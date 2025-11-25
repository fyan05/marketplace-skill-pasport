@extends('member.template')

@section('content')
<div class="container mt-4" style="max-width: 820px;">

    {{-- ===========================
        BELUM PUNYA TOKO
    ============================ --}}
    @if (!$toko)
        <div class="card border-0 shadow-sm p-4 rounded-4"
             style="background: #E9FBE7; border-left: 6px solid #03AC0E;">
            <div class="text-center">

                <i class="fa-solid fa-store-slash text-success" style="font-size: 70px;"></i>

                <h4 class="mt-3 fw-bold text-success">Anda Belum Memiliki Toko</h4>
                <p class="text-secondary">Buat toko Anda sekarang dan mulai berjualan.</p>

                <button class="btn px-4 py-2 rounded-pill text-white"
                        style="background: #03AC0E;"
                        data-bs-toggle="modal"
                        data-bs-target="#modalAdd">
                    <i class="fa-solid fa-plus"></i> Buat Toko
                </button>
            </div>
        </div>

    {{-- ===========================
        STATUS PENDING
    ============================ --}}
    @elseif ($toko->status == 'pending')
        <div class="card border-0 shadow-sm p-4 rounded-4"
             style="background: #FFF7DA; border-left: 6px solid #FFB800;">
            <div class="text-center">

                <i class="fa-solid fa-hourglass-half text-warning" style="font-size: 70px;"></i>

                <h4 class="mt-3 fw-bold text-warning">Toko Sedang Diverifikasi</h4>
                <p class="text-secondary">
                    Toko Anda masih <strong>pending</strong>.
                    Mohon tunggu proses verifikasi admin.
                </p>

            </div>
        </div>

    {{-- ===========================
        STATUS DITOLAK
    ============================ --}}
    @elseif ($toko->status == 'ditolak')
        <div class="card border-0 shadow-sm p-4 rounded-4"
             style="background: #FFE6E6; border-left: 6px solid #FF4D4D;">
            <div class="text-center">

                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 70px;"></i>

                <h4 class="mt-3 fw-bold text-danger">Toko Ditolak</h4>
                <p class="text-secondary">
                    Perbaiki data toko Anda dan ajukan ulang verifikasi.
                </p>

                <button class="btn btn-warning px-4 py-2 rounded-pill"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEdit">
                    <i class="fa-solid fa-pen-to-square"></i> Perbaiki Toko
                </button>

            </div>
        </div>

    {{-- ===========================
        PROFIL TOKO AKTIF
    ============================ --}}
    @else
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

            {{-- HEADER --}}
            <div class="p-3" style="background: #03AC0E;">
                <h4 class="text-white m-0">
                    <i class="fa-solid fa-store"></i> Profil Toko
                </h4>
            </div>

            <div class="row g-0 toko-row">

                {{-- FOTO TOKO --}}
                <div class="col-md-4 p-3 toko-col-left">
                    <img src="{{ asset('storage/fototoko/' . $toko->gambar) }}"
                         class="img-fluid rounded-4 w-100 toko-image"
                         style="object-fit: cover; height: 220px;">
                </div>

                {{-- DETAIL TOKO --}}
                <div class="col-md-8 p-4 toko-col-right">

                    <h3 class="fw-bold text-success mb-1">
                        {{ $toko->nama_toko }}
                    </h3>

                    <p class="text-muted mb-2">
                        <i class="fa-solid fa-user"></i>
                        Owner: <strong>{{ $user->nama }}</strong>
                    </p>

                    <p>
                        <strong>Deskripsi:</strong><br>
                        {{ $toko->deskripsi_toko }}
                    </p>

                    <p class="mb-2">
                        <strong><i class="fa-solid fa-phone"></i> Kontak:</strong><br>
                        {{ $toko->kontak_toko }}
                    </p>

                    <p>
                        <strong><i class="fa-solid fa-location-dot"></i> Alamat:</strong><br>
                        {{ $toko->alamat_toko }}
                    </p>

                    <button class="btn rounded-pill text-white px-4"
                            style="background: #03AC0E;"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Toko
                    </button>

                </div>
            </div>
        </div>

    @endif
</div>

{{-- ===========================================
    MODAL BUAT TOKO
=========================================== --}}
<div class="modal fade" id="modalAdd" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('member.toko-post') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="fw-bold">
                        <i class="fa-solid fa-store"></i> Buat Toko Baru
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="fw-bold">Nama Toko</label>
                    <input type="text" name="nama_toko" class="form-control mb-2">

                    <label class="fw-bold">Deskripsi</label>
                    <textarea name="deskripsi_toko" class="form-control mb-2"></textarea>

                    <label class="fw-bold">Alamat</label>
                    <textarea name="alamat_toko" class="form-control mb-2"></textarea>

                    <label class="fw-bold">Kontak</label>
                    <input type="text" name="kontak_toko" class="form-control mb-2">

                    <label class="fw-bold">Gambar Toko</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- ===========================================
    MODAL EDIT TOKO
=========================================== --}}
@if ($toko)
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('member.toko-update', $toko->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="fw-bold">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Toko
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label class="fw-bold">Nama Toko</label>
                    <input type="text" name="nama_toko" value="{{ $toko->nama_toko }}" class="form-control mb-2">

                    <label class="fw-bold">Deskripsi</label>
                    <textarea name="deskripsi_toko" class="form-control mb-2">{{ $toko->deskripsi_toko }}</textarea>

                    <label class="fw-bold">Kontak</label>
                    <input type="text" name="kontak_toko" value="{{ $toko->kontak_toko }}" class="form-control mb-2">

                    <label class="fw-bold">Alamat</label>
                    <textarea name="alamat_toko" class="form-control mb-2">{{ $toko->alamat_toko }}</textarea>

                    <label class="fw-bold">Gambar Baru</label>
                    <input type="file" name="gambar" class="form-control mb-2">
                    <input type="hidden" name="id" value="{{ $toko->id }}">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Simpan Perubahan</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endif

{{-- ===========================================
    CSS RESPONSIVE TAMBAHAN
=========================================== --}}
<style>
    @media (max-width: 768px) {

        .container {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        .card {
            border-radius: 14px !important;
        }

        .toko-image {
            height: 180px !important;
            object-fit: cover !important;
        }

        .toko-row {
            display: flex;
            flex-direction: column;
        }

        .toko-col-left,
        .toko-col-right {
            width: 100% !important;
        }
    }

    @media (max-width: 992px) {
        .toko-image {
            height: 200px !important;
        }
    }
</style>

@endsection
