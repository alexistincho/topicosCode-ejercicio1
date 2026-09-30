<?php $pageTitle = 'Vehículos (ABM)'; ?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Vehículos</h1>
    <a href="<?= site_url('admin/vehiculos/nuevo') ?>" class="btn btn-primary">
        <?= mc_icon('plus') ?> Registrar vehículo
    </a>
</div>

<?php if (empty($vehiculos)): ?>
    <div class="card empty-state">Todavía no hay vehículos registrados.</div>
<?php else: ?>
    <div class="card table-wrap">
        <table>
            <thead>
            <tr>
                <th>Marca / Modelo</th>
                <th>Año</th>
                <th>Plazas</th>
                <th>Motor</th>
                <th>Kilometraje</th>
                <th>Precio/día</th>
                <th>Disponibilidad</th>
                <th>Estado</th>
                <th class="text-right">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($vehiculos as $v): ?>
                <tr>
                    <td><strong><?= esc($v['marca']) ?></strong> <?= esc($v['modelo']) ?></td>
                    <td><?= esc($v['anio']) ?></td>
                    <td><?= esc($v['plazas']) ?></td>
                    <td><?= esc($v['motor']) ?></td>
                    <td><?= number_format((float) $v['kilometraje'], 0, ',', '.') ?> km</td>
                    <td>$<?= number_format((float) $v['precio_dia'], 2, ',', '.') ?></td>
                    <td>
                        <?php if ($v['disponible']): ?>
                            <span class="badge badge-ok">Disponible</span>
                        <?php else: ?>
                            <span class="badge badge-warn">Alquilado</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($v['estado']): ?>
                            <span class="badge badge-ok">Activo</span>
                        <?php else: ?>
                            <span class="badge badge-bad">De baja</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-right">
                        <div class="actions-row" style="justify-content:flex-end;">
                            <a href="<?= site_url('admin/vehiculos/editar/' . $v['id']) ?>" class="btn btn-sm" title="Modificar">
                                <?= mc_icon('edit') ?>Modificar
                            </a>
                            <?php if ($v['estado']): ?>
                                <form method="post" action="<?= site_url('admin/vehiculos/baja/' . $v['id']) ?>" data-confirm="¿Dar de baja este vehículo?">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja">
                                        <?= mc_icon('trash') ?>Baja
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="post" action="<?= site_url('admin/vehiculos/alta/' . $v['id']) ?>" data-confirm="¿Reactivar este vehículo?">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-ok" title="Reactivar">
                                        <?= mc_icon('rotate') ?>Reactivar
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
