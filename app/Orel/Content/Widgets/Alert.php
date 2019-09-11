<?php

namespace App\Orel\Content\Widgets;

use App\Helpers\Contracts\WidgetsTypesRules;

use Illuminate\Support\Facades\Validator;

class Alert extends WidgetsTypesRules {
    public function getWidgetRules(array $data) {
        return [
            'props.variant' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',

            'props.html' => 'required|string',

            'props.navHash' => 'array',
            'props.navHash.title' => 'string|max:255',
            'props.navHash.slug' => 'alpha_dash|max:255',
            'props.navHash.group' => 'alpha_dash|max:255',
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