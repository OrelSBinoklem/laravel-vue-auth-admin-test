<?php

namespace App\Orel\Content\Widgets;

use App\Helpers\Contracts\WidgetsTypesRules;

use Illuminate\Support\Facades\Validator;

class Alert extends WidgetsTypesRules {
    public function getWidgetRules(array $data) {
        //todo-crutch
        $data['props']['navHash']['group'] = $data['props']['navHash']['group'] === "null" ? null : $data['props']['navHash']['group'];
        return [
            'props.variant' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',

            'props.html' => 'required|string',

            'props.navHash' => 'array',
            'props.navHash.title' => 'nullable|string|max:255',
            'props.navHash.slug' => 'nullable|alpha_dash|max:255',
            'props.navHash.group' => 'nullable|alpha_dash|max:255',
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