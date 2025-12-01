<?php

namespace App\Domains\Reservations\Controllers\Web;

use App\Http\Controllers\Controller;

class ReservationEntityController extends Controller
{
    public function index()
    {
        return view('reservations::web.index');
    }
}