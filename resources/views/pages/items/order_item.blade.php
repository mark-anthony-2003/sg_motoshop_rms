@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-4 fw-bold">SG MOTOSHOP</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container">
            <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-5 text-center">
                                @if ($orderItemId->item_image)
                                    <img src="{{ asset('storage/' . $orderItemId->item_image) }}" alt="{{ $orderItemId->item_name }}" class="img-fluid rounded shadow" width="250">
                                @else
                                    <p>No Image Available</p>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <h3><strong> {{ Str::title($orderItemId->item_name) }} </strong></h3>
                                <p><strong> ₱{{ number_format($orderItemId->price, 2) }} </strong></p>
                                <p><span class="badge bg-info text-dark">{{ $orderItemId->sold }} sold</span></p>
                                <p>
                                    <strong>Item Status:</strong>
                                    <span class="badge {{ $orderItemId->item_status === 'in_stock' ? 'text-bg-success' : 'text-bg-danger' }}">
                                        {{ ucfirst(str_replace('_', ' ', $orderItemId->item_status)) }}
                                    </span>
                                </p>

                                <form action="{{ route('shop.addToCartItem', $orderItemId->item_id) }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity:</label>
                                        <input type="number" id="quantity" name="quantity" class="form-control" min="1" max="{{ $orderItemId->stocks }}" value="1" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm" {{ $orderItemId->item_status === 'out_of_stock' ? 'disabled' : '' }}>Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
