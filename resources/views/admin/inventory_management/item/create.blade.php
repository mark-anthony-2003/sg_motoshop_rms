@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ isset($item) ? 'Update Item' : 'New Item' }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"> <a href="{{ route('items-table') }}">Items</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Item</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="{{ isset($item) ? route('update-item', $item->item_id) : route('store-item') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                    
                                <div class="mb-3">
                                    <label for="item_name" class="form-label">Product Name:</label>
                                    <input type="text" id="item_name" name="item_name" value="{{ old('item_name', $item->item_name ?? '') }}" class="form-control">
                                    @error('item_name')
                                        <p style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="item_image" class="form-label">Item Image:</label>
                                    <input type="file" name="item_image" id="item_image" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price:</label>
                                    <input type="number" id="price" name="price" value="{{ old('price', $item->price ?? '') }}" class="form-control">
                                    @error('price')
                                        <p style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="stocks" class="form-label">Stocks:</label>
                                    <input type="number" id="stocks" name="stocks" value="{{ old('stocks', $item->stocks ?? '') }}" class="form-control">
                                    @error('stocks')
                                        <p style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="item_status" class="form-label">Item Status:</label>
                                    <select name="item_status" id="item_status" class="form-select">
                                        <option value="in_stock" {{ (old('item_status', $item->item_status ?? '') == 'in_stock') ? 'selected' : '' }}>In Stock</option>
                                        <option value="out_of_stock" {{ (old('item_status', $item->item_status ?? '') == 'out_of_stock') ? 'selected' : '' }}>Out of Stock</option>
                                    </select>
                                    @error('item_status')
                                        <p style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                    
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($item) ? 'Update Item' : 'Create Item' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
