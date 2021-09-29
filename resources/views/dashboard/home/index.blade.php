@extends('dashboard.layouts.appProgress')

@section('title')
Escritorio
@endsection

@section('content')
<div class="breadcrumb-area">
    <h1>Dashboard</h1>

    <ol class="breadcrumb">
        <li class="item"><a href="dashboard-analytics.html"><i class='bx bx-home-alt'></i></a></li>

        <li class="item">Dashboard</li>

        <li class="item">Colorss</li>
    </ol>
</div>
<!-- End Breadcrumb Area -->

<!-- Start -->
<div class="card mb-30">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Dashboard</h3>
        {{-- <button type='button' class='pinchado' onclick="pinchado()">Pincha</button>  --}}
        <div class="dropdown">
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
        </div>
    </div>

    <div class="card-body">
     
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