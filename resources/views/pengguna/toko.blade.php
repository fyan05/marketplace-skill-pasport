@extends('pengguna.template')

@section('title', $toko->nama_toko)

@section('content')

<style>
    /* ================= HEADER TOKO ================= */
    .store-header {
        background: linear-gradient(135deg, #16a34a, #22c55e);
        border-radius: 18px;
        padding: 28px;
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .store-header img {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 14px;
        border: 3px solid white;
    }

    /* Mobile Header fix */
    @media (max-width: 576px) {
        .store-header {
            padding: 20px;
            text-align: center;
            justify-content: center;
        }
        .store-header img {
            width: 90px;
            height: 90px;
        }
        .store-header h2 {
            font-size: 22px;
        }
    }

    /* ================= INFO CARD ================= */
    .info-box {
        background: white;
        border-radius: 14px;
        padding: 18px;
        border: 1px solid #e5e5e5;
        margin-top: 22px;
    }

    .info-label {
        font-weight: 600;
        color: #444;
        margin-bottom: 4px;
    }

    /* Mobile Info */
    @media (max-width: 576px) {
        .info-label {
            margin-bottom: 6px;
        }
        .info-box .row {
            margin-bottom: 14px;
        }
    }

    /* ================= PRODUK CARD ================= */
    .product-card {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #eaeaea;
        background: white;
        transition: .2s;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 5px 14px rgba(0,0,0,0.12);
    }

    .product-img {
        height: 180px;
        width: 100%;
        object-fit: cover;
    }

    @media (max-width: 576px) {
        .product-img {
            height: 140px;
        }
    }

    .product-title {
        font-size: 15px;
        font-weight: 600;
        min-height: 40px;
        color: #333;
    }

    .product-price {
        color: #16a34a;
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 3px;
    }
</style>

<!-- ================= HEADER TOKO ================= -->
<div class="container mt-4">
    <div class="store-header">

        <!-- Gambar toko -->
        <img src="{{ asset('storage/fototoko/'.$toko->gambar) }}" alt="Toko">

        <!-- Info -->
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fa-solid fa-store me-2"></i>
                {{ $toko->nama_toko }}
            </h2>

            <div class="d-flex flex-wrap mt-2" style="gap: 14px;">
                <span>
                    <i class="fa-solid fa-box text-white me-1"></i>
                    {{ $produk->count() }} Produk
                </span>

                <span>
                    <i class="fa-solid fa-circle-dot text-white me-1"></i>
                    Status: <strong>{{ ucfirst($toko->status) }}</strong>
                </span>
            </div>
        </div>

    </div>
</div>

<!-- ================= INFORMASI TOKO ================= -->
<div class="container">
    <div class="info-box">

        <h4 class="fw-bold mb-3">
            <i class="fa-solid fa-circle-info me-2 text-success"></i>
            Informasi Toko
        </h4>

        <div class="row mb-3">
            <div class="col-md-3 col-12 info-label">
                <i class="fa-solid fa-file-lines me-2"></i>Deskripsi
            </div>
            <div class="col-md-9 col-12">
                {{ $toko->deskripsi_toko }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 col-12 info-label">
                <i class="fa-solid fa-phone me-2 text-success"></i>Kontak
            </div>
            <div class="col-md-9 col-12">
                {{ $toko->kontak_toko }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-12 info-label">
                <i class="fa-solid fa-location-dot me-2 text-danger"></i>Alamat
            </div>
            <div class="col-md-9 col-12">
                {{ $toko->alamat_toko }}
            </div>
        </div>

    </div>
</div>

<!-- ================= PRODUK TOKO ================= -->
<div class="container mt-4">

    <h4 class="fw-bold mb-3">
        <i class="fa-solid fa-boxes-stacked me-2 text-success"></i>
        Produk di Toko Ini
    </h4>

    <div class="row g-3">

        @forelse($produk as $p)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('produk.detail', $p->id) }}" class="text-decoration-none text-dark">

                <div class="product-card">

                    <!-- Gambar Produk -->
                    @if ($p->gambarProduks->first())
                        <img src="{{ asset('storage/'.$p->gambarProduks->first()->gambar) }}" class="product-img">
                    @else
                        <img src="{{ asset('no-image.png') }}" class="product-img">
                    @endif

                    <!-- Info -->
                    <div class="p-2">
                        <div class="product-title">{{ $p->nama_produk }}</div>

                        <div class="product-price">
                            Rp {{ number_format($p->harga,0,',','.') }}
                        </div>

                        <small class="text-muted">
                            Stok: {{ $p->stok }}
                        </small>
                    </div>

                </div>

            </a>
        </div>

        @empty
            <p class="text-muted text-center">Belum ada produk.</p>
        @endforelse

    </div>
</div>

@endsection
