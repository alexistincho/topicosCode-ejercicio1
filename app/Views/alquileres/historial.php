<?php $pageTitle = 'Historial de alquileres'; ?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Historial de alquileres</h1>
</div>

<?php if (empty($alquileres)): ?>
    <div class="card empty-state">Todavía no hay alquileres registrados.</div>
<?php else: ?>
    <div class="card table-wrap">
        <table>
            <thead>
            <tr>
                <th>Vehículo</th>
                <th>Cliente</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th>Devolución</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($alquileres as $a): ?>
                <tr>
                    <td><?= esc($a['marca']) ?> <?= esc($a['modelo']) ?> (<?= esc($a['anio']) ?>)</td>
                    <td><?= esc($a['nombre']) ?> <?= esc($a['apellido']) ?></td>
                    <td class="nowrap"><?= esc($a['fecha_desde']) ?></td>
                    <td class="nowrap"><?= esc($a['fecha_hasta']) ?></td>
                    <td class="nowrap"><?= $a['fecha_devolucion'] ? esc($a['fecha_devolucion']) : '—' ?></td>
                    <td>
                        <?php if ($a['devuelto']): ?>
                            <span class="badge">Devuelto</span>
                        <?php else: ?>
                            <span class="badge badge-ok">Vigente</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
