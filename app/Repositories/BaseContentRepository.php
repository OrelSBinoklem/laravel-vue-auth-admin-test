<?php

namespace App\Repositories;

use App\Orel\Content\Widgets\Alert as WidgetAlert;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class BaseContentRepository extends VueTableRepository {
    protected $widgets_rules = [];
    protected $public_columns = ['id', 'title', 'slug', 'description_short', 'published', 'viewed', 'created_at', 'updated_at'];

    public function __construct() {
        $this->widgets_rules['alert'] = new WidgetAlert();
    }

    public function getPublicWhereInSlugs(array $slugs) {
        //todo-orel какого хера грузяться metas - временное решение https://github.com/kodeine/laravel-meta/issues/17 вставил в модель метод toArray

        return $this->model->newQuery()
            ->select($this->public_columns)
            ->whereIn('slug', $slugs)
            ->get()
            ->keyBy('slug');
    }

    public function shortWhereInSlugsByTax(array $slugs) {
        //todo-orel какого хера грузяться metas - временное решение https://github.com/kodeine/laravel-meta/issues/17 вставил в модель метод toArray

        return $this->model->newQuery()
            ->select($this->public_columns)
            ->whereIn('slug', $slugs)
            ->with(['categories', 'tags'])
            ->get()
            ->keyBy('slug');
    }

    protected function validateWidgetsData(&$data, array &$allRules) {
        //todo В конце очистить data от rules
        $this->rulesWidgets($data, $data,$allRules, '', '', TRUE);
        //debug($data);
        //debug($allRules);
    }

    protected function rulesWidgets(&$data_original, &$dataWidget, array &$allRules, string $prefixDataForm, string $prefixWrapPos, bool $FIRST) {
        //Вначале проверяем соответствие виджета области а потом просто валидируем параметры виджета

        if(!$FIRST){
            $allRules[$prefixDataForm] = 'widget_matches_position:' . $prefixWrapPos . '|widget_exist';
            if(isset($this->widgets_rules[$dataWidget['name']])) {
                foreach ($this->widgets_rules[$dataWidget['name']]->getWidgetRules($dataWidget) as $name_rule => $rule) {
                    $allRules[$prefixDataForm . '.' . $name_rule] = $rule;
                }
            }
        }

        if($FIRST || (isset($dataWidget['name']) && isset($this->widgets_rules[$dataWidget['name']]))) {
            if(isset($dataWidget['positions'])) {

                $positionRules = $FIRST
                    ? $this->getPositionsRules($data_original)
                    : $this->widgets_rules[$dataWidget['name']]->getPositionsRules($dataWidget);
                //
                foreach ($positionRules as $key => $position) {
                    $allRules[$FIRST ? 'positions.' . $key : $prefixDataForm . '.positions.' . $key] = 'required|position_widgets_count';
                    if (isset($dataWidget['positions'][$key])) {
                        //Вживление правил
                        $dataWidget['positions'][$key]['rules'] = $position['rules'];

                        $prefixDataForm .= (!$FIRST ? '.' : '') . 'positions.' . $key;
                        if(isset($dataWidget['positions'][$key]['widgets'])) {
                            foreach ($dataWidget['positions'][$key]['widgets'] as $key_w => $widget) {

                                $this->rulesWidgets($data_original, $widget,$allRules, $prefixDataForm . '.widgets.' . (int)$key_w,  $prefixDataForm, FALSE);

                            }
                        }
                    }
                }
                //
            }

        }


    }

    protected function __clearPosRules($data) {
        //todo-fast удалить rules
    }
}

?>