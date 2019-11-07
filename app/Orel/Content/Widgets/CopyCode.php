<?php

namespace App\Orel\Content\Widgets;

use App\Helpers\Contracts\WidgetsTypesRules;

use Illuminate\Support\Facades\Validator;

class CopyCode extends WidgetsTypesRules {
    public function getWidgetRules(array $data) {
        //todo-crutch
        $data['props']['navHash']['group'] = $data['props']['navHash']['group'] === "null" ? null : $data['props']['navHash']['group'];
        return [
            //todo-orel зделать репласер для полей которые передаються как параметры чтоб к ним добавлялся префикс $prefixDataForm или валидировать отдельно и перекидывать ошибки на глобальный уровень
            'props.type_visible' => 'required|in:row,vertical_tabs,casual',
            'props.getter_store_priority_type_code' => 'string',
            'props.count_editors' => 'required|integer|between:1,99',
            'props.min_lines' => 'integer|between:1,999',
            'props.max_lines' => 'integer|between:1,999',
            'props.editors' => 'required|array',
            'props.editors.*.heading' => 'string',
            'props.editors.*.variant_or_group' => 'in:layouts,styles,js,data,jade,html,xml,svg,css,sass,scss,less,stylus,javascript,typescript,coffee,json,yaml,php',
            'props.navHash' => 'array',
            'props.navHash.title' => 'nullable|string|max:255',
            'props.navHash.slug' => 'nullable|alpha_dash|max:255',
            'props.navHash.group' => 'nullable|alpha_dash|max:255',
        ];
    }

    public function getPositionsRules(array $data) {
        $result = [];

        for($i = 0; $i < (int)($data['props']['count_editors']); $i++) {
            $editor = $data['props']['editors'][$i];
            $result['editor' . $i] = [
                'rules' => [
                    [
                        'name' => ['regex:/^code_editor$/miu'],
                        'count' => '1-5',
                        'props' => [
                            'variant' => $this->__getRegexVariablesCode($editor['variant_or_group'])
                          ]
                    ]
                ]
            ];
        }

        return $result;
    }

    private function __getRegexVariablesCode($variant_or_group) {
        if($variant_or_group !== null) {
            if(preg_match("/^layouts|styles|js|data$/imu", $variant_or_group)) {
            switch($variant_or_group) {
                case 'layouts':
                    return ['in:jade,html'];
                case 'styles':
                    return ['in:css,sass,scss,less,stylus'];
                case 'js':
                    return ['in:javascript,typescript,coffee'];
                case 'data':
                    return ['in:json,yaml,xml'];
                }
            } else {
                return ['regex:/^' . $variant_or_group . '$/imu'];
            }
        } else {
            return ['regex:/./imu'];
        }
    }
}