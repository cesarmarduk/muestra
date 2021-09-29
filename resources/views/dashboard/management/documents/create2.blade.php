@extends('dashboard.layouts.app')

@section('title')
Agregar Firmantes - Documentos
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/inputtags/inputtags.css') }}">
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/plugins/inputtags/inputtags.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
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
            <div class="card-body" id="tabs-style7">
                <form method="POST" enctype="multipart/form-data" action="{{ route('dashboard.management.document.storeContact') }}">
                    @include('dashboard.layouts.partials.errors')
                    <div class="row row-sm">
                        <div class="col-sm-12">
                            <div class="panel">
                                <div class="panel panel-primary mt-3 tabs-style-7">
                                    <div class="tab-menu-heading">
                                        <div class="tabs-menu">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs">
                                                <li class=""><a href="javascript:void(0)">Informacón General</a></li>
                                                <li><a href="#tabInformation" class="active" data-toggle="tab">Agregar Firmantes</a></li>
                                                <li><a href="javascript:void(0)">Agregar Variables</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tabInformation">
                                                <div class="row row-sm">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <div class="alert alert-danger">
                                                                <h5 class="text-center"><strong>Es importante mantener el orden de los firmantes para el desarrollo del documento</strong></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row row-sm">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <button class="btn btn-md btn-info waves-effect waves-dark" id="addContactBtn" type="button"><i class="material-icons">add_circle_outline</i> Agregar Firmante</button>
                                                            <button class="btn btn-md btn-danger waves-effect waves-dark" id="removeContactBtn" type="button"><i class="material-icons">remove_circle_outline</i> Eliminar Firmante</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row row-sm addContact">
                                                    <div class="col-9 col-sm-9 col-md-9 col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="count">Cantidad de firmantes</label>
                                                            <input autofocus type="number" class="form-control form-control-lg" name="count" id="count" placeholder="Ingrese la cantidad">
                                                        </div>
                                                    </div>
                                                    <div class="col-3 col-sm-3 col-md-3 col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-control-label">&nbsp;</label>
                                                            <button class="btn btn-md btn-info waves-effect waves-dark top30" id="generateBtn" type="button">Generar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row row-sm">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <input name="document_id" value="{{ Crypt::encrypt($document->id) }}" type="hidden">
                                                            {{-- <a class="btn btn-md btn-success waves-effect wave-dark" href="{{ route('dashboard.management.document.edit', Crypt::encrypt($document->document_id)) }}"><i class="material-icons">navigate_before</i> Anterior</a> --}}
                                                            <button class="btn btn-md btn-success waves-effect wave-dark" type="submit">Siguiente <i class="material-icons">navigate_next</i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    var i = 0;

    $(function () {
        $('#generateBtn').click(e => {
            $('.items').remove();
            i = 0;
            for(var k = 1; k <= $('#count').val(); k++){
                i++;
                add();
            }

            $('#count').attr('disabled', 'disabled');
            $(e.currentTarget).attr('disabled', 'disabled');
        });

        $('#addContactBtn').click(() => {
            i++;
            add();
        });

        $('#removeContactBtn').click(() => {
            if (i > 0) {
                $(`.itemContact${i}`).remove();
                i--;
            } 
            if (i === 0){
                $('#generateBtn').removeAttr('disabled');
                $('#count').removeAttr('disabled');
                $('#count').val('');
                $('#count').focus();
            }
        });
    });

    let add = () => {
        if (i === 1) {
            $('.addContact').after(`<div class="row row-sm items itemContact${i}"> 
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-control-label">ORDEN ${i}</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <input name="order[]" value="${i}" type="hidden">
                        <label class="form-control-label" for="title">Título Descriptivo</label>
                        <input name="title[]" class="form-control form-control-lg" type="text">
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="form-control-label" for="fullname"> Nombres y Apellidos</label>
                        <input name="fullname[]" class="form-control form-control-lg" type="text">
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="form-control-label" for="email">Email</label>
                        <input name="email[]" class="form-control form-control-lg" type="email">
                    </div>
                </div>
                <div
            </div>`);
        } else {
            $(`.itemContact${i-1}`).after(`<div class="row row-sm items itemContact${i}"> 
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-control-label">ORDEN ${i}</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <input name="order[]" value="${i}" type="hidden">
                        <label class="form-control-label" for="title">Título Descriptivo</label>
                        <input name="title[]" class="form-control form-control-lg" type="text">
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="form-control-label" for="fullname"> Nombres y Apellidos</label>
                        <input name="fullname[]" class="form-control form-control-lg" type="text">
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="form-control-label" for="email">Email</label>
                        <input name="email[]" class="form-control form-control-lg" type="email">
                    </div>
                </div>
                <div
            </div>`);
        }
    }
</script>
@endsection