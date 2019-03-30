<?php

namespace App\Repositories;

use App\ContentJSPlugin;
use Illuminate\Http\Request;

use Gate;
use Validator;
use Auth;

class ContentJSPluginRepository extends BaseContentRepository {

    public function __construct(ContentJSPlugin $contentJSPlugin) {
        $this->with = ['metas'];
        $this->model = $contentJSPlugin;
    }

    public function getTableData() {
        $data = parent::getTableData();

        return response()->json(
            $data
        )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function getOne(Request $request) {
        $data = $request->all();

        return response()->json(
            $this->model->newQuery()->with('metas')->where('id', (int)$data['id'])->first()
        )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
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

        $new->save();

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

        $plugin->save();

        return ['status' => 'Плагин изменён'];

    }

    public function delete(ContentJSPlugin $plugin) {

        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        //$plugin->roles()->detach();

        $t_name = $plugin->title;

        if($plugin->delete()) {
            return ['status' => 'Плагин ' . $t_name . ' удалён'];
        }
    }

    protected function validatorCreate(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|max:255|unique:content_j_s_plugins,slug',
            'description_short' => 'required|string|max:1023',
            'description' => 'required|string',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'meta_keyword' => 'required|string|max:255',
            'published' => 'required|integer|between:0,1',

            'alerts.*.title' => 'string|max:255',
            'alerts.*.text' => 'string|max:1023'
        ]);
    }

    protected function validatorUpdate(array $data, ContentJSPlugin $plugin)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            //'slug' => 'required|alpha_dash|max:255|unique:content_j_s_plugins,slug',
            'description_short' => 'required|string|max:1023',
            'description' => 'required|string',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'meta_keyword' => 'required|string|max:255',
            'published' => 'required|integer|between:0,1',

            'alerts.*.title' => 'string|max:255',
            'alerts.*.text' => 'string|max:1023'
        ]);
    }

}

?>