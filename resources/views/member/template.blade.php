<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller</title>

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
        }

        /* ===================== SIDEBAR ===================== */
        .sidebar {
            width: 250px;
            background-color: #2E7D32;
            min-height: 100vh;
            padding: 1rem;
            position: fixed;
            top: 0;
            left: 0;
            transition: all .3s ease-in-out;
            z-index: 200;
        }

        .sidebar .nav-link {
            color: #E8F5E9;
            font-weight: 500;
            margin-bottom: 0.6rem;
            padding: 0.7rem 1rem;
            border-radius: 0.55rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #388E3C;
            color: #fff;
        }

        /* ===================== MAIN WRAPPER ===================== */
        .main-wrapper {
            margin-left: 250px;
            padding: 25px;
            transition: all .3s ease-in-out;
            min-height: 100vh;
        }

        /* ===================== TOPBAR ===================== */
        .topbar {
            background-color: #fff;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
            padding: 0.9rem 1.4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 12px;
            margin-bottom: 20px;
            position: sticky;
            top: 15px;
            z-index: 50;
        }

        .menu-btn {
            display: none;
            font-size: 1.5rem;
        }

        .search-box {
            background: #F1F1F1;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
        }

        /* ===================== CONTENT ===================== */
        .content {
            margin-top: 15px;
        }

        .card {
            border-radius: 14px;
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 991px) {
            .main-wrapper {
                margin-left: 0;
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
            }

            .sidebar.active {
                left: 0;
            }

            .menu-btn {
                display: block;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    <nav class="sidebar" id="sidebarMenu">
        <h4 class="text-white text-center mb-4">
            <i class="fa-solid fa-store me-2"></i> Seller Panel
        </h4>

        <ul class="nav flex-column">
            <li class="mb-1">
                <a href="{{ route('member.toko') }}" class="nav-link {{ request()->routeIs('member.toko') ? 'active' : '' }}">
                    <i class="fa-solid fa-store"></i> Toko
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('member.produk') }}" class="nav-link {{ request()->routeIs('member.produk') ? 'active' : '' }}">
                    <i class="fa-solid fa-box"></i> Produk
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('member.gambar') }}" class="nav-link {{ request()->routeIs('member.produk.gambar') ? 'active' : '' }}">
                    <i class="fa-solid fa-image"></i> Gambar Produk
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('logout') }}" class="nav-link">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">

        {{-- CONTENT --}}
        <div class="content">
            @yield('content')
        </div>

    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebarMenu').classList.toggle('active');
        }
    </script>
     <script src="{{ asset('bootstrap1/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
