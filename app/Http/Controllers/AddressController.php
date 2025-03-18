<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    public function getCountries() {
        return response()->json([
            [
                'code' => 'PH',
                'name' => 'Philippines'
            ],
        ]);
    }

    public function getProvinces() {
        $res = Http::get("https://psgc.gitlab.io/api/provinces");
        return response()->json($res->json());
    }

    public function getStates($provinceCode) {
        $res = Http::get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities");
        return response()->json($res->json());
    }

    public function getBarangays($stateCode) {
        $res = Http::get("https://psgc.gitlab.io/api/cities-municipalities/{$stateCode}/barangays");
        return response()->json($res->json());
    }
}
