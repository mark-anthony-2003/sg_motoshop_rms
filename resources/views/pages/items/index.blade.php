@extends('includes.app')

<style>
    .hover-card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease; }

    .card {
        border-radius: 12px;
        overflow: hidden; }

    .card-img-top {
        object-fit: cover;
        height: 180px; }
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
            <div class="row g-3 mb-4">
                @forelse ($items as $item)
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <a href="{{ route('shop.showOrderItem', $item->item_id) }}" class="text-decoration-none">
                            <div class="card h-100 shadow-sm hover-card">
                                @if ($item->item_image)
                                    <img src="{{ asset('storage/' . $item->item_image) }}" 
                                        class="card-img-top" 
                                        alt="{{ $item->item_name }}">
                                @else
                                    <div class="text-center py-3">No Image Available</div>
                                @endif
                                <div class="card-body d-flex flex-column text-dark">
                                    <h5 class="card-title">{{ Str::title($item->item_name) }}</h5>
                                    <p class="fw-bold mb-1">₱{{ number_format($item->price, 2) }}</p>
                                    <p><span class="badge bg-info text-dark">{{ $item->sold }} sold</span></p>
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
@endsection
