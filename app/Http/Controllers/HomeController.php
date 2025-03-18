<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function popularItems()
    {
        $items = Item::all();
        return view('pages.auth.index', compact('items'));
    }

    public function popularServices()
    {
        $serviceTypes = ServiceType::all();
        return view('pages.auth.index', compact('serviceTypes'));
    }
}
