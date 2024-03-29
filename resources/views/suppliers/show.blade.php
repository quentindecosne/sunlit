@extends('layouts.app')

@section('title')
    @parent() | Supplier {{ $supplier->company }}
@endsection

@section('page-title')
    Supplier {{ $supplier->company }}
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <!-- Profile -->
        <div class="card bg-secondary">
            <div class="card-body profile-user-box">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar-lg">
                                    <!-- <img src="/images/users/avatar-2.jpg" alt="" class="rounded-circle img-thumbnail"> -->
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <h4 class="mt-1 mb-1 text-white">{{ $supplier->contact_person }}</h4>
                                    <p class="font-13 text-white-50"> {{ $supplier->company }}</p>
                                    <ul class="mb-0 list-inline text-light">
                                        <li class="list-inline-item me-3">
                                            <h5 class="mb-1">{{ $supplier->currency_code }} <span class="pending_orders_amount"></span></h5>
                                            <p class="mb-0 font-13 text-white-50">Total Amount</p>
                                        </li>
                                        <li class="list-inline-item">
                                            <h5 class="mb-1 pending_orders_counter"></h5>
                                            <p class="mb-0 font-13 text-white-50">Pending Orders</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-sm-4">
                        <div class="text-center mt-sm-0 mt-3 text-sm-end">
                            @can('edit suppliers')
                            <a href="{{ route('suppliers.edit', $supplier->id) }}">
                            <button type="button" class="btn btn-light">
                                <i class="mdi mdi-account-edit me-1"></i> Edit Supplier
                            </button>
                        </a>
                            @endcan
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row -->

            </div> <!-- end card-body/ profile-user-box-->
        </div><!--end profile/ card -->
    </div> <!-- end col-->
</div>
<!-- end row -->


<div class="row">
    <div class="col-xl-4">
        <!-- Personal-Information -->
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 mb-3">Seller Information</h4>
                {{-- <p class="text-muted font-13">
                    Hye, I’m Michael Franklin residing in this beautiful world. I create websites and mobile apps with great UX and UI design. I have done work with big companies like Nokia, Google and Yahoo. Meet me or Contact me for any queries. One Extra line for filling space. Fill as many you want.
                </p> --}}

                <hr/>

                <div class="text-start">
                    <p class="text-muted"><strong>Full Name :</strong> <span class="ms-2">{{ $supplier->contact_person }}</span></p>

                    <p class="text-muted"><strong>Phone :</strong><span class="ms-2">{{ $supplier->phone }} / {{ $supplier->phone2 }}</span></p>

                    <p class="text-muted"><strong>Email :</strong> <span class="ms-2">{{ $supplier->email }}</span></p>

                    <p class="text-muted"><strong>Location :</strong> <span class="ms-2">{{ $supplier->address }}, {{ $supplier->city }}, {{ $supplier->state->name ?? "" }} {{ $supplier->zip_code }} {{ $supplier->country }} </span></p>

                    @if ($supplier->gstin)
                        <p class="text-muted"><strong>GSTIN :</strong><span class="ms-2">{{ $supplier->gstin }}</span></p>
                    @endif


                </div>
            </div>
        </div>
        <!-- Personal-Information -->

        <!-- Toll free number box-->
        <div class="card text-white bg-info overflow-hidden">
            <div class="card-body">
                <div class="toll-free-box text-center">
                    <h4> <i class="mdi mdi-deskphone"></i> {{ $supplier->phone }}</h4>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
        <!-- End Toll free number box-->

       

    </div> <!-- end col-->

    <div class="col-xl-8">

        <!-- Chart-->
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Purchase Orders</h4>
                    <div id="purchase-orders-bar-chart" class="apex-charts"></div>
                </div>        
            </div>
        </div>
        <!-- End Chart-->
    </div>
    {{-- <div class="col">
        <div class="row">
            <div class="col-sm-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class="dripicons-basket float-end text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Orders</h6>
                        <h2 class="m-b-20">{{ $supplier->purchase_orders_count }}</h2>
                    </div> <!-- end card-body-->
                </div> <!--end card-->
            </div><!-- end col -->

            <div class="col-sm-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class="dripicons-box float-end text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Sales</h6>
                        <h2 class="m-b-20">$<span> {{ $total_orders }}</span></h2>
                    </div> <!-- end card-body-->
                </div> <!--end card-->
            </div><!-- end col -->
            <div class="col-sm-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class="dripicons-jewel float-end text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Product Sold</h6>
                        <h2 class="m-b-20">100000</h2>
                    </div> <!-- end card-body-->
                </div> <!--end card-->
            </div><!-- end col -->

        </div>
        <!-- end row --> --}}


        

    <!-- end col -->
    <div class="card">
        <div class="card-body">
            <h4 class="header-title mb-3">Products</h4>

            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0">
                    <thead>
                        <tr>
                            <th>Warehouse</th>
                            <th>Part Number</th>
                            <th>Price</th>
                            <th>Available</th>
                            <th>Ordered</th>
                            <th>Booked</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supplier->products as $product)
                            @foreach ($product->inventory as $inventory)
                                <tr class="product" data-id="{{ $product->id }}">
                                    <td>{{ $inventory->warehouse->name }}</td>
                                    <td>{{ $product->part_number }}</td>
                                    <td>{{ __('app.currency_symbol_inr')}} {{ $inventory->average_cost }}</td>
                                    <td>
                                        @if ($inventory->stock_available <= $product->minimum_quantity)
                                            <span class="badge bg-danger">
                                        @elseif ($inventory->stock_available <= $product->minimum_quantity*10)
                                            <span class="badge bg-warning">
                                        @else
                                            <span class="badge bg-success">
                                        @endif
                                        {{ $inventory->stock_available }} Pcs</span>
                                    </td>   
                                    <td>
                                        @if ($inventory->stock_ordered > 100)
                                            <span class="badge bg-danger">
                                        @elseif ($inventory->stock_ordered > 50)
                                            <span class="badge bg-warning">
                                        @else
                                            <span class="badge bg-success">
                                        @endif
                                        {{ $inventory->stock_ordered }} Pcs</span>
                                    </td>
                                    <td>
                                        @if ($inventory->stock_booked > 100)
                                            <span class="badge bg-danger">
                                        @elseif ($inventory->stock_booked > 50)
                                            <span class="badge bg-warning">
                                        @else
                                            <span class="badge bg-success">
                                        @endif
                                        {{ $inventory->stock_booked }} Pcs</span>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                      
                    </tbody>
                </table>
            </div> <!-- end table responsive-->
        </div> <!-- end col-->
    </div> <!-- end row-->
</div>
<!-- end row -->

@endsection
@section('page-scripts')
<script>
    $('.product').on('dblclick', function(){
        var route = "{{ route('products.show', ':id') }}";
        route = route.replace(':id', $(this).attr('data-id'));
        window.location.href = route;
    });


    var route = '{{ route("suppliers.stats", ":id") }}';
    route = route.replace(':id', {{ $supplier->id }});
    $.ajax({
        type: 'GET',
        url: route,
        dataType: 'json',
        success : function(res){
            data = res.data;
            $('.pending_orders_amount').html(data.total_amount['inr']);
            $('.pending_orders_counter').html(data.total_orders);
            chart.updateSeries([
                {
                    name: 'Amount',
                    type:"column",
                    data: data.graph_data['amount_inr']
                },
                {
                    name: 'Number of orders',
                    type: "line",
                    data: data.graph_data['orders']
                }
            ]);
        }
    })

    var options = {
        chart: {
            height: 300,
            type: 'line',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
            }
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [1]
        },
        noData: {
            text: 'Loading...'
        },
        series: [
        //     {
        //     data: [100,150,25,23,55,75,200,30,3,0,0,0]
        // }
        ],
        stroke: {
            width: [0, 3]
        },
        colors: ["#727cf5", "#6c757d"],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        },
        yaxis: [
        {
          title: {
            text: ""
          }
        },
        {
          opposite: true,
          title: {
            text: ""
          }
        }
      ],
        states: {
            hover: {
                filter: 'none'
            }
        },
        grid: {
            borderColor: '#f1f3fa'
        }
    }

    var chart = new ApexCharts(
        document.querySelector("#purchase-orders-bar-chart"),
        options
    );

    chart.render();


</script>
@endsection

