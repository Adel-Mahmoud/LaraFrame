<?php

namespace App\Domains\Settings\Controllers\Web;

use App\Http\Controllers\Controller;

class SettingEntityController extends Controller
{
    public function index()
    {
        return view('settings::web.index');
    }
}