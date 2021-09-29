@extends('dashboard.layouts.appProgress')

@section('title')
Mis contratos - Pólizas
@endsection
@section('plugins')
<script type="text/javascript" src="{{ asset('assets/js/forms/ponyfill.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/slider.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/animation.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/gallery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/jquery.easing.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/main.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/plugins/jquery-mask/jquery-mask.js') }}"></script>
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
@endsection
@section('content')
<div class="breadcrumb-area">
    <h1>Dashboard</h1>

    <ol class="breadcrumb">
        <li class="item"><a href="dashboard-analytics.html"><i class='bx bx-home-alt'></i></a></li>
        <li class="item">Dashboard</li>
    </ol>
</div>
<!-- End Breadcrumb Area -->

<!-- Start -->
<div class="card mb-30">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Pólizas</h3>

        <a href="{{ route('dashboard.management.policies.create') }}" data-toggle="tooltip" data-placement="top" title="Agregar Contrato Con Poliza"  class="btn btn-success">+ Agregar </a>
    </div>

    <div class="card-body">
        <section id="progressbar" class="section-1 form">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 align-self-start">
                        <form id="form_contrat" method="POST" action="#" enctype="multipart/form-data">
                            @include('layouts.partials-forms.errors')
                            <div class="row form-content">
                                <div class="col-12 p-0">
                                    <ul class="progressbar">
                                        <li id="step1" class="active">Datos de la Poliza</li>
                                        <li id="step2">Firmantes</li>
                                        <li id="step3">Pago</li>
                                    </ul>
                                    <fieldset class="step-group" id="step-group1">
                                        <div class="row">
                                            <input type="hidden" class="form-control form-control-lg" name="placement" value="management">
                                            <input type="hidden" class="form-control form-control-lg" name="contrat_id" id="contrat_id">
                                          
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
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group"> 
                                                    <label for="">Tipo de Poliza</label>
                                                    <select name="upgrade" id="upgrade" class="form-control">
                                                        <option value="">-- Seleccione Municipio --</option>
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
                                                    <input type="text" class="form-control form-control-lg" id="rent_monthly" name="rent_monthly">
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
                                        <div class="row paymentMethod margin-top20">
                                            <div class="col-sm-12">
                                                <h4 class="text-center"><strong>Métodos de Pago</strong></h4>
                                            </div>
                                            
                                            <div class="col-sm-6 text-center">
                                                <div class="card-Payment">
                                                    <img width="150" src="{{ asset('assets/images/card.jpg') }}" alt="">
                                                    <h5>Tarjeta de Crédito o Débito</h5>
                                                    <p>Paga con tu tarjeta de crédito o debito y acelera el proceso de tu compra desde la comodidad de tu hogar.</p>
                                                    <button class="btn primary-button" id="payment_type1" style="display: block !important; margin: auto;" type="button"><i class="icon-check"></i> Pagar</button>
                                                </div>
                                                {{-- <div class="form-check form-check-inline">
                                                    <label class="form-check-label" style="float: left !important; text-align:left !important" for="payment_type1">
                                                        <input class="form-check-input" type="radio" name="payment_type" id="payment_type1" value="OXXO" checked>
                                                        <h5>OXXO</h5>
                                                    </label>
                                                </div> --}}
                                            </div>
                                            <div class="col-sm-6 text-center">
                                                {{-- <div class="form-check form-check-inline">
                                                    <label class="form-check-label" style="float: left !important; text-align:left !important" for="payment_type2">
                                                        <input class="form-check-input" type="radio" name="payment_type" id="payment_type2" value="CARD">
                                                        <h5>TARJETA DEB/CRE</h5>
                                                    </label>
                                                </div> --}}
                                                <div class="card-Payment">
                                                    <img width="150" src="{{ asset('assets/images/oxxo.jpg') }}" alt="">
                                                    <h5>Pago en oxxo</h5>
                                                    <p>Paga con esta opción es una cómoda alternativa ya que pagas en efectivo en cualquiera de los muchos establecimientos de tu ciudad.</p>
                                                    <button class="btn primary-button" id="payment_type2" style="display: block !important; margin: auto;" type="button"><i class="icon-check"></i> Pagar</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row paymentMethod sectionOxxo card-Payment margin-top20">
                                            <div class="col-sm-12 text-center">
                                                <img class="img-fluid img-responsive text-center" width="150" src="{{ asset('assets/images/oxxo.jpg') }}" alt="">
                                                <h5 class="text-center">Pago en Oxxo (Efectivo)</h5>
                                                <h6 class="text-center">Monto a pagar <span class="amount"></span> MXN</h6>
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
                                            <div class="col-sm-12 margin-top20 text-center">
                                                <button class="btn primary-button paymentOxxo" style="display: block !important; margin: auto;" type="button"><i class="icon-check"></i> Solicitar Referencia</button>
                                            </div>
                                            <div class="col-sm-12 margin-top20 paymentOxxoFinish text-center">
                                                <div class="oxxoButton"></div>
                                            </div>
                                        </div>
                                        <form id="card-form">
                                        <div class="row paymentMethod sectionCard card-Payment margin-top20">
                                            <div class="col-sm-12 text-center">
                                                <img class="img-fluid img-responsive text-center" width="150" src="{{ asset('assets/images/card.jpg') }}" alt="">
                                                <h5 class="text-center">Tarjeta de Crédito o Débito</h5>
                                                <h6 class="text-center">Monto a pagar <span class="amount"></span> MXN</h6>
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
                                                    <input class="form-control form-control-lg" placeholder="AAAA" maxlength="4" name="expCard" data-conekta="card[exp_year]" id="expAACard" type="number">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 margin-top20 text-center">
                                                    <button class="btn primary-button methodPayment" style="display: block !important; margin: auto;" type="button"><i class="icon-check"></i> Generar Pago</button>
                                                </div>
                                                <div class="col-sm-12 margin-top20 paymentCardFinish text-center">
                                                    <div class="cardButton"></div>
                                                </div>
                                                {{-- <input name="contrat" value="{{ Crypt::encrypt($contrat) }}" type="hidden"> --}}
                                            </div>
                                        </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-12 input-group p-0 d-flex justify-content-between justify-content-md-start">
                                                <a href="#progressbar" class="step-prev step-prev3 btn primary-button mr-4"><i class="icon-arrow-left-circle"></i>ANTERIOR</a>
                                                <button style="display:none" class="step-next btn primary-button mr-4 btnFinish" type="submit"><i class="icon-check"></i> Finalizar</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
        
                    
                </form>
            </div>
        </section>
    </div>
</div>
 <div class="flex-grow-1"></div>
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
            $('.sectionPayment, .reference, .sectionOxxo, .sectionCard, .loading, .paymentOxxoFinish, .paymentCardFinish').hide('fast');
        });
        
        $('#fiador_type1,#fiador_type2').click(e => {
            $('.guarantor').show('fast');
            $('.fiador').hide('fast');
        });
        
        $('#fiador_type3').click(e => {
            $('.fiador,.guarantor').hide('fast');
        });

        $('#numberCard').mask('9999-9999-9999-9999');
        $('#cvcCard').mask('9999');
        $('#expMMCard').mask('99');
        $('#expAACard').mask('9999');

        $('#payment_type1').click(e => {
            amount(1);
            
            
           
        });
        $('#payment_type2').click(e => {
            amount(2); //
           
        });

        var storeOxxoPay = ()=>{
            $.ajax({
                url: "{{ route('payments.store') }}",
                data: {
                    contrat : $('input[name="contrat_id"]').val(),
                    upgrade : $('input[name="upgrade"]').val(),
                    payment_type : 'OXXO',
                    token_id: null,
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
        }

        $('.paymentOxxo').click(e => {
            if($('input[name="contrat_id"]').val()!=""){ //Si ya existe el contrato intentaguardar
                storeOxxoPay();
            }else{
                storeContrat("CARD",token);
            }
           
        });
        
        $('.methodPayment').click(e => {
            Conekta.Token.create($("#card-form"), conektaSuccessResponseHandler, conektaErrorResponseHandler);
        });
    });

    var conektaSuccessResponseHandler = function(token) {
        if($('input[name="contrat_id"]').val()!=""){ //Si ya existe el contrato intentaguardar
            storeCardPay(token);
        }else{
            storeContrat("CARD",token);
        }
      
    };

    var storeCardPay = (token)=>{
        $.ajax({
            url: "{{ route('payments.store') }}",
            data: {
                contrat : $('input[name="contrat_id"]').val(),
                upgrade : $('input[name="upgrade"]').val(),
                payment_type : 'CARD',
                token_id: token.id
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
                        html: `Ha completado el pago, por favor pulsa el boton "Finalizar" para continuar`,
                        type: 'success',
                        allowOutsideClick: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        showCancelButton: false
                    });
                    if (data.message.policy !== ""){
                        $('.btnFinish').css('display','block');
                    }
                }
            }
        });
    }

    var storeContrat = function(type,token=false) {
     
        $.ajax({
            url: "{{ route('contrats.simple.store')}}",
            data: $(`#form_contrat`).serialize(),
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
                    $(`#contrat_id`).val(data.contrat_id);
                    if(type=="CARD"){
                        storeCardPay(token);
                    }else{
                        storeOxxoPay();
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

    let amount = val =>{
      
        $.ajax({
            url: "{{ route('dashboard.management.policies.amount') }}",
            data: {
                rent_monthly : $('input[name="rent_monthly"]').val(),
                val :  $('#upgrade').val(),
            },
            type: 'POST',
            dataType: "JSON",
            statusCode: {
                200: function(data) {
                    if(val==1){
                        $('.sectionOxxo').hide('fast');
                        $('.sectionCard').show('fast');
                    }else{
                        $('.sectionCard').hide('fast');
                        $('.sectionOxxo').show('fast');
                    }
                    $('.amount').html(data.message);
                }
            }
        });
    }

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