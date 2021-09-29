@extends('dashboard.layouts.app')

@section('title')
Listado - Documentos
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
<div class="breadcrumb-area">
    <h1>Documentos</h1>

    <ol class="breadcrumb">
        <li class="item"><a href="dashboard-analytics.html"><i class='bx bx-home-alt'></i></a></li>

        <li class="item">Documentos</li>

        <li class="item">Mis Documentos</li>
    </ol>
</div>
<!-- End Breadcrumb Area -->

<!-- Start -->
<div class="card mb-30">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Mis Documentos</h3>

        
    </div>

    <div class="card-body">
        <div class="col-sm-12">
            {{-- <div class="form-group">
                <a class="btn btn-md btn-success waves-effect wave-dark" href="{{ route('dashboard.management.document.createDocument') }}"><i class="material-icons">+</i> Nuevo</a>
            </div> --}}
        </div>
        <table id="table" class="table table-striped">
            <thead>
                <tr>
                  


                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Descripción</th>
                    <th scope="col" class="text-center"> Adjunto</th>
                    <th scope="col" class="text-center">Solicitar</th>
                    <th scope="col" class="text-center">Estatus</th>
                    <th scope="col" class="text-center"> Firmantes</th>
                    {{-- <th scope="col" class="text-center">Acciones</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $document)
                <tr>
                    <td class="text-center text-transform-initial" style="font-size:25px">
                        {{-- <a class="btn-link" href="{{ route('dashboard.management.document.edit', Crypt::encrypt($document->id)) }}"><i class="material-icons text-success">edit</i></a> --}}
                        <a class="btn-link" href="{{ route('dashboard.management.document.destroy', Crypt::encrypt($document['id'])) }}"><span class="icon"><i class='bx bxs-trash'></i></span></a>
                        @if ($document['path'] === TRUE)
                        <a class="btn-link" href="{{ asset('public/'.$document['file']) }}" target="_blank"> <span class="icon"><i class='bx bxs-file-doc'></i></span></a>
                        @endif
                    </td>
                    <td class="text-transform-initial">{{ $document['description'] }}</td>
                    <td class="text-center text-transform-initial">{{ $document['template'] }}</td>
                    <td class="text-center text-transform-initial">
                        @if ($document['request'] === TRUE)
                        <button class="btn btn-md btn-light waves-effect wavesdark requestBtn" data-id="{{ Crypt::encrypt($document['id'])}}" type="button">Solicitar</button>
                        @endif
                    </td>
                    <td class="text-center text-transform-initial">
                        <div class="badge badge-md badge-{{ $document['color'] }}">{{ $document['status_document'] }}</div>
                    </td>
                    <td class="text-center text-transform-initial">
                        {{-- @if ($document['contacts'] === TRUE) --}}
                        <a class="btn btn-md btn-success waves-effect waves-dark" href="{{ route('dashboard.management.document.contacts', Crypt::encrypt($document['id'])) }}">Firmantes</a>
                        {{-- @endif --}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="flex-grow-1"></div>
{{-- <!-- row opened -->
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
                            <a class="btn btn-md btn-success waves-effect wave-dark" href="{{ route('dashboard.management.document.createDocument') }}"><i class="material-icons">add</i> Nuevo</a>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-md-nowrap" id="table">
                                <thead>
                                    <tr>
                                        <th class="wd-10p border-bottom-0"></th>
                                        <th class="wd-45p border-bottom-0">Descripción</th>
                                        <th class="wd-10p text-center border-bottom-0">Adjunto</th>
                                        <th class="wd-15p text-center border-bottom-0">Solicitar</th>
                                        <th class="wd-10p text-center border-bottom-0">Estatus</th>
                                        <th class="wd-10p text-center border-bottom-0">Firmantes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $document)
                                        <tr>
                                            <td class="text-center text-transform-initial">
                                                {{-- <a class="btn-link" href="{{ route('dashboard.management.document.edit', Crypt::encrypt($document->id)) }}"><i class="material-icons text-success">edit</i></a> 
                                                <a class="btn-link" href="{{ route('dashboard.management.document.destroy', Crypt::encrypt($document['id'])) }}"><i class="material-icons text-danger">delete</i></a>
                                                @if ($document['path'] === TRUE)
                                                <a class="btn-link" href="{{ asset($document['file']) }}" target="_blank"><i class="material-icons text-danger">picture_as_pdf</i></a>
                                                @endif
                                            </td>
                                            <td class="text-transform-initial">{{ $document['description'] }}</td>
                                            <td class="text-center text-transform-initial">{{ $document['template'] }}</td>
                                            <td class="text-center text-transform-initial">
                                                @if ($document['request'] === TRUE)
                                                <button class="btn btn-md btn-light waves-effect wavesdark requestBtn" data-id="{{ Crypt::encrypt($document['id'])}}" type="button">Solicitar</button>
                                                @endif
                                            </td>
                                            <td class="text-center text-transform-initial">
                                                <div class="badge badge-md badge-{{ $document['color'] }}">{{ $document['status_document'] }}</div>
                                            </td>
                                            <td class="text-center text-transform-initial">
                                                @if ($document['contacts'] === TRUE)
                                                <a class="btn btn-md btn-success waves-effect waves-dark" href="{{ route('dashboard.management.document.contacts', Crypt::encrypt($document['id'])) }}">Firmantes</a>
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
</div> --}}
@endsection

@include('dashboard.management.documents.partials.contactsModal')

@section('js')
@include('dashboard.layouts.partials.datatable')
<script type="text/javascript">
    $(function() {
        $(document).on('click', '.requestBtn', e => {
            $.ajax({
                url: "{{ route('dashboard.management.document.requestFirm') }}",
                data: {
                    document : $(e.currentTarget).attr('data-id')
                },
                type: 'POST',
                dataType: "JSON",
                statusCode: {
                    422: function(data){
                        swalAccept(data.responseJSON.title, data.responseJSON.message, data.responseJSON.type);
                    },
                    200: function(data) {
                        swalAccept(data.title, data.message, data.type);
                    }
                }
            });
        });
        
        $(document).on('click', '.contactLink', e => {
            $('.modal-title').html('Contactos');
            $('.html').html($(e.currentTarget).attr('data-contact'));
        });
    });

    let swalAccept = (title, message, type) => {
        swal({
            title: title,
            html: message,
            type: type,
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar',
        }).then(result => {
            if (result.value === true){
                $(location).attr("href", "{{ route('dashboard.management.document.index') }}");
            } 
        });
    }
</script>
@endsection