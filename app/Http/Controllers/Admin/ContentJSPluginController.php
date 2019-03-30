<?php

namespace App\Http\Controllers\Admin;

use App\ContentJSPlugin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Gate;

use App\Repositories\ContentJSPluginRepository;

class ContentJSPluginController extends BaseContentController
{
    protected $rep;

    public function __construct(ContentJSPluginRepository $rep) {
        parent::__construct();

        /*if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }*/

        $this->rep = $rep;
    }

    public function getOne(Request $request) {
        return $this->rep->getOne($request);
    }

    public function store(Request $request)
    {
        if(Gate::denies('EDIT_JS_PLUGIN') && Gate::denies('EDIT_JS_PLUGIN_ONLY_MY')) {
            abort(403, 'Недостаточно прав');
        }

        return $this->rep->add($request);
    }

    public function update(Request $request, $id)
    {
        $plugin = ContentJSPlugin::find((int) $id);
        if(!$plugin) {
            abort(404, 'Нет такого плагина');
        }

        if(Gate::denies('EDIT_JS_PLUGIN')) {
            if(Gate::denies('EDIT_JS_PLUGIN_ONLY_MY')) {
                abort(403, 'Недостаточно прав');
            } else {
                if(Auth::user()->id !== (int)$plugin->created_by) {
                    abort(403, 'Вы не являетесь автором плагина');
                }
            }
        }

        return $this->rep->update($request, $plugin);
    }

    public function destroy($id)
    {
        $plugin = ContentJSPlugin::find((int) $id);
        if(!$plugin) {
            abort(404, 'Нет такого плагина');
        }

        if(Gate::denies('EDIT_JS_PLUGIN')) {
            if(Gate::denies('EDIT_JS_PLUGIN_ONLY_MY')) {
                abort(403, 'Недостаточно прав');
            } else {
                if(Auth::user()->id !== (int)$plugin->created_by) {
                    abort(403, 'Вы не являетесь автором плагина');
                }
            }
        }

        return $this->rep->delete($plugin);
    }
}
