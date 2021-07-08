@extends('layouts.guest')

@section("content")
<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5">
                <div class="card">
                    <!-- Logo-->
                    <div class="card-header pt-4 pb-4 text-center bg-primary">
                        <a href="index.html">
                            <span><img src="/images/logo.png" alt="" height="18"></span>
                        </a>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <div >
                                    <i class="dripicons-wrong me-2"></i><strong>{{ __('Whoops! Something went wrong.') }}</strong>
                                </div>

                                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Enter your name" required autofocus >
                            </div>

                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Email address</label>
                                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password"/>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confim Password</label>
                                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="current-password" placeholder="Confirm your password"/>
                            </div>


                            <div class="mb-3 text-center">
                                <button class="btn btn-primary" type="submit"> Sign Up </button>
                            </div>

                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">Already have account? <a href="{{ route('login') }}" class="text-muted ms-1"><b>Log In</b></a></p>
                    </div> <!-- end col-->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>

@endsection