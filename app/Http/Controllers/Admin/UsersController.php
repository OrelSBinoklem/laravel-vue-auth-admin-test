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
        debug(Auth::user()->isSuperAdmin());

        return $this->us_rep->getTableData();
    }

    public function store(Request $request)
    {
		$user = $this->us_rep->add($request);

        event(new Registered($user));

        return ['status' => 'Пользователь добавлен'];
    }

    public function update(Request $request, User $user)
    {
        if(Gate::denies('EDIT_USERS')) {
            return ['error' => 'Недостаточно прав редактировать юзера'];
        }
        if (!Auth::user()->immunityIsHigherForAccessToModel(['EDIT_USERS'], $user)) {
            //abort(403);
            return ['error' => 'Недостаточно иммунитета редактировать юзера'];
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
            //abort(403);
            return ['error' => 'Недостаточно иммунитета удалить юзера'];
        }
        return $this->us_rep->delete($user);
    }

    public function groupBan(Request $request) {
        $users = User::whereIn('id', $request->input('ids'))->get();

        if(!$users->count()) {
            return ['error' => 'Вы пытаетесь редактировать 0 юзеров'];
        }

        if(Gate::denies('EDIT_USERS')) {
            return ['error' => 'Недостаточно прав редактировать юзеров'];
        }

        if (!Auth::user()->immunityIsHigherForPermission(['EDIT_USERS'], $users)) {
            return ['error' => 'Недостаточно иммунитета редактировать юзеров'];
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
            return ['error' => 'Вы пытаетесь удалить 0 юзеров'];
        }

        if(Gate::denies('EDIT_USERS')) {
            return ['error' => 'Недостаточно прав удалять юзеров'];
        }

        if (!Auth::user()->immunityIsHigherForPermission(['EDIT_USERS'], $users)) {
            return ['error' => 'Недостаточно иммунитета удалять юзеров'];
        }

        $this->us_rep->deleteGroup($users);

        return ['status' => '(' . $users->count() . ') пользователей удалено'];
    }
}
