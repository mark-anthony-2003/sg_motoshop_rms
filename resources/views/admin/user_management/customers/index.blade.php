@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Customers Table</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"> <a href="{{ route('admin-dashboard') }}">Dashboard</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Customers</li>
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
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $index => $customer)
                                        <tr class="align-middle">
                                            <td>{{ $index+1 }}</td>
                                            <td>
                                                @if ($customer->user_image)
                                                    <img src="{{ asset('storage/' . $customer->user_image) }}" alt="{{ $customer->user_name }}" width="70">
                                                @else
                                                    No Image Available
                                                @endif
                                            </td>
                                            <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>
                                                <span class="badge 
                                                    {{ $customer->account_status === 'active' ? 'text-bg-success' : 
                                                       ($customer->account_status === 'inactive' ? 'text-bg-warning' : 'text-bg-danger') }}">
                                                    {{ strtoupper(ucfirst(str_replace('_', ' ', $customer->account_status))) }}
                                                </span>
                                            </td>                                            
                                            <td class="text-center">
                                                {{-- <a href="{{ route('show-item', $item->item_id) }}" class="btn btn-info btn-sm">
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
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Customers Available</td>
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

