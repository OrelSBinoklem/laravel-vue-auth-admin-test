<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\MenusRepository;

use Gate;

use App\Menu;
use App\MenuItems;

class MenusController extends AdminController
{
    
    protected $menu_rep;

    public function __construct(MenusRepository $menu_rep) {
        parent::__construct();

        /*if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }*/

        $this->menu_rep = $menu_rep;
    }

    public function getTableData()
    {
        return $this->menu_rep->getTableData();
    }

    public function index()
    {
        return $this->menu_rep->get();
    }

    public function store(Request $request)
    {
        if(Gate::denies('EDIT_MENU')) {
            abort(403, 'Недостаточно прав');
        }

        return $this->menu_rep->add($request);
    }

    public function update(Request $request, Menu $menu)
    {
        if(Gate::denies('EDIT_MENU')) {
            abort(403, 'Недостаточно прав');
        }

        return $this->menu_rep->update($request, $menu);
    }

    public function destroy(Menu $menu)
    {
        if(Gate::denies('EDIT_MENU')) {
            abort(403, 'Недостаточно прав');
        }

        return $this->menu_rep->delete($menu);
    }

    public function getItems($id_menu)
    {
        if(Gate::denies('EDIT_MENU')) {
            abort(403, 'Недостаточно прав');
        }

        return $this->menu_rep->get_items(Menu::find((int) $id_menu));
    }

    public function storeItem(Request $request, $id_menu)
    {
        if(Gate::denies('EDIT_MENU')) {
            abort(403, 'Недостаточно прав');
        }

        $menu = Menu::find((int) $id_menu);
        if(!$menu) {
            abort(404, 'Нет такого меню');
        }

        return $this->menu_rep->addItem($request, $menu);
    }

    public function updateItem(Request $request, $id_menu, $id_item)
    {
        if(Gate::denies('EDIT_MENU')) {
            abort(403, 'Недостаточно прав');
        }

        $menu = Menu::find((int) $id_menu);
        if(!$menu) {
            abort(404, 'Нет такого меню');
        }

        $menuItem = MenuItems::find((int) $id_item);
        if(!$menuItem) {
            abort(404, 'Нет такого пункта меню');
        }

        return $this->menu_rep->updateItem($request, $menu, $menuItem);
    }

    public function updateTreeItems(Request $request, $id_menu)
    {
        if(Gate::denies('EDIT_MENU')) {
            abort(403, 'Недостаточно прав');
        }

        $menu = Menu::find((int) $id_menu);
        if(!$menu) {
            abort(404, 'Нет такого меню');
        }

        return $this->menu_rep->updateTreeItems($request, $menu);
    }

    public function deleteItem(Request $request, $id_menu, $id_item)
    {
        if(Gate::denies('EDIT_MENU')) {
            abort(403, 'Недостаточно прав');
        }

        $menu = Menu::find((int) $id_menu);
        if(!$menu) {
            abort(404, 'Нет такого меню');
        }

        $menuItem = MenuItems::find((int) $id_item);
        if(!$menuItem) {
            abort(404, 'Нет такого пункта меню');
        }

        return $this->menu_rep->deleteItem($request, $menu, $menuItem);
    }
}
