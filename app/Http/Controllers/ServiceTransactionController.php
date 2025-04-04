<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceTransaction;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ServiceTransactionController extends Controller
{
    public function showReservationForm()
    {
        $customer = Auth::user();
        $address = $customer->addresses;
        $serviceTypes = ServiceType::all();

        return view(
            'pages.reservation.index',
            compact('customer', 'address', 'serviceTypes')
        );
    }

    public function makeReservation(Request $request, $customerId)
    {
        $request->validate([
            'serviceTypes'      => 'required|array',
            'servicesTypes.*'   => 'exists:service_type_id,service_type_name',
            'parts'             => 'nullable|array',
            'parts.*'           => 'exists:part_id,part_name,',
            'payment_method'    => 'required|in:cash,gcash',
            'ref_no'            => 'nullable|string',
            'preferred_date'    => 'required|date'
        ]);

        $totalAmount = ServiceType::whereIn('service_type_id', $request->serviceTypes)
            ->sum('service_type_price');

        $service = Service::create([
            'total_amount'      => $totalAmount,
            'payment_method'    => $request->payment_method,
            'payment_status'    => 'pending',
            'ref_no'            => $request->ref_no,
            'preferred_date'    => $request->preferred_date 
        ]);

        ServiceTransaction::create([
            'user_id'       => Auth::id(),
            'service_id'    => $service->service_id,
            'employee_id'   => null
        ]);

        foreach ($request->serviceTypes as $serviceTypeId) {
            ServiceDetail::create([
                'service_id'        => $service->service_id,
                'service_type_id'   => $serviceTypeId,
                'part_id'           => null
            ]);
        }

        if ($request->has('parts')) {
            foreach ($request->parts as $partId) {
                ServiceDetail::create([
                    'service_id'        => $service->service_id,
                    'service_type_id'   => null,
                    'part_id'           => $partId
                ]);
            }
        }

        return redirect()->route('customer.profile', $customerId)->with('success', 'Reservation successful!');
    }
}
