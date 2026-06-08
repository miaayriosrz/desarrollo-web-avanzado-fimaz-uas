<?php 
//Muestra una interfaz en cuadrícula con tarjetas de productos disponibles
//para los visitantes de la tienda, incluyendo imágenes, descripción, precio, 
//y un buscador integrado para filtrar por nombre o palabras clave.
//por: Marysa Quiñonez, Carolina Vazquez, Luz Salas y Mia Rios
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2>Catálogo público de productos</h2>
        <p>Consulta los productos disponibles y realiza búsquedas por nombre o descripción.</p>
    </div>
</div>

<form method="GET" action="index.php" class="row g-2 mb-4">
    <input type="hidden" name="route" value="catalogo">

    <div class="col-md-10">
        <input type="text" name="buscar" class="form-control"
               placeholder="Buscar por nombre o descripción"
               value="<?= htmlspecialchars($termino ?? ''); ?>">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Buscar</button>
    </div>
</form>
<div class="row">
    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-4 mb-4">
                <div class="col card h-100 shadow-sm">
                    <img src="views/img/<?= htmlspecialchars($producto['imagen']); ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($producto['nombre']); ?>"
                         style="height: 200px; object-fit: cover;">
                    
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($producto['nombre']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">SKU: <?= htmlspecialchars($producto['sku']); ?></h6>
                        <p class="card-text"><?= htmlspecialchars($producto['descripcion']); ?></p>
                        <p><strong>Precio:</strong> $<?= number_format((float)$producto['precio_venta'], 2); ?></p>
                        <p><strong>Existencia:</strong> <?= (int)$producto['existencia']; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning">No se encontraron productos.</div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>