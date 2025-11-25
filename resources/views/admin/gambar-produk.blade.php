@extends('admin.template')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-3">Manajemen Gambar Produk</h3>

    <div class="row">
        @foreach($gambar as $img)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <img src="{{ asset('storage/' . $img->gambar) }}"
                         class="card-img-top"
                         style="height: 150px; object-fit: cover;">

                    <div class="card-body text-center">

                        {{-- Button Edit --}}
                        <button class="btn btn-primary btn-sm w-100 mb-2"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $img->id }}">
                            <i class="fa fa-edit"></i> Edit
                        </button>

                        {{-- Button Delete --}}
                        <form action="{{ route('admin.gambar.delete', $img->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm w-100"
                                    onclick="return confirm('Hapus gambar ini?')">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            {{-- Modal Edit --}}
            <div class="modal fade" id="editModal{{ $img->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('admin.gambar.update', $img->id) }}"
                          method="POST"
                          enctype="multipart/form-data"
                          class="modal-content">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Gambar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <img src="{{ asset('storage/' . $img->gambar) }}"
                                 class="img-fluid mb-3 rounded">

                            <label class="form-label">Pilih Gambar Baru</label>
                            <input type="file" class="form-control" name="gambar" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        @endforeach
    </div>

</div>
@endsection
