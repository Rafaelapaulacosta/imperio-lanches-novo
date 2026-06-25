<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Lanches')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #1a1f2e;
            --sidebar-hover: #2a3145;
            --sidebar-active: #f97316;
            --sidebar-text: #a8b2c8;
            --sidebar-text-active: #ffffff;
            --topbar-height: 60px;
            --accent: #f97316;
            --accent-dark: #ea6c05;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f1f5f9;
            margin: 0;
        }

        /* ── Sidebar ── */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform .3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 22px;
            border-bottom: 1px solid rgba(255,255,255,.06);
            text-decoration: none;
        }
        .sidebar-brand .brand-icon {
            width: 38px; height: 38px;
            background: var(--accent);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .sidebar-brand .brand-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }
        .sidebar-brand .brand-sub {
            font-size: .7rem;
            color: var(--sidebar-text);
            font-weight: 400;
        }

        /* Nav sections */
        .nav-section-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #4a5568;
            padding: 18px 22px 6px;
        }

        .nav-item { padding: 2px 12px; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--sidebar-text);
            font-size: .875rem;
            font-weight: 500;
            text-decoration: none;
            transition: background .15s, color .15s;
        }
        .nav-link i { font-size: 1rem; min-width: 18px; }
        .nav-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }
        .nav-link.active {
            background: rgba(249,115,22,.15);
            color: var(--accent);
        }
        .nav-link.active i { color: var(--accent); }

        /* Submenu (collapse) */
        .nav-link[data-bs-toggle="collapse"] .chevron {
            margin-left: auto;
            font-size: .75rem;
            transition: transform .2s;
        }
        .nav-link[aria-expanded="true"] .chevron { transform: rotate(90deg); }

        .submenu { padding: 2px 0; }
        .submenu .nav-item { padding: 1px 12px 1px 28px; }
        .submenu .nav-link {
            font-size: .82rem;
            padding: 8px 12px;
            color: #6b7a99;
        }
        .submenu .nav-link::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #4a5568;
            flex-shrink: 0;
            transition: background .15s;
        }
        .submenu .nav-link:hover::before,
        .submenu .nav-link.active::before { background: var(--accent); }
        .submenu .nav-link.active { color: var(--accent); background: transparent; }

        /* ── Top Bar ── */
        #topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 24px;
            z-index: 999;
            gap: 12px;
        }
        .topbar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.3rem;
            color: #64748b;
            cursor: pointer;
        }
        .topbar-breadcrumb {
            flex: 1;
            font-size: .82rem;
        }
        .topbar-breadcrumb .breadcrumb { margin: 0; }
        .topbar-actions { display: flex; align-items: center; gap: 8px; }
        .topbar-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            font-weight: 700;
            font-size: .8rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
        }

        /* ── Main content ── */
        #main {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
        }
        .page-content { padding: 28px 28px; }

        /* Page header */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .page-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        .page-subtitle {
            font-size: .8rem;
            color: #94a3b8;
            margin: 2px 0 0;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            border-radius: 14px 14px 0 0 !important;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .card-title-sm {
            font-size: .9rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Table */
        .table { margin: 0; }
        .table thead th {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #94a3b8;
            background: #f8fafc;
            border-top: none;
            padding: 12px 16px;
        }
        .table tbody td {
            font-size: .875rem;
            color: #334155;
            padding: 14px 16px;
            vertical-align: middle;
            border-color: #f1f5f9;
        }
        .table tbody tr:hover { background: #fafcff; }

        /* Badges */
        .badge-status {
            font-size: .7rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-ativo { background: #dcfce7; color: #16a34a; }
        .badge-inativo { background: #fee2e2; color: #dc2626; }
        .badge-proomo { background: #fef9c3; color: #ca8a04; }

        /* Action buttons */
        .btn-action {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            font-size: .85rem;
            transition: all .15s;
            text-decoration: none;
        }
        .btn-edit { background: #eff6ff; color: #3b82f6; }
        .btn-edit:hover { background: #3b82f6; color: #fff; }
        .btn-delete { background: #fff1f2; color: #ef4444; }
        .btn-delete:hover { background: #ef4444; color: #fff; }
        .btn-view { background: #f0fdf4; color: #22c55e; }
        .btn-view:hover { background: #22c55e; color: #fff; }

        /* Primary button */
        .btn-primary {
            background: var(--accent);
            border-color: var(--accent);
            font-weight: 600;
            font-size: .85rem;
            border-radius: 8px;
            padding: 8px 16px;
        }
        .btn-primary:hover { background: var(--accent-dark); border-color: var(--accent-dark); }

        /* Search bar */
        .search-input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: .85rem;
            padding: 7px 14px 7px 36px;
            background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 16 16'%3E%3Cpath fill='%2394a3b8' d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0'/%3E%3C/svg%3E") no-repeat 12px center;
            min-width: 220px;
        }
        .search-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(249,115,22,.1);
            background-color: #fff;
        }

        /* Product image placeholder */
        .product-thumb {
            width: 42px; height: 42px;
            border-radius: 10px;
            object-fit: cover;
            background: #f1f5f9;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
        }

        /* Overlay for mobile */
        #sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 999;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #sidebar-overlay.open { display: block; }
            #topbar { left: 0; }
            #main { margin-left: 0; }
            .topbar-toggle { display: block; }
            .page-content { padding: 20px 16px; }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- ══════════ SIDEBAR ══════════ -->
<nav id="sidebar">

    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <div class="brand-icon">🍔</div>
        <div>
            <div class="brand-name">LancheSys</div>
            <div class="brand-sub">Gestão de Lanches</div>
        </div>
    </a>

    <ul class="nav flex-column mt-2 mb-auto" style="list-style:none; padding:0;">

        <li class="nav-section-label">Principal</li>

        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
        </li>

        <!-- ── MÓDULO: LANCHES ── -->
        <li class="nav-section-label">Cardápio</li>

        <li class="nav-item">
            <a href="#menu-lanches"
               class="nav-link {{ request()->routeIs('lanches.*') ? '' : 'collapsed' }}"
               data-bs-toggle="collapse"
               aria-expanded="{{ request()->routeIs('lanches.*') ? 'true' : 'false' }}">
                <i class="bi bi-burger"></i>
                Lanches
                <i class="bi bi-chevron-right chevron ms-auto"></i>
            </a>
            <div class="collapse submenu {{ request()->routeIs('lanches.*') ? 'show' : '' }}" id="menu-lanches">
                <ul class="nav flex-column" style="list-style:none; padding:0;">
                    <li class="nav-item">
                        <a href="{{ route('lanches.index') }}"
                           class="nav-link {{ request()->routeIs('lanches.index') ? 'active' : '' }}">
                            Lista de Lanches
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('lanches.create') }}"
                           class="nav-link {{ request()->routeIs('lanches.create') ? 'active' : '' }}">
                            Novo Lanche
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link collapsed" data-bs-toggle="collapse" aria-expanded="false">
                <i class="bi bi-tags"></i>
                Categorias
                <i class="bi bi-chevron-right chevron ms-auto"></i>
            </a>
            <div class="collapse submenu" id="menu-cat">
                <ul class="nav flex-column" style="list-style:none; padding:0;">
                    <li class="nav-item"><a href="#" class="nav-link">Lista de Categorias</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Nova Categoria</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-section-label">Sistema</li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-people"></i> Usuários
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-gear"></i> Configurações
            </a>
        </li>

    </ul>

    <!-- User info at bottom -->
    <div style="padding: 16px 22px; border-top: 1px solid rgba(255,255,255,.06); margin-top: auto;">
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="topbar-avatar">AD</div>
            <div>
                <div style="font-size:.8rem; font-weight:600; color:#fff;">Admin</div>
                <div style="font-size:.7rem; color:#4a5568;">admin@sistema.com</div>
            </div>
            <a href="#" style="margin-left:auto; color:#4a5568; font-size:1rem;">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>

</nav>

<!-- ══════════ TOP BAR ══════════ -->
<header id="topbar">
    <button class="topbar-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <nav class="topbar-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="color:#94a3b8; text-decoration:none;">Início</a></li>
            @yield('breadcrumb')
        </ol>
    </nav>

    <div class="topbar-actions">
        <button class="btn btn-sm" style="border:1px solid #e2e8f0; border-radius:8px; color:#64748b; font-size:.8rem;">
            <i class="bi bi-bell"></i>
        </button>
        <div class="topbar-avatar">AD</div>
    </div>
</header>

<!-- ══════════ MAIN CONTENT ══════════ -->
<main id="main">
    <div class="page-content">
        @yield('content')
    </div>
</main>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('open');
    }
</script>

@stack('scripts')
</body>
</html>
