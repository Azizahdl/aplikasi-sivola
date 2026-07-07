<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistem Validasi</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('template-dashboard/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('template-dashboard/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('template-dashboard/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet"
        href="{{ asset('template-dashboard/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template-dashboard/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('template-dashboard/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @stack('styles')

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/global-responsive.css') }}">

    <style>
        /* Dropdown profil: ukuran ngikutin isi, jangan kepanjangan */
        .navbar-dropdown {
            min-width: 160px !important;
            /* Berikan lebar minimal yang ideal */
            width: auto !important;
            max-width: 240px !important;
            /* Batasi lebar maksimalnya */
            padding: 8px 0 !important;
            left: auto !important;
            /* Batalkan kalkulasi posisi kiri otomatis */
            right: 0 !important;
            /* Paksa dropdown menempel rata di kanan tombol profil */
        }

        .navbar-dropdown .dropdown-item {
            padding: 8px 16px !important;
            font-size: 13px;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            {{-- <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <img src="{{ asset('template-dashboard/images/logo-apk.png') }}" alt="logo"
                    style="height:150px; width:auto; object-fit:contain;" />
            </div> --}}
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

                <!-- LOGO BESAR (sidebar normal) -->
                <a class="navbar-brand brand-logo" href="#">
                    <img src="{{ asset('frontend/assets/images/logo/logo2.png') }}" alt="logo"
                        style="height:50px; width:auto; object-fit:contain;">
                </a>

                <!-- LOGO KECIL (sidebar mini) -->
                <a class="navbar-brand brand-logo-mini" href="#">
                    <img src="{{ asset('frontend/assets/images/logo/logo1.png') }}" alt="logo"
                        style="height:50px; width:auto; object-fit:contain;">
                </a>

            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>

                <!-- Example search bar -->
                {{-- <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-search d-none d-lg-block">
                        <div class="input-group">
                            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                                <span class="input-group-text" id="search">
                                    <i class="icon-search"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                                aria-label="search">
                        </div>
                    </li>
                </ul> --}}

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="{{ asset('template-dashboard/images/faces/user.png') }}" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">

                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="ti-settings text-primary"></i> Pengaturan
                            </a>

                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ti-power-off text-primary"></i> Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </div>
                    </li>
                </ul>

                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->

        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                {{-- SESUDAH --}}
                <ul class="nav">
                    <li class="nav-item {{ request()->is('siswa/dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('siswa/dashboard') }}">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('siswa/materi*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('siswa/materi') }}">
                            <i class="icon-book menu-icon"></i>
                            <span class="menu-title">Materi</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('siswa/riwayat-latihan*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('siswa/riwayat-latihan') }}">
                            <i class="icon-clock menu-icon"></i>
                            <span class="menu-title">Riwayat Latihan</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar -->

            <!-- Main Content -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
            <!-- End Main Content -->
        </div>
    </div>

    <!-- plugins:js -->
    <script src="{{ asset('template-dashboard/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->

    <!-- Plugin js for this page -->
    <script src="{{ asset('template-dashboard/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('template-dashboard/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('template-dashboard/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('template-dashboard/js/dataTables.select.min.js') }}"></script>
    <!-- End plugin js -->

    <!-- inject:js -->
    <script src="{{ asset('template-dashboard/js/off-canvas.js') }}"></script>
    <script src="{{ asset('template-dashboard/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('template-dashboard/js/template.js') }}"></script>
    <script src="{{ asset('template-dashboard/js/settings.js') }}"></script>
    <script src="{{ asset('template-dashboard/js/todolist.js') }}"></script>
    <!-- endinject -->

    <!-- Custom js for this page-->
    <script src="{{ asset('template-dashboard/js/dashboard.js') }}"></script>
    <script src="{{ asset('template-dashboard/js/Chart.roundedBarCharts.js') }}"></script>
    <!-- End custom js -->
    @stack('scripts')
</body>

</html>
