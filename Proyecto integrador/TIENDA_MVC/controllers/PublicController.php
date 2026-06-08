<?php
namespace Controllers;
//Este es el el controlador publico
//gestiona la vista del catálogo accesible para todos los usuarios visitantes,
//permitiendo la visualización general de los productos disponibles y procesando
//las peticiones de búsqueda filtradas por nombre o descripción.
//por: Marysa Quiñonez, Carolina Vazquez, Luz Salas y Mia Rios
use Models\ProductoModel;

class PublicController
{
    public function catalogo(): void
    {
        $termino = trim($_GET['buscar'] ?? '');
        $productoModel = new ProductoModel();
        $productos = $productoModel->buscarPublico($termino);
        require_once __DIR__ . '/../views/public/catalogo.php';
    }
}
?>