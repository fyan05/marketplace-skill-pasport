<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Sticky footer layout */
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        footer {
            margin-top: auto;
        }

        /* Navbar */
        .navbar-main {
            background: white;
            border-bottom: 1px solid #e6e6e6;
            padding: 12px 0;
        }
        .navbar-brand span {
            color: #4CAF50;
            font-weight: 700;
            font-size: 28px;
        }
        .search-box input {
            border-radius: 8px;
            border: 1px solid #dcdcdc;
        }
        .search-box input:focus {
            box-shadow: none;
        }
        .btn-jual {
            background: #4CAF50;
            color: white;
            border-radius: 6px;
            padding: 7px 18px;
            font-weight: 500;
        }

        /* Footer Modern */
        .footer-green {
            background: #22c55e;
            color: white;
            border-radius: 18px 18px 0 0;
        }
        .footer-green a {
            color: white;
            text-decoration: none;
        }
        .footer-green a:hover {
            opacity: 0.7;
        }
    </style>
</head>
<body>

    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-lg navbar-main">
        <div class="container align-items-center">

            <!-- Logo -->
            <a class="navbar-brand" href="/">
                <span>tokosekolah</span>
            </a>

            <!-- Search -->
            <form action="{{ route('cari') }}" method="GET" class="flex-grow-1 me-3 search-box">
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

            <!-- Mulai Berjualan -->
            <a href="{{ route('registrasi') }}" class="btn btn-jual">
                Mulai Berjualan
            </a>

        </div>
    </nav>

    <!-- Content -->
    <div>
        @yield('content')
    </div>

    <!-- FOOTER -->
    <footer class="footer-green mt-5">
        <div class="container py-4">

            <div class="row">

                <!-- Logo / Brand -->
                <div class="col-md-4 mb-3">
                    <h4 style="font-weight:700;">Tokosekolah</h4>
                    <p style="opacity:0.9;">
                        Belanja perlengkapan sekolah dengan mudah, cepat, dan terpercaya.
                    </p>
                </div>

                <!-- Navigasi -->
                <div class="col-md-4 mb-3">
                    <h5 style="font-weight:600;">Navigasi</h5>
                    <ul class="list-unstyled" style="line-height:1.8;">
                        <li><a href="/">Beranda</a></li>
                        <li><a href="{{ route('pengguna.produk') }}">Produk</a></li>
                        <li><a href="/toko">Toko</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div class="col-md-4 mb-3">
                    <h5 style="font-weight:600;">Kontak</h5>
                    <p class="m-0">Email: support@tokosekolah.com</p>
                    <p class="m-0">WhatsApp: 0812-3456-7890</p>
                </div>

            </div>

            <hr style="border-color: rgba(255,255,255,0.3);">

            <div class="text-center" style="opacity:0.9;">
                &copy; {{ date('Y') }} Tokosekolah — Semua Hak Dilindungi.
            </div>

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
