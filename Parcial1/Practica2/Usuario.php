<?php


class Usuario {
    protected  $nombre;
    protected  $correo;

    public function __construct( $nombre,  $correo) {
        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    public function getNombre()  {
        return $this->nombre;
    }

    public function getCorreo() {
        return $this->correo;
    }
}