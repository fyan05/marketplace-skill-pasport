<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace
    </title>

    {{-- Bootstrap & Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F4F6F6;
            color: #333;
            height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #2E7D32;
            min-height: 100vh;
        }

        .sidebar .nav-link {
            color: #E8F5E9;
            font-weight: 500;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #388E3C;
            color: #fff;
            border-radius: 8px;
        }

        .submenu .nav-link {
            font-size: 0.9rem;
        }

        .content {
            flex: 1;
            padding: 30px;
        }

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

<div class="d-flex">
    {{-- SIDEBAR --}}
    <nav class="sidebar d-flex flex-column p-3">
        <h4 class="text-white text-center mb-4">
            <i class="fa-solid fa-store me-2"></i> Koperasi
        </h4>

        <ul class="nav nav-pills flex-column mb-4">
            <li><a href="#" class="nav-link"><i class="fa fa-house me-2"></i> Dashboard</a></li>
            <li><a href="#" class="nav-link"><i class="fa fa-users me-2"></i> Users</a></li>
            <li><a href="#" class="nav-link"><i class="fa fa-utensils me-2"></i> Produk</a></li>
            <li><a href="#" class="nav-link"><i class="fa fa-gear me-2"></i> Pengaturan</a></li>
        </ul>
    </nav>
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
