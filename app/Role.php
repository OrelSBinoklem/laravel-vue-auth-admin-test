<?php

namespace App;

use App\Helpers\Contracts\BelongsToUsers;

class Role extends Model implements BelongsToUsers
{
    //

    protected $fillable = [
        'name', 'immunity',
    ];
    
    public function users() {
		return $this->belongsToMany('App\User','role_user');
	}
	
	public function permissions() {
		return $this->belongsToMany('App\Permission','permission_role');
	}
	
	
	public function hasPermission($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $permissionName) {
                $hasPermission = $this->hasPermission($permissionName);

                if ($hasPermission && !$require) {
                    return true;
                } elseif (!$hasPermission && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->permissions as $permission) {
                if ($permission->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function savePermissions($inputPermissions) {
		
		if(!empty($inputPermissions)) {
			$this->permissions()->sync($inputPermissions);
		}
		else {
			$this->permissions()->detach();
		}
		
		return TRUE;
	}

    public function BelongsToUsers() {
        return $this->users;
    }
}
