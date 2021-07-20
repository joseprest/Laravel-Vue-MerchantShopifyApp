<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts._partials.head')
</head>
<body class="navbar-floating @yield('body')">
    <div id="app">
        @if(Auth::check())
            @include('layouts._partials.navbar')
            @include('layouts._partials.sidebar')
        @endif

	    <div class="app-content content">
	        <div class="content-overlay"></div>
	        <div class="header-navbar-shadow"></div>
	        <div class="content-wrapper">
            	@yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
