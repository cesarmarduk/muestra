@extends('dashboard.layouts.appProgress')

@section('title')
Mis contratos - Firmas Electrónicas
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
        <li class="item">Firmas Electrónicas</li>
    </ol>
</div>
<!-- End Breadcrumb Area -->

<!-- Start -->
<div class="card mb-30">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Firmas Electrónicas</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-md-nowrap" id="table">
                        <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0" >ID</th>
                                <th class="wd-10p border-bottom-0">Tipo documento</th>
                                <th class="wd-10p text-center border-bottom-0">Firmantes</th>
                                <th class="wd-10p text-center border-bottom-0">Fecha Solicitud</th>
                   
                                <th class="wd-10p text-center border-bottom-0">Estatus</th>
                                <th class="wd-10p text-center border-bottom-0">Descargar</th>
                                <th class="wd-10p text-center border-bottom-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($signs as $sign)
                                <tr>
                                    <td class="text-transform-initial">{{ $sign['id'] }}</td>
                                    <td class="text-transform-initial">{{ $sign['type'] }}</td>
                                 
                                    <td class="text-right text-transform-initial">{{ $sign['contrat_signers']->where('status','=','Firmado')->count() }} / {{ $sign['contrat_signers']->count() }}</td>
                                    <td class="text-center text-transform-initial">
                                        {{ $sign['updated_at']->format('j F, Y') }}
                                        
                                     
                                    </td>
                                  
                                    <td class="text-center text-transform-initial">
                                        @php
                                           
                                            $color = 'default';
                                            if ($sign['sign_status'] === 'Sin Firmar'): 
                                                $color = 'default';
                                            elseif ($sign['sign_status'] === 'En Proceso'): 
                                                $color = 'info';
                                            elseif ($sign['sign_status'] === 'Problema con Firma'): 
                                                $color = 'warning';
                                            elseif ($sign['sign_status'] === 'Revisar Datos'): 
                                                $color = 'warning';
                                            elseif ($sign['sign_status'] === 'No Firmada'): 
                                                $color = 'danger';
                                            elseif ($sign['sign_status'] === 'Firmada'): 
                                                $color = 'success';
                                            endif;
                                        @endphp
                                        <span class="badge badge-{{ $color }}">{{ strtoupper($sign['sign_status']) }}</span>
                                    </td>
                                    <td class="text-center text-transform-initial">
                                    
                                        <div class="btn btn-success exportPdf" data-url="{{ $sign['poliza'] }}">Descargar</div>
                                      
                                    </td>
                                  
                                    <td class="text-center text-transform-initial">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Acciones
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item openModalSign" data-id="{{ $sign['id'] }}" data-template="<h5>Obteniendo Informacion... <i class='fas fa-circle-notch fa-spin'></i><h5>" data-toggle="modal" data-target="#modal" href="javascript:void(0)"> <i class="fa fa-eye"></i> Ver Firma Electronica</a>
                                            </div>
                                        </div>
                                    
                                      
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

 <input type="hidden" id="weesignToken">
 <input type="hidden" id="documentID">
@endsection

@include('dashboard.settings.emails.partials.templateModal')

@section('js')
<script type="text/javascript">

   

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

    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $("#search").keyup(() => getAll(1));

        $("#pagination").change(() => page()); 

        $(document).on('click', '.openModalSign', e => {
           
            $('.modal-title').html('<h4>Detalles de la firma del documento</h4>');
            $('#html').addClass('text-center').html($(e.currentTarget).attr('data-template'));
            getContratSignDetails($(e.currentTarget).attr('data-id'));
           
        });

        let getContratSignDetails = (id) => {
            $.ajax({
                url: "{{ route('dashboard.management.signs.details') }}",
                data: {
                    contrat : id,
                },
                type: "POST",
                dataType: "JSON",
                statusCode: {
                    200: function(res) {
                        proccessContratDetails(res);
                    }
                }
            });
        }

        let proccessContratDetails = (res) => {
            let signers=``;
            let stringBtnStart=`Iniciar Proceso`;
            let titleBtnStart=`Iniciar Proceso`;
            let colorBtnStart=`success`;
            let classBtnStart=`startSignProcess`;
            sessionStorage.setItem('contratFileOriginal', JSON.stringify(res.file));
            let actionBtns=``;
            let signatory = [];
          
            if(res.contrat_signers.length==0)
                signers=`Sin Firmantes`;
            res.contrat_signers.forEach((contrat_signer, indice)  => {
                let signer=contrat_signer.signer;
              
                if(res.sign_status=='En Proceso'){ //res.sign_status==En Proceso')
                    actionBtns=`
                 
                        <div class="col-md-8 text-left">
                        
                            <a data-toggle="tooltip" data-placement="top" title="Aprobar Firmas" class="btn btn-success color-white font-bold"><i class="fa fa-check-square-o color-white"></i> Validar</a>
                           
                            <a data-toggle="tooltip" data-placement="top" title="Enviar Contrato Por Email" class="btn btn-info color-white font-bold sharedCompleteDocument"><i class="fa fa-envelope-o color-white"></i> Enviar </a>
                            <a data-toggle="tooltip" data-placement="top" title="Descargar Contrato Firmado" class="btn btn-primary color-white font-bold"><i class="fas fa-file-contract color-white"></i> Descargar</a> 
                            <a data-toggle="tooltip" data-placement="top" title="Elimina el documento y cancela el proceso" class="deleteDocument btn btn-danger color-white font-bold"><i class="fas fa-file-signature color-white"></i> Eliminar</a>
                            <hr>
                        </div>
                    `;
                }else if(res.sign_status=='Sin Firmar'){
                    actionBtns=`
                  
                        <div class="col-md-8 text-center">
                           Debe Iniciar el proceso de la firma para ver más opciones
                        </div>
                   `;
                }
                if(res.sign_status!='Sin Firmar'){
                    classBtnStart  = `restartSignProcess`;
                    titleBtnStart  = `Reiniciar Proceso`;
                    stringBtnStart = `Reiniciar Proceso`;
                    colorBtnStart  = `danger`;
                }
                let hr=`<hr>`;
                if(indice==res.contrat_signers.length-1){
                    hr=``;
                }
                let add=`
                    <div class="row p-1">
                        <div class="col-md-6">
                            <b>Tipo:</b> ${contrat_signer.type} ${signer.type}
                        </div>
                        <div class="col-md-6">
                            <b>Status de Firma:</b> ${contrat_signer.status} 
                        </div>
                        <div class="col-md-6">
                            <b>Nombre:</b> ${signer.name} 
                        </div>
                      
                        <div class="col-md-6">
                            <b>Email:</b> ${signer.email||signer.email_comercia} 
                        </div>
                    
                        <div class="col-md-12">
                            <b>Telefono:</b> ${signer.phone} 
                        </div>  
                    </div>
                    ${hr}
                `;
                signers=signers+add;
                signatory.push({
                    'emailID': signer.email||signer.email_comercia,
                    'name': signer.name
                });
            });

            sessionStorage.setItem('signatory', JSON.stringify(signatory));
            let html=`
          
                <div class="row text-center">
                   
                    ${actionBtns}
                    <div class="col-md-4 statusBox p-2 text-left"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Contrato</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <a data-id="${res.id}" class="btn btn-${colorBtnStart} color-white font-bold ${classBtnStart}" data-toggle="tooltip" data-placement="top" title="${titleBtnStart}"><i class="fas fa-signature color-white signatureBtnIcon"></i> ${stringBtnStart}</a>
                    </div>
                </div>
                
                <div class="row p-1">
                    <div class="col-md-6">
                        <b>Tipo:</b> ${res.type} 
                    </div>
                    <div class="col-md-4">
                        <b>Status General:</b> ${res.sign_status} 
                    </div>
                
                    <div class="col-md-6">
                        <b>Deposito:</b> ${res.deposit} 
                    </div><br>
                    <div class="col-md-6">
                        <b>Renta Mensual:</b> ${res.rent_monthly} 
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Inmueble</h4>
                    </div>
                </div>
               
                <div class="row p-1">
                    <div class="col-md-6">
                        <b>Direccion:</b> ${res.property.address.address} 
                    </div>
                    <div class="col-md-6">
                        <b>Uso:</b> ${res.use} 
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                    <h4>Firmantes</h4>
                    </div>
                
                </div>
             
                ${signers}

             
               
            `;
            $('#html').removeClass('text-center').addClass('text-left').html(html);
            $('[data-toggle="tooltip"]').tooltip();
            
        }

        



        $(document).on('click', '.startSignProcess', e => {
            let contrat = $(e.currentTarget).attr('data-id');

            swal({
                title: "Se iniciara el proceso de Firmas!",
                html: `Una vez comenzado el proceso de firmas se enviara por email una invitacion a los firmantes y posteriormente podra autorizar el documento firmado!`,
                type: "warning",
                buttons: ["Si, Iniciar Proceso", "Cancelar"],
                dangerMode: true,
                showCancelButton: true
            })
            .then((willDelete) => {
                if (willDelete.value) {
                    $(`.signatureBtnIcon`).removeClass('fa-signature').addClass('fa-sync').addClass('fa-spin');
                    startSignProcess(contrat,"start");
                   
                }
            });
           
       });


       $(document).on('click', '.restartSignProcess', e => {
            let contrat = $(e.currentTarget).attr('data-id');
            swal({
                title: "Se reiniciara el proceso de Firmas!",
                html: `Esto eliminara el documento generado anteriormente y sus firmas asociadas y reenviara un nuevo ocumento a los firmantes, luego podra autorizar el documento firmado!`,
                type: "warning",
                buttons: ["Si, Reniciar Proceso", "Cancelar"],
                dangerMode: true,
                showCancelButton: true
            })
            .then((willDelete) => {
                if (willDelete.value) {
                    $(`.signatureBtnIcon`).removeClass('fa-signature').addClass('fa-sync').addClass('fa-spin');
                    startSignProcess(contrat,"restart");
                    /*
                    swal({
                        title: "Reiniciar!",
                        type: "success",
                    })*/
                   
                }
            });
           
          
       });

       let startSignProcess = (id,type="start") => {
            let msg=`<h5>Obteniendo Credenciales...<i class="fas fa-circle-notch fa-spin"></i></h5>`;
           
            if(type=="start"){

                getAccessToken();
            }else{
                msg=`<h5 style="color:red">Solicitando...<i style="color:black !important" class="fas fa-circle-notch fa-spin"></i></h5>`;
                restartProcess(id);

            }
            $(`.statusBox`).html(msg);
      
        }

        async function restartProcess(id){
            $.ajax({
                url: "{{ route('dashboard.management.signs.restartProcess') }}",
                type: "POST",
                data: { id: id },
                dataType: "JSON",
                statusCode: {
                    200: function(res) {
                     
                        if(res.continue){
                          
                            getAccessToken(true);
                        }
                        
                        console.log(res);
                        //proccessContratDetails(res);
                    },
                    400: function(res) {
                        //Error en credenciales 
                        console.log(res);
                        //proccessContratDetails(res);
                    }
                }
            });
        }

     
        async function getAccessToken(deleteD=false){
            let msg=`<h5  style="color:red">Obteniendo Credenciales...<i style="color:black !important" class="fas fa-circle-notch fa-spin"></i></h5>`;
            $(`.statusBox`).html(msg);
            let documentID = $(`#documentID`).val();
            $.ajax({
                url: "https://legalglobalconsulting.com:3000/api/getAccessToken",
                type: "GET",
                dataType: "JSON",
                statusCode: {
                    200: function(res) {
                        $(`.signatureBtnIcon`).removeClass('fa-spin').removeClass('fa-sync').addClass('fa-signature');
                        if(res){
                            let message=res.message;
                            let responseCode=res.responseCode;
                            let success=res.success;
                            if(success){
                                let weesignToken=res.responseData.accessToken;
                                $(`#weesignToken`).val(weesignToken);
                                if(deleteD&&documentID.trim()!=''){
                                    deleteDocument(true);
                                }else{
                                    addDocument();
                                }
                            
                            }
                        }
                        
                        console.log(res);
                        //proccessContratDetails(res);
                    },
                    400: function(res) {
                        //Error en credenciales 
                        console.log(res);
                        //proccessContratDetails(res);
                    }
                }
            });
        }

        $(document).on('click', '.addDocument', e => {
        
            addDocument();
           
        });
       
        async function addDocument(){
            let msg=`<h5  style="color:red">Agregando Documento...<i style="color:black !important" class="fas fa-circle-notch fa-spin"></i></h5>`;
            $(`.statusBox`).html(msg);
            let token = $(`#weesignToken`).val();
            let file = sessionStorage.getItem('contratFileOriginal');
            $.ajax({
                url: "https://legalglobalconsulting.com:3000/api/addDocument",
                type: "POST",
                dataType: "JSON",
                data : { token:token, file:file },
                statusCode: {
                    200: function(res) {
                        let success=res.success;
                        if(success){
                            let documentID=res.responseData.documentID;
                            $(`#documentID`).val(documentID);
                            addSignatureToDocument();
                        }
                        console.log(res);
                        //proccessContratDetails(res);
                    },
                    400: function(res) {
                        //Error en credenciales 
                        console.log(res);
                        //proccessContratDetails(res);
                    }
                }
            });
        }

        /*
        $(document).on('click', '.addSignatureToDocument', e => {
            let email = $(e.currentTarget).attr('data-email');
            let name = $(e.currentTarget).attr('data-name');
            addSignatureToDocument(email,name);
           
        });*/
        async function addSignatureToDocument(){
            let msg=`<h5  style="color:red">Agregando Firmantes...<i style="color:black !important" class="fas fa-circle-notch fa-spin"></i></h5>`;
            $(`.statusBox`).html(msg);
            let token = $(`#weesignToken`).val();
            let documentID = $(`#documentID`).val();
            let signatory = sessionStorage.getItem('signatory');
            $.ajax({
                url: "https://legalglobalconsulting.com:3000/api/addSignatureToDocument",
                type: "POST",
                dataType: "JSON",
                data : { token:token, documentID:documentID, signatory:signatory  },
                statusCode: {
                    200: function(res) {
                        let success=res.success;
                        if(success){
                            let msg=`<h5  style="color:green">Completado <i style="color:black !important" class="fas fa-check"></i></h5>`;
                            $(`.statusBox`).html(msg);
                            swal({
                                title: 'Firmas enviadas',
                                html: `El documento ha sido enviado con exito para su firma a los involucrados en el contrato`,
                                type: 'success',
                                allowOutsideClick: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar',
                                showCancelButton: false
                            });
                        }
                        //proccessContratDetails(res);
                    },
                    400: function(res) {
                        //Error en credenciales 
                        console.log(res);
                        //proccessContratDetails(res); "6065174d097fa90031816fe7"
                    }
                }
            });
        }
        $(document).on('click', '.deleteDocument', e => {
          
            deleteDocument();
           
        });
        async function deleteDocument(deleteD=false){
            let msg=`<h5  style="color:red">Eliminando...<i style="color:black !important" class="fas fa-circle-notch fa-spin"></i></h5>`;
            $(`.statusBox`).html(msg);
            let token = $(`#weesignToken`).val();
            let documentID = $(`#documentID`).val();
            $.ajax({
                url: "https://legalglobalconsulting.com:3000/api/deleteDocument",
                type: "POST",
                dataType: "JSON",
                data : { token:token, documentID:documentID },
                statusCode: {
                    200: function(res) {
                        let success=res.success;
                        if(success){
                            if(deleteD){
                                addDocument();
                            }
                          
                        }
                        console.log(res);
                        //proccessContratDetails(res);
                    },
                    400: function(res) {
                        //Error en credenciales 
                        console.log(res);
                        //proccessContratDetails(res);
                    }
                }
            });
        }
        $(document).on('click', '.getAllUserDocuments', e => {
            
            getAllUserDocuments();
           
        });
        async function getAllUserDocuments(){
            let token = $(`#weesignToken`).val();
            $.ajax({
                url: "https://legalglobalconsulting.com:3000/api/getAllUserDocuments",
                type: "POST",
                dataType: "JSON",
                data : { token:token },
                statusCode: {
                    200: function(res) {
                        let success=res.success;
                        if(success){
                            let documentID=res.responseData.documentID;
                            $(`#documentID`).val(documentID);
                        }
                        console.log(res);
                        //proccessContratDetails(res);
                    },
                    400: function(res) {
                        //Error en credenciales 
                        console.log(res);
                        //proccessContratDetails(res);
                    }
                }
            });
        }
        
        $(document).on('click', '.sharedCompleteDocument', e => {
         
            sharedCompleteDocument();
           
        });
        async function sharedCompleteDocument(){
            let token = $(`#weesignToken`).val();
            let documentID = $(`#documentID`).val();
            let shared_email = $(`#shared_email`).val();
            $.ajax({
                url: "https://legalglobalconsulting.com:3000/api/sharedCompleteDocument",
                type: "POST",
                dataType: "JSON",
                data : { token:token, documentID:documentID, shared_email:shared_email },
                statusCode: {
                    200: function(res) {
                        let success=res.success;
                        if(success){
                            let documentID=res.responseData.documentID;
                            $(`#documentID`).val(documentID);
                        }
                        console.log(res);
                        //proccessContratDetails(res);
                    },
                    400: function(res) {
                        //Error en credenciales 
                        console.log(res);
                        //proccessContratDetails(res);
                    }
                }
            });
        }

        
                            
                            
                            
                            

    });
</script>
@endsection