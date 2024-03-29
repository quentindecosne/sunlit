<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Supplier Information</h4>
                <h5>{{ $purchase_order->supplier->company }}</h5>
                <h6>{{ $purchase_order->supplier->contact_person }}</h6>
                <address class="mb-0 font-14 address-lg">
                    <abbr title="Phone">P:</abbr> {{ $purchase_order->supplier->phone }} <br />
                    <abbr title="Mobile">M:</abbr> {{ $purchase_order->supplier->phone2 }} <br />
                    <abbr title="Mobile">@:</abbr> {{ $purchase_order->supplier->email }}
                </address>
            </div>
        </div>
    </div> <!-- end col -->

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Warehouse Information</h4>
                <h5>{{ $purchase_order->warehouse->name }}</h5>
                <h6>{{ $purchase_order->warehouse->contact_person }}</h6>
                <address class="mb-0 font-14 address-lg">
                    <abbr title="Phone">P:</abbr> {{ $purchase_order->warehouse->phone }} <br />
                    <abbr title="Mobile">M:</abbr> {{ $purchase_order->warehouse->phone2 }} <br />
                    <abbr title="Mobile">@:</abbr> {{ $purchase_order->warehouse->email }}
                </address>
            </div>
        </div>
    </div> <!-- end col -->


    
    <!-- the d-none class hides this card -->

    <div class="col-lg-4  @if (!$invoice->paid_at) d-none @endif">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3 text-center">Payment Information</h4>
                <div class="text-center">
                    @if ($purchase_order->supplier->is_international)
                        <i class="mdi mdi-cash-usd-outline h2 text-muted"></i>
                    @else
                        <p>&#8377;</p>
                    @endif
                    <h5><b>{{ $invoice->courier }}</b></h5>
                    <p class="mb-1"><b>Payment # :</b> {{ $invoice->payment_reference }}</p>
                    <p class="mb-1"><b>Paid On:</b> {{ $invoice->display_paid_at }}</p>
                    @if ($purchase_order->supplier->is_international)
                        <p class="mb-0"><b>FX rate :</b> {{ __('app.currency_symbol_inr')}} {{ $invoice->paid_exchange_rate }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div>