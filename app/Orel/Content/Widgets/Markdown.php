<?php

namespace App\Orel\Content\Widgets;

use App\Helpers\Contracts\WidgetsTypesRules;

use Illuminate\Support\Facades\Validator;

class Markdown extends WidgetsTypesRules {
    public function getWidgetRules(array $data) {
        return [
            //todo-orel зделать репласер для полей которые передаються как параметры чтоб к ним добавлялся префикс $prefixDataForm или валидировать отдельно и перекидывать ошибки на глобальный уровень
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