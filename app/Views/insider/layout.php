<?php
/** @var string|null $pageTitle */
$rol     = session('rol');
$current = uri_string();

$navActive = static function (string $path) use ($current): string {
    if ($path === 'home') {
        return $current === 'home' ? 'active' : '';
    }

    return ($current === $path || strpos($current, $path . '/') === 0) ? 'active' : '';
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCar<?= isset($pageTitle) ? ' · ' . esc($pageTitle) : '' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<div class="app-shell">

    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <span class="logo"><?= mc_icon('car') ?></span>
            <span>
                <span class="name">MyCar</span>
                <span class="role"><?= $rol === 'admin' ? 'Administrador' : 'Cliente' ?></span>
            </span>
        </div>

        <nav>
            <a href="<?= site_url('home') ?>" class="<?= $navActive('home') ?>">
                <?= mc_icon('dashboard') ?> Menú principal
            </a>

            <?php if ($rol === 'admin'): ?>
                <div class="section-label">Mostrar</div>
                <a href="<?= site_url('vehiculos') ?>" class="<?= $navActive('vehiculos') ?>">
                    <?= mc_icon('car') ?> Vehículos disponibles
                </a>
                <a href="<?= site_url('admin/alquileres') ?>" class="<?= $navActive('admin/alquileres') ?>">
                    <?= mc_icon('key') ?> Alquileres vigentes
                </a>
                <a href="<?= site_url('admin/alquileres/historial') ?>" class="<?= $navActive('admin/alquileres/historial') ?>">
                    <?= mc_icon('list') ?> Historial de alquileres
                </a>
                <a href="<?= site_url('admin/alquileres/por-vehiculo') ?>" class="<?= $navActive('admin/alquileres/por-vehiculo') ?>">
                    <?= mc_icon('search') ?> Alquileres por vehículo
                </a>
                <a href="<?= site_url('admin/alquileres/por-cliente') ?>" class="<?= $navActive('admin/alquileres/por-cliente') ?>">
                    <?= mc_icon('search') ?> Alquileres por cliente
                </a>

                <div class="section-label">Altas / ABM</div>
                <a href="<?= site_url('admin/vehiculos') ?>" class="<?= $navActive('admin/vehiculos') ?>">
                    <?= mc_icon('car') ?> Vehículos (ABM)
                </a>
                <a href="<?= site_url('admin/clientes') ?>" class="<?= $navActive('admin/clientes') ?>">
                    <?= mc_icon('users') ?> Clientes (ABM)
                </a>
                <a href="<?= site_url('admin/reservas') ?>" class="<?= $navActive('admin/reservas') ?>">
                    <?= mc_icon('inbox') ?> Reservas pendientes
                </a>
            <?php else: ?>
                <div class="section-label">Cliente</div>
                <a href="<?= site_url('vehiculos') ?>" class="<?= $navActive('vehiculos') ?>">
                    <?= mc_icon('car') ?> Vehículos disponibles
                </a>
                <a href="<?= site_url('mis-reservas') ?>" class="<?= $navActive('mis-reservas') ?>">
                    <?= mc_icon('calendar') ?> Mis reservas y alquileres
                </a>
            <?php endif; ?>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= site_url('logout') ?>" data-confirm="¿Cerrar la sesión actual?">
                <?= mc_icon('logout') ?> Cerrar sesión
            </a>
        </div>
    </aside>

    <div class="main">
        <!-- Overlay oscuro para cerrar el sidebar en mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <header class="topbar">
            <!-- Botón hamburgesa: solo visible en mobile -->
            <button class="hamburger" id="hamburgerBtn" aria-label="Abrir menú" aria-expanded="false" aria-controls="sidebar">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="page-title"><?= isset($pageTitle) ? esc($pageTitle) : 'MyCar' ?></div>
            <div class="user-box">
                <span><strong><?= esc(session('usuario_nombre')) ?></strong></span>
                <span class="badge"><?= $rol === 'admin' ? 'Administrador' : 'Cliente' ?></span>
            </div>
        </header>

        <main class="content">
            <?php if (session('success')): ?>
                <div class="alert alert-success"><?= esc(session('success')) ?></div>
            <?php endif; ?>

            <?php if (session('error')): ?>
                <div class="alert alert-error"><?= esc(session('error')) ?></div>
            <?php endif; ?>

            <?php if (session('errors')): ?>
                <div class="alert alert-error">
                    <?php foreach (session('errors') as $err): ?>
                        <div><?= esc($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

<script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>