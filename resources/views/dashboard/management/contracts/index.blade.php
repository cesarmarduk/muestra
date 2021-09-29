@extends('dashboard.layouts.app')

@section('title')
Listado - Contactos
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
                            <a class="btn btn-md btn-success waves-effect wave-dark" href="{{ route('dashboard.management.contact.create') }}"><i class="material-icons">add</i> Nuevo</a>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-md-nowrap" id="table">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0"></th>
                                        <th class="wd-40p border-bottom-0">Nombre y Apellidos</th>
                                        <th class="wd-40p text-center border-bottom-0">Email</th>
                                        <th class="wd-15p text-center border-bottom-0">Dirección</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contacts as $contact)
                                        <tr>
                                            <td class="text-center">
                                                <a class="btn-link" href="{{ route('dashboard.management.contact.edit', Crypt::encrypt($contact->id)) }}"><i class="material-icons text-success">edit</i></a>
                                                <a class="btn-link" href="{{ route('dashboard.management.contact.destroy', Crypt::encrypt($contact->id)) }}"><i class="material-icons text-danger">delete</i></a>
                                            </td>
                                            <td class="text-transform-initial">{{ $contact->fullname }}</td>
                                            <td class="text-center text-transform-initial">{{ $contact->email }}</td>
                                            <td class="text-center text-transform-initial">
                                                @if($contact->address_id !== NULL)
                                                <button class="btn-link text-white templateLink" data-template="{{ $contact->address->address }}" data-toggle="modal" data-target="#modal" type="button">[ Ver Dirección ]</button>
                                                @endif
                                            </td>
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
            $('.modal-title').html('Dirección');
            $('#html').html($(e.currentTarget).attr('data-template'));
        });
    });
</script>
@endsection