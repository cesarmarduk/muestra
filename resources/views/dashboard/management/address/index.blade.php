@extends('dashboard.layouts.app')

@section('title')
Listado - Dirección
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
                    <div class="col-sm-12">
                        <div class="form-group">
                            <a class="btn btn-md btn-success waves-effect wave-dark" href="{{ route('dashboard.management.address.create') }}"><i class="material-icons">add</i> Nuevo</a>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-md-nowrap" id="table">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0"></th>
                                        <th class="wd-95p border-bottom-0">Dirección</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($address as $addres)
                                        <tr>
                                            <td class="text-center">
                                                <a class="btn-link" href="{{ route('dashboard.management.address.edit', Crypt::encrypt($addres->id)) }}"><i class="material-icons text-success">edit</i></a>
                                                <a class="btn-link" href="{{ route('dashboard.management.address.destroy', Crypt::encrypt($addres->id)) }}"><i class="material-icons text-danger">delete</i></a>
                                            </td>
                                            <td class="text-transform-initial">{{ $addres->address }}</td>
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