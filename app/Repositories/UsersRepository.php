<?php

namespace App\Repositories;

use App\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Contracts\Auth\MustVerifyEmail;


class UsersRepository extends VueTableRepository
{
	protected $with = 'roles';
    
	public function __construct(User $user) {
		$this->model  = $user;
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
		
		return $user;
	}
	
	
	public function update($request, $user) {
		if (Gate::denies('edit',$this->model)) {
            abort(403);
        }
		
		$data = $request->all();

        $this->validatorUpdate($data, $user)->validate();
		
		if(isset($data['password'])) {
			$data['password'] = Hash::make($data['password']);
		}

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
		
		if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $t_name = $user->name;

        $user->oauthProviders()->delete();

		$user->roles()->detach();
		
		if($user->delete()) {
			return ['status' => 'Пользователь ' . $t_name . ' удален'];
		}
	}

    protected function validatorUpdate(array $data, User $user)
    {
        //In App\Http\Kernel.php: \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class
        //если пустая строка в поле то оно превращаеться в null
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];

        if(!empty($data['password'])) {
            $rules['password'] = 'required|string|min:6|confirmed';
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