<?php
class Database {
    private $host = "localhost";
    private $db_name = "venta"; // Asegúrate que este nombre coincida con tu BD
    private $username = "root";
    private $password = "";
    private $charset = "utf8mb4";
    private $connection;

    public function getConnection() {
        $this->connection = null;
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
        return $this->connection;
    }
}
?>