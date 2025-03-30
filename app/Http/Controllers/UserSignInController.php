<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSignInController extends Controller
{
    public function showCustomerForm()
    {
        if (Auth::check()) {
            return redirect()->route('home-page');
        }
        $userType = 'customer';
        return view('pages.auth.signin', compact('userType'));
    }

    public function showEmployeeForm()
    {
        return view('pages.auth.employee.index');
    }

    public function showAdminForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin-dashboard');
        }
        $userType = 'admin';
        return view('pages.auth.signin', compact('userType'));
    }

    public function signIn(Request $request)
    {
        $request->validate([
            'email'      => 'required|email',
            'password'   => 'required',
            'user_type'  => 'required|in:customer,employee,admin'
        ]);

        $user = User::where('email', $request->email)
                    ->where('user_type', $request->user_type)
                    ->first();
        
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            if ($user->user_type === 'admin') {
                return redirect()->route('admin-dashboard');
            }
            return redirect()->route('home-page');
        }
        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function showEmployeeManagerForm()
    {
        if (Auth::check()) {
            return redirect()->route('home-page');
        }
        $employeeType = 'manager';
        return view('pages.auth.employee.signin', compact('employeeType'));
    }

    public function showEmployeeLaborerForm()
    {
        if (Auth::check()) {
            return redirect()->route('home-page');
        }
        $employeeType = 'laborer';
        return view('pages.auth.employee.signin', compact('employeeType'));
    }

    public function employeeSignin(Request $request)
    {
        $credentials = $request->validate([
            'email'                 => 'required|email',
            'password'              => 'required',
            'employee_type_name'    => 'required|in:manager,laborer'
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'], 
            'password' => $credentials['password']
        ])) {
            $user = Auth::user();

            // Check if the user is an employee
            $employee = Employee::where('user_id', $user->user_id)
                ->whereHas('positionType', function($query) use ($credentials) {
                    $query->where('position_type_name', $credentials['employee_type_name']);
                })
                ->first();

                if ($employee) {
                    $positionType = $employee->positionType->position_type_name;
                    Log::info('Employee verified', ['employee_id' => $employee->employee_id, 'position_type' => $positionType]);
        
                    if ($positionType === 'manager') {
                        return redirect()->route('manager-homepage');
                    } elseif ($positionType === 'laborer') {
                        return redirect()->route('laborer-homepage');
                    }
                }
        
                Auth::logout();
                return redirect()->back()->withErrors(['employee_type_name' => 'Unauthorized access for this employee type.']);
        }
        Log::error('Invalid credentials', ['email' => $credentials['email']]);
        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }
}
