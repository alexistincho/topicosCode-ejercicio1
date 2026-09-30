<?php $pageTitle = 'Alquileres por cliente'; ?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Alquileres por cliente</h1>
</div>

<p class="text-muted">Seleccioná un cliente para ver todos los vehículos que alquiló.</p>

<div class="card">
    <form method="get" action="<?= site_url('admin/alquileres/por-cliente') ?>" class="form-inline">
        <div class="form-group" style="flex:1;">
            <label for="cliente_id">Cliente</label>
            <select id="cliente_id" name="cliente_id" onchange="this.form.submit()">
                <option value="0">— Seleccione un cliente —</option>
                <?php foreach ($clientes as $c): ?>
                    <option value="<?= esc($c['id']) ?>" <?= $clienteId === (int) $c['id'] ? 'selected' : '' ?>>
                        <?= esc($c['nombre']) ?> <?= esc($c['apellido']) ?><?= $c['estado'] ? '' : ' — de baja' ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><?= mc_icon('search') ?> Buscar</button>
    </form>
</div>

<?php if ($clienteId > 0): ?>
    <h2>
        <?= $cliente ? esc($cliente['nombre']) . ' ' . esc($cliente['apellido']) : 'Cliente' ?>
        — vehículos alquilados
    </h2>

    <?php if (empty($resultados)): ?>
        <div class="card empty-state">Ese cliente todavía no alquiló ningún vehículo.</div>
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
                <?php foreach ($resultados as $r): ?>
                    <tr>
                        <td><?= esc($r['marca']) ?> <?= esc($r['modelo']) ?> (<?= esc($r['anio']) ?>)</td>
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
