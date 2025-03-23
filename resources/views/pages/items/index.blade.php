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
                @forelse ($items as $item)
                    <div class="col-md-4 col-sm-6 col-lg-3">
                        <div class="card h-100 shadow-sm">
                            @if ($item->item_image)
                                <img src="{{ asset('storage/' . $item->item_image) }}"
                                    class="card-img-top"
                                    alt="{{ $item->item_name }}">
                            @else
                                No Image Available
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ Str::title($item->item_name) }}</h5>
                                <p class="fw-bold">₱{{ number_format($item->price, 2) }}</p>
                                <p><span class="badge bg-info text-dark">{{ $item->sold }} sold</span></p>
                                <a href="{{ route('shop.showOrderItem', $item->item_id) }}" class="btn btn-primary btn-sm mt-auto">Order Item</a>
                            </div>
                        </div>
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
