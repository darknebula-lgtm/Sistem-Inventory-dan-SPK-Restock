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

    .btn-tambah {
        background: #0f766e;
    }

    .btn-edit {
        background: #3498db;
    }

    .btn-hapus {
        background: #e74c3c;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
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

    .aksi {
        display: flex;
        gap: 5px;
    }

    form {
        display: inline;
    }
</style>

<div class="header">
    <h2>Kategori</h2>
    <a href="/kategori/create" class="btn btn-tambah">+ Tambah</a>
</div>

<div class="card">
    <table>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>

        @foreach($data as $index => $d)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $d->nama_kategori }}</td>
            <td class="aksi">
                <a href="/kategori/{{ $d->id_kategori }}/edit" class="btn btn-edit">Edit</a>

                <form action="/kategori/{{ $d->id_kategori }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-hapus" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>
</div>

@endsection