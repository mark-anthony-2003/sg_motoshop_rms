@extends('includes.app')

@section('title', 'Sign in')

@section('content')
    <section class="login-page bg-body-secondary">
        <div class="login-box">
            <div class="login-logo">
                <h1>SG MOTOSHOP</h1>
                <p>Parts, Accessories and Services</p>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('sign-in.employee-manager') }}" class="btn btn-primary">Sign in as Manager</a>
                <a href="{{ route('sign-in.employee-laborer') }}" class="btn btn-primary">Sign in as Laborer</a>
            </div>
        </div>
    </section>
@endsection
