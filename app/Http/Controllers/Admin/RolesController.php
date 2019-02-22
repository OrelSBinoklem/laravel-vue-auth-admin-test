<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Repositories\UsersRepository;
use App\Repositories\RolesRepository;
use App\Repositories\PermissionsRepository;

use Illuminate\Support\Facades\Gate;
use App\User;
use App\Role;
use App\Permission;

use Auth;

class RolesController extends AdminController
{
    
    protected $us_rep;
    protected $rol_rep;
    protected $perm_rep;


    public function __construct(RolesRepository $rol_rep, UsersRepository $us_rep, PermissionsRepository $perm_rep) {
        parent::__construct();
        
        /*if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }*/

        $this->us_rep = $us_rep;
        $this->rol_rep = $rol_rep;
        $this->perm_rep = $perm_rep;
    }

    public function getTableData()
    {
        return $this->rol_rep->getTableData();
    }

    public function getPermissionRoleTableData()
    {
        $roles = $this->rol_rep->getAll('permissions');
        $permissions = $this->perm_rep->getAll('');
        return response()->json(
            [
                'roles' => $roles,
                'permissions' => $permissions
            ]
        )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');

    }

    public function changePermissionRole(Request $request)
    {
        $immunityMaxRolesUser = Auth::user()->roles->max('immunity');
        $role = Role::findOrFail($request->input('role_id'));
        $permission = Permission::findOrFail($request->input('permission_id'));
        $immunityRole = $role->immunity;

        //исключение - $permission->name == 'EDIT_PERMISSIONS' && Auth::user()->isSuperAdmin()
        if(Gate::denies('EDIT_PERMISSIONS') && !($permission->name == 'EDIT_PERMISSIONS' && Auth::user()->isSuperAdmin())) {
            abort(403, 'Недостаточно прав редактировать права');
        }

        if ($immunityMaxRolesUser < $immunityRole) {
            abort(403, 'Недостаточно иммунитета редактировать роль: ' . $role->name);
        }

        if($permission->name == 'EDIT_PERMISSIONS' && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Право редактировать право на выдачу прав имеет только Superadmin');
        }

        if($request->input('attach')) {
            $role->permissions()->attach($permission);
            return ['status' => 'Роли:' . $role->name . ' выдано право:' . $permission->name];
        } else {
            $role->permissions()->detach($permission);
            return ['status' => 'У роли:' . $role->name . ' изъято право:' . $permission->name];
        }
    }

    public function index()
    {
        return $this->rol_rep->get();
    }

    public function store(Request $request)
    {
        $immunityMaxRolesUser = Auth::user()->roles->max('immunity');

        //исключение - $permission->name == 'EDIT_PERMISSIONS' && Auth::user()->isSuperAdmin()
        if(Gate::denies('EDIT_PERMISSIONS')) {
            abort(403, 'Недостаточно прав');
        }

        if ($immunityMaxRolesUser < (int)$request->input("immunity")) {
            abort(403, 'Роль неможет иметь иммунитет выше чем ваш: ' . $immunityMaxRolesUser);
        }

        return $this->rol_rep->add($request);
    }

    public function update(Request $request, Role $role)
    {
        $immunityMaxRolesUser = Auth::user()->roles->max('immunity');

        if(Gate::denies('EDIT_PERMISSIONS')) {
            abort(403, 'Недостаточно прав');
        }

        //Иммунитет должен быть выше исключение - Auth::user()->isSuperAdmin() - иммунитет может быть равен
        if ($immunityMaxRolesUser <= $role->immunity && !($immunityMaxRolesUser == $role->immunity && Auth::user()->isSuperAdmin())) {
            abort(403, 'Роль нельзя редактировать если её иммуниетет выше или равен вашему, исключение Superadmin (его роль может быть равна). Ваш иммунитет: ' . $immunityMaxRolesUser);
        }

        //Запрет на выдачу иммунитета выше вашего
        if ($request->input('immunity') > $immunityMaxRolesUser && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Нельзя устанавливать иммунитет выше вашего, исключение Superadmin. Ваш иммунитет: ' . $immunityMaxRolesUser);
        }

		return $this->rol_rep->update($request, $role);
    }

    public function destroy(Role $role)
    {
        $immunityMaxRolesUser = Auth::user()->roles->max('immunity');

        if(Gate::denies('EDIT_PERMISSIONS')) {
            abort(403, 'Недостаточно прав');
        }

        if(Auth::user()->isRoleSuperAdmin($role)) {
            abort(403, 'Роль Superadmin нельзя удалять!');
        }

        if ($immunityMaxRolesUser <= $role->immunity) {
            abort(403, 'Роль нельзя удалять если её иммуниетет выше или равен вашему. Ваш иммунитет: ' . $immunityMaxRolesUser);
        }

        return $this->rol_rep->delete($role);
    }
}
