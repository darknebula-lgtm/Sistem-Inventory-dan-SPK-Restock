@extends('layout')

@section('content')

<style>
    .card {
        max-width: 600px;
        margin: auto;
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    h2 {
        margin-bottom: 20px;
        color: #0f766e;
        text-align: center;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
    }

    input:focus, select:focus {
        border-color: #0f766e;
    }

    .btn {
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        color: white;
    }

    .btn-simpan {
        background: #0f766e;
    }

    .btn-kembali {
        background: #7f8c8d;
        margin-top: 10px;
        display: block;
        text-align: center;
        text-decoration: none;
    }

    .btn:hover {
        opacity: 0.9;
    }
</style>

<div class="card">
    <h2>Tambah Produk</h2>

    <form action="/produk" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id_kategori }}">
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" required>
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" required>
        </div>

        <button type="submit" class="btn btn-simpan">Simpan</button>
        <a href="/produk" class="btn btn-kembali">Kembali</a>
    </form>
</div>

@endsection