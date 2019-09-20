<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\MenuItems;

class MenuItemDeleted
{
    use SerializesModels;

    public $item;

    public function __construct(MenuItems $item)
    {
        $this->item = $item;
    }

    public function getModel(): MenuItems {
        return $this->item;
    }
}
