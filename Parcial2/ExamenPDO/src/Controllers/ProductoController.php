<?php
namespace App\Controllers;

use App\Config\Database;
use App\Models\Producto;
use PDO;
use PDOException;

class ProductoController {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function crear(Producto $producto) {
        try {
            $sql = "INSERT INTO productos (nombre, descripcion, existencia, precio) VALUES (:n, :d, :e, :p)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':n', $producto->getNombre());
            $stmt->bindValue(':d', $producto->getDescripcion());
            $stmt->bindValue(':e', $producto->getExistencia(), PDO::PARAM_INT);
            $stmt->bindValue(':p', $producto->getPrecio());
            return $stmt->execute();
        } catch (PDOException $e) { return false; }
    }

    public function listar() {
        try {
            $sql = "SELECT * FROM productos ORDER BY id DESC";
            $stmt = $this->connection->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) { return []; }
    }

    public function obtenerPorId($id) {
        try {
            $sql = "SELECT * FROM productos WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) { return null; }
    }

    public function actualizar(Producto $producto) {
        try {
            $sql = "UPDATE productos SET nombre=:n, descripcion=:d, existencia=:e, precio=:p WHERE id=:id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':n', $producto->getNombre());
            $stmt->bindValue(':d', $producto->getDescripcion());
            $stmt->bindValue(':e', $producto->getExistencia(), PDO::PARAM_INT);
            $stmt->bindValue(':p', $producto->getPrecio());
            $stmt->bindValue(':id', $producto->getId(), PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) { return false; }
    }

    public function eliminar($id) {
        try {
            $sql = "DELETE FROM productos WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) { return false; }
    }

    public function buscar($t) {
        try {
            $sql = "SELECT * FROM productos WHERE nombre LIKE :t OR descripcion LIKE :t ORDER BY id DESC";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':t', "%$t%");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) { return []; }
    }
}
// Rios R. Mia Yolanda