<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class UserPolicy
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
		return $user->can('EDIT_USERS');
    }
    
    public function edit(User $user)
    {
		return $user->can('EDIT_USERS');
    }
}
