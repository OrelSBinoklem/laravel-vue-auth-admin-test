<?php

namespace App\Repositories;


class VueTableRepository extends Repository
{
    protected $with = null;
    protected $fieldsFilter = null;

    public function getTableData() {
        $request = request();
        $query = $this->model->newQuery();
        if(!empty($this->with)) {
            foreach ($this->with as $with) {
                $query = $query->with($with);
            }
        }
        //$query = $this->model->newQuery();
        // handle sort option
        if (request()->has('sort')) {
            // handle multisort
            $sorts = explode(',', request()->sort);
            foreach ($sorts as $sort) {
                list($sortCol, $sortDir) = explode('|', $sort);
                $query = $query->orderBy($sortCol, $sortDir);
            }
        } else {
            $query = $query->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            if(property_exists($this->model, 'translatable')) {
                $this->fieldsFilter = $this->fieldsToLangFields($this->model, $this->fieldsFilter);
            }

            debug($this->fieldsFilter);

            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where($this->fieldsFilter[0], 'like', $value);
                if(count($this->fieldsFilter) > 1) {
                    for($i = 1; $i < count($this->fieldsFilter); $i++) {
                        $q->orWhere($this->fieldsFilter[$i], 'like', $value);
                    }
                }
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        //$pagination = $query->with('address')->paginate($perPage);
        $pagination = $query->paginate($perPage);
        $pagination->appends([
            'sort' => request()->sort,
            'filter' => request()->filter,
            'per_page' => request()->per_page
        ]);
        // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
        // are to allow you to call this from any domain (see CORS for more info).
        // This is for local testing only. You should not do this in production server,
        // unless you know what it means.
        return $pagination;
    }
}