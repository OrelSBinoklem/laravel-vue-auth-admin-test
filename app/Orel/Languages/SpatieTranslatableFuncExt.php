<?php

namespace App\Orel\Languages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Lang;

trait SpatieTranslatableFuncExt
{
    public function touchGetters($model)
    {
        if($model instanceof Collection) {
            $first = $model->first();
            if($first !== null) {
                if(property_exists($first,'translatable')) {
                    $model->each(function ($model) use ($first) {
                        foreach($first->translatable as $key => $field) {
                            $model->$field = $model->$field;
                        }
                    });
                }
            }
        } else if($model instanceof Model) {
            if(property_exists($model,'translatable')) {
                foreach($model->translatable as $key => $field) {
                    $model->$field = $model->$field;
                }
            }
        } else {
            throw new Exception('Передан неправельный тип. Модель может быть моделью либо коллекцией моделей');
        }
    }

    public function fieldsToLangFields($model, $fields)
    {
        //parse $translatable or return $fields
        if($model instanceof Collection) {
            $first = $model->first();
            if($first === null) {
                return $fields;
            } else {
                if(property_exists($first,'translatable')) {
                    $translatable = $first->translatable;
                } else {
                    return $fields;
                }
            }
        } else if($model instanceof Model) {
            if(property_exists($model,'translatable')) {
                $translatable = $model->translatable;
            } else {
                return $fields;
            }
        } else {
            throw new Exception('Передан неправельный тип. Модель может быть моделью либо коллекцией моделей');
        }

        //add ->lang_code for translatable fields
        if(is_array($fields)) {
            $translatableFields = collect($translatable);

            foreach($fields as $key => $field) {
                if($translatableFields->search($field) !== false) {
                    $fields[$key] .= '->' . Lang::locale();
                }
            }
            return $fields;
        } else if(is_string($fields)) {
            $translatableFields = collect($translatable);

            if($translatableFields->search($fields) !== false) {
                return $fields . '->' . Lang::locale();
            }
        } else {
            throw new Exception('Передан неправельный тип. ожидаеться строка или массив');
        }
    }
}