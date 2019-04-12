<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\TaxonomyRepository;

use Illuminate\Support\Facades\Gate;

class TagsController extends AdminController
{
    protected $rep;

    public function __construct(TaxonomyRepository $rep) {
        parent::__construct();

        /*if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }*/

        $this->rep = $rep;
        $this->rep->setIsCategory(false);
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
            && Gate::denies('EDIT_TAGS')
            && Gate::denies('EDIT_TAXONOMY_ONLY_MY')
            && Gate::denies('EDIT_TAGS_ONLY_MY')
        ) {
            abort(403, 'Недостаточно прав');
        }

        return $this->rep->add($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        if(Gate::denies('EDIT_TAXONOMY') && Gate::denies('EDIT_TAGS')) {
            if(Gate::denies('EDIT_TAXONOMY_ONLY_MY') && Gate::denies('EDIT_TAGS_ONLY_MY')) {
                abort(403, 'Недостаточно прав');
            } else {
                if(Auth::user()->id !== (int)$tag->created_by) {
                    abort(403, 'Вы не являетесь автором тэга');
                }
            }
        }

        return $this->rep->update($request, $tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,  Tag $tag)
    {
        if(Gate::denies('EDIT_TAXONOMY') && Gate::denies('EDIT_TAGS')) {
            if(Gate::denies('EDIT_TAXONOMY_ONLY_MY') && Gate::denies('EDIT_TAGS_ONLY_MY')) {
                abort(403, 'Недостаточно прав');
            } else {
                if(Auth::user()->id !== (int)$tag->created_by) {
                    abort(403, 'Вы не являетесь автором тэга');
                }
            }
        }

        return $this->rep->delete($request, $tag);
    }
}
