@section('title','Employee')
@section('employee-active','active')
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
                    <span>Employees</h3>
                    <div class="float-right">
                        <a href="{{ route('admin.employee.create') }}" class="btn btn-success "><i class="fa-solid fa-circle-plus"></i> Add new employee</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="no-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->fname }}</td>
                                    <td>{{ $employee->lname }}</td>
                                    <td>{{ $employee->company? $employee->company->name : '-' }}</td>
                                    <td>{{ $employee->email }}</td>
                                   <td>{{ $employee->phone }}</td>
                                    <th>
                                        <a href="{{ route('admin.employee.edit',$employee->id) }}" class="text-warning mr-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="{{ route('admin.employee.show',$employee->id) }}" class="text-primary mr-1"><i class="fa-solid fa-circle-info"></i></a>
                                        <form action="{{ route('admin.employee.destroy',$employee->id) }}" method="POST" id="submit_form">
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