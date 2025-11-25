@extends('admin.template')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Kelola Kategori</h3>

    <!-- Tombol Tambah Kategori -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
        <i class="fa fa-plus"></i> Tambah Kategori
    </button>

    <!-- TABEL KATEGORI -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width:5%;">No</th>
                    <th>Nama Kategori</th>
                    <th style="width:20%;">Dibuat</th>
                    <th style="width:20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategoris as $index => $k)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $k->nama_kategori }}</td>
                    <td>{{ $k->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <!-- Tombol Edit -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editKategoriModal{{ $k->id }}">
                                <i class="fa fa-edit"></i>
                            </button>

                            <!-- Tombol Hapus -->
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteKategoriModal{{ $k->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- 🟡 Modal Edit -->
                <div class="modal fade" id="editKategoriModal{{ $k->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.kategori-update', $k->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="nama_kategori" class="form-control"
                                        value="{{ $k->nama_kategori }}" required>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 🔴 Modal Hapus -->
                <div class="modal fade" id="deleteKategoriModal{{ $k->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.kategori-delete', $k->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Hapus Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Yakin ingin menghapus <b>{{ $k->nama_kategori }}</b>?
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-danger" type="submit">Hapus</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- 🟢 Modal Tambah Kategori -->
<div class="modal fade" id="addKategoriModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.kategori-store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
