<?php $pageTitle = 'Clientes (ABM)'; ?>
<?= $this->extend('insider/layout') ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Clientes</h1>
</div>

<p class="text-muted">Los clientes se registran ellos mismos desde la pantalla de inicio de sesión. Aquí podés modificar sus datos o darlos de baja.</p>

<?php if (empty($clientes)): ?>
    <div class="card empty-state">Todavía no hay clientes registrados.</div>
<?php else: ?>
    <div class="card table-wrap">
        <table>
            <thead>
            <tr>
                <th>Nombre y apellido</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Fecha de alta</th>
                <th>Estado</th>
                <th class="text-right">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($clientes as $c): ?>
                <tr>
                    <td><strong><?= esc($c['nombre']) ?> <?= esc($c['apellido']) ?></strong></td>
                    <td><?= esc($c['usuario']) ?></td>
                    <td><?= esc($c['email']) ?></td>
                    <td><?= esc($c['direccion']) ?></td>
                    <td><?= esc($c['telefono']) ?></td>
                    <td class="nowrap"><?= esc($c['fecha_alta']) ?></td>
                    <td>
                        <?php if ($c['estado']): ?>
                            <span class="badge badge-ok">Activo</span>
                        <?php else: ?>
                            <span class="badge badge-bad">De baja</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-right">
                        <div class="actions-row" style="justify-content:flex-end;">
                            <a href="<?= site_url('admin/clientes/editar/' . $c['id']) ?>" class="btn btn-sm" title="Modificar">
                                <?= mc_icon('edit') ?>Editar
                            </a>
                            <?php if ($c['estado']): ?>
                                <form method="post" action="<?= site_url('admin/clientes/baja/' . $c['id']) ?>" data-confirm="¿Dar de baja este cliente?">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja">
                                        <?= mc_icon('trash') ?>Baja
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="post" action="<?= site_url('admin/clientes/alta/' . $c['id']) ?>" data-confirm="¿Reactivar este cliente?">
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
