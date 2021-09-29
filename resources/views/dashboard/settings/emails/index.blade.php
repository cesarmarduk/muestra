@extends('dashboard.layouts.app')

@section('title')
Listado - Emails
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
                    @can('emails.create')
                    <div class="col-sm-12">
                        <div class="form-group">
                            <a class="btn btn-md btn-success waves-effect wave-dark" href="{{ route('dashboard.settings.email.create') }}"><i class="material-icons">add</i> Nuevo</a>
                        </div>
                    </div>
                    @endcan
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-md-nowrap" id="table">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0"></th>
                                        <th class="wd-10p border-bottom-0 text-center">Host</th>
                                        <th class="wd-5p border-bottom-0 text-center">Puerto</th>
                                        <th class="wd-10p border-bottom-0 text-center">Usuario</th>
                                        <th class="wd-10p border-bottom-0 text-center">Password</th>
                                        <th class="wd-5p border-bottom-0 text-center">Ecriptación</th>
                                        <th class="wd-15p border-bottom-0 text-center">Remitente</th>
                                        <th class="wd-15p border-bottom-0 text-center">Nombre</th>
                                        <th class="wd-15p border-bottom-0 text-center">Asunto</th>
                                        <th class="wd-5p border-bottom-0 text-center">Plantilla</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($emails as $email)
                                        <tr>
                                            <td class="text-center">
                                                @can('emails.edit')
                                                <a class="btn-link" href="{{ route('dashboard.settings.email.edit', Crypt::encrypt($email->id)) }}"><i class="material-icons text-success">edit</i></a>
                                                @endcan
                                                @can('emails.destroy')
                                                <a class="btn-link" href="{{ route('dashboard.settings.email.destroy', Crypt::encrypt($email->id)) }}"><i class="material-icons text-danger">delete</i></a>
                                                @endcan
                                            </td>
                                            <td class="text-center text-transform-initial">{{ $email->host }}</td>
                                            <td class="text-center text-transform-initial">{{ $email->port }}</td>
                                            <td class="text-center text-transform-initial">{{ $email->username }}</td>
                                            <td class="text-center text-transform-initial">{{ $email->password }}</td>
                                            <td class="text-center text-transform-initial">{{ $email->encryptation }}</td>
                                            <td class="text-center text-transform-initial">{{ $email->from }}</td>
                                            <td class="text-center text-transform-initial">{{ $email->fromname }}</td>
                                            <td class="text-center text-transform-initial">{{ $email->subject }}</td>
                                            <td class="text-center"><button class="btn-link templateLink" data-template="{{ $email->template }}" data-toggle="modal" data-target="#modal" type="button">[ Ver Plantilla ]</button></td>
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

@include('dashboard.settings.emails.partials.templateModal')

@section('js')
@include('dashboard.layouts.partials.datatable')
<script type="text/javascript">
    $(function() {
        $(document).on('click', '.templateLink', e => {
            $('.modal-title').html('Mensaje del Email');
            $('#html').html($(e.currentTarget).attr('data-template'));
        });
    });
</script>
@endsection