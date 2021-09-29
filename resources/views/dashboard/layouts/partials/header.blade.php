<div class="main-header main-header-fixed">
    <div class="container-fluid">
        <div class="main-header-left">
            <a href="#" data-toggle="sidebar" class="nav-link toggle-border waves-effect waves-light"><i class="material-icons">dehaze</i></a>
        </div><!-- Sidebar toggle closed -->
        <div class="main-header-center">
            <div class="header-breadcrumb">
                <h5 class="mb-1">Dashboard</h5>
                <div class="main-content-breadcrumb"> <span>Dashboard</span> / <span>Escritorio</span> </div>
            </div>
            <div class="responsive-logo"><a href="{{ route('dashboard.home') }}"><img src="{{ asset('assets/images/logo/logo-white.png') }}" class="mobile-logo" alt="logo"></a></div>
        </div><!-- breadcrumb closed -->
        <div class="main-header-right">
            <div class="dropdown main-profile-menu nav nav-item nav-link">
                @if (Auth::user()->file_id === NULL)
                    <a href="javascript:void(0)" class="profile-user waves-effect waves-light"><img src="{{ asset('assets/images/user.png') }}"></a>
                @else
                    <a href="javascript:void(0)" class="profile-user waves-effect waves-light"><img src="{{ asset('assets/images/user.png') }}"></a>
                @endif
                <div class="dropdown-menu animated fadeInUp">
                    <div class="main-header-profile header-img bg-primary text-center text-capitalize">
                        <h6>{{ Auth::user()->fullname }}</h6>
                    </div>
                    <a class="dropdown-item waves-effect waves-light" href="{{ route('dashboard.settings.profile.index') }}"><i class="material-icons">person</i> Mi Perfil</a>
                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons">power_settings_new</i> Salir</a>
                    <form id="logout-form" action="{{ route('logout-post') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div><!-- Main-profile-menu closed -->
            <button class="navbar-toggler navresponsive-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon bx bx-dots-vertical-rounded"></span>
            </button><!-- Navresponsive closed -->
        </div>
    </div>
</div>
<!-- Main-header closed -->

<!-- Mobile-header -->
<div class="responsive main-header">
    <div class="mb-1 navbar navbar-expand-lg nav nav-item navbar-nav-right responsive-navbar">
        <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    @if (Auth::user()->avatar === NULL)
                        <a href="javascript:void(0)" class="profile-user waves-effect waves-light"><img src="{{ asset('assets/images/user.png') }}"></a>
                    @else
                        <a href="javascript:void(0)" class="profile-user waves-effect waves-light"><img src="{{ asset('assets/images/user.png') }}"></a>
                    @endif
                    <div class="dropdown-menu animated fadeInUp">
                        <div class="main-header-profile header-img bg-primary text-center text-capitalize">
                            <h6>{{ Auth::user()->first_name }}<br>{{ Auth::user()->last_name }}</h6>
                        </div>
                        <a class="dropdown-item waves-effect waves-light" href="{{ route('dashboard.settings.profile.index') }}"><i class="material-icons">person</i> Mi Perfil</a>
                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form-responsive').submit();"><i class="material-icons">power_settings_new</i> Salir</a>
                        <form id="logout-form-responsive" action="{{ route('logout-post') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div><!-- Main-profile-menu closed -->
            </div>
        </div>
    </div>
</div>
<!-- Mobile-header closed -->