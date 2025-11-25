@extends('admin.template')

@section('content')

<style>

    /* ===============================
        BOX HASIL PENCARIAN
    ================================ */
    .search-result-box {
        max-width: 650px;
        margin: 20px auto;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        padding: 18px;
        position: relative;
        z-index: 10;
    }

    @media(max-width: 768px) {
        .search-result-box {
            max-width: 90%;
            padding: 15px;
            border-radius: 12px;
        }
    }

    /* ===============================
        ITEM PRODUK
    ================================ */
    .search-item {
        display: flex;
        gap: 14px;
        padding: 12px;
        border-radius: 10px;
        text-decoration: none;
        transition: 0.15s;
        border: 1px solid #f0f0f0;
        background: #ffffff;
        align-items: center;
    }

    .search-item:hover {
        background: #f9f9f9;
        transform: translateX(4px);
    }

    /* ===============================
        GAMBAR PRODUK RESPONSIVE
    ================================ */
    .search-item img {
        width: 55px;
        height: 55px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }

    @media(max-width: 480px) {
        .search-item img {
            width: 48px;
            height: 48px;
        }
    }

    /* ===============================
        TEXT PRODUK
    ================================ */
    .search-title {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 4px;
        color: #111;
        line-height: 1.2;
    }

    .search-sub {
        color: #666;
        font-size: 13px;
        margin-bottom: 2px;
        line-height: 1.2;
    }

    .search-price {
        font-size: 15px;
        font-weight: 700;
        color: #16a34a;
        margin-top: 3px;
    }

    /* Text container agar tidak tumpang tindih */
    .search-text {
        flex: 1;
        min-width: 0;
    }

</style>


@if($q)
<div class="search-result-box">

    <div class="mb-2 text-muted" style="font-size:13px;">
        Hasil pencarian untuk: <strong>"{{ $q }}"</strong>
    </div>

    @forelse($produk as $p)
    <a href="#" class="search-item">

        {{-- Fallback jika gambar null --}}
        @php
            $img = $p->gambarProduks->first()->gambar ?? 'no-image.png';
        @endphp

        <img src="{{ asset('storage/' . $img) }}">

        <div class="search-text">
            <div class="search-title">{{ $p->nama_produk }}</div>
            <div class="search-sub">{{ $p->kategori->nama_kategori ?? '-' }}</div>
            <div class="search-price">
                Rp {{ number_format($p->harga,0,',','.') }}
            </div>
        </div>

    </a>
    @empty

    <div class="text-center text-muted py-3">
        Tidak ada hasil ditemukan.
    </div>

    @endforelse

</div>
@endif

@endsection
