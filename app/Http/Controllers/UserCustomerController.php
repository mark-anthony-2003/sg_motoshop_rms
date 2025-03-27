<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;

class UserCustomerController extends Controller
{
    public function showCustomersTable()
    {
        $customers = User::where('user_type', 'customer')->get();
        return view('admin.user_management.customers.index', compact('customers'));
    }

    public function showCustomerProfile($userId)
    {
        $user = User::findOrFail($userId);
        return view('pages.profile.index', compact('user'));
    }

    public function updateCustomerProfile(Request $request, $customerId)
    {
        $customer = User::findOrFail($customerId);

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

        $userImagePath = $customer->user_image;
        if ($request->hasFile('user_image')) {
            $userImagePath = $request->file('user_image')->store('user_images', 'public');
        }

        $customer->update([
            'first_name'    => $validated['first_name'],
            'last_name'     => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'] ?? $customer->date_of_birth,
            'contact_no'    => $validated['contact_no'] ?? $customer->contact_no,
            'user_image'    => $userImagePath
        ]);
        $customer->addresses()->updateOrCreate(
            ['address_type' => $validated['address_type']],
            [
                'barangay' => $validated['barangay'],
                'city'     => $validated['city'],
                'province' => $validated['province'],
                'country'  => $validated['country'],
            ]
        );

        return redirect()->route('customer.profile', $customerId)->with('success', 'Profile updated successfully!');
    }

}
