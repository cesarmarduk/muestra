@extends('dashboard.layouts.appProgress')

@section('title')
Perfil
@endsection

@section('content')
<div class="breadcrumb-area">
    <h1>Dashboard</h1>

    <ol class="breadcrumb">
        <li class="item"><a href="dashboard-analytics.html"><i class='bx bx-home-alt'></i></a></li>

        <li class="item">Dashboard</li>

        <li class="item">Perfil</li>
    </ol>
</div>
<!-- End Breadcrumb Area -->

<!-- Start -->
<div class="card mb-30">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Perfil</h3>
        {{-- <button type='button' class='pinchado' onclick="pinchado()">Pincha</button>  --}}
       
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12 text-center mb-4 ">
                @php
                if(Auth::user()->url){
                    $photo=Auth::user()->url;
                }else{
                    $photo=asset('assets/img/user1.jpg');
                }

                @endphp
                <img width="250" class="rounded-circle" src="{{ $photo  }}" alt="">
            </div><br>
            <div class="col-md-12 mt-4">
                <label class="font-bold" for="">Nombre: </label> {{ Auth::user()->fullname }}
            </div>
            <div class="col-md-12">
                <label class="font-bold" for="">Email: </label> {{ Auth::user()->email }}
            </div>
            <div class="col-md-12">
                <label class="font-bold" for="">Telefono: </label> {{ Auth::user()->phone ?? '----' }}
            </div>
            <div class="col-md-12">
                <label class="font-bold" for="">Status: </label> {{ Auth::user()->verified }}
            </div>

            {{-- <div class="col-md-12">
                <a class="btn btn-danger" href="{{route('dashboard.editProfile')}}">Editar <i class="bx bx-edit"></i>  </a>
            </div> --}}
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
    
  
</script>
@endsection