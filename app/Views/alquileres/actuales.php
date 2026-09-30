<?php $pageTitle = 'Alquileres vigentes'; ?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Alquileres vigentes</h1>
</div>

<p class="text-muted">Vehículos actualmente alquilados, con los datos del cliente que los alquiló. Registrá la devolución cuando el vehículo sea entregado.</p>

<?php if (empty($alquileres)): ?>
    <div class="card empty-state">No hay alquileres vigentes en este momento.</div>
<?php else: ?>
    <div class="card table-wrap">
        <table>
            <thead>
            <tr>
                <th>Vehículo</th>
                <th>Cliente</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th class="text-right">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($alquileres as $a): ?>
                <tr>
                    <td><?= esc($a['marca']) ?> <?= esc($a['modelo']) ?> (<?= esc($a['anio']) ?>)</td>
                    <td><?= esc($a['nombre']) ?> <?= esc($a['apellido']) ?></td>
                    <td><?= esc($a['telefono']) ?></td>
                    <td><?= esc($a['email']) ?></td>
                    <td class="nowrap"><?= esc($a['fecha_desde']) ?></td>
                    <td class="nowrap"><?= esc($a['fecha_hasta']) ?></td>
                    <td class="text-right">
                        <form method="post" action="<?= site_url('admin/alquileres/devolver/' . $a['id']) ?>" data-confirm="¿Registrar la devolución de este vehículo?">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-ok"><?= mc_icon('rotate') ?> Registrar devolución</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
