@extends('layouts.form')

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
@endsection

@section('content')
@include('layouts.partials-forms.slider')

<section id="progressbar" class="section-1 form">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-7 align-self-start">
                <form method="POST" action="{{ route('contrats.simple.store')}}" enctype="multipart/form-data">
                    @include('layouts.partials-forms.errors')
                    <div class="row form-content">
                        <div class="col-12 p-0">
                            <ul class="progressbar">
                                <li id="step1" class="active">Datos del Contrato</li>
                                <li id="step2">Firmantes</li>
                                <li id="step3">Contacto</li>
                            </ul>
                            <fieldset class="step-group" id="step-group1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="p-b-59 text-center">
                                                <h4><strong>Datos del Inmueble</strong></h4>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="property_address">
                                            <label for="property_address">Dirección</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="property_exterior">
                                            <label for="property_exterior">Número Exterior</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="property_interior">
                                            <label for="property_interior">Número Interior</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="property_colonia">
                                            <label for="property_colonia">Colonia</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="property_postal_code">
                                            <label for="property_postal_code">Código Postal</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group"> 
                                            <label for="">Estado</label>
                                            <select name="state_id" id="state_id" class="form-control">
                                                <option value="">-- Seleccione una opción --</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group"> 
                                            <label for="">Municipio</label>
                                            <select name="municipality_id" id="municipality_id" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="p-b-59 text-center">
                                                <h4><strong>Datos del Contrato</strong></h4>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="">Fecha de Inicio</label><br>
                                        <select name="contrat_beginning_day" class="form-control day" style="width: 30% !important; float:left">
                                        </select>
                                        <select name="contrat_beginning_mounth" class="form-control" style="width: 30% !important; float:left">
                                            <option value="01">Enero</option>
                                            <option value="02">Febrero</option>
                                            <option value="03">Marzo</option>
                                            <option value="04">Abril</option>
                                            <option value="05">Mayo</option>
                                            <option value="06">Junio</option>
                                            <option value="07">Julio</option>
                                            <option value="08">Agosto</option>
                                            <option value="09">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                        <select name="contrat_beginning_year" class="form-control year" style="width: 40% !important; float:left">
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="">Fecha de Culminación</label><br>
                                        <select name="contrat_finish_day" class="form-control day" style="width: 30% !important; float:left">
                                        </select>
                                        <select name="contrat_finish_mounth" class="form-control" style="width: 30% !important; float:left">
                                            <option value="01">Enero</option>
                                            <option value="02">Febrero</option>
                                            <option value="03">Marzo</option>
                                            <option value="04">Abril</option>
                                            <option value="05">Mayo</option>
                                            <option value="06">Junio</option>
                                            <option value="07">Julio</option>
                                            <option value="08">Agosto</option>
                                            <option value="09">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                        <select name="contrat_finish_year" class="form-control year" style="width: 40% !important; float:left">
                                        </select>
                                    </div>  
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="rent_monthly">
                                            <label for="rent_monthly">Monto de la Renta Mensual</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="deposit">
                                            <label for="deposit">Monto del Depósito</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="payment_beginning">Pago desde</label>
                                                <select name="payment_beginning" class="form-control day">
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="payment_finish">Pago hasta</label>
                                                <select name="payment_finish" class="form-control day">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="institution">
                                            <label for="institution">Institución Bancaria</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="titular">
                                            <label for="titular">Titular de la Cuenta</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="account">
                                            <label for="account">Cuenta Bancaria</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="clabe">
                                            <label for="clabe">Clabe Bancaria</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="p-b-59 text-center">
                                                <h4><strong>Datos del Uso</strong></h4>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="use2">
                                                <input class="form-check-input" type="radio" name="use" id="use2" value="Comercial" checked>
                                                <h5>Comercial</h5>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="use1">
                                                <input class="form-check-input" type="radio" name="use" id="use1" value="Habitacional">
                                                <h5>Habitacional</h5>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="use3">
                                                <input class="form-check-input" type="radio" name="use" id="use3" value="Industrial">
                                                <h5>Industrial</h5>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 input-group p-0">
                                        <a href="#progressbar" class="step-next step-next1 btn primary-button">SIGUIENTE<i class="icon-arrow-right-circle left"></i></a>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="step-group" id="step-group2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="p-b-59 text-center">
                                                <h4><strong>Datos del Arrendador</strong></h4>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="owner_type">Tipo de Arrendador</label>
                                        <select class="form-control owner_type" name="owner_type[]" data-id="1">
                                            <option value="Fisico">Persona Física</option>
                                            <option value="Moral">Persona Moral (empresa)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" name="owner_name[]" class="form-control form-control-lg">
                                            <label class="arrendadorFisico1">Nombre completo</label>
                                            <label class="arrendadorMoral1" style="display: none">Nombre o Razón social</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="owner_email[]">
                                            <label for="owner_email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="number" class="form-control form-control-lg" name="owner_phone[]">
                                            <label for="owner_phone">Télefono</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 arrendadorMoral1" style="display:none">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="owner_rfc[]">
                                            <label for="owner_rfc">RFC</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="p-b-59 text-center">
                                                <h4><strong>Domicilio del Arrendador</strong></h4>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="owner_address[]">
                                            <label for="owner_address">Dirección</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="owner_exterior[]">
                                            <label for="owner_exterior">Número Exterior</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="owner_interior[]">
                                            <label for="owner_interior">Número Interior</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="owner_colonia[]">
                                            <label for="owner_colonia">Colonia</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="owner_postal_code[]">
                                            <label for="owner_postal_code">Código Postal</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group"> 
                                            <label for="">Estado</label>
                                            <select name="owner_state[]" class="form-control states" data-id="1">
                                                <option value="">-- Seleccione una opción --</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group"> 
                                            <label for="">Municipio</label>
                                            <select name="owner_municipality[]" class="form-control" id="municipality_id1">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row contenedorArrendador">   
                                    <div class="col-sm-12 col-md-7">
                                        <div class="form-group">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Agregar Arrendador" class="addArrendador"><h6>+ Agregar otro Arrendador (Propietario)</h6></a> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="p-b-59 text-center">
                                                <h4><strong>Datos del Arrendatario</strong></h4>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="tenant_type">Tipo de Arrendatario</label>
                                        <select class="form-control form-control-lg tenant_type" name="tenant_type[]" data-id="1">
                                            <option value="Fisico">Persona Física</option>
                                            <option value="Moral">Persona Moral (empresa)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" name="tenant_name[]" class="form-control form-control-lg">
                                            <label class="arrendatarioFisico1">Nombre completo</label>
                                            <label class="arrendatarioMoral1" style="display: none">Nombre o Razón social</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="tenant_email[]">
                                            <label for="tenant_email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="number" class="form-control form-control-lg" name="tenant_phone[]">
                                            <label for="tenant_phone">Télefono</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 arrendatarioMoral1" style="display:none">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="tenant_rfc[]">
                                            <label for="tenant_rfc">RFC</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row contenedorArrendatario">   
                                    <div class="col-sm-12 col-md-7">
                                        <div class="form-group">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Agregar Arrendatario" class="addArrendatario"><h6>+ Agregar otro Arrendatario (Inquilino)</h6></a> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="p-b-59 text-center">
                                                <h6><strong>¿Desea agregar un Obligado Solidario ó un Fiador?</strong></h6>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-check form-check-inline" style="width: auto !important">
                                            <label class="form-check-label" for="fiador_type3">
                                                <input class="form-check-input" type="radio" name="fiador_type" id="fiador_type3" value="Sin Fiador" checked>
                                                <h5>Sin Fiador</h5>
                                            </label>
                                        </div> 
                                        <div class="form-check form-check-inline" style="width: auto !important">
                                            <label class="form-check-label" for="fiador_type2">
                                                <input class="form-check-input" type="radio" name="fiador_type" id="fiador_type2" value="Obligado Solidario">
                                                <h5>Obligado Solidario</h5>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline" style="width: auto !important">
                                            <label class="form-check-label" for="fiador_type1">
                                                <input class="form-check-input" type="radio" name="fiador_type" id="fiador_type1" value="Fiador">
                                                <h5>Fiador</h5>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row guarantor">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="p-b-59 text-center">
                                                <h4><strong>Datos del Obligado Solidario y/o Fiador</strong></h4>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="guarantor_type">Tipo de Obligado Solidario y/o Fiador</label>
                                        <select class="form-control form-control-lg guarantor_type" name="guarantor_type[]" data-id="1">
                                            <option value="Fisico">Persona Física</option>
                                            <option value="Moral">Persona Moral (empresa)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row guarantor">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" name="guarantor_name[]" class="form-control form-control-lg">
                                            <label class="guarantorFisico1">Nombre completo</label>
                                            <label class="guarantorMoral1" style="display: none">Nombre o Razón social</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="guarantor_email[]">
                                            <label for="guarantor_email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="number" class="form-control form-control-lg" name="guarantor_phone[]">
                                            <label for="guarantor_phone">Télefono</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 guarantorMoral1" style="display:none">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="guarantor_rfc[]">
                                            <label for="guarantor_rfc">RFC</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="p-b-59 text-center">
                                                <h4><strong>Domicilio del Obligado Solidario y/o Fiador</strong></h4>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="guarantor_address[]">
                                            <label for="guarantor_address">Dirección</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="guarantor_exterior[]">
                                            <label for="guarantor_exterior">Número Exterior</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="guarantor_interior[]">
                                            <label for="guarantor_interior">Número Interior</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="guarantor_colonia[]">
                                            <label for="guarantor_colonia">Colonia</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="guarantor_postal_code[]">
                                            <label for="guarantor_postal_code">Código Postal</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group"> 
                                            <label for="">Estado</label>
                                            <select name="guarantor_state[]" class="form-control states" data-id="2">
                                                <option value="">-- Seleccione una opción --</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group"> 
                                            <label for="">Municipio</label>
                                            <select name="guarantor_municipality[]" class="form-control" id="municipality_id2">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fiador fiador1">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="p-b-59 text-center">
                                                <h4><strong>Datos Notariales</strong></h4>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_address[]">
                                            <label for="notarial_address">Dirección</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_writing[]">
                                            <label for="notarial_writing">Escritura</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_volume[]">
                                            <label for="notarial_volume">Volumen</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_book[]">
                                            <label for="notarial_book">Libro</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_notary[]">
                                            <label for="notarial_notary">Notario</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_invoice[]">
                                            <label for="notarial_invoice">Folio</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_place[]">
                                            <label for="notarial_place">Lugar</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="">Fecha</label><br>
                                        <select name="notarial_day[]" class="form-control day" style="width: 30% !important; float:left">
                                        </select>
                                        <select name="notarial_mounth[]" class="form-control" style="width: 30% !important; float:left">
                                            <option value="01">Enero</option>
                                            <option value="02">Febrero</option>
                                            <option value="03">Marzo</option>
                                            <option value="04">Abril</option>
                                            <option value="05">Mayo</option>
                                            <option value="06">Junio</option>
                                            <option value="07">Julio</option>
                                            <option value="08">Agosto</option>
                                            <option value="09">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                        <select name="notarial_year[]" class="form-control year" style="width: 40% !important; float:left">
                                        </select>
                                    </div>
                                </div>
                                <div class="row guarantor contenedorGuarantor">   
                                    <div class="col-sm-12 col-md-8">
                                        <div class="form-group">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Agregar Obligado/Fiador" class="addObligado"><h6>+ Agregar otro Obligado/Fiador (Garante)</h6></a> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 input-group p-0 d-flex justify-content-between justify-content-md-start">
                                        <a href="#progressbar" class="step-prev step-prev2 btn primary-button mr-4"><i class="icon-arrow-left-circle"></i>ANTERIOR</a>
                                        <a href="#progressbar" class="step-next step-next2 btn primary-button">SIGUIENTE<i class="icon-arrow-right-circle left"></i></a>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="step-group" id="step-group3">
                                <div class="row"> 
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="manager_name">
                                            <label for="manager_name">Nombre completo del Gestor</label>
                                        </div>
                                    </div>  
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="email" class="form-control form-control-lg" name="manager_email">
                                            <label for="manager_email">Email del Gestor</label>
                                        </div>
                                    </div>  
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="number" class="form-control form-control-lg" name="manager_phone">
                                            <label for="manager_phone">Número Whatsapp (para recibir el contrato)</label>
                                        </div>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-12 input-group p-0 d-flex justify-content-between justify-content-md-start">
                                        <a href="#progressbar" class="step-prev step-prev3 btn primary-button mr-4"><i class="icon-arrow-left-circle"></i>ANTERIOR</a>
                                        <button class="step-next btn primary-button mr-4" type="submit"><i class="icon-check"></i> Finalizar</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>

            <div class="content-images col-sm-12 col-md-12 col-lg-5">
                <div class="gallery">
                    <div class="mask-radius"></div>
                    <img src="{{ asset('assets/images/about-2.jpg') }}" class="fit-image" alt="Fit Image">
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('js')
@include('layouts.partials-forms.script-form')
<script type="text/javascript">
    $(function () {
        $('#state_id').change(e => municipalityByState($(e.currentTarget).val()));
        $('#step-group2').hide('fast');
        $('#step-group3').hide('fast');
        
        $('.step-next1, .step-prev3').click(e => {
            $('#step3').removeClass('active');
            $('#step1').addClass('active');
            $('#step2').addClass('active');
            $('#step-group1').hide('fast');
            $('#step-group3').hide('fast');
            $('#step-group2').show('fast');
        });
        
        $('.step-prev2').click(e => {
            $('#step3').removeClass('active');
            $('#step2').removeClass('active');
            $('#step1').addClass('active');
            $('#step-group2').hide('fast');
            $('#step-group3').hide('fast');
            $('#step-group1').show('fast');
        });
        
        $('.step-next2').click(e => {
            $('#step1').addClass('active');
            $('#step2').addClass('active');
            $('#step3').addClass('active');
            $('#step-group1').hide('fast');
            $('#step-group2').hide('fast');
            $('#step-group3').show('fast');
        });
        
        $('#fiador_type1,#fiador_type2').click(e => {
            $('.guarantor').show('fast');
            $('.fiador').hide('fast');
        });
        
        $('#fiador_type3').click(e => {
            $('.fiador,.guarantor').hide('fast');
        });
    });

    $(document).on('change', '.states', e => municipalityByStateDinamic($(e.currentTarget).attr('data-id'), $(e.currentTarget).val()));

    let states = (pos) => {
        $.ajax({
            url: "{{ route('state.indexAjax') }}",
            type: "POST",
            dataType: "JSON",
            statusCode: {
                200: function(res) {
                    let rows = '<option value="">-- Seleccione una opción --</option>';
                    
                    if (res.total !== 0) {
                        res.items.forEach((val, index) => {
                            if (val !== null) {
                                rows += `<option value="${val.id}">${val.text}</option>`;
                            }
                        });
                    }

                    $(`.state${pos}`).html(rows);
                }
            }
        });
    }
    
    let municipalityByState = (value) => {
        $.ajax({
            url: "{{ route('municipality.indexAjaxByState') }}",
            data: {
                state : value
            },
            type: "POST",
            dataType: "JSON",
            statusCode: {
                200: function(res) {
                    let rows = '<option value="">-- Seleccione una opción --</option>';
                    
                    if (res.total !== 0) {
                        res.items.forEach((val, index) => {
                            if (val !== null) {
                                rows += `<option value="${val.id}">${val.text}</option>`;
                            }
                        });
                    }

                    $("#municipality_id").html(rows);
                }
            }
        });
    }
    
    let municipalityByStateDinamic = (pos, value) => {
        $.ajax({
            url: "{{ route('municipality.indexAjaxByState') }}",
            data: {
                state : value
            },
            type: "POST",
            dataType: "JSON",
            statusCode: {
                200: function(res) {
                    let rows = '<option value="">-- Seleccione una opción --</option>';
                    
                    if (res.total !== 0) {
                        res.items.forEach((val, index) => {
                            if (val !== null) {
                                rows += `<option value="${val.id}">${val.text}</option>`;
                            }
                        });
                    }

                    $(`#municipality_id${pos}`).html(rows);
                }
            }
        });
    }
</script>
@endsection