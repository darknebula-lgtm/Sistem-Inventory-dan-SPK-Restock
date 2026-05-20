@extends('layout')

@section('content')

<style>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .btn {
        padding: 8px 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        color: white;
        font-size: 14px;
    }

    .btn-tambah { background: #0f766e; }
    .btn-hapus { background: #e74c3c; }

    .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    h3 {
        margin-bottom: 10px;
        color: #0f766e;
    }

    .total {
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #0f766e;
        color: white;
        padding: 10px;
        text-align: left;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    tr:hover {
        background: #f2f2f2;
    }

    form {
        display: inline;
    }
</style>

<div class="header">
    <h2>Barang Masuk</h2>
    <a href="/barang-masuk/create" class="btn btn-tambah">+ Tambah</a>
</div>

@php
    $grouped = $data->sortByDesc('tanggal_masuk')->groupBy('tanggal_masuk');
@endphp

@foreach($grouped as $tanggal => $items)

@php
    $total = $items->sum('jumlah');
@endphp

<div class="card">

    <h3>Tanggal: {{ $tanggal }}</h3>
    <div class="total">Total Barang Masuk: {{ $total }}</div>

    <table>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Jumlah</th>
        </tr>

        @foreach($items as $index => $d)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $d->produk->nama_produk }}</td>
            <td>{{ $d->jumlah }}</td>
        </tr>
        @endforeach

    </table>

</div>
@endforeach

@endsection