<?php

namespace App\Orel\Menus\PlainPluginsMegaMenu;

use App\Menu;

trait Repository
{
    public function get_data_materials_for_ppmm(array $slugs) {
        $res = $this->model->newQuery()
            ->select($this->public_columns)
            ->whereIn('slug', $slugs)
            ->with(['categories', 'tags', 'metas'])
            ->get()
            ->keyBy('slug');

        debug($res);

        return $res;
    }
}