@extends('layouts.app')

@section('title')
Verificar Email
@endsection

@section('content')
<div class="row no-gutter justify-content-center top50">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3 class="text-primary text-transform-initial">@yield('title')</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="text-center text-transform-initial alert alert-{{ $color }}" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Route::has('register'))
                <div class="row">
                    <div class="col-sm-12 margin-bottom10">
                        <a class="btn-link float-right text-transform-initial" href="{{ route('login') }}">
                            Ingresar al sistema
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
