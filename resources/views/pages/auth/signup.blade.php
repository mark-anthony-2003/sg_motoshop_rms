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
    </script>
@endsection
