@extends('includes.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-sm-12 d-flex flex-column align-items-center text-center">
                    <h1 class="mb-0">SG MOTOSHOP</h1>
                    <p>Parts, Accessories, and Services</p>

                    <div class="d-flex gap-4 justify-content-center">
                        <a href="{{ route('shop.items') }}" class="btn btn-primary btn-sm">Order Items</a>
                        <a href="{{ route('shop.reservation') }}" class="btn btn-primary btn-sm">Make a Reservation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

