<?php

namespace App;

use App\Events\ContentJSPluginDeleted;
use App\Events\ContentJSPluginSaved;
use Illuminate\Database\Eloquent\Model;
use Kodeine\Metable\Metable;

class ContentJSPlugin extends Model
{
    use Metable;

    protected $dispatchesEvents = [
        'saved' => ContentJSPluginSaved::class,
        'deleted' => ContentJSPluginDeleted::class,
    ];
    //
    protected $guarded = ['id', 'viewed', 'created_at', 'updated_at'];

    protected function getMetaKeyName()
    {
        return 'plugin_id'; // The parent foreign key
    }

    public function categories() {
        return $this->morphToMany('App\Category', 'categoryable');
    }

    public function tags() {
        return $this->morphToMany('App\Tag', 'tagable');
    }

    //todo-orel временное решение "какого хера грузяться metas"
    public function toArray()
    {
        if (isset($this->relations['metas'])) {
            return array_merge(parent::toArray(), [
                'meta_data' => $this->getMeta()->toArray(),
            ]);
        }

        return parent::toArray();
    }
}
