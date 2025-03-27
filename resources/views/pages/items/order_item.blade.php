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
            <div class="row justify-content-center">
                <div class="col-md-6">
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
                                        <span class="badge {{ $orderItemId->item_status === 'in_stock' ? 'text-bg-success' : 'text-bg-danger' }}">
                                            {{ ucfirst(str_replace('_', ' ', $orderItemId->item_status)) }}
                                        </span>
                                    </p>

                                    <form action="{{ route('shop.addToCartItem', $orderItemId->item_id) }}" method="POST" class="d-flex align-items-center gap-2">
                                        @csrf
                                        <div class="input-group" style="width: auto;">
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(-1)" {{ $orderItemId->item_status === 'out_of_stock' ? 'disabled' : '' }}>-</button>
                                            <input type="number" id="quantity" name="quantity" class="form-control text-center" style="max-width: 70px;" min="1" max="{{ $orderItemId->stocks }}" value="1" required>
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(1)" {{ $orderItemId->item_status === 'out_of_stock' ? 'disabled' : '' }}>+</button>
                                        </div>
                                    
                                        <button type="submit" class="btn btn-dark btn-md" {{ $orderItemId->item_status === 'out_of_stock' ? 'disabled' : '' }}>Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeQuantity(amount) {
            const quantityInput = document.getElementById('quantity')
            if (!quantityInput) return

            let currentValue = parseInt(quantityInput.value) || 1
            const max = parseInt(quantityInput.max) || Infinity
            const min = parseInt(quantityInput.min) || 1

            currentValue += amount;
            if (currentValue < min) currentValue = min
            if (currentValue > max) currentValue = max

            quantityInput.value = currentValue
        }

    </script>
@endsection
