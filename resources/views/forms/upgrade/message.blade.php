@extends('layouts.form')

@section('title')
Póliza Upgrade
@endsection

@section('plugins')
<script type="text/javascript" src="{{ asset('assets/js/forms/ponyfill.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/slider.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/animation.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/gallery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/jquery.easing.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/forms/main.js') }}"></script>
@endsection

@section('content')
@include('layouts.partials-forms.slider')

<section id="contact" class="section-1 form">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-7 align-self-start">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="alert alert-{{ $color }}" rol="alert">
                            {!! $message !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-images col-sm-12 col-md-12 col-lg-5">
                <div class="gallery">
                    <div class="mask-radius"></div>
                    <img src="{{ asset('assets/images/about-2.jpg') }}" class="fit-image" alt="Fit Image">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection