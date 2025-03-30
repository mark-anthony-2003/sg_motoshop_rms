@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Employees Update Information</h3>
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
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5>Update Employee Information</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update.employeeInfo', $employee->employee_id) }}" method="POST">
                                @csrf

                                <!-- Position Type -->
                                <div class="mb-3">
                                    <label for="position_type_id" class="form-label">Position Type</label>
                                    <select name="position_type_id" id="position_type_id" class="form-control" required>
                                        @foreach ($positionTypes as $position)
                                            <option value="{{ $position->position_type_id }}"
                                                {{ $employee->position_type_id == $position->position_type_id ? 'selected' : '' }}>
                                                {{ ucfirst($position->position_type_name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Salary Type -->
                                <div class="mb-3">
                                    <label for="salary_type_id" class="form-label">Salary Type</label>
                                    <select name="salary_type_id" id="salary_type_id" class="form-control" required>
                                        @foreach ($salaryTypes as $salary)
                                            <option value="{{ $salary->salary_type_id }}"
                                                {{ $employee->salary_type_id == $salary->salary_type_id ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $salary->salary_type_name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Update Employee</button>
                                    <a href="{{ route('show-employeeInfo', $employee->employee_id) }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


