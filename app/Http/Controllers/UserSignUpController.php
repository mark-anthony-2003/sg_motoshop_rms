<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserSignUpController extends Controller
{
    public function showCustomerForm()
    {
        $userType = 'customer';
        return view('pages.auth.signup', compact('userType'));
    }

    public function signUp(Request $request) {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'account_status' => 'active',
            'user_type' => 'customer',
        ]);

        return redirect()->route('sign-in.selection')->with('success', 'Account created successfully!');
    }
}
