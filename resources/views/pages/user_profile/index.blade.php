@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-1 text-center">
                    <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center"
                        style="width: 80px; height: 80px; font-size: 24px;">
                        {{ strtoupper($user->first_name[0]) }}{{ strtoupper($user->last_name[0]) }}
                    </div>
                </div>
                <div class="col-sm-11">
                    <h2>{{ ucfirst(strtolower($user->first_name)) }} {{ ucfirst(strtolower($user->last_name)) }}</h2>
                    <p>{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container">
            <div class="row">
                <!-- Left Sidebar - Vertical Tabs -->
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills bg-light p-3 rounded" id="v-pills-tab" role="tablist">
                        <a class="nav-link active" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings"
                           role="tab" aria-controls="v-pills-settings" aria-selected="true">
                            <i class="bi bi-gear"></i> User Settings
                        </a>
                        <a class="nav-link" id="v-pills-orders-tab" data-bs-toggle="pill" href="#v-pills-orders"
                           role="tab" aria-controls="v-pills-orders" aria-selected="false">
                            <i class="bi bi-cart"></i> Orders History
                        </a>
                        <a class="nav-link" id="v-pills-reservations-tab" data-bs-toggle="pill" href="#v-pills-reservations"
                           role="tab" aria-controls="v-pills-reservations" aria-selected="false">
                            <i class="bi bi-calendar-check"></i> Reservations History
                        </a>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="col-md-9">
                    <div class="tab-content bg-white p-4 rounded shadow-sm" id="v-pills-tabContent">
                        <!-- User Settings -->
                        <div class="tab-pane fade show active" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <form action="{{ $user->user_type === 'employee' ? route('employee.profile_update', $user->user_id) : route('customer.profile_update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row g-3">
                                    <h4>User Settings</h4>

                                    <div class="col-md-4">
                                        <label for="user_image" class="form-label">Profile Image</label>
                                        <input type="file" name="user_image" class="form-control">
                                        @if($user->user_image)
                                            <img src="{{ asset('storage/' . $user->user_image) }}" alt="User Image" width="100">
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="contact_no" class="form-label">Contact Number</label>
                                        <input type="text" name="contact_no" class="form-control" value="{{ old('contact_no', $user->contact_no) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                    </div>
                                </div>

                                <h4 class="my-3">Address</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="country" class="form-label">Country</label>
                                        <select name="country" id="country" class="form-control">
                                            <option value="{{ old('country', $user->addresses->first()->country ?? 'Philippines') }}" selected>
                                                {{ old('country', $user->addresses->first()->country ?? 'Philippines') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="province" class="form-label">State/Province</label>
                                        <select name="province" id="province" class="form-control">
                                            <option value="{{ old('province', $user->addresses->first()->province ?? '') }}" selected>
                                                {{ old('province', $user->addresses->first()->province ?? 'Select State/Province') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="city" class="form-label">City/Town/Municipality</label>
                                        <select name="city" id="city" class="form-control">
                                            <option value="{{ old('city', $user->addresses->first()->city ?? '') }}" selected>
                                                {{ old('city', $user->addresses->first()->city ?? 'Select City/Town/Municipality') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="barangay" class="form-label">Street/Barangay</label>
                                        <select name="barangay" id="barangay" class="form-control">
                                            <option value="{{ old('barangay', $user->addresses->first()->barangay ?? '') }}" selected>
                                                {{ old('barangay', $user->addresses->first()->barangay ?? 'Select Street/Barangay') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="address_type" class="form-label">Address Type</label>
                                        <select name="address_type" id="address_type" class="form-control">
                                            <option value="{{ old('address_type', $user->addresses->first()->address_type ?? '') }}" selected>
                                                {{ ucfirst(old('address_type', $user->addresses->first()->address_type ?? 'Select Address Type')) }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>

                        <!-- Orders History -->
                        <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                            <h4>Orders History</h4>
                            <p>View your past orders here.</p>
                        </div>

                        <!-- Reservations History -->
                        <div class="tab-pane fade" id="v-pills-reservations" role="tabpanel" aria-labelledby="v-pills-reservations-tab">
                            <h4>Reservations History</h4>
                            <p>View your past reservations here.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // $(document).ready(function () {
        //     $('#province').append('<option>Loading...</option>')

        //     // Fetch Provinces
        //     $.get('/address/provinces', function(data) {
        //         $('#province').empty().append('<option>Select State/Province</option>')
        //         data.forEach(function(item) {
        //             $('#province').append(`<option value="${item.code}" data-code="${item.code}">${item.name}</option>`)
        //         })
        //     }).fail(function() {
        //         alert("Failed to load provinces.")
        //     });

        //     // Fetch Cities
        //     $('#province').change(function () {
        //         var provinceCode = $(this).val()
        //         $('#city').html('<option>Loading...</option>')
        //         $('#barangay').html('<option>Select Barangay</option>')

        //         $.get(`/address/cities/${provinceCode}`, function(data) {
        //             $('#city').empty().append('<option>Select City/Town/Municipality</option>')
        //             data.forEach(function(item) {
        //                 $('#city').append(`<option value="${item.code}" data-code="${item.code}">${item.name}</option>`)
        //             })
        //         }).fail(function() {
        //             alert("Failed to load cities.")
        //         });
        //     });

        //     // Fetch Barangays
        //     $('#city').change(function() {
        //         var cityCode = $(this).val()
        //         $('#barangay').html('<option>Loading...</option>')

        //         $.get(`/address/barangays/${cityCode}`, function(data) {
        //             $('#barangay').empty().append('<option>Select Barangay</option>')
        //             data.forEach(function(item) {
        //                 $('#barangay').append(`<option value="${item.name}">${item.name}</option>`)
        //             })
        //         }).fail(function() {
        //             alert("Failed to load barangays.")
        //         })
        //     })
        // })
        $(document).ready(function () {
            const userProvince = "{{ old('province', $user->addresses->first()->province ?? '') }}"
            const userCity = "{{ old('city', $user->addresses->first()->city ?? '') }}"
            const userBarangay = "{{ old('barangay', $user->addresses->first()->barangay ?? '') }}"

            // Fetch Provinces
            $.get('/address/provinces', function(data) {
                $('#province').empty().append('<option>Select State/Province</option>')
                data.forEach(function(item) {
                    const selected = item.code == userProvince ? 'selected' : ''
                    $('#province').append(`<option value="${item.code}" ${selected}>${item.name}</option>`)
                });
            }).fail(function() {
                alert("Failed to load provinces.")
            });

            // Fetch Cities on Province Change
            $('#province').change(function () {
                const provinceCode = $(this).val()
                $('#city').html('<option>Loading...</option>')
                $('#barangay').html('<option>Select Barangay</option>')

                $.get(`/address/cities/${provinceCode}`, function(data) {
                    $('#city').empty().append('<option>Select City/Town/Municipality</option>')
                    data.forEach(function(item) {
                        const selected = item.code == userCity ? 'selected' : ''
                        $('#city').append(`<option value="${item.code}" ${selected}>${item.name}</option>`);
                    });
                }).fail(function() {
                    alert("Failed to load cities.")
                });
            });

            // Trigger city load if a province is already selected
            if (userProvince) {
                $('#province').trigger('change')
            }

            // Fetch Barangays on City Change
            $('#city').change(function() {
                const cityCode = $(this).val()
                $('#barangay').html('<option>Loading...</option>')

                $.get(`/address/barangays/${cityCode}`, function(data) {
                    $('#barangay').empty().append('<option>Select Barangay</option>')
                    data.forEach(function(item) {
                        const selected = item.code == userBarangay ? 'selected' : ''
                        $('#barangay').append(`<option value="${item.code}" ${selected}>${item.name}</option>`)
                    });
                }).fail(function() {
                    alert("Failed to load barangays.")
                });
            });
        });

    </script>
@endsection
