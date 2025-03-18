@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Item Detail</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"> <a href="{{ route('items-table') }}">Items</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Item Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-5 text-center">
                                    @if ($item->item_image)
                                        <img src="{{ asset('storage/' . $item->item_image) }}" alt="{{ $item->item_name }}" class="img-fluid rounded shadow" width="250">
                                    @else
                                        <p>No Image Available</p>
                                    @endif
                                </div>
                                <div class="col-md-7">
                                    <h3><strong>Name:</strong> {{ $item->item_name }}</h3>
                                    <p><strong>Price:</strong> ₱{{ number_format($item->price, 2) }}</p>
                                    <p><strong>Stocks:</strong> {{ $item->stocks ?? 'Not Specified' }}</p>
                                    <p>
                                        <strong>Product Status:</strong>
                                        <span class="badge {{ $item->item_status === 'in_stock' ? 'text-bg-success' : 'text-bg-danger' }}">
                                            {{ ucfirst(str_replace('_', ' ', $item->item_status)) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection
