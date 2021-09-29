@extends('dashboard.layouts.app')

@section('title')
Crear - Email
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/ckeditor/adapters/jquery.js') }}"></script>
@endsection

@section('content')
<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">@yield('title')</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.settings.email.store') }}">
                    @include('dashboard.layouts.partials.errors')
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="code">Código</label>
                                <input autofocus class="form-control @if($errors->get('code')) is-invalid @endif" name="code" id="code" value="{{ old('code') }}" placeholder="Ingrese coódigo" type="text">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="host">Host</label>
                                <input class="form-control @if($errors->get('host')) is-invalid @endif" name="host" id="host" value="{{ old('host') }}" placeholder="Ingrese host" type="text">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="port">Puerto</label>
                                <input class="form-control @if($errors->get('port')) is-invalid @endif" name="port" id="port" value="{{ old('port') }}" placeholder="Ingrese puerto" type="text">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="encryptation">Encriptación</label>
                                <select class="form-control @if($errors->get('encryptation')) is-invalid @endif" name="encryptation" id="encryptation">
                                    <option value="">-- Seleccione una opción --</option>
                                    <option value="tls">tls</option>
                                    <option value="ssl">ssl</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="username">Usuario</label>
                                <input class="form-control @if($errors->get('username')) is-invalid @endif" name="username" id="username" value="{{ old('username') }}" placeholder="Ingrese usuario" type="text">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input class="form-control @if($errors->get('password')) is-invalid @endif" name="password" id="password" value="{{ old('password') }}" placeholder="Ingrese password" type="text">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="from">Remitente</label>
                                <input class="form-control @if($errors->get('from')) is-invalid @endif" name="from" id="from" value="{{ old('from') }}" placeholder="Ingrese remitente" type="text">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="fromname">Nombre</label>
                                <input class="form-control @if($errors->get('fromname')) is-invalid @endif" name="fromname" id="fromname" value="{{ old('fromname') }}" placeholder="Ingrese nombre" type="text">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="subject">Asunto</label>
                                <input class="form-control @if($errors->get('subject')) is-invalid @endif" name="subject" id="subject" value="{{ old('subject') }}" placeholder="Ingrese asunto" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="template">Plantilla</label>
                                <textarea name="template" rows="80" cols="10" class="form-control @if($errors->get('template')) is-invalid @endif" name="template">{{old('template')}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button class="btn btn-md btn-success waves-effect wave-dark" type="submit"><i class="material-icons">save</i> Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@include('dashboard.layouts.partials.ckeditor')
@endsection