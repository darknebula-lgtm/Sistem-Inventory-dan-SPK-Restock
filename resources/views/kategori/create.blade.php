@extends('layout')

@section('content')

<style>
    .card {
        max-width: 500px;
        margin: 50px auto; /* Memberi jarak atas bawah agar posisi lebih seimbang */
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    h2 {
        margin-bottom: 25px;
        color: #0f766e;
        text-align: center;
        font-weight: 700;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        outline: none;
        box-sizing: border-box; /* Mencegah input meluber keluar card */
        transition: all 0.3s ease;
    }

    input:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15); /* Efek glow lembut saat diklik */
    }

    /* 🔥 CONTAINER UNTUK TOMBOL AGAR SEJAJAR */
    .btn-container {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        padding: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        text-align: center;
        text-decoration: none; /* Menghapus garis bawah pada tag <a> */
        flex: 1; /* Membuat kedua tombol memiliki lebar yang sama rata */
        display: inline-block;
        box-sizing: border-box;
        transition: background 0.2s ease;
    }

    .btn-simpan {
        background: #0f766e;
        color: white;
    }

    .btn-simpan:hover {
        background: #0d5c58;
    }

    .btn-kembali {
        background: #e2e8f0;
        color: #475569;
    }

    .btn-kembali:hover {
        background: #cbd5e1;
    }
</style>

<div class="card">
    <h2>Tambah Kategori</h2>

    <form action="/kategori" method="POST">
        @csrf

        <div class="form-group">
            <label for="nama_kategori">Nama Kategori</label>
            <input type="text" id="nama_kategori" name="nama_kategori" placeholder="Masukkan nama kategori..." required>
        </div>

        <div class="btn-container">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="/kategori" class="btn btn-kembali">Kembali</a>
        </div>
    </form>
</div>

@endsection