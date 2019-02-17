<?php

namespace App;

use App\Helpers\Contracts\BelongsToUsers;

class Permission extends Model implements BelongsToUsers
{
    //
    
    public function roles() {
		return $this->belongsToMany('App\Role','permission_role');
	}

    public function BelongsToUsers() {
        return $this->roles->load("users")->pluck('users')->collapse()->unique('id');
    }
}
