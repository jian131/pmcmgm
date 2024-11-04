<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Quản lý Nhà thuốc</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/css/adminlte.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
         /* Sidebar Styling */
         .app-sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 4rem; /* Adjust if you have a fixed header */
            z-index: 1000;
            overflow-y: auto;
            background-color: #f8f9fa; /* Light gray background */
            color: #212529; /* Dark text */
            transition: width 0.3s ease;
        }

               .sidebar-brand .brand-link {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #212529; /* Dark text for readability */
            text-decoration: none;
        }

        .sidebar-brand .brand-text {
            font-size: 1.5rem;
        }

        /* Navigation Styling */
        .sidebar-menu .nav-link {
            color: #212529; /* Dark text */
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s, color 0.2s;
        }

        .sidebar-menu .nav-link:hover {
            background-color: #e2e6ea; /* Light gray hover */
            color: #212529; /* Maintains dark text on hover */
            text-decoration: none;
        }

        .sidebar-menu .nav-link.active {
            background-color: #0d6efd; /* Bootstrap's Primary color for active links */
            color: #fff;
        }

        .sidebar-menu .nav-icon {
            font-size: 1.25rem;
            margin-right: 0.75rem;
        }
                .nav-header {
            font-size: 0.85rem;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            padding-left: 1rem;
            color: #6c757d; /* Bootstrap's Secondary text color */
        }

        /* Main Content Styling */
        .app-main {
            margin-left: 250px; /* Same as sidebar width */
            padding-top: 4rem; /* Adjust if you have a fixed header */
            padding: 1rem; /* Additional padding */
            transition: margin-left 0.3s ease;
        }

        /* Header Styling (Optional) */
        .app-header {
            width: 100%;
            height: 4rem;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1001;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
        }
        .small-box {
            position: relative;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 0.25rem;
            color: #fff;
            background-color: #0d6efd; /* Bootstrap's Primary color */
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .app-sidebar {
                width: 200px;
            }

            .app-main {
                margin-left: 200px;
            }
        }

        /* Optional: Toggle Sidebar */
        .app-sidebar.collapsed {
            width: 60px;
        }

        .app-sidebar.collapsed .sidebar-menu .nav-link span {
            display: none; /* Hide text labels when collapsed */
        }

        .app-sidebar.collapsed .sidebar-menu .nav-link {
            justify-content: center; /* Center icons */
        }

        .app-main.collapsed {
            margin-left: 60px;
        }

        /* Sidebar Header Sections */
        .nav-header {
            font-size: 0.85rem;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            padding-left: 1rem;
            color: #adb5bd;
        }

        /* Main Content Styling */
        .app-main {
            margin-left: 250px; /* Same as sidebar width */
            padding-top: 4rem; /* Adjust if you have a fixed header */
            padding: 1rem; /* Additional padding */
            transition: margin-left 0.3s ease;
        }
        .app-header {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1001;
        }

        .app-main {
            margin-left: 250px;
            padding-top: 4rem;
        }

        .small-box {
            position: relative;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 0.25rem;
            color: #fff;
        }

        .small-box .inner {
            padding: 10px;
        }

        .small-box .icon {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 70px;
            opacity: 0.3;
        }

        .small-box .icon i {
            font-size: 3rem;
        }

        .bg-info { background-color: #17a2b8 !important; }
        .bg-success { background-color: #28a745 !important; }
        .bg-warning { background-color: #ffc107 !important; }
        .bg-danger { background-color: #dc3545 !important; }

        .sidebar-menu .nav-link {
            color: #343a40;
            padding: 0.5rem 1rem;
        }

        .sidebar-menu .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }

        .sidebar-menu .nav-link:hover {
            background-color: rgba(0,0,0,0.1);
        }

        .app-footer {
            margin-left: 250px;
            padding: 1rem;
            border-top: 1px solid #dee2e6;
            text-align: center;
        }
    </style>
    @stack('styles')
</head>
<body class="layout-fixed">
    <div class="wrapper">
        @include('layouts.partials.navbar')
        @include('layouts.partials.sidebar')

        <main class="app-main">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('header')</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>

        @include('layouts.partials.footer')
    </div>

    <!-- Scripts -->
    <script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.app-sidebar');
    const mainContent = document.querySelector('.app-main');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('collapsed');
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/js/adminlte.min.js"></script>
    @stack('scripts')
</body>
</html>
