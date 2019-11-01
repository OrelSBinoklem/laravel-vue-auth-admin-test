<?php

namespace App\Orel\Menus\PlainPluginsMegaMenu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait Controller
{
    public function getMaterialsDataForItemsPPMM(Request $request) {
        Validator::make($request->all(), [
            'material-slugs' => 'array',
            'material-slugs.*' => 'array'
        ])->validate();

        $slugs = $request->input('material-slugs');

        if($slugs === null) {
            return response()->json([])->header('Access-Control-Allow-Origin', '*')->header('Access-Control-Allow-Methods', 'GET');
        }

        $result = [];

        foreach ($slugs as $key => $type_slugs) {
            if(isset($this->types[$key])) {
                $result[$key] = $this->types[$key]['rep']->get_data_materials_for_ppmm($type_slugs);
            } else {
                abort(404, 'Нет такого типа контента: ' . $key);
            }
        }

        $result = response()->json($result)->header('Access-Control-Allow-Origin', '*')->header('Access-Control-Allow-Methods', 'GET');

        return $result;
    }

    public function getMaterialsTaxForItemsPPMM(Request $request) {
        Validator::make($request->all(), [
            'material-slugs' => 'array',
            'material-slugs.*' => 'array'
        ])->validate();

        $slugs = $request->input('material-slugs');

        if($slugs === null) {
            return response()->json([])->header('Access-Control-Allow-Origin', '*')->header('Access-Control-Allow-Methods', 'GET');
        }

        $result = [];

        foreach ($slugs as $key => $type_slugs) {
            if(isset($this->types[$key])) {
                $result[$key] = $this->types[$key]['rep']->get_data_materials_tax_for_ppmm($type_slugs);
            } else {
                abort(404, 'Нет такого типа контента: ' . $key);
            }
        }

        $result = response()->json($result)->header('Access-Control-Allow-Origin', '*')->header('Access-Control-Allow-Methods', 'GET');

        return $result;
    }

    public function getMaterialsAllTaxForItemsPPMM(Request $request) {
        Validator::make($request->all(), [
            'material-slugs' => 'array'
        ])->validate();

        $slugs = $request->input('material-slugs');

        if($slugs === null) {
            return response()->json([])->header('Access-Control-Allow-Origin', '*')->header('Access-Control-Allow-Methods', 'GET');
        }

        $result = [];

        foreach ($slugs as $key => $type_slugs) {
            if(isset($this->types[$key])) {
                $result[$key] = $this->types[$key]['rep']->get_data_all_materials_tax_for_ppmm();
            } else {
                abort(404, 'Нет такого типа контента: ' . $key);
            }
        }

        $result = response()->json($result)->header('Access-Control-Allow-Origin', '*')->header('Access-Control-Allow-Methods', 'GET');

        return $result;
    }

    /*$this->model->newQuery()
            ->select($this->public_columns)
            ->whereIn('slug', $slugs)
            ->with(['categories', 'tags'])
            ->get()
            ->keyBy('slug');*/
}