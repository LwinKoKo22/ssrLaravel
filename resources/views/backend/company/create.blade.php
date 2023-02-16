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
                        <span>Add New Company</h3>
                        <div class="float-right">
                            <a href="{{ route('admin.company.index') }}" class="btn btn-success "><i class="fa-sharp fa-solid fa-backward"></i> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.company.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="control-label">Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="logo">
                               <img src="https://via.placeholder.com/100x100" id="logo_image" width="100px" height="100px">
                                <span class="rm-icon" id="rm_icon">x</span>
                            </div>
                            <div class="form-group">
                                <label for="logo" class="control-label">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control" accept="image/png, image/jpeg">
                            </div>
                            <div class="form-group">
                                <label for="website" class="control-label">Website</label>
                                <input type="text" name="website" class="form-control @error('website') is-invalid @enderror" id="website" value="{{ old('website') }}">
                                @error('website')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="btn btn-success"><i class="fa-solid fa-circle-check"></i> Save</button>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </section>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreCompanyRequest') !!}
    <script>
        $(document).ready(function(){
            $('#logo').on('change',function(){
                var file_length= document.getElementById('logo').files.length;
                for(var i=0 ; i<file_length ; i++){
                    $("#logo_image").attr("src",`${URL.createObjectURL(event.target.files[i])}`);
                    document.getElementById('rm_icon').style.display = "inline-block";
                }
            })

            $('#rm_icon').on('click',function(){
                $("#logo_image").attr("src","https://via.placeholder.com/100x100");
                document.getElementById('rm_icon').style.display = "none";           
                document.getElementById("logo").value = null;
            })
        })
    </script>
@endsection