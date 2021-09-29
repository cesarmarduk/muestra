@extends('dashboard.layouts.app')

@section('title')
Listado - Estados
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
                    @can('states.create')
                    <div class="col-sm-12">
                        <div class="form-group">
                            <a class="btn btn-md btn-success waves-effect wave-dark" href="{{ route('dashboard.settings.state.create') }}"><i class="material-icons">add</i> Nuevo</a>
                        </div>
                    </div>
                    @endcan
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-md-nowrap" id="table">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0"></th>
                                        <th class="wd-75p border-bottom-0">Estados</th>
                                        <th class="wd-20p border-bottom-0 text-center">Abreviatura</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($states as $state)
                                        <tr>
                                            <td class="text-center">
                                                @can('states.edit')
                                                <a class="btn-link" href="{{ route('dashboard.settings.state.edit', Crypt::encrypt($state->id)) }}"><i class="material-icons text-success">edit</i></a>
                                                @endcan
                                                @can('cities.destroy')
                                                <a class="btn-link" href="{{ route('dashboard.settings.state.destroy', Crypt::encrypt($state->id)) }}"><i class="material-icons text-danger">delete</i></a>
                                                @endcan
                                            </td>
                                            <td class="text-transform-initial">{{ $state->name }}</td>
                                            <td class="text-center text-transform-initial">{{ $state->abbreviation }}</td>
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