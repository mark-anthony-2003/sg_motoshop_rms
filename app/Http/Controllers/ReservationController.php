<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function showReservationForm()
    {
        return view('pages.reservation.index');
    }

    public function createReservation(Request $request)
    {
        // 

        return view('pages.reservation.index');
    }
}
