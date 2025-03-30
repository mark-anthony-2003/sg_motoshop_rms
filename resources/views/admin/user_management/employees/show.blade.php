@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Employees Information</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin-dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Employees</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container">
            <div class="row align-items-center">
                <!-- Profile Image -->
                <div class="col-sm-2 text-center">
                    <div class="rounded-circle d-flex justify-content-center align-items-center overflow-hidden"
                        style="width: 100px; height: 100px; font-size: 24px; background-color: #6c757d; color: white;">
                        @if($employee->user->user_image)
                            <img src="{{ asset('storage/' . $employee->user->user_image) }}" 
                                 alt="User Image" class="img-fluid" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ strtoupper($employee->user->first_name[0]) }}{{ strtoupper($employee->user->last_name[0]) }}
                        @endif
                    </div>
                </div>

                <!-- Employee Details -->
                <div class="col-sm-10">
                    <h2>{{ Str::title($employee->user->first_name) }} {{ Str::title($employee->user->last_name) }}</h2>
                    <p>{{ $employee->user->email }}</p>

                    @if($employee->user->addresses->isNotEmpty())
                        @php $address = $employee->user->addresses->first(); @endphp
                        <p>
                            {{ $address->barangay }},
                            {{ $address->city }},
                            {{ $address->province }},
                            {{ $address->country }}
                        </p>
                    @else
                        <p>No address available</p>
                    @endif

                    <div class="mt-2">
                        <strong>Position:</strong> {{ Str::title(optional($employee->positionType)->position_type_name) ?? 'Not Assigned' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
