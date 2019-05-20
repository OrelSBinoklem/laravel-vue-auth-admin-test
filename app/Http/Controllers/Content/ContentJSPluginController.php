<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;

use App\Repositories\ContentJSPluginRepository;

class ContentJSPluginController extends BaseContentController
{
    protected $rep;

    public function __construct(ContentJSPluginRepository $rep) {
        $this->rep = $rep;
    }
}
