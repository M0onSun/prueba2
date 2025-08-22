<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<section class="container login-container">
    <div class="login-card">
        <h3 class="text-center mb-5">Iniciar Sesión</h3>
        <div class="login-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                    <button type="reset" class="btn btn-outline-light">Limpiar</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>