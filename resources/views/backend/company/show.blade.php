@section('title','Company')
@section('company-active','active')
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
                        <span>Company Detail</h3>
                        <div class="float-right">
                            <a href="{{ route('admin.company.index') }}" class="btn btn-success "><i class="fa-sharp fa-solid fa-backward"></i> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>
                            @if($company->logo)
                                <img src="{{ $company->logo_image_path() }}" alt="logo_image" width="100px" height="100px"/>
                            @else
                                <img src="https://via.placeholder.com/100x100" id="logo_image" width="100px" height="100px">
                            @endif
                        </p>
                        <p>Name : {{ $company->name }}</p>
                        <p>Email : {{ $company->email }}</p>
                        <p>Website :  <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></p>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </section>
@endsection
