@extends('dashboard.layouts.app')

@section('title')
Contrato Simple
@endsection

@section('content')
<div class="breadcrumb-area">
    <h1>Contratos</h1>

    <ol class="breadcrumb">
        <li class="item"><a href="dashboard-analytics.html"><i class='bx bx-home-alt'></i></a></li>

        <li class="item">Contratos</li>

        <li class="item">Simple</li>
    </ol>
</div>
<!-- End Breadcrumb Area -->

<!-- Start -->
<div class="card mb-30">
    @include('dashboard.layouts.partials.errors')
    <form method="POST" action="@if($contrato ?? ''){{ route('dashboard.register.simple.edit', ['id'=>Crypt::encrypt($contrato->id)])}}@else{{ route('dashboard.register.simple') }}@endif">
        {{ csrf_field() }}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Arrendador</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6 ">
                    <label for="inputEmail4">NOMBRE (S)</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombre_arrendador}} @endif" class="form-control @if($errors->get('nombre_arrendador')) is-invalid @endif" id="nombre_arrendador" name="nombre_arrendador">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">PRIMER APELLIDO</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->papellido_arrendador}} @endif" class="form-control @if($errors->get('primer_apellido_arrendador')) is-invalid @endif" id="primer_apellido_arrendador" name="primer_apellido_arrendador">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">SEGUNDO APELLIDO</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->sapellido_arrendador}} @endif" class="form-control @if($errors->get('segundo_apellido_arrendador')) is-invalid @endif" id="segundo_apellido_arrendador" name="segundo_apellido_arrendador">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">EMAIL</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->email_arrendador}} @endif" class="form-control @if($errors->get('email_arrendador')) is-invalid @endif" id="email_arrendador" name="email_arrendador">
                </div>
            </div>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Domicilio Arrendador</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6 ">
                    <label for="inputEmail4">TIPO DE VIALIDAD</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->tipoVialidad_darrendador}} @endif" class="form-control @if($errors->get('tipoVialidad_domicilioArrendador')) is-invalid @endif" id="tipoVialidad_domicilioArrendador" name="tipoVialidad_domicilioArrendador">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NOMBRE DE LA VIALIDAD</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombreVialidad_darrendador}} @endif" class="form-control @if($errors->get('nombreVialidad_domicilioArrendador')) is-invalid @endif" id="nombreVialidad_domicilioArrendador" name="nombreVialidad_domicilioArrendador">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NÚMERO INTERIOR</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->numeroInterior_darrendador}} @endif" class="form-control @if($errors->get('numeroInterior_domicilioArrendador')) is-invalid @endif" id="numeroInterior_domicilioArrendador" name="numeroInterior_domicilioArrendador">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NÚMERO EXTERIOR</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->numeroExterior_darrendador}} @endif" class="form-control @if($errors->get('numeroExterior_domicilioArrendador')) is-invalid @endif" id="numeroExterior_domicilioArrendador" name="numeroExterior_domicilioArrendador">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NOMBRE DEL MUNICIPIO O DEMARCACIÓN TERRITORIAL</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombreMunicipio_darrendador}} @endif" class="form-control @if($errors->get('nombreMunicipio_domicilioArrendador')) is-invalid @endif" id="nombreMunicipio_domicilioArrendador" name="nombreMunicipio_domicilioArrendador">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NOMBRE DE LA ENTIDAD FEDERATIVA</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombreEntidad_darrendador}} @endif" class="form-control @if($errors->get('nombreEntidad_domicilioArrendador')) is-invalid @endif" id="nombreEntidad_domicilioArrendador" name="nombreEntidad_domicilioArrendador">
                </div>
            </div>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Arrendatario</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6 ">
                    <label for="inputEmail4">NOMBRE (S)</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombre_arrendatario}} @endif" class="form-control @if($errors->get('nombre_arrendatario')) is-invalid @endif" id="nombre_arrendatario" name="nombre_arrendatario">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">PRIMER APELLIDO</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->papellido_arrendatario}} @endif" class="form-control @if($errors->get('primer_apellido_arrendatario')) is-invalid @endif" id="primer_apellido_arrendatario" name="primer_apellido_arrendatario">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">SEGUNDO APELLIDO</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->sapellido_arrendatario}} @endif" class="form-control @if($errors->get('segundo_apellido_arrendatario')) is-invalid @endif" id="segundo_apellido_arrendatario" name="segundo_apellido_arrendatario">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">EMAIL</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->email_arrendatario}} @endif" class="form-control @if($errors->get('email_arrendatario')) is-invalid @endif" id="email_arrendatario" name="email_arrendatario">
                </div>
            </div>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Domicilio Arrendatario</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6 ">
                    <label for="inputEmail4">TIPO DE VIALIDAD</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->tipoVialidad_darrendatario}} @endif" class="form-control @if($errors->get('tipoVialidad_domicilioArrendatario')) is-invalid @endif" id="tipoVialidad_domicilioArrendatario" name="tipoVialidad_domicilioArrendatario">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NOMBRE DE LA VIALIDAD</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombreVialidad_darrendatario}} @endif" class="form-control @if($errors->get('nombreVialidad_domicilioArrendatario')) is-invalid @endif" id="nombreVialidad_domicilioArrendatario" name="nombreVialidad_domicilioArrendatario">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NÚMERO INTERIOR</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->numeroInterior_darrendatario}} @endif" class="form-control @if($errors->get('numeroInterior_domicilioArrendatario')) is-invalid @endif" id="numeroInterior_domicilioArrendatario" name="numeroInterior_domicilioArrendatario">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NÚMERO EXTERIOR</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->numeroExterior_darrendatario}} @endif" class="form-control @if($errors->get('numeroExterior_domicilioArrendatario')) is-invalid @endif" id="numeroExterior_domicilioArrendatario" name="numeroExterior_domicilioArrendatario">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NOMBRE DEL MUNICIPIO O DEMARCACIÓN TERRITORIAL</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombreMunicipio_darrendatario}} @endif" class="form-control @if($errors->get('nombreMunicipio_domicilioArrendatario')) is-invalid @endif" id="nombreMunicipio_domicilioArrendatario" name="nombreMunicipio_domicilioArrendatario">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NOMBRE DE LA ENTIDAD FEDERATIVA</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombreEntidad_darrendatario}} @endif" class="form-control @if($errors->get('nombreEntidad_domicilioArrendatario')) is-invalid @endif" id="nombreEntidad_domicilioArrendatario" name="nombreEntidad_domicilioArrendatario">
                </div>
            </div>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Inmueble en Arrendamiento</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6 ">
                    <label for="inputEmail4">TIPO DE VIALIDAD</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombre_arrendador}} @endif" class="form-control @if($errors->get('tipoVialidad_inmueble')) is-invalid @endif"" id="tipoVialidad_inmueble" name="tipoVialidad_inmueble">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NOMBRE DE LA VIALIDAD</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombreVialidad_inmueble}} @endif" class="form-control @if($errors->get('nombreVialidad_inmueble')) is-invalid @endif" id="nombreVialidad_inmueble" name="nombreVialidad_inmueble">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NÚMERO INTERIOR</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->numeroInterior_inmueble}} @endif" class="form-control @if($errors->get('numeroInterior_inmueble')) is-invalid @endif" id="numeroInterior_inmueble" name="numeroInterior_inmueble">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NÚMERO EXTERIOR</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->numeroExterior_inmueble}} @endif" class="form-control @if($errors->get('numeroExterior_inmueble')) is-invalid @endif" id="numeroExterior_inmueble" name="numeroExterior_inmueble">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NOMBRE DEL MUNICIPIO O DEMARCACIÓN TERRITORIAL</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombreMunicipio_inmueble}} @endif" class="form-control @if($errors->get('nombreMunicipio_inmueble')) is-invalid @endif" id="nombreMunicipio_inmueble" name="nombreMunicipio_inmueble">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">NOMBRE DE LA ENTIDAD FEDERATIVA</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->nombreEntidad_inmueble}} @endif" class="form-control @if($errors->get('nombreEntidad_inmueble')) is-invalid @endif" id="nombreEntidad_inmueble" name="nombreEntidad_inmueble">
                </div>
                <div class="form-group col-md-12">
                    <label for="inputPassword4">DIRECCION</label>
                    <textarea type="text"  class="form-control @if($errors->get('direccion_inmueble')) is-invalid @endif" id="direccion_inmueble" name="direccion_inmueble">@if($contrato ?? '') {{$contrato->direccion_inmueble}} @endif</textarea>
                </div>
            </div>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Vigencia del Contrato</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6 ">
                    <label for="inputEmail4">INICIO</label>
                    <input type="date" value="@if($contrato ?? ''){{date("Y-m-d", strtotime($contrato->inicio_contrato))}}@endif" class="form-control @if($errors->get('inicio_contrato')) is-invalid @endif" id="inicio_contrato" name="inicio_contrato">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">TERMINO</label>
                    <input type="date" value="@if($contrato ?? ''){{date("Y-m-d", strtotime($contrato->termino_contrato))}}@endif" class="form-control @if($errors->get('termino_contrato')) is-invalid @endif" id="termino_contrato" name="termino_contrato">
                </div>
            </div>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Renta</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6 ">
                    <label for="inputEmail4">ANUAL</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->renta_anual}} @endif" class="form-control @if($errors->get('renta_anual')) is-invalid @endif" id="renta_anual" name="renta_anual">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">MENSUAL</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->renta_mensual}} @endif" class="form-control @if($errors->get('renta_mensual')) is-invalid @endif" id="renta_mensual" name="renta_mensual">
                </div>
                <div class="form-group col-md-12">
                    <label for="inputPassword4">MAS CUOTA DE MANTENIMIENTO</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->cuota_mantenimiento}} @endif" class="form-control @if($errors->get('cuota_mantenimiento')) is-invalid @endif" id="cuota_mantenimiento" name="cuota_mantenimiento">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">DIA PAGO DESDE</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->dia_desde}} @endif" class="form-control @if($errors->get('dia_desde')) is-invalid @endif" id="dia_desde" name="dia_desde">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">DIA PAGO HASTA</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->dia_hasta}} @endif" class="form-control @if($errors->get('dia_hasta')) is-invalid @endif" id="dia_hasta" name="dia_hasta">
                </div>
            </div>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Depósito</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6 ">
                    <label for="inputEmail4">CANTIDAD ( MONTO ) </label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->deposito_monto}} @endif" class="form-control @if($errors->get('deposito')) is-invalid @endif" id="deposito" name="deposito">
                </div>
              
            </div>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Uso</h3>
        </div>
        <div class="card-body">
            <div class="form-check form-check-inline">
                <input class="form-check-input @if($errors->get('uso')) is-invalid @endif" @if($contrato ?? '') {{$contrato->radioUso=='comercial'?'checked':''}} @endif  type="radio" name="uso" id="radioUso1" value="comercial">
                <label class="form-check-label" for="inlineRadio1">COMERCIAL</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input @if($errors->get('uso')) is-invalid @endif" @if($contrato ?? '') {{$contrato->radioUso=='habitacional'?'checked':''}} @endif type="radio" name="uso" id="radioUso2" value="habitacional">
                <label class="form-check-label" for="inlineRadio2">HABITACIONAL</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input @if($errors->get('uso')) is-invalid @endif" @if($contrato ?? '') {{$contrato->radioUso=='industrial'?'checked':''}} @endif type="radio" name="uso" id="radioUso3" value="industrial">
                <label class="form-check-label" for="inlineRadio3">INDUSTRIAL</label>
            </div>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center mt-3">
            <h3>Jurisdicción</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6 ">
                    <label class="form-check-label" >ESTADO</label>
                    <select class="form-control @if($errors->get('estado_jurisdiccion')) is-invalid @endif" name="estado_jurisdiccion" id="estado_jurisdiccion">
                        <option value="">SELECCIONE</option>
                        <option @if($contrato ?? '') {{$contrato->estado=='ESTADO DE MEXICO'?'selected':''}} @endif value="ESTADO DE MEXICO">ESTADO DE MEXICO</option>
                        <option @if($contrato ?? '') {{$contrato->estado=='CIUDAD DE MEXICO'?'selected':''}} @endif value="CIUDAD DE MEXICO">CIUDAD DE MEXICO </option>
                    </select>
                </div>
              
                <div class="form-group col-md-6 ">
                    <label class="form-check-label" >MUNICIPIO</label>
                    <input type="text" value="@if($contrato ?? '') {{$contrato->municipio}} @endif" class="form-control @if($errors->get('municipio_jurisdiccion')) is-invalid @endif" id="municipio_jurisdiccion" name="municipio_jurisdiccion">
                </div>
            
            </div>
            <div class="form-row">
                <div class="form-group col-md-4 ">
                    <label class="form-check-label" >DIA</label>
                    <input type="text" value="@if($contrato ?? ''){{date("d", strtotime($contrato->fecha_contrato))}}@endif" class="form-control @if($errors->get('dia')) is-invalid @endif" id="dia" name="dia">
                </div>
                <div class="form-group col-md-4 ">
                    <label class="form-check-label" >MES</label>
                    <input type="text" value="@if($contrato ?? ''){{date("m", strtotime($contrato->fecha_contrato))}}@endif" class="form-control @if($errors->get('mes')) is-invalid @endif" id="mes" name="mes">
                </div>
                <div class="form-group col-md-4 ">
                    <label class="form-check-label" >AÑO</label>
                    <input type="text" value="@if($contrato ?? ''){{date("Y", strtotime($contrato->fecha_contrato))}}@endif" class="form-control @if($errors->get('anio')) is-invalid @endif" id="anio" name="anio">
                </div>
            
            </div>
        </div>

        <button type="submit" class="btn btn-danger mt-3">@if($contrato ?? '') {{'Editar'}} @else {{'Enviar'}} @endif Datos</button>
    </form>
</div>


<div class="flex-grow-1"></div>
@endsection