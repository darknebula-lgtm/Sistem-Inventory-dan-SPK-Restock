@extends('layout')

@section('content')

<style>
    .form-card {
        max-width: 900px;
        margin: 20px auto;
        padding: 30px;
    }

    .form-title {
        margin: 0 0 25px;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .fld {
        flex: 1;
        min-width: 140px;
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

    .fld:focus {
        border-color: var(--teal, #0f5c4d);
        box-shadow: 0 0 0 3px rgba(15, 92, 77, 0.15);
    }

    .btn-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 18px;
        font: inherit;
        font-size: 13px;
        font-weight: bold;
        text-decoration: none;
        border: none;
        border-radius: 999px;
        cursor: pointer;
    }

    .btn-pill:hover {
        opacity: 0.85;
    }

    .btn-add {
        background: #dcf7ee;
        color: #0f7a5a;
    }

    .btn-hapus {
        padding: 7px 14px;
        background: #fde2e2;
        color: #b42318;
    }

    .btn-simpan {
        width: 100%;
        margin-top: 20px;
        padding: 13px;
        font-size: 14px;
        background: var(--teal, #0f5c4d);
        color: white;
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
        padding: 12px 10px;
        font-size: 14px;
        border-bottom: 1px solid #eef2f1;
    }
</style>

<div class="ui-card form-card">
    <h2 class="form-title">Barang Masuk (Multi Input)</h2>

    <div class="form-row">

        <select id="kategori" class="fld">
            <option value="">Kategori</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
            @endforeach
        </select>

        <select id="produk" class="fld">
            <option value="">Pilih Produk</option>
        </select>

        <input type="date" id="tanggal" class="fld">
        <input type="number" id="jumlah" class="fld" min="1" placeholder="Jumlah">

        <button type="button" class="btn-pill btn-add" onclick="tambahData()">
            <i class="ti ti-plus"></i> Tambah
        </button>
    </div>

    <form id="form-masuk" action="/barang-masuk" method="POST">
        @csrf

        <table id="table" class="tbl">
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

        <button type="submit" class="btn-pill btn-simpan">Simpan Semua</button>
    </form>
</div>

<script>
    let index = 0;

    // DATA PRODUK DARI BACKEND
    const allProduk = @json($produk);

    const kategoriSelect = document.getElementById('kategori');
    const produkSelect = document.getElementById('produk');
    const tanggalInput = document.getElementById('tanggal');
    const jumlahInput = document.getElementById('jumlah');
    const tbody = document.querySelector('#table tbody');

    // supaya nama produk tidak dibaca sebagai kode HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // TOAST JAVASCRIPT DINAMIS (gaya toast ada di layout)
    function showToast(message, type = 'success') {
        let toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerText = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // FILTER PRODUK SAAT PILIH KATEGORI
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

    // TAMBAH DATA
    function tambahData() {
        let tanggal = tanggalInput.value;
        let jumlah = jumlahInput.value;

        if (!produkSelect.value || !tanggal || !jumlah) {
            showToast('Lengkapi data terlebih dahulu!', 'error');
            return;
        }

        if (parseInt(jumlah) <= 0) {
            showToast('Jumlah barang masuk harus lebih dari 0!', 'error');
            return;
        }

        let namaProduk = produkSelect.options[produkSelect.selectedIndex].text;

        tbody.insertAdjacentHTML('beforeend', `
            <tr>
                <td>
                    ${escapeHtml(namaProduk)}
                    <input type="hidden" name="data[${index}][id_produk]" value="${produkSelect.value}">
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
                    <button type="button" class="btn-pill btn-hapus" onclick="hapusRow(this)">
                        <i class="ti ti-trash"></i> Hapus
                    </button>
                </td>
            </tr>
        `);

        index++;
        jumlahInput.value = '';

        showToast('Berhasil menambahkan item ke tabel list.', 'success');
    }

    // HAPUS ROW
    function hapusRow(btn) {
        btn.closest('tr').remove();
        showToast('Item dihapus dari list.', 'error');
    }

    // tekan Enter di kolom jumlah = klik Tambah
    jumlahInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            tambahData();
        }
    });

    // cegah simpan kalau list masih kosong
    document.getElementById('form-masuk').addEventListener('submit', function (e) {
        if (tbody.children.length === 0) {
            e.preventDefault();
            showToast('Tambahkan minimal satu item dulu!', 'error');
        }
    });
</script>

@endsection