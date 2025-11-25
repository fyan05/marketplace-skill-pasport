@extends('pengguna.template')
@section('title', $produk->nama_produk)

@section('content')

<style>
    /* ================================
        GAMBAR PRODUK
    ================================= */
    .main-image {
        width: 100%;
        height: 430px;
        object-fit: cover;
        border-radius: 12px;
    }
    .thumb-image {
        width: 100%;
        height: 90px;
        object-fit: cover;
        border-radius: 10px;
        cursor: pointer;
        transition: .2s;
        border: 2px solid transparent;
    }
    .thumb-image:hover {
        transform: scale(1.05);
        border-color: #0d6efd;
    }

    /* ================================
        CARD GLOBAL
    ================================= */
    .product-card {
        border-radius: 14px;
        padding: 25px;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,.08);
    }
    .price-box {
        padding: 15px;
        border-radius: 10px;
        background: #f5f7fa;
    }

    /* ================================
        RESPONSIVE
    ================================= */
    @media (max-width: 768px) {
        .main-image {
            height: 280px;
        }
        .thumb-image {
            height: 70px;
        }
        .product-card {
            padding: 18px;
        }
        h3 {
            font-size: 20px;
        }
        .price-box h2 {
            font-size: 22px;
        }
    }
</style>

<div class="container py-4">

    <div class="row g-4">

        {{-- LEFT: GAMBAR --}}
        <div class="col-md-6">

            {{-- GAMBAR UTAMA --}}
            <div class="product-card mb-3">
                <img id="mainImage"
                    src="{{ asset('storage/'.$produk->gambarProduks->first()->gambar) }}"
                    class="main-image shadow-sm">
            </div>

            {{-- THUMBNAIL --}}
            <div class="row g-2">
                @foreach($produk->gambarProduks as $g)
                <div class="col-4">
                    <img src="{{ asset('storage/'.$g->gambar) }}"
                        onclick="changeImage('{{ asset('storage/'.$g->gambar) }}')"
                        class="thumb-image shadow-sm">
                </div>
                @endforeach
            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-md-6">

            <div class="product-card">

                <h3 class="fw-bold">{{ $produk->nama_produk }}</h3>

                {{-- HARGA --}}
                <div class="price-box mt-3">
                    <h2 class="text-success fw-bold mb-0">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </h2>
                </div>

                {{-- STOK --}}
                <p class="mt-3 mb-1">
                    <i class="fa fa-box text-primary"></i>
                    Stok: <b>{{ $produk->stok }}</b>
                </p>

                <hr>

                {{-- DESKRIPSI --}}
                <h5 class="fw-bold">Deskripsi Produk</h5>
                <p class="text-secondary">{{ $produk->deskripsi }}</p>

                <hr>

                {{-- BOX TOKO --}}
                <div class="mt-4 p-3 rounded border bg-light">

                    <div class="d-flex align-items-center">

                        <img src="{{ asset('storage/fototoko/'.$produk->toko->gambar) }}"
                            width="60" height="60"
                            class="rounded-circle border shadow-sm me-3"
                            style="object-fit: cover;">

                        <div>
                            <h5 class="mb-0 fw-bold">{{ $produk->toko->nama_toko }}</h5>
                            <small class="text-success"></small>
                        </div>

                    </div>

                    <hr>

                    <p class="mb-1">
                        <i class="fa fa-phone text-primary"></i>
                        {{ $produk->toko->kontak_toko }}
                    </p>

                    <p class="mb-2">
                        <i class="fa fa-map-marker-alt text-danger"></i>
                        {{ $produk->toko->alamat_toko }}
                    </p>

                    <a href="{{ route('detail.toko', $produk->toko->id) }}"
                        class="btn btn-outline-primary w-100">
                        <i class="fa fa-store me-1"></i> Kunjungi Toko
                    </a>

                </div>

                {{-- TOMBOL WA --}}
                @php
                $wa = $produk->toko->kontak_toko;

                $text = urlencode("
                Halo, saya mau pesan:

                Produk : ".$produk->nama_produk."
                Harga  : Rp ".number_format($produk->harga, 0, ',', '.')."
                Jumlah :

                Nama :
                Alamat :

                Terima kasih.
                ");
                @endphp

                <a href="https://wa.me/{{ $wa }}?text={{ $text }}"
                    class="btn btn-success btn-lg w-100 mt-4 py-2">
                    <i class="fab fa-whatsapp me-2"></i> Beli via WhatsApp
                </a>

            </div>

        </div>

    </div>


    {{-- ================
        ULASAN
    ================= --}}
    <div class="mt-5">

        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Ulasan Pembeli</h4>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalReview">
                <i class="fa fa-pen"></i> Tulis Ulasan
            </button>
        </div>

        <hr>

        @forelse($produk->reviews as $r)
        <div class="p-3 border rounded mb-3 bg-light">

            <div class="d-flex justify-content-between">
                <strong>{{ $r->nama }}</strong>
                <small class="text-muted">{{ $r->created_at->format('d M Y') }}</small>
            </div>

            <div class="text-warning mb-2">
                @for($i=1; $i<=5; $i++)
                    <i class="fa fa-star{{ $i <= $r->rating ? '' : '-o' }}"></i>
                @endfor
            </div>

            <p>{{ $r->ulasan }}</p>

            @if($r->foto)
            <img src="{{ asset('storage/fotoreview/'.$r->foto) }}"
                width="130" class="rounded shadow-sm">
            @endif

        </div>
        @empty
        <p class="text-muted">Belum ada ulasan.</p>
        @endforelse

    </div>

</div>


{{-- ========================
    MODAL ULASAN
======================== --}}
<div class="modal fade" id="modalReview" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('review.post', $produk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tulis Ulasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Rating</label>
                        <select name="rating" class="form-select" required>
                            <option value="">Pilih Rating</option>
                            @for($i=5; $i>=1; $i--)
                                <option value="{{ $i }}">{{ $i }} ⭐</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Ulasan</label>
                        <textarea name="ulasan" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Foto (opsional)</label>
                        <input type="file" name="foto" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success">Kirim Ulasan</button>
                </div>

            </form>

        </div>
    </div>
</div>


<script>
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }
</script>

@endsection
