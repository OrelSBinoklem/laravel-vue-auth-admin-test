<?php

namespace App\Orel\Admin\Menu\ItemsTypes;

use App\Helpers\Contracts\AdminMenuItemType;

use Illuminate\Support\Facades\Validator;
use App\MenuItems;

class Casual extends AdminMenuItemType {
    public function validatorCreateItem(array $data) {
        $data['is_router'] = $data['is_router'] && $data['is_router'] == 'true' ? 1 : 0;
        $rules = [];

        $rules['is_router'] = 'required|integer|between:0,1';

        if((boolean) $data['is_router']) {
            $rules['path'] = 'regex:/(^[a-zA-Z\d\-\_\.]+$)/u';
        } else {
            $rules['path'] = 'url';
        }

        return Validator::make($data, $rules);
    }

    public function validatorUpdateItem(array $data) {
        $data['is_router'] = $data['is_router'] && $data['is_router'] == 'true' ? 1 : 0;
        $rules = [];

        $rules['is_router'] = 'required|integer|between:0,1';

        if((boolean) $data['is_router']) {
            $rules['path'] = 'regex:/(^[a-zA-Z\d\-\_\.]+$)/u';
        } else {
            $rules['path'] = 'url';
        }

        return Validator::make($data, $rules);
    }

    public function setMetaFields(MenuItems $model, array $data) {
        $model->setMeta([
            'is_router' => $data['is_router'] && $data['is_router'] == 'true' ? 1 : 0,
            'path' => $data['path'],
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
            'is_router' => $model->getMeta('is_router') ? TRUE : FALSE
        ];
        if($model->getMeta('is_router')) {
            $data['router'] = ['name' => $model->getMeta('path')];
        } else {
            $data['path'] = $model->getMeta('path');
        }
        return $data;
    }
}