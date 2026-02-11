<?php
require_once 'Admin.php';


$admin = new Admin("Mia Y. Rios", "miaaayoriosrz@gmail.com");

echo "<h2>Información del Usuario</h2>";
echo "Nombre: " . $admin->getNombre() . "<br>";
echo "Correo: " . $admin->getCorreo() . "<br>";
echo "Rol: " . $admin->getRol() . "<br>";