<?php

namespace App\Repositories;

use Gate;

class BaseContentRepository extends VueTableRepository {
    protected $public_columns = ['id', 'title', 'slug', 'description_short', 'published', 'viewed', 'created_at', 'updated_at'];

    public function __construct() {

    }

    public function getPublicWhereInSlugs(array $slugs) {
        //todo-orel какого хера грузяться metas - временное решение https://github.com/kodeine/laravel-meta/issues/17 вставил в модель метод toArray

        return $this->model->newQuery()
            ->select($this->public_columns)
            ->whereIn('slug', $slugs)
            ->get()
            ->keyBy('slug');
    }

    public function shortWhereInSlugsByTax(array $slugs) {
        //todo-orel какого хера грузяться metas - временное решение https://github.com/kodeine/laravel-meta/issues/17 вставил в модель метод toArray

        return $this->model->newQuery()
            ->select($this->public_columns)
            ->whereIn('slug', $slugs)
            ->with(['categories', 'tags'])
            ->get()
            ->keyBy('slug');
    }
}

?>