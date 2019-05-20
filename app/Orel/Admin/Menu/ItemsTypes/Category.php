<?php

namespace App\Orel\Admin\Menu\ItemsTypes;

use App\Helpers\Contracts\AdminMenuItemType;

use Illuminate\Support\Facades\Validator;
use App\MenuItems;

class Category extends AdminMenuItemType {
    public function validatorCreateItem(array $data) {
        $rules = [];

        $rules['category_slug'] = 'required|alpha_dash|max:255';

        return Validator::make($data, $rules);
    }

    public function validatorUpdateItem(array $data) {
        $rules = [];

        $rules['category_slug'] = 'required|alpha_dash|max:255';

        return Validator::make($data, $rules);
    }

    public function setMetaFields(MenuItems $model, array $data) {
        $model->setMeta([
            'category_slug' => $data['category_slug']
        ]);
    }

    public function getPublicDataItem(MenuItems $model) {
        $data = [
            'id' => $model->id,
            'slug' => $model->slug,
            'name' => $model->name,
            'order' => $model->order,
            'parent_id' => $model->parent_id,
            'type_id' => $model->type_id,
            'meta_data' => $model->getMeta()->toArray(),
            'is_router' => TRUE
        ];
        $data['router'] = [
            'name' => 'category',
            'params' => [
                'slug' => $model->getMeta('category_slug')
            ]
        ];
        return $data;
    }
}