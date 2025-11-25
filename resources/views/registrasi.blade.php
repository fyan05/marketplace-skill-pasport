<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e7f8ee 0%, #d0f2dc 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .card-register {
            width: 100%;
            max-width: 480px;
            margin: 70px auto 20px auto;
            padding: 32px;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            animation: fadeIn 0.7s ease;
        }

        h3 {
            font-weight: 700;
        }

        .btn-green {
            background: linear-gradient(90deg, #00c853 0%, #43e97b 100%);
            border: none;
            font-weight: 600;
            padding: 11px;
            border-radius: 12px;
            transition: 0.25s;
        }

        .btn-green:hover {
            background: linear-gradient(90deg, #43e97b 0%, #00c853 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 150, 80, 0.25);
        }

        footer {
            text-align: center;
            padding: 15px 0;
            font-size: 0.9rem;
            color: #555;
            margin-top: auto;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(15px);}
            to {opacity: 1; transform: translateY(0);}
        }

        /* RESPONSIVE MOBILE */
        @media (max-width: 480px) {
            .card-register {
                margin: 40px 15px 20px 15px;
                padding: 25px;
                border-radius: 16px;
            }
            h3 {
                font-size: 1.5rem;
            }
        }

        /* RESPONSIVE TABLET */
        @media (min-width: 768px) and (max-width: 1024px) {
            .card-register {
                max-width: 520px;
                padding: 38px;
            }
        }
    </style>
</head>

<body>

<div class="card-register">
    <h3 class="text-center mb-3">Registrasi Akun</h3>
    <p class="text-center text-muted mb-4">Isi data dengan benar untuk membuat akun baru</p>

    {{-- Alert sukses / gagal --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('registrasi.post') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama') }}"
                   class="form-control @error('nama') is-invalid @enderror"
                   placeholder="Masukkan nama">
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kontak</label>
            <input type="text" name="kontak" value="{{ old('kontak') }}"
                   class="form-control @error('kontak') is-invalid @enderror"
                   placeholder="Contoh: 081234567890">
            @error('kontak') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" value="{{ old('username') }}"
                   class="form-control @error('username') is-invalid @enderror"
                   placeholder="Masukkan username">
            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Masukkan password">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-green w-100 py-2">Daftar</button>

        <div class="text-center mt-3">
            <small>Sudah punya akun? <a href="{{ route('login') }}">Login</a></small>
        </div>
    </form>
</div>

<footer class="text-center mt-4 mb-3 text-muted">
    © 2024-{{ date('Y') }}, PT Tokosekolah — Tokosekolah.com
</footer>

</body>
</html>
