@if ($invoice->status == 9)

<div class="row">
    <div class="col-12">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10 col-sm-11">
                <div class="alert alert-danger bg-transparent text-danger" role="alert">
                    This invoice is <strong>cancelled</strong>
                </div>
            </div>
        </div>
    </div>
</div>

@else

<div class="row">
    <div class="col-12">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10 col-sm-11">
                <div class="horizontal-steps mt-4 mb-4 pb-5" id="tooltip-container">
                    @if ($purchase_order->supplier->is_international)
                        <div class="horizontal-steps-content">
                            {{-- <div class="step-item @if ($invoice->status == 2) current @endif">
                                <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ $invoice->display_ordered_at }}">Ordered</span>
                            </div>
                            <div class="step-item @if ($invoice->status == 3) current @endif">
                                <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ $invoice->display_confirmed_at }}">Confirmed</span>
                            </div> --}}
                            <div class="step-item @if ($invoice->status == 4) current @endif">
                                <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ $invoice->display_shipped_at }}">Shipped</span>
                            </div>
                            <div class="step-item @if ($invoice->status == 5) current @endif">
                                <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ $invoice->display_customs_at }}">Customs</span>
                            </div>
                            <div class="step-item @if ($invoice->status == 6) current @endif">
                                <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ $invoice->display_cleared_at }}">Cleared</span>
                            </div>
                            <div class="step-item @if ($invoice->status == 7) current @endif">
                                <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ $invoice->display_received_at }}">Received</span>
                            </div>
                            <div class="step-item @if ($invoice->status == 8) current @endif">
                                <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ $invoice->display_paid_at }}">Paid</span>
                            </div>
                        </div>
                        <div class="process-line"
                        @switch($invoice->status)
                            @case(2)
                            @case(3)
                                style="width:0%;"
                                @break
                            @case(4)
                                style="width:0%;"
                                @break
                            @case(5)
                                style="width:25%;"
                                @break
                            @case(6)
                                style="width:50%;"
                                @break
                            @case(7)
                                style="width:75%;"
                                @break
                            @case(8)
                                style="width:100%;"
                                @break
                            @default
                            style="width:0%;"
                        @endswitch
                        ></div>
                    
                    @else
                        <div class="horizontal-steps-content">
                            <div class="step-item @if ($invoice->status == 4) current @endif">
                                <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ $invoice->display_shipped_at }}">Shipped</span>
                            </div>
                            <div class="step-item @if ($invoice->status == 7) current @endif">
                                <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ $invoice->display_received_at }}">Received</span>
                            </div>
                            <div class="step-item @if ($invoice->status == 8) current @endif">
                                <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ $invoice->display_paid_at }}">Paid</span>
                            </div>
                        </div>
                        <div class="process-line"
                        @switch($invoice->status)
                            @case(2)
                            @case(3)
                                style="width:0%;"
                                @break
                            @case(4)
                                style="width:0%;"
                                @break
                            @case(5)
                                style="width:50%;"
                                @break
                            @case(6)
                                style="width:50%;"
                                @break
                            @case(7)
                                style="width:50%;"
                                @break
                            @case(8)
                                style="width:100%;"
                                @break
                            @default
                            style="width:0%;"
                        @endswitch
                        ></div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endif