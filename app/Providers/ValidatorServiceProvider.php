<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Arr;

use App\Orel\Content\Widgets\Alert as WidgetAlert;

class ValidatorServiceProvider extends ServiceProvider {

    protected $widgets_rules = [];

    public function boot(WidgetAlert $widgetAlert)
    {
        $this->widgets_rules['alert'] = $widgetAlert;

        $this->app['validator']->extend('arr_uniq_field', function ($attribute, $value, $parameters)
        {
            $uniq = [];
            foreach ($value as $el) {
                if(isset($uniq[$el[$parameters[0]]])) {
                    return false;
                } else {
                    $uniq[$el[$parameters[0]]] = TRUE;
                }
            }
            return true;
        });

        $this->app['validator']->replacer('arr_uniq_field', function($message, $attribute, $rule, $parameters)
        {
            return str_replace(':field', $parameters[0], $message);
        });

        //
        //todo возможно зделать кеш проверок виджетов чтоб и на count и на соответствие области недублировались проверки(ключ использовать как атрибут позиции а в значение заносить rules и not_rules)
        $this->app['validator']->extend('position_widgets_count', function ($attribute, $value, $parameters)
        {
            foreach ($value['rules'] as $key => $pos_rule) {
                if(!$this->__checkOnePosRuleCountsWidgets($pos_rule, $value['widgets'])) {
                    return false;
                }
            }
            return true;
        });

        //Соответствие виджета позиции
        $this->app['validator']->extend('widget_matches_position', function ($attribute, $value, $parameters, $validator)
        {
            //todo-hack получение параметра
            $position = Arr::get($validator->getData(), $parameters[0]);
            foreach ($position['rules'] as $key => $rule_pos) {
                $rules = [];
                if(isset($rule_pos['name'])){$rules['name'] = $rule_pos['name'];}
                if(isset($rule_pos['props'])) {
                    foreach ($rule_pos['props'] as $prop_name => $prop_rule) {
                        $rules['props.' . $prop_name] = $prop_rule;
                    }
                }
                $rules_not = [];
                if(isset($rule_pos['not'])) {
                    if(isset($rule_pos['not']['name'])){$rules_not['name'] = $rule_pos['not']['name'];}
                    if(isset($rule_pos['not']['props'])) {
                        foreach ($rule_pos['not']['props'] as $prop_name => $prop_rule) {
                            $rules_not['props.' . $prop_name] = $prop_rule;
                        }
                    }
                }

                if(!Validator::make($value, $rules)->fails() && (!count($rules_not) || Validator::make($value, $rules_not)->fails())) {
                    return true;
                }
            }

            return false;
        });

        //Проверка существования виджета
        $this->app['validator']->extend('widget_exist', function ($attribute, $value, $parameters)
        {
            return isset($this->widgets_rules[$value['name']]);
        });
    }

    public function register()
    {
        //
    }

    private function __checkOnePosRuleCountsWidgets(array $rule_pos, array $widgets) {
        if(isset($rule_pos['count']) && $rule_pos['count'] != '*') {
            //Считаем количество соответствующих виджетов
            $count = 0;

            $rules = [];
            if(isset($rule_pos['name'])){$rules['name'] = $rule_pos['name'];}
            if(isset($rule_pos['props'])) {
                foreach ($rule_pos['props'] as $prop_name => $prop_rule) {
                    $rules['props.' . $prop_name] = $prop_rule;
                }
            }
            $rules_not = [];
            if(isset($rule_pos['not'])) {
                if(isset($rule_pos['not']['name'])){$rules_not['name'] = $rule_pos['not']['name'];}
                if(isset($rule_pos['not']['props'])) {
                    foreach ($rule_pos['not']['props'] as $prop_name => $prop_rule) {
                        $rules_not['props.' . $prop_name] = $prop_rule;
                    }
                }
            }

            foreach ($widgets as $key => $widget) {
                debug($widget, $rules_not);
                if(!Validator::make($widget, $rules)->fails() && (!count($rules_not) || Validator::make($widget, $rules_not)->fails())) {
                    $count++;
                }
            }
            //\Считаем количество соответствующих виджетов

            //Варианты шаблонов count
            //'*' - сколько угодно
            //n - точное число
            //n+ - число и больше
            //n-m - промежуток

            /*if($rule_pos['count'] == '*') {//переместил вверх
                return true;
            }*/
            $matches = [];
            if(preg_match("/^[1-9]\d*$/i", $rule_pos['count'] . '')) {
                return $count === (int)$rule_pos['count'];
            } else if(preg_match("/^[1-9]\d*\+$/i", $rule_pos['count'] . '')) {
                return $count >= (int)preg_replace('/\D/', '', $rule_pos['count'] . '');
            } else if(preg_match("/^(?:\d+)\-(?:[1-9]\d*)$/i", $rule_pos['count'] . '', $matches)) {
                return $count >= (int)$matches[1] && $count <= (int)$matches[2];
            }
        } else {
            return true;
        }
    }
}