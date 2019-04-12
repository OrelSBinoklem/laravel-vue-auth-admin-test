<?php

namespace App\Repositories;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Tag;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection as ModelCollection;

class TaxonomyRepository extends VueTableRepository {

    protected $model_cat = FALSE;
    protected $model_tag = FALSE;
    protected $model_name = '';
    protected $is_cat = TRUE;

    public function __construct(Category $category, Tag $tag) {
        $this->model_cat = $category;
        $this->model_tag = $tag;
    }

    public function setIsCategory(bool $is_cat) {
        $this->is_cat = $is_cat;
        if($is_cat) {
            $this->model = $this->model_cat;
            $this->model_name = 'categories';
        } else {
            $this->model = $this->model_tag;
            $this->model_name = 'tags';
        }
    }

    public function getTableData() {
        $data = parent::getTableData();

        return response()->json(
            $data
        )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function add($request) {
        if (Gate::denies('create',$this->model)) {
            abort(403);
        }

        $data = $request->all();

        $data['published'] = $data['published'] ? 1 : 0;

        $this->validatorCreate($data)->validate();

        $addData = [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'published' => $data['published'],

            'created_by' => Auth::user()->id,
            'modified_by' => Auth::user()->id
        ];
        if($this->is_cat) {
            $addData['parent_id'] = null;
        }
        $tax = $this->model->create($addData);

        if($tax) {
            if($this->is_cat) {
                return ['status' => 'Категория добавлена'];
            } else {
                return ['status' => 'Тэг добавлен'];
            }
        }
    }

    public function update($request, $tax) {
        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $data = $request->all();

        $data['published'] = $data['published'] ? 1 : 0;

        $this->validatorUpdate($data, $tax)->validate();

        $tax->fill([
            'title' => $data['title'],
            //'slug' => $data['slug'],
            'published' => $data['published'],

            //'created_by' => Auth::user()->id,
            'modified_by' => Auth::user()->id
        ]);

        $tax->save();

        if($this->is_cat) {
            return ['status' => 'Категория изменена'];
        } else {
            return ['status' => 'Тэг изменён'];
        }

    }

    public function updateTreeItems(Request $request, ModelCollection $cat) {
        if (Gate::denies('edit', $this->model)) {
            abort(403);
        }

        $data = $request->all();

        $sortedNewLocation = [];
        collect($data['data'])->sortBy('id')->map(function ($item, $key) use (&$index, &$sortedNewLocation) {
            $sortedNewLocation[] = $item;
        });

        $index = 0;
        $success = TRUE;
        $not_recursion_error = TRUE;
        $cat->sortBy('id')->map(function ($item, $key) use (&$index, $sortedNewLocation, &$success, &$not_recursion_error) {
            if($sortedNewLocation[$index]['id'] != $item->id) {
                $success = FALSE;
            } else if($sortedNewLocation[$index]['id'] == $sortedNewLocation[$index]['parent_id']) {
                $not_recursion_error = FALSE;
            } else {
                $item->parent_id = $sortedNewLocation[$index]['parent_id'];
                $item->save();
            }
            $index++;
        });

        if(!$success) {
            return ['error' => 'Переданы неправельные id'];
        }

        if(!$not_recursion_error) {
            return ['error' => 'id категории недолжно быть равно parent_id'];
        }

        return ['status' => 'Расположение категорий обновлено'];
    }

    public function delete(Request $request, Model $tax) {

        if (Gate::denies('edit', $this->model)) {
            abort(403);
        }

        $nested = FALSE;
        if(!$this->is_cat) {
            if($request->has('new_parent')) {
                $tax->newQuery()->where('parent_id', $tax->id)->get()
                    ->map(function ($item, $key) use ($request) {
                        $item->parent_id = $request->input('new_parent');
                        $item->save();
                    });
            }

            $success_nested = TRUE;
            if($request->has('delete_children') && $request->input('delete_children')) {
                $nested = TRUE;
                $collectionsLevelsNested = [];
                function recursion($ids, &$collectionsLevelsNested, $tax) {
                    $collection = $tax->newQuery()->whereIn('parent_id', $ids)->get();
                    if(count($collection) > 0) {
                        $collectionsLevelsNested[] = $collection;
                        recursion($collection->pluck('id')->all(), $collectionsLevelsNested, $tax);
                    }
                }
                recursion([$tax->id], $collectionsLevelsNested, $tax);

                foreach(array_reverse($collectionsLevelsNested, TRUE) as $key => $value) {
                    $value->map(function ($item, $key) use (&$success_nested) {
                        if(!$item->delete()) {
                            $success_nested = FALSE;
                        }
                    });
                }
            }
        }

        $success = $tax->delete();

        if($this->is_cat) {
            if($success) {
                if($nested) {
                    if($success_nested) {
                        return ['status' => 'Категория и вложенные удалены'];
                    }
                    return ['error' => 'Вложенные категории не удалены'];
                } else {
                    return ['status' => 'Категория удалена'];
                }
            }
        } else {
            if($success) {
                return ['status' => 'Тэг удалён'];
            }

        }

        if($this->is_cat) {
            return ['error' => 'Категория не удалена'];
        } else {
            return ['error' => 'Тэг не удалён'];
        }
    }

    protected function validatorCreate(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|max:255|unique:' . $this->model_name . ',slug',
            'published' => 'required|integer|between:0,1'
        ]);
    }

    protected function validatorUpdate(array $data, Model $tax)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            //'slug' => 'required|alpha_dash|max:255|unique:' . $this->model_name . ',slug',
            'published' => 'required|integer|between:0,1'
        ]);
    }
	
}

?>