@extends('layouts.loginLay')

@section('title')
Registrate en nuestro sistema
@endsection


@section('content')

  <!-- Start Register Area -->
  <div class="register-area">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="register-form">
                <div class="logo">
                    <a href="dashboard-analytics.html"><img src="{{ asset('assets/img/logo.png') }}" alt="image"></a>
                </div>

                <h2>Registrar</h2>
                @include('dashboard.layouts.partials.errors')
                <form method="POST" action="{{ route('register.store') }}">
                    <div class="form-group">
                        <input type="text" id="fullname" class="form-control" name="fullname" value="{{ old('fullname') }}" placeholder="Nombre Completo">
                        <span class="label-title"><i class='bx bx-user'></i></span>
                    </div>

                    <div class="form-group">
                        <input type="text" id="email"  class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                        <span class="label-title"><i class='bx bx-envelope'></i></span>
                    </div>

                    <div class="form-group">
                        <input type="password" id="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password">
                        <span class="label-title"><i class='bx bx-lock'></i></span>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password_confirmation" class="form-control form-control-lg" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Ingrese confirmación de contraseña">
                        <span class="label-title"><i class='bx bx-lock'></i></span>
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="register-btn">Registrarse</button>

                    <p class="mb-0">Ya tienes una cuenta? <a href="{{ route('login') }}">Ingresar</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Register Area -->


@endsection

@section('js')
<script type="text/javascript">
    $(function () {
        $('.select2').select2();
    });
</script>
@endsection