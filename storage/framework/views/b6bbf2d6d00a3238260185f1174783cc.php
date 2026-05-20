

<?php $__env->startSection('content'); ?>

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

    .btn-tambah { background: #0f766e; }
    .btn-hapus { background: #e74c3c; }

    .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    h3 {
        margin-bottom: 10px;
        color: #0f766e;
    }

    .total {
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
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

    form {
        display: inline;
    }
</style>

<div class="header">
    <h2>Barang Keluar</h2>
    <a href="/barang-keluar/create" class="btn btn-tambah">+ Tambah</a>
</div>

<?php
    $grouped = $data->groupBy('tanggal_keluar');
?>

<?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tanggal => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php
    $total = $items->sum('jumlah');
?>

<div class="card">

    <h3>Tanggal: <?php echo e($tanggal); ?></h3>
    <div class="total">Total Barang Keluar: <?php echo e($total); ?></div>

    <table>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Jumlah</th>
        </tr>

        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($index + 1); ?></td>
            <td><?php echo e($d->produk->nama_produk); ?></td>
            <td><?php echo e($d->jumlah); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </table>

</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Laravel10\TokoObat\resources\views/barang_keluar/index.blade.php ENDPATH**/ ?>