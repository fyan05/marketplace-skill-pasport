@extends('admin.template')
@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold mb-4">Dashboard Koperasi Sekolah</h4>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0 bg-success text-white">
                <div class="card-body">
                    <h6>Total Produk</h6>
                    <h3>{{ $totalProduk }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0 bg-primary text-white">
                <div class="card-body">
                    <h6>Total Kategori</h6>
                    <h3>{{ $totalKategori }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0 bg-warning text-dark">
                <div class="card-body">
                    <h6>Total Toko</h6>
                    <h3>{{ $totalToko }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0 bg-danger text-white">
                <div class="card-body">
                    <h6>Total User</h6>
                    <h3>{{ $totalUser }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- GRAFIK & PRODUK TERBARU --}}
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Jumlah Produk per Kategori</h6>
                    <canvas id="produkKategoriChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Produk Terbaru</h6>
                    <ul class="list-group list-group-flush">
                        @foreach ($produkTerbaru as $p)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $p->nama_produk }}</span>
                                {{ \Carbon\Carbon::parse($p->tanggal_upload)->format('d M Y') }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('produkKategoriChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($namaKategori) !!},
            datasets: [{
                label: 'Jumlah Produk',
                data: {!! json_encode($jumlahProdukPerKategori) !!},
                backgroundColor: 'rgba(46, 125, 50, 0.8)',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection
