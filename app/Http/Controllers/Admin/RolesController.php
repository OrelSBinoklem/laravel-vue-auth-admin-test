<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Repositories\UsersRepository;
use App\Repositories\RolesRepository;

use Illuminate\Support\Facades\Gate;
use App\User;

class RolesController extends AdminController
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
        return $this->rol_rep->getTableData();
    }

    public function index()
    {
        return $this->rol_rep->get();
    }

    public function store(UserRequest $request)
    {
		return $this->rol_rep->add($request);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, User $user)
    {
		return $this->rol_rep->update($request,$user);
    }

    public function destroy(User $user)
    {
        return $this->rol_rep->delete($user);
    }
}
