<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<section class="container mt-4 shadow-lg p-4 rounded-2 border border-warning" style="width: 29rem;">
    <h1 class="text-warning">Editar Usuario</h1>

    <form method="POST" action="<?= BASE_URL ?>user/update/<?= $user['id_usuario'] ?>">
        <div class="mb-3">
            <label class="form-label">Nombres</label>
            <input type="text" name="nombres" class="form-control" 
                   value="<?= htmlspecialchars($user['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Apellido Paterno</label>
            <input type="text" name="apaterno" class="form-control" 
                   value="<?= htmlspecialchars($user['apaterno']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Apellido Materno</label>
            <input type="text" name="amaterno" class="form-control" 
                   value="<?= htmlspecialchars($user['amaterno']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" name="correo" class="form-control" 
                   value="<?= htmlspecialchars($user['correo']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nueva Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" name="contrasena" class="form-control" minlength="6">
        </div>
        <div class="mb-3">
            <label class="form-label">Rol</label>
            <select name="id_rol" class="form-select" required>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id_rol'] ?>" 
                        <?= $role['id_rol'] == $user['id_rol'] ? 'selected' : '' ?>>
                        <?= $role['rol'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="<?= BASE_URL ?>user/index" class="btn btn-secondary">Cancelar</a>
    </form>
</section>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>