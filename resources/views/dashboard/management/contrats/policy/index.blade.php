@extends('dashboard.layouts.appProgress')

@section('title')
Mis contratos - Pólizas
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
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
        <h3>Pólizas</h3>

        <a href="{{ route('dashboard.management.policies.create') }}" data-toggle="tooltip" data-placement="top" title="Agregar Contrato Con Poliza"  class="btn btn-success">+ Agregar </a>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-md-nowrap" id="table">
                        <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">Folio</th>
                                <th class="wd-10p text-center border-bottom-0">Tipo de Póliza</th>
                                <th class="wd-10p text-center border-bottom-0">Tipo de Pago</th>
                                <th class="wd-10p text-center border-bottom-0">Fecha Inicio</th>
                                <th class="wd-10p text-center border-bottom-0">Fecha Final</th>
                                <th class="wd-10p text-center border-bottom-0">Costo</th>
                                <th class="wd-10p text-center border-bottom-0">Estatus</th>
                                <th class="wd-5p text-center border-bottom-0">Pólizas</th>
                                <th class="wd-5p text-center border-bottom-0">Contrato Arre.</th>
                                <th class="wd-5p text-center border-bottom-0">Contrato Serv.</th>
                                <th class="wd-5p text-center border-bottom-0">Pagaré</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($policies as $policy)
                                <tr>
                                    <td class="text-transform-initial">{{ $policy['folio'] }}</td>
                                    <td class="text-transform-initial">{{ $policy['type'] }}</td>
                                    <td class="text-center text-transform-initial">{{ $policy['policy_type'] }}</td>
                                    <td class="text-center text-transform-initial">{{ $policy['date_beginning'] }}</td>
                                    <td class="text-center text-transform-initial">{{ $policy['date_finish'] }}</td>
                                    <td class="text-right text-transform-initial">{{ $policy['cost'] }}</td>
                                    <td class="text-center text-transform-initial">
                                        @php
                                            if ($policy['status'] === 'Creada'): 
                                                $color = 'default';
                                            elseif ($policy['status'] === 'Solicitud'): 
                                                $color = 'info';
                                            elseif ($policy['status'] === 'Autorizada'): 
                                                $color = 'warning';
                                            elseif ($policy['status'] === 'Activa'): 
                                                $color = 'warning';
                                            elseif ($policy['status'] === 'Rechazada'): 
                                                $color = 'danger';
                                            endif;
                                        @endphp
                                        <span class="badge badge-{{ $color }}">{{ $policy['status'] }}</span>
                                    </td>
                                    <td class="text-center text-transform-initial">
                                        @if ($policy['status'] === 'Autorizada')
                                        <div class="btn btn-success exportPdf" data-url="{{ $policy['poliza'] }}">Descargar</div>
                                        @endif
                                    </td>
                                    <td class="text-center text-transform-initial">
                                        @if ($policy['status'] === 'Autorizada')
                                        <div class="btn btn-success exportPdf" data-url="{{ $policy['cont_arre'] }}">Descargar</div>
                                        @endif
                                    </td>
                                    <td class="text-center text-transform-initial">
                                        @if ($policy['status'] === 'Autorizada')
                                        <div class="btn btn-success exportPdf" data-url="{{ $policy['cont_serv'] }}">Descargar</div>
                                        @endif
                                    </td>
                                    <td class="text-center text-transform-initial">
                                        @if ($policy['status'] === 'Autorizada')
                                        <div class="btn btn-success exportPdf" data-url="{{ $policy['pagare'] }}">Descargar</div>
                                        @endif
                                    </td>
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

@section('js')
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $("#search").keyup(() => getAll(1));

        $("#pagination").change(() => page()); 
    });

    $(document).on('click', '.exportPdf', e => {
        exportPdf($(e.currentTarget).attr('data-url'));
    });

    let exportPdf = (url) => {
        swal({
            title: 'Archivo generado',
            html: url,
            type: 'success',
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar',
            showCancelButton: false
        });
    }
</script>
@endsection