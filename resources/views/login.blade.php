<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Marketplace</title>

    <link rel="stylesheet" href="{{ asset('bootstrap1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/fontawesome-free-6.7.2-web/css/all.min.css') }}">

    <style>
        body {
            background: linear-gradient(135deg, #d3ffe8 0%, #e8fdf5 100%);
            min-height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 22px;
            padding: 30px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease-in-out;
            margin: 20px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-img {
            width: 110px;
            height: 110px;
            object-fit: contain;
            border-radius: 50%;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        }

        .login-title {
            font-family: 'Segoe UI', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #222;
        }

        .input-group-text {
            background: #f3f3f3;
            border: none;
            font-size: 1.1rem;
        }

        .form-control {
            border-left: none;
        }

        .btn-success {
            background: linear-gradient(90deg, #00c853 0%, #43e97b 100%);
            border: none;
            font-weight: 600;
            padding: 10px;
            border-radius: 12px;
            transition: 0.25s;
        }

        .btn-success:hover {
            background: linear-gradient(90deg, #43e97b 0%, #00c853 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 150, 80, 0.25);
        }

        .text-small a {
            font-weight: 600;
        }

        /* RESPONSIVE FIX */
        @media (max-width: 480px) {
            .login-container {
                padding: 20px;
                border-radius: 16px;
            }
            .login-title {
                font-size: 1.4rem;
            }
            .logo-img {
                width: 90px;
                height: 90px;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .login-container {
                max-width: 450px;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="login-container">

            @if (session('message'))
                <div class="alert alert-danger text-center">
                    {{ session('message') }}
                </div>
            @endif

            <form action="{{ route('login.auth') }}" method="POST">
                @csrf

                <div class="text-center mb-3">
                    <img src="{{ asset('asset/logo/ChatGPT Image 23 Nov 2025, 13.35.39.png') }}" class="logo-img" alt="Logo">
                </div>

                <h2 class="login-title text-center mb-3">Login</h2>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <button class="btn btn-success w-100 mt-3" type="submit">Login</button>

                <div class="text-center text-small mt-3">
                    <small>Belum punya akun?
                        <a href="{{ route('registrasi') }}">Daftar Sekarang</a>
                    </small>
                </div>

            </form>
        </div>
    </div>

    <footer class="text-center mt-4 mb-3 text-muted">
        © 2024-{{ date('Y') }}, PT Tokosekolah — Tokosekolah.com
    </footer>

    <script src="{{ asset('bootstrap1/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
