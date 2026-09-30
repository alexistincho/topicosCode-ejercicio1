<?php $errors = session('errors') ?? []; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCar · Crear cuenta</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<div class="auth-page">
    <div class="auth-card wide">
        <div class="auth-brand">
            <span class="logo"><?= mc_icon('car') ?></span>
            <span class="name">MyCar</span>
        </div>

        <h1>Crear cuenta de cliente</h1>
        <p class="subtitle">Registrate para poder reservar vehículos</p>

        <?php if (session('error')): ?>
            <div class="alert alert-error"><?= esc(session('error')) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('registro') ?>">
            <?= csrf_field() ?>

            <h3>Datos de acceso</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="usuario">Nombre de usuario</label>
                    <input type="text" id="usuario" name="usuario" value="<?= old('usuario') ?>">
                    <?php if (isset($errors['usuario'])): ?><div class="field-error"><?= esc($errors['usuario']) ?></div><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= old('email') ?>">
                    <?php if (isset($errors['email'])): ?><div class="field-error"><?= esc($errors['email']) ?></div><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="contra">Contraseña</label>
                    <input type="password" id="contra" name="contra">
                    <?php if (isset($errors['contra'])): ?><div class="field-error"><?= esc($errors['contra']) ?></div><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="contra_confirm">Confirmar contraseña</label>
                    <input type="password" id="contra_confirm" name="contra_confirm">
                    <?php if (isset($errors['contra_confirm'])): ?><div class="field-error"><?= esc($errors['contra_confirm']) ?></div><?php endif; ?>
                </div>
            </div>

            <h3>Datos personales</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?= old('nombre') ?>">
                    <?php if (isset($errors['nombre'])): ?><div class="field-error"><?= esc($errors['nombre']) ?></div><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" value="<?= old('apellido') ?>">
                    <?php if (isset($errors['apellido'])): ?><div class="field-error"><?= esc($errors['apellido']) ?></div><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" value="<?= old('direccion') ?>">
                    <?php if (isset($errors['direccion'])): ?><div class="field-error"><?= esc($errors['direccion']) ?></div><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" value="<?= old('telefono') ?>">
                    <?php if (isset($errors['telefono'])): ?><div class="field-error"><?= esc($errors['telefono']) ?></div><?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Crear cuenta</button>
        </form>

        <div class="auth-footer">
            ¿Ya tenés cuenta? <a href="<?= site_url('login') ?>">Iniciar sesión</a>
        </div>
    </div>
</div>
</body>
</html>
