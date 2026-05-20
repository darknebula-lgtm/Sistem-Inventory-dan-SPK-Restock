@extends('layout')

@section('content')

<style>
    .card {
        max-width: 900px;
        margin: auto;
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        color: #0f766e;
        margin-bottom: 20px;
    }

    .form-row {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    select, input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        flex: 1;
    }

    .btn {
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        color: white;
    }

    .btn-add { background: #3498db; }
    .btn-simpan { background: #0f766e; width: 100%; margin-top: 15px; }
    .btn-hapus { background: #e74c3c; }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th {
        background: #0f766e;
        color: white;
        padding: 10px;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
</style>

<div class="card">
    <h2>Barang Masuk (Multi Input)</h2>

    <div class="form-row">

        <select id="kategori">
            <option value="">Kategori</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
            @endforeach
        </select>

        <select id="produk">
            <option value="">Pilih Produk</option>
        </select>

        <input type="date" id="tanggal">
        <input type="number" id="jumlah" placeholder="Jumlah">

        <button type="button" class="btn btn-add" onclick="tambahData()">Tambah</button>
    </div>

    <form action="/barang-masuk" method="POST">
        @csrf

        <table id="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <button type="submit" class="btn btn-simpan">Simpan Semua</button>
    </form>
</div>

<script>
let index = 0;

// 🔥 DATA PRODUK DARI BACKEND
const allProduk = @json($produk);

const kategoriSelect = document.getElementById('kategori');
const produkSelect = document.getElementById('produk');

// 🔥 FUNGSI UNTUK MEMBUAT TOAST JAVASCRIPT DINAMIS
function showToast(message, type = 'success') {
    let toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerText = message;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// 🔥 FILTER PRODUK SAAT PILIH KATEGORI
kategoriSelect.addEventListener('change', function () {
    let idKategori = this.value;

    produkSelect.innerHTML = '<option value="">Pilih Produk</option>';

    let filtered = allProduk.filter(p => p.id_kategori == idKategori);

    filtered.forEach(p => {
        let option = document.createElement('option');
        option.value = p.id_produk;
        option.textContent = p.nama_produk;
        produkSelect.appendChild(option);
    });
});

// 🔥 TAMBAH DATA
function tambahData() {
    let produk = document.getElementById('produk');
    let tanggal = document.getElementById('tanggal').value;
    let jumlah = document.getElementById('jumlah').value;

    // Ganti alert kaku dengan Toast Error
    if (!produk.value || !tanggal || !jumlah) {
        showToast('Lengkapi data terlebih dahulu!', 'error');
        return;
    }

    if (parseInt(jumlah) <= 0) {
        showToast('Jumlah barang masuk harus lebih dari 0!', 'error');
        return;
    }

    let table = document.querySelector('#table tbody');

    let row = `
        <tr>
            <td>
                ${produk.options[produk.selectedIndex].text}
                <input type="hidden" name="data[${index}][id_produk]" value="${produk.value}">
            </td>
            <td>
                ${tanggal}
                <input type="hidden" name="data[${index}][tanggal_masuk]" value="${tanggal}">
            </td>
            <td>
                ${jumlah}
                <input type="hidden" name="data[${index}][jumlah]" value="${jumlah}">
            </td>
            <td>
                <button type="button" class="btn btn-hapus" onclick="hapusRow(this)">Hapus</button>
            </td>
        </tr>
    `;

    table.innerHTML += row;
    index++;

    document.getElementById('jumlah').value = '';
    
    // Tampilkan Toast Sukses saat berhasil masuk tabel list temporary
    showToast('Berhasil menambahkan item ke tabel list.', 'success');
}

// 🔥 HAPUS ROW
function hapusRow(btn) {
    btn.closest('tr').remove();
    // Tampilkan Toast saat item dikeluarkan dari list antrean
    showToast('Item dihapus dari list.', 'error');
}
</script>

@endsection