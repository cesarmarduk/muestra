@extends('dashboard.layouts.app')

@section('title')
Editar - Permiso
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
                <form method="POST" action="{{ route('dashboard.settings.permission.update', Crypt::encrypt($permission->id)) }}">
                    @include('dashboard.layouts.partials.errors')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input autofocus class="form-control @if($errors->get('name')) is-invalid @endif" name="name" id="name" value="{{ old('name', $permission->name) }}" placeholder="Ingres permiso" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button class="btn btn-md btn-success waves-effect wave-dark" type="submit"><i class="material-icons">save</i> Actualizar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection