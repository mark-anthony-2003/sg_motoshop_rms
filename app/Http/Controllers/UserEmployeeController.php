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

    public function showEmployeeProfile($userId)
    {
        $user = User::findOrFail($userId);
        return view('pages.user_profile.index', compact('user'));
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
}
