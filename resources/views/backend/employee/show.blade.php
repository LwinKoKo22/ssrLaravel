@section('title','Employee')
@section('employee-active','active')
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
                        <span>Employee Detail</h3>
                        <div class="float-right">
                            <a href="{{ route('admin.employee.index') }}" class="btn btn-success "><i class="fa-sharp fa-solid fa-backward"></i> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>First Name : {{ $employee->fname }}</p>
                        <p>Last Name : {{ $employee->lname }}</p>
                        <p>Company : {{ $employee->company ? $employee->company->name : '-' }}</p>
                        <p>Email : {{ $employee->email }}</p>
                        <p>Phone : {{ $employee->phone }}</p>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </section>
@endsection
