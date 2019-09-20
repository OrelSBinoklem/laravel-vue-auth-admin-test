<?php

namespace App;

use App\Events\MenuDeleted;
use App\Events\MenuSaved;

class Menu extends Model
{
    protected $dispatchesEvents = [
        'saved' => MenuSaved::class,
        'deleted' => MenuDeleted::class,
    ];

    protected $fillable = [
        'name', 'slug',
    ];
    
    public function menuItems() {
		return $this->hasMany('App\MenuItems', 'menu_id', 'id');
	}
}
