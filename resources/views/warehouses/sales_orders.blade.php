<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="sale-orders-datatable">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Dealer</th>
                                <th>Status</th>
                                <th>Ordered on</th>
                                <th>Created by</th>
                            </tr>
                            <tr class="sale-orders-filters" style="display:none;">
                                <th><input type="text" class="form-control"></th>
                                <th><input type="text" class="form-control"></th>
                                <th><select class="form-control status-select"><option value="0">All</option>@foreach($sale_order_status as $k => $v) <option value={{ $k }}>{{ $v }}</option> @endforeach</select></th>
                                <th id="sale_ordered_at" class="position-relative">
                                    <input type="text" class="form-control" name="ordered_at" 
                                    data-provide="datepicker" 
                                    data-date-container="#sale_ordered_at"
                                    data-date-autoclose="true"
                                    data-date-format="M d, yyyy"
                                    data-date-start-date="-1d"
                                    data-date-end-date="+6m"
                                    data-date-today-highlight="true"
                                    required>
                                </th>
                                <th><input type="text" class="form-control"></th>
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



{{-- @section('page-scripts') --}}
@push('page-scripts')

    <script>
        
 $(document).ready(function () {
    "use strict";

    $('.toggle-filters').on('click', function(e) {
        $( ".sale-orders-filters" ).slideToggle('slow');
    });

    var saleTable = $('#sale-orders-datatable').DataTable({
        dom: 'Bfrtip',
        stateSave: true,
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4]
                },
                className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4]
                },
                className: 'btn btn-warning',
                download: 'open'
            },
            {
                extend: 'colvis',
                columns: ':not(.noVis)',
                className: 'btn btn-info'
            },
            {
                text: '<i class="mdi mdi-filter"></i>&nbsp;Filter',
                // className: 'btn btn-light',
                action: function ( e, dt, node, config ) {
                    $( ".sale-orders-filters" ).slideToggle('slow');
                }
            }
        ],
        processing: true,
        serverSide: true,
        orderCellsTop: true,
        fixedHeader: true,
        //deferLoading: 0,
        searching: true,
        paging: false,
        ajax      : {
            url   : "{{ route('sale-orders.datatables') }}",
            "data": function ( d ) {
                d.source = 'warehouses',
                d.filter_warehouse_id = {{ $warehouse->id }};
            },
        }, 
        "language": {
            "paginate": {
                "previous": "<i class='mdi mdi-chevron-left'>",
                "next": "<i class='mdi mdi-chevron-right'>"
            },
            "info": "Showing inventory _START_ to _END_ of _TOTAL_",
            "lengthMenu": "Display <select class='form-select form-select-sm ms-1 me-1'>" +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="-1">All</option>' +
                '</select> rows'
        },
        "pageLength": {{ Setting::get('general.grid_rows') }},
        "columns": [
            { 
                'data': 'order_number',
                'orderable': true 
            },
            { 
                'data': 'dealer',
                'orderable': true
            },
            { 
                'data': 'status',
                'orderable': true
            },
            { 
                'data': 'ordered_at',
                'orderable': true 
            },
            { 
                'data': 'user',
                'orderable': true
            }
        ],
        
        "order": [[1, "desc"]],
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            $('#sale-orders-datatable_length label').addClass('form-label');
 
        },
        
    });


    saleTable.columns().eq(0).each(function(colIdx) {

        var cell = $('.sale-orders-filters th').eq($(saleTable.column(colIdx).header()).index());
        var title = $(cell).text();

        if($(cell).hasClass('no-filter')){

            $(cell).html('&nbsp');

        }
        else{

            // $(cell).html( '<input class="form-control filter-input" type="text"/>' );

            $('select', $('.sale-orders-filters th').eq($(saleTable.column(colIdx).header()).index()) ).off('keyup change').on('keyup change', function (e) {
                e.stopPropagation();
                $(this).attr('title', $(this).val());
                //var regexr = '({search})'; //$(this).parents('th').find('select').val();
                saleTable
                    .column(colIdx)
                    .search(this.value) //(this.value != "") ? regexr.replace('{search}', 'this.value') : "", this.value != "", this.value == "")
                    .draw();
                
            });
            
            $('input', $('.sale-orders-filters th').eq($(saleTable.column(colIdx).header()).index()) ).off('keyup change').on('keyup change', function (e) {
                e.stopPropagation();
                $(this).attr('title', $(this).val());
                //var regexr = '({search})'; //$(this).parents('th').find('select').val();
                saleTable
                    .column(colIdx)
                    .search(this.value) //(this.value != "") ? regexr.replace('{search}', 'this.value') : "", this.value != "", this.value == "")
                    .draw();
                
            }); 
        }
    });
});

    </script>    
@endpush
{{-- @endsection --}}
