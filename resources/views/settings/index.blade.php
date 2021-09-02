@extends('layouts.app')

@section('page-title', 'Global settings')

@section('content')

<div class="row">
    <form action="{{ route('settings.update') }}" method="POST">
        @csrf()
        @method('PUT')
        @foreach ($settings as $group=>$gsettings)
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="mb-4">{{ ucfirst($group) }}</h4>
                                @foreach($gsettings as $key =>$value)  
                                    <div class="mb-3">
                                        <div>
                                            <label class="form-label" for="{{ $key }}">{{ ucfirst($key)}}</label>
                                            <input type="text" class="form-control" name="{{ $group }}__{{ $key }}" id="{{ $key }}" placeholder="" value="{{ $value }}" required @if (Auth::user()->cannot('edit settings')) disabled @endif>
                                        </div>
                                    </div>
                                @endforeach
                            </div><!-- end col-->
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        @endforeach
        <button class="btn btn-primary" type="submit">Save settings</button>
    </form>
</div>



@endsection

@section('page-scripts')
    <script>
        
 $(document).ready(function () {
    "use strict";

  


    @if(Session::has('success'))
        $.NotificationApp.send("Success","{{ session('success') }}","top-right","","success")
    @endif
    @if(Session::has('error'))
        $.NotificationApp.send("Error","{{ session('error') }}","top-right","","error")
    @endif

});

    </script>    
@endsection
