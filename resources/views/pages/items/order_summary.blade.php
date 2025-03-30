@extends('includes.app')

@section('content')
    <div class="app-content-header py-4 bg-light border-bottom">
        <div class="container">
            <h2 class="fw-bold mb-0">SG MOTOSHOP</h2>
        </div>
    </div>

    <div class="app-content py-5">
        <div class="container">
            {{-- Customer Information --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h4 class="fw-semibold mb-3">Customer Information</h4>
                    <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                    <p><strong>Contact No:</strong> {{ $user->contact_no }}</p>

                    @if($user->addresses->first())
                        <p><strong>Address:</strong> 
                            {{ $user->addresses->first()->barangay }},
                            {{ $user->addresses->first()->city }},
                            {{ $user->addresses->first()->province }},
                            {{ $user->addresses->first()->country }}
                        </p>
                    @else
                        <p class="text-muted">No address available</p>
                    @endif
                </div>
            </div>

            <div class="row g-4">
                {{-- Order Items --}}
                <div class="col-md-7">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            @foreach ($carts as $cart)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3" style="min-width: 80px;">
                                        <img src="{{ asset('storage/' . $cart->item->item_image) }}" alt="{{ $cart->item->item_name }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">{{ Str::title($cart->item->item_name) }}</h5>
                                        <p class="mb-1"><strong>Quantity:</strong> {{ $cart->quantity }}</p>
                                        <p class="mb-1"><strong>Subtotal:</strong> ₱{{ number_format($cart->sub_total, 2) }}</p>d
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="col-md-5">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h4 class="fw-semibold mb-3">Order Summary</h4>
                            <div class="mt-4 d-flex justify-content-between">
                                <strong>Subtotal:</strong>
                                <span>₱{{ number_format($totalAmount, 2) }}</span>
                            </div>
                            <div class="mt-4 d-flex justify-content-between">
                                <strong>Total</strong>
                                <span class="fw-bold">₱{{ number_format($totalAmount, 2) }}</span>
                            </div>

                            {{-- Payment Method --}}
                            <h4 class="fw-semibold mt-3">Payment Method</h4>
                            <div class="d-flex flex-column gap-1 mb-2">
                                <form action="{{ route('payment.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">
                                    <div class="d-flex flex-column gap-1 mb-2">
                                        <label class="d-flex align-items-center gap-2">
                                            <input type="radio" name="payment_method" value="gcash" required>
                                            <span>Gcash</span>
                                        </label>
                                        <label class="d-flex align-items-center gap-2">
                                            <input type="radio" name="payment_method" value="cash_on_delivery" required>
                                            <span>Cash on Delivery</span>
                                        </label>
                                    </div>
                                    {{-- Checkout Button --}}
                                    <div class="text-end mt-4">
                                        Total ({{ count($selectedItems) }} items)
                                        <button type="submit" class="btn btn-dark btn-md">Place Order</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
