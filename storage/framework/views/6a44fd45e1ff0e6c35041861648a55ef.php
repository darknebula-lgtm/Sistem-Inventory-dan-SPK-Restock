<!DOCTYPE html>
<html>
<head>
    <title>Inventory Dashboard</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ecf0f1;
        }

        /* WRAPPER */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: #0f766e;
            color: white;
            padding: 20px;
            transition: 0.3s;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: white;
            padding: 10px;
            margin: 10px 0;
            text-decoration: none;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: #0d5c58;
        }

        .sidebar a.active {
            background: white;
            color: #0f766e;
            font-weight: bold;
        }

        .sidebar span {
            margin-left: 10px;
        }

        .sidebar.collapsed span {
            display: none;
        }

        /* MAIN */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* TOPBAR */
        .topbar {
            background: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .toggle-btn {
            font-size: 20px;
            cursor: pointer;
        }

        /* USER */
        .user-area {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-name {
            font-weight: bold;
        }

        .logout-btn {
            background: #e84118;
            border: none;
            padding: 8px 12px;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background: #c23616;
        }

        /* CONTENT */
        .content {
            padding: 20px;
            flex: 1;
        }

        /* ===== TOAST ===== */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 18px;
            border-radius: 6px;
            color: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: fadeIn 0.3s, fadeOut 0.3s 2.7s;
        }

        .toast.success { background: #2ecc71; }
        .toast.error { background: #e74c3c; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeOut {
            to { opacity: 0; transform: translateY(-10px); }
        }
    </style>

</head>
<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div id="sidebar" class="sidebar">
        <h2>📦 <span>Inventory</span></h2>

        <a href="/dashboard" class="<?php echo e(request()->is('dashboard') ? 'active' : ''); ?>">
            🏠 <span>Dashboard</span>
        </a>

        <a href="/kategori" class="<?php echo e(request()->is('kategori*') ? 'active' : ''); ?>">
            📁 <span>Kategori</span>
        </a>

        <a href="/produk" class="<?php echo e(request()->is('produk*') ? 'active' : ''); ?>">
            📦 <span>Produk</span>
        </a>

        <a href="/barang-masuk" class="<?php echo e(request()->is('barang-masuk*') ? 'active' : ''); ?>">
            ⬇️ <span>Barang Masuk</span>
        </a>

        <a href="/barang-keluar" class="<?php echo e(request()->is('barang-keluar*') ? 'active' : ''); ?>">
            ⬆️ <span>Barang Keluar</span>
        </a>

        <a href="/laporan" class="<?php echo e(request()->is('laporan*') ? 'active' : ''); ?>">
            📄 <span>Laporan</span>
        </a>
        
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">

            <!-- LEFT -->
            <div style="display:flex; align-items:center; gap:15px;">
                <span class="toggle-btn" onclick="toggleSidebar()">☰</span>

                <!-- SEARCH -->
                <form action="/produk" method="GET" style="display:flex; gap:5px;">
                    <input type="text" name="search"
                        placeholder="Cari produk..."
                        value="<?php echo e(request('search')); ?>"
                        style="padding:6px 10px; border:1px solid #ccc; border-radius:5px;">
                    <button style="background:#0f766e; color:white; border:none; padding:6px 10px; border-radius:5px;">
                        🔍
                    </button>
                </form>
            </div>

            <!-- RIGHT -->
            <div class="user-area">
                <span class="user-name">
                    <?php echo e(auth()->user()->name); ?>

                </span>

                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="logout-btn">Logout</button>
                </form>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </div>

</div>


<!-- TOAST -->
<?php if(session('success')): ?>
<div class="toast success" id="toast">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="toast error" id="toast">
    <?php echo e(session('error')); ?>

</div>
<?php endif; ?>


<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("collapsed");
}

// auto hilang
setTimeout(() => {
    let toast = document.getElementById('toast');
    if (toast) toast.remove();
}, 3000);
</script>

</body>
</html><?php /**PATH C:\Laravel10\TokoObat\resources\views/layout.blade.php ENDPATH**/ ?>