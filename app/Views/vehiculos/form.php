<?php
$pageTitle = $modo === 'crear' ? 'Registrar vehículo' : 'Modificar vehículo';
$accion    = $modo === 'crear' ? site_url('admin/vehiculos') : site_url('admin/vehiculos/actualizar/' . $vehiculo['id']);
$errors    = session('errors') ?? [];

$val = static function (string $key, $fallback = '') {
    $old = old($key, null, false);

    return esc($old ?? $fallback);
};
?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1><?= esc($pageTitle) ?></h1>
    <a href="<?= site_url('admin/vehiculos') ?>" class="btn btn-sm"><?= mc_icon('arrow-left') ?> Volver</a>
</div>

<div class="card">
    <form method="post" action="<?= $accion ?>">
        <?= csrf_field() ?>

        <div class="form-grid">
            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" id="marca" name="marca" value="<?= $val('marca', $vehiculo['marca'] ?? '') ?>">
                <?php if (isset($errors['marca'])): ?><div class="field-error"><?= esc($errors['marca']) ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" id="modelo" name="modelo" value="<?= $val('modelo', $vehiculo['modelo'] ?? '') ?>">
                <?php if (isset($errors['modelo'])): ?><div class="field-error"><?= esc($errors['modelo']) ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="anio">Año</label>
                <input type="number" id="anio" name="anio" value="<?= $val('anio', $vehiculo['anio'] ?? '') ?>" min="1980" max="<?= (int) date('Y') + 1 ?>">
                <?php if (isset($errors['anio'])): ?><div class="field-error"><?= esc($errors['anio']) ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="plazas">Cantidad de plazas</label>
                <input type="number" id="plazas" name="plazas" value="<?= $val('plazas', $vehiculo['plazas'] ?? '') ?>" min="1" max="9">
                <?php if (isset($errors['plazas'])): ?><div class="field-error"><?= esc($errors['plazas']) ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="motor">Motor</label>
                <input type="text" id="motor" name="motor" value="<?= $val('motor', $vehiculo['motor'] ?? '') ?>" placeholder="Ej: 1.6 Nafta">
                <?php if (isset($errors['motor'])): ?><div class="field-error"><?= esc($errors['motor']) ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="kilometraje">Kilometraje</label>
                <input type="number" step="0.01" id="kilometraje" name="kilometraje" value="<?= $val('kilometraje', $vehiculo['kilometraje'] ?? '') ?>" min="0">
                <?php if (isset($errors['kilometraje'])): ?><div class="field-error"><?= esc($errors['kilometraje']) ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="precio_dia">Precio de alquiler por día ($)</label>
                <input type="number" step="0.01" id="precio_dia" name="precio_dia" value="<?= $val('precio_dia', $vehiculo['precio_dia'] ?? '') ?>" min="0.01">
                <?php if (isset($errors['precio_dia'])): ?><div class="field-error"><?= esc($errors['precio_dia']) ?></div><?php endif; ?>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= mc_icon('check') ?> Guardar</button>
            <a href="<?= site_url('admin/vehiculos') ?>" class="btn">Cancelar</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
