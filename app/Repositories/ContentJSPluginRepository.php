<?php

namespace App\Repositories;

use App\ContentJSPlugin;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;

use Gate;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class ContentJSPluginRepository extends BaseContentRepository {
    use UploadTrait;

    protected $meta_fields = [
        'plugin_site',
        'plugin_github',
        'plugin_npm',
        'plugin_demo',
    ];

    public function __construct(ContentJSPlugin $contentJSPlugin) {
        $this->with = ['metas', 'categories', 'tags'];
        $this->model = $contentJSPlugin;
        parent::__construct();
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

        $meta = [];
        if ($request->has('meta_fields.plugin_file_data') && $request->file('meta_fields.plugin_file_data') !== null) {
            $file = $request->file('meta_fields.plugin_file_data');
            $name = $file->getClientOriginalName();
            $folder = '/uploads/js-plugins/';
            $filePath = $folder . $file->getClientOriginalName();
            $this->uploadOne($file, $folder, 'public', substr($name, 0, strlen($name) - (strlen($file->getClientOriginalExtension()) + 1)));

            $meta['plugin_file'] = $filePath;
        } else {
            $meta['plugin_file'] = null;
        }

        foreach($this->meta_fields as $value) {
            if ($request->has('meta_fields.' . $value) && $request->input('meta_fields.' . $value) !== null) {
                $meta[$value] = $request->input('meta_fields.' . $value);
            }
        }

        if(count($meta)) {
            $new->setMeta($meta);
        }

        $new->setMeta([
            'positions' => $data['positions'],
        ]);

        $new->save();

        $new->categories()->sync(isset($data['categories_ids']) ? $data['categories_ids'] : []);
        $new->tags()->sync(isset($data['tags_ids']) ? $data['tags_ids'] : []);

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

        $meta = [];
        $iconPath = null;
        $folder = '/uploads/js-plugins/';
        if ($request->has('meta_fields.plugin_file_data') && $request->file('meta_fields.plugin_file_data') !== null) {
            $file = $request->file('meta_fields.plugin_file_data');
            $name = $file->getClientOriginalName();
            $filePath = $folder . $file->getClientOriginalName();

            debug(substr($name, 0, strlen($name) - (strlen($file->getClientOriginalExtension()) + 1)));
            $this->uploadOne($file, $folder, 'public', substr($name, 0, strlen($name) - (strlen($file->getClientOriginalExtension()) + 1)));
            $meta['plugin_file'] = $filePath;
        } else {
            if(!$request->has('plugin_file') || !$request->input('plugin_file') && $plugin->plugin_file !== null) {
                Storage::disk('public')->delete($plugin->plugin_file);
                $meta['plugin_file'] = null;
            }
        }

        foreach($this->meta_fields as $value) {
            if ($request->has('meta_fields.' . $value) && $request->input('meta_fields.' . $value) !== null) {
                $meta[$value] = $request->input('meta_fields.' . $value);
            }
        }

        if(count($meta)) {
            $plugin->setMeta($meta);
        }

        $plugin->setMeta([
            'positions' => $data['positions'],
        ]);

        $plugin->save();

        $plugin->categories()->sync(isset($data['categories_ids']) ? $data['categories_ids'] : []);
        $plugin->tags()->sync(isset($data['tags_ids']) ? $data['tags_ids'] : []);

        return ['status' => 'Плагин изменён'];

    }

    public function delete(ContentJSPlugin $plugin) {

        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $plugin->categories()->detach();
        $plugin->tags()->detach();

        $t_name = $plugin->title;

        if($plugin->plugin_file !== null) {
            Storage::disk('public')->delete($plugin->plugin_file);
        }

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

            'meta_fields.plugin_file_data' => 'nullable|mimes:zip,bz,bz2|max:4096',
            'meta_fields.plugin_site' => 'nullable|url|max:255',
            'meta_fields.plugin_github' => 'nullable|url|max:255',
            'meta_fields.plugin_npm' => 'nullable|url|max:255',
            'meta_fields.plugin_demo' => 'nullable|url|max:255',
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

            'meta_fields.plugin_file_data' => 'nullable|mimes:zip,bz,bz2|max:4096',
            'meta_fields.plugin_site' => 'nullable|url|max:255',
            'meta_fields.plugin_github' => 'nullable|url|max:255',
            'meta_fields.plugin_npm' => 'nullable|url|max:255',
            'meta_fields.plugin_demo' => 'nullable|url|max:255',
        ];
        $this->validateWidgetsData($data,$rules);
        return Validator::make($data, $rules);
    }

    protected function getPositionsRules(array $data) {
        return [
            'description' => [
                'rules' => [
                    [
                        'name' => [
                            'regex:/^casual_html$/im'
                        ]
                    ]
                ]
            ],
            'tut_alerts' => [
                'rules' => [
                    [
                        'name' => [
                            'regex:/^callout/im'
                        ],
                        'props' => [
                            'variant' => ['regex:/^danger|warning$/im']
                        ]
                        //'count' => 2,
                        /*'not' => [
                            'props' => [
                                'variant' => ['regex:/^light|dark$/im']
                            ]
                        ]*/
                    ],
                    /*[
                        'name' => 'regex:/^button$/im'
                    ]*/
                ]
            ],
            'use_code' => [
                'rules' => [
                    [
                        'name' => [
                            'regex:/^copy_code$/im'
                        ]
                    ]
                ]
            ]
        ];
    }
}

?>