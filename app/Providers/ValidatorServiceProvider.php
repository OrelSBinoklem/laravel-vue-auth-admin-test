<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->app['validator']->extend('arr_uniq_field', function ($attribute, $value, $parameters)
        {
            $uniq = [];
            foreach ($value as $el) {
                if(isset($uniq[$el[$parameters[0]]])) {
                    return false;
                } else {
                    $uniq[$el[$parameters[0]]] = TRUE;
                }
            }
            return true;
        });

        $this->app['validator']->replacer('arr_uniq_field', function($message, $attribute, $rule, $parameters)
        {
            return str_replace(':field', $parameters[0], $message);
        });
    }

    public function register()
    {
        //
    }
}