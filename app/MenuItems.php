<?php

namespace App;

use Kodeine\Metable\Metable;

class MenuItems extends Model
{
    use Metable;

    protected $guarded = [];

    protected function getMetaKeyName()
    {
        return 'menu_item_id'; // The parent foreign key
    }
}
