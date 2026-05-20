

<?php $__env->startSection('content'); ?>

<style>
.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

h2 {
    margin-bottom: 20px;
    color: #0f766e;
}

.form-bobot {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100px;
}

button {
    padding: 8px 15px;
    background: #0f766e;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.alert {
    background: #e74c3c;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
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
}

td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.rank-1 { background: #e74c3c; color: white; }
.rank-2 { background: #f39c12; color: white; }
.rank-3 { background: #f1c40f; }

.section-title {
    margin-top: 30px;
    margin-bottom: 10px;
    color: #0f766e;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
}

.modal-content {
    background: white;
    margin: 5% auto;
    padding: 20px;
    width: 80%;
    max-height: 80vh;
    overflow: auto;
    border-radius: 10px;
}

.modal-footer {
    margin-top: 15px;
    display: flex;
    justify-content: space-between;
}
</style>

<div class="card">

<h2>SPK Restock (PROMETHEE)</h2>

<?php if(session('error')): ?>
<div class="alert"><?php echo e(session('error')); ?></div>
<?php endif; ?>

<form method="GET" class="form-bobot">
    <div>
        Terjual<br>
        <input type="number" step="0.1" name="terjual" value="<?php echo e($bobot['terjual']); ?>">
    </div>

    <div>
        Harga<br>
        <input type="number" step="0.1" name="harga" value="<?php echo e($bobot['harga']); ?>">
    </div>

    <div>
        Stok<br>
        <input type="number" step="0.1" name="stok" value="<?php echo e($bobot['stok']); ?>">
    </div>

    <div style="align-self:end;">
        <button type="submit">Hitung</button>
    </div>
</form>

<table>
<tr>
    <th>Ranking</th>
    <th>Produk</th>
    <th>Terjual</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Net Flow</th>
</tr>

<?php $__currentLoopData = $hasil; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr class="<?php echo e($i == 0 ? 'rank-1' : ($i == 1 ? 'rank-2' : ($i == 2 ? 'rank-3' : ''))); ?>">
    <td><?php echo e($i+1); ?></td>
    <td><?php echo e($h['nama']); ?></td>
    <td><?php echo e($h['terjual']); ?></td>
    <td><?php echo e(number_format($h['harga'])); ?></td>
    <td><?php echo e($h['stok']); ?></td>
    <td><strong><?php echo e(round($h['net'],3)); ?></strong></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<br>
<button onclick="openModal()">Lihat Step Perhitungan</button>

</div>


<div id="modalStep" class="modal">
    <div class="modal-content">

        <h3 id="stepTitle"></h3>

        <div id="stepContent"></div>

        <div class="modal-footer">
            <button onclick="prevStep()">⬅ Prev</button>
            <button onclick="nextStep()">Next ➡</button>
            <button onclick="closeModal()">Tutup</button>
        </div>

    </div>
</div>

<script>
let step = 1;

function openModal() {
    document.getElementById('modalStep').style.display = 'block';
    showStep();
}

function closeModal() {
    document.getElementById('modalStep').style.display = 'none';
}

function nextStep() {
    if(step < 4) step++;
    showStep();
}

function prevStep() {
    if(step > 1) step--;
    showStep();
}

function showStep() {
    let title = document.getElementById('stepTitle');
    let content = document.getElementById('stepContent');

    if(step === 1){
        title.innerText = "Step 1: Data Awal";
        content.innerHTML = `
        <table>
        <tr><th>Produk</th><th>Terjual</th><th>Harga</th><th>Stok</th></tr>
        <?php $__currentLoopData = $step['data_awal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($d['nama']); ?></td>
            <td><?php echo e($d['terjual']); ?></td>
            <td><?php echo e($d['harga']); ?></td>
            <td><?php echo e($d['stok']); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>`;
    }

    if(step === 2){
        title.innerText = "Step 2: Normalisasi";
        content.innerHTML = `
        <table>
        <tr><th>Produk</th><th>Terjual</th><th>Harga</th><th>Stok</th></tr>
        <?php $__currentLoopData = $step['normalisasi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($d['nama']); ?></td>
            <td><?php echo e(round($d['terjual_n'],3)); ?></td>
            <td><?php echo e(round($d['harga_n'],3)); ?></td>
            <td><?php echo e(round($d['stok_n'],3)); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>`;
    }

    if(step === 3){
        title.innerText = "Step 3: Perbandingan";
        content.innerHTML = `
        <?php $__currentLoopData = $hasil; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <h4><?php echo e($h['nama']); ?></h4>
        <table>
        <tr><th>Dibanding</th><th>A→B</th><th>B→A</th></tr>
        <?php $__currentLoopData = $h['detail']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($d['dibanding']); ?></td>
            <td><?php echo e($d['pref_ab']); ?></td>
            <td><?php echo e($d['pref_ba']); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>`;
    }

    if(step === 4){
        title.innerText = "Step 4-6: Flow & Ranking";
        content.innerHTML = `
        <table>
        <tr><th>Produk</th><th>Leaving</th><th>Entering</th><th>Net</th></tr>
        <?php $__currentLoopData = $hasil; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($h['nama']); ?></td>
            <td><?php echo e(round($h['leaving'],3)); ?></td>
            <td><?php echo e(round($h['entering'],3)); ?></td>
            <td><?php echo e(round($h['net'],3)); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>`;
    }
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Laravel10\TokoObat\resources\views/spk/index.blade.php ENDPATH**/ ?>