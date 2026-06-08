<?php
namespace Controllers;
//Este es el controlador de Productos
//gestiona el ciclo de vida completo de los productos en la tienda, incluyendo
//la validación de datos, control de sesiones, operaciones CRUD, procesamiento
//seguro de imágenes en el servidor y una API en formato JSON
//por: Marysa Quiñonez, Carolina Vazquez, Luz Salas y Mia Rios

use Models\ProductoModel;

class ProductoController
{
    private ProductoModel $productoModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
    }

    private function verificarSesion(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin'])) {
            header('Location: index.php?route=login');
            exit;
        }
    }

    public function index(): void
    {
        $this->verificarSesion();
        $productos = $this->productoModel->obtenerTodos();
        require_once __DIR__ . '/../views/productos/index.php';
    }

    public function create(): void
    {
        $this->verificarSesion();
        require_once __DIR__ . '/../views/productos/create.php';
    }

    public function store(): void
    {
        $this->verificarSesion();

        $data = [
            'sku' => trim($_POST['sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio_compra' => trim($_POST['precio_compra'] ?? ''),
            'precio_venta' => trim($_POST['precio_venta'] ?? ''),
            'existencia' => trim($_POST['existencia'] ?? '')
        ];

        if (
            $data['sku'] === '' ||
            $data['nombre'] === '' ||
            $data['descripcion'] === '' ||
            $data['precio_compra'] === '' ||
            $data['precio_venta'] === '' ||
            $data['existencia'] === ''
        ) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: index.php?route=productos/create');
            exit;
        }

        if (!is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta'])
            || !is_numeric($data['existencia'])) {
            $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numéricos.';
            header('Location: index.php?route=productos/create');
            exit;
        }

        $precioCompra = (float)$data['precio_compra'];
        $precioVenta = (float)$data['precio_venta'];
        $existencia = (int)$data['existencia'];

        if ($precioCompra < 0 || $precioVenta < 0 || $existencia < 0) {
            $_SESSION['error'] = 'No se permiten valores negativos en precios o existencias.';
            header('Location: index.php?route=productos/create');
            exit;
        }

        // VALIDACIÓN: Precio de Venta >= Precio de Compra
        if ($precioVenta < $precioCompra) {
            $_SESSION['error'] = 'El precio de venta no puede ser menor que el precio de compra.';
            header('Location: index.php?route=productos/create');
            exit;
        }

        // VALIDACIÓN: SKU duplicado al Crear
        if ($this->productoModel->verificarSkuDuplicado($data['sku'])) {
            $_SESSION['error'] = 'El SKU ya se encuentra registrado.';
            header('Location: index.php?route=productos/create');
            exit;
        }

        // ========================================================
        // PROCESAR SUBIDA DE IMAGEN (CREAR - OBLIGATORIA)
        // ========================================================
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = 'La imagen del producto es obligatoria.';
            header('Location: index.php?route=productos/create');
            exit;
        }

        $fileTmpPath = $_FILES['imagen']['tmp_name'];
        $fileName = $_FILES['imagen']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($fileExtension, $extensionesPermitidas)) {
            $_SESSION['error'] = 'Formato de imagen no permitido (Solo JPG, PNG, WEBP).';
            header('Location: index.php?route=productos/create');
            exit;
        }

        // Generar nombre único usando md5 y marcas de tiempo
        $nuevoNombreImagen = md5(time() . $fileName) . '.' . $fileExtension;
        
        // RUTA CORREGIDA: Apunta a views/img/
        $rutaDestino = __DIR__ . '/../views/img/' . $nuevoNombreImagen;

        if (move_uploaded_file($fileTmpPath, $rutaDestino)) {
            $data['imagen'] = $nuevoNombreImagen; // Se guarda para el modelo
        } else {
            $_SESSION['error'] = 'Error al guardar la imagen en el servidor.';
            header('Location: index.php?route=productos/create');
            exit;
        }

        if ($this->productoModel->crear($data)) {
            $_SESSION['success'] = 'Producto registrado correctamente.';
        } else {
            $_SESSION['error'] = 'No fue posible registrar el producto.';
        }

        header('Location: index.php?route=productos');
        exit;
    }

    public function edit(): void
    {
        $this->verificarSesion();

        $id = (int)($_GET['id'] ?? 0);
        $producto = $this->productoModel->obtenerPorId($id);

        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado.';
            header('Location: index.php?route=productos');
            exit;
        }

        require_once __DIR__ . '/../views/productos/edit.php';
    }

    public function update(): void
    {
        $this->verificarSesion();

        $id = (int)($_POST['id'] ?? 0);

        // Obtenemos los datos actuales del producto antes de sobreescribir
        $productoActual = $this->productoModel->obtenerPorId($id);
        if (!$productoActual) {
            $_SESSION['error'] = 'Producto no encontrado.';
            header('Location: index.php?route=productos');
            exit;
        }

        $data = [
            'sku' => trim($_POST['sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio_compra' => trim($_POST['precio_compra'] ?? ''),
            'precio_venta' => trim($_POST['precio_venta'] ?? ''),
            'existencia' => trim($_POST['existencia'] ?? ''),
            'imagen' => $productoActual['imagen'] // Mantiene la imagen actual si no se sube una nueva
        ];

        if ($id <= 0) {
            $_SESSION['error'] = 'ID inválido.';
            header('Location: index.php?route=productos');
            exit;
        }

        if (
            $data['sku'] === '' ||
            $data['nombre'] === '' ||
            $data['descripcion'] === '' ||
            $data['precio_compra'] === '' ||
            $data['precio_venta'] === '' ||
            $data['existencia'] === ''
        ) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: index.php?route=productos/edit&id=' . $id);
            exit;
        }

        if (!is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta'])
            || !is_numeric($data['existencia'])) {
            $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numéricos.';
            header('Location: index.php?route=productos/edit&id=' . $id);
            exit;
        }

        $precioCompra = (float)$data['precio_compra'];
        $precioVenta = (float)$data['precio_venta'];
        $existencia = (int)$data['existencia'];

        if ($precioCompra < 0 || $precioVenta < 0 || $existencia < 0) {
            $_SESSION['error'] = 'No se permiten valores negativos en precios o existencias.';
            header('Location: index.php?route=productos/edit&id=' . $id);
            exit;
        }

        // VALIDACIÓN: Precio de Venta >= Precio de Compra
        if ($precioVenta < $precioCompra) {
            $_SESSION['error'] = 'El precio de venta no puede ser menor que el precio de compra.';
            header('Location: index.php?route=productos/edit&id=' . $id);
            exit;
        }

        // VALIDACIÓN: SKU duplicado en Edición (excluyendo el actual)
        if ($this->productoModel->verificarSkuDuplicado($data['sku'], $id)) {
            $_SESSION['error'] = 'El SKU ya pertenece a otro producto.';
            header('Location: index.php?route=productos/edit&id=' . $id);
            exit;
        }

        // ========================================================
        // PROCESAR SUBIDA DE IMAGEN (EDITAR/ACTUALIZAR)
        // ========================================================
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['imagen']['tmp_name'];
            $fileName = $_FILES['imagen']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($fileExtension, $extensionesPermitidas)) {
                $_SESSION['error'] = 'Formato de imagen no permitido (Solo JPG, PNG, WEBP).';
                header('Location: index.php?route=productos/edit&id=' . $id);
                exit;
            }

            $nuevoNombreImagen = md5(time() . $fileName) . '.' . $fileExtension;
            
            // RUTA CORREGIDA: Apunta a views/img/
            $rutaDestino = __DIR__ . '/../views/img/' . $nuevoNombreImagen;

            if (move_uploaded_file($fileTmpPath, $rutaDestino)) {
                // RUTA CORREGIDA: Eliminar del servidor la imagen vieja desde views/img/
                if (!empty($productoActual['imagen']) && file_exists(__DIR__ . '/../views/img/' . $productoActual['imagen'])) {
                    unlink(__DIR__ . '/../views/img/' . $productoActual['imagen']);
                }
                
                $data['imagen'] = $nuevoNombreImagen; // Reemplazamos con el nuevo nombre
            } else {
                $_SESSION['error'] = 'Error al guardar la nueva imagen en el servidor.';
                header('Location: index.php?route=productos/edit&id=' . $id);
                exit;
            }
        }

        if ($this->productoModel->actualizar($id, $data)) {
            $_SESSION['success'] = 'Producto actualizado correctamente.';
        } else {
            $_SESSION['error'] = 'No fue posible actualizar el producto.';
        }

        header('Location: index.php?route=productos');
        exit;
    }

    public function delete(): void
    {
        $this->verificarSesion();

        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = 'ID inválido.';
            header('Location: index.php?route=productos');
            exit;
        }

        // RUTA CORREGIDA: Obtener el producto para borrar físicamente su archivo desde views/img/
        $producto = $this->productoModel->obtenerPorId($id);
        if ($producto && !empty($producto['imagen']) && file_exists(__DIR__ . '/../views/img/' . $producto['imagen'])) {
            unlink(__DIR__ . '/../views/img/' . $producto['imagen']);
        }

        if ($this->productoModel->eliminar($id)) {
            $_SESSION['success'] = 'Producto eliminado correctamente.';
        } else {
            $_SESSION['error'] = 'No fue posible eliminar el producto.';
        }

        header('Location: index.php?route=productos');
        exit;
    }

    public function apiProductos(): void
{
    header('Content-Type: application/json; charset=utf-8');

    $productos = $this->productoModel->obtenerTodos();

    echo json_encode([
        'success' => true,
        'total' => count($productos),
        'data' => $productos
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
}