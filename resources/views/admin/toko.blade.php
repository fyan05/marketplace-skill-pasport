@extends('admin.template')

@section('content')

<div class="container">

    <h3 class="mb-4">Data Toko</h3>

    <!-- BUTTON TAMBAH -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Toko
    </button>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Kontak</th>
                <th>Alamat</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($toko as $index => $t)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $t->nama_toko }}</td>
                <td>{{ $t->deskripsi_toko }}</td>
                <td>{{ $t->kontak_toko }}</td>
                <td>{{ $t->alamat_toko }}</td>
                <td>
                    @if($t->gambar)
                        <img src="{{ asset('storage/fototoko/'.$t->gambar) }}" width="60">
                    @else
                        <span class="text-muted">Tidak ada</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEdit{{ $t->id }}">
                        Edit
                    </button>

                    <a href="{{ route('admin.toko-delete', $t->id) }}" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin hapus toko ini?')">
                        Hapus
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- ============================
     MODAL EDIT — DITARUH DI LUAR TABLE
============================= -->
@foreach ($toko as $t)
<div class="modal fade" id="modalEdit{{ $t->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.toko-memek',$t->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5>Edit Toko</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama_toko" value="{{ $t->nama_toko }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi_toko" class="form-control" rows="3">{{ $t->deskripsi_toko }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Kontak</label>
                        <input type="text" name="kontak_toko" value="{{ $t->kontak_toko }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat_toko" value="{{ $t->alamat_toko }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Gambar</label><br>
                        @if($t->gambar)
                            <img src="{{ asset('storage/fototoko/'.$t->gambar) }}" width="80" class="mb-2">
                        @endif
                        <input type="file" name="gambar" class="form-control" value="{{ $t->gambar }}">
                    </div>

                    <input type="hidden" name="user_id" value="{{ $t->user_id }}">
                    <input type="hidden" name="id" value="{{ $t->id }}">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach



<!-- ============================
     MODAL TAMBAH
============================= -->

<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.toko-store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5>Tambah Toko</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama Toko</label>
                        <input type="text" name="nama_toko" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi_toko" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Kontak</label>
                        <input type="text" name="kontak_toko" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat_toko" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Pemilik (User)</label>
                        <select name="user_id" class="form-control">
                            @foreach ($user as $u)
                            <option value="{{ $u->id }}">{{ $u->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
