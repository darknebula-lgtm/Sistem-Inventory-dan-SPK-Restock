

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

        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($index + 1); ?></td>
            <td><?php echo e($d->nama_kategori); ?></td>
            <td class="aksi">
                <a href="/kategori/<?php echo e($d->id_kategori); ?>/edit" class="btn btn-edit">Edit</a>

                <form action="/kategori/<?php echo e($d->id_kategori); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-hapus" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </table>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Laravel10\TokoObat\resources\views/kategori/index.blade.php ENDPATH**/ ?>