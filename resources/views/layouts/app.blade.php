<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Wisata Riau | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
    :root {
        --pandan-primary: #2e7d32;
        --pandan-secondary: #81c784;
        --pandan-light: #e8f5e9;
        --pandan-dark: #1b5e20;
    }

    body {
        background-color: #f5f5f5;
        overflow-x: hidden;
    }

    .sidebar {
        background-color: var(--pandan-primary);
        color: white;
        height: 100vh;
        position: fixed;
        width: 250px;
        transition: all 0.3s;
        z-index: 1000;
        left: 0;
    }

    .sidebar.collapsed {
        left: -250px;
    }

    .sidebar-header {
        padding: 20px;
        background-color: var(--pandan-dark);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar-menu {
        padding: 0;
        list-style: none;
        max-height: calc(100vh - 60px);
        overflow-y: auto;
    }

    .sidebar-menu li {
        padding: 10px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s;
    }

    .sidebar-menu li:hover {
        background-color: var(--pandan-secondary);
    }

    .sidebar-menu li a {
        color: white;
        text-decoration: none;
        display: block;
    }

    .sidebar-menu li i {
        transition: all 0.3s ease;
        display: inline-block;
    }

    .sidebar-menu li:hover i {
        transform: translateY(-5px) scale(1.2);
        text-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        color: #fff;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
    }

    .sidebar-menu li:hover a {
        transform: translateX(8px);
        transition: transform 0.3s ease;
    }

    .sidebar-menu li.active {
        background-color: var(--pandan-dark);
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
        transition: all 0.3s;
    }

    .main-content.expanded {
        margin-left: 0;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        border: none;
    }

    .card-header {
        background-color: var(--pandan-primary);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }

    .btn-pandan {
        background-color: var(--pandan-primary);
        color: white;
    }

    .btn-pandan:hover {
        background-color: var(--pandan-dark);
        color: white;
    }

    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
    }

    .table thead {
        background-color: var(--pandan-primary);
        color: white;
    }

    .alert-success {
        background-color: #e8f5e9;
        border-color: #c8e6c9;
        color: var(--pandan-dark);
    }

    .sidebar-toggle {
        display: none;
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
    }

    @media (max-width: 992px) {
        .sidebar {
            left: -250px;
        }

        .sidebar.collapsed {
            left: 0;
        }

        .main-content {
            margin-left: 0;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .sidebar-toggle {
            display: block;
        }
    }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-tree-fill me-2"></i>Wisata Riau</h4>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ request()->is('wisata*') ? 'active' : '' }}">
                <a href="{{ url('/wisata') }}"><i class="bi bi-signpost-split me-2"></i> Wisata</a>
            </li>
            <li class="{{ request()->is('penginapan*') ? 'active' : '' }}">
                <a href="{{ url('/penginapan') }}"><i class="bi bi-house-door me-2"></i> Penginapan</a>
            </li>
            <li class="{{ request()->is('restoran*') ? 'active' : '' }}">
                <a href="{{ url('/restoran') }}"><i class="bi bi-egg-fried me-2"></i> Restoran</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Content -->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Toggle sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        mobileSidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });

        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 992) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnMobileToggle = mobileSidebarToggle.contains(event.target);

                if (!isClickInsideSidebar && !isClickOnMobileToggle && !sidebar.classList.contains(
                        'collapsed')) {
                    sidebar.classList.add('collapsed');
                }
            }
        });
    });
    </script>
    @stack('scripts')
</body>

</html>