@extends('dashboard.layouts.app')

@section('title')
Agregar Variables a los Firmantes - Documentos
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
                <div class="row row-sm">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel panel-primary mt-3 tabs-style-7">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class=""><a href="javascript:void(0)">Informacón General</a></li>
                                            <li><a href="javascript:void(0)">Agregar Firmantes</a></li>
                                            <li><a href="#tabInformation" class="active" data-toggle="tab">Agregar Variables</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabInformation">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <h5>Documento: <strong>{{ $document->description }}</strong></h5>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    @foreach($document_contacts as $document_contact)
                                                        <div aria-multiselectable="true" class="accordion" data-id="{{ Crypt::encrypt($document_contact->id) }}" id="accordion{{ $document_contact->id }}" role="tablist">
                                                        <div class="card">
                                                            <div class="card-header" id="headingOne{{ $document_contact->id }}" role="tab">
                                                                <a aria-controls="collapseOne{{ $document_contact->id }}" aria-expanded="false" data-toggle="collapse" href="#collapseOne{{ $document_contact->id }}">{{ $document_contact->title }} - {{ $document_contact->fullname }} ({{ $document_contact->email }})</a>
                                                            </div>
                                                            <div aria-labelledby="headingOne{{ $document_contact->id }}" class="collapse" data-parent="#accordion{{ $document_contact->id }}" id="collapseOne{{ $document_contact->id }}" role="tabpanel">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 alerts alert{{ $document_contact->id }}">
                                                                            <div class="form-group">
                                                                                <div class="alert alert-danger">
                                                                                    <strong><h6 class="alertText{{ $document_contact->id }}"></h6></strong>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-lg tag_name" data-id="{{ Crypt::encrypt($document_contact->id) }}" placeholder="Ingrese variable" type="text">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="example">
                                                                                <div class="tags tags{{ $document_contact->id }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <input name="document_id" value="{{ Crypt::encrypt($document->id) }}" type="hidden">
                                                        {{-- <a class="btn btn-md btn-success waves-effect wave-dark" href="{{ route('dashboard.management.document.edit', Crypt::encrypt($document->document_id)) }}"><i class="material-icons">navigate_before</i> Anterior</a> --}}
                                                        <a class="btn btn-md btn-success waves-effect wave-dark" href="{{ route('dashboard.management.document.index') }}"><i class="material-icons">check_circle_outline</i> Finalizar</a>
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    var i = 0;

    $(function () {
        $('.alerts').hide();
        $('.accordion').click(e => loadVariable($(e.currentTarget).attr('data-id')));

        $('.tag_name').keypress(e => {
            if (e.which === 13) {
                $.ajax({
                    url: "{{ route('dashboard.management.document.storeContactVariable') }}",
                    data: {
                        variable : $(e.currentTarget).val(),
                        document_contact : $(e.currentTarget).attr('data-id'),
                    },
                    type: 'POST',
                    dataType: "JSON",
                    statusCode: {
                        422: function(data){
                            $(`.alert${data.responseJSON.document_contact}`).show('slow');
                            $(`.alertText${data.responseJSON.document_contact}`).html(data.responseJSON.errors);
                        },
                        200: function(data) {
                            $(`.alert${data.document_contact}`).hide('slow');
                            $(`.alertText${data.document_contact}`).html('');
                            $(e.currentTarget).val('');
                            $(e.currentTarget).focus();
                            loadVariable($(e.currentTarget).attr('data-id'));
                        }
                    }
                });
            }
        });
    });
    
    $(document).on('click', '.varibleBtn', e => {
        let document_contact = ($(e.currentTarget).attr('data-document'));
        $.ajax({
            url: "{{ route('dashboard.management.document.destroyDocumentContactVariable') }}",
            data: {
                document_contact : $(e.currentTarget).attr('data-value')
            },
            type: 'POST',
            dataType: "JSON",
            statusCode: {
                422: function(data){
                },
                200: function(data) {
                    loadVariable(document_contact);
                }
            }
        });
    });

    let loadVariable = (value) => {
        $.ajax({
            url: "{{ route('dashboard.management.document.indexDocumentContactVariable') }}",
            data: {
                document_contact : value
            },
            type: 'POST',
            dataType: "JSON",
            statusCode: {
                422: function(data){
                },
                200: function(data) {
                    let rows = '';

                    if (data != 0){
                        data.result.forEach((val, index) => {
                            if (val !== null) {
                                rows += `<span class="tag tag-dark">${val.variable} <a href="javascript:void(0)" class="tag-addon bg-danger varibleBtn" data-value="${val.value}" data-document="${val.document_contact}"><i class="material-icons font12" style="top:-5px !important; postion: relative !important;">close</i></a></span>`;
                            }
                        });
                    }

                    $(`.tags${data.document_contact}`).html(rows);
                }
            }
        });
    }
</script>
@endsection