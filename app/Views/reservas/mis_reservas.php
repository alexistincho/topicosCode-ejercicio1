<?php $pageTitle = 'Mis reservas y alquileres'; ?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Mis reservas</h1>
</div>

<?php if (empty($reservas)): ?>
    <div class="card empty-state">Todavía no realizaste ninguna reserva.</div>
<?php else: ?>
    <div class="card table-wrap">
        <table>
            <thead>
            <tr>
                <th>Vehículo</th>
                <th>Fecha desde</th>
                <th>Días</th>
                <th>Precio/día</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reservas as $r): ?>
                <tr>
                    <td><?= esc($r['marca']) ?> <?= esc($r['modelo']) ?></td>
                    <td class="nowrap"><?= esc($r['fecha_desde']) ?></td>
                    <td><?= esc($r['cantidad_dias']) ?></td>
                    <td>$<?= number_format((float) $r['precio_dia'], 2, ',', '.') ?></td>
                    <td>
                        <?php if ($r['estado'] === 'pendiente'): ?>
                            <span class="badge badge-warn">Pendiente</span>
                        <?php elseif ($r['estado'] === 'aprobada'): ?>
                            <span class="badge badge-ok">Aprobada</span>
                        <?php else: ?>
                            <span class="badge badge-bad">Rechazada</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<h2>Mis alquileres</h2>

<?php if (empty($alquileres)): ?>
    <div class="card empty-state">Todavía no tenés alquileres registrados.</div>
<?php else: ?>
    <div class="card table-wrap">
        <table>
            <thead>
            <tr>
                <th>Vehículo</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($alquileres as $a): ?>
                <tr>
                    <td><?= esc($a['marca']) ?> <?= esc($a['modelo']) ?></td>
                    <td class="nowrap"><?= esc($a['fecha_desde']) ?></td>
                    <td class="nowrap"><?= esc($a['fecha_hasta']) ?></td>
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
