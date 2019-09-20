<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Menu;

class MenuDeleted
{
    use SerializesModels;

    public $item;

    public function __construct(Menu $item)
    {
        $this->item = $item;
    }

    public function getModel(): Menu {
        return $this->item;
    }
}
