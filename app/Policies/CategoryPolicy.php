<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Category;

class CategoryPolicy
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
		return $user->can('EDIT_TAXONOMY')
            || $user->can('EDIT_CATEGORIES')
            || $user->can('EDIT_TAXONOMY_ONLY_MY')
            || $user->can('EDIT_CATEGORIES_ONLY_MY');
    }
    
    public function edit(User $user, Category $tax)
    {
        $perm_all = $user->can('EDIT_TAXONOMY') || $user->can('EDIT_CATEGORIES');
		if(!$perm_all && ($user->can('EDIT_TAXONOMY_ONLY_MY') || $user->can('EDIT_CATEGORIES_ONLY_MY'))) {
            return $user->id === $tax->created_by;
        }
        return $perm_all;
    }
}
