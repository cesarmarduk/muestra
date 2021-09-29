@extends('dashboard.layouts.app')

@section('title')
Crear - Contacto
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
                <form method="POST" action="{{ route('dashboard.management.contact.store') }}">
                    @include('dashboard.layouts.partials.errors')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fullname">Nombres y Apellidos</label>
                                <div class="input-group @if($errors->get('fullname')) is-invalid @endif">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="material-icons text-white tx-24 lh--9 op-6">face</i>
                                        </div>
                                    </div>
                                    <input type="text" id="fullname" class="form-control form-control-lg text-white" name="fullname" value="{{ old('fullname') }}" placeholder="Ingrese nombres y apellidos" autofocus>
                                </div>
                            </div>
                        </div>                            
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-group @if($errors->get('email')) is-invalid @endif">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="material-icons text-white tx-24 lh--9 op-6">mail</i>
                                        </div>
                                    </div>
                                    <input type="email" id="email" class="form-control form-control-lg text-white" name="email" value="{{ old('email') }}" placeholder="Ingrese email">
                                </div>
                            </div>
                        </div>
                        <div class="col-10 col-sm-5 col-md-5">
                            <div class="form-group">
                                <label for="address_id">Dirección</label>
                                <select id="address_id" class="form-control form-control-lg text-white" name="address_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-2 col-sm-1 col-md-1">
                            <div class="form-group">
                                <button class="btn btn-info btn-icon waves-effect wave-dark top28" data-toggle="modal" data-target="#addressModal" data-backdrop="static" type="button"><i class="material-icons">add</i></button>
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

@include('dashboard.management.contacts.partials.addressModal')

@section('js')
<script type="text/javascript">
    $(function () {
        address();

        $('.addressName').hide();
        $('#addressName').keypress(e => {
            if (e.which === 13) {
                saveAddress();
            }
        });

        $('#saveAddressBtn').click(e => saveAddress());
    });

    let address = () => {
        $("#address_id").select2({
            placeholder: "-- Seleccione una opción --",
            allowClear: true,
            width: "100%",
            ajax: {
                url: "{{ route('dashboard.management.address.indexAjax') }}",
                dataType: "JSON",
                type: "POST",
                data: function (params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items,
                    };
                },
                cache: true,
            }
        });
    }

    let saveAddress = () => {
        $.ajax({
            url: "{{ route('dashboard.management.address.storeAjax') }}",
            data: {
                address : $('#addressName').val(),
            },
            type: 'POST',
            dataType: "JSON",
            statusCode: {
                422: function(data){
                    if (data.responseJSON.address.length > 0){
                        let rows = '';
                        $('.form-control-addressName').addClass('is-invalid');
                        data.responseJSON.address.forEach((val, index) => {
                            if (val !== null) {
                                rows += `<li><strong>${val}</strong></li>`;
                            }
                        });
                        $('.addressNameUl').html(rows);
                        $('.addressName').show('slow');
                    } else {
                        $('.form-control-addressName').removeClass('is-invalid');
                        $('.addressNameUl').html('');
                        $('#addressName').val('');
                        $('.addressName').hide('slow');
                    }
                },
                200: function(data) {
                    $('.form-control-addressName').removeClass('is-invalid');
                    $('.addressNameUl').html('');
                    $('#addressName').val('');
                    $('.addressName').hide('slow');
                    $('#addressModal').modal('hide');
                }
            }
        });
    }
</script>
@endsection