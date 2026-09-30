<?php $pageTitle = 'Menú principal'; ?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Hola, <?= esc(session('cliente_nombre') ?? session('usuario_nombre')) ?></h1>
</div>

<p class="text-muted">Desde aquí podés ver los vehículos disponibles y reservar el que necesites.</p>

<div class="menu-grid">
    <a href="<?= site_url('vehiculos') ?>" class="menu-tile">
        <div class="tile-icon"><?= mc_icon('car') ?></div>
        <h3>Vehículos disponibles</h3>
        <p>Consultá la flota disponible para alquilar y reservá el vehículo que prefieras.</p>
    </a>

    <a href="<?= site_url('mis-reservas') ?>" class="menu-tile">
        <div class="tile-icon"><?= mc_icon('calendar') ?></div>
        <h3>Mis reservas y alquileres</h3>
        <p>Revisá el estado de tus reservas y el historial de tus alquileres.</p>
    </a>
</div>

<?= $this->endSection() ?>
