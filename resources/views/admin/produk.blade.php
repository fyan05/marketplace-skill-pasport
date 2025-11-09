@extends('admin.template')

@section('content')
<div class="container mt-4">
    <h3>Daftar Produk</h3>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProdukModal">+ Tambah Produk</button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
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
                    <td>{{ $p->nama_produk }}</td>
                    <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                    <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                    <td>{{ $p->stok }}</td>
                    <td>
                        <div class="d-flex flex-wrap">
                            @foreach($p->gambarProduks as $g)
                                <img src="{{ asset('storage/'.$g->gambar) }}" width="60" class="me-1 mb-1 rounded">
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <!-- Tombol Edit -->
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editProduk{{ $p->id }}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <!-- Tombol Hapus -->
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
                    <div class="modal-dialog modal-lg">
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
                            <div class="mb-3">
                                <label>Nama Produk</label>
                                <input type="text" class="form-control" name="nama_produk" value="{{ $p->nama_produk }}">
                            </div>
                            <div class="mb-3">
                                <label>Kategori</label>
                                <select class="form-control" name="id_kategori">
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}" {{ $p->id_kategori == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="deskripsi">{{ $p->deskripsi }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label>Harga</label>
                                <input type="number" class="form-control" name="harga" value="{{ $p->harga }}">
                            </div>
                            <div class="mb-3">
                                <label>Stok</label>
                                <input type="number" class="form-control" name="stok" value="{{ $p->stok }}">
                            </div>
                            <div class="mb-3">
                                <label>Toko</label>
                                <select class="form-control" name="id_toko">
                                    @foreach($toko as $t)
                                        <option value="{{ $t->id }}" {{ $p->id_toko == $t->id ? 'selected' : '' }}>{{ $t->nama_toko }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Gambar Produk (tambahkan jika ingin menambah)</label>
                                <input type="file" class="form-control" name="gambar[]" multiple>
                            </div>
                            <div class="mb-3">
                                <label>Gambar Saat Ini:</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($p->gambarProduks as $g)
                                        <img src="{{ asset('storage/'.$g->gambar) }}" width="60" class="me-1 mb-1 rounded">
                                    @endforeach
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
                </div>
            @endforeach
        </tbody>
    </table>
</div>
{{-- tambah --}}
<div class="modal fade" id="addProdukModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('admin.produk-store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="nama_produk" class="form-control mb-2" placeholder="Nama Produk" required>
          <textarea name="deskripsi" class="form-control mb-2" placeholder="Deskripsi" required></textarea>
          <input type="number" name="harga" class="form-control mb-2" placeholder="Harga" required>
          <input type="number" name="stok" class="form-control mb-2" placeholder="Stok" required>

          <select name="id_kategori" class="form-control mb-2" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategori as $k)
              <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
            @endforeach
          </select>

          <select name="id_toko" class="form-control mb-2" required>
            <option value="">-- Pilih Toko --</option>
            @foreach($toko as $t)
              <option value="{{ $t->id }}">{{ $t->nama_toko }}</option>
            @endforeach
          </select>

          <label>Upload Gambar (bisa lebih dari satu):</label>
          <input type="file" name="gambar[]" class="form-control" multiple>
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
