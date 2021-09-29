@extends('layouts.newLayout')

@section('title')
Contrato de Formulario Simple
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/js/forms/ponyfill.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/slider.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/animation.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/gallery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/jquery.easing.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-mask/jquery-mask.js') }}"></script>
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
@endsection

@section('content')
<nav class="navbar shadow-sm">
    <div class="container">
        <a class="navbar-brand mx-auto" href="#">
            <img src="{{ asset('assets/download/Blindaje-Legal-Patrimonial-Logo-Horizontal 1.png') }}" alt="" width="200">
        </a>
    </div>
</nav>

@if ($error === TRUE)
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger" rol="alert">
                <h5><strong>{!! $message !!}</strong></h5>
            </div>
        </div>
    </div>
@elseif ($error === FALSE)


    <div class="Bordes-inferiores-redondos" style="background: #B91029">
        <div class="Bordes-inferiores-redondos" style="background: white; text-align: center; padding: 50px 0px;">
            <img src="{{ asset('assets/download/Group 14.png') }}" class="ImagenesMasPequeñas" style="position: absolute; left: 0;" width="100">
            <img src="{{ asset('assets/download/Group 17.png') }}" class="ImagenesMasPequeñas" style="position: absolute; right: 0;" width="100">
            <div class="row">
                <div class="col-sm-12 col-lg-6 col-md-8 mx-auto ColumnaMasChicaEnMovil">
                    <h1 class="Poppins-semibold">Su contrato ha sido generado exitosamente</h1>
                    <img src="{{ asset('assets/download/Check.png') }}" alt="" width="100">
                    <p class="Poppins-medium" style="color: #FD4460">Antes de descargarlo, le invitamos a conocer nuestros servicios</p>
                </div>	
            </div>
        </div>
        <div class="Bordes-inferiores-redondos"style="background: linear-gradient(180deg, #B91029, #FD4460); text-align: center; padding: 50px 50px 0px;">
            <div class="row">
                <div class="col-lg-6 order-sm-1 order-lg-0 order-1">
                    <img src="{{ asset('assets/download/Ladron 1.png') }}" class="Ladron" width="400">
                </div>
                <div class="col-lg-5">
                    <h2 class="Poppins-semibold" style="color: white">Rente su bien inmueble sin temor y con la certeza de que estará protegido por profesionales</h2>
                    <hr style="color: transparent;">
                    <p class="Poppins-medium" style="color: white">Obtenga Protección Extra para su inmueble adquiriendo de forma fácil y rápida nuestros siguientes servicios:</p>
                </div>
            </div>
        </div>
    </div>



    {{-- UPGRADES --}}


    <div class="Bordes-inferiores-redondos shadow-sm" style="position: relative; background: white; text-align: center; padding: 10px 50px 50px;">
        <img src="{{ asset('assets/download/Cuadrados 1.png') }}" class="ImagenesMasPequeñas" style="position: absolute; left: 0; top: 200px" width="100">
        <img src="{{ asset('assets/download/Cuadrados 2.png') }}" class="ImagenesMasPequeñas" style="position: absolute; right: 0; top: 50px" width="100">
        <img src="{{ asset('assets/download/V arrow.png') }}" alt="" width="100">
        @if($cobranza === TRUE)

            <div class="row gx d-flex justify-content-center">
                <div class="col-lg-3 shadow-sm" style="padding: 0;margin: 10px 10px;border-radius: 30px">
                    <div class="card" style="border:0px">
                        <div class="card-body" style="background: linear-gradient(180deg, #B91029, #FD4460); border-radius: 30px">
                            <h2 class="Poppins-semibold" style="color: white">Protección Básica</h2>
                            <p class="Poppins-medium" style="color: white">Garantiza que, <br>con ayuda de un abogado, usted puede recuperar su propiedad, pagos adeudados de rentas, servicios y otros gastos relacionados al arrendamiento por medio de una Cobranza Extrajudicial.</p>
                            <a class="Poppins-semibold" style="color: white; text-decoration: none" href="#">Más info</a>
                        </div>
                    </div>
                    <span class="Poppins-bold" style="color: #51CB17; font-size: 20px;"><input type="radio" class="upgrade" name="upgrade" id="upgrade1" value="1"> Desde $2,650</span>
                </div>
                <div class="col-lg-3 shadow-sm" style="padding: 0;margin: 10px 10px;border-radius: 30px">
                    <div class="card" style="border:0px">
                        <div class="card-body" style="background: linear-gradient(180deg, #B91029, #FD4460); border-radius: 30px">
                            <h2 class="Poppins-semibold" style="color: white">Protección<br> Total</h2>
                            <p class="Poppins-medium" style="color: white">Garantiza, gracias a un Contrato hecho por Profesionales, tras una investigación para validar la identidad de los firmantes, que usted recupere su propiedad; y que, de ser necesario se realice la Cobranza Judicial por falta de pago de rentas y servicios.</p>
                            <a class="Poppins-semibold" style="color: white; text-decoration: none" href="#">Más info</a>
                        </div>
                    </div>
                    <span class="Poppins-bold" style="color: #51CB17; font-size: 20px;"><input type="radio" class="upgrade" name="upgrade" id="upgrade2" value="2"> Desde $3,200</span>
                </div>
            </div>	
        @else 
        <div class="row gx d-flex justify-content-center">
            <div class="col-lg-6 shadow-sm" style="padding: 0;margin: 10px 10px;border-radius: 30px">
                <div class="card" style="border:0px">
                    <div class="card-body" style="background: linear-gradient(180deg, #B91029, #FD4460); border-radius: 30px">
                        <h2 class="Poppins-semibold" style="color: white">Protección de Cobranza</h2>
                        <p class="Poppins-medium" style="color: white">Garantiza que, <br>con ayuda de un abogado, usted puede recuperar su propiedad, pagos adeudados de rentas, servicios y otros gastos relacionados al arrendamiento por medio de una Cobranza Extrajudicial.</p>
                        <a class="Poppins-semibold" style="color: white; text-decoration: none" href="#">Más info</a>
                    </div>
                </div>
                <span class="Poppins-bold" style="color: #51CB17; font-size: 20px;"><input type="radio" class="upgrade" name="upgrade" id="upgrade6" value="3"> Desde $2,000</span>
            </div>
        
        </div>	
        @endif
    </div>


    {{-- SERVICIOS DE CONTRATO --}}



    <hr style="color: transparent;">
    <div class="Bordes-inferiores-redondos" style="background: white; text-align: center; padding: 10px 50px 50px;">
        <h3 class="w-50 mx-auto Poppins-semibold" style="color: #FD4460">Servicios de Contrato</h3>
        <br>
        <img src="{{ asset('assets/download/Cuadrados 3.png') }}" class="ImagenesMasPequeñas" style="position: absolute; right: 0;" width="100">
        <div class="row gx d-flex">			
            <div class="col-lg-5 offset-lg-2 shadow-sm" style="padding: 0;border-radius: 30px">
                <div class="card" style="border:0px">
                    <div class="card-body" style="background: linear-gradient(180deg, #B91029, #FD4460); border-radius: 30px">
                        <h2 class="Poppins-semibold" style="color: white">Extinción de Dominio</h2>
                        <p class="Poppins-medium" style="color: white">Agregue a su Contrato una cláusula que lo proteja usted y su inmueble, en caso de que el ocupante cometiera un delito en su propiedad.</p>
                    </div>
                </div>
                <span class="Poppins-bold" style="color: #51CB17; font-size: 20px;"><input type="checkbox" name="serviciodecontrato[]" value="extincion"> $150</span>
            </div>
        </div>
        <br>
        <img src="{{ asset('assets/download/Cuadrados 4.png') }}" class="ImagenesMasPequeñas" style="position: absolute; left: 0;" width="100">
        <div class="row gx d-flex">
            <div class="col-lg-5 offset-lg-4 shadow-sm" style="padding: 0;border-radius: 30px">
                <div class="card" style="border:0px">
                    <div class="card-body" style="background: linear-gradient(180deg, #B91029, #FD4460); border-radius: 30px">
                        <h2 class="Poppins-semibold" style="color: white">Investigación del Arrendatario</h2>
                        <p class="Poppins-medium" style="color: white">Con el fin de saber si el arrendatario tiene Antecedentes Legales o coincidencias con Registros Judiciales, como por ejemplo, haber sido demandado por falta de pago o haber sido desalojado.</p>
                    </div>
                </div>
                <span class="Poppins-bold" style="color: #51CB17; font-size: 20px;">
                    {{-- <input type="checkbox" name="serviciodecontrato"> 
                    $1,500 --}}
                    En Construcción
                
                </span>
            </div>
        </div>
        <br>
        <img src="{{ asset('assets/download/Cuadrados 5.png') }}" class="ImagenesMasPequeñas" style="position: absolute; right: 0;" width="100">
        <div class="row gx d-flex">
            <div class="col-lg-5 offset-lg-2 shadow-sm" style="padding: 0;border-radius: 30px">
                <div class="card" style="border:0px">
                    <div class="card-body" style="background: linear-gradient(180deg, #B91029, #FD4460); border-radius: 30px">
                        <h2 class="Poppins-semibold" style="color: white">Firma Electrónica</h2>
                        <p class="Poppins-medium" style="color: white">Es la forma más fácil y segura de autentificar la validez de sus Contratos Inmobiliarios. El arrendador y el arrendatario reciben un enlace que se abre en un dispositivo con pantalla táctil para que lo puedan firmar con el dedo.</p>
                    </div>
                </div>
                <span class="Poppins-bold" style="color: #51CB17; font-size: 20px;"><input type="checkbox" name="serviciodecontrato[]" value="firma"> $1,500</span>
            </div>
        </div>
        <br>
        <br>
        <h3 class="w-50 mx-auto Poppins-semibold" style="color: #FD4460">Métodos de Pago</h3>
        <br>
        <div class="row gx d-flex justify-content-center">
            <div class="col-lg-3 shadow" style="padding: 0;margin: 10px 10px;border-radius: 30px">
                <div class="card" style="border:0px">
                    <div class="card-body" style="border-radius: 30px">
                        <img src="{{ asset('assets/download/Tarjetas.png') }}" alt="" width="200">
                        <img src="{{ asset('assets/download/Logos de Pago.png') }}" alt="" width="200">
                        <h2 class="Poppins-semibold" style="color: #FD4460">Pague en Línea con su tarjeta</h2>
                        <p class="Poppins-medium" style="color: #6C6C6C">Para su comodidad, puede pagar rápidamente con su Tarjeta de Crédito o Débito.</p>
                    </div>
                </div>
                <span class="Poppins-bold" style="color: #51CB17; font-size: 20px;"><input type="radio"  class="continue_payment" name="payment_type" value="card"></span>
            </div>
            <div class="col-lg-3 shadow" style="padding: 0;margin: 10px 10px;border-radius: 30px">
                <div class="card" style="border:0px">
                    <div class="card-body" style="border-radius: 30px">
                        <br>
                        <img src="{{ asset('assets/download/Billetes.png') }}" alt="" width="200">
                        <br><br>
                        <img src="{{ asset('assets/download/oxxo_pay_Grande 1.png') }}" alt="" width="200">
                        <br>
                        <h2 class="Poppins-semibold" style="color: #FD4460; margin-top: 15px">Pague en Efectivo en OXXO</h2>
                        <p class="Poppins-medium" style="color: #6C6C6C">Una forma conveniente de Pagar en Efectivo desde el Oxxo más cercano a su hogar.</p>
                    </div>
                </div>
                <span class="Poppins-bold" style="color: #51CB17; font-size: 20px;"><input class="continue_payment" type="radio" name="payment_type" value="oxxo"></span>
            </div>
        </div>	
        <br>
        {{-- <button type="button" class="btn Poppins-semibold continue_payment" style="background: linear-gradient(180deg, #20AC2E, #59E118);color: white;">CONTINUAR</button> --}}
        <br><br>
        <div class="row">
            <div class="col-sm-12 align-self-start">
     
                <div class="row paymentMethod sectionOxxo card-Payment margin-top20">
                    <div class="col-sm-12 text-center">
                        <img class="img-fluid img-responsive text-center" width="300" src="{{ asset('assets/images/oxxo.jpg') }}" alt=""><br><br>
                        <h5 class="text-center">Pago en Oxxo (Efectivo)</h5><br>
                        <h6 class="text-center">Monto a pagar <span class="amount"></span> MXN</h6><br>
                        <div class="reference">
                            <h3 class="text-center">Referencia <span class="oxxoReference"></span></h3>
                            {{-- <h6 class="text-center">Comisión <span class="oxxoComission"></span></h6>
                            <h6 class="text-center">Total a Depositar <span class="oxxoTotal"></span></h6> --}}
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <h6 class="text-center">
                            OXXO cobrará una comisión adicional al momento de realizar el pago.
                        </h6>
    
                        <strong>
                            <p>
                                INSTRUCCIONES
                            </p>
                        </strong>
                        <p>
                            1. Acude a la tienda OXXO más cercana.
                            2. Indica en la caja que quieres realizar un pago de OXXOPay. <br>
                            3. Dicta al cajero el número de referencia en esta ficha para que la tecleé directamente en la pantalla de venta. <br>
                            4. Realiza el pago correspondiente con dinero en efectivo. <br>
                            5. Al confirmar tu pago, el cajero te entregará un comprobante impreso. En él podrás verificar que se haya realizado correctamente. Conserva este comprobante de pago. <br>
                            6. Luego informa sobre tu pago, sube tu comprobante y lo procesaremos. <br>
                        </p>
                    </div>
                    <br>
                    <div class="col-sm-12 margin-top20 mt-4 text-center">
                        <button class="btn btn-primary paymentOxxo" style="display: block !important; margin: auto;" type="button"><i class="icon-check"></i> Solicitar Referencia</button>
                    </div>
                    <div class="col-sm-12 mt-4 paymentOxxoFinish text-center">
                        <div class="oxxoButton"></div>
                    </div>
                </div>
                <form id="card-form">
                    <div class="row paymentMethod sectionCard card-Payment margin-top20">
                        <div class="col-sm-12 text-center">
                            <img class="img-fluid img-responsive text-center" width="300" src="{{ asset('assets/images/card.jpg') }}" alt=""><br><br>
                            <h5 class="text-center">Tarjeta de Crédito o Débito</h5> <br>
                            <h6 class="text-center">Monto a pagar <span class="amount"></span> MXN</h6><br>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="md-form">
                                <input class="form-control form-control-lg" placeholder="Nombre del titular tarjeta" name="nameCard" id="nameCard" data-conekta="card[name]" type="text">
                                <label for="owner_email">Nombre del titular tarjeta</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="md-form">
                                <input class="form-control form-control-lg" placeholder="4242-4242-4242-4242" name="numberCard" maxlength="19" id="numberCard" data-conekta="card[number]" type="text">
                                <label for="owner_email">Número de la Tarjeta</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="md-form">
                                <input class="form-control form-control-lg" placeholder="999" maxlength="4" name="cvcCard" id="cvcCard" data-conekta="card[cvc]" type="password">
                                <label for="owner_email">CVC</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="owner_email">Fecha de expiración (MM/AAAA)</label>
                            </div>
                            <div class="md-form">           
                                <input class="form-control form-control-lg" placeholder="MM" maxlength="2" name="expCard" data-conekta="card[exp_month]" id="expMMCard" type="number">
                                <label for="owner_email">Mes</label>
                                <input class="form-control form-control-lg" placeholder="AAAA" maxlength="4" name="expCard" data-conekta="card[exp_year]" id="expAACard" type="number">
                                <label for="owner_email">Año</label>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 mt-4" >
                            <div class="col-sm-12 margin-top20 text-center">
                                <button class="btn btn-primary  methodPayment" style="display: block !important; margin: auto;" type="button"><i class="icon-check"></i> Generar Pago</button>
                            </div>
                            <div class="col-sm-12 mt-2 paymentCardFinish text-center">
                                <div class=" cardButton"></div>
                            </div>
                            <input name="contrat" value="{{ Crypt::encrypt($contrat) }}" type="hidden">
                        </div>
                    </div>
                </form>
            </div>
        </div>

       
        <br><br><br>
        <img src="{{ asset('assets/download/Group 14.png') }}" class="ImagenesMasPequeñas" style="position: absolute; left: 0;" width="100">
        <img src="{{ asset('assets/download/Group 17.png') }}" class="ImagenesMasPequeñas" style="position: absolute; right: 0;" width="100">
        <div class="row">
            <div class="col-sm-12 col-lg-6 col-md-8 mx-auto ColumnaMasChicaEnMovil">
                <h3 class="Poppins-semibold" style="color: #6C6C6C">Descargue su contrato sin el servicio de protección de arrendamiento</h3>
                <br><br>
                <img src="{{ asset('assets/download/Contrato.png') }}" alt="">
                <br><br>
                <p class="Poppins-medium" style="color: #FD4460">Para complementar su contrato, le invitamos a <br>añadir alguno(s) de nuestros anteriores servicios </p>
                <p class="Poppins-semibold" style="color: #FD4460">No se arriesgue. ¡Proteja su inmueble!</p>
            </div>	
        </div>

        <br><br>
        <a target="_blank" href="{{ route('file.pdf', Crypt::encrypt($contrat)) }}" class="btn Poppins-semibold" style="background: linear-gradient(180deg, #B91029, #FD4460);color: white;">DESCARGAR</a>
    </div>

@endif


    <hr style="color: transparent;">
    <div style="width: 99%">
        <div class="row">
            <div class="col-lg-6 d-flex" style="background: linear-gradient(180deg, #424141, #6C6C6C);">
                <div class="container">
                    <div class="ms-auto p-2 col-lg-6" style="margin: 30px 0px">
                        <p class="Poppins-medium IconosAlCentro" style="color: white;">Dirección: Centro de las Campanas 3 Despacho 304 Torre A, San Andrés Alenco, 54040</p> 
                        <br>
                        <div class="IconosAlCentro">
                        <a class="Poppins-medium" style="color: white; text-align: center; text-decoration: none" href="#">Política de Privacidad</a> 	
                        </div>
                        <br><br>
                        <div class="ms-auto IconosAlCentro">
                        <a href="#"><img src="{{ asset('assets/download/Facebook.png') }}" alt="" width="30px"></a>
                        <a href="#"><img src="{{ asset('assets/download/WhatsApp.png') }}" alt="" width="30px"></a>	
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" style="padding: 0">
                <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d1880.0013602246656!2d-99.21875327441558!3d19.541496767658366!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sDespacho%20304%20Torre%20A%2C%20San%20Andr%C3%A9s%20Alenco%2C%2054040!5e0!3m2!1ses-419!2sve!4v1617010501748!5m2!1ses-419!2sve" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
    
    @if ($error === FALSE)
    Conekta.setPublicKey('key_PhUgqYQqMgr5bqLDnsmsrvQ');
    $(function() {
        $('.sectionPayment, .reference, .sectionOxxo, .sectionCard, .loading, .paymentOxxoFinish, .paymentCardFinish, .paymentMethod').hide('fast');
       
        amount();

        $('#numberCard').mask('9999-9999-9999-9999');
        $('#cvcCard').mask('9999');
        $('#expMMCard').mask('99');
        $('#expAACard').mask('9999');

        $('.continue_payment').click(e => {
            let type = $('input[name="payment_type"]:checked').val();
            if(type=='card'){
                $('.sectionOxxo').hide('fast');
                $('.sectionCard').show('fast');
            }else{
                $('.sectionCard').hide('fast');
                $('.sectionOxxo').show('fast');
            }
           
        });
        $('input[type="checkbox"]').click(
            e => amount()
        );
        $('.upgrade').click(e => amount());

        $('.paymentOxxo').click(e => {
            var services = $('input[type="checkbox"]:checked').map(function() {
                return $(this).val();
            }).get()
            console.log($('input[name="upgrade"]:checked').val());
            if(!$('input[name="upgrade"]:checked').val()&&services.length==0){
                swal({
                    title: 'Elije uno!',
                    html: `Debes escoger un tipo de protección y/ó un servicio para continuar`,
                    type: 'warning',
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Entiendo!',
                    showCancelButton: false
                });
                return false;
            }
            $.ajax({
                url: "{{ route('payments.store') }}",
                data: {
                    contrat : $('input[name="contrat"]').val(),
                    upgrade : $('input[name="upgrade"]:checked').val(),
                    payment_type : 'OXXO',
                    token_id: null,
                    services: services
                },
                type: 'POST',
                dataType: "JSON",
                statusCode: {
                    422: function(data){
                        Swal.fire({
                            title: '',
                            html: data.responseJSON.message,
                            type: data.responseJSON.type,
                            allowOutsideClick : false,
                            allowEscapeKey : false,
                            showCancelButton: false,
                            focusConfirm: true,
                            confirmButtonText: 'Aceptar'
                        });
                    },
                    200: function(data) {
                        $('.paymentOxxoFinish').show('fast');
                        $('.reference').show('fast');
                        $('.oxxoReference').html(data.message.reference);
                        // $('.oxxoComission').html(data.message.comission);
                        // $('.oxxoTotal').html(data.message.total);
                        if (data.message.policy !== ""){
                            $('.oxxoButton').html(data.message.policy);
                        }
                    }
                }
            });
        });
        
        $('.methodPayment').click(e => {
            var services = $('input[type="checkbox"]:checked').map(function() {
                return $(this).val();
            }).get()
            console.log($('input[name="upgrade"]:checked').val());
            if(!$('input[name="upgrade"]:checked').val()&&services.length==0){
                swal({
                    title: 'Elije uno!',
                    html: `Debes escoger un tipo de protección y/ó un servicio para continuar`,
                    type: 'warning',
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Entiendo!',
                    showCancelButton: false
                });
                return false;
            }
      
            Conekta.Token.create($("#card-form"), conektaSuccessResponseHandler, conektaErrorResponseHandler);
        });
    });

    var conektaSuccessResponseHandler = function(token) {
        var services = $('input[type="checkbox"]:checked').map(function() {
            return $(this).val();
        }).get()
     
        $.ajax({
            url: "{{ route('payments.store') }}",
            data: {
                contrat : $('input[name="contrat"]').val(),
                upgrade : $('input[name="upgrade"]:checked').val(),
                payment_type : 'CARD',
                token_id: token.id,
                services: services
            },
            type: 'POST',
            dataType: "JSON",
            statusCode: {
                422: function(data){
                    Swal.fire({
                        title: '',
                        html: data.responseJSON.message,
                        type: 'error',
                        allowOutsideClick : false,
                        allowEscapeKey : false,
                        showCancelButton: false,
                        focusConfirm: true,
                        confirmButtonText: 'Aceptar'
                    });
                },
                200: function(data) {
                    $('.paymentCardFinish').show('fast');
                    swal({
                        title: 'Pago Completado',
                        html: `Ha completado el pago, por favor pulsa el boton "Siguiente" para continuar`,
                        type: 'success',
                        allowOutsideClick: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        showCancelButton: false
                    });
                    if (data.message.policy !== ""){
                        $('.cardButton').html(data.message.policy);
                    }
                }
            }
        });
    };

    var conektaErrorResponseHandler = function(response) {
        Swal.fire({
            title: '',
            html: 'Los datos de la tarjeta son inválidos',
            type: 'error',
            allowOutsideClick : false,
            allowEscapeKey : false,
            showCancelButton: false,
            focusConfirm: true,
            confirmButtonText: 'Aceptar'
        });
    };

    let amount = () =>{
       

        var services = $('input[type="checkbox"]:checked').map(function() {
            return $(this).val();
        }).get()
       
        $.ajax({
            url: "{{ route('payments.amount') }}",
            data: {
                contrat : $('input[name="contrat"]').val(),
                upgrade :  $('input[name="upgrade"]:checked').val(),
                services:services
            },
            type: 'POST',
            dataType: "JSON",
            statusCode: {
                200: function(data) {
                    $('.amount').html(data.message);
                }
            }
        });
    }
    @endif
</script>
@endsection