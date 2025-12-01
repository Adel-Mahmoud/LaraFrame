<?php

namespace App\Domains\Reservations\Controllers\Admin;

use App\Http\Controllers\Controller;

class ReservationEntityController extends Controller
{
    public function index()
    {
        return view('reservations::admin.index');
    }
}