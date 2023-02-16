@section('title','Company')
@section('company-active','active')
@extends('backend.layouts.app')
@section('content')
        <!-- Content Header (Page header) -->
        @include('backend.layouts.content-header')
        <!-- /.content-header -->
         <!-- Main content -->
    <section class="content company">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <span>Companies</h3>
                    <div class="float-right">
                        <a href="{{ route('admin.company.create') }}" class="btn btn-success "><i class="fa-solid fa-circle-plus"></i> Add new company</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="no-action">Logo</th>
                                <th class="no-action">Website</th>
                                <th class="no-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                                <tr>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>
                                        @if($company->logo)
                                        <img src="{{ $company->logo_image_path() }}" alt="logo_image" width="80px" height="80px"/>
                                        @else
                                        <img src="https://via.placeholder.com/100x100" id="logo_image" width="80px" height="80px">
                                        @endif
                                    </td>
                                    <td><a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></td>
                                    <th>
                                        <a href="{{ route('admin.company.edit',$company->id) }}" class="text-warning mr-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="{{ route('admin.company.show',$company->id) }}" class="text-primary mr-1"><i class="fa-solid fa-circle-info"></i></a>
                                        <form action="{{ route('admin.company.destroy',$company->id) }}" method="POST" id="submit_form">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#"  class="text-danger deleteBtn" type="submit"><i class="fa-solid fa-trash"></i></a>
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            var datatable = $('#datatable').DataTable({
                "columnDefs": [{
                    "targets": "no-action",
                    "searchable": false,
                    "sortable":false,
                }],
                mark : true
            });
            $(document).on('click','.deleteBtn',function(e){
                e.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                title: 'Are you sure you want to delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $('#submit_form').submit();
                }
                })
            })
        });
    </script>
@endsection