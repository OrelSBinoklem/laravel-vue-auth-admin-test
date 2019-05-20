<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

class BaseContentController extends Controller
{
    protected $rep;

    public function index(Request $request)
    {
        return $this->rep->getOneBySlug($request);
    }
}
