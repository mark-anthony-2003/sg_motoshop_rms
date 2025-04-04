@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Services Table</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"> <a href="{{ route('admin-dashboard') }}">Dashboard</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Services</li>
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
                            <a href="{{ route('create-service-type') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> New Service Type
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No#</th>
                                        <th>Image</th>
                                        <th>Service Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($serviceTypes as $index => $serviceType)
                                        <tr class="align-middle">
                                            <td>{{ $index+1 }}</td>
                                            <td>
                                                @if ($serviceType->service_type_image)
                                                    <img src="{{ asset('storage/' . $serviceType->service_type_image) }}" alt="{{ $serviceType->service_type_name }}" width="70">
                                                @else
                                                    No Image Available
                                                @endif
                                            </td>
                                            <td>{{ $serviceType->service_type_name }}</td>
                                            <td>{{ number_format($serviceType->service_type_price, 2) }}</td>
                                            <td>
                                                <span class="badge {{ $serviceType->service_type_status === 'available' ? 'text-bg-success' : 'text-bg-danger' }}">
                                                    {{ strtoupper(ucfirst(str_replace('_', ' ', $serviceType->service_type_status))) }}
                                                </span>
                                            </td>                                            
                                            <td class="text-center">
                                                <a href="{{ route('edit-service-type', $serviceType->service_type_id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('delete-service-type', $serviceType) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Services Available</td>
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