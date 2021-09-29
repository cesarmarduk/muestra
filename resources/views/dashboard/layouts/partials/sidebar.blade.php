<div class="sidemenu-area">
    <div class="sidemenu-header">
        <a href="" class="navbar-brand d-flex align-items-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="image">
            {{-- <span></span> --}}
        </a>

        <div class="burger-menu d-none d-lg-block">
            <span class="top-bar"></span>
            <span class="middle-bar"></span>
            <span class="bottom-bar"></span>
        </div>

        <div class="responsive-burger-menu d-block d-lg-none">
            <span class="top-bar"></span>
            <span class="middle-bar"></span>
            <span class="bottom-bar"></span>
        </div>
    </div>

    <div class="sidemenu-body">
        <ul class="sidemenu-nav metisMenu h-100" id="sidemenu-nav" data-simplebar>
            @can('manage.settings')
            <li class="nav-item @if (Request::segment(2) === 'escritorio'&&Request::segment(3) === NULL) mm-active @endif">
                <a href="{{ route('dashboard.home') }}" class=" nav-link" aria-expanded="false">
                    <span class="icon"><i class='bx bx-home-circle'></i></span>
                    <span class="menu-title">Dashboard</span>
                    {{-- <span class="badge">2</span> --}}
                </a>
            </li>
            @endcan

            <li class="nav-item">
                <a href="#" class="collapsed-nav-link nav-link" aria-expanded="false">
                    <span class="icon"><i class='bx bx-cabinet'></i></span>
                    <span class="menu-title">Mis Contratos </span>
                </a>

                <ul class="sidemenu-nav-second-level">
                    <li class="nav-item @if (Request::segment(3) === 'contrato-extincion') mm-active @endif">
                        <a href="{{ route('dashboard.management.extintions.index') }}" class="nav-link">
                            <span class="icon"><i class='bx bx-notepad'></i></span>
                            <span class="menu-title">Con Extinción</span>
                        </a>
                    </li>

                    <li class="nav-item @if (Request::segment(3) === 'polizas') mm-active @endif" >
                        <a href="{{ route('dashboard.management.policies.index') }}" class="nav-link">
                            <span class="icon"><i class='bx bx-notepad'></i></span>
                            <span class="menu-title">Pólizas</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item @if (Request::segment(3) === 'investigaciones') mm-active @endif" >
                        <a href="{{ route('dashboard.management.investigations.index') }}" class="nav-link">
                            <span class="icon"><i class='bx bx-notepad'></i></span>
                            <span class="menu-title">Investigación Arrendatario</span>
                        </a>
                    </li> --}}
                    <li class="nav-item @if (Request::segment(3) === 'firmas') mm-active @endif" >
                        <a href="{{ route('dashboard.management.signs.index') }}" class="nav-link">
                            <span class="icon"><i class='bx bx-notepad'></i></span>
                            <span class="menu-title">Firmas Electrónicas</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>