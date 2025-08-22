<?php require_once APP_DIR . '/views/layouts/header.php'; ?>

<section class="container mt-4 shadow-lg p-4 rounded-2 border border-success" style="width: 29rem;">
<h1 class="mb-2">Crear Nuevo Usuario</h1>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    <?= htmlspecialchars($_SESSION['error']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php unset($_SESSION['error']); endif; ?>

<form id="userForm" method="POST" action="<?= BASE_URL ?>user/store" class="needs-validation" novalidate>
    <div class="mb-2">
        <label for="nombres" class="form-label">Nombres *</label>
        <input type="text" id="nombres" name="nombres" class="form-control" pattern="[a-zA-Z\s]+" required>
        <div class="invalid-feedback text-warning">Por favor ingrese sus nombres (solo letras y espacios).</div>
        <div class="valid-feedback text-success">Campo válido.</div>
    </div>
    <div class="mb-2">
        <label for="apaterno" class="form-label">Apellido Paterno *</label>
        <input type="text" id="apaterno" name="apaterno" class="form-control" pattern="[a-zA-Z\s]+" required>
        <div class="invalid-feedback text-warning">Por favor ingrese su apellido paterno (solo letras y espacios).</div>
        <div class="valid-feedback text-success">Campo válido.</div>
    </div>
    <div class="mb-2">
        <label for="amaterno" class="form-label">Apellido Materno *</label>
        <input type="text" id="amaterno" name="amaterno" class="form-control" pattern="[a-zA-Z\s]+" required>
        <div class="invalid-feedback text-warning">Por favor ingrese su apellido materno (solo letras y espacios).</div>
        <div class="valid-feedback text-success">Campo válido.</div>
    </div>
    <div class="mb-2">
        <label for="correo" class="form-label">Correo Electrónico *</label>
        <input type="email" id="correo" name="correo" class="form-control" required>
        <div class="invalid-feedback text-warning">Por favor ingrese un correo electrónico válido.</div>
        <div class="valid-feedback text-success">Campo válido.</div>
    </div>
    <div class="mb-2">
        <label for="contrasena" class="form-label">Contrasena *</label>
        <input type="password" id="contrasena" name="contrasena" class="form-control"
        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}" required>
        <div class="invalid-feedback text-warning">
            La contrasena debe tener al menos 8 caracteres con:
            <ul class="mb-0 ps-3">
                <li>Una mayúscula</li>
                <li>Una minúscula</li>
                <li>Un número</li>
                <li>Un carácter especial (@$!%*?&)</li>
            </ul>
        </div>
        <div class="form-text text-info">Mínimo 8 caracteres con mayúsculas, minúsculas, números y caracteres especiales</div>
        <div class="valid-feedback text-success">Contrasena válida.</div>
    </div>
    <div class="mb-2">
        <label for="contrasena_confirm" class="form-label">Confirmar Contrasena *</label>
        <input type="password" id="contrasena_confirm" name="contrasena_confirm" class="form-control" required>
        <div class="invalid-feedback text-warning">Las contrasenas no coinciden.</div>
        <div class="valid-feedback text-success">Las contrasenas coinciden.</div>
    </div>
    <div class="mb-3">
        <label for="id_rol" class="form-label">Rol *</label>
        <select id="id_rol" name="id_rol" class="form-select" required>
            <option value="" selected disabled>Seleccione un rol</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id_rol'] ?>"><?= htmlspecialchars($role['rol']) ?></option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback text-warning">Por favor seleccione un rol.</div>
        <div class="valid-feedback text-success">Rol seleccionado.</div>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="reset" class="btn btn-outline-warning me-md-2">Limpiar</button>
        <a href="<?= BASE_URL ?>user" class="btn btn-outline-secondary me-md-2">Cancelar</a>
        <button type="submit" class="btn btn-outline-success">Guardar</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('userForm');
    const contrasena = document.getElementById('contrasena');
    const contrasenaConfirm = document.getElementById('contrasena_confirm');
    const nameFields = ['nombres', 'apaterno', 'amaterno'];
    const textPattern = new RegExp ('^[a-zA-ZáéíóúÁÉÍÓÚñÑ\\s]+$');
    const passwordPattern = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}/;

    form.addEventListener('submit', function(event) {
        // Validar que las contraseñas coincidan
        if (contrasena.value !== contrasenaConfirm.value) {
            contrasenaConfirm.setCustomValidity('Las contraseñas no coinciden');
        } else {
            contrasenaConfirm.setCustomValidity('');
        }

        // Validar patrón de la contraseña
        if (!passwordPattern.test(contrasena.value)) {
            contrasena.setCustomValidity('La contraseña no cumple el patrón requerido');
        } else {
            contrasena.setCustomValidity('');
        }

        // Validar nombres y apellidos
        nameFields.forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (input.value.trim() !== '' && !textPattern.test(input.value)) {
                input.setCustomValidity('Solo se permiten letras y espacios.');
            } else {
                input.setCustomValidity('');
            }
        });

        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        form.classList.add('was-validated');
    }, false);

    contrasenaConfirm.addEventListener('input', function() {
        if (contrasena.value !== contrasenaConfirm.value) {
            contrasenaConfirm.setCustomValidity('Las contraseñas no coinciden');
            contrasenaConfirm.classList.add('is-invalid');
            contrasenaConfirm.classList.remove('is-valid');
        } else {
            contrasenaConfirm.setCustomValidity('');
            contrasenaConfirm.classList.remove('is-invalid');
            contrasenaConfirm.classList.add('is-valid');
        }
    });

    Array.from(form.elements).forEach(element => {
        element.addEventListener('input', function() {
            if (nameFields.includes(element.id)) {
                if (element.value.trim() !== '' && !textPattern.test(element.value)) {
                    element.setCustomValidity('Solo se permiten letras y espacios.');
                    element.classList.add('is-invalid');
                    element.classList.remove('is-valid');
                } else {
                    element.setCustomValidity('');
                    if (element.value.trim() !== '') {
                        element.classList.remove('is-invalid');
                        element.classList.add('is-valid');
                    } else {
                        element.classList.remove('is-invalid');
                        element.classList.remove('is-valid');
                    }
                }
            } else if (element.id === 'contrasena_confirm') {
                // ya manejado arriba
            } else {
                if (element.checkValidity()) {
                    element.classList.remove('is-invalid');
                    element.classList.add('is-valid');
                } else {
                    element.classList.remove('is-valid');
                }
            }
        });

        element.addEventListener('focus', function() {
            if (!this.checkValidity()) {
                this.classList.add('is-invalid');
            }
        });

        element.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                if (this.required && this.value.trim() === '') {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (this.value.trim() !== '') {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.remove('is-valid');
                }
            }
        });
    });
});
</script>

<?php require_once APP_DIR . '/views/layouts/footer.php'; ?>
