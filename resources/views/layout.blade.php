<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">

    <style>
        :root {
            --teal: #0f5c4d;
            --orange: #ee7035;
            --canvas: #e9efed;
            --text: #1f2933;
            --muted: #7b8794;
            --line: #cfd8d5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            background: var(--canvas);
            color: var(--text);
        }

        /* WRAPPER */
.wrapper {
    display: flex;
    padding: 16px 16px 16px 0;
    min-height: 100vh;
}

/* SIDEBAR */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    width: 230px;
    height: 100vh;
    background: var(--teal);
    color: white;
    border-radius: 0 28px 28px 0;
    padding: 22px 14px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden;
    transition: width 0.3s;
}

.sidebar.collapsed {
    width: 76px;
}

/* GESER KONTEN SESUAI LEBAR SIDEBAR */
.sidebar + .main {
    margin-left: 246px;
    transition: margin-left 0.3s;
}

.sidebar.collapsed + .main {
    margin-left: 92px;
}
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 24px;
            font-size: 18px;
            font-weight: bold;
            white-space: nowrap;
        }

        .brand-logo {
            width: 30px;
            height: 30px;
            flex-shrink: 0;
            border-radius: 50%;
            border: 7px solid var(--orange);
        }

        .menu a,
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 12px;
            margin-bottom: 6px;
            color: white;
            font: inherit;
            text-decoration: none;
            white-space: nowrap;
            background: none;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            opacity: 0.75;
        }

        .menu a i,
        .logout-btn i {
            font-size: 22px;
            flex-shrink: 0;
        }

        .menu a:hover,
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.12);
            opacity: 1;
        }

        .menu a.active {
            background: var(--orange);
            font-weight: bold;
            opacity: 1;
        }

        .sidebar.collapsed .label {
            display: none;
        }

        .sidebar.collapsed .brand,
        .sidebar.collapsed .menu a,
        .sidebar.collapsed .logout-btn {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        /* MAIN */
        .main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* TOPBAR */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .topbar-left,
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-btn {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--muted);
            background: white;
            border: 1px solid var(--line);
            border-radius: 50%;
            cursor: pointer;
        }

        .search {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 280px;
            height: 42px;
            padding: 0 16px;
            color: var(--muted);
            background: white;
            border: 1px solid var(--line);
            border-radius: 999px;
        }

        .search input {
            flex: 1;
            min-width: 0;
            font-size: 14px;
            color: var(--text);
            background: none;
            border: none;
            outline: none;
        }

        .date-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            height: 42px;
            padding: 0 16px;
            font-size: 14px;
            color: var(--muted);
            background: white;
            border: 1px solid var(--line);
            border-radius: 999px;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            height: 42px;
            padding: 0 18px 0 5px;
            background: white;
            border: 1px solid var(--line);
            border-radius: 999px;
        }

        .avatar {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: bold;
            color: white;
            background: var(--orange);
            border-radius: 50%;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-info strong {
            font-size: 13px;
        }

        .user-info small {
            font-size: 11px;
            color: var(--muted);
        }

        /* CONTENT */
        .content {
            flex: 1;
        }

        /* KOMPONEN UMUM (dipakai di halaman lain) */
        .ui-card {
            background: white;
            border-radius: 24px;
            padding: 20px 22px;
        }

        .ui-card-accent {
            background: var(--orange);
            color: white;
        }

        .ui-badge {
            display: inline-block;
            padding: 4px 12px;
            font-size: 12px;
            border-radius: 999px;
        }

        .ui-badge.success {
            background: #dcf7ee;
            color: #0f7a5a;
        }

        .ui-badge.warning {
            background: #fde8d8;
            color: #c2561d;
        }

        .ui-badge.danger {
            background: #fde2e2;
            color: #b42318;
        }

        /* ===== TOAST ===== */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 12px;
            color: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            animation: fadeIn 0.3s, fadeOut 0.3s 2.7s forwards;
        }

        .toast.success {
            background: #1d9e75;
        }

        .toast.error {
            background: #e24b4a;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .date-chip,
            .user-info {
                display: none;
            }

            .search {
                width: 180px;
            }
        }
    </style>
</head>
<body>

@php
    $userName = auth()->user()->name ?? 'Admin';
    $userRole = auth()->user()->role ?? 'Pengguna';
@endphp

<div class="wrapper">

    <!-- SIDEBAR -->
    <div id="sidebar" class="sidebar">

        <div>
            <div class="brand">
                <div class="brand-logo"></div>
                <span class="label">Inventory</span>
            </div>

            <nav class="menu">
                <a href="/dashboard" title="Dashboard"
                   class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="ti ti-layout-grid"></i>
                    <span class="label">Dashboard</span>
                </a>

                <a href="/kategori" title="Kategori"
                   class="{{ request()->is('kategori*') ? 'active' : '' }}">
                    <i class="ti ti-category"></i>
                    <span class="label">Kategori</span>
                </a>

                <a href="/produk" title="Produk"
                   class="{{ request()->is('produk*') ? 'active' : '' }}">
                    <i class="ti ti-package"></i>
                    <span class="label">Produk</span>
                </a>

                <a href="/barang-masuk" title="Barang Masuk"
                   class="{{ request()->is('barang-masuk*') ? 'active' : '' }}">
                    <i class="ti ti-download"></i>
                    <span class="label">Barang Masuk</span>
                </a>

                <a href="/barang-keluar" title="Barang Keluar"
                   class="{{ request()->is('barang-keluar*') ? 'active' : '' }}">
                    <i class="ti ti-upload"></i>
                    <span class="label">Barang Keluar</span>
                </a>

                <a href="/laporan" title="Laporan"
                   class="{{ request()->is('laporan*') ? 'active' : '' }}">
                    <i class="ti ti-file-text"></i>
                    <span class="label">Laporan</span>
                </a>

                <a href="/spk" title="SPK Restock"
                   class="{{ request()->is('spk*') ? 'active' : '' }}">
                    <i class="ti ti-brain"></i>
                    <span class="label">SPK Restock</span>
                </a>
            </nav>
        </div>

        <!-- LOGOUT -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn" title="Logout">
                <i class="ti ti-logout"></i>
                <span class="label">Logout</span>
            </button>
        </form>

    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">

            <!-- LEFT -->
            <div class="topbar-left">
                <button type="button" class="icon-btn"
                        onclick="toggleSidebar()" title="Buka/tutup menu">
                    <i class="ti ti-menu-2"></i>
                </button>

                <!-- SEARCH -->
                <form action="/produk" method="GET" class="search">
                    <i class="ti ti-search"></i>
                    <input type="text" name="search"
                           placeholder="Cari produk..."
                           value="{{ request('search') }}">
                </form>
            </div>

            <!-- RIGHT -->
            <div class="topbar-right">
                <div class="date-chip">
                    <i class="ti ti-calendar"></i>
                    {{ now()->format('d M Y') }}
                </div>

                <div class="user-pill">
                    <div class="avatar">{{ strtoupper(substr($userName, 0, 1)) }}</div>
                    <div class="user-info">
                        <strong>{{ $userName }}</strong>
                        <small>{{ $userRole }}</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>

    </div>

</div>


<!-- TOAST -->
@if(session('success'))
    <div class="toast success" id="toast">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="toast error" id="toast">
        {{ session('error') }}
    </div>
@endif


<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    }

    // toast hilang otomatis
    setTimeout(() => {
        let toast = document.getElementById('toast');
        if (toast) toast.remove();
    }, 3000);
</script>

</body>
</html>