<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Orel\Content\Types;
use App\Orel\Menus\PlainPluginsMegaMenu\Controller as PPMMController;

class ContentController extends Controller
{
    use PPMMController;

    protected $types;

    public function __construct(Types $types) {
        $this->types = $types->types;
    }

    public function getPublicWhereInSlug(Request $request)
    {

        Validator::make($request->all(), [
            'material-slugs' => 'array',
            'material-slugs.*' => 'array'
        ])->validate();

        $slugs = $request->input('material-slugs');

        if($slugs === null) {
            return response()->json(
                []
            )
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET');
        }

        $result = [];

        foreach ($slugs as $key => $type_slugs) {
            if(isset($this->types[$key])) {
                $result[$key] = $this->types[$key]['rep']->getPublicWhereInSlugs($type_slugs);
            } else {
                abort(404, 'Нет такого типа контента: ' . $key);
            }
        }

        $result = response()->json(
            $result
        )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');

        return $result;
    }

    public function ShortWhereInSlugsByTax(Request $request)
    {

        Validator::make($request->all(), [
            'material-slugs' => 'array',
            'material-slugs.*' => 'array'
        ])->validate();

        $slugs = $request->input('material-slugs');

        if($slugs === null) {
            return response()->json(
                []
            )
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET');
        }

        $result = [];

        foreach ($slugs as $key => $type_slugs) {
            if(isset($this->types[$key])) {
                $result[$key] = $this->types[$key]['rep']->shortWhereInSlugsByTax($type_slugs);
            } else {
                abort(404, 'Нет такого типа контента: ' . $key);
            }
        }

        $result = response()->json(
            $result
        )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');

        return $result;
    }
}
