<div class="sidebar" data-background-color="white">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="white">
            <a href="#" class="logo">
                <div class="input-group">
                    <img
                        src="{{ asset('img/logodsg.png') }}"
                        alt="navbar brand"
                        class="navbar-brand input-group-item"
                        height="27" />
                    <span class="input-label">
                        <h5>&nbsp; <b>Direct Selling</b></h5>
                    </span>
                </div>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ Request::is('main') ? 'active' : '' }}">
                    <a href="{{ route('main') }}">
                        <i class="fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>

                @if (in_array((auth()->user()->roles ?? ''), ['SUPERVISOR','SPV ADMIN','ADMIN 2','LOCK','CHECKER']))
                @php
                $isActivePenjualan = Request::is('main/penjualan') || Request::is('main/penjualanret') || Request::is('main/penjualanvalidasi') || Request::is('main/penjualanreturvalidasi') || Request::is('main/penjualanreport') || Request::is('main/returpenjualanreport');
                @endphp
                <li class="nav-item {{ $isActivePenjualan ? 'active' : '' }}">
                    <a
                        data-bs-toggle="collapse"
                        href="#penjualan"
                        class="collapsed"
                        aria-expanded="false">
                        <i class="fas fa-money-check-alt"></i>
                        <p>Penjualan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="penjualan">
                        <ul class="nav nav-collapse">
                            @if (in_array((auth()->user()->roles ?? ''), ['SUPERVISOR','SPV ADMIN','ADMIN 2']))
                            <li class="{{ Request::is('main/penjualan') ? 'active' : '' }}">
                                <a href="{{ route('penjualan') }}"><span class="sub-item">Entry Penjualan</span></a>
                            </li>
                            <li class="{{ Request::is('main/penjualanret') ? 'active' : '' }}">
                                <a href="{{ route('penjualanret') }}"><span class="sub-item">Entry Retur Penjualan</span></a>
                            </li>
                            @endif

                            @if (in_array((auth()->user()->roles ?? ''), ['SUPERVISOR','SPV ADMIN','LOCK']))
                            <li class="{{ Request::is('main/penjualanvalidasi') ? 'active' : '' }}">
                                <a href="{{ route('penjualanvalidasi') }}"><span class="sub-item">Validasi Penjualan</span></a>
                            </li>
                            <li class="{{ Request::is('main/penjualanreturvalidasi') ? 'active' : '' }}">
                                <a href="{{ route('penjualanreturvalidasi') }}"><span class="sub-item">Validasi Retur Penjualan</span></a>
                            </li>
                            @endif

                            @if (in_array((auth()->user()->roles ?? ''), ['SUPERVISOR','SPV ADMIN','ADMIN 2','LOCK']))
                            <li>
                                <hr style="color:black;">
                            </li>
                            @endif

                            @if (in_array((auth()->user()->roles ?? ''), ['SUPERVISOR','SPV ADMIN','ADMIN 2','LOCK','CHECKER']))
                            <li class="{{ Request::is('main/penjualanreport') ? 'active' : '' }}">
                                <a href="{{ route('penjualanreport') }}"><span class="sub-item">Laporan Penjualan</span></a>
                            </li>
                            @endif

                            @if (in_array((auth()->user()->roles ?? ''), ['SUPERVISOR','SPV ADMIN','ADMIN 2','CHECKER']))
                            <li class="{{ Request::is('main/returpenjualanreport') ? 'active' : '' }}">
                                <a href="{{ route('returpenjualanreport') }}"><span class="sub-item">Laporan Retur Penjualan</span></a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li> -->

                @if (in_array((auth()->user()->roles ?? ''), ['SUPERVISOR','PENAGIHAN','SPV ADMIN','ADMIN 2','CHECKER']))
                @php
                $isActivePenagihan = Request::is('main/penagihan/*') || Request::is('main/penagihanreport') || Request::is('main/penagihanreportnota') || Request::is('main/penagihanreporttim') || Request::is('main/penagihanreportperformaangsuran') || Request::is('main/penagihandraftspk') || Request::is('main/penagihanreschedule');
                @endphp
                <li class="nav-item {{ $isActivePenagihan ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#penagihan">
                        <i class="fas fa-layer-group"></i>
                        <p>Penagihan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="penagihan">
                        <ul class="nav nav-collapse">
                            @if (in_array((auth()->user()->roles ?? ''), ['SUPERVISOR','PENAGIHAN','SPV ADMIN','ADMIN 2']))
                            <li class="{{ Request::is('main/penagihan/*') ? 'active' : '' }}">
                                <a href="{{ route('penagihan',['id' => 0]) }}">
                                    <span class="sub-item">Entry Penagihan</span>
                                </a>
                            </li>
                            @endif

                            @if (in_array((auth()->user()->roles ?? ''), ['SUPERVISOR']))
                            <li class="{{ Request::is('main/penagihanreschedule') ? 'active' : '' }}">
                                <a href="{{ route('penagihanreschedule') }}">
                                    <span class="sub-item">Reschedule Angsuran</span>
                                </a>
                            </li>
                            @endif

                            <li>
                                <hr style="color:black;">
                            </li>

                            @if (in_array((auth()->user()->roles ?? ''), ['SUPERVISOR','PENAGIHAN','SPV ADMIN','ADMIN 2','CHECKER']))
                            <li class="{{ Request::is('main/penagihanreport') ? 'active' : '' }}">
                                <a href="{{ route('penagihanreport') }}">
                                    <span class="sub-item">Laporan Penagihan</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('main/penagihanreportnota') ? 'active' : '' }}">
                                <a href="{{ route('penagihanreportnota') }}">
                                    <span class="sub-item">Laporan Rekap Sisa Penagihan/Nota</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('main/penagihanreportperformaangsuran') ? 'active' : '' }}">
                                <a href="{{ route('penagihanreportperformaangsuran') }}">
                                    <span class="sub-item">Laporan Performa Angsuran</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('main/penagihanreporttim') ? 'active' : '' }}">
                                <a href="{{ route('penagihanreporttim') }}">
                                    <span class="sub-item">Laporan Rekap Penagihan/Tim</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('main/penagihandraftspk') ? 'active' : '' }}">
                                <a href="{{ route('draftspk') }}">
                                    <span class="sub-item">Draft SPK</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
