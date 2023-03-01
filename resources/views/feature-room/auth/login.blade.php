@extends('feature-room.layouts.app')
@section('content')
<div class="card my-3 shadow">
    <div class="card-body">
        <h5 class="text-center mt-2 mb-3">Login Form</h5>
        <form action="{{ route('customer.store') }}" method="POST">
            @csrf
            <div class="form-group mt-3">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Your email"  value="{{ old('email') }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Your password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-grid gap-2 mt-5  mb-3">
                <button class="btn btn-theme" type="submit">Login</button>
            </div>
            <p class="text-center text">Not a member? <a href="{{ route('customer.register') }}">Register</a> here</p>
        </form>
    </div>
</div>
@endsection