<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

class BaseContentController extends AdminController
{
    protected $rep;

    public function __construct() {
        parent::__construct();
	}

    public function getTableData()
    {
        return $this->rep->getTableData();
    }
}
