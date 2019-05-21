<?php
/**
 * Created by PhpStorm.
 * User: Jeka
 * Date: 24.04.2019
 * Time: 19:00
 */

namespace App\Orel\Content\Widgets;

use App\Repositories\ContentJSPluginRepository;


class Types
{
    public $types;

    public function __construct(ContentJSPluginRepository $ContentJSPluginRepository)
    {
        $this->types = ["js-plugin" => [
                "name" => 'JS плагин',
                "rep" => $ContentJSPluginRepository
            ]
        ];
    }
}