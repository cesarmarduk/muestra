@extends('layouts.error')

@section('title')
{{ 'Error '.$error }}
@endsection

@section('content')
<div class="main-error-wrapper page page-h">
    <h1 class="text-white tx-130">{{ $error }}</h1>
    <h2 class="tx-white-8">La página que buscaba no existe.</h2>
    <h6 class="tx-white-6">Es posible que haya escrito mal la dirección o que la página se haya movido.</h6>
    <a href="{{ redirect()->back() }}" class="btn btn-md btn-danger waves-effect waves-dark"><i class="material-icons">keyboard_return</i> Retornar</a>
</div>
@endsection