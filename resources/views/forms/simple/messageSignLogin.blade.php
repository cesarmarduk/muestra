@extends('layouts.form')

@section('title')
Contratacion de {!! $servicio !!} realizada! 
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/js/forms/ponyfill.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/slider.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/animation.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/gallery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/jquery.easing.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/main.js') }}"></script>
@endsection

@section('content')
@include('layouts.partials-forms.slider')

<section id="contact" class="section-1 form">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-7 align-self-start">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="alert alert-{{ $color }}" rol="alert">
                            {!! $message !!}
                        </div>
                    </div>

                    <div class="col-sm-12 text-left">
                        <div class="login-area col-sm-12 p-0">
                            <div class="d-table col-sm-12 p-0">
                                <div class="d-table-cell col-sm-12 p-0">

                       
                                    <div class="login-form">
                                        <div class="logo text-center">
                                            <a href="{{ route('login') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="image"></a>
                                        </div>
                                        <br>
                                        @include('dashboard.layouts.partials.errors')
                                        <form method="POST" action="{{ route('login') }}">
                                            <div class="form-group">
                                                <div class="remember-forgot">
                                                    {{-- <label class="checkbox-box">Remember me
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label> --}}
                        
                                                    <a href="javascript:void(0)" class="forgot-password">Enviar Contraseña a mi correo</a>
                                                </div>
                                            </div>

                                            <div class="form-group p-0">
                                                
                                                    <div class="col-12 col-md-12 p-0">
                                                    <div class="input-group flex-nowrap p-0">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="material-icons">person</i></span>
                                                        </div>
                                                        <input type="text" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                                                    </div>
                                                    </div>
                                              
                                            </div>
                                           
                                            
                                            <div class="form-group p-0">
                                             
                                                    <div class="col-12 col-md-12 p-0">
                                                    <div class="input-group flex-nowrap p-0">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="material-icons">lock</i></span>
                                                        </div>
                                                        <input type="password" class="form-control" name="password" placeholder="Password" value="{{ old('password') }}">
                                                    </div>
                                                    </div>
                                                
                                            </div>

                                            <input name="contrat" value="{{ Crypt::encrypt($contrat) }}" type="hidden">
                                          
                                            {{ csrf_field() }}
                                            <button type="submit" class="login-btn btn btn-danger">Ingresar</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
               
                    </div>
                    <div class="col-sm-12 text-left">
                        <div >
                            <p class="bold">
                                <br>
                                <b>INSTRUCCIONES</b> <br>
                                <br>
                                Tu contrato esta listo y es necesario que ingreses a la plataforma y lo envies a las partes para que puedas gestionar la firma electrónica.
                                <br><br>
                                <b>1.-</b> Para ingresar revisa tu correo donde te enviamos una clave para que ingreses con tu correo electrónico.
                                <br><br>
                                <b>2.-</b> Al ingresar ubica el documento y desde el boton presiona enviar firmas para que las partes inicien la firma electrónica desde su correo.
                                <br><br>
                                <b>3.-</b> Una vez firmada y podras entrar al sistema a autorizarla y enviarla a las partes.

                            </p>
                           
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-images col-sm-12 col-md-12 col-lg-5">
                <div class="gallery">
                    <div class="mask-radius"></div>
                    <img src="{{ asset('assets/images/about-2.jpg') }}" class="fit-image" alt="Fit Image">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript">


    $(document).on('click', '.forgot-password', e => {
        resendPasswordContrat();

    });

    let resendPasswordContrat = (val) =>{
        $.ajax({
            url: "{{ route('resendpass.contrat') }}",
            data: {
                contrat : $('input[name="contrat"]').val()
            },
            type: 'POST',
            dataType: "JSON",
            statusCode: {
                200: function(data) {
                    console.log(data);
                }
            }
        });
    }
</script>
@endsection