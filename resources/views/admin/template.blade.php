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
            height: 100vh;
            display: flex;
            flex-direction: row;

        }

        /* === SIDEBAR === */
        .sidebar {
            width: 250px;
            background-color: #2E7D32;
            min-height: 100vh;
            flex-shrink: 0;
            display: block;
            flex-direction: column;
            padding: 1rem;
            position: fixed
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

        /* === MAIN WRAPPER === */
        .main-wrapper {
            flex: 1;
            margin-left:250px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* === TOPBAR === */
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

        /* === CONTENT === */
        .content {
            flex: 1;
            padding: 25px;
        }

        /* Button custom */
        .btn-primary {
            background-color: #FF9800;
            border: none;
        }

        .btn-primary:hover {
            background-color: #FB8C00;
        }
    </style>
</head>

<body>
    {{-- SIDEBAR --}}
    <nav class="sidebar">
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
        </ul>
    </nav>

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <nav class="topbar">
            <div class="search-box">
                <i class="fas fa-search text-muted"></i>
                <input type="text" placeholder="Search for...">
            </div>
            <div class="user-info">
                <span class="text-muted small">Admin</span>
                <i class="fa-solid fa-circle-user"></i>
            </div>
        </nav>

        {{-- MAIN CONTENT --}}
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('bootstrap1/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
