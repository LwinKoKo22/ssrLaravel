@extends('feature-room.layouts.app')
@section('content')
<div class="card my-3 shadow">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <p>{{ auth()->guard('customer')->user()->name }}</p>
            <form action="{{ route('customer.logout') }}" method="POST">
                @csrf
                <button class="btn btn-theme " style="border-radius:0px;" type="submit">Logout <i class="bi bi-box-arrow-right"></i> </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach ($features as $feature)
            <div class="col-6">
                <div class="card border my-3">
                    <div class="card-body">
                        <img src="{{ $feature->feature_image_path() }}" alt="" width="100%" height="200px">
                    </div>
                    <div class="card-footer">
                       <p class="text-center mb-0"><a href="/features/{{ $feature->id }}" style="text-decoration:none;">{{ $feature->name }}</a></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection