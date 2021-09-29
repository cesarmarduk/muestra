<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>@yield('title', 'Register') | Legal Global Consulting S.C.</title>
        <!-- ================== BEGIN METAS ================== -->
        <meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1">
        <meta name="encoding" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="robots" content="index, follow">
        <meta name="application-name" content="Legal Global Consulting S.C.">
        <meta name="copyright" content="Legal Global Consulting S.C.">
        <meta name="description" content="Corporativo Jurídico enfocado al sector Inmobiliario, el cuál da un Servicio Integral a sus socios en sus diferentes áreas.">
        <meta name="author" content="Eduardo Estevez - www.netstudios.com.mx">
        <!-- ================== END METAS ================== -->
        <!-- ================== CSRF Token ================== -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- ================== END CSRF Token ================== -->
        <!-- ================== BEGIN FAVICON ================== -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}">
        <!-- ================== END FAVICON ================== -->
        <!-- ================== BEGIN CSS ================== -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/icons/material-icons/css/material-icons.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/icons/icons/css/icons.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-ui/css/jquery-ui.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/normalize/normalize.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/animate/animate.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/mdb/css/mdb.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/waves/css/waves.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/sweetalert/css/sweetalert.css') }}">
        @yield('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/slider.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/animation.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/main.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/default.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">
        <!-- ================== END CSS ================== -->
        <!-- ================== BEGIN SCRIPTS ================== -->
        <script type="text/javascript" src="{{ asset('assets/plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/jquery-migrate/jquery-migrate-1.4.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/jquery-ui/js/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/mdb/js/mdb.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/modernizr/modernizr.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/wow/wow.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    </head>

    <body>
        @include('layouts.partials-forms.nav')
        @yield('content')
		@include('layouts.partials-forms.footer')
        <a href="javascript:void(0)" class="back-to-top"><i class="material-icons">arrow_upward</i></a>
        @yield('plugins')
        @yield('js')
    </body>
</html>