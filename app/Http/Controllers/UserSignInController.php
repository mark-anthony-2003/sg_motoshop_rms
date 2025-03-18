<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSignInController extends Controller
{
    public function showCustomerForm()
    {
        $userType = 'customer';
        return view('pages.auth.signin', compact('userType'));
    }

    public function showEmployeeForm()
    {
        $userType = 'employee';
        return view('pages.auth.signin', compact('userType'));
    }

    public function signIn(Request $request)
    {
        $request->validate([
            'email'      => 'required|email',
            'password'   => 'required',
            'user_type'  => 'required|in:customer,employee'
        ]);

        $user = User::where('email', $request->email)
                    ->where('user_type', $request->user_type)
                    ->first();
        
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            if ($user->user_type === 'employee') {
                return redirect()->route('admin-dashboard');
            }
            return redirect()->route('home-page');
        }
        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }
}
