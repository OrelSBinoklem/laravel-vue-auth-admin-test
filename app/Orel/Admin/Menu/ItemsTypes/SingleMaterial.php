<?php

namespace App\Orel\Admin\Menu\ItemsTypes;

use App\Helpers\Contracts\AdminMenuItemType;

use Illuminate\Support\Facades\Validator;
use App\MenuItems;

class SingleMaterial extends AdminMenuItemType {
    public function validatorCreateItem(array $data) {
        $rules = [];

        $rules['content_type'] = 'required|alpha_dash|max:255';
        $rules['material_slug'] = 'required|alpha_dash|max:255';

        return Validator::make($data, $rules);
    }

    public function validatorUpdateItem(array $data) {
        $rules = [];

        $rules['content_type'] = 'required|alpha_dash|max:255';
        $rules['material_slug'] = 'required|alpha_dash|max:255';

        return Validator::make($data, $rules);
    }

    public function setMetaFields(MenuItems $model, array $data) {
        $model->setMeta([
            'content_type' => $data['content_type'],
            'material_slug' => $data['material_slug']
        ]);
    }

    public function getPublicDataItem(MenuItems $model) {
        $data = [
            'id' => $model->id,
            'slug' => $model->slug,
            'name' => $model->name,
            'icon' => $model->icon,
            'class' => $model->class,
            'order' => $model->order,
            'parent_id' => $model->parent_id,
            'type_id' => $model->type_id,
            'meta_data' => $model->getMeta()->toArray(),
            'is_router' => TRUE
        ];
        $data['router'] = [
            'name' => 'content.' . $model->getMeta('content_type'),
            'params' => [
                'type_slug' => $model->getMeta('content_type'),
                'slug' => $model->getMeta('material_slug')
            ]
        ];
        return $data;
    }
}