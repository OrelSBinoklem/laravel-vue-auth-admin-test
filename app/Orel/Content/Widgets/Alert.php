<?php

namespace App\Orel\Content\Widgets;

use App\Helpers\Contracts\WidgetsTypesRules;

use Illuminate\Support\Facades\Validator;

class Alert extends WidgetsTypesRules{
    public function getWidgetRules(array $data) {
        return [
            'props.variant' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',

            'text' => 'required|string'
        ];
    }

    public function getPositionsRules(array $data) {
        return [
            'slot' => [
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
            ]
        ];
    }
}