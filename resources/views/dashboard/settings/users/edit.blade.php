@extends('dashboard.layouts.app')

@section('title')
Editar - Usuario
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
                <form method="POST" action="{{ route('dashboard.settings.user.update', Crypt::encrypt($user->id)) }}">
                    @include('dashboard.layouts.partials.errors')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fullname">Nombres y Apellidos</label>
                                <div class="input-group @if($errors->get('fullname')) is-invalid @endif">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="material-icons tx-24 lh--9 op-6">face</i>
                                        </div>
                                    </div>
                                    <input type="text" id="fullname" class="form-control form-control-lg" name="fullname" value="{{ old('fullname', $user->fullname) }}" placeholder="Ingrese nombres y apellidos" autofocus>
                                </div>
                            </div>
                        </div>                            
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-group @if($errors->get('email')) is-invalid @endif">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="material-icons tx-24 lh--9 op-6">mail</i>
                                        </div>
                                    </div>
                                    <input type="email" id="email" class="form-control form-control-lg" name="email" value="{{ old('email', $user->email) }}" placeholder="Ingrese email">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="phone">Teléfono</label>
                                <div class="input-group @if($errors->get('phone')) is-invalid @endif">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="material-icons tx-24 lh--9 op-6">phone</i>
                                        </div>
                                    </div>
                                    <input type="text" id="phone" class="form-control form-control-lg" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Ingrese teléfono">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="role_id">Rol</label>
                                <select id="role_id" class="form-control form-control-lg select2 @if($errors->get('role_id')) is-invalid @endif" name="role_id">
                                    <option value="">-- Seleccione una opción --</option>
                                    @foreach($roles as $role)
                                        @if(count($rol) > 0)
                                            @if($rol[0]->role_id === $role->id)
                                                <option value="{{ $role->id }}" selected="selected">{{ $role->name }}</option>
                                            @else 
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endif
                                        @else 
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <div class="input-group @if($errors->get('address')) is-invalid @endif">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="material-icons tx-24 lh--9 op-6">zoom_out_map</i>
                                        </div>
                                    </div>
                                    <input type="text" id="address" class="form-control form-control-lg" name="address" value="{{ old('address', $user->address) }}" placeholder="Ingrese dirección">
                                </div>
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