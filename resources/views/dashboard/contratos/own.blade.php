@extends('dashboard.layouts.app')

@section('title')
Mis Contratos
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}">
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
@endsection

@section('content')
<div class="breadcrumb-area">
    <h1>Contratos</h1>

    <ol class="breadcrumb">
        <li class="item"><a href="dashboard-analytics.html"><i class='bx bx-home-alt'></i></a></li>

        <li class="item">Contratos</li>

        <li class="item">Mis Contratos</li>
    </ol>
</div>
<!-- End Breadcrumb Area -->

<!-- Start -->
<div class="card mb-30">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Mis Contratos</h3>

        {{-- <div class="dropdown">
            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class='bx bx-dots-horizontal-rounded' ></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <i class='bx bx-show'></i> View
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <i class='bx bx-edit-alt'></i> Edit
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <i class='bx bx-trash'></i> Delete
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <i class='bx bx-printer'></i> Print
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <i class='bx bx-download'></i> Download
                </a>
            </div>
        </div> --}}
    </div>

    <div class="card-body">
        <table id="table" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Arrendador</th>
                    <th scope="col" class="text-center"> Arrendatario</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr> --}}
            </tbody>
        </table>
    </div>
</div>

<div class="flex-grow-1"></div>
@endsection

@section('js')
<script type="text/javascript">
    $(function() {
        $('#table').DataTable({
            language: {
                searchPlaceholder: 'Buscar...',
                sSearch: '',
                lengthMenu: '_MENU_'
            },
            processing: true,
            serverSide: true,
            ajax: "{{route('dashboard.solicitud.getOwnContratos')}}",
            type : 'post',
            columns: [
                { data: 'id', className: "text-center" },
                { data: 'nombre_arrendador', className: "text-center" },
                { data: 'nombre_arrendatario', className: "text-center" },
                { data: 'status', className: "text-center" },
                { data: 'acciones', className: "text-center" },
            ]
        });
    });
</script>
@endsection