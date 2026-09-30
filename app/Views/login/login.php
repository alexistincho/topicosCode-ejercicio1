<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCar · Iniciar sesión</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-brand">
            <span class="logo"><?= mc_icon('car') ?></span>
            <span class="name">MyCar</span>
        </div>

        <h1>Iniciar sesión</h1>
        <p class="subtitle">Sistema de alquiler de vehículos</p>

        <?php if (session('success')): ?>
            <div class="alert alert-success"><?= esc(session('success')) ?></div>
        <?php endif; ?>

        <?php if (session('error')): ?>
            <div class="alert alert-error"><?= esc(session('error')) ?></div>
        <?php endif; ?>

        <?php if (session('errors')): ?>
            <div class="alert alert-error">
                <?php foreach (session('errors') as $err): ?>
                    <div><?= esc($err) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('login') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="login">Usuario o email</label>
                <input type="text" id="login" name="login" value="<?= old('login') ?>" autofocus>
            </div>

            <div class="form-group">
                <label for="contra">Contraseña</label>
                <input type="password" id="contra" name="contra">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
        </form>

        <div class="auth-footer">
            ¿No tenés cuenta? <a href="<?= site_url('registro') ?>">Registrate como cliente</a>
        </div>
    </div>
</div>
</body>
</html>
