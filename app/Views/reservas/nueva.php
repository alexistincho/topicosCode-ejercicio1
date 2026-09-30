<?php
$pageTitle = 'Reservar vehículo';
$errors    = session('errors') ?? [];
?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Reservar vehículo</h1>
    <a href="<?= site_url('vehiculos') ?>" class="btn btn-sm"><?= mc_icon('arrow-left') ?> Volver</a>
</div>

<div class="card">
    <div class="vehicle-card" style="margin-bottom:1.2rem; max-width:320px;">
        <div class="vehicle-icon"><?= mc_icon('car') ?></div>
        <div>
            <div class="vehicle-title"><?= esc($vehiculo['marca']) ?> <?= esc($vehiculo['modelo']) ?></div>
            <div class="vehicle-sub">Año <?= esc($vehiculo['anio']) ?></div>
        </div>
        <div class="vehicle-specs">
            <span>Plazas: <strong><?= esc($vehiculo['plazas']) ?></strong></span>
            <span>Motor: <strong><?= esc($vehiculo['motor']) ?></strong></span>
        </div>
        <div class="vehicle-price">$<?= number_format((float) $vehiculo['precio_dia'], 2, ',', '.') ?> <small>/ día</small></div>
    </div>

    <form method="post" action="<?= site_url('reservas') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="vehiculo_id" value="<?= esc($vehiculo['id']) ?>">

        <div class="form-grid">
            <div class="form-group">
                <label for="fecha_desde">Fecha desde</label>
                <input type="date" id="fecha_desde" name="fecha_desde" value="<?= old('fecha_desde') ?>" data-min-today>
                <?php if (isset($errors['fecha_desde'])): ?><div class="field-error"><?= esc($errors['fecha_desde']) ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="cantidad_dias">Cantidad de días</label>
                <input type="number" id="cantidad_dias" name="cantidad_dias" value="<?= old('cantidad_dias') ?: 1 ?>" min="1" max="60">
                <?php if (isset($errors['cantidad_dias'])): ?><div class="field-error"><?= esc($errors['cantidad_dias']) ?></div><?php endif; ?>
                <span class="hint">La reserva quedará pendiente de aprobación por el administrador.</span>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= mc_icon('calendar') ?> Enviar reserva</button>
            <a href="<?= site_url('vehiculos') ?>" class="btn">Cancelar</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
