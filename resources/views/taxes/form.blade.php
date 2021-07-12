@extends('layouts.app')

@section('page-title', 'Taxes')

@section('content')

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <h4>Add a tax</h4>
                </div>
                    <form action="{{ route('taxes.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf()
                        <div class="mb-3">
                            <x-forms.input label="name" name="name" value="{{ old('name', $tax->name) }}" message="Please provide a name" required="true"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="display_amount">Amount</label>
                            <div class="input-group">
                                <input class="form-control" id="display_amount" name="display_amount" value="{{ old('display_amount', $tax->display_amount) }}" message="Please provide the percentage" required="true" data-toggle="input-mask" data-mask-format="00.00"/>
                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                            </div>
                        </div>
                       
                        <button class="btn btn-primary" type="submit">Create tax</button>

                    </form>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>


@endsection