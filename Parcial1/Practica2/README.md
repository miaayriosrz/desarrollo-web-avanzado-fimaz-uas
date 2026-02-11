// Objetvo // Implementar la herencia mediante la extensión de clases (extends), permitiendo que una clase hija reutilice los atributos y métodos de una clase base.

// Clases y herencias//
 1. Clase Usuario: Es la clase padre (base) que contiene los datos generales como nombre y correo.

2. Clase Admin: Es la clase hija que extiende a Usuario. Gracias a la herencia, esta clase ya cuenta con nombre y correo sin tener que programarlos de nuevo, y solo se le agrega el método getRol().

// Diferencias // 
Usuario: Es la base general para cualquier perfil.

Admin: Es una versión especializada que tiene el permiso de mostrar el rol "Administrador".

// Evidencia // 
El sistema crea un objeto Admin, pero muestra el nombre y correo que fueron definidos originalmente en la clase Usuario, demostrando que la reutilización de código funciona correctamente.