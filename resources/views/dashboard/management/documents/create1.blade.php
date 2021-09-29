@extends('dashboard.layouts.app')

@section('title')
Información General - Documentos
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
                <form method="POST" enctype="multipart/form-data" action="{{ route('dashboard.management.document.storePhotoProfile') }}">
                    @include('dashboard.layouts.partials.errors')
                    <div class="row row-sm">
                        <div class="col-sm-12">
                            <div class="panel">
                                <div class="panel panel-primary mt-3 tabs-style-7">
                                    <div class="tab-menu-heading">
                                        <div class="tabs-menu">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs">
                                                <li class=""><a href="#tabInformation" class="active" data-toggle="tab">Informacón General</a></li>
                                                <li><a href="javascript:void(0)">Agregar Firmantes</a></li>
                                                <li><a href="javascript:void(0)">Agregar Variables</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tabInformation">
                                                <div class="row row-sm">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="description">Descripción</label>
                                                            <textarea autofocus cols="40" rows="4" class="form-control form-control-lg" name="description" id="description" placeholder="Ingrese descripción"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="template"><input checked value="Si" name="template" class="form-control margin-right10 height20 width20 float-left" id="template" type="checkbox"><span> Adjuntar modelo de documento</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 template">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Adjunto del documento (formato PDF): </label> 
                                                            <div class="input-group file-browser">
                                                                <input type="text" class="form-control border-right-0 browse-file" id="labelFile" placeholder="Cargar archivo" readonly>
                                                                <label class="input-group-btn">
                                                                    <span class="btn btn-md btn-primary">
                                                                        Haz click aquí <input type="file" id="file_id" name="file_id" style="display: none;">
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row row-sm">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
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
    $(function () {
        $('#template').click(e => {
            // if ($(e.currentTarget).prop('checked') === true){
            //     $(e.currentTarget).val('Yes');
            //     $('.template').show('slow');
            // } else {
            //     $(e.currentTarget).val('No');
            //     $('.template').hide('slow');
            //     $('#labelFile').val('');
            //     $('#file_id').val('');
            // }
        });

        $('#file_id').change(function(event) {
            if (this.files[0] === undefined || this.files[0] === "undefined") {
                $('#labelFile').val('');
                $(this).val('');
            } else {
                $('#labelFile').val(this.files[0].name);
            }
	    });
    });
</script>
@endsection