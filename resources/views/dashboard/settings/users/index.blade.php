@extends('dashboard.layouts.app')

@section('title')
Listado - Usuarios
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}">
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
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
                <div class="row">
                    @can('users.create')
                    <div class="col-sm-12">
                        <div class="form-group">
                            <a class="btn btn-md btn-success waves-effect wave-dark" href="{{ route('dashboard.settings.user.create') }}"><i class="material-icons">add</i> Nuevo</a>
                        </div>
                    </div>
                    @endcan
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-md-nowrap" id="table">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0"></th>
                                        <th class="wd-5p border-bottom-0">Verificación</th>
                                        <th class="wd-25p border-bottom-0">Nombres</th>
                                        <th class="wd-25p border-bottom-0 text-center">Email</th>
                                        <th class="wd-25p border-bottom-0 text-center">Rol</th>
                                        <th class="wd-15p border-bottom-0 text-center">Teléfono</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr @if ($user->status === 'Inactive') class="bg-danger" @endif>
                                            <td class="text-center">
                                                @can('users.edit')
                                                <a class="btn-link" href="{{ route('dashboard.settings.user.edit', Crypt::encrypt($user->id)) }}"><i class="material-icons text-success">edit</i></a>
                                                @endcan
                                                @can('users.destroy')
                                                    @if ($user->status === 'Active')
                                                    <a class="btn-link" href="{{ route('dashboard.settings.user.destroy', Crypt::encrypt($user->id)) }}"><i class="material-icons text-danger">delete</i></a>
                                                    @endif
                                                @endcan
                                            </td>
                                            <td class="text-center text-transform-initial">
                                                @if ($user->verified === 'Verified')
                                                    <i class="material-icons text-success">verified_user</i>
                                                @else
                                                    <i class="material-icons text-dark">verified_user</i>
                                                @endif
                                            </td>
                                            <td class="text-transform-initial">{{ $user->fullname }}</td>
                                            <td class="text-center text-transform-initial">{{ $user->email }}</td>
                                            <td class="text-center text-transform-initial">
                                                @php
                                                    $rolname = '';
                                                    $rol     = DB::table('model_has_roles')->where('model_id', '=', $user->id)->get();
                                                    if (count($rol) > 0):
                                                        $role       = \Spatie\Permission\Models\Role::where('id', '=', $rol[0]->role_id)->get();
                                                        $rolname    = $role[0]->name;
                                                    endif;
                                                @endphp

                                                {{ $rolname }}
                                            </td>
                                            <td class="text-center text-transform-initial">{{ $user->phone }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@include('dashboard.layouts.partials.datatable')
@endsection