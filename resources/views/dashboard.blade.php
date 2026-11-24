@extends('layout')

@section('content')

<style>
    .dash-top {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
    margin-bottom: 16px;
}

.stat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

    .stat-card {
        min-height: 130px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    .stat-number {
        font-size: 30px;
        font-weight: bold;
        line-height: 1.1;
    }

    .stat-label {
        margin-top: 6px;
        font-size: 14px;
        color: var(--muted, #7b8794);
    }

    .ui-card-accent .stat-label {
        color: white;
    }

    @media (max-width: 900px) {
        .dash-top {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dash-top">

    <!-- KARTU STATISTIK -->
    <div class="stat-grid">

        <div class="ui-card ui-card-accent stat-card">
            <div class="stat-number">
                {{ number_format((int) $totalStok, 0, ',', '.') }}
            </div>
            <div class="stat-label">Total Stok</div>
        </div>

        <div class="ui-card stat-card">
            <div class="stat-number">
                {{ number_format((int) $barangMasuk, 0, ',', '.') }}
            </div>
            <div class="stat-label">Barang Masuk</div>
        </div>

        <div class="ui-card stat-card">
            <div class="stat-number">
                {{ number_format((int) $barangKeluar, 0, ',', '.') }}
            </div>
            <div class="stat-label">Barang Keluar</div>
        </div>

        <div class="ui-card stat-card">
            <div class="stat-number">
                {{ number_format((int) $totalProduk, 0, ',', '.') }}
            </div>
            <div class="stat-label">Total Produk</div>
        </div>

    </div>

    <!-- GRAFIK: langkah berikutnya -->

</div>

@endsection