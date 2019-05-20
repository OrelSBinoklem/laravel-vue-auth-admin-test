<?php

namespace App\Helpers\Contracts;

use App\MenuItems;

abstract class AdminMenuItemType
{
    protected $store_publick_items = [];

    public function __construct(){

    }

    abstract public function validatorCreateItem(array $data);
    abstract public function validatorUpdateItem(array $data);

    abstract public function setMetaFields(MenuItems $model, array $data);
    abstract public function getPublicDataItem(MenuItems $model);
}