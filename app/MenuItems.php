<?php

namespace App;

use Kodeine\Metable\Metable;
use Spatie\Translatable\HasTranslations;

use App\Events\MenuItemSaved;
use App\Events\MenuItemDeleted;

class MenuItems extends Model
{
    use Metable;
    use HasTranslations;

    protected $dispatchesEvents = [
        'saved' => MenuItemSaved::class,
        'deleted' => MenuItemDeleted::class,
    ];

    public $translatable = ['name'];

    protected $guarded = [];

    protected function getMetaKeyName()
    {
        return 'menu_item_id'; // The parent foreign key
    }
}
