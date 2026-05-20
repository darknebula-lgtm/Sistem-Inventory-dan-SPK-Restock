<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang Masuk</title>
    <style>
        body { font-family: sans-serif; }

        .header {
            text-align: center;
            border-bottom: 2px solid black;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 2px;
            font-size: 12px;
        }

        h3 {
            text-align: center;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background: #0f766e;
            color: white;
        }

        .total {
            margin-top: 15px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>TOKO ANDA</h2>
    <p>Jl. Contoh Alamat No. 123</p>
    <p>Telp: 08123456789</p>
</div>

<h3>Laporan Barang Masuk</h3>

<table>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Produk</th>
        <th>Jumlah</th>
    </tr>

    <?php $total = 0; ?>

    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $total += $d->jumlah; ?>
    <tr>
        <td><?php echo e($i+1); ?></td>
        <td><?php echo e($d->tanggal_masuk); ?></td>
        <td><?php echo e($d->produk->nama_produk); ?></td>
        <td><?php echo e($d->jumlah); ?></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>

<div class="total">
    Total Barang Masuk: <?php echo e($total); ?>

</div>

</body>
</html><?php /**PATH C:\Laravel10\TokoObat\resources\views/laporan/masuk.blade.php ENDPATH**/ ?>