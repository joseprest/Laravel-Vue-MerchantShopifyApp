@extends('layouts.app')

@section('body', 'auth blank-page bg-full-screen-image')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/css/pages/authentication.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('app-assets/css/components.css') }}">
@endsection

@section('content')
    <div class="content-body">
        <section class="row flexbox-container">
            <div class="col-xl-8 col-11 d-flex justify-content-center">
                <div class="card bg-authentication rounded-0 mb-0">
                    <div class="row m-0">
                        <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                            <img src="{{ url('app-assets/images/pages/login.png') }}" alt="branding logo">
                        </div>
                        <div class="col-lg-6 col-12 p-0">
                            <div class="card rounded-0 mb-0 px-2 py-5">
                                <div class="card-header pb-1">
                                    <div class="card-title">
                                        <h4 class="mb-0">Reset Password</h4>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body pt">
                                        <form method="POST" action="{{ route('password.email') }}">
                                            @csrf
                                            <div class="form-label-group mt-3">
                                                <label>Email</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            @if(session('status'))
                                                <div class="text-success mb-4" role="alert">
                                                    {{ session('status') }}
                                                </div>
                                            @endif

                                            <a href="{{ route('login') }}" class="btn btn-link py-0">
                                                Login
                                            </a>
                                            <button type="submit" class="btn btn-primary float-right btn-inline mb-50">
                                                Submit
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <style>
        .form-label-group {
            margin-bottom: 1rem;
        }
        .form-label-group > label {
            position: unset;
            opacity: 1;
            padding: 0;
            padding-bottom: 0px;
            padding-bottom: 6px;
            color: #333;
        }
    </style>
@endsection
