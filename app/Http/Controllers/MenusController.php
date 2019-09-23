<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\MenusRepository;

use Gate;

use App\Menu;
use App\MenuItems;

class MenusController extends Controller
{
    
    protected $menu_rep;

    public function __construct(MenusRepository $menu_rep) {
        /*if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }*/

        $this->menu_rep = $menu_rep;
    }

    public function index($slug)
    {
        $menu = Menu::where('slug', (string)$slug)->first();
        if(!$menu) {
            abort(404, 'Нет такого меню');
        }

        $before = microtime(true);
        $temp = \Cache::remember('menu_client_' . $menu->id, 900, function() use ($slug) {
            return $this->menu_rep->get_items_for_client(Menu::where('slug', (string)$slug)->first());
        });
        $after = microtime(true);
        debug(($after-$before) * 1000 . " msec/serialize\n");

        return $temp;
    }
}
