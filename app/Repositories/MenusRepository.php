<?php

namespace App\Repositories;

use Illuminate\Http\Request;

use App\Menu;
use App\MenuItems;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

use App\Orel\Admin\Menu\ItemsTypes\Casual as typeCasual;

use Carbon\Carbon;


class MenusRepository extends VueTableRepository
{
	protected $with = [];
    protected $fieldsFilter = ['name'];

    protected $types = [];
    
	public function __construct(Menu $menus, MenuItems $items, typeCasual $typeCasual) {
		$this->model = $menus;
		$this->modelItems = $items;

        $this->types[] = $typeCasual;
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

        $this->validatorCreate($data)->validate();

        $this->model->create([
            'name' => $data['name'],
            'slug' => $data['slug']
        ]);

        return ['status' => 'Меню добавлено'];
	}
	
	
	public function update($request, $menu) {
		if (Gate::denies('edit',$this->model)) {
            abort(403);
        }
		
		$data = $request->all();

        $this->validatorUpdate($data, $menu)->validate();

        $menu->name = $data['name'];
        //$menu->slug = $data['slug']; слаг лучше неменять иначе теряеться его смысл

        $menu->save();

        return ['status' => 'Меню изменено'];
	}
	
	public function delete(Menu $menu) {
		
		if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $t_name = $menu->name;

		//Доудалять метаданные с пунктов
        $menu->menuItems()->delete();

		if($menu->delete()) {
			return ['status' => 'Меню ' . $t_name . ' удалено'];
		}
	}

    protected function validatorUpdate(array $data, Menu $menu)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:menus,name,' . $menu->id,
            //'slug' => 'required|alpha_dash|max:255|unique:menus,slug,' . $menu->id
        ];

        return Validator::make($data, $rules);
    }

    protected function validatorCreate(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:menus,name',
            'slug' => 'required|alpha_dash|max:255|unique:menus,slug'
        ]);
    }

    public function get_items(Menu $menu) {

        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        return response()->json(
            $menu->menuItems()->with(['metas'])->get()
        )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function addItem(Request $request, Menu $menu) {
        if (Gate::denies('create', $this->modelItems)) {
            abort(403);
        }

        $data = $request->all();

        $data['publish'] = $data['publish'] ? 1 : 0;

        if($data['type_id'] > count($this->types) || $data['type_id'] < 1) {
            abort(404, 'Нет такого типа пункта меню');
        }

        $this->validatorCreateItem($data)->validate();

        $type = $this->types[$data['type_id'] - 1];

        $type->validatorCreateItem($data)->validate();

        $menu->menuItems()->increment('order');

        $new = new MenuItems;

        $new->fill([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'path' => $data['path'],
            'publish' => $data['publish'],

            'order' => 1,
            'menu_id' => $menu->id,
            'parent_id' => null,
            'type_id' => $data['type_id']
        ]);

        $type->setMetaFields($new, $data);

        $new->save();

        //МНОГО ЗАПРОСОВ (изза плагина мета полей) решил с помощью метода fill

        return ['status' => 'Пункт добавлен'];
    }

    public function updateItem(Request $request, Menu $menu, MenuItems $menuItem) {
        if (Gate::denies('edit', $this->modelItems)) {
            abort(403);
        }

        $data = $request->all();

        $data['publish'] = $data['publish'] ? 1 : 0;

        if($data['type_id'] > count($this->types) || $data['type_id'] < 1) {
            abort(404, 'Нет такого типа пункта меню');
        }

        $this->validatorUpdateItem($data, $menuItem)->validate();

        $type = $this->types[$data['type_id'] - 1];

        $type->validatorUpdateItem($data, $menuItem)->validate();

        $menuItem->fill([
            'name' => $data['name'],
            //'slug' => $data['slug'], слаг лучше неменять иначе теряеться его смысл
            'path' => $data['path'],
            'publish' => $data['publish']
        ]);

        $type->setMetaFields($menuItem, $data);

        $menuItem->save();

        return ['status' => 'Пункт обновлён'];
    }

    public function updateTreeItems(Request $request, Menu $menu) {
        if (Gate::denies('edit', $this->modelItems)) {
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
        $menu->menuItems->sortBy('id')->map(function ($item, $key) use (&$index, $sortedNewLocation) {
            if($sortedNewLocation[$index]['id'] != $item->id) {
                $success = FALSE;
            } else if($sortedNewLocation[$index]['id'] == $sortedNewLocation[$index]['parent_id']) {
                $not_recursion_error = FALSE;
            } else {
                $item->parent_id = $sortedNewLocation[$index]['parent_id'];
                $item->order = $sortedNewLocation[$index]['order'];
                $item->save();
            }
            $index++;
        });

        if(!$success) {
            return ['error' => 'Переданы неправельные id'];
        }

        if(!$not_recursion_error) {
            return ['error' => 'id пункта недолжно быть равно parent_id'];
        }

        return ['status' => 'Расположение пунктов обновлено'];
    }

    public function deleteItem(Request $request, Menu $menu, MenuItems $menuItem) {
        if (Gate::denies('edit', $this->modelItems)) {
            abort(403);
        }

        if($request->has('new_parent')) {
            MenuItems::where('parent_id', $menuItem->id)->get()
                ->map(function ($item, $key) use ($request) {
                $item->parent_id = $request->input('new_parent');
                $item->save();
            });
        }

        $nested = FALSE;
        $success_nested = TRUE;
        if($request->has('delete_children') && $request->input('delete_children')) {
            $nested = TRUE;
            $collectionsLevelsNested = [];
            function recursion($ids, &$collectionsLevelsNested) {
                $collection = MenuItems::whereIn('parent_id', $ids)->get();
                if(count($collection) > 0) {
                    $collectionsLevelsNested[] = $collection;
                    recursion($collection->pluck('id')->all(),$collectionsLevelsNested);
                }
            }
            recursion([$menuItem->id],$collectionsLevelsNested);

            foreach(array_reverse($collectionsLevelsNested, TRUE) as $key => $value) {
                $value->map(function ($item, $key) use ($success_nested) {
                    if(!$item->delete()) {
                        $success_nested = FALSE;
                    }
                });
            }
        }

        $success = $menuItem->delete();

        $index = 1;
        $menu->menuItems->sortBy('order')->map(function ($item, $key) use (&$index) {
            $item->order = $index;
            $item->save();
            $index++;
        });

        if($success) {
            if($nested) {
                if($success_nested) {
                    return ['status' => 'Пункт и вложенные удалены'];
                }
                return ['error' => 'Дочерние пункты не удалены'];
            } else {
                return ['status' => 'Пункт удалён'];
            }
        }

        return ['error' => 'Пункт не удалён'];
    }

    protected function validatorCreateItem(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|max:255|unique:menu_items,slug',
            'path' => 'required|max:255',
            'publish' => 'required|integer|between:0,1',
            'type_id' => 'required|integer|between:1,100'
        ]);
    }

    protected function validatorUpdateItem(array $data, MenuItems $item)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            //'slug' => 'required|alpha_dash|max:255|unique:menu_items,slug,' . $item->id,
            'path' => 'required|max:255',
            'publish' => 'required|integer|between:0,1',
            'type_id' => 'required|integer|between:1,100'
        ]);
    }
}