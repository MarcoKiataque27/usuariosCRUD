<h1 class="mb-4">Nuevo Usuario</h1>

<form method="POST" action="/usuarios/store">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($_SESSION['old']['nombre'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($_SESSION['old']['apellido'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label for="correo" class="form-label">Correo</label>
        <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($_SESSION['old']['correo'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label for="celular" class="form-label">Celular</label>
        <input type="text" class="form-control" id="celular" name="celular" value="<?= htmlspecialchars($_SESSION['old']['celular'] ?? '') ?>">
    </div>
    <button type="submit" class="btn btn-primary">Crear</button>
    <a href="/usuarios" class="btn btn-secondary">Cancelar</a>
</form>

<?php unset($_SESSION['old']); ?>