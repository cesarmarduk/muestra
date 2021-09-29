@extends('dashboard.layouts.app')

@section('title')
Editar - Dirección
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
                <form method="POST" action="{{ route('dashboard.management.address.update', Crypt::encrypt($address->id)) }}">
                    @include('dashboard.layouts.partials.errors')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <textarea cols="40" rows="6" autofocus class="form-control @if($errors->get('address')) is-invalid @endif" name="address" id="address" placeholder="Ingrese dirección">{{ old('address', $address->address) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button class="btn btn-md btn-success waves-effect wave-dark" type="submit"><i class="material-icons">save</i> Actualizar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection