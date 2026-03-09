<?php
require_once 'clases/Admin.php';
require_once 'clases/Alumno.php';
require_once 'clases/Invitado.php';

$usuarios = [];
$errorMsg = "";

try {
  
    $usuarios[] = new Admin("Mia Yolanda Rios", "miaaayorios@gmail.com");
    $usuarios[] = new Alumno("Camila Graciano", "gracianocami@gmail.com", "020475");
    $usuarios[] = new Invitado("Bogarin Company", "bogarcompany@gmail.com.", "Google");

    $usuarios[] = new Alumno("Error Humano", "correo_sin_arroba.com", "000000");

} catch (Exception $e) {
    $errorMsg = $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Práctica 4</title>
    <style>
        table { width: 80%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .error { color: white; background-color: #d9534f; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Gestión de Usuarios </h1>

    <?php if ($errorMsg): ?>
        <div class="error">
            <strong>⚠ Error controlado:</strong> <?php echo $errorMsg; ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Matrícula</th>
                <th>Empresa</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?php echo $u->getNombre(); ?></td>
                    <td><?php echo $u->getCorreo(); ?></td>
                    <td><?php echo $u->getRol(); ?></td>
                    <td><?php echo (method_exists($u, 'getMatricula')) ? $u->getMatricula() : "—"; ?></td>
                    <td><?php echo (method_exists($u, 'getEmpresa')) ? $u->getEmpresa() : "—"; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>