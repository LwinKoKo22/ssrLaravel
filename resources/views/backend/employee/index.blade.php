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
                                <th class="no-action">Create At</th>
                                <th class="no-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
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
                processing: true,
                serverSide: true,
                ajax: '/admin/employee/datatable/ssd',
                columns : [
                    {data :"fname" , name : "fname"},
                    {data :"lname" , name : "lname"},
                    {data :"company" , name : "company"},
                    {data : "email" , name : "email"},
                    {data : "phone" , name : "phone"},
                    {data : "created_at" , name : "created_at"},
                    {data : "action" , name : "action"}
                ],
                columnDefs: [
                    { 
                        targets: "no-action", 
                        searchable : false,
                        sortable : false
                    },
                ]
            });
            $(document).on('click','.delete_btn',function(e){
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
                  $.ajax({
                    url : "/admin/employee/" + id,
                    type : "DELETE",
                    success : function(res){
                        if(res.status == 'success'){
                            datatable.ajax.reload();
                            Swal.fire(
                            'Deleted!',
                            res.message,
                            'success'
                            )
                        }
                    }   
                  })
                }
                })
            })
        });
    </script>
@endsection