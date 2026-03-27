<h1 class="mb-4">Lista de Usuarios</h1>

<a href="/usuarios/create" class="btn btn-primary mb-3">Nuevo Usuario</a>

<?php if (empty($usuarios)): ?>
    <div class="alert alert-info">No hay usuarios registrados</div>
<?php else: ?>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Celular</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><?= htmlspecialchars($u['apellido']) ?></td>
                    <td><?= htmlspecialchars($u['correo']) ?></td>
                    <td><?= htmlspecialchars($u['celular'] ?? '-') ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($u['creado_en'])) ?></td>
                    <td>
                        <a href="/usuarios/show/<?= $u['id'] ?>" class="btn btn-sm btn-info">Ver</a>
                        <a href="/usuarios/edit/<?= $u['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <form action="/usuarios/delete/<?= $u['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar usuario?')">
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>