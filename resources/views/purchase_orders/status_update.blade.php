
{{-- confirmed --}}
<div class="mt-lg-0 rounded @if ($purchase_order->status != 2) d-none @endif">
    <div class="card border">
        <div class="card-body">
            <form name="confirm-order-form" class="needs-validation" novalidate
                action="{{ route('purchase-orders.confirmed', $purchase_order->id) }}" method="POST" >
                @csrf()
                @method('PUT')
                <div class="mb-3 position-relative" id="confirmed_at">
                    <label class="form-label">Confirmation date</label>
                    <input type="text" class="form-control" name="confirmed_at" value="{{ $purchase_order->display_confirmed_at }}"
                    data-provide="datepicker" 
                    data-date-container="#confirmed_at"
                    data-date-autoclose="true"
                    data-date-format="M d, yyyy"
                    data-date-start-date="-1m"
                    data-date-end-date="+6m"
                    data-date-today-highlight="true"
                    required>
                    <div class="invalid-feedback">
                        Confirmation date is required
                    </div>
                </div>
                <button class="col-lg-12 text-center btn btn-warning" type="submit"
                    name="confirm_order">Confirm order</button>
            </form>

        </div>
    </div>
</div>

{{-- shipped --}}


{{-- customs --}}
<div class="mt-lg-0 rounded @if ($purchase_order->status != 4) d-none @endif">
    <div class="card border">
        <div class="card-body">
            <form name="customs-order-form" class="needs-validation" novalidate
                action="{{ route('purchase-orders.customs', $purchase_order->id) }}" method="POST">
                @csrf()
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-xl-4" id="customs_at">
                        <label class="form-label">Due date</label>
                        <input type="text" class="form-control" name="customs_at" value="{{ $purchase_order->display_customs_at }}"
                        data-provide="datepicker" 
                        data-date-container="#customs_at"
                        data-date-autoclose="true"
                        data-date-format="M d, yyyy"
                        data-date-start-date="-1m"
                        data-date-end-date="+6m"
                        data-date-today-highlight="true"
                        required>
                        <div class="invalid-feedback">
                            Customs date is required
                        </div>
                    </div>
                    <div class="col-xl-8" id="boe_number">
                        <label class="form-label">Bill of Entry #</label>
                        <input type="text" class="form-control" name="boe_number" required>
                    </div>
                </div>
                
             
                <button class="col-lg-12 text-center btn btn-warning" type="submit"
                    name="custom_order">Order at Customs</button>
            </form>

        </div>
    </div>
</div>

{{-- cleared --}}
<div class="mt-lg-0 rounded @if ($purchase_order->status != 5) d-none @endif">
    <div class="card border">
        <div class="card-body">
            <form name="clear-order-form" class="needs-validation" novalidate
                action="{{ route('purchase-orders.cleared', $purchase_order->id) }}" method="POST">
                @csrf()
                @method('PUT')
               <div class="row mb-3">
                    <div class="col-xl-4" id="cleared_at">
                        <label class="form-label">Cleared date</label>
                        <input type="text" class="form-control" name="cleared_at" value="{{ $purchase_order->display_cleared_at }}"
                        data-provide="datepicker" 
                        data-date-container="#cleared_at"
                        data-date-autoclose="true"
                        data-date-format="M d, yyyy"
                        data-date-start-date="-1m"
                        data-date-end-date="+6m"
                        data-date-today-highlight="true"
                        required>
                        <div class="invalid-feedback">
                            Cleared date is required
                        </div>
                    </div>
                     <div class="col-xl-6">
                        <label class="form-label">Customs Exchange Rate</label>
                        <div class="input-group">
                            <span class="input-group-text" id="cleared__currency">{{ __('app.currency_symbol_inr')}}</span>
                            <input class="form-control" id="customs_exchange_rate" name="customs_exchange_rate" value="{{ old('customs_exchange_rate', $purchase_order->customs_exchange_rate) }}" required >
                            <div class="invalid-feedback">
                                {{ __('error.form_invalid_field', ['field' => 'customs exchange rate']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-xl-10">
                        <label class="form-label">Amount at Customs</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ __('app.currency_symbol_inr')}}</span>
                            <input class="form-control" id="customs_amount" name="customs_amount" required />
                            <div class="invalid-feedback">
                                {{ __('error.form_invalid_field', ['field' => 'customs amount']) }}
                            </div>
                        </div>
                    </div>
                </div>

                <button class="col-lg-12 text-center btn btn-warning" type="submit"
                    name="cleared_order">Clear order</button>
            </form>

        </div>
    </div>
</div>

{{-- received --}}
<div class="mt-lg-0 rounded @if ($purchase_order->status != 6) d-none @endif">
    <div class="card border">
        <div class="card-body">
            <form name="receive-order-form"  class="needs-validation" novalidate
                action="{{ route('purchase-orders.received', $purchase_order->id) }}" method="POST">
                @csrf()
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-xl-6" id="received_at">
                        <label class="form-label">Received date</label>
                        <input type="text" class="form-control" name="received_at"
                            value="{{ $purchase_order->display_received_at }}" 
                            data-provide="datepicker" 
                            data-date-autoclose="true"
                            data-date-container="#received_at" 
                            data-date-format="M d, yyyy" 
                            data-date-today-highlight="true" 
                            data-date-start-date="-1m"
                            data-date-end-date="+6m" 
                            required>
                    </div>
                </div>
            
                <button class="col-lg-12 text-center btn btn-warning" type="submit"
                    name="ship_order">Receive order</button>
            </form>

        </div>
    </div>
</div>
