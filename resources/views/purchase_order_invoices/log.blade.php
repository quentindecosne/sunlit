<div class="col-lg-6">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title mb-3">Invoice log</h4>

            <div class="table-responsive">
                <table class="table table-sm table-centered mb-0">
                    <thead>
                        <th>Date</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($activity->updated_at)->toFormattedDateString() }}
                                </td>
                                <td>
                                    {!! $activity->description.' by <b>'.$activity->causer->name.'</b>' !!}
                                </td>
                            </tr>
                        @endforeach
                        
{{--                         @if ($invoice->status >= 8)
                        <tr>
                            <td>{{ $invoice->display_paid_at }}</td><td>The invoice has been paid, <b>#{{ $invoice->payment_reference }} / <b>{{ __('app.currency_symbol_inr')}}{{ $invoice->paid_exchange_rate }}</b></b></td>
                        </tr>
                        @endif
                        @if ($invoice->status >= 7)
                        <tr>
                            <td>{{ $invoice->display_received_at }}</td><td>The order has been received</td>
                        </tr>
                        @endif
                        @if ($invoice->status >= 6)
                        <tr>
                            <td>{{ $invoice->display_cleared_at }}</td><td>The order is cleared from customs</td>
                        </tr>
                        @endif
                        @if ($invoice->status >= 5)
                        <tr>
                            <td>{{ $invoice->display_customs_at }}</td><td>The order is at Customs, Bill of Entry <b>#{{ $invoice->boe_number }}</b></td>
                        </tr>
                        @endif
                        @if ($invoice->status >= 4)
                        <tr>
                            <td>{{ $invoice->display_shipped_at }}</td><td>The order has been shipped</b></td>
                        </tr>
                        @endif
 --}}                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
