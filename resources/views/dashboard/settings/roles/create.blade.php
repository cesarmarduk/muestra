@extends('dashboard.layouts.app')

@section('title')
Crear - Rol
@endsection

@section('content')
<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <form method="POST" action="{{ route('dashboard.settings.role.store') }}">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title')</h4>
                    </div>
                </div>
                <div class="card-body">
                    @include('dashboard.layouts.partials.errors')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input autofocus class="form-control @if($errors->get('name')) is-invalid @endif" name="name" id="name" value="{{ old('name') }}" placeholder="Ingres rol" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Asigne los permisos al Rol</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($titles as $key => $title)
                            <div class="col-sm-6 col-md-4">
                                <div aria-multiselectable="true" class="accordion" id="accordion{{ $key }}" role="tablist">
                                    <div class="card">
                                        <div class="card-header" id="headingOne{{ $key }}" role="tab">
                                            <a aria-controls="collapseOne{{ $key }}" aria-expanded="false" data-toggle="collapse" href="#collapseOne{{ $key }}">{{ $title }}</a>
                                        </div>
                                        <div aria-labelledby="headingOne{{ $key }}" class="collapse" data-parent="#accordion{{ $key }}" id="collapseOne{{ $key }}" role="tabpanel">
                                            <div class="card-body">
                                                <ul class="list-group">
                                                    @foreach($permissions as $permission)
                                                        @php 
                                                            $name  = explode('.', $permission->name);
                                                            $name  = strtoupper($name[0]);
                                                        @endphp
                                                        @if ($name === $title)
                                                            <li class="list-group-item"><label for="permissions"><input type="checkbox" class="form-control margin-right10 height20 width20 float-left" name="permissions[]" value="{{ $permission->id }}"><span>{{ $permission->name }}</span></label></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-md btn-success waves-effect wave-dark" type="submit"><i class="material-icons">save</i> Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection