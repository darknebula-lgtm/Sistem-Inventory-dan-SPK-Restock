@extends('layout')

@section('content')

<style>
    .form-card {
        max-width: 500px;
        margin: 20px auto;
        padding: 30px;
    }

    .form-title {
        margin: 0 0 25px;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
    }

    .form-input {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 16px;
        font: inherit;
        font-size: 14px;
        color: inherit;
        background: white;
        border: 1px solid var(--line, #cfd8d5);
        border-radius: 14px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-input:focus {
        border-color: var(--teal, #0f5c4d);
        box-shadow: 0 0 0 3px rgba(15, 92, 77, 0.15);
    }

    .field-error {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: #b42318;
    }

    /* CONTAINER UNTUK TOMBOL AGAR SEJAJAR */
    .btn-container {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .btn-form {
        flex: 1;
        box-sizing: border-box;
        padding: 12px;
        font: inherit;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        border: none;
        border-radius: 999px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-update {
        background: var(--teal, #0f5c4d);
        color: white;
    }

    .btn-update:hover {
        background: #0a4a3d;
    }

    .btn-kembali {
        background: #e9efed;
        color: #475569;
    }

    .btn-kembali:hover {
        background: #d8e2df;
    }
</style>

<div class="ui-card form-card">
    <h2 class="form-title">Edit Kategori</h2>

    <form action="/kategori/{{ $data->id_kategori }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" id="nama_kategori" name="nama_kategori"
                   class="form-input"
                   value="{{ old('nama_kategori', $data->nama_kategori) }}"
                   required>

            @error('nama_kategori')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="btn-container">
            <button type="submit" class="btn-form btn-update">Update</button>
            <a href="/kategori" class="btn-form btn-kembali">Kembali</a>
        </div>
    </form>
</div>

@endsection