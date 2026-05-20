

<?php $__env->startSection('content'); ?>

<style>
    h2 {
        margin-bottom: 20px;
        color: #0f766e;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .card-box {
        padding: 20px;
        border-radius: 10px;
        color: white;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: 0.3s;
    }

    .card-box:hover {
        transform: translateY(-5px);
    }

    .card-box h3 {
        margin: 0;
        font-size: 16px;
    }

    .card-box p {
        font-size: 28px;
        margin-top: 10px;
        font-weight: bold;
    }

    /* warna konsisten */
    .green { background: #0f766e; }
    .blue { background: #3498db; }
    .orange { background: #f39c12; }
    .red { background: #e74c3c; }
</style>

<h2>Dashboard</h2>

<div class="cards">
    <div class="card-box green">
        <h3>Total Produk</h3>
        <p><?php echo e($totalProduk); ?></p>
    </div>

    <div class="card-box blue">
        <h3>Barang Masuk</h3>
        <p><?php echo e($barangMasuk); ?></p>
    </div>

    <div class="card-box orange">
        <h3>Barang Keluar</h3>
        <p><?php echo e($barangKeluar); ?></p>
    </div>

    <div class="card-box red">
        <h3>Total Stok</h3>
        <p><?php echo e($totalStok); ?></p>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Laravel10\TokoObat\resources\views/dashboard.blade.php ENDPATH**/ ?>