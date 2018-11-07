<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function get(Request $request)
    {
        $user = $request->user();

        $user->oauth = $user->isOAuth();

        return $user;
    }
}
