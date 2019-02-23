<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return $user->can('EDIT_PERMISSIONS');
    }

    public function edit(User $user)
    {
        return $user->can('EDIT_PERMISSIONS');
    }
    
    public function change(User $user) {
    	
    	//EDIT_PERMISSIONS
		return $user->canDo('EDIT_PERMISSIONS');
	}
}
