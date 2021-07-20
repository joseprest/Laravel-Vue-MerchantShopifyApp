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
                                        <h4 class="mb-0">Login</h4>
                                    </div>
                                </div>
                                <p class="pl-4 mt-3">Welcome back, please login to your account.</p>
                                <div class="card-content">
                                    <div class="card-body pt">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                <input id="user-name" name="email" type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required="">
                                                <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                                <label for="user-name">Username</label>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </fieldset>

                                            <fieldset class="form-label-group position-relative has-icon-left">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" id="user-password" placeholder="Password" required>
                                                <div class="form-control-position">
                                                    <i class="feather icon-lock"></i>
                                                </div>
                                                <label for="user-password">Password</label>
                                            </fieldset>
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <div class="text-left ml-3">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <label>
                                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                                <span class="">Remember me</span>
                                                            </label>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="text-right">
                                                    <a href="{{ route('password.request') }}" class="card-link">Forgot Password?</a>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <a href="{{ url('/signup') }}" class="card-link">Signup</a>
                                                <button type="submit" class="btn btn-primary ml-auto">Login</button>
                                            </div>
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
@endsection
