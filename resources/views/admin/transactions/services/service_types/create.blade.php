@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ isset($serviceType) ? 'Update Service Type' : 'New Service Type' }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"> <a href="{{ route('service-type-table') }}">Services</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Service Type</li>
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
                            <form action="{{ isset($serviceType) ? route('update-service-type', $serviceType->service_type_id) : route('store-service-type') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                    
                                <div class="mb-3">
                                    <label for="service_type_name" class="form-label">Service Type Name:</label>
                                    <input type="text" id="service_type_name" name="service_type_name" value="{{ old('service_type_name', $serviceType->service_type_name ?? '') }}" class="form-control">
                                    @error('service_type_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="service_type_price" class="form-label">Service Type Price:</label>
                                    <input type="number" id="service_type_price" name="service_type_price" value="{{ old('service_type_price', $serviceType->service_type_price ?? '') }}" class="form-control">
                                    @error('service_type_price')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="service_type_image" class="form-label">Service Type Image:</label>
                                    <input type="file" id="service_type_image" name="service_type_image" class="form-control">
                                    @if (isset($serviceType) && $serviceType->service_type_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $serviceType->service_type_image) }}" alt="{{ $serviceType->service_type_name }}" width="100" class="rounded">
                                        </div>
                                    @endif
                                    @error('service_type_image')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="service_status" class="form-label">Service Status:</label>
                                    <select name="service_status" id="service_status" class="form-select">
                                        <option value="available" {{ (old('service_status', $serviceType->service_status ?? '') == 'available') ? 'selected' : '' }}>Available</option>
                                        <option value="not_available" {{ (old('service_status', $serviceType->service_status ?? '') == 'not_available') ? 'selected' : '' }}>Not Available</option>
                                    </select>                                    
                                    @error('service_status')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                    
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($serviceType) ? 'Update Service Type' : 'Create Service Type' }}
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
