<?php
namespace Config;
//este es la configuración de Base de Datos.
//establece la conexión segura al servidor MySQL utilizando la interfaz PDO,
//configurando el manejo de excepciones y el modo de obtención de datos.
//por: Marysa Quiñonez, Carolina Vazquez, Luz Salas y Mia Rios.

use PDO;
use PDOException;

class Database
{
    private string $host = 'localhost';
    private string $dbName = 'tienda_mvc';
    private string $username = 'root';
    private string $password = '';
    private string $charset = 'utf8mb4';

    public function connect(): PDO
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset={$this->charset}";
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }
}
?>