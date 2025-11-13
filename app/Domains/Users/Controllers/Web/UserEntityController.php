<?php

namespace App\Domains\Users\Controllers\Web;

use App\Http\Controllers\Controller;

class UserEntityController extends Controller
{
    public function index()
    {
        return view('users::web.index');
    }
}