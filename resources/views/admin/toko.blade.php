@extends('admin.template')

@section('content')

<div class="container">

    <h3 class="mb-4">Data Toko</h3>

    <!-- BUTTON TAMBAH -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Toko
    </button>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Pemilik</th>
                    <th>Deskripsi</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Gambar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($toko as $index => $t)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $t->nama_toko }}</td>
                    <td>{{ $t->user->nama }}</td>
                    <td class="text-truncate" style="max-width: 120px;">{{ $t->deskripsi_toko }}</td>
                    <td>{{ $t->kontak_toko }}</td>
                    <td class="text-truncate" style="max-width: 120px;">{{ $t->alamat_toko }}</td>
                    <td>
                        @if($t->gambar)
                            <img src="{{ asset('storage/fototoko/'.$t->gambar) }}" width="60" class="img-fluid rounded">
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                    <!-- STATUS -->
                    <td>
                        @if ($t->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif ($t->status == 'active')
                            <span class="badge bg-success">Active</span>
                        @elseif ($t->status == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm mb-1"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit{{ $t->id }}">
                            Edit
                        </button>
                        <a href="{{ route('admin.toko-delete', $t->id) }}" class="btn btn-danger btn-sm mb-1"
                           onclick="return confirm('Yakin hapus toko ini?')">
                            Hapus
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- ============================
     MODAL EDIT — DITARUH DI LUAR TABLE
============================= -->
@foreach ($toko as $t)
<div class="modal fade" id="modalEdit{{ $t->id }}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <form action="{{ route('admin.toko-update',$t->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5>Edit Toko</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-12 col-md-6 mb-3">
                            <label>Nama</label>
                            <input type="text" name="nama_toko" value="{{ $t->nama_toko }}" class="form-control">
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi_toko" class="form-control" rows="3">{{ $t->deskripsi_toko }}</textarea>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Kontak</label>
                            <input type="text" name="kontak_toko" value="{{ $t->kontak_toko }}" class="form-control">
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Alamat</label>
                            <input type="text" name="alamat_toko" value="{{ $t->alamat_toko }}" class="form-control">
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Gambar</label><br>
                            @if($t->gambar)
                                <img src="{{ asset('storage/fototoko/'.$t->gambar) }}" width="80" class="mb-2 img-fluid rounded">
                            @endif
                            <input type="file" name="gambar" class="form-control" value="{{ $t->gambar }}">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="pending"  {{ $t->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active"   {{ $t->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="ditolak"  {{ $t->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <form action="{{ route('admin.toko-store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5>Tambah Toko</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-12 col-md-6 mb-3">
                            <label>Nama Toko</label>
                            <input type="text" name="nama_toko" class="form-control">
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi_toko" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Kontak</label>
                            <input type="text" name="kontak_toko" class="form-control">
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Alamat</label>
                            <input type="text" name="alamat_toko" class="form-control">
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Gambar</label>
                            <input type="file" name="gambar" class="form-control">
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Pemilik (User)</label>
                            <select name="user_id" class="form-control">
                                @foreach ($user as $u)
                                <option value="{{ $u->id }}">{{ $u->nama }}</option>
                                @endforeach
                            </select>
                        </div>
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
