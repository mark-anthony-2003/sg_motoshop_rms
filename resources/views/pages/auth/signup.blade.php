@extends('includes.app')

@section('title', 'Sign Up')

@section('content')
    <section class="register-page bg-body-secondary">
        <div class="register-box">
            <div class="register-logo">
                <h1>SG MOTOSHOP</h1>
                <p>Parts, Accessories and Services</p>
            </div>
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="register-box-msg">Sign Up as Customer</p>
                    <form action="{{ route('sign-up.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_type" value="{{ $userType }}">
    
                        <div class="input-group mb-3">
                            <input type="text" id="first_name" name="first_name" placeholder="First Name" class="form-control">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" id="last_name" name="last_name" placeholder="Last Name" class="form-control">
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" id="email" name="email" placeholder="Email" class="form-control">
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" id="password" name="password" placeholder="Password" class="form-control">
                            <div class="input-group-text">
                                <span class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" class="form-control">
                            <div class="input-group-text">
                                <span class="bi bi-eye-slash" id="toggleConfirmPassword" style="cursor: pointer;"></span>
                            </div>
                        </div>
                        
                        {{-- <div>
                            <h3>Address</h3>
                            <div class="input-group mb-3">
                                <label for="country">Country</label>
                                <select name="country" id="country">
                                    <option value="philippines" selected>Philippines</option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <label for="province">State/Province</label>
                                <select name="province" id="province">
                                    <option>Select State/Province</option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <label for="city">City/Town/Municipality</label>
                                <select name="city" id="city">
                                    <option>Select City/Town/Municipality</option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <label for="barangay">Street/Barangay</label>
                                <select name="barangay" id="barangay">
                                    <option>Select Street/Barangay</option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <label for="address_type">Address Type</label>
                                <select name="address_type" id="address_type">
                                    <option value="home">Home</option>
                                    <option value="work">Work</option>
                                </select>
                            </div>
                        </div> --}}

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Sign Up
                            </button>
                        </div>
                    </form>

                    @if($userType === 'customer') 
                        <p class="mt-4 text-center">
                            Already have an account? <a href="{{ route('sign-in.customer') }}">Sign In</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            let passwordInput = document.getElementById('password')
            let icon = this

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'
                icon.classList.remove('bi-eye-slash')
                icon.classList.add('bi-eye')
            } else {
                passwordInput.type = 'password'
                icon.classList.remove('bi-eye')
                icon.classList.add('bi-eye-slash')
            }
        })
        document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
            let passwordInput = document.getElementById('password_confirmation')
            let icon = this

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'
                icon.classList.remove('bi-eye-slash')
                icon.classList.add('bi-eye')
            } else {
                passwordInput.type = 'password'
                icon.classList.remove('bi-eye')
                icon.classList.add('bi-eye-slash')
            }
        })

        // $(document).ready(function () {
        //     $('#province').empty().append('<option>Select Province</option>')
    
        //     // Fetch Provinces
        //     $.get('/address/provinces', function(data) {
        //         if (data.length > 0) {
        //             data.forEach(function(item) {
        //                 $('#province').append(`<option value="${item.name}" data-code="${item.code}">${item.name}</option>`)
        //             });
        //         } else {
        //             $('#province').append('<option disabled>No provinces found</option>')
        //         }
        //     }).fail(function() {
        //         alert("Failed to load provinces.")
        //     });
    
        //     // Fetch Cities based on selected Province
        //     $('#province').change(function () {
        //         var provinceCode = $('#province option:selected').data('code')
        //         $('#city').empty().append('<option>Loading...</option>')
        //         $('#barangay').empty().append('<option>Select Barangay</option>')
    
        //         $.get(`/address/cities/${provinceCode}`, function(data) {
        //             $('#city').empty().append('<option>Select City/Town/Municipality</option>')
        //             if (data.length > 0) {
        //                 data.forEach(function(item) {
        //                     $('#city').append(`<option value="${item.name}" data-code="${item.code}">${item.name}</option>`)
        //                 })
        //             } else {
        //                 $('#city').append('<option disabled>No cities found</option>')
        //             }
        //         }).fail(function() {
        //             alert("Failed to load cities.")
        //         });
        //     });
    
        //     // Fetch Barangays based on selected City
        //     $('#city').change(function() {
        //         var cityCode = $('#city option:selected').data('code')
        //         $('#barangay').empty().append('<option>Loading...</option>')
    
        //         $.get(`/address/barangays/${cityCode}`, function(data) {
        //             $('#barangay').empty().append('<option>Select Barangay</option>')
        //             if (data.length > 0) {
        //                 data.forEach(function(item) {
        //                     $('#barangay').append(`<option value="${item.name}">${item.name}</option>`)
        //                 })
        //             } else {
        //                 $('#barangay').append('<option disabled>No Barangays found</option>')
        //             }
        //         }).fail(function() {
        //             alert("Failed to load barangays.")
        //         })
        //     })
        // })
    </script>
@endsection
