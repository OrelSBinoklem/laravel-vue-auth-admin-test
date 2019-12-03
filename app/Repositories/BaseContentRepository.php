<?php

namespace App\Repositories;

use App\Orel\Content\Widgets\Alert as WidgetAlert;
use App\Orel\Content\Widgets\Callout as WidgetCallout;
use App\Orel\Content\Widgets\CasualHtml as WidgetCasualHtml;
use App\Orel\Content\Widgets\CodeEditor as WidgetCodeEditor;
use App\Orel\Content\Widgets\CopyCode as WidgetCopyCode;
use App\Orel\Content\Widgets\Markdown as WidgetMarkdown;

use App\Orel\Menus\PlainPluginsMegaMenu\Repository as PPMMRepository;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class BaseContentRepository extends VueTableRepository {
    use PPMMRepository;

    protected $widgets_rules = [];
    protected $public_columns = ['id', 'title', 'slug', 'description_short', 'published', 'viewed', 'created_at', 'updated_at'];

    public function __construct() {
        $this->widgets_rules['alert'] = new WidgetAlert();
        $this->widgets_rules['callout'] = new WidgetCallout();
        $this->widgets_rules['casual_html'] = new WidgetCasualHtml();
        $this->widgets_rules['code_editor'] = new WidgetCodeEditor();
        $this->widgets_rules['copy_code'] = new WidgetCopyCode();
        $this->widgets_rules['markdown'] = new WidgetMarkdown();
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
                //debug('rules');
                //debug($positionRules);
                //
                foreach ($positionRules as $key => $position) {
                    $allRules[$FIRST ? 'positions.' . $key : $prefixDataForm . '.positions.' . $key] = 'required|position_widgets_count';
                    if (isset($dataWidget['positions'][$key])) {
                        //Вживление правил
                        $dataWidget['positions'][$key]['rules'] = $position['rules'];

                        $prefixDataFormPos = $prefixDataForm . (!$FIRST ? '.' : '') . 'positions.' . $key;
                        if(isset($dataWidget['positions'][$key]['widgets'])) {
                            foreach ($dataWidget['positions'][$key]['widgets'] as $key_w => $widget) {
                                //$dataWidget['positions'][$key]['widgets'][$key_w] токо так сохраняються изменения в следующей итерации
                                $this->rulesWidgets($data_original, $dataWidget['positions'][$key]['widgets'][$key_w], $allRules, $prefixDataFormPos . '.widgets.' . (int)$key_w,  $prefixDataFormPos, FALSE);

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