@extends('dashboard.layouts.app')

@section('title')
Crear - Ciudad
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
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
                <form method="POST" action="{{ route('dashboard.settings.city.store') }}">
                    @include('dashboard.layouts.partials.errors')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input autofocus class="form-control @if($errors->get('name')) is-invalid @endif" name="name" id="name" value="{{ old('name') }}" placeholder="Ingres ciudad" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="abbreviation">Abreviatura</label>
                                <input class="form-control @if($errors->get('abbreviation')) is-invalid @endif" name="abbreviation" id="abbreviation" value="{{ old('abbreviation') }}" placeholder="Ingres abreviatura" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="state_id">Estado</label>
                                <select id="state_id" class="form-control form-control-lg select2 text-white @if($errors->get('state_id')) is-invalid @endif" name="state_id">
                                    <option value="">-- Seleccione una opción --</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
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
<script type="text/javascript">
    $(function () {
        $('.select2').select2();
    });
</script>
@endsection