<?php

namespace App\Repositories;

use App\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Cog\Contracts\Ban\Bannable as BannableContract;

use Carbon\Carbon;


class UsersRepository extends VueTableRepository
{
	protected $with = ['roles', 'bans'];
    protected $fieldsFilter = ['name', 'email'];
    
	public function __construct(User $user) {
		$this->model  = $user;
	}

	public function getTableData() {
	    $data = parent::getTableData();

        return response()->json(
            [
                'pagination' => $data,
                'current_date' => Carbon::now()->format('Y-m-d\TH:iP')
            ]
        )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function add($request) {
		if (Gate::denies('create',$this->model)) {
            abort(403);
        }
		
		$data = $request->all();

        $this->validatorCreate($data)->validate();
		
		$user = $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
		
		if($user) {
			$user->roles()->sync($data['roles_ids']);
		}
	}
	
	
	public function update($request, $user) {
		/*if (Gate::denies('edit',$this->model)) {
            abort(403);
        }*/
		
		$data = $request->all();

        $this->validatorUpdate($data, $user)->validate();
		
		if(isset($data['password'])) {
			$data['password'] = Hash::make($data['password']);
		}

        $user->banSync($data['bans_expired_at']);

        if (
            $user instanceof MustVerifyEmail &&
            ! $user->isOAuth() &&
            isset($data['email']) &&
            $data['email'] !== $user->email
        ) {
            $data['email_verified_at'] = null;
        }
		
		$user->fill($data)->update();
		$user->roles()->sync($data['roles_ids']);
	}
	
	public function delete($user) {
		
		/*if (Gate::denies('edit',$this->model)) {
            abort(403);
        }*/

        $t_name = $user->name;

        $user->oauthProviders()->delete();

		$user->roles()->detach();

        debug($user->bans());
		if($user instanceof BannableContract) {
		    //НЕРАБОТАЕТ
            $user->bans()->delete();
        }
        debug($user->bans());

		if($user->delete()) {
			return ['status' => 'Пользователь ' . $t_name . ' удален'];
		}
	}

	public function banGroup($users, $ban) {
        $users->each(function ($user) use ($ban) {
            $user->banSync($ban);
        });
    }

    public function deleteGroup($users) {
        $users->each(function ($user) {
            $user->oauthProviders()->delete();

            $user->roles()->detach();

            if($user instanceof BannableContract) {
                $user->bans()->delete();
            }

            $user->delete();
        });
    }

    protected function validatorUpdate(array $data, User $user)
    {
        //In App\Http\Kernel.php: \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class
        //если пустая строка в поле то оно превращаеться в null
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bans_expired_at' => 'required'
        ];

        if(!empty($data['password'])) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        if(!is_bool($data['bans_expired_at'])) {
            $rules['bans_expired_at'] = 'required|date';
        }

        return Validator::make($data, $rules);
    }

    protected function validatorCreate(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
}