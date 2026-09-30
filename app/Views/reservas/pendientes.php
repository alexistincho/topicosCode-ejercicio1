<?php $pageTitle = 'Reservas pendientes'; ?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Reservas pendientes</h1>
</div>

<p class="text-muted">Aprobá una reserva para registrarla como alquiler, o rechazala si el vehículo ya no está disponible.</p>

<?php if (empty($reservas)): ?>
    <div class="card empty-state">No hay reservas pendientes en este momento.</div>
<?php else: ?>
    <div class="card table-wrap">
        <table>
            <thead>
            <tr>
                <th>Cliente</th>
                <th>Email</th>
                <th>Vehículo</th>
                <th>Fecha desde</th>
                <th>Días</th>
                <th>Precio/día</th>
                <th class="text-right">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reservas as $r): ?>
                <tr>
                    <td><?= esc($r['nombre']) ?> <?= esc($r['apellido']) ?></td>
                    <td><?= esc($r['email']) ?></td>
                    <td><?= esc($r['marca']) ?> <?= esc($r['modelo']) ?></td>
                    <td class="nowrap"><?= esc($r['fecha_desde']) ?></td>
                    <td><?= esc($r['cantidad_dias']) ?></td>
                    <td>$<?= number_format((float) $r['precio_dia'], 2, ',', '.') ?></td>
                    <td class="text-right">
                        <div class="actions-row" style="justify-content:flex-end;">
                            <form method="post" action="<?= site_url('admin/reservas/aprobar/' . $r['id']) ?>" data-confirm="¿Aprobar esta reserva y registrarla como alquiler?">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-ok"><?= mc_icon('check') ?> Aprobar</button>
                            </form>
                            <form method="post" action="<?= site_url('admin/reservas/rechazar/' . $r['id']) ?>" data-confirm="¿Rechazar esta reserva?">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger"><?= mc_icon('x') ?> Rechazar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
