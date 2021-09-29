@extends('dashboard.layouts.appProgress')

@section('title')
Mis contratos - Extinción
@endsection

@section('content')
<div class="breadcrumb-area">
    <h1>Dashboard</h1>

    <ol class="breadcrumb">
        <li class="item"><a href="dashboard-analytics.html"><i class='bx bx-home-alt'></i></a></li>
        <li class="item">Dashboard</li>
    </ol>
</div>
<!-- End Breadcrumb Area -->

<!-- Start -->
<div class="card mb-30">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Contratos de Extinción</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-md-nowrap" id="table">
                        <thead>
                            <tr>
                                <th class="wd-20p border-bottom-0">Type</th>
                                <th class="wd-10p border-bottom-0">Fecha Inicio</th>
                                <th class="wd-10p border-bottom-0">Fecha Final</th>
                                <th class="wd-15p border-bottom-0">Renta Anual</th>
                                <th class="wd-15p border-bottom-0">Renta Mensual</th>
                                <th class="wd-15p border-bottom-0">Depósito</th>
                                <th class="wd-15p border-bottom-0">Uso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contrats as $contrat)
                                <tr>
                                    <td class="text-transform-initial">{{ $contrat->type }}</td>
                                    <td class="text-center text-transform-initial">{{ $contrat->date_beginning }}</td>
                                    <td class="text-center text-transform-initial">{{ $contrat->date_finish }}</td>
                                    <td class="text-right text-transform-initial">{{ number_format($contrat->rent_annual, '2', '.', ',') }}</td>
                                    <td class="text-right text-transform-initial">{{ number_format($contrat->rent_montly, '2', '.', ',') }}</td>
                                    <td class="text-right text-transform-initial">{{ number_format($contrat->deposit, '2', '.', ',') }}</td>
                                    <td class="text-center text-transform-initial">{{ $contrat->use }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
 <div class="flex-grow-1"></div>
@endsection