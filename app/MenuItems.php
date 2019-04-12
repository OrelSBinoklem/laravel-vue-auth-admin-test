<?php

namespace App;

use Kodeine\Metable\Metable;
use Spatie\Translatable\HasTranslations;

class MenuItems extends Model
{
    use Metable;
    use HasTranslations;

    public $translatable = ['name'];

    protected $guarded = [];

    protected function getMetaKeyName()
    {
        return 'menu_item_id'; // The parent foreign key
    }
}
