@extends('layouts.loginLay')

@section('title')
Login
@endsection

@section('content')
<div class="login-area">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="login-form">
                <div class="logo">
                    <a href="{{ route('login') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="image"></a>
                </div>

                <h2>Bienvenido</h2>
                @include('dashboard.layouts.partials.errors')
                <form method="POST" action="{{ route('login') }}">
                    <div class="form-group">
                        <input type="text" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                        <span class="label-title"><i class="material-icons">person</i></span>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" value="{{ old('password') }}">
                        <span class="label-title"><i class="material-icons">lock</i></span>
                    </div>

                    <div class="form-group">
                        <div class="remember-forgot">
                            {{-- <label class="checkbox-box">Remember me
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label> --}}

                            <a href="forgot-password.html" class="forgot-password">Olvido Contraseña?</a>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="login-btn">Ingresar</button>
                    @if (Route::has('register'))
                    <p class="mb-0">No tienes cuenta? <a href="{{ route('register') }}">Registrarse</a></p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
