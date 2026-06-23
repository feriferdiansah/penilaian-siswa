<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Penilaian Siswa - SMART Method</title>
    
    <!-- Bootstrap 4 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    
    <style>
        /* ========================================
           RESET & DASAR
           ======================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            background: #f5f7fa;
            overflow-x: hidden;
        }
        
        /* ========================================
           WRAPPER - FLEX CONTAINER
           ======================================== */
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }
        
        /* ========================================
           SIDEBAR
           ======================================== */
        .sidebar {
            width: 250px;
            min-width: 250px;
            max-width: 250px;
            background: linear-gradient(135deg, #2d3e50 0%, #1a2a3a 100%);
            color: #e8edf2;
            transition: all 0.3s ease-in-out;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
        }
        
        .sidebar .sidebar-header {
            padding: 20px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
        }
        
        .sidebar .sidebar-header h5 {
            margin: 0;
            color: #e8edf2;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
        }
        
        .sidebar .sidebar-header small {
            color: #9aaebf;
            font-size: 11px;
        }
        
        .sidebar-nav {
            flex: 1;
            padding: 10px 15px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 12px 15px;
            margin: 4px 0;
            border-radius: 10px;
            transition: all 0.3s;
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #ffffff;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.12);
            color: #ffffff;
            border-left: 3px solid #7ab2d6;
        }
        
        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            font-size: 0.9rem;
        }
        
        .sidebar-footer {
            flex-shrink: 0;
            padding: 15px;
            border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
        }
        
        .logout-btn {
            width: 100%;
        }
        
        .logout-btn button {
            background: rgba(248, 113, 113, 0.15);
            border: 1px solid rgba(248, 113, 113, 0.3);
            cursor: pointer;
            width: 100%;
            text-align: left;
            padding: 12px 15px;
            border-radius: 10px;
            color: #f87171 !important;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .logout-btn button:hover {
            background: rgba(248, 113, 113, 0.3);
            border-color: #f87171;
            transform: translateX(5px);
        }
        
        .logout-btn button i {
            margin-right: 12px;
            width: 20px;
            color: #f87171;
        }
        
        /* ========================================
           CONTENT UTAMA
           ======================================== */
        .content {
            flex: 1;
            min-height: 100vh;
            transition: all 0.3s ease-in-out;
            margin-left: 250px;
            width: calc(100% - 250px);
        }
        
        /* ========================================
           NAVBAR ATAS
           ======================================== */
        .navbar-top {
            background: #ffffff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            padding: 12px 20px;
            position: sticky;
            top: 0;
            z-index: 1040;
            border-bottom: 1px solid #e9ecef;
        }
        
        .navbar-top h5 {
            font-size: 0.95rem;
            margin-bottom: 0;
            color: #2c3e50;
            font-weight: 500;
        }
        
        #sidebarCollapse {
            background: #eef2f7;
            border: 1px solid #e2e8f0;
            color: #4a6fa5;
            border-radius: 10px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        #sidebarCollapse:hover {
            background: #e2e8f0;
            transform: scale(1.02);
            color: #2c3e50;
        }
        
        .main-content {
            background: #f0f4f8;
            min-height: calc(100vh - 60px);
            padding: 20px;
        }
        
        /* ========================================
           OVERLAY (Untuk Mobile)
           ======================================== */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1045;
            cursor: pointer;
        }
        
        .overlay.active {
            display: block;
        }
        
        /* ========================================
           RESPONSIF: DESKTOP (>= 769px)
           ======================================== */
        @media (min-width: 769px) {
            .sidebar {
                margin-left: 0 !important;
            }
            
            .sidebar.active {
                margin-left: -250px !important;
            }
            
            .content {
                margin-left: 250px;
                width: calc(100% - 250px);
            }
            
            .content.active {
                margin-left: 0;
                width: 100%;
            }
            
            .overlay {
                display: none !important;
            }
        }
        
        /* ========================================
           RESPONSIF: MOBILE (<= 768px)
           ======================================== */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
                width: 250px;
                min-width: 250px;
                max-width: 250px;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .content {
                margin-left: 0;
                width: 100%;
            }
            
            .content.active {
                margin-left: 0;
                width: 100%;
            }
            
            .main-content {
                padding: 12px !important;
            }
            
            .navbar-top {
                padding: 8px 12px !important;
            }
            
            .navbar-top h5 {
                font-size: 11px !important;
                margin-left: 8px !important;
                max-width: 120px;
            }
            
            #sidebarCollapse {
                padding: 5px 10px !important;
                font-size: 0.8rem !important;
            }
            
            h2 {
                font-size: 1.1rem !important;
            }
            h3 {
                font-size: 1rem !important;
            }
            h4 {
                font-size: 0.9rem !important;
            }
            h5 {
                font-size: 0.8rem !important;
            }
            
            .card-body {
                padding: 12px !important;
            }
            
            .card-header {
                padding: 8px 12px !important;
            }
            
            .card-header h5 {
                font-size: 0.75rem !important;
            }
            
            .form-control {
                font-size: 0.75rem !important;
                padding: 0.4rem 0.7rem !important;
                height: auto !important;
            }
            
            .form-group {
                margin-bottom: 0.8rem !important;
            }
            
            .form-group label {
                font-size: 0.7rem !important;
                margin-bottom: 0.2rem !important;
            }
            
            .col-form-label {
                font-size: 0.7rem !important;
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }
            
            .btn {
                font-size: 0.7rem !important;
                padding: 5px 10px !important;
                border-radius: 6px !important;
            }
            
            .btn-sm {
                font-size: 0.6rem !important;
                padding: 3px 6px !important;
            }
            
            .btn-group .btn {
                font-size: 0.6rem !important;
                padding: 3px 6px !important;
            }
            
            .table {
                font-size: 0.65rem !important;
            }
            
            .table th,
            .table td {
                padding: 4px 6px !important;
                font-size: 0.65rem !important;
            }
            
            .table .btn-sm {
                padding: 2px 5px !important;
                font-size: 0.55rem !important;
            }
            
            .badge {
                font-size: 0.55rem !important;
                padding: 2px 6px !important;
            }
            
            .badge-pill {
                padding: 3px 8px !important;
            }
            
            .alert {
                font-size: 0.7rem !important;
                padding: 0.5rem 0.8rem !important;
            }
            
            .card-stats .card-body {
                padding: 10px !important;
            }
            
            .card-stats h2 {
                font-size: 1.1rem !important;
            }
            
            .card-stats h3 {
                font-size: 1rem !important;
            }
            
            .card-stats h6 {
                font-size: 0.55rem !important;
            }
            
            .card-stats i {
                font-size: 1.2rem !important;
            }
            
            .progress {
                height: 16px !important;
            }
            
            .progress-bar {
                font-size: 0.6rem !important;
                line-height: 16px !important;
            }
            
            .select2-container .select2-selection--single {
                height: auto !important;
                padding: 4px 8px !important;
            }
            
            .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
                font-size: 0.75rem !important;
                padding-left: 8px !important;
            }
            
            .custom-control-label {
                font-size: 0.7rem !important;
                padding-left: 5px !important;
            }
            
            .custom-control {
                padding-left: 1.5rem !important;
                margin-right: 5px !important;
            }
        }
        
        /* ========================================
           RESPONSIF: MOBILE KECIL (<= 576px)
           ======================================== */
        @media (max-width: 576px) {
            .main-content {
                padding: 8px !important;
            }
            
            .container-fluid {
                padding-left: 8px !important;
                padding-right: 8px !important;
            }
            
            .row {
                margin-left: -4px !important;
                margin-right: -4px !important;
            }
            
            .col-6, .col-sm-6, .col-md-3, .col-md-4, .col-md-6 {
                padding-left: 4px !important;
                padding-right: 4px !important;
            }
            
            .navbar-top h5 {
                max-width: 80px;
                font-size: 10px !important;
            }
            
            .radio-group .custom-control {
                flex: 0 0 calc(50% - 6px);
                margin-right: 0;
                margin-bottom: 4px;
            }
            
            .radio-group .custom-control-label {
                font-size: 0.65rem !important;
            }
            
            .table th,
            .table td {
                padding: 3px 4px !important;
                font-size: 0.6rem !important;
            }
            
            .table .btn-sm {
                padding: 1px 4px !important;
                font-size: 0.5rem !important;
            }
            
            .table .btn-sm i {
                font-size: 0.5rem !important;
            }
            
            .btn-group .btn {
                font-size: 0.55rem !important;
                padding: 2px 5px !important;
            }
            
            .card-stats h2 {
                font-size: 0.95rem !important;
            }
            
            .card-stats h3 {
                font-size: 0.85rem !important;
            }
            
            .card-stats i {
                font-size: 1rem !important;
            }
            
            h2 {
                font-size: 0.95rem !important;
            }
        }
        
        /* ========================================
           RESPONSIF: TABLET (769px - 1024px)
           ======================================== */
        @media (min-width: 769px) and (max-width: 1024px) {
            .main-content {
                padding: 15px !important;
            }
            
            .card-stats h2 {
                font-size: 1.3rem !important;
            }
            
            .card-stats h3 {
                font-size: 1.1rem !important;
            }
        }
        
        /* ========================================
           UTILITY: TABLE WRAPPER
           ======================================== */
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            width: 100%;
            margin-bottom: 0;
        }
        
        .table-wrapper table {
            min-width: 600px;
            width: 100%;
            margin-bottom: 0;
        }
        
        .table-wrapper table th,
        .table-wrapper table td {
            white-space: nowrap;
        }
        
        /* ========================================
           UTILITY: RADIO GROUP
           ======================================== */
        .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .radio-group .custom-control {
            margin-right: 10px;
            margin-bottom: 0;
        }
        
        @media (max-width: 576px) {
            .radio-group .custom-control {
                flex: 0 0 calc(50% - 6px);
                margin-right: 0;
                margin-bottom: 4px;
            }
            
            .radio-group .custom-control-label {
                font-size: 0.65rem !important;
            }
        }
        
        /* ========================================
           UTILITY: CARD STATS
           ======================================== */
        .card-stats {
            border-radius: 12px;
            border: none;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            background: #ffffff;
            height: 100%;
        }
        
        .card-stats:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        
        .card-stats .card-body {
            padding: 1.25rem !important;
        }
        
        .card-stats h6 {
            font-size: 0.65rem;
            margin-bottom: 0;
            letter-spacing: 0.5px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .card-stats h2 {
            font-size: 1.6rem;
            margin-bottom: 0;
            font-weight: 700;
        }
        
        .card-stats h3 {
            font-size: 1.3rem;
            margin-bottom: 0;
            font-weight: 700;
        }
        
        .card-stats i {
            font-size: 1.8rem;
            opacity: 0.8;
        }
        
        /* ========================================
           PRINT STYLES
           ======================================== */
        @media print {
            .sidebar,
            .navbar-top,
            .btn,
            .btn-group,
            .no-print,
            #sidebarCollapse {
                display: none !important;
            }
            
            .content {
                margin-left: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }
            
            .main-content {
                padding: 20px !important;
                background: white !important;
            }
            
            .card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
            }
            
            .card-stats {
                border: 1px solid #ddd !important;
            }
            
            .table-wrapper {
                overflow: visible !important;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="overlay" id="overlay"></div>
        
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h5><i class="fas fa-trophy"></i> SPK SMART</h5>
                <small>MIN 3 Tangerang</small>
            </div>
            
            <div class="sidebar-nav">
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('alternatif.*') ? 'active' : '' }}" href="{{ route('alternatif.index') }}">
                        <i class="fas fa-users"></i> Data Siswa
                    </a>
                    <a class="nav-link {{ request()->routeIs('absensi.*') ? 'active' : '' }}" href="{{ route('absensi.index') }}">
                        <i class="fas fa-calendar-check"></i> Absensi
                    </a>
                    <a class="nav-link {{ request()->routeIs('kriteria.*') ? 'active' : '' }}" href="{{ route('kriteria.index') }}">
                        <i class="fas fa-list"></i> Kriteria
                    </a>
                    <a class="nav-link {{ request()->routeIs('penilaian.*') ? 'active' : '' }}" href="{{ route('penilaian.index') }}">
                        <i class="fas fa-star"></i> Penilaian
                    </a>
                    <a class="nav-link {{ request()->routeIs('rangking.*') ? 'active' : '' }}" href="{{ route('rangking.index') }}">
                        <i class="fas fa-trophy"></i> Rangking
                    </a>
                    <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                        <i class="fas fa-file-pdf"></i> Laporan
                    </a>
                    <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                        <i class="fas fa-user-cog"></i> Pengaturan
                    </a>
                </nav>
            </div>
            
            <div class="sidebar-footer">
                <div class="logout-btn">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Page Content -->
        <div class="content" id="content">
            <nav class="navbar-top d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center" style="min-width: 0; flex: 1 1 auto;">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h5 class="mb-0 ml-3" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">
                        Selamat Datang, {{ auth()->user()->name ?? 'Guest' }}
                    </h5>
                </div>
                <div class="d-flex align-items-center" style="flex-shrink: 0;">
                    <span class="badge badge-primary mr-3 d-none d-sm-inline-block">
                        {{ auth()->user() && auth()->user()->role == 'admin' ? 'Administrator' : 'Guru' }}
                    </span>
                    <i class="fas fa-user-circle fa-2x text-secondary" style="color: #94a3b8 !important;"></i>
                </div>
            </nav>
            
            <div class="main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> Terjadi kesalahan:
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var sidebar = $('#sidebar');
            var content = $('#content');
            var overlay = $('#overlay');
            
            function isMobile() {
                return $(window).width() <= 768;
            }
            
            function toggleSidebar(show) {
                if (show === undefined) {
                    sidebar.toggleClass('active');
                    content.toggleClass('active');
                    overlay.toggleClass('active');
                } else if (show) {
                    sidebar.addClass('active');
                    content.addClass('active');
                    overlay.addClass('active');
                } else {
                    sidebar.removeClass('active');
                    content.removeClass('active');
                    overlay.removeClass('active');
                }
                
                var isOpen = !sidebar.hasClass('active');
                localStorage.setItem('sidebarState', isOpen ? 'open' : 'closed');
            }
            
            $('#sidebarCollapse').on('click', function() {
                toggleSidebar();
            });
            
            overlay.on('click', function() {
                if (isMobile()) {
                    toggleSidebar(false);
                }
            });
            
            function loadSavedState() {
                var savedState = localStorage.getItem('sidebarState');
                var mobile = isMobile();
                
                if (mobile) {
                    if (savedState === 'open') {
                        toggleSidebar(true);
                    } else {
                        toggleSidebar(false);
                    }
                } else {
                    if (savedState === 'closed') {
                        toggleSidebar(false);
                    } else {
                        toggleSidebar(true);
                    }
                }
            }
            
            var resizeTimer;
            $(window).on('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    var mobile = isMobile();
                    var isOpen = !sidebar.hasClass('active');
                    
                    if (mobile) {
                        if (isOpen) {
                            toggleSidebar(false);
                        }
                    } else {
                        if (!isOpen) {
                            toggleSidebar(true);
                        }
                    }
                }, 200);
            });
            
            $(document).on('keydown', function(e) {
                if (e.ctrlKey && (e.key === 'b' || e.key === 'B')) {
                    e.preventDefault();
                    toggleSidebar();
                }
            });
            
            loadSavedState();
            
            if ($('.datatable').length) {
                $('.datatable').each(function() {
                    if (!$.fn.DataTable.isDataTable($(this))) {
                        $(this).DataTable({
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
                            },
                            "pageLength": 10,
                            "responsive": false,
                            "autoWidth": false,
                            "scrollX": true,
                            "columnDefs": [
                                { "orderable": false, "targets": 'no-sort' }
                            ]
                        });
                    }
                });
            }
            
            setTimeout(function() {
                $(".alert").fadeOut("slow", function() {
                    $(this).remove();
                });
            }, 4000);
            
            if ($('[data-toggle="tooltip"]').length) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>