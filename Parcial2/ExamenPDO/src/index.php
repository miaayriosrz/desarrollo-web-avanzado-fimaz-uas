<?php
require_once 'controllers/ProductoController.php';

$controller = new ProductoController();
$mensaje = "";
$productoEditar = null;

if (isset($_GET['eliminar'])) {
    if ($controller->eliminar($_GET['eliminar'])) {
        $mensaje = "Producto eliminado correctamente.";
    }
}

if (isset($_GET['editar'])) {
    $productoEditar = $controller->obtenerPorId($_GET['editar']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nuevoProducto = new Producto(
        $id,
        $_POST['nombre'],
        $_POST['descripcion'],
        (int)$_POST['existencia'],
        (float)$_POST['precio']
    );

    if ($id) {
        $res = $controller->actualizar($nuevoProducto);
        $mensaje = $res ? "Producto actualizado correctamente." : "Error al actualizar.";
    } else {
        $res = $controller->crear($nuevoProducto);
        $mensaje = $res ? "Producto agregado correctamente." : "Error al agregar.";
    }
}

$productos = $controller->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Productos PDO - Mia Yolanda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">Sistema de Gestión de Productos</h2>
    
    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <?php echo $productoEditar ? "Editar Producto" : "Nuevo Producto"; ?>
        </div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $productoEditar['id'] ?? ''; ?>">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo $productoEditar['nombre'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Descripción</label>
                        <input type="text" name="descripcion" class="form-control" value="<?php echo $productoEditar['descripcion'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cant.</label>
                        <input type="number" name="existencia" class="form-control" value="<?php echo $productoEditar['existencia'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $productoEditar['precio'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100"><?php echo $productoEditar ? "Actualizar" : "Guardar"; ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">Lista de Productos</div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cant.</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><?php echo $p['id']; ?></td>
                        <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($p['descripcion']); ?></td>
                        <td><?php echo $p['existencia']; ?></td>
                        <td>$<?php echo number_format($p['precio'], 2); ?></td>
                        <td>
                            <a href="?editar=<?php echo $p['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="?eliminar=<?php echo $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
//Rios R. Mia Yolanda
</html>
