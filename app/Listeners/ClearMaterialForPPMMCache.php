<?php

namespace App\Listeners;

class ClearMaterialForPPMMCache
{
    public function handle($event)
    {
        $model = $event->getModel();
        $name_model = get_class($model);

        \Cache::forget('materials_for_ppmm_' . $name_model . '_' . $model->slug);
    }
}
