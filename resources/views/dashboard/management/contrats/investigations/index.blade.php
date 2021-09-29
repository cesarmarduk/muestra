@extends('dashboard.layouts.appProgress')

@section('title')
Mis contratos - Investigaciones al Arrendatario
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
@endsection

@section('content')
<div class="breadcrumb-area">
    <h1>Dashboard</h1>

    <ol class="breadcrumb">
        <li class="item"><a href="dashboard-analytics.html"><i class='bx bx-home-alt'></i></a></li>
        <li class="item">Investigaciones al Arrendatario</li>
    </ol>
</div>
<!-- End Breadcrumb Area -->

<!-- Start -->
<div class="card mb-30">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Investigaciones al Arrendatario</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-md-nowrap" id="table">
                        <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">ID</th>
                                <th class="wd-10p border-bottom-0">Tipo documento</th>
                                <th class="wd-10p text-center border-bottom-0">Firmantes</th>
                                <th class="wd-10p text-center border-bottom-0">Fecha Solicitud</th>
                                <th class="wd-10p text-center border-bottom-0">Fecha Completado</th>
                                <th class="wd-10p text-center border-bottom-0">Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($investigations as $investigation)
                                <tr>
                                    <td class="text-transform-initial">{{ $investigation['folio'] }}</td>
                                    <td class="text-transform-initial">{{ $investigation['type'] }}</td>
                                   
                                  
                                    <td class="text-center text-transform-initial">{{ $investigation['date_finish'] }}</td>
                                    <td class="text-right text-transform-initial">{{ $investigation['cost'] }}</td>
                                    <td class="text-center text-transform-initial">
                                        @php
                                            $color = 'default';
                                            if ($investigation['status'] === 'Creada'): 
                                                $color = 'default';
                                            elseif ($investigation['status'] === 'Solicitud'): 
                                                $color = 'info';
                                            elseif ($investigation['status'] === 'Autorizada'): 
                                                $color = 'warning';
                                            elseif ($investigation['status'] === 'Activa'): 
                                                $color = 'warning';
                                            elseif ($investigation['status'] === 'Rechazada'): 
                                                $color = 'danger';
                                            endif;
                                        @endphp
                                        <span class="badge badge-{{ $color }}">{{ $investigation['status'] }}</span>
                                    </td>
                                    <td class="text-center text-transform-initial">
                                        @if ($investigation['status'] === 'Autorizada')
                                        <div class="btn btn-success exportPdf" data-url="{{ $investigation['poliza'] }}">Descargar</div>
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