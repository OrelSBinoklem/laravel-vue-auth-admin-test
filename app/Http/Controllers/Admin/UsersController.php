<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Repositories\UsersRepository;
use App\Repositories\RolesRepository;

use Illuminate\Support\Facades\Gate;
use App\User;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Events\Registered;
use App\Events\ChangeEmail;

class UsersController extends AdminController
{
    
    protected $us_rep;
    protected $rol_rep;


    public function __construct(RolesRepository $rol_rep, UsersRepository $us_rep) {
        parent::__construct();
        
        /*if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }*/

        $this->us_rep = $us_rep;
        $this->rol_rep = $rol_rep;
    }

    public function getTableData()
    {
        return $this->us_rep->getTableData();
    }

    public function index()
    {
        return $this->us_rep->get();
    }

    public function store(Request $request)
    {
		$user = $this->us_rep->add($request);

        event(new Registered($user));

        return ['status' => 'Пользователь добавлен'];
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, User $user)
    {
		$this->us_rep->update($request, $user);

        if(
            $user instanceof MustVerifyEmail &&
            ! $user->isOAuth() &&
            $request->has('email') &&
            $request->input('email') !== $user->email
        ) {
            event(new ChangeEmail($user));
        }

        return ['status' => 'Пользователь изменен'];
    }

    public function destroy(User $user)
    {
        return $this->us_rep->delete($user);
    }
}
