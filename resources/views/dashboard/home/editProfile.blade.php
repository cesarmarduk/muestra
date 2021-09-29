@extends('dashboard.layouts.appProgress')

@section('title')
Editar Perfil
@endsection


@section('plugins')
<script type="text/javascript" src="{{ asset('assets/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
<script src="https://kit.fontawesome.com/43d2ce84b8.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="breadcrumb-area">
    <h1>Dashboard</h1>

    <ol class="breadcrumb">
        <li class="item"><a href="dashboard-analytics.html"><i class='bx bx-home-alt'></i></a></li>

        <li class="item">Dashboard</li>

        <li class="item">Editar Perfil</li>
    </ol>
</div>
<!-- End Breadcrumb Area -->

<!-- Start -->
<div class="card mb-30">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Editar Perfil</h3>
        {{-- <button type='button' class='pinchado' onclick="pinchado()">Pincha</button>  --}}
       
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12 text-center mb-4">
                @php
                if(Auth::user()->url){
                    $photo=Auth::user()->url;
                }else{
                    $photo=asset('assets/img/user1.jpg');
                }
                @endphp
                <div class="avatar-icon-wrapper mb-4 d-flex justify-content-center">
                    <div class="avatar-icon">
                        <img width="250" class="rounded-circle" src="{{ $photo  }}" alt="Photo"> <br>
                        <input type="file" id="photo" class="file-hidden"/>
<!--                            <i class="lnr-circle-minus"></i>-->
                    </div>
                </div>
               
            </div><br>

         


            <div class="col-md-6 mt-2 mb-2">
                <label class="font-bold" for="">Nombre: </label>
                <input type="text" class="form-control" id="nombre" value="{{ Auth::user()->fullname }}">
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <label class="font-bold" for="">Email: </label>
                <input type="text" class="form-control" id="email" value="{{ Auth::user()->email }}">
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <label class="font-bold" for="">Telefono: </label>
                <input type="text" class="form-control" id="telefono" value="{{ Auth::user()->phone }}">
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <label class="font-bold" for="">Password: </label>
                <input type="password" class="form-control" id="password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" >
            </div>

            <div class="col-md-12 mt-2 text-right">
                <a class="btn btn-danger storeProfile font-bold" style="color:white" >Guardar <i class="bx bx-save"></i>  </a>
            </div>
        </div>
     
    </div>
</div>
{{-- 
<div class="card mb-30">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Background Colors</h3>

   
    </div>

    <div class="card-body">
        <div class="p-3 mb-2 bg-primary text-white">.bg-primary</div>
        <div class="p-3 mb-2 bg-secondary text-white">.bg-secondary</div>
        <div class="p-3 mb-2 bg-success text-white">.bg-success</div>
        <div class="p-3 mb-2 bg-danger text-white">.bg-danger</div>
        <div class="p-3 mb-2 bg-warning text-dark">.bg-warning</div>
        <div class="p-3 mb-2 bg-info text-white">.bg-info</div>
        <div class="p-3 mb-2 bg-light text-dark">.bg-light</div>
        <div class="p-3 mb-2 bg-dark text-white">.bg-dark</div>
        <div class="p-3 mb-2 bg-white text-dark">.bg-white</div>

    </div>
</div>
<!-- End -->

 --}}
 <div class="flex-grow-1"></div>
@endsection

@section('js')

<script>
    $(`body`).on('click','.storeProfile',()=>{
        let nombre = $(`#nombre`).val();
        let email = $(`#email`).val();
        let telefono = $(`#telefono`).val();
        let password = $(`#password`).val();
        var photo=$("#photo").prop("files")[0];

        var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if(!email.match(mailformat))
        {	
            swal({
                title: `Email erroneo`,
                html: `Agregue una direccion de email valida`,
                type: 'error',
                allowOutsideClick: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
                showCancelButton: false
            });
            return false;
        }

        var form_data=new FormData();
        form_data.append("photo",photo);
        form_data.append("nombre",nombre);
        form_data.append("email",email);
        form_data.append("telefono",telefono);
        form_data.append("password",password);
        
        $.ajax({
            url: "{{ route('dashboard.updateProfile') }}",
            data: form_data,
            cache:false,
            contentType:false,
            processData:false,
            data:form_data,
            dataType: "JSON",
            type: "POST",
            statusCode: {
                200: function (res) {
                    let type="success";
                    if(res.error){
                        type="error";
                    }
                    swal({
                        title: res.message,
                        html: res.message,
                        type: type,
                        allowOutsideClick: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        showCancelButton: false
                    });
                    setTimeout(()=>{
                        location.reload();

                    },1500);
                }
            },
        });

    });
  
</script>
@endsection