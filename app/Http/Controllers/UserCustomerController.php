<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserCustomerController extends Controller
{
    public function showCustomersTable()
    {
        $customers = User::where('user_type', 'customer')->get();
        return view('admin.user_management.customers.index', compact('customers'));
    }
}
