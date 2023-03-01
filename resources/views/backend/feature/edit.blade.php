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
                        <span>Edit Feature</h3>
                        <div class="float-right">
                            <a href="{{ route('admin.feature.index') }}" class="btn btn-success "><i class="fa-sharp fa-solid fa-backward"></i> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.feature.update',$feature->id) }}" method="POST" enctype="multipart/form-data" id="create-form">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="name" class="control-label">Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $feature->name }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="logo">
                               @if ($feature->feature_image)
                               <img src="{{ $feature->feature_image_path() }}" id="logo_image" width="100px" height="100px">
                               @else
                               <img src="https://via.placeholder.com/100x100" id="logo_image" width="100px" height="100px">
                               @endif
                                <span class="rm-icon" id="rm_icon">x</span>
                            </div>
                            <div class="form-group">
                                <label for="logo" class="control-label">Logo</label>
                                <input type="file" name="feature_image" id="logo" class="form-control" accept="image/png, image/jpeg" value="{{ $feature->featue_image }}">
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
{!! JsValidator::formRequest('App\Http\Requests\UpdateFeatureRequest') !!}
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