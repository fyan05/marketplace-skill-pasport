<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>

    {{-- Bootstrap & Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('bootstrap1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/fontawesome-free-6.7.2-web/css/all.min.css') }}">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F4F6F6;
            color: #333;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: row;
        }

        .sidebar {
            width: 250px;
            background-color: #2E7D32;
            min-height: 100vh;
            flex-shrink: 0;
            display: block;
            flex-direction: column;
            padding: 1rem;
            position: fixed;
            z-index: 1000;
            transition: left 0.3s;
            left: 0;
        }

        .sidebar h4 {
            font-weight: 600;
        }

        .sidebar .nav-pills {
            padding-top: 0.5rem;
        }

        .sidebar .nav-link {
            color: #E8F5E9;
            font-weight: 500;
            margin-bottom: 0.5rem;
            padding: 0.6rem 0.9rem;
            border-radius: 0.6rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: background-color 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #388E3C;
            color: #fff;
        }

        .sidebar .nav-link i {
            font-size: 1rem;
        }

        .main-wrapper {
            flex: 1;
            margin-left:250px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s;
        }

        .topbar {
            background-color: #fff;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar .search-box {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #F8F9FA;
            border-radius: 0.5rem;
            padding: 0.3rem 0.8rem;
        }

        .topbar .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.9rem;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .topbar .user-info img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }

        .content {
            flex: 1;
            padding: 25px;
        }

        .btn-primary {
            background-color: #FF9800;
            border: none;
        }

        .btn-primary:hover {
            background-color: #FB8C00;
        }

        /* Responsive Styles */
        @media (max-width: 991.98px) {
            .sidebar {
                left: -250px;
                position: fixed;
                top: 0;
                height: 100vh;
            }
            .sidebar.active {
                left: 0;
            }
            .main-wrapper {
                margin-left: 0;
            }
            .topbar {
                padding: 0.8rem 1rem;
            }
        }

        @media (max-width: 767.98px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 220px;
                padding: 0.7rem;
            }
            .content {
                padding: 15px;
            }
            .topbar .search-box input {
                width: 100px;
            }
        }

        @media (max-width: 575.98px) {
            .sidebar {
                width: 180px;
                padding: 0.5rem;
            }
            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            .topbar .search-box input {
                width: 70px;
            }
        }

        /* Hamburger button */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #2E7D32;
            margin-right: 1rem;
        }
        @media (max-width: 991.98px) {
            .sidebar-toggle {
                display: block;
            }
        }
    </style>
</head>

<body>
    {{-- SIDEBAR --}}
    <nav class="sidebar" id="sidebar">
        <h4 class="text-white text-center mb-4">
            <i class="fa-solid fa-store me-2"></i> Marketplace
        </h4>

        <ul class="nav nav-pills flex-column mb-4">
            <li class="mb-1">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('admin.user') }}" class="nav-link {{ request()->routeIs('admin.user') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('admin.produk') }}" class="nav-link {{ request()->routeIs('admin.produk') ? 'active' : '' }}">
                    <i class="fa-solid fa-utensils"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('admin.produk.gambar') }}" class="nav-link {{ request()->routeIs('admin.produk.gambar') ? 'active' : '' }}">
                    <i class="fa-solid fa-image"></i>
                    <span>Gambar Produk</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('admin.kategori') }}" class="nav-link {{ request()->routeIs('admin.kategori') ? 'active' : '' }}">
                    <i class="fa-solid fa-tags"></i>
                    <span>Kategori</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('admin.toko') }}" class="nav-link {{ request()->routeIs('admin.toko') ? 'active' : '' }}">
                    <i class="fa-solid fa-store"></i>
                    <span>Toko</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('logout') }}" class="nav-link {{ request()->routeIs('logout') ? 'active' : '' }}">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">
        {{-- TOPBAR --}}
        <nav class="topbar">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fa-solid fa-bars"></i>
            </button>
             <form action="{{ route('admin.cari') }}" method="GET" class="flex-grow-1 me-3 search-box">
                <div class="input-group">
                    <input
                        type="text"
                        name="q"
                        class="form-control"
                        placeholder="Cari di Tokosekolah..."
                        required
                    >
                </div>
            </form>
            <div class="user-info">
                <span class="text-muted small"></span>
                <i class="fa-solid fa-circle-user"></i>
            </div>
        </nav>

        {{-- MAIN CONTENT --}}
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('bootstrap1/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        // Sidebar toggle for mobile/tablet
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        });

        // Optional: close sidebar when clicking outside (mobile)
        document.addEventListener('click', function(e) {
            var sidebar = document.getElementById('sidebar');
            var toggle = document.getElementById('sidebarToggle');
            if (window.innerWidth <= 991.98 && sidebar.classList.contains('active')) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    </script>
</body>
</html>
