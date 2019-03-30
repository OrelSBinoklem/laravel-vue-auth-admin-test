<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\ContentJSPlugin;

class ContentJSPluginPolicy
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
		return $user->can('EDIT_JS_PLUGIN') || $user->can('EDIT_JS_PLUGIN_ONLY_MY');
    }
    
    public function edit(User $user, ContentJSPlugin $plugin)
    {
        $perm_all = $user->can('EDIT_JS_PLUGIN');
		if(!$perm_all && $user->can('EDIT_JS_PLUGIN_ONLY_MY')) {
            return $user->id === $plugin->created_by;
        }
        return $perm_all;
    }
}
