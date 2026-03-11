<?php
require_once 'Admin.php';
require_once 'Alumno.php';

$mostrarusuario = [];
$error = "";

try {
   
    $admin = new Admin("Mia Rios", "miaaayorios.admin@empresa.com");
    $mostrarusuario[] = $admin;

    $alumno = new Alumno("Camila Graciano", "Camigrcn02@uas.edu.mx", "29034558");
    $mostrarusuario[] = $alumno;

    $alumnoinvalido = new Alumno("Pedro", "pedrito23.com", "2223445");
    $mostrarusuario[] = $alumnoinvalido;

} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        .error { color: #721c24; background-color: #f8d7da; padding: 15px; border: 1px solid #f5c6cb; margin-bottom: 20px; }
    </style>
</head>
<body>

    <h2>Lista de Usuarios</h2>

    <?php if ($error): ?>
        <div class="error">
            <strong>Atención:</strong> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Matrícula</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mostrarusuario as $N): ?>
                <tr>
                    <td><?php echo $N->getNombre(); ?></td>
                    <td><?php echo $N->getCorreo(); ?></td>
                    <td><?php echo $N->getRol(); ?></td>
                    <td><?php echo (method_exists($N, 'getMatricula')) ? $N->getMatricula() : 'N/A'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>