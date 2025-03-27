@extends('includes.app')

<style>
    .popular-item .hover-card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease; }

    .popular-item .popular-card {
        border-radius: 12px;
        overflow: hidden; }

    .popular-item .popular-card .card-img-top {
        object-fit: cover;
        height: 180px; }

    .order-item .card {
        border-radius: 12px;
        overflow: hidden; }

    .order-item img {
        object-fit: cover;
        max-width: 100%; }
</style>

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
                    <div class="card shadow order-item">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-5 text-center">
                                    @if ($orderItemId->item_image)
                                        <img 
                                            src="{{ asset('storage/' . $orderItemId->item_image) }}"
                                            alt="{{ $orderItemId->item_name }}"
                                            class="img-fluid rounded shadow"
                                            width="250">
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
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeItemQuantity(-1)" {{ $orderItemId->item_status === 'out_of_stock' ? 'disabled' : '' }}>-</button>
                                            <input type="number" id="quantity" name="quantity" class="form-control text-center" style="max-width: 70px;" min="1" max="{{ $orderItemId->stocks }}" value="1" required>
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeItemQuantity(1)" {{ $orderItemId->item_status === 'out_of_stock' ? 'disabled' : '' }}>+</button>
                                        </div>
                                    
                                        <button type="submit" class="btn btn-dark btn-md" {{ $orderItemId->item_status === 'out_of_stock' ? 'disabled' : '' }}>Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-4 popular-item">
                <div class="col-sm-12">
                    <h3 class="mb-4 fw-bold">You might also like</h3>
                </div>

                @forelse ($popularItems as $popularItem)
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                        <a href="{{ route('shop.showOrderItem', $popularItem->item_id) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm hover-card popular-card">
                                @if ($popularItem->item_image)
                                    <img src="{{ asset('storage/' . $popularItem->item_image) }}" 
                                        class="card-img-top" 
                                        alt="{{ $popularItem->item_name }}">
                                @else
                                    <div class="text-center py-3">No Image Available</div>
                                @endif
                                <div class="card-body d-flex flex-column text-dark">
                                    <h5 class="card-title">{{ Str::title($popularItem->item_name) }}</h5>
                                    <p class="fw-bold mb-1">₱{{ number_format($popularItem->price, 2) }}</p>
                                    <p><span class="badge bg-info text-dark">{{ $popularItem->sold }} sold</span></p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>No items available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <script>
        function changeItemQuantity(amount) {
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
