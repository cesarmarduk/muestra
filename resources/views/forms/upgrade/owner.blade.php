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
                <form method="POST" action="{{ route('policies.upgrade.storeOwner')}}" enctype="multipart/form-data">
                    <ul class="progressbar">
                        <li id="step1" class="active">Propietarios</li>
                        <li id="step2">Inquilinos</li>
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
                                    <div class="col-sm-12">
                                        <h4><strong>Archivos de {{ $row->signer->name }}</strong></h4>
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
                                                <input type="file" class="form-control" name="owner_id[]" id="file">
                                                @endif
                                            @else
                                            <input type="file" class="form-control" name="owner_id[]" id="file">
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
                                                <input type="file" class="form-control" name="owner_address[]" id="file">
                                                @endif
                                            @else
                                            <input type="file" class="form-control" name="owner_address[]" id="file">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12 input-group p-0 d-flex justify-content-between justify-content-md-start">
                                    <input name="policy" value="{{ Crypt::encrypt($policy->id) }}" type="hidden">
                                    <button class="step-next btn primary-button" type="submit">SIGUIENTE <i class="icon-arrow-right-circle left"></i></button>
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