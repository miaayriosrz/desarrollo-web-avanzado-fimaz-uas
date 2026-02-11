// Objetivo // 
Desarrollar un sistema de usuarios que incluya validaciones automáticas y manejo de errores (excepciones) para evitar que la aplicación truene si se ingresan datos incorrectos.

// Clases //

Usuario (Base): Valida el correo. Si el formato es incorrecto, lanza una Exception.

Admin (Hijo): Hereda todo de Usuario y asigna el rol de Administrador.

Alumno (Hijo): Hereda de Usuario pero añade el atributo privado $matricula.

//errores // Se implementó un bloque try-catch en el index.php. Esto permite que, si el sistema detecta un correo inválido, en lugar de mostrar un error de código, muestre un mensaje amigable al usuario explicando el problema.

