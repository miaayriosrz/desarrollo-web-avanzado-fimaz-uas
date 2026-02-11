<?php

abstract class Usuario {
    protected $nombre;
    protected $correo;

    public function __construct(string $nombre, string $correo) {
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Error: El formato del correo '$correo' no es válido.");
        }
        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    // Método abstracto para obligar a las clases hijas a definir su rol
    abstract public function getRol();

    public function getDatos(){
        return "Nombre: {$this->nombre} | Correo: {$this->correo} | Rol: " . $this->getRol();
    }
}