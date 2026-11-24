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

    .stok-info {
        min-height: 18px;
        margin: -8px 0 16px 4px;
        font-size: 13px;
        color: var(--muted, #7b8794);
    }

    .stok-info.habis {
        color: #b42318;
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
    <h2 class="form-title">Barang Keluar (Multi Input)</h2>

    <!-- INPUT -->
    <div class="form-row">

        <!-- KATEGORI -->
        <select id="kategori" class="fld">
            <option value="">Kategori</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
            @endforeach
        </select>

        <!-- PRODUK (KOSONG DULU) -->
        <select id="produk" class="fld">
            <option value="">Pilih Produk</option>
        </select>

        <input type="date" id="tanggal" class="fld">
        <input type="number" id="jumlah" class="fld" min="1" placeholder="Jumlah">

        <button type="button" class="btn-pill btn-add" onclick="tambahData()">
            <i class="ti ti-plus"></i> Tambah
        </button>
    </div>

    <div id="info-stok" class="stok-info"></div>

    <!-- TABLE -->
    <form id="form-keluar" action="/barang-keluar" method="POST">
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

    // Ambil data produk dari backend
    const allProduk = @js($produk);

    // Simpan stok sementara (biar tidak bisa minus saat multi input)
    let stokSementara = {};

    // ELEMENT
    const kategoriSelect = document.getElementById('kategori');
    const produkSelect = document.getElementById('produk');
    const tanggalInput = document.getElementById('tanggal');
    const jumlahInput = document.getElementById('jumlah');
    const infoStok = document.getElementById('info-stok');
    const tbody = document.querySelector('#table tbody');

    // supaya nama produk tidak dibaca sebagai kode HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // TOAST JAVASCRIPT KUSTOM (gaya toast ada di layout)
    function showToast(message, type = 'success') {
        let toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerText = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // FILTER PRODUK
    kategoriSelect.addEventListener('change', function () {
        let idKategori = this.value;

        produkSelect.innerHTML = '<option value="">Pilih Produk</option>';
        infoStok.innerText = '';
        infoStok.classList.remove('habis');

        let filtered = allProduk.filter(p => p.id_kategori == idKategori);

        filtered.forEach(p => {
            let option = document.createElement('option');
            option.value = p.id_produk;
            option.textContent = p.nama_produk;
            option.setAttribute('data-stok', p.stok);
            produkSelect.appendChild(option);
        });
    });

    // TAMPILKAN STOK
    produkSelect.addEventListener('change', function () {
        let selected = this.options[this.selectedIndex];
        let id = this.value;

        if (!id) {
            infoStok.innerText = '';
            infoStok.classList.remove('habis');
            return;
        }

        let stokAsli = parseInt(selected.getAttribute('data-stok'));
        let terpakai = stokSementara[id] ?? 0;

        let sisa = stokAsli - terpakai;

        infoStok.innerText = 'Stok tersedia: ' + sisa;
        infoStok.classList.toggle('habis', sisa <= 0);
    });

    // TAMBAH DATA
    function tambahData() {
        let tanggal = tanggalInput.value;
        let jumlah = parseInt(jumlahInput.value);

        if (!produkSelect.value || !tanggal || !jumlah) {
            showToast('Lengkapi data terlebih dahulu!', 'error');
            return;
        }

        if (jumlah <= 0) {
            showToast('Jumlah barang keluar harus lebih dari 0!', 'error');
            return;
        }

        let selected = produkSelect.options[produkSelect.selectedIndex];
        let id = produkSelect.value;
        let stokAsli = parseInt(selected.getAttribute('data-stok'));
        let terpakai = stokSementara[id] ?? 0;

        let sisa = stokAsli - terpakai;

        if (jumlah > sisa) {
            showToast('Stok tidak mencukupi!', 'error');
            return;
        }

        // Simpan pemakaian stok sementara
        stokSementara[id] = terpakai + jumlah;

        tbody.insertAdjacentHTML('beforeend', `
            <tr>
                <td>
                    ${escapeHtml(selected.text)}
                    <input type="hidden" name="data[${index}][id_produk]" value="${id}">
                </td>
                <td>
                    ${tanggal}
                    <input type="hidden" name="data[${index}][tanggal_keluar]" value="${tanggal}">
                </td>
                <td>
                    ${jumlah}
                    <input type="hidden" name="data[${index}][jumlah]" value="${jumlah}">
                </td>
                <td>
                    <button type="button" class="btn-pill btn-hapus"
                            onclick="hapusRow(this, '${id}', ${jumlah})">
                        <i class="ti ti-trash"></i> Hapus
                    </button>
                </td>
            </tr>
        `);

        index++;
        jumlahInput.value = '';
        produkSelect.dispatchEvent(new Event('change')); // update stok

        showToast('Berhasil menambahkan item ke tabel list.', 'success');
    }

    // HAPUS ROW + BALIKIN STOK
    function hapusRow(btn, id, jumlah) {
        btn.closest('tr').remove();

        stokSementara[id] -= jumlah;

        produkSelect.dispatchEvent(new Event('change'));

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
    document.getElementById('form-keluar').addEventListener('submit', function (e) {
        if (tbody.children.length === 0) {
            e.preventDefault();
            showToast('Tambahkan minimal satu item dulu!', 'error');
        }
    });
</script>

@endsection