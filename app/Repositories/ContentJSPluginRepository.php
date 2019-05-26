<?php

namespace App\Repositories;

use App\ContentJSPlugin;
use Illuminate\Http\Request;

use Gate;
use Validator;
use Auth;

class ContentJSPluginRepository extends BaseContentRepository {
    public function __construct(ContentJSPlugin $contentJSPlugin) {
        $this->with = ['metas', 'categories', 'tags'];
        $this->model = $contentJSPlugin;
    }

    public function getTableData() {
        $data = parent::getTableData();

        //todo-orel может както фильтровать данные и передавать только нужное а не весь объект
        return response()->json(
            $data
        )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function getOne(Request $request) {
        $data = $request->all();
        $content = $this->model->newQuery()->with(['metas', 'categories', 'tags'])->where('id', (int)$data['id'])->first();

        if($content) {
            return response()->json(
                $content
            )
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET');
        } else {
            abort(404, 'Контент ненайден');
        }
    }

    public function getOneBySlug(Request $request) {
        $data = $request->all();
        $content = $this->model->newQuery()->with(['metas', 'categories', 'tags'])->where('slug', (string)$data['slug'])->first();

        if($content) {
            return response()->json(
                $content
            )
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET');
        } else {
            abort(404, 'Контент ненайден');
        }
    }

    public function add(Request $request) {
        if (Gate::denies('create',$this->model)) {
            abort(403);
        }

        $data = $request->all();

        $data['published'] = $data['published'] ? 1 : 0;

        $this->validatorCreate($data)->validate();

        $new = new ContentJSPlugin;

        $new->fill([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description_short' => $data['description_short'],
            'description' => $data['description'],
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
            'meta_keyword' => $data['meta_keyword'],
            'published' => $data['published'],

            'created_by' => Auth::user()->id,
            'modified_by' => Auth::user()->id
        ]);

        $new->setMeta([
            'alerts' => $data['alerts'],
        ]);

        $new->setMeta([
            'editors' => $data['editors'],
        ]);

        $new->setMeta([
            'positions' => $data['positions'],
        ]);

        $new->save();

        $new->categories()->sync($data['categories_ids']);
        $new->tags()->sync($data['tags_ids']);

        return ['status' => 'Плагин добавлен'];

    }

    public function update(Request $request, ContentJSPlugin $plugin) {
        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $data = $request->all();

        $data['published'] = $data['published'] ? 1 : 0;

        $this->validatorUpdate($data, $plugin)->validate();

        $plugin->fill([
            'title' => $data['title'],
            //'slug' => $data['slug'],
            'description_short' => $data['description_short'],
            'description' => $data['description'],
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
            'meta_keyword' => $data['meta_keyword'],
            'published' => $data['published'],

            //'created_by' => Auth::user()->id,
            'modified_by' => Auth::user()->id
        ]);

        $plugin->setMeta([
            'alerts' => $data['alerts'],
        ]);

        $plugin->setMeta([
            'editors' => $data['editors'],
        ]);

        $plugin->setMeta([
            'positions' => $data['positions'],
        ]);

        $plugin->save();

        $plugin->categories()->sync($data['categories_ids']);
        $plugin->tags()->sync($data['tags_ids']);

        return ['status' => 'Плагин изменён'];

    }

    public function delete(ContentJSPlugin $plugin) {

        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $plugin->categories()->detach();
        $plugin->tags()->detach();

        $t_name = $plugin->title;

        if($plugin->delete()) {
            return ['status' => 'Плагин ' . $t_name . ' удалён'];
        }
    }

    protected function validatorCreate(array $data)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|max:255|unique:content_j_s_plugins,slug',
            'description_short' => 'required|string|max:1023',
            'description' => 'required|string',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'meta_keyword' => 'required|string|max:255',
            'published' => 'required|integer|between:0,1',

            'editors' => 'array|arr_uniq_field:slug',
            'editors.*' => 'array',
            'editors.*.slug' => 'string|max:255',
            'editors.*.text' => 'string|max:4095',

            'alerts.*.title' => 'string|max:255',
            'alerts.*.text' => 'string|max:1023'
        ];
        $this->validateWidgetsData($data,$rules);
        return Validator::make($data, $rules);
    }

    protected function validatorUpdate(array $data, ContentJSPlugin $plugin)
    {
        $rules = [
            'title' => 'required|string|max:255',
            //'slug' => 'required|alpha_dash|max:255|unique:content_j_s_plugins,slug',
            'description_short' => 'required|string|max:1023',
            'description' => 'required|string',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'meta_keyword' => 'required|string|max:255',
            'published' => 'required|integer|between:0,1',

            'editors' => 'array|arr_uniq_field:slug',
            'editors.*' => 'array',
            'editors.*.slug' => 'string|max:255',
            'editors.*.text' => 'string|max:4095',

            'alerts.*.title' => 'string|max:255',
            'alerts.*.text' => 'string|max:1023'
        ];
        $this->validateWidgetsData($data,$rules);
        return Validator::make($data, $rules);
    }

    protected function getPositionsRules(array $data) {
        return [
            'tut_alerts' => [
                'rules' => [
                    [
                        'name' => [
                            'regex:/^alert$/gmi'
                        ],
                        'count' => 2,
                        'not' => [
                            'params' => [
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

?>