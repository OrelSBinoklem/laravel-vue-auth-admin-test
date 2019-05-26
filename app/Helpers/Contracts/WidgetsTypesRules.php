<?php

namespace App\Helpers\Contracts;

use App\MenuItems;

abstract class WidgetsTypesRules
{
    abstract public function getWidgetRules(array $data);
    abstract public function getPositionsRules(array $data);
}