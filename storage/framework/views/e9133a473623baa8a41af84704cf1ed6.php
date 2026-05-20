

<?php $__env->startSection('content'); ?>

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

    .stok-info {
        font-size: 13px;
        margin-top: -5px;
        margin-bottom: 10px;
        color: #555;
    }
</style>

<div class="card">
    <h2>Barang Keluar (Multi Input)</h2>

    <!-- INPUT -->
    <div class="form-row">

        <!-- KATEGORI -->
        <select id="kategori">
            <option value="">Kategori</option>
            <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k->id_kategori); ?>"><?php echo e($k->nama_kategori); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <!-- PRODUK (KOSONG DULU) -->
        <select id="produk">
            <option value="">Pilih Produk</option>
        </select>

        <input type="date" id="tanggal">
        <input type="number" id="jumlah" placeholder="Jumlah">

        <button type="button" class="btn btn-add" onclick="tambahData()">Tambah</button>
    </div>

    <div id="info-stok" class="stok-info"></div>

    <!-- TABLE -->
    <form action="/barang-keluar" method="POST">
        <?php echo csrf_field(); ?>

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

// Ambil data produk dari backend
const allProduk = <?php echo \Illuminate\Support\Js::from($produk)->toHtml() ?>;

// Simpan stok sementara (biar tidak bisa minus saat multi input)
let stokSementara = {};

// ELEMENT
const kategoriSelect = document.getElementById('kategori');
const produkSelect = document.getElementById('produk');
const infoStok = document.getElementById('info-stok');

// 🔥 FUNGSI UNTUK MEMBUAT TOAST JAVASCRIPT KUSTOM
function showToast(message, type = 'success') {
    // Buat elemen div baru
    let toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerText = message;
    
    // Masukkan ke dalam body halaman
    document.body.appendChild(toast);
    
    // Otomatis hapus setelah 3 detik (sama dengan logika layout.blade)
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// FILTER PRODUK
kategoriSelect.addEventListener('change', function () {
    let idKategori = this.value;

    produkSelect.innerHTML = '<option value="">Pilih Produk</option>';
    infoStok.innerText = '';

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
        return;
    }

    let stokAsli = parseInt(selected.getAttribute('data-stok'));
    let terpakai = stokSementara[id] ?? 0;

    let sisa = stokAsli - terpakai;

    infoStok.innerText = "Stok tersedia: " + sisa;
});

// TAMBAH DATA
function tambahData() {
    let produk = produkSelect;
    let tanggal = document.getElementById('tanggal').value;
    let jumlah = parseInt(document.getElementById('jumlah').value);

    if (!produk.value || !tanggal || !jumlah) {
        showToast('Lengkapi data terlebih dahulu!', 'error'); // Ganti alert
        return;
    }

    let selected = produk.options[produk.selectedIndex];
    let id = produk.value;
    let stokAsli = parseInt(selected.getAttribute('data-stok'));
    let terpakai = stokSementara[id] ?? 0;

    let sisa = stokAsli - terpakai;

    if (jumlah > sisa) {
        showToast('Stok tidak mencukupi!', 'error'); // Ganti alert disini
        return;
    }

    // Simpan pemakaian stok sementara
    stokSementara[id] = terpakai + jumlah;

    let table = document.querySelector('#table tbody');

    let row = `
        <tr>
            <td>
                ${selected.text}
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
                <button type="button" class="btn btn-hapus" onclick="hapusRow(this, '${id}', ${jumlah})">Hapus</button>
            </td>
        </tr>
    `;

    table.innerHTML += row;
    index++;

    document.getElementById('jumlah').value = '';
    produk.dispatchEvent(new Event('change')); // update stok
    
    showToast('Berhasil menambahkan item ke tabel list.', 'success');
}

// HAPUS ROW + BALIKIN STOK
function hapusRow(btn, id, jumlah) {
    btn.closest('tr').remove();

    stokSementara[id] -= jumlah;

    produkSelect.dispatchEvent(new Event('change'));
    
    showToast('Item dihapus dari list.', 'error');
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Laravel10\TokoObat\resources\views/barang_keluar/create.blade.php ENDPATH**/ ?>