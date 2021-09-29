@extends('dashboard.layouts.app')

@section('title')
Crear - Estado
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
                <form method="POST" action="{{ route('dashboard.settings.state.store') }}">
                    @include('dashboard.layouts.partials.errors')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input autofocus class="form-control @if($errors->get('name')) is-invalid @endif" name="name" id="name" value="{{ old('name') }}" placeholder="Ingres estado" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="abbreviation">Abreviatura</label>
                                <input class="form-control @if($errors->get('abbreviation')) is-invalid @endif" name="abbreviation" id="abbreviation" value="{{ old('abbreviation') }}" placeholder="Ingres abreviatura" type="text">
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