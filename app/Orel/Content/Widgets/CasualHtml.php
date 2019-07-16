<?php

namespace App\Orel\Content\Widgets;

use App\Helpers\Contracts\WidgetsTypesRules;

use Illuminate\Support\Facades\Validator;

class CasualHtml extends WidgetsTypesRules {
    public function getWidgetRules(array $data) {
        return [
            'props.html' => 'required|string|max:4096'
        ];
    }

    public function getPositionsRules(array $data) {
        return [

        ];
    }
}