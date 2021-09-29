<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- ================== BEGIN METAS ================== -->
        <meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1">
        <meta name="encoding" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="robots" content="index, follow">
        <title>@yield('title', 'Login') | LGCverify</title>
        <!-- ================== END METAS ================== -->
        <!-- ================== CSRF Token ================== -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- ================== END CSRF Token ================== -->
        <!-- ================== BEGIN FAVICON ================== -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}">
        <!-- ================== END FAVICON ================== -->
        <!-- ================== BEGIN CSS ================== -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/icons/material-icons/css/material-icons.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-ui/css/jquery-ui.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/normalize/normalize.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/animate/animate.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/mdb/css/mdb.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/waves/css/waves.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/mscrollbar/css/jquery.mCustomScrollbar.css') }}">
        @yield('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
        <!-- ================== END CSS ================== -->
        <!-- ================== BEGIN SCRIPTS ================== -->
        <script type="text/javascript" src="{{ asset('assets/plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/jquery-migrate/jquery-migrate-1.4.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/jquery-ui/js/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/modernizr/modernizr.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/wow/wow.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/waves/js/waves.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/moment/moment.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/jquery-slimscroll/jquery-slimscroll.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
    </head>
    <body class="main-body">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{ asset('assets/images/loader.svg') }}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
		<div class="container-fluid">
            @yield('content')
        </div>
        @yield('plugins')
        @yield('js')
    </body>
</html>
