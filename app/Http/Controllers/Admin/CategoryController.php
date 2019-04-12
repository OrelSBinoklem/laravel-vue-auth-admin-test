<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\TaxonomyRepository;

use Illuminate\Support\Facades\Gate;

class CategoryController extends AdminController
{
    protected $rep;

    public function __construct(TaxonomyRepository $rep) {
        parent::__construct();

        /*if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }*/

        $this->rep = $rep;
        $this->rep->setIsCategory(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->rep->getAll([]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(
            Gate::denies('EDIT_TAXONOMY')
            && Gate::denies('EDIT_CATEGORIES')
            && Gate::denies('EDIT_TAXONOMY_ONLY_MY')
            && Gate::denies('EDIT_CATEGORIES_ONLY_MY')
        ) {
            abort(403, 'Недостаточно прав');
        }

        return $this->rep->add($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if(Gate::denies('EDIT_TAXONOMY') && Gate::denies('EDIT_CATEGORIES')) {
            if(Gate::denies('EDIT_TAXONOMY_ONLY_MY') && Gate::denies('EDIT_CATEGORIES_ONLY_MY')) {
                abort(403, 'Недостаточно прав');
            } else {
                if(Auth::user()->id !== (int)$category->created_by) {
                    abort(403, 'Вы не являетесь автором категории');
                }
            }
        }

        return $this->rep->update($request, $category);
    }

    public function updateTreeItems(Request $request)
    {
        //Может облегчить права доступа к данному действию
        if(Gate::denies('EDIT_TAXONOMY') && Gate::denies('EDIT_CATEGORIES')) {
            abort(403, 'Недостаточно прав');
            /*if(Gate::denies('EDIT_TAXONOMY_ONLY_MY') && Gate::denies('EDIT_CATEGORIES_ONLY_MY')) {
                abort(403, 'Недостаточно прав');
            } else {
                if(Auth::user()->id !== (int)$category->created_by) {
                    abort(403, 'Вы не являетесь автором категории');
                }
            }*/
        }

        return $this->rep->updateTreeItems($request, Category::all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        if(Gate::denies('EDIT_TAXONOMY') && Gate::denies('EDIT_CATEGORIES')) {
            if(Gate::denies('EDIT_TAXONOMY_ONLY_MY') && Gate::denies('EDIT_CATEGORIES_ONLY_MY')) {
                abort(403, 'Недостаточно прав');
            } else {
                if(Auth::user()->id !== (int)$category->created_by) {
                    abort(403, 'Вы не являетесь автором категории');
                }
            }
        }

        return $this->rep->delete($request, $category);
    }
}
