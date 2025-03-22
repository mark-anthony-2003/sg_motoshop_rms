<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserEmployeeController extends Controller
{
    public function showEmployeesTable()
    {
        $employees = User::where('user_type', 'employee')->get();
        return view('admin.user_management.employees.index', compact('employees'));
    }

    public function showEmployeeProfile($employeeId)
    {
        $employee = User::where('user_type', 'employee')->find($employeeId);
        if (!$employee) {
            abort(404, 'Employee not found');
        }
        return view('pages.user_profile.index', compact('employee'));
    }
}
