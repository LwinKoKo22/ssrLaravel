@section('title','Employee')
@section('employee-active','active')
@extends('backend.layouts.app')
@section('content')
        <!-- Content Header (Page header) -->
        @include('backend.layouts.content-header')
        <!-- /.content-header -->
         <!-- Main content -->
         <div class="container">
            <div class="row">
                <div class="col-3">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" id="search_btn">Search</button>
                    </div>
                </div>
                <div class="col-3">
                    <div class="input-group mb-3">
                        <i class="fa-solid fa-x" id="clear_btn" style="position: absolute;top: 12px;right: 8px;z-index: 999;cursor: pointer;"></i>
                        <input type="text" class="form-control" placeholder="Search here...."   id="search" style="border-radius: 5px">
                      </div>
                </div>
                <div class="col-3">
                        <select id="company" class="form-control">
                            <option value="">All</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Date</span>
                        <input type="text" name="date" value="{{request()->date}}"  class="form-control date" placeholder="All"/>
                    </div>
                </div>
            </div>
        </div>
    <section class="content company">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <span>Employees</h3>
                        <a href="#" id="export" class="btn btn-primary">Export</a>
                    <div class="float-right">
                        <a href="{{ route('admin.employee.create') }}" class="btn btn-success "><i class="fa-solid fa-circle-plus"></i> Add new employee</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
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
                    {data :"name" , name : "name"},
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
             //Search Button
             $('#search_btn').on('click',function(){
                var search = $('#search').val();
                var date = $('.date').val();
                var company = $('#company').val();
                if(search){
                    document.getElementById('clear_btn').style.display = 'block';
                }
                datatable.ajax.url(`/admin/employee/datatable/ssd?name=${search}&date=${date}&company=${company}`).load();
            })
            $('#export').on('click',function(e){
                e.preventDefault();
                var search = $('#search').val();
                var date = $('.date').val();
                var company = $('#company').val();
                window.location.replace(`/admin/employee_export?search=${search}&date=${date}&company=${company}`);
            })
            //Clear Button
            $('#clear_btn').on('click',function(){
                window.location.replace('/admin/employee');
                return false;
            })
                //DaterangePicker
                $('.date').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('.date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
            });

            $('.date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endsection