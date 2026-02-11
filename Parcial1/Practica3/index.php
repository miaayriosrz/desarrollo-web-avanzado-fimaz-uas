<?php
require_once 'clases/Admin.php';
require_once 'clases/Alumno.php';

try {
    echo "<h2>Prueba de Usuarios</h2>";

    $admin = new Admin("Mia Yolanda Rios", "miaaayorios@gamil.com");
    echo $admin->getDatos() . "<br>";

    $alumno = new Alumno("Julian Ibarra", "Jules.ibarra@gmail.com", "27710174");
    echo $alumno->getDatos() . "<p style='color:green;'>✓ Usuarios creados con éxito.</p>";

    echo "<h2>Prueba de Error</h2>";
    $error = new Admin("Usuario Invalido", "correo-sin-formato");

} catch (Exception $e) {
    echo "<p style='color:red; border:1px solid red; padding:10px;'>";
    echo "<strong>Excepción capturada:</strong> " . $e->getMessage();
    echo "</p>";
}