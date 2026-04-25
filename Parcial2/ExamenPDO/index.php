<?php
require_once "autoload.php";
use App\Controllers\ProductoController;
use App\Models\Producto;

$controller = new ProductoController();
$mensaje = "";
$pEdit = null;
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

if(isset($_GET['eliminar'])) {
    if($controller->eliminar($_GET['eliminar'])) $mensaje = "Producto eliminado.";
}

if(isset($_GET['editar'])) {
    $d = $controller->obtenerPorId($_GET['editar']);
    if($d) $pEdit = new Producto($d['id'], $d['nombre'], $d['descripcion'], $d['existencia'], $d['precio']);
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p = new Producto($_POST['id'] ?: null, $_POST['nombre'], $_POST['descripcion'], $_POST['existencia'], $_POST['precio']);
    $res = $p->getId() ? $controller->actualizar($p) : $controller->crear($p);
    $mensaje = $res ? "Operación exitosa." : "Error en la operación.";
}

$productos = ($busqueda !== '') ? $controller->buscar($busqueda) : $controller->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Examen PDO Rios R. Mia Yolanda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2 class="text-center">Sistema de Productos</h2>
    <p class="text-center text-muted">por: Rios R. Mia Yolanda</p>

    <?php if($mensaje): ?> <div class="alert alert-info"><?= $mensaje ?></div> <?php endif; ?>

    <div class="card card-body mb-4 shadow-sm">
        <form method="POST">
            <input type="hidden" name="id" value="<?= $pEdit ? $pEdit->getId() : '' ?>">
            <div class="row g-2">
                <div class="col-md-3"><input type="text" name="nombre" class="form-control" placeholder="Nombre" value="<?= $pEdit ? $pEdit->getNombre() : '' ?>" required></div>
                <div class="col-md-4"><input type="text" name="descripcion" class="form-control" placeholder="Descripción" value="<?= $pEdit ? $pEdit->getDescripcion() : '' ?>" required></div>
                <div class="col-md-2"><input type="number" name="existencia" class="form-control" placeholder="Cant." value="<?= $pEdit ? $pEdit->getExistencia() : '' ?>" required></div>
                <div class="col-md-2"><input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" value="<?= $pEdit ? $pEdit->getPrecio() : '' ?>" required></div>
                <div class="col-md-1"><button type="submit" class="btn btn-success w-100"><?= $pEdit ? 'Act.' : 'Agregar' ?></button></div>
            </div>
        </form>
    </div>

    <form method="GET" class="mb-3 d-flex gap-2">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar..." value="<?= htmlspecialchars($busqueda) ?>">
        <button class="btn btn-primary">Buscar</button>
        <?php if($busqueda): ?> <a href="index.php" class="btn btn-secondary">Limpiar</a> <?php endif; ?>
    </form>

    <table class="table table-hover border">
        <thead class="table-dark">
            <tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Cant.</th><th>Precio</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach($productos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><?= htmlspecialchars($p['descripcion']) ?></td>
                <td><?= $p['existencia'] ?></td>
                <td>$<?= number_format($p['precio'], 2) ?></td>
                <td>
                    <a href="index.php?editar=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="index.php?eliminar=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>