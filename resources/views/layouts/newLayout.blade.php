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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap" rel="stylesheet"> 
        <style type="text/css">
            h1{
                color: #6C6C6C;
                text-align: center;
            }
            .Poppins-medium{
                font-family: 'Poppins', sans-serif;
                font-weight: 400;
            }
            .Poppins-semibold{
                font-family: 'Poppins', sans-serif;
                font-weight: 600;
            }
            .Poppins-bold{
                font-family: 'Poppins', sans-serif;
                font-weight: 700;
            }    	
            .Bordes-inferiores-redondos{
                border-bottom-left-radius: 50px;
                border-bottom-right-radius: 50px;
            }
            .Ladron{
                margin-top: -100px;
            }
            @media (max-width: 576px){
                .ImagenesMasPequeñas{
                    width: 50px;
                }
                .ColumnaMasChicaEnMovil{
                    width: 75%;
                }			
                .IconosAlCentro{
                    text-align: center;
                }
            }	
            @media (max-width: 991px){
                .Ladron{
                    margin-top: 0px;
                    width: 300px
                }
            }		
        </style>

        <!-- ================== BEGIN CSS ================== -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/sweetalert/css/sweetalert.css') }}">
        @yield('css')
 
      
        <!-- ================== END CSS ================== -->
        <!-- ================== BEGIN SCRIPTS ================== -->
        <script type="text/javascript" src="{{ asset('assets/plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/jquery-migrate/jquery-migrate-1.4.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/jquery-ui/js/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    </head>

    <body>


        @yield('content')


    <footer>
		<div class="text-center p-3 Poppins-semibold" style="background: linear-gradient(180deg, #B91029, #FD4460); color: white">
			© 2021 BLINDAJE LEGAL PATRIMONIAL
		</div>
	</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script> 
    @yield('plugins')
    @yield('js')
    </body>
</html>