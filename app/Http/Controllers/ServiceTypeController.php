<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function showServiceTypesTable()
    {
        $serviceTypes = ServiceType::all();
        return view('admin.transactions.services.service_types.index', compact('serviceTypes'));
    }

    public function showServiceTypeForm()
    {
        return view('admin.transactions.services.service_types.create');
    }

    public function editServiceType(ServiceType $serviceType)
    {
        return view('admin.transactions.services.service_types.create', compact('serviceType'));
    }

    public function storeServiceType(Request $request)
    {
        $validated = $request->validate([
            'service_type_name'     => 'required|string|max:100',
            'service_type_price'    => 'required|integer',
            'service_type_image'    => 'nullable|image|mimes:png,jpg|max:5000',
            'service_status'        => 'required|in:available,not_available'
        ]);

        $serviceTypeImage = null;
        if ($request->hasFile('service_type_image')) {
            $serviceTypeImage = $request->file('service_type_image')->store('service_type_images', 'public');
        }

        $serviceType = ServiceType::create([
            'service_type_name'     => $validated['service_type_name'],
            'service_type_price'    => $validated['service_type_price'],
            'service_type_image'    => $serviceTypeImage,
            'service_status'        => $validated['service_status']
        ]);

        if (!$serviceType) {
            return redirect()->back()->withErrors(['error' => 'Failed to store service type.']);
        }

        return redirect()->route('service-type-table')->with('success', 'Service Type created successfully');
    }

    public function updateServiceType(Request $request, ServiceType $serviceType)
    {
        $validated = $request->validate([
            'service_type_name'     => 'required|string|max:100',
            'service_type_price'    => 'required|integer',
            'service_type_image'    => 'nullable|image|mimes:png,jpg|max:5000',
            'service_status'        => 'required|in:available,not_available'
        ]);

        $serviceTypeImage = $serviceType->service_type_image;
        if ($request->hasFile('service_type_image')) {
            $serviceTypeImage = $request->file('service_type_image')->store('service_type_images', 'public');
        }

        $serviceType->update([
            'service_type_name'     => $validated['service_type_name'],
            'service_type_image'    => $serviceTypeImage,
            'service_type_price'    => $validated['service_type_price'],
            'service_status'        => $validated['service_status']
        ]);

        return redirect()->route('service-type-table')->with('success', 'Service Type updated successfully');
    }

    public function deleteServiceType(ServiceType $serviceType)
    {
        $serviceType->delete();
        return redirect()->route('service-type-table')->with('success', 'Service Type delete successfully');
    }
}
