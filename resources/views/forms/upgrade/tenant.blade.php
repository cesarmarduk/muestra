@extends('layouts.form')

@section('title')
Póliza Upgrade - Propietarios
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/dropzone/dist/dropzone.css') }}">
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/js/forms/ponyfill.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/slider.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/animation.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/gallery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/jquery.easing.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/dropzone/dist/dropzone.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/main.js') }}"></script>
@endsection

@section('content')
@include('layouts.partials-forms.slider')

<section id="progressbar" class="section-1 form">
    <div class="container">
        <div class="row justify-content-center">
            @if ($error === TRUE)
            <div class="col-sm-12 col-md-6 align-self-start">
                <div class="alert alert-danger">
                    <h5 class="text-center"><strong>La póliza no se encuentra registrada</strong></h5>
                </div>
            </div>
            @else
            <div class="col-sm-12 align-self-start">
                <form method="POST" action="{{ route('policies.upgrade.storeTenant')}}" enctype="multipart/form-data">
                    <ul class="progressbar">
                        <li id="step1" class="active">Propietarios</li>
                        <li id="step2" class="active">Inquilinos</li>
                        @if ($policy->type === 'Fiador')
                        <li id="step3">{{ $policy->type }}</li>
                        @elseif ($policy->type === 'Obligado Solidario')
                        <li id="step3">{{ $policy->type }}</li>
                        @endif
                    </ul>
                    <!-- Group 1 -->
                    <fieldset class="step-group" id="step-group1">
                        @include('layouts.partials-forms.errors')
                        @if(count($policy_signers) > 0)
                            @foreach($policy_signers as $row)
                                @php
                                    $policy_files = \App\Models\Management\PoliciesFiles::where('policy_id', '=', $policy->id)->where('signer_id', '=', $row->signer_id)->get();
                                @endphp
                                <div class="row">
                                    @if ($row->signer->type === 'Fisico')
                                    <div class="col-sm-12">
                                        <h4><strong>Datos del Trabajo de {{ $row->signer->name }}</strong></h4>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="hidden" name="tenant_type[]" value="{{ $row->signer->type }}">
                                            <input type="text" name="job_name[]" class="form-control form-control-lg" value="{{ $row->signer->name }}">
                                            <label for="job_name">Nombre completo</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="job_email[]" value="{{ $row->signer->email }}">
                                            <label for="job_email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="number" class="form-control form-control-lg" name="job_phone[]" value="{{ $row->signer->phone }}">
                                            <label for="job_phone">Télefono</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="job_address[]">
                                            <label for="job_address">Dirección</label>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-sm-12">
                                        <h4><strong>Datos del Inquilino de {{ $row->signer->company }}</strong></h4>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="hidden" name="tenant_type[]" value="{{ $row->signer->type }}">
                                            <input type="text" name="tenant_name[]" class="form-control form-control-lg" value="{{ $row->signer->company }}">
                                            <label for="tenant_name">Razón social y/o Empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" name="tenant_rfc[]" class="form-control form-control-lg" value="{{ $row->signer->rfc }}">
                                            <label for="tenant_rfc">RFC</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="email" name="tenant_email[]" class="form-control form-control-lg" value="{{ $row->signer->email }}">
                                            <label for="tenant_email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="number" name="tenant_phone[]" class="form-control form-control-lg" value="{{ $row->signer->phone }}">
                                            <label for="tenant_phone">Teléfono</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <h4><strong>Datos Notariales de {{ $row->signer->company }}</strong></h4>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_address[]">
                                            <label for="notarial_address">Dirección</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_writing[]">
                                            <label for="notarial_writing">Escritura</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_volume[]">
                                            <label for="notarial_volume">Volumen</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_book[]">
                                            <label for="notarial_book">Libro</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_notary[]">
                                            <label for="notarial_notary">Notario</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_invoice[]">
                                            <label for="notarial_invoice">Folio</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="notarial_place[]">
                                            <label for="notarial_place">Lugar</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="">Fecha</label><br>
                                        <select name="notarial_day[]" class="form-control day" style="width: 30% !important; float:left">
                                        </select>
                                        <select name="notarial_mounth[]" class="form-control" style="width: 30% !important; float:left">
                                            <option value="01">Enero</option>
                                            <option value="02">Febrero</option>
                                            <option value="03">Marzo</option>
                                            <option value="04">Abril</option>
                                            <option value="05">Mayo</option>
                                            <option value="06">Junio</option>
                                            <option value="07">Julio</option>
                                            <option value="08">Agosto</option>
                                            <option value="09">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                        <select name="notarial_year[]" class="form-control year" style="width: 40% !important; float:left">
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="representative1{{ $row->id }}">
                                                <input class="form-check-input representative1" type="radio" name="representative[]" id="representative1{{ $row->id }}" data-id="{{ $row->id }}" value="Si" checked>
                                                <h5>Con representante</h5>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="representative2{{ $row->id }}">
                                                <input class="form-check-input representative2" type="radio" name="representative[]" id="representative2{{ $row->id }}" data-id="{{ $row->id }}" value="No">
                                                <h5>Sin representante</h5>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 repre{{ $row->id }}">
                                        <h4><strong>Datos del Representante de {{ $row->signer->company }}</strong></h4>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 repre{{ $row->id }}">
                                        <div class="md-form">
                                            <input type="text" name="representative_first_name[]" class="form-control form-control-lg">
                                            <label for="representative_first_name">Nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 repre{{ $row->id }}">
                                        <div class="md-form">
                                            <input type="text" name="representative_last_name[]" class="form-control form-control-lg">
                                            <label for="representative_last_name">Apellido</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 repre{{ $row->id }}">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="representative_email[]">
                                            <label for="representative_email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 repre{{ $row->id }}">
                                        <div class="md-form">
                                            <input type="number" class="form-control form-control-lg" name="representative_phone[]">
                                            <label for="representative_phone">Télefono</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 repre{{ $row->id }}">
                                        <div class="md-form">
                                            <input type="text" class="form-control form-control-lg" name="representative_address[]">
                                            <label for="representative_address">Dirección</label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        @if ($row->signer->type === 'Fisico')
                                        <h4><strong>Archivos de {{ $row->signer->name }}</strong></h4>
                                        @else
                                        <h4><strong>Archivos de {{ $row->signer->company }}</strong></h4>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="id">IDENTIFICACION OFICIAL (INE, PASAPORTE, CARTILLA MILITAR)</label>
                                            @if (isset($policy_files[0]->file_id))
                                                @if ($row->signer_id === $policy_files[0]->signer_id)
                                                <a href="{{ route('policies.upgrade.file', Crypt::encrypt($policy_files[0]->file_id)) }}" download="{{ $policy_files[0]->file->name }}" class="btn btn-success waves-effect waves-dark" target="_blank">DESCARGAR ARCHIVO</a>
                                                @else
                                                <input type="file" class="form-control" name="tenant_id[]" id="file">
                                                @endif
                                            @else
                                            <input type="file" class="form-control" name="tenant_id[]" id="file">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="address">COMPROBANTE DE DOMICILIO</label>
                                            @if (isset($policy_files[1]->file_id))
                                                @if ($row->signer_id === $policy_files[1]->signer_id)
                                                <a href="{{ route('policies.upgrade.file', Crypt::encrypt($policy_files[1]->file_id)) }}" download="{{ $policy_files[1]->file->name }}" class="btn btn-success waves-effect waves-dark" target="_blank">DESCARGAR ARCHIVO</a>
                                                @else
                                                <input type="file" class="form-control" name="tenant_address[]" id="file">
                                                @endif
                                            @else
                                            <input type="file" class="form-control" name="tenant_address[]" id="file">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="earnings">COMPROBANTE DE INGRESOS</label>
                                            @if (isset($policy_files[2]->file_id))
                                                @if ($row->signer_id === $policy_files[2]->signer_id)
                                                <a href="{{ route('policies.upgrade.file', Crypt::encrypt($policy_files[2]->file_id)) }}" download="{{ $policy_files[2]->file->name }}" class="btn btn-success waves-effect waves-dark" target="_blank">DESCARGAR ARCHIVO</a>
                                                @else
                                                <input type="file" class="form-control" name="tenant_earnings[]" id="file">
                                                @endif
                                            @else
                                            <input type="file" class="form-control" name="tenant_earnings[]" id="file">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4><strong>Referencia Familiar</strong></h4>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="md-form">
                                        <input type="text" name="ref_family_name" class="form-control form-control-lg">
                                        <label for="ref_family_name">Nombre completo</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="md-form">
                                        <input type="email" name="ref_family_email" class="form-control form-control-lg">
                                        <label for="ref_family_email">Email</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="md-form">
                                        <input type="number" name="ref_family_phone" class="form-control form-control-lg">
                                        <label for="ref_family_phone">Teléfono</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="md-form">
                                        <input type="number" name="ref_family_mobile" class="form-control form-control-lg">
                                        <label for="ref_family_mobile">Celular</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4><strong>Referencia No Familiar</strong></h4>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="md-form">
                                        <input type="text" name="ref_no_family_name" class="form-control form-control-lg">
                                        <label for="ref_no_family_name">Nombre completo</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="md-form">
                                        <input type="email" name="ref_no_family_email" class="form-control form-control-lg">
                                        <label for="ref_no_family_email">Email</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="md-form">
                                        <input type="number" name="ref_no_family_phone" class="form-control form-control-lg">
                                        <label for="ref_no_family_phone">Teléfono</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="md-form">
                                        <input type="number" name="ref_no_family_mobile" class="form-control form-control-lg">
                                        <label for="ref_no_family_mobile">Celular</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 input-group p-0 d-flex justify-content-between justify-content-md-start">
                                    <input name="policy" value="{{ Crypt::encrypt($policy->id) }}" type="hidden">
                                    <a class="step-next btn primary-button m-r4" href="{{ route('policies.upgrade.owner', Crypt::encrypt($policy->id)) }}"><i class="icon-arrow-left-circle"></i> ANTERIOR</a>
                                    <button class="step-next btn primary-button" type="submit">
                                        @if ($policy->type === 'Sin Fiador')
                                        <i class="icon-check"></i> FINALIZAR
                                        @else
                                        SIGUIENTE <i class="icon-arrow-right-circle left"></i>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        @endif
                    </fieldset>
                </form>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript">
    $(function() {
        $("body").on("click", ".representative1",function() {
            let id=$(this).attr('data-id');
            $(`.repre${id}`).show('fast');
        });
        
        $("body").on("click", ".representative2",function() {
            let id=$(this).attr('data-id');
            $(`.repre${id}`).hide('fast');
        });

        calculatorDays();
        calculatorYears();
    });

    let calculatorDays = () => {
        let rows;
        for(var x = 1; x <= 31; x++){
            rows += `<option value="${x}">${x}</option>`;
        }

        $('.day').html(rows);
    }
    
    let calculatorYears = () => {
        var fecha   = new Date();
        var ano     = parseInt(fecha.getFullYear()) + parseInt(50);
        let rows;

        for(var z = ano; z >= 1900; z--){
            rows += `<option value="${z}">${z}</option>`;
        }

        $('.year').html(rows);
        $('.year').val(fecha.getFullYear());
    }
</script>
@endsection