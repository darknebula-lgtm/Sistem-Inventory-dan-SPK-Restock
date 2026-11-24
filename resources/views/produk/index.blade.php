@extends('layout')

@section('content')

<style>
    .page-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .page-title {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
    }

    .search-info {
        margin: -6px 0 16px;
        font-size: 13px;
        color: var(--muted, #7b8794);
    }

    .search-info a {
        margin-left: 6px;
        color: var(--teal, #0f5c4d);
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

    .btn-edit {
        background: #dcf7ee;
        color: #0f7a5a;
    }

    .btn-hapus {
        background: #fde2e2;
        color: #b42318;
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

    .tbl tbody tr:hover {
        background: #f6f9f8;
    }

    .tbl .col-no {
        width: 60px;
    }

    .tbl .col-aksi {
        width: 200px;
    }

    .tbl .num {
        text-align: right;
    }

    .tbl td.empty-row {
        padding: 30px;
        text-align: center;
        color: var(--muted, #7b8794);
    }

    .aksi {
        display: flex;
        gap: 8px;
    }

    .aksi form {
        margin: 0;
    }
</style>

<div class="ui-card">

    <div class="page-head">
        <h2 class="page-title">Produk</h2>

        <a href="/produk/create" class="btn-pill btn-tambah">
            <i class="ti ti-plus"></i> Tambah
        </a>
    </div>

    @if(request('search'))
        <p class="search-info">
            Hasil pencarian: <strong>{{ request('search') }}</strong>
            <a href="/produk">Reset</a>
        </p>
    @endif

    <table class="tbl">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th class="num">Harga</th>
                <th class="num">Stok</th>
                <th class="col-aksi">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->nama_produk }}</td>
                    <td>{{ $d->kategori->nama_kategori ?? '-' }}</td>
                    <td class="num">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                    <td class="num">{{ $d->stok }}</td>
                    <td>
                        <div class="aksi">
                            <a href="/produk/{{ $d->id_produk }}/edit"
                               class="btn-pill btn-edit">
                                <i class="ti ti-pencil"></i> Edit
                            </a>

                            <form action="/produk/{{ $d->id_produk }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-pill btn-hapus"
                                        onclick="return confirm('Yakin hapus data?')">
                                    <i class="ti ti-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-row">
                        {{ request('search') ? 'Produk tidak ditemukan.' : 'Belum ada produk.' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection