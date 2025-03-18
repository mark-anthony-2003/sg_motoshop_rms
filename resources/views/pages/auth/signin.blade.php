@extends('includes.app')

@section('title', 'Sign in')

@section('content')
    <section class="login-page bg-body-secondary">
        <div class="login-box">
            <div class="login-logo">
                <h1>SG MOTOSHOP</h1>
                <p>Parts, Accessories and Services</p>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in as {{ ucfirst($userType) }}</p>
                    <form action="{{ route('sign-in.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_type" value="{{ $userType }}">
        
                        <div class="input-group mb-3">
                            <input type="email" id="email" name="email" placeholder="Email" class="form-control">
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" id="password" name="password" placeholder="Password" class="form-control">
                            <div class="input-group-text">
                                <span class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></span>
                            </div>
                        </div>
        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Sign In
                            </button>
                        </div>
                    </form>
        
                    @if($userType === 'customer') 
                        <p class="mt-4 text-center">
                            Don't have an account? <a href="{{ route('sign-up') }}">Sign Up</a>
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
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye')
            } else {
                passwordInput.type = 'password'
                icon.classList.remove('bi-eye')
                icon.classList.add('bi-eye-slash')
            }
        });
    </script>
@endsection
