<?php

namespace App;

class Menu extends Model
{
    protected $fillable = [
        'name', 'slug',
    ];
    
    public function menuItems() {
		return $this->hasMany('App\MenuItems', 'menu_id', 'id');
	}
}
