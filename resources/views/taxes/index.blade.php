@extends('layouts.app')

@section('title')
    @parent() | Taxes
@endsection

@section('page-title')
    Taxes
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            
                <div class="table-responsive">
                    <table class="table table-centered table-striped table-bordered table-hover w-100 dt-responsive nowrap" id="taxes-datatable">
                        <thead class="table-light">
                            <tr>
                            
                                <th>Name</th>
                                <th>Amount</th> 
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            
                            
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>

<x-modal-confirm type="danger" target="tax"></x-modal-confirm>


@endsection

@section('page-scripts')
    <script>
        
 $(document).ready(function () {
    "use strict";

    // Default Datatable
    var table = $('#taxes-datatable').DataTable({
        dom: 'Bfrtip',
        stateSave: true,
        scrollY: "500px",
        paging: false,
        buttons: [
            {
                text: '<i class="mdi mdi-plus-circle me-2"></i> {{ __('app.add_title', ['field' => 'tax']) }}',
                className: 'btn btn-light   ',
                action: function ( e, dt, node, config ) {
                    window.location.href="{{ route('taxes.create') }}"
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1]
                },
                className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1]
                },
                className: 'btn btn-warning',
                download: 'open'
            },
            {
                extend: 'colvis',
                columns: ':not(.noVis)',
                className: 'btn btn-info'
            }
        ],
        processing: true,
        serverSide: true,
        ajax: "{{ route('taxes.datatables') }}",

        "language": {
            "paginate": {
                "previous": "<i class='mdi mdi-chevron-left'>",
                "next": "<i class='mdi mdi-chevron-right'>"
            },
            "info": "Showing taxes _START_ to _END_ of _TOTAL_",
            "lengthMenu": "Display <select class='form-select form-select-sm ms-1 me-1'>" +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="-1">All</option>' +
                '</select> taxes',
        },
        "pageLength": {{ Setting::get('general.grid_rows') }},
        "columns": [
           
            { 
                'data': 'name',
                'orderable': true 
            },
            { 
                'data': 'amount',
                'orderable': true ,
                'render' : function(data, type, row, meta){
                    if (type === 'display'){
                        return data + '%';
                    }
                    return data;
                },
            },
            {
                'data': 'id',
                "width": "5%",
                'className': 'noVis',
                'render' : function(data, type, row, meta){
                    if (type === 'display'){

                        var edit_btn = '';
                        var delete_btn = '';

                        @if (Auth::user()->can('edit taxes'))
                            var edit_route = '{{ route("taxes.edit", ":id") }}';
                            edit_route = edit_route.replace(':id', data);
                            edit_btn = '<a href="' + edit_route + '" class="action-icon"> <i class="mdi mdi-pencil"></i></a>'                       
                        @endif
                        @if (Auth::user()->can('delete taxes'))
                            delete_btn = '<a href="" class="action-icon" id="' + data + '" data-bs-toggle="modal" data-bs-target="#delete-modal"> <i class="mdi mdi-delete"></i></a>'
                        @endif

                        data = edit_btn +  delete_btn
                    }
                    return data;
                }
            }
            
        ],
        "order": [[1, "desc"]],
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            $('#taxes-datatable_length label').addClass('form-label');
            
        },
    });

    $('#delete-modal').on('show.bs.modal', function (e) {
        var route = '{{ route("taxes.delete", ":id") }}';
        var button = e.relatedTarget;
        if (button != null){
            route = route.replace(':id', button.id);
            console.log(route);
            $('#delete-form').attr('action', route);
        }
        
    });


    @if(Session::has('success'))
        $.NotificationApp.send("Success","{{ session('success') }}","top-right","","success")
    @endif
    @if(Session::has('error'))
        $.NotificationApp.send("Error","{{ session('error') }}","top-right","","error")
    @endif
  
});


    
    </script>    
@endsection
