<?php

namespace App\Domains\Dashboards\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardEntityController extends Controller
{
    public function index()
    {
        return view('dashboards::admin.index');
    }
}