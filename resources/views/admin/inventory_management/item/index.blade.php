@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Items Table</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"> <a href="{{ route('items-table') }}">Items</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Items</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="mb-4">
                        <div class="card-header d-flex justify-content-end align-items-right">
                            <a href="{{ route('create-item') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> New Item
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No#</th>
                                        <th>Image</th>
                                        <th>Item Name</th>
                                        <th>Price</th>
                                        <th>Stocks</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($items as $index => $item)
                                        <tr class="align-middle">
                                            <td>{{ $index+1 }}</td>
                                            <td>
                                                @if ($item->item_image)
                                                    <img src="{{ asset('storage/' . $item->item_image) }}" alt="{{ $item->item_name }}" width="70">
                                                @else
                                                    No Image Available
                                                @endif
                                            </td>
                                            <td>{{ Str::title($item->item_name) }}</td>
                                            <td>₱{{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->stocks }}</td>
                                            <td>
                                                <span class="badge {{ $item->item_status === 'in_stock' ? 'text-bg-success' : 'text-bg-danger' }}">
                                                    {{ strtoupper(ucfirst(str_replace('_', ' ', $item->item_status))) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('show-item', $item->item_id) }}" class="btn btn-info btn-sm">
                                                    <i class="bi bi-info-circle"></i>
                                                </a>
                                                <a href="{{ route('edit-item', $item->item_id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('delete-item', $item) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Items Available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
