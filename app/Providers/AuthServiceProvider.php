<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\User' => 'App\Policies\UserPolicy',
        'App\Role' => 'App\Policies\RolePolicy',
        'App\Permission' => 'App\Policies\PermissionPolicy',
        'App\Menu' => 'App\Policies\MenuPolicy',
        'App\MenuItems' => 'App\Policies\MenuItemPolicy',
        'App\ContentJSPlugin' => 'App\Policies\ContentJSPluginPolicy',
        'App\Category' => 'App\Policies\CategoryPolicy',
        'App\Tag' => 'App\Policies\TagPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('EDIT_USERS', function ($user) {
            return $user->canDo('EDIT_USERS', FALSE);
        });

        $gate->define('EDIT_PERMISSIONS', function ($user) {
            return $user->canDo('EDIT_PERMISSIONS', FALSE);
        });

        $gate->define('EDIT_MENU', function ($user) {
            return $user->canDo('EDIT_MENU', FALSE);
        });

        $gate->define('EDIT_JS_PLUGIN', function ($user) {
            return $user->canDo('EDIT_JS_PLUGIN', FALSE);
        });

        $gate->define('EDIT_JS_PLUGIN_ONLY_MY', function ($user) {
            return $user->canDo('EDIT_JS_PLUGIN_ONLY_MY', FALSE);
        });

        $gate->define('EDIT_TAXONOMY', function ($user) {
            return $user->canDo('EDIT_TAXONOMY', FALSE);
        });

        $gate->define('EDIT_CATEGORIES', function ($user) {
            return $user->canDo('EDIT_CATEGORIES', FALSE);
        });

        $gate->define('EDIT_TAGS', function ($user) {
            return $user->canDo('EDIT_TAGS', FALSE);
        });

        $gate->define('EDIT_TAXONOMY_ONLY_MY', function ($user) {
            return $user->canDo('EDIT_TAXONOMY_ONLY_MY', FALSE);
        });

        $gate->define('EDIT_CATEGORIES_ONLY_MY', function ($user) {
            return $user->canDo('EDIT_CATEGORIES_ONLY_MY', FALSE);
        });

        $gate->define('EDIT_TAGS_ONLY_MY', function ($user) {
            return $user->canDo('EDIT_TAGS_ONLY_MY', FALSE);
        });
    }
}
