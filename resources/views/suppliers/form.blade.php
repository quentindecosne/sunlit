@extends('layouts.app')

@section('title')
    @parent() | Create a supplier
@endsection

@section('page-title', 'Create a Supplier')

@section('content')

<div class="row">
    <div class="col-9">
        <div class="card">
            <div class="card-body">
                <x-forms.errors class="mb-4" :errors="$errors" />
                    <form action="@if ($supplier->id) {{ route('suppliers.update', $supplier->id) }} @else {{ route('suppliers.store') }} @endif" method="POST" class="needs-validation" novalidate>
                        @csrf()
                        @if ($supplier->id)
                            @method('PUT')
                        @endif

                        <div class="mb-3 row">
                            <div class="col-xl-5">
                                <x-forms.input label="company" name="company" value="{{ old('company', $supplier->company) }}" required="true"/>
                            </div>
                            <div class="col-xl-2">
                                <x-forms.input label="GSTIN" name="gstin" value="{{ old('gstin', $supplier->gstin) }}" required="true"/>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-xl-5">
                                <x-forms.input label="contact person" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}" required="true"/>
                            </div>
                            <div class="col-xl-2">
                                <label class="form-label" for="currency-select">Currency</label>
                                <select class="currency-select form-control" name="currency">
                                    @if ($supplier->currency)
                                        <option value="{{$supplier->currency}}" selected="selected">{{strtoupper($supplier->currency)}}</option>
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('error.form_invalid_field', ['field' => 'currency code' ]) }}
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <label class="form-label" for="credit-select">Credit Period</label>
                                <select class="credit-select form-control" name="credit_period">
                                    @if ($supplier->credit_period)
                                        <option value="{{$supplier->credit_period}}" selected="selected">{{$supplier->credit_period}} days</option>
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('error.form_invalid_field', ['field' => 'currency code' ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-xl-12">
                                <x-forms.input label="address" name="address" value="{{ old('address', $supplier->address) }}" required="true"/>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-xl-12">
                                <x-forms.input label="address 2" name="address2" value="{{ old('address2', $supplier->address2) }}" required="false"/>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-xl-3">
                                <label class="form-label" for="country-select">Country</label>
                                <select class="country-select form-control" name="country">
                                    @if ($supplier->country)
                                        <option value="{{$supplier->country}}" selected="selected" required>{{$supplier->country}}</option>
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('error.form_invalid_field', ['field' => 'country' ]) }}
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <label class="form-label" for="state-select">State</label>
                                <select class="state-select form-control" name="state_id">
                                    @if ($supplier->state)
                                        <option value="{{$supplier->state->id}}" selected="selected">{{$supplier->state->name}}</option>
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('error.form_invalid_field', ['field' => 'state' ]) }}
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <x-forms.input label="city" name="city" value="{{ old('city', $supplier->city) }}" required="true"/>
                            </div>
                            <div class="col-xl-2">
                                <x-forms.input label="zip code" name="zip_code" value="{{ old('zip_code', $supplier->zip_code) }}" required="true"/>
                            </div>
                            
                        </div>
                        <div class="mb-3 row">
                            <div class="col-xl-2">
                                <x-forms.input label="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" required="false"/>
                            </div>
                            <div class="col-xl-2">
                                <x-forms.input label="phone 2" name="phone2" value="{{ old('phone2', $supplier->phone2) }}"  required="false"/>
                            </div>
                           <div class="col-xl-4">
                                <x-forms.inputGroup label="email address" name="email" value="{{ old('email', $supplier->email) }}"  required="true" position="before" symbol="@"/>
                            </div>
                        </div>
                        
                        
                       
                        
                       
                        <button class="btn btn-primary" type="submit">@if ($supplier->id) {{ __('app.edit_title', ['field' => 'supplier']) }} @else {{ __('app.add_title', ['field' => 'supplier']) }} @endif</button>

                    </form>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
@endsection

@section('page-scripts')
    <script>
        var countryArray = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Cape Verde","Cayman Islands","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cruise Ship","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kuwait","Kyrgyz Republic","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mauritania","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Namibia","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Satellite","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","South Africa","South Korea","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","St. Lucia","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Uganda","Ukraine","United Arab Emirates","United Kingdom","Uruguay","Uzbekistan","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
        var countries = $.map(countryArray, function (obj) {
            obj.id = obj.id || obj;
            obj.text = obj.text || obj;
            return obj;
        });

        var countrySelect = $(".country-select").select2({
            data: countries,
        });

        var stateSelect = $(".state-select").select2();
        stateSelect.select2({
            ajax: {
                url: '{{route('ajax.states')}}',
                dataType: 'json'
            }
        });

        var currencies = [
            {
                id: 'inr',
                text: 'INR'
            },
            {
                id: 'usd', 
                text:'USD'
            }
        ]

        var credit = [
            {
                id: '0',
                text: 'None'
            },
            {
                id: '30',
                text: '30 days'
            },
            {
                id: '60', 
                text:'60 days'
            },
            {
                id: '90', 
                text:'90 days'
            }
        ]

        var currencySelect = $(".currency-select").select2();
        currencySelect.select2({data:currencies});

        var creditSelect = $(".credit-select").select2();
        creditSelect.select2({data:credit});

    </script>
@endsection