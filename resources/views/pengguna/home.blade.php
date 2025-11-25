@extends('pengguna.template')
@section('content')

<style>
    /* ================================
        KATEGORI
    ================================= */
    .kategori-box {
        border-radius: 10px;
        border: 1px solid #eee;
        padding: 15px;
        transition: 0.2s;
        text-align: center;
        cursor: pointer;
        background: white;
    }
    .kategori-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* ================================
        PRODUK CARD
    ================================= */
    .product-card {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #eaeaea;
        transition: .2s;
        background: white;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 3px 12px rgba(0,0,0,0.15);
    }

    .produk-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #f8f8f8;
    }

    .product-title {
        font-size: 15px;
        font-weight: 600;
    }

    .product-price {
        color: #4CAF50;
        font-weight: 700;
        margin-bottom: 6px;
    }

    /* ================================
        HERO BOX
    ================================= */
    .hero-box {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        border: none;
    }

    .hero-box img {
        filter: drop-shadow(0 5px 10px rgba(0,0,0,0.2));
    }

    @media(max-width: 768px) {
        .produk-image {
            height: 150px;
        }
    }
</style>

<!-- ================================
    HERO SECTION
================================ -->
<div class="container mt-4">
    <div class="hero-box p-4 p-md-5 d-flex align-items-center rounded-4">
        <div>
            <h2 class="fw-bold mb-2">Selamat Datang di TokoSekolah 🎒</h2>
            <p class="mb-0 fs-5">
                Belanja makanan, minuman, dan perlengkapan sekolah dengan mudah & cepat.
            </p>
        </div>

        <div class="ms-auto d-none d-md-block">
            <img src="https://cdn-icons-png.flaticon.com/512/3081/3081870.png"
                 width="130">
        </div>
    </div>
</div>

<!-- ================================
    KATEGORI
================================ -->
<div class="container mt-4">
    <h4 class="fw-bold mb-3">Kategori</h4>

    <div class="row g-3">

        <!-- MAKANAN -->
        <div class="col-4">
            <a href="{{ route('pengguna.produk', ['kategori' => '1']) }}"
               class="text-decoration-none text-dark">
                <div class="kategori-box">
                    <i class="fa-solid fa-burger fa-2x mb-2 text-success"></i>
                    <h6>Makanan</h6>
                </div>
            </a>
        </div>

        <!-- MINUMAN -->
        <div class="col-4">
            <a href="{{ route('pengguna.produk', ['kategori' => '2']) }}"
               class="text-decoration-none text-dark">
                <div class="kategori-box">
                    <i class="fa-solid fa-mug-saucer fa-2x mb-2 text-success"></i>
                    <h6>Minuman</h6>
                </div>
            </a>
        </div>

        <!-- ALAT TULIS -->
        <div class="col-4">
            <a href="{{ route('pengguna.produk', ['kategori' => '3']) }}"
               class="text-decoration-none text-dark">
                <div class="kategori-box">
                    <i class="fa-solid fa-pencil fa-2x mb-2 text-success"></i>
                    <h6>Alat Tulis</h6>
                </div>
            </a>
        </div>

    </div>
</div>

<!-- ================================
    PRODUK TERBARU
================================ -->
<div class="container mt-5">
    <h4 class="fw-bold mb-3">Produk Terbaru</h4>

    <div class="row g-3">
        @foreach($produk as $p)
        <div class="col-6 col-md-3">
            <a href="{{ route('produk.detail', $p->id) }}" class="text-decoration-none text-dark">
                <div class="product-card">

                    @if($p->gambarProduks->first())
                        <img src="{{ asset('storage/'.$p->gambarProduks->first()->gambar) }}"
                             class="produk-image" alt="">
                    @else
                        <img src="{{ asset('no-image.png') }}" class="produk-image" alt="">
                    @endif

                    <div class="p-2">
                        <div class="product-title">{{ $p->nama_produk }}</div>
                        <div class="product-price">
                            Rp {{ number_format($p->harga, 0, ',', '.') }}
                        </div>

                        <small class="text-muted">Stok: {{ $p->stok }}</small>
                    </div>

                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection
