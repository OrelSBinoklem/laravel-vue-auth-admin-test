<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kodeine\Metable\Metable;

class ContentJSPlugin extends Model
{
    use Metable;
    //
    protected $guarded = ['id', 'viewed', 'created_at', 'updated_at'];

    protected function getMetaKeyName()
    {
        return 'plugin_id'; // The parent foreign key
    }
}
