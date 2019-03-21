<?php

namespace App\Orel\Admin\Menu\ItemsTypes;

use App\Helpers\Contracts\AdminMenuItemType;

use Illuminate\Support\Facades\Validator;
use App\MenuItems;

class Casual extends AdminMenuItemType {
    public function validatorCreateItem(array $data) {
        $data['is_router'] = $data['is_router'] ? 1 : 0;
        $rules = [];

        $rules['is_router'] = 'required|integer|between:0,1';

        if((boolean) $data['is_router']) {
            $rules['path'] = 'alpha_dash';
        } else {
            $rules['path'] = 'url';
        }

        return Validator::make($data, $rules);
    }

    public function validatorUpdateItem(array $data) {
        $data['is_router'] = $data['is_router'] ? 1 : 0;
        $rules = [];

        $rules['is_router'] = 'required|integer|between:0,1';

        if((boolean) $data['is_router']) {
            $rules['path'] = 'alpha_dash';
        } else {
            $rules['path'] = 'url';
        }

        return Validator::make($data, $rules);
    }

    public function setMetaFields(MenuItems $model, array $data) {
        $model->setMeta('is_router', $data['is_router'] ? 1 : 0);
    }
}