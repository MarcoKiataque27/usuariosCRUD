<h1 class="mb-4">Detalle del Usuario</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($usuario->getNombre() . ' ' . $usuario->getApellido()) ?></h5>
        <p class="card-text">
            <strong>ID:</strong> <?= $usuario->getId() ?><br>
            <strong>Correo:</strong> <?= htmlspecialchars($usuario->getCorreo()) ?><br>
            <strong>Celular:</strong> <?= htmlspecialchars($usuario->getCelular() ?? '-') ?><br>
            <strong>Creado:</strong> <?= date('d/m/Y H:i', strtotime($usuario->getCreadoEn())) ?><br>
            <strong>Actualizado:</strong> <?= date('d/m/Y H:i', strtotime($usuario->getActualizadoEn())) ?>
        </p>
        <a href="/usuarios/edit/<?= $usuario->getId() ?>" class="btn btn-warning">Editar</a>
        <form action="/usuarios/delete/<?= $usuario->getId() ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar usuario?')">
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
        <a href="/usuarios" class="btn btn-secondary">Volver</a>
    </div>
</div>