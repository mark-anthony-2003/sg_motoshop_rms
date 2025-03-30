@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Employees Table</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"> <a href="{{ route('admin-dashboard') }}">Dashboard</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Employees</li>
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
                            <a href="#" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> New Employee
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($employees as $index => $employee)
                                        <tr class="align-middle">
                                            <td>{{ $index+1 }}</td>
                                            <td>
                                                @if ($employee->user_image)
                                                    <img src="{{ asset('storage/' . $employee->user->user_image) }}" alt="{{ $employee->user->user_id }}" width="70">
                                                @else
                                                    No Image Available
                                                @endif
                                            </td>
                                            <td>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</td>
                                            <td>{{ $employee->user->email }}</td>
                                            <td>{{ Str::title($employee->positionType->position_type_name) }}</td>
                                            <td>
                                                <span class="badge 
                                                    {{ $employee->user->account_status === 'active' ? 'text-bg-success' : 
                                                       ($employee->user->account_status === 'inactive' ? 'text-bg-warning' : 'text-bg-danger') }}">
                                                    {{ strtoupper(ucfirst(str_replace('_', ' ', $employee->user->account_status))) }}
                                                </span>
                                            </td>                                            
                                            <td class="text-center">
                                                <a href="{{ route('show-employeeInfo', $employee->employee_id) }}" class="btn btn-info btn-sm">
                                                    <i class="bi bi-info-circle"></i>
                                                </a>
                                                <a href="{{ route('edit.employeeInfo', $employee->employee_id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="#" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Employees Available</td>
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

