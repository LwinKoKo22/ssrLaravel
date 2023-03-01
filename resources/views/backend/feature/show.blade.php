@section('title','Feature')
@section('feature-active','active')
@extends('backend.layouts.app')
@section('content')
        <!-- Content Header (Page header) -->
        @include('backend.layouts.content-header')
        <!-- /.content-header -->
         <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <span>Feature Detail</h3>
                        <div class="float-right">
                            <a href="{{ route('admin.feature.index') }}" class="btn btn-success "><i class="fa-sharp fa-solid fa-backward"></i> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>
                            @if($feature->feature_image)
                                <img src="{{ $feature->feature_image_path() }}" alt="logo_image" width="100px" height="100px"/>
                            @else
                                <img src="https://via.placeholder.com/100x100" id="logo_image" width="100px" height="100px">
                            @endif
                        </p>
                        <p>Name : {{ $feature->name }}</p>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </section>
@endsection
