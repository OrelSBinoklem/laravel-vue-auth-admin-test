<?php

namespace App\Orel\Menus\PlainPluginsMegaMenu;

use App\Menu;

trait Repository
{
    public function get_data_materials_for_ppmm(array $slugs) {
        $result = [];
        $slugs_nocache = [];

        $name_model = get_class($this->model);

        foreach ($slugs as $slug) {
            if(\Cache::has('materials_for_ppmm_' . $name_model . '_' . $slug)) {
                $result[$slug] = \Cache::get('materials_for_ppmm_' . $name_model . '_' . $slug);
            } else {
                $slugs_nocache[] = $slug;
            }
        }

        if(count($slugs_nocache)) {
            $loaded = $this->model->newQuery()
                ->select($this->public_columns)
                ->whereIn('slug', $slugs_nocache)
                ->with(['categories', 'tags', 'metas'])
                ->get()
                ->keyBy('slug')
                ->toArray();

            foreach ($loaded as $slug => &$content) {
                $meta_data = $content['meta_data'];

                unset($content['metas']);
                unset($content['meta_data']);
                $content['meta_data'] = [];
                $content['meta_data']['positions'] = [];

                $content['meta_data']['positions']['description'] = $meta_data['positions']['description'];
                $content['meta_data']['positions']['use_code'] = $meta_data['positions']['use_code'];
                if(isset($meta_data['plugin_file'])) {$content['meta_data']['plugin_file'] = $meta_data['plugin_file'];}
                if(isset($meta_data['plugin_site'])) {$content['meta_data']['plugin_site'] = $meta_data['plugin_site'];}
                if(isset($meta_data['plugin_github'])) {$content['meta_data']['plugin_github'] = $meta_data['plugin_github'];}
                if(isset($meta_data['plugin_npm'])) {$content['meta_data']['plugin_npm'] = $meta_data['plugin_npm'];}
                if(isset($meta_data['plugin_demo'])) {$content['meta_data']['plugin_demo'] = $meta_data['plugin_demo'];}

                \Cache::put('materials_for_ppmm_' . $name_model . '_' . $slug, $content, 90);
            }

            return array_merge($result, $loaded);
        } else {
            return $result;
        }
    }
}