<?php $pageTitle = 'Menú principal'; ?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Panel de administración</h1>
</div>

<div class="card-grid">
    <div class="stat-card">
        <div class="stat-value"><?= (int) $vehiculosDisponibles ?></div>
        <div class="stat-label">Vehículos disponibles</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= (int) $totalVehiculos ?></div>
        <div class="stat-label">Vehículos de alta</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= (int) $totalClientes ?></div>
        <div class="stat-label">Clientes activos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= (int) $reservasPendientes ?></div>
        <div class="stat-label">Reservas pendientes</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= (int) $alquileresActivos ?></div>
        <div class="stat-label">Alquileres vigentes</div>
    </div>
</div>

<h2>Accesos rápidos</h2>
<div class="menu-grid">
    <a href="<?= site_url('admin/vehiculos/nuevo') ?>" class="menu-tile">
        <div class="tile-icon"><?= mc_icon('plus') ?></div>
        <h3>Registrar vehículo</h3>
        <p>Da de alta un nuevo vehículo en la flota.</p>
    </a>

    <a href="<?= site_url('admin/reservas') ?>" class="menu-tile">
        <div class="tile-icon"><?= mc_icon('inbox') ?></div>
        <h3>Reservas pendientes</h3>
        <p>Aprobá una reserva para registrarla como alquiler, o rechazala.</p>
    </a>

    <a href="<?= site_url('admin/alquileres') ?>" class="menu-tile">
        <div class="tile-icon"><?= mc_icon('key') ?></div>
        <h3>Alquileres vigentes</h3>
        <p>Vehículos alquilados actualmente y registro de devoluciones.</p>
    </a>

    <a href="<?= site_url('admin/vehiculos') ?>" class="menu-tile">
        <div class="tile-icon"><?= mc_icon('car') ?></div>
        <h3>ABM de vehículos</h3>
        <p>Modificá datos o da de baja un vehículo existente.</p>
    </a>

    <a href="<?= site_url('admin/clientes') ?>" class="menu-tile">
        <div class="tile-icon"><?= mc_icon('users') ?></div>
        <h3>ABM de clientes</h3>
        <p>Modificá datos o da de baja un cliente existente.</p>
    </a>

    <a href="<?= site_url('admin/alquileres/historial') ?>" class="menu-tile">
        <div class="tile-icon"><?= mc_icon('list') ?></div>
        <h3>Historial de alquileres</h3>
        <p>Listado completo de alquileres, vigentes y devueltos.</p>
    </a>
</div>

<?= $this->endSection() ?>
