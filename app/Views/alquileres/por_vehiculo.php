<?php $pageTitle = 'Alquileres por vehículo'; ?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Alquileres por vehículo</h1>
</div>

<p class="text-muted">Seleccioná un vehículo para ver todos los clientes que lo alquilaron.</p>

<div class="card">
    <form method="get" action="<?= site_url('admin/alquileres/por-vehiculo') ?>" class="form-inline">
        <div class="form-group" style="flex:1;">
            <label for="vehiculo_id">Vehículo</label>
            <select id="vehiculo_id" name="vehiculo_id" onchange="this.form.submit()">
                <option value="0">— Seleccione un vehículo —</option>
                <?php foreach ($vehiculos as $v): ?>
                    <option value="<?= esc($v['id']) ?>" <?= $vehiculoId === (int) $v['id'] ? 'selected' : '' ?>>
                        <?= esc($v['marca']) ?> <?= esc($v['modelo']) ?> (<?= esc($v['anio']) ?>)<?= $v['estado'] ? '' : ' — de baja' ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><?= mc_icon('search') ?> Buscar</button>
    </form>
</div>

<?php if ($vehiculoId > 0): ?>
    <h2>
        <?= $vehiculo ? esc($vehiculo['marca']) . ' ' . esc($vehiculo['modelo']) . ' (' . esc($vehiculo['anio']) . ')' : 'Vehículo' ?>
        — clientes que lo alquilaron
    </h2>

    <?php if (empty($resultados)): ?>
        <div class="card empty-state">Ese vehículo todavía no fue alquilado por ningún cliente.</div>
    <?php else: ?>
        <div class="card table-wrap">
            <table>
                <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($resultados as $r): ?>
                    <tr>
                        <td><?= esc($r['nombre']) ?> <?= esc($r['apellido']) ?></td>
                        <td><?= esc($r['telefono']) ?></td>
                        <td><?= esc($r['email']) ?></td>
                        <td class="nowrap"><?= esc($r['fecha_desde']) ?></td>
                        <td class="nowrap"><?= esc($r['fecha_hasta']) ?></td>
                        <td>
                            <?php if ($r['devuelto']): ?>
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
<?php endif; ?>

<?= $this->endSection() ?>
