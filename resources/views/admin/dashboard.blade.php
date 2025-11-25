@extends('admin.template')

@section('content')
<div class="container py-4">

    {{-- 🔷 STATISTIK ATAS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card text-center shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="fa-solid fa-utensils"></i>
                    <h6 class="text-muted mb-1">Total Produk</h6>
                    <h3 class="fw-bold text-success">{{ $totalProduk }}</h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card text-center shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="fa fa-tags"></i>
                    <h6 class="text-muted mb-1">Total Kategori</h6>
                    <h3 class="fw-bold text-primary">{{ $totalKategori }}</h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card text-center shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="fa fa-users"></i>
                    <h6 class="text-muted mb-1">Total User</h6>
                    <h3 class="fw-bold text-warning">{{ $totalUser }}</h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card text-center shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="fa fa-store"></i>
                    <h6 class="text-muted mb-1">Total Toko</h6>
                    <h3 class="fw-bold text-danger">{{ $totalToko }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔶 GRAFIK & PRODUK TERBARU --}}
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Distribusi Produk per Kategori</h6>
                    <div class="w-100" style="overflow-x:auto;">
                        <canvas id="produkKategoriChart" height="60" style="max-height:250px;min-width:200px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Produk Terbaru</h6>
                    <ul class="list-group list-group-flush small">
                        @forelse ($produkTerbaru as $p)
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span>{{ $p->nama_produk }}</span>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal_upload)->format('d M Y') }}</small>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Belum ada produk</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔷 PRODUK STOK TERTINGGI & TERENDAH --}}
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Produk Stok Tertinggi</h6>
                    @if ($produkStokTinggi)
                        <p class="mb-1 fw-bold">{{ $produkStokTinggi->nama_produk }}</p>
                        <p class="text-success">Stok: {{ $produkStokTinggi->stok }}</p>
                    @else
                        <p class="text-muted">Tidak ada data.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Produk Stok Terendah</h6>
                    @if ($produkStokRendah)
                        <p class="mb-1 fw-bold">{{ $produkStokRendah->nama_produk }}</p>
                        <p class="text-danger">Stok: {{ $produkStokRendah->stok }}</p>
                    @else
                        <p class="text-muted">Tidak ada data.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- 🔴 DAFTAR PRODUK STOK MENIPIS --}}
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-body">
            <h6 class="fw-semibold mb-3">Produk dengan Stok Menipis (≤ 5)</h6>
            @if ($produkStokRendahList->isEmpty())
                <p class="text-muted">Semua produk memiliki stok aman.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Stok</th>
                                <th>Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produkStokRendahList as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->nama_produk }}</td>
                                    <td><span class="badge bg-danger">{{ $p->stok }}</span></td>
                                    <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- 🟣 SCRIPT CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('produkKategoriChart');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($namaKategori) !!},
        datasets: [{
            data: {!! json_encode($jumlahProdukPerKategori) !!},
            backgroundColor: [
                '#4CAF50', '#2196F3', '#FFC107', '#FF5722', '#9C27B0',
                '#00BCD4', '#8BC34A', '#FF9800', '#E91E63', '#3F51B5'
            ],
            borderWidth: 1,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            title: { display: false },
        }
    }
});
</script>
<style>
@media (max-width: 767.98px) {
    .card-body h3 {
        font-size: 1.3rem;
    }
    .table-responsive {
        font-size: 0.95rem;
    }
}
</style>
@endsection
