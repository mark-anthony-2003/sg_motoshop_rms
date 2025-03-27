@extends('includes.app')

{{-- @section('content')
    <div class="app-content-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-4 fw-bold">SG MOTOSHOP</h3>
                </div>
                <div class="col-sm-12">
                    <h3 class="mb-4 fw-bold">Order Summary</h3>
                </div>
            </div>
        </div>
    </div>

    
@endsection --}}

@extends('includes.app')

@section('content')
    <div class="container mt-5">
        <h3 class="mb-4 fw-bold">Order Summary</h3>

        <p><strong>Shipment ID:</strong> {{ $shipment->shipment_id }}</p>
        <p><strong>Total Amount:</strong> ₱{{ number_format($shipment->total_amount, 2) }}</p>
        <p><strong>Payment Method:</strong> {{ ucfirst($shipment->payment_method) }}</p>
        <p><strong>Shipment Status:</strong> {{ ucfirst($shipment->shipment_status) }}</p>
    </div>
@endsection


