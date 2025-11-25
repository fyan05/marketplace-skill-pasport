@extends('pengguna.template')
@section('content')

<style>

    /* ===============================
        CONTAINER BIAR RAPI & TENGAH
    ================================ */
    .produk-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 16px;
    }

    /* ===============================
        CARD PRODUK
    ================================ */
    .produk-card {
        border-radius: 14px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        transition: .2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .produk-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    /* ===============================
        GAMBAR PRODUK RESPONSIVE
    ================================ */
    .produk-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        background: #f3f4f6;
    }

    @media(max-width: 768px) {
        .produk-img {
            height: 140px;
        }
    }

    @media(max-width: 480px) {
        .produk-img {
            height: 120px;
        }
    }

    /* ===============================
        BADGE READY
    ================================ */
    .badge-status {
        background: #22c55e;
        color: #fff;
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 6px;
        position: absolute;
        top: 8px;
        left: 8px;
        z-index: 5;
    }

    /* ===============================
        NAMA PRODUK & HARGA
    ================================ */
    .produk-title {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
        min-height: 34px;
        line-height: 17px;
    }

    .price {
        font-size: 15px;
        font-weight: bold;
        color: #16a34a;
        margin-bottom: 8px;
    }

    /* ===============================
        TOMBOL DETAIL
    ================================ */
    .btn-detail {
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        padding: 7px 0;
        background: #16a34a;
        color: white !important;
        width: 100%;
        border: none;
        margin-top: auto;
        text-align: center;
        display: block;
    }

    .btn-detail:hover {
        background: #15803d;
    }

</style>

<div class="produk-container">

    {{-- Judul kategori --}}
    @if($kategori)
    <h5 class="fw-bold mb-3">
        Produk {{ $produk->first()?->kategori?->nama_kategori ?? '' }}
    </h5>
    @endif

    <div class="row gy-3 gx-3">

        @foreach ($produk as $p)
        <div class="col-6 col-md-4 col-lg-3"> {{-- Mobile:2 | Tablet:3 | Desktop:4 --}}
            <div class="card produk-card position-relative">

                <span class="badge-status">Ready</span>

                {{-- gambar aman jika null --}}
                @if ($p->gambarProduks->first())
                    <img src="{{ asset('storage/'.$p->gambarProduks->first()->gambar) }}" class="produk-img">
                @else
                    <img src="{{ asset('no-image.png') }}" class="produk-img">
                @endif

                <div class="card-body p-2 d-flex flex-column">

                    <div class="produk-title">{{ $p->nama_produk }}</div>

                    <div class="price">
                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                    </div>

                    <a href="{{ route('produk.detail', $p->id) }}" class="btn-detail">
                        Lihat Detail
                    </a>

                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

@endsection
