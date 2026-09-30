<?php $pageTitle = 'Vehículos disponibles'; ?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Vehículos disponibles</h1>
</div>

<?php if (empty($vehiculos)): ?>
    <div class="card empty-state">No hay vehículos disponibles para alquilar en este momento.</div>
<?php else: ?>
    <div class="vehicle-grid">
        <?php foreach ($vehiculos as $v): ?>
            <div class="vehicle-card">
                <div class="vehicle-icon"><?= mc_icon('car') ?></div>
                <div>
                    <div class="vehicle-title"><?= esc($v['marca']) ?> <?= esc($v['modelo']) ?></div>
                    <div class="vehicle-sub">Año <?= esc($v['anio']) ?></div>
                </div>

                <div class="vehicle-specs">
                    <span>Plazas: <strong><?= esc($v['plazas']) ?></strong></span>
                    <span>Motor: <strong><?= esc($v['motor']) ?></strong></span>
                    <span>Kilometraje: <strong><?= number_format((float) $v['kilometraje'], 0, ',', '.') ?> km</strong></span>
                </div>

                <div class="vehicle-price">
                    $<?= number_format((float) $v['precio_dia'], 2, ',', '.') ?> <small>/ día</small>
                </div>

                <?php if (session('rol') === 'cliente'): ?>
                    <a href="<?= site_url('vehiculos/reservar/' . $v['id']) ?>" class="btn btn-primary btn-block">
                        <?= mc_icon('calendar') ?> Reservar
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
