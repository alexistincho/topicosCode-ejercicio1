<?php
$pageTitle = 'Modificar cliente';
$errors    = session('errors') ?? [];

$val = static function (string $key, $fallback = '') {
    $old = old($key, null, false);

    return esc($old ?? $fallback);
};
?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1><?= esc($pageTitle) ?>: <?= esc($cliente['nombre']) ?> <?= esc($cliente['apellido']) ?></h1>
    <a href="<?= site_url('admin/clientes') ?>" class="btn btn-sm"><?= mc_icon('arrow-left') ?> Volver</a>
</div>

<div class="card">
    <p class="text-muted">
        Usuario: <strong><?= esc($cliente['usuario']) ?></strong> ·
        Email: <strong><?= esc($cliente['email']) ?></strong> ·
        Alta: <?= esc($cliente['fecha_alta']) ?>
    </p>

    <form method="post" action="<?= site_url('admin/clientes/actualizar/' . $cliente['id']) ?>">
        <?= csrf_field() ?>

        <div class="form-grid">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= $val('nombre', $cliente['nombre']) ?>">
                <?php if (isset($errors['nombre'])): ?><div class="field-error"><?= esc($errors['nombre']) ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="<?= $val('apellido', $cliente['apellido']) ?>">
                <?php if (isset($errors['apellido'])): ?><div class="field-error"><?= esc($errors['apellido']) ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" value="<?= $val('direccion', $cliente['direccion']) ?>">
                <?php if (isset($errors['direccion'])): ?><div class="field-error"><?= esc($errors['direccion']) ?></div><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="<?= $val('telefono', $cliente['telefono']) ?>">
                <?php if (isset($errors['telefono'])): ?><div class="field-error"><?= esc($errors['telefono']) ?></div><?php endif; ?>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= mc_icon('check') ?> Guardar</button>
            <a href="<?= site_url('admin/clientes') ?>" class="btn">Cancelar</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
