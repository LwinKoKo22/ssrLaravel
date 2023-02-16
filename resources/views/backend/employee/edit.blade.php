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
                        <span>Add New Employee</h3>
                        <div class="float-right">
                            <a href="{{ route('admin.employee.index') }}" class="btn btn-success "><i class="fa-sharp fa-solid fa-backward"></i> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.employee.update',$employee->id) }}" method="POST"  id="create-form">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="fname" class="control-label">First Name</label>
                                <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" id="fname" value="{{ $employee->fname }}">
                                @error('fname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lname" class="control-label">Last Name</label>
                                <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" id="lname" value="{{ $employee->lname }}">
                                @error('lname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="company">Company</label>
                                <select name="company" id="company" class="form-control @error('company') is-invalid @enderror" value="{{ old('company') }}">
                                    <option value="">---- Please Choose ----</option>
                                @foreach ($compaines as $company)
                                    <option value="{{ $company->id }}" @if ($company->id == $employee->company_id)
                                        selected
                                    @endif>{{ $company->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ $employee->email }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div><div class="form-group">
                                <label for="phone" class="control-label">Phone</label>
                                <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ $employee->phone }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="btn btn-success"><i class="fa-solid fa-circle-check"></i> Update</button>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </section>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateEmployeeRequest') !!}
@endsection