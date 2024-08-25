<!DOCTYPE html>
<html lang="en">

  <head>
    <meta http-equiv="X-UA-Compatible"
      content="IE=edge" />
    <title>DS {{ $title }}</title>

    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport" />
    <link rel="icon"
      href="{{ asset('img/logodsg.png') }}"
      type="image/x-icon">

    <!-- Fonts and icons -->
    <script src="{{ asset('kai/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["{{ asset('kai/css/fonts.min.css') }}"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet"
      href="{{ asset('kai/css/bootstrap.min.css') }}" />
    <link rel="stylesheet"
      href="{{ asset('kai/css/plugins.min.css') }}" />
    <link rel="stylesheet"
      href="{{ asset('kai/css/kaiadmin.min.css') }}" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
      integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @livewireStyles
  </head>

  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      @include($menu)
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header"
              data-background-color="white">
              <a href="#"
                class="logo">
                <img src="{{ asset('img/logodsg.png') }}"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20" />
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

          <!-- Navbar Header -->
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">
              <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                <h4>{{ $title }}</h4>
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown d-flex d-lg-none">
                  <h4>{{ $title }}</h4>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false">
                    <div class="avatar-sm">
                      @auth
                      @if (auth()->user()->image)
                      <img src="{{ asset('storage/' . auth()->user()->image) }}"
                        class="avatar-img rounded-circle"
                        alt="Profile Picture">
                      @else
                      <img src="{{ asset('img/profile-kosong.webp') }}"
                        class="avatar-img rounded-circle"
                        alt="Profile Picture">
                      @endif
                      @else
                      <img src="{{ asset('img/profile-kosong.webp') }}"
                        class="avatar-img rounded-circle"
                        alt="Profile Picture">
                      @endauth
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold">
                        @auth
                        {{ auth()->User()->name }}
                        @else
                        Guest
                        @endauth
                      </span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            @auth
                            @if (auth()->user()->image)
                            <img src="{{ asset('storage/' . auth()->user()->image) }}"
                              class="avatar-img rounded-circle"
                              alt="Profile Picture">
                            @else
                            <img src="{{ asset('img/profile-kosong.webp') }}"
                              class="avatar-img rounded-circle"
                              alt="Profile Picture">
                            @endif
                            @else
                            <img src="{{ asset('img/profile-kosong.webp') }}"
                              class="avatar-img rounded-circle"
                              alt="Profile Picture">
                            @endauth
                          </div>
                          <div class="u-text">
                            <h4>
                              @auth
                              {{ auth()->User()->name }}
                              @else
                              Guest
                              @endauth
                            </h4>
                            <p class="text-muted">
                              @auth
                              {{ auth()->User()->email }}
                              @else
                              Guest
                              @endauth
                            </p>
                            <a href="{{ route('profile') }}"
                              class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"
                          href="{{ route('panel') }}">Panel</a>
                      </li>
                      <li>
                        <a class="dropdown-item"
                          href="{{ route('logout') }}">Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
            {{ $slot }}
          </div>
        </div>
      </div>

      <!-- <footer class="footer">
                <div class="container-fluid d-flex justify-content-between">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="http://www.themekita.com">
                                    ThemeKita
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Help </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Licenses </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright">
                        2024, made with <i class="fa fa-heart heart text-danger"></i> by
                        <a href="http://www.themekita.com">ThemeKita</a>
                    </div>
                    <div>
                        Distributed by
                        <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
                    </div>
                </div>
            </footer> -->
    </div>

    </div>


    <!--   Core JS Files   -->
    <!-- <script src="{{ asset('kai/js/core/jquery-3.7.1.min.js') }}"></script> -->
    <script src="{{ asset('kai/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('kai/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('kai/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('kai/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('kai/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('kai/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('kai/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('kai/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('kai/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('kai/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('kai/js/kaiadmin.min.js') }}"></script>

    @livewireScripts
    <!-- Datatables -->
    <script src="{{ asset('kai/js/plugin/datatables/datatables.min.js') }}"></script>
    @stack('scripts')


  </body>

</html>