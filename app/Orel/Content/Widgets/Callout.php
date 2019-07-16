<?php

namespace App\Orel\Content\Widgets;

use App\Helpers\Contracts\WidgetsTypesRules;

use Illuminate\Support\Facades\Validator;

class Callout extends WidgetsTypesRules {
    public function getWidgetRules(array $data) {
        return [
            'props.variant' => 'required|in:danger,warning,info',
            'props.heading' => 'string',
            'props.html' => 'required|string'
        ];
    }

    public function getPositionsRules(array $data) {
        return [
            /*'default' => [
                'rules' => [
                    [
                        'name' => [
                            'regex:/^alert2$/gmi'
                        ],
                        'count' => '*',
                        'not' => [
                            'props' => [
                                'variant' => 'regex:/^light|dark$/gimu'
                            ]
                        ]
                    ],
                    [
                        'name' => 'regex:/^button$/gimu'
                    ]
                ]
            ]*/
        ];
    }
}