@extends('member.template')

@section('content')
<div class="container mt-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
        <h3 class="fw-bold mb-2 mb-md-0">
            <i class="fa-solid fa-box"></i> Daftar Produk
        </h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProdukModal">
            <i class="fa fa-plus"></i> Tambah Produk
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger"><i class="fa fa-times-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Produk</th>
                    <th width="15%">Kategori</th>
                    <th width="10%">Harga</th>
                    <th width="10%">Stok</th>
                    <th width="20%">Gambar</th>
                    <th width="13%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produks as $no => $p)
                <tr>
                    <td>{{ $no+1 }}</td>
                    <td class="fw-semibold">{{ $p->nama_produk }}</td>
                    <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                    <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                    <td>{{ $p->stok }}</td>

                    <td>
                        <div class="d-flex flex-wrap">
                            @foreach($p->gambarProduks as $g)
                            <img src="{{ asset('storage/'.$g->gambar) }}"
                                 width="60"
                                 class="me-1 mb-1 rounded border img-fluid">
                            @endforeach
                        </div>
                    </td>

                    <td>
                        <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editProduk{{ $p->id }}">
                            <i class="fa fa-edit"></i>
                        </button>

                        <form action="{{ route('member.produk-hapus', $p->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus produk ini?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                {{-- ========== MODAL EDIT PRODUK ========== --}}
                <div class="modal fade" id="editProduk{{ $p->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg">

                            <form action="{{ route('member.produk-update', $p->id) }}"
                                  method="POST" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')

                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title">
                                        <i class="fa fa-edit"></i> Edit Produk
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="fw-bold">Nama Produk</label>
                                        <input type="text" class="form-control" name="nama_produk"
                                               value="{{ $p->nama_produk }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Kategori</label>
                                        <select class="form-control" name="id_kategori" required>
                                            @foreach($kategori as $k)
                                                <option value="{{ $k->id }}" {{ $p->id_kategori == $k->id ? 'selected' : '' }}>
                                                    {{ $k->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Deskripsi</label>
                                        <textarea class="form-control" name="deskripsi" required>{{ $p->deskripsi }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Harga</label>
                                        <input type="number" class="form-control" name="harga" value="{{ $p->harga }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Stok</label>
                                        <input type="number" class="form-control" name="stok" value="{{ $p->stok }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Gambar Saat Ini:</label>
                                        <div class="d-flex flex-wrap">
                                            @foreach($p->gambarProduks as $g)
                                                <img src="{{ asset('storage/'.$g->gambar) }}"
                                                     width="60" class="me-1 mb-1 rounded border img-fluid">
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Tambah Gambar Baru</label>
                                        <input type="file" class="form-control" name="gambar[]" multiple>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                {{-- END MODAL EDIT --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>


{{-- ========== MODAL TAMBAH PRODUK ========== --}}
<div class="modal fade" id="addProdukModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">

            <form action="{{ route('member.produk-post') }}"
                  method="POST" enctype="multipart/form-data">

                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fa fa-plus-circle"></i> Tambah Produk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="fw-bold">Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Harga</label>
                        <input type="number" class="form-control" name="harga" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Stok</label>
                        <input type="number" class="form-control" name="stok" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Kategori</label>
                        <select class="form-control" name="id_kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="id_toko" value="{{ $toko->id }}">

                    <div class="mb-3">
                        <label class="fw-bold">Upload Gambar</label>
                        <input type="file" name="gambar[]" class="form-control" multiple>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>

                    <button type="submit" class="btn btn-primary">
                        Simpan Produk
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- Tambahkan CSS responsif khusus jika perlu --}}
@push('styles')
<style>
    @media (max-width: 767.98px) {
        .table-responsive {
            margin-bottom: 1rem;
        }
        .modal-lg {
            max-width: 95vw;
        }
        .modal-content {
            font-size: 0.95rem;
        }
        .table th, .table td {
            font-size: 0.95rem;
            padding: 0.5rem;
        }
        .d-flex.flex-wrap img {
            width: 48px !important;
        }
    }
    @media (max-width: 575.98px) {
        .modal-lg {
            max-width: 100vw;
        }
        .table th, .table td {
            font-size: 0.9rem;
            padding: 0.4rem;
        }
        .d-flex.flex-wrap img {
            width: 40px !important;
        }
    }
</style>
@endpush

@endsection
