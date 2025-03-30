@extends('includes.app')

<style>
    #top-nav .nav-link,
    #orders-nav .nav-link {
        color: var(--bs-black); }

    #top-nav .nav-link.active,
    #orders-nav .nav-link.active {
        background-color: #343a40;
        color: var(--bs-light) !important; }
</style>

@section('content')
    <div class="app-content-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-2 text-center">
                    <div class="rounded-circle d-flex justify-content-center align-items-center overflow-hidden"
                        style="width: 100px; height: 100px; font-size: 24px; background-color: #6c757d; color: white;">
                        @if($user->user_image)
                            <img src="{{ asset('storage/' . $user->user_image) }}" alt="User Image" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ strtoupper($user->first_name[0]) }}{{ strtoupper($user->last_name[0]) }}
                        @endif
                    </div>
                </div>
                <div class="col-sm-10">
                    <h2>{{ Str::title($user->first_name) }} {{ Str::title($user->last_name) }}</h2>
                    <p>{{ $user->email }}</p>
                    @if($user->addresses->first())
                        <p>
                            {{ $user->addresses->first()->barangay }},
                            {{ $user->addresses->first()->city }},
                            {{ $user->addresses->first()->province }},
                            {{ $user->addresses->first()->country }}
                        </p>
                    @else
                        <p>No address available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="nav nav-pills bg-light p-3 rounded mb-2 d-flex gap-2" id="top-nav" role="tablist">
                    <a class="nav-link active btn text-black" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="true">
                        <i class="bi bi-gear"></i> User Settings
                    </a>
                    <a class="nav-link btn text-black" id="v-pills-orders-tab" data-bs-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">
                        <i class="bi bi-cart"></i> Orders
                    </a>
                    <a class="nav-link btn text-black" id="v-pills-reservations-tab" data-bs-toggle="pill" href="#v-pills-reservations" role="tab" aria-controls="v-pills-reservations" aria-selected="false">
                        <i class="bi bi-calendar-check"></i> Reservations History
                    </a>
                </div>

                <div class="col-md-12 mb-4">
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
                                    <div class="col-md-4">
                                        <label for="country" class="form-label">Country</label>
                                        <select name="country" id="country" class="form-control">
                                            <option value="{{ old('country', $user->addresses->first()->country ?? 'Philippines') }}" selected>
                                                {{ old('country', $user->addresses->first()->country ?? 'Philippines') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="province" class="form-label">State/Province</label>
                                        <select name="province" id="province" class="form-control">
                                            <option value="{{ old('province', $user->addresses->first()->province ?? '') }}" selected>
                                                {{ old('province', $user->addresses->first()->province ?? 'Select State/Province') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="city" class="form-label">City/Town/Municipality</label>
                                        <select name="city" id="city" class="form-control">
                                            <option value="{{ old('city', $user->addresses->first()->city ?? '') }}" selected>
                                                {{ old('city', $user->addresses->first()->city ?? 'Select City/Town/Municipality') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="barangay" class="form-label">Street/Barangay</label>
                                        <select name="barangay" id="barangay" class="form-control">
                                            <option value="{{ old('barangay', $user->addresses->first()->barangay ?? '') }}" selected>
                                                {{ old('barangay', $user->addresses->first()->barangay ?? 'Select Street/Barangay') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="address_type" class="form-label">Address Type</label>
                                        <select name="address_type" id="address_type" class="form-control">
                                            <option value="">Select Address Type</option>
                                            <option value="home" {{ old('address_type', $user->addresses->first()->address_type ?? '') == 'home' ? 'selected' : '' }}>Home</option>
                                            <option value="work" {{ old('address_type', $user->addresses->first()->address_type ?? '') == 'work' ? 'selected' : '' }}>Work</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>

                        <!-- Orders -->
                        <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                            <h4>Orders</h4>

                            <div class="nav nav-pills bg-light p-3 rounded mb-2 d-flex gap-2" id="orders-nav" role="tablist">
                                <a class="nav-link active btn text-black" id="v-pills-all-tab" data-bs-toggle="pill" href="#v-pills-all" role="tab" aria-controls="v-pills-all" aria-selected="true">
                                    All
                                </a>
                                <a class="nav-link btn text-black" id="v-pills-unpaid-tab" data-bs-toggle="pill" href="#v-pills-unpaid" role="tab" aria-controls="v-pills-unpaid" aria-selected="false">
                                    Unpaid
                                </a>
                                <a class="nav-link btn text-black" id="v-pills-toship-tab" data-bs-toggle="pill" href="#v-pills-toship" role="tab" aria-controls="v-pills-toship" aria-selected="false">
                                    To Ship
                                </a>
                                <a class="nav-link btn text-black" id="v-pills-shipped-tab" data-bs-toggle="pill" href="#v-pills-shipped" role="tab" aria-controls="v-pills-shipped" aria-selected="false">
                                    Shipped
                                </a>
                                <a class="nav-link btn text-black" id="v-pills-returns-tab" data-bs-toggle="pill" href="#v-pills-returns" role="tab" aria-controls="v-pills-returns" aria-selected="false">
                                    Returns
                                </a>
                            </div>
                            {{-- Orders Content --}}
                            <div class="tab-content">
                                {{-- All --}}
                                <div class="tab-pane fade show active" id="v-pills-all" role="tabpanel" aria-labelledby="v-pills-all-tab">
                                    <p class="text-center py-4">No Orders Yet</p>
                                </div>
                                {{-- Unpaid --}}
                                <div class="tab-pane fade" id="v-pills-unpaid" role="tabpanel" aria-labelledby="v-pills-unpaid-tab">
                                    <p class="text-center py-4">No Orders Yet</p>
                                </div>
                                {{-- To Ship --}}
                                <div class="tab-pane fade" id="v-pills-toship" role="tabpanel" aria-labelledby="v-pills-toship-tab">
                                    <p class="text-center py-4">No Orders Yet</p>
                                </div>
                                {{-- Shipped --}}
                                <div class="tab-pane fade" id="v-pills-shipped" role="tabpanel" aria-labelledby="v-pills-shipped-tab">
                                    <p class="text-center py-4">No Orders Yet</p>
                                </div>
                                {{-- Returns --}}
                                <div class="tab-pane fade" id="v-pills-returns" role="tabpanel" aria-labelledby="v-pills-returns-tab">
                                    <p class="text-center py-4">No Orders Yet</p>
                                </div>
                            </div>
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
        $(document).ready(function () {
            const userProvince = "{{ old('province', $user->addresses->first()->province ?? '') }}"
            const userCity = "{{ old('city', $user->addresses->first()->city ?? '') }}"
            const userBarangay = "{{ old('barangay', $user->addresses->first()->barangay ?? '') }}"

            // Fetch Provinces
            $.get('/address/provinces', function(data) {
                $('#province').empty().append('<option>Select State/Province</option>')
                data.forEach(function(item) {
                    const selected = item.name == userProvince ? 'selected' : ''
                    $('#province').append(`<option value="${item.name}" data-code="${item.code}" ${selected}>${item.name}</option>`)
                })

                if (userProvince) $('#province').trigger('change')
            })
            // .fail(function() {
            //     alert("Failed to load provinces.");
            // });

            // Fetch Cities on Province Change
            $('#province').change(function () {
                const provinceCode = $('#province option:selected').data('code')
                const provinceName = $(this).val()
                
                $('input[name="province"]').val(provinceName)

                $('#city').html('<option>Loading...</option>')
                $('#barangay').html('<option>Select Barangay</option>')

                if (!provinceCode) return

                $.get(`/address/cities/${provinceCode}`, function(data) {
                    $('#city').empty().append('<option>Select City/Town/Municipality</option>')
                    data.forEach(function(item) {
                        const selected = item.name == userCity ? 'selected' : ''
                        $('#city').append(`<option value="${item.name}" data-code="${item.code}" ${selected}>${item.name}</option>`)
                    })

                    if (userCity) $('#city').trigger('change')
                })
            })

            // Fetch Barangays on City Change
            $('#city').change(function() {
                const cityCode = $('#city option:selected').data('code')
                const cityName = $(this).val()
                
                $('input[name="city"]').val(cityName)

                $('#barangay').html('<option>Loading...</option>')

                if (!cityCode) return

                $.get(`/address/barangays/${cityCode}`, function(data) {
                    $('#barangay').empty().append('<option>Select Barangay</option>')
                    data.forEach(function(item) {
                        const selected = item.name == userBarangay ? 'selected' : ''
                        $('#barangay').append(`<option value="${item.name}" ${selected}>${item.name}</option>`)
                    })
                })
            })
        })
    </script>
@endsection
