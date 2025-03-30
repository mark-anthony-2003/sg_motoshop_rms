<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PositionType;
use App\Models\SalaryType;
use App\Models\User;
use Illuminate\Http\Request;

class UserEmployeeController extends Controller
{
    public function showEmployeesTable()
    {
        $employees = Employee::with(['salaryType', 'positionType'])->get();
        return view('admin.user_management.employees.index', compact('employees'));
    }

    public function showEmployeeProfile($userId)
    {
        $user = User::findOrFail($userId);
        return view('pages.profile.index', compact('user'));
    }

    public function updateEmployeeProfile(Request $request, $employeeId)
    {
        $employee = User::findOrFail($employeeId);

        $validated = $request->validate([
            'first_name'    => 'required|string|max:225',
            'last_name'     => 'required|string|max:225',
            'date_of_birth' => 'nullable|date',
            'contact_no'    => 'nullable|string|max:20',
            'user_image'    => 'nullable|image|mimes:png,jpg|max:5000',
            'country'       => 'required|string|max:100',
            'province'      => 'required|string|max:100',
            'city'          => 'required|string|max:100',
            'barangay'      => 'required|string|max:100',
            'address_type'  => 'required|in:home,work'
        ]);

        $userImagePath = $employee->user_image;
        if ($request->hasFile('user_image')) {
            $userImagePath = $request->file('user_image')->store('user_images', 'public');
        }

        $employee->update([
            'first_name'    => $validated['first_name'],
            'last_name'     => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'] ?? $employee->date_of_birth,
            'contact_no'    => $validated['contact_no'] ?? $employee->contact_no,
            'user_image'    => $userImagePath,
        ]);
        $employee->addresses()->updateOrCreate(
            ['address_type' => $validated['address_type']],
            [
                'barangay' => $validated['barangay'],
                'city'     => $validated['city'],
                'province' => $validated['province'],
                'country'  => $validated['country'],
            ]
        );

        return redirect()->route('employee.profile', $employeeId)->with('success', 'Profile updated successfully!');
    }

    public function adminShowEmployeeInfo($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        return view('admin.user_management.employees.show', compact('employee'));
    }

    public function adminEditEmployeeInfo($employeeId)
    {
        $employee = Employee::where('employee_id', $employeeId)->firstOrFail();
        $positionTypes = PositionType::all();
        $salaryTypes = SalaryType::all();

        return view('admin.user_management.employees.create', compact('employee', 'positionTypes', 'salaryTypes'));
    }

    public function adminUpdateEmployeeInfo(Request $request, $employeeId)
    {
        $employee = Employee::findOrFail($employeeId);

        $validated = $request->validate([
            'position_type_id'    => 'required|exists:position_types,position_type_id',
            'salary_type_id'      => 'required|exists:salary_types,salary_type_id',
        ]);

        $employee->update([
            'position_type_id'    => $validated['position_type_id'],
            'salary_type_id'      => $validated['salary_type_id']
        ]);

        return redirect()->route('show-employeeInfo', $employeeId)->with('success', 'Employee Information updated successfully!');
    }
}
