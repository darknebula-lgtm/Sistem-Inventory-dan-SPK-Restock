@extends('layout')

@section('content')

<style>
    .page-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .page-title {
        margin: 0;
        font-size: 20px;
        font-weight: bold;
    }

    .btn-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        font: inherit;
        font-size: 13px;
        text-decoration: none;
        border: none;
        border-radius: 999px;
        cursor: pointer;
    }

    .btn-pill:hover {
        opacity: 0.85;
    }

    .btn-tambah {
        background: var(--teal, #0f5c4d);
        color: white;
    }

    .group-card {
        margin-bottom: 16px;
    }

    .group-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }

    .group-date {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        font-size: 16px;
        font-weight: bold;
    }

    .group-date i {
        font-size: 20px;
        color: var(--orange, #ee7035);
    }

    .tbl {
        width: 100%;
        border-collapse: collapse;
    }

    .tbl th {
        padding: 12px 10px;
        font-size: 13px;
        text-align: left;
        border-bottom: 1px solid var(--line, #cfd8d5);
    }

    .tbl td {
        padding: 14px 10px;
        font-size: 14px;
        border-bottom: 1px solid #eef2f1;
    }

    .tbl tbody tr:last-child td {
        border-bottom: none;
    }

    .tbl tbody tr:hover {
        background: #f6f9f8;
    }

    .tbl .col-no {
        width: 60px;
    }

    .tbl .num {
        text-align: right;
    }

    .empty-card {
        padding: 40px 22px;
        text-align: center;
        color: var(--muted, #7b8794);
    }
</style>

<div class="page-head">
    <h2 class="page-title">Barang Keluar</h2>

    <a href="/barang-keluar/create" class="btn-pill btn-tambah">
        <i class="ti ti-plus"></i> Tambah
    </a>
</div>

@php
    $grouped = $data->sortByDesc('tanggal_keluar')->groupBy('tanggal_keluar');
@endphp

@forelse($grouped as $tanggal => $items)

    @php
        $total = $items->sum('jumlah');
    @endphp

    <div class="ui-card group-card">

        <div class="group-head">
            <h3 class="group-date">
                <i class="ti ti-calendar"></i>
                {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}
            </h3>

            <span class="ui-badge warning">
                Total keluar: {{ number_format($total, 0, ',', '.') }}
            </span>
        </div>

        <table class="tbl">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th>Produk</th>
                    <th class="num">Jumlah</th>
                </tr>
            </thead>

            <tbody>
                @foreach($items as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->produk->nama_produk ?? '-' }}</td>
                        <td class="num">{{ number_format($d->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@empty

    <div class="ui-card empty-card">
        Belum ada data barang keluar.
    </div>

@endforelse

@endsection