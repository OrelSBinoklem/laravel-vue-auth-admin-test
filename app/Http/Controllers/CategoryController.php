<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\TaxonomyRepository;

use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    protected $rep;

    public function __construct(TaxonomyRepository $rep) {
        $this->rep = $rep;
        $this->rep->setIsCategory(true);
    }

    public function getPublic ()
    {
        return $this->rep->getPublic();
    }

}
