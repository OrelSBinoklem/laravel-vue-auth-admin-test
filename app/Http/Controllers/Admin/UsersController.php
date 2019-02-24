<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Repositories\UsersRepository;
use App\Repositories\RolesRepository;

use Illuminate\Support\Facades\Gate;
use App\User;
use App\Role;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Events\Registered;
use App\Events\ChangeEmail;

use Auth;

class UsersController extends AdminController
{
    protected $us_rep;
    protected $rol_rep;

    public function __construct(RolesRepository $rol_rep, UsersRepository $us_rep) {
        parent::__construct();

        /*if (Gate::denies('EDIT_USERS')) {
            $this->middleware(function ($request, $next) {
                //return $next($request);
                return response(['error' => 'Нет права редактировать юзеров'], 200);
            });
            //abort(403);
            //return ['error' => 'Нет права редактировать юзеров'];
        }*/

        $this->us_rep = $us_rep;
        $this->rol_rep = $rol_rep;
    }

    public function getTableData()
    {
        return $this->us_rep->getTableData();
    }

    public function store(Request $request)
    {
        if(Gate::denies('EDIT_USERS')) {
            abort(403, 'Недостаточно прав создавать юзеров');
        }

        $immunityAuthUser = Auth::user()->roles->max('immunity');
        $immunityNewUser= Role::whereIn('id', $request->input('roles_ids'))->get()->max('immunity');

        if($immunityAuthUser < $immunityNewUser) {
            abort(403, 'Нельзя создавать юзера с более высоким иммунитетом чем ваш. Ваш иммунитет: ' . $immunityAuthUser . ' Нового юзера: ' . $immunityNewUser);
        }

		$user = $this->us_rep->add($request);

        event(new Registered($user));

        return ['status' => 'Пользователь добавлен'];
    }

    public function update(Request $request, User $user)
    {
        if(Gate::denies('EDIT_USERS')) {
            abort(403, 'Недостаточно прав редактировать юзера');
        }

        $immunityAuthUser = Auth::user()->roles->max('immunity');
        $immunityUpdateUser= $user->roles->max('immunity');
        $immunityNewRoles= Role::whereIn('id', $request->input('roles_ids'))->get()->max('immunity');

        if ($immunityAuthUser <= $immunityUpdateUser) {
            abort(403, 'Ваш иммунитет должен быть выше редактируемого юзера. Ваш иммунитет: ' . $immunityAuthUser . ' Редактируемого юзера: ' . $immunityUpdateUser);
        }

        if($immunityAuthUser < $immunityNewRoles) {
            abort(403, 'Нельзя выдавать роли с большим иммунитетом чем ваш. Ваш иммунитет: ' . $immunityAuthUser . ' Выданных ролей: ' . $immunityNewRoles);
        }

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
        if (!Auth::user()->immunityIsHigherForAccessToModel(['EDIT_USERS'], $user)) {
            abort(403, 'Недостаточно иммунитета удалить юзера');
        }
        return $this->us_rep->delete($user);
    }

    public function groupBan(Request $request) {
        $users = User::whereIn('id', $request->input('ids'))->get();

        if(!$users->count()) {
            abort(403, 'Вы пытаетесь редактировать 0 юзеров');
        }

        if(Gate::denies('EDIT_USERS')) {
            abort(403, 'Недостаточно прав редактировать юзеров');
        }

        if (!Auth::user()->immunityIsHigherForPermission(['EDIT_USERS'], $users)) {
            abort(403, 'Недостаточно иммунитета редактировать юзеров');
        }

        $this->us_rep->banGroup($users, $request->input('expired_at'));

        if($request->input('expired_at') == false) {
            //ДОБАВИТЬ НЕСКОЛЬКО ВАРИАНТОВ ОКОНЧАНИЙ СЛОВАМ ПРИ РАЗНЫХ ЧИСЛАХ
            return ['status' => '(' . $users->count() . ') пользователей разбанено'];
        } else {
            return ['status' => '(' . $users->count() . ') пользователям бан установлен'];
        }
    }

    public function groupDelete(Request $request) {
        $users = User::whereIn('id', $request->input('ids'))->get();

        if(!$users->count()) {
            abort(403, 'Вы пытаетесь удалить 0 юзеров');
        }

        if(Gate::denies('EDIT_USERS')) {
            abort(403, 'Недостаточно прав удалять юзеров');
        }

        if (!Auth::user()->immunityIsHigherForPermission(['EDIT_USERS'], $users)) {
            abort(403, 'Недостаточно иммунитета удалять юзеров');
        }

        $this->us_rep->deleteGroup($users);

        return ['status' => '(' . $users->count() . ') пользователей удалено'];
    }
}
