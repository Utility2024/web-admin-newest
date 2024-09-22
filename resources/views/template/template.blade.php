<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCAN QR CODE</title>
    <link rel="shortcut icon" type="image/png" href="{{url('images/logo_siix.png')}}" />
    <link rel="stylesheet" href="{{url('admin/assets/css/styles.min.css')}}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <!-- Sertakan pustaka DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <script src="{{url('callendar/dist/index.global.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .loading-text {
            font-size: 18px;
            color: #333;
        }

        .chart {
            width: 519px !important;
            height: 519px !important;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="loading-overlay" id="loadingOverlay" style="display: none;">
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>
    <!--  Body Wrapper -->
    <div class="flash-data" data-flashdata="{{session('flash')}}"></div>
    <!-- <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed"> -->
        <!-- Sidebar Start -->
        <!-- <aside class="left-sidebar" style="background-image: url('{{ url('admin/assets/images/backgrounds/bg-nav.png') }}');"> -->

        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            
            <!--  Header End -->
            <div class="container-fluid">
                <h4>
                    @yield('title')
                </h4>
                <hr>
                @yield('content')
            </div>
        </div>
    </div>
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Notifikasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="notification-list" class="list-group">
                        <!-- Notifications will be appended here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="{{url('admin/assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{url('admin/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('admin/assets/js/sidebarmenu.js')}}"></script>
    <script src="{{url('admin/assets/js/app.min.js')}}"></script>
    <script src="{{url('admin/assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
    <script src="{{url('admin/assets/libs/simplebar/dist/simplebar.js')}}"></script>
    <script src="{{url('admin/assets/js/dashboard.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{url('admin/assets/js/custom/global.js')}}"></script>
</body>
@yield('script')

</html>