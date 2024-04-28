<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Panel</div>
                <a class="{{ Request::is('panel') ? 'active' : '' }} nav-link" href="{{ route('panel') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Home
                </a>
                @php
                $isActive = Request::is('panel/pt') || Request::is('panel/tim') || Request::is('panel/provinsi') || Request::is('panel/kota') || Request::is('panel/barang');
                @endphp
                <a class="{{ $isActive ? 'active' : '' }} nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Master
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="{{ Request::is('panel/barang') ? 'active' : '' }} nav-link" href="{{ route('barang') }}">Barang</a>
                        <a class="{{ Request::is('panel/kota') ? 'active' : '' }} nav-link" href="{{ route('kota') }}">Kota</a>
                        <a class="{{ Request::is('panel/provinsi') ? 'active' : '' }} nav-link" href="{{ route('provinsi') }}">Provinsi</a>
                        <a class="{{ Request::is('panel/tim') ? 'active' : '' }} nav-link" href="{{ route('tim') }}">TIM</a>
                        <a class="{{ Request::is('panel/pt') ? 'active' : '' }} nav-link" href="{{ route('pt') }}">PT</a>
                    </nav>
                </div>
                <a class="{{ Request::is('panel/timsetup') ? 'active' : '' }} nav-link" href="{{ route('timsetup') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Setup Tim
                </a>
                <a class="{{ Request::is('panel/user') ? 'active' : '' }} nav-link" href="{{ route('user') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    User
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            @auth
            <img src="{{ asset('storage/' . auth()->user()->image) }}" class="img-fluid rounded-circle" style="object-fit: cover; width: 25px; height: 25px;" alt="Profile Picture">
            {{ auth()->User()->name }}
            @else
            Guest
            @endauth
        </div>
    </nav>
</div>