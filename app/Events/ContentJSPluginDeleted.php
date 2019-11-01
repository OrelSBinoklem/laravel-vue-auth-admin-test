<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\ContentJSPlugin;

class ContentJSPluginDeleted
{
    use SerializesModels;

    public $item;

    public function __construct(ContentJSPlugin $item)
    {
        $this->item = $item;
    }

    public function getModel(): ContentJSPlugin {
        return $this->item;
    }
}
