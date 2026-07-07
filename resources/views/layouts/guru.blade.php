<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistem Validasi</title>

    {{-- Font & Icon --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Template CSS --}}
    <link rel="stylesheet" href="{{ asset('template-dashboard/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('template-dashboard/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('template-dashboard/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template-dashboard/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template-dashboard/js/select.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template-dashboard/css/vertical-layout-light/style.css') }}">

    @stack('styles')

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/global-responsive.css') }}">

    {{-- Fallback font agar layout tidak lompat --}}
    <style>
        body,
        .sidebar .nav .nav-item .nav-link,
        .navbar,
        .content-wrapper,
        table,
        input,
        button,
        select {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif !important;
        }

        /* Reset background nav-link semua item */
        .sidebar .nav .nav-item>.nav-link,
        .sidebar.active .nav .nav-item>.nav-link {
            background: transparent !important;
            color: #6C7383 !important;
        }

        .sidebar .nav .nav-item>.nav-link i,
        .sidebar .nav .nav-item>.nav-link .menu-title,
        .sidebar.active .nav .nav-item>.nav-link i,
        .sidebar.active .nav .nav-item>.nav-link .menu-title {
            color: #6C7383 !important;
        }

        /* Hanya nav-item.active yang boleh orange */
        .sidebar .nav .nav-item.active>.nav-link,
        .sidebar.active .nav .nav-item.active>.nav-link {
            background: #f37022 !important;
        }

        .sidebar .nav .nav-item.active>.nav-link i,
        .sidebar .nav .nav-item.active>.nav-link .menu-title,
        .sidebar.active .nav .nav-item.active>.nav-link i,
        .sidebar.active .nav .nav-item.active>.nav-link .menu-title {
            color: #ffffff !important;
        }

        /* Fix hover — hanya non-active yang subtle */
        .sidebar .nav .nav-item:not(.active):hover>.nav-link,
        .sidebar.active .nav .nav-item:not(.active):hover>.nav-link {
            background: rgba(243, 112, 34, 0.1) !important;
        }

        .sidebar .nav .nav-item:not(.active):hover>.nav-link i,
        .sidebar .nav .nav-item:not(.active):hover>.nav-link .menu-title,
        .sidebar.active .nav .nav-item:not(.active):hover>.nav-link i,
        .sidebar.active .nav .nav-item:not(.active):hover>.nav-link .menu-title {
            color: #6C7383 !important;
        }
    </style>
    <!-- plugins:css -->
    {{-- <link rel="stylesheet" href="{{ asset('template-dashboard/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('template-dashboard/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('template-dashboard/vendors/css/vendor.bundle.base.css') }}"> --}}
    <!-- endinject -->

    <!-- Plugin css for this page -->
    {{-- <link rel="stylesheet"
        href="{{ asset('template-dashboard/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template-dashboard/js/select.dataTables.min.css') }}"> --}}
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    {{-- <link rel="stylesheet" href="{{ asset('template-dashboard/css/vertical-layout-light/style.css') }}"> --}}
    <!-- endinject -->

    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"> --}}

</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            {{-- <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <img src="{{ asset('frontend/assets/images/logo/logo2.png') }}" alt="logo"
                    style="height:50px; width:auto; object-fit:contain;" />
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


                <!-- Profile menu -->
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
                <ul class="nav">
                    {{-- Dashboard --}}
                    <li class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('guru.dashboard') }}">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    {{-- Daftar Siswa --}}
                    <li class="nav-item {{ request()->routeIs('guru.daftar-siswa*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('guru.daftar-siswa') }}">
                            <i class="icon-head menu-icon"></i>
                            <span class="menu-title">Daftar Siswa</span>
                        </a>
                    </li>

                    {{-- Materi --}}
                    <li class="nav-item {{ request()->routeIs('guru.materi*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('guru.materi.index') }}">
                            <i class="icon-book menu-icon"></i>
                            <span class="menu-title">Materi</span>
                        </a>
                    </li>

                    {{-- Riwayat Latihan --}}
                    <li class="nav-item {{ request()->routeIs('guru.riwayat-latihan*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('guru.riwayat-latihan') }}">
                            <i class="icon-clock menu-icon"></i>
                            <span class="menu-title">Riwayat Latihan</span>
                        </a>
                    </li>

                    {{-- Manajemen User --}}
                    <li class="nav-item {{ request()->routeIs('guru.manajemen-user*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('guru.manajemen-user.index') }}">
                            <i class="icon-cog menu-icon"></i>
                            <span class="menu-title">Pengguna</span>
                        </a>
                    </li>
                </ul>
            </nav>

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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @stack('styles')
</body>

</html>
