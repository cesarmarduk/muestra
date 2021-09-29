@extends('dashboard.layouts.app')

@section('title')
Listado - Roles
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-pagination/css/jquery-pagination.css') }}">
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-pagination/js/jquery-pagination.js') }}"></script>
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
                <div class="row">
                    @can('roles.create')
                    <div class="col-sm-12">
                        <div class="form-group">
                            <a class="btn btn-md btn-success waves-effect wave-dark" href="{{ route('dashboard.settings.role.create') }}"><i class="material-icons">add</i> Nuevo</a>
                        </div>
                    </div>
                    @endcan
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-centered table-bordered table-hover text-md-nowrap" id="table">
                                <thead>
                                    <tr>
                                        @can('roles.edit')
                                        <th class="wd-5p border-bottom-0"></th>
                                        <th class="wd-65p border-bottom-0">Roles</th>
                                        @else
                                        <th class="wd-85p border-bottom-0">Roles</th>
                                        @endcan
                                        @can('permissions.indexAjax')
                                        <th class="wd-15p border-bottom-0 text-center">Permisos</th>
                                        <th class="wd-15p border-bottom-0 text-center">Guard</th>
                                        @else
                                        <th class="wd-15p border-bottom-0 text-center">Guard</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            @can('roles.edit')
                                            <td class="text-center"><a class="btn-link" href="{{ route('dashboard.settings.role.edit', Crypt::encrypt($role->id)) }}"><i class="material-icons text-success">edit</i></a></td>
                                            @endcan
                                            <td class="text-transform-initial">{{ $role->name }}</td>
                                            @can('permissions.indexAjax')
                                            <td class="text-center"><button class="btn-link text-white permissionsLink" data-id="{{ Crypt::encrypt($role->id) }}" data-title="Listado de Permisos para el Rol {{ $role->name }}" data-toggle="modal" data-target="#modal" type="button">[ Ver Permisos ]</button></td>
                                            @endcan
                                            <td class="text-center text-transform-initial">{{ $role->guard_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('dashboard.settings.roles.partials.permissionsModal')

@section('js')
@include('dashboard.layouts.partials.datatable')
<script type="text/javascript">
    $(function() {
        $("#search").keyup(() => getAll(1));

        $("#pagination").change(() => page()); 
    });

    $(document).on('click', '.permissionsLink', e => {
        $("#rol").val('');
        $("#search").val('');
        $("#pagination").val(10);
		$('#permissionsTitle').html($(e.currentTarget).attr('data-title'));
        $("#rol").val($(e.currentTarget).attr('data-id'));
        getAll(1);
    });

    let getAll = (numberpag) => {
        $.ajax({
            url: "{{ route('dashboard.settings.permission.indexAjax') }}",
            data: {
                page        : numberpag,
                search      : $("#search").val(),
                pagination  : $("#pagination").val(),
                rol         : $('#rol').val()
            },
            type: "POST",
            dataType: "JSON",
            statusCode: {
                200: function(res) {
                    let rows = '';
                    
                    if (res.total === 0) {
                        rows = `<tr><td><div class="text-center">No hay registros</div></td></tr>`;
                    } else {
                        let pages;

                        res.data.forEach((val, index) => {
                            if (val !== null) {
                                rows += `<tr><td class="text-transform-initial">${val.name}</td></tr>`;
                            }
                        });

                        pages = Math.ceil(res.total / $("#pagination").val());

                        $('.pag').html(`<ul class="pagination" data-page="${numberpag}" data-pages="${pages}" data-link="false" data-keyNavigation="true" data-link="false" data-skin="default"></ul>`);
                        $('.pagination').pagination();

                        $("li.page").click(e => getAll($(e.currentTarget).attr('data-page')));
                    }

                    $("#tbodyGeneral").html(rows);
                }
            }
        });
    }

    let page = () => getAll($(".pagination li.current").attr('data-page'));
</script>
@endsection