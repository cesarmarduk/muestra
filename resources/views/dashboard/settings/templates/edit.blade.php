@extends('dashboard.layouts.app')

@section('title')
Editar - Plantilla
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/ckeditor/adapters/jquery.js') }}"></script>
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
                <form method="POST" action="{{ route('dashboard.settings.template.update', Crypt::encrypt($template->id)) }}">
                    @include('dashboard.layouts.partials.errors')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input autofocus class="form-control @if($errors->get('name')) is-invalid @endif" name="name" id="name" value="{{ old('name', $template->name) }}" placeholder="Ingres nombre" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="type_id">Tipo</label>
                                <select id="type_id" class="form-control form-control-lg select2 text-white @if($errors->get('type_id')) is-invalid @endif" name="type_id">
                                    <option value="">-- Seleccione una opción --</option>
                                    @foreach($types as $type)
                                        @if($template->type_id === $type->id)
                                        <option value="{{ $type->id }}" selected="selected">{{ $type->name }}</option>
                                        @else 
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="template">Plantilla</label>
                                <textarea name="template" rows="80" cols="10" class="form-control @if($errors->get('template')) is-invalid @endif" name="template">{{old('template', $template->template)}}</textarea>
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

@section('js')
@include('dashboard.layouts.partials.ckeditor')
<script type="text/javascript">
    $(function () {
        $('.select2').select2();
    });
</script>
@endsection