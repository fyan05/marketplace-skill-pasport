@extends('admin.template')

@section('content')
<div class="container mt-4">
    <h3>Daftar Produk</h3>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProdukModal">+ Tambah Produk</button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Toko</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produks as $no => $p)
                    <tr>
                        <td>{{ $no+1 }}</td>
                        <td>{{ $p->toko->nama_toko ?? '-' }}</td>
                        <td>{{ $p->nama_produk }}</td>
                        <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                        <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td>{{ $p->stok }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($p->gambarProduks as $g)
                                    <img src="{{ asset('storage/'.$g->gambar) }}" style="width:80px; height:80px; object-fit:cover; border-radius:8px; border:1px solid #ddd;" class="shadow-sm img-fluid">
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editProduk{{ $p->id }}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.produk-delete', $p->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus produk ini?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- MODAL EDIT PRODUK --}}
                    <div class="modal fade" id="editProduk{{ $p->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                            <form action="{{ route('admin.produk-update',$p->id) }}" method ="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                <h5 class="modal-title">Edit Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="id" value="{{ $p->id }}">
                                <div class="row g-2">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label>Nama Produk</label>
                                        <input type="text" class="form-control" name="nama_produk" value="{{ $p->nama_produk }}">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label>Kategori</label>
                                        <select class="form-control" name="id_kategori">
                                            @foreach($kategori as $k)
                                                <option value="{{ $k->id }}" {{ $p->id_kategori == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control" name="deskripsi">{{ $p->deskripsi }}</textarea>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label>Harga</label>
                                        <input type="number" class="form-control" name="harga" value="{{ $p->harga }}">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label>Stok</label>
                                        <input type="number" class="form-control" name="stok" value="{{ $p->stok }}">
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label>Toko</label>
                                        <select class="form-control" name="id_toko">
                                            @foreach($toko as $t)
                                                <option value="{{ $t->id }}" {{ $p->id_toko == $t->id ? 'selected' : '' }}>{{ $t->nama_toko }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label>Gambar Produk (tambahkan jika ingin menambah)</label>
                                        <input type="file" class="form-control" name="gambar[]" multiple>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Gambar Saat Ini:</label>
                                        <div class="d-flex flex-wrap">
                                            @foreach($p->gambarProduks as $g)
                                                <img src="{{ asset('storage/'.$g->gambar) }}" width="60" class="me-1 mb-1 rounded img-fluid">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- tambah --}}
<div class="modal fade" id="addProdukModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form action="{{ route('admin.produk-store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-2">
            <div class="col-12 col-md-6 mb-2">
              <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk" required>
            </div>
            <div class="col-12 col-md-6 mb-2">
              <input type="number" name="harga" class="form-control" placeholder="Harga" required>
            </div>
            <div class="col-12 mb-2">
              <textarea name="deskripsi" class="form-control" placeholder="Deskripsi" required></textarea>
            </div>
            <div class="col-12 col-md-6 mb-2">
              <input type="number" name="stok" class="form-control" placeholder="Stok" required>
            </div>
            <div class="col-12 col-md-6 mb-2">
              <select name="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                  <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-md-6 mb-2">
              <select name="id_toko" class="form-control" required>
                <option value="">-- Pilih Toko --</option>
                @foreach($toko as $t)
                  <option value="{{ $t->id }}">{{ $t->nama_toko }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 mb-2">
              <label>Upload Gambar (bisa lebih dari satu):</label>
              <input type="file" name="gambar[]" class="form-control" multiple>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
