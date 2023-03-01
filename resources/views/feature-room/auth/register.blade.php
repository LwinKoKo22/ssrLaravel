@extends('feature-room.layouts.app')
@section('content')
<div class="card my-3 shadow">
    <div class="card-body">
        <h5 class="text-center mt-2 mb-3">Registration Form</h5>
        <form action="{{ route('customer.storeRegister') }}" method="POST">
            @csrf
            <div class="form-group mt-3">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Your name"  value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Your email"  value="{{ old('email') }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="phone">Phone:</label>
                <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Your phone"  value="{{ old('phone') }}">
                @error('phone')
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
            <div class="form-group mt-3">
                <label>Gender:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="male" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                     Male
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2" value="female">
                    <label class="form-check-label" for="flexRadioDefault2">
                      Female
                    </label>
                  </div>
            </div>
            <div class="d-grid gap-2 mt-3 mb-3">
                <button class="btn btn-theme" type="submit">Register</button>
            </div>
            <p class="text-center text">Already account? <a href="{{ route('customerLogin') }}">Login</a> here</p>
        </form>
    </div>
</div>
@endsection