<?php

namespace App\Orel\Content\Widgets;

use App\Helpers\Contracts\WidgetsTypesRules;

use Illuminate\Support\Facades\Validator;

class CodeEditor extends WidgetsTypesRules {
    public function getWidgetRules(array $data) {
        return [
            //todo-orel зделать репласер для полей которые передаються как параметры чтоб к ним добавлялся префикс $prefixDataForm или валидировать отдельно и перекидывать ошибки на глобальный уровень
            'props.variant' => 'required|in:jade,html,xml,svg,css,sass,scss,less,stylus,javascript,typescript,coffee,json,yaml,php',
            'props.min_lines' => 'required|integer|between:1,999',
            'props.max_lines' => 'required|integer|between:1,999',
            'props.code' => 'required|string'
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