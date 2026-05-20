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

    .btn-update {
        background: #3498db;
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
    <h2>Edit Produk</h2>

    <form action="/produk/{{ $data->id_produk }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" value="{{ $data->nama_produk }}" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id_kategori }}"
                        {{ $data->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" value="{{ $data->harga }}" required>
        </div>


        <button type="submit" class="btn btn-update">Update</button>
        <a href="/produk" class="btn btn-kembali">Kembali</a>
    </form>
</div>

@endsection