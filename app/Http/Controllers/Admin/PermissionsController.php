<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\PermissionsRepository;

use Gate;

use App\Permission;

class PermissionsController extends AdminController
{
    
    protected $per_rep;

    public function __construct(PermissionsRepository $perm_rep) {
        parent::__construct();

        /*if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }*/

        $this->perm_rep = $perm_rep;
    }

    public function getTableData()
    {
        return $this->perm_rep->getTableData();
    }

    public function store(Request $request)
    {
        $immunityMaxRolesUser = Auth::user()->roles->max('immunity');

        //исключение - $permission->name == 'EDIT_PERMISSIONS' && Auth::user()->isSuperAdmin()
        if(Gate::denies('EDIT_PERMISSIONS')) {
            abort(403, 'Недостаточно прав');
        }

        return $this->perm_rep->add($request);
    }

    public function update(Request $request, Permission $permission)
    {
        if(Gate::denies('EDIT_PERMISSIONS')) {
            abort(403, 'Недостаточно прав');
        }

        if(!Auth::user()->isSuperAdmin()) {
            abort(403, 'Редактировать права может только Superadmin');
        }

        if($permission->name == "EDIT_PERMISSIONS") {
            abort(403, 'Право EDIT_PERMISSIONS нельзя редактировать!');
        }

        return $this->perm_rep->update($request, $permission);
    }

    public function destroy(Permission $permission)
    {
        if(Gate::denies('EDIT_PERMISSIONS')) {
            abort(403, 'Недостаточно прав');
        }

        if(!Auth::user()->isSuperAdmin()) {
            abort(403, 'Удалять права может только Superadmin');
        }

        if($permission->name == "EDIT_PERMISSIONS") {
            abort(403, 'Право EDIT_PERMISSIONS нельзя удалять!');
        }

        return $this->perm_rep->delete($permission);
    }
}
