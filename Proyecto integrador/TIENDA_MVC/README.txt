# Tienda MVC - Desarrollo Web Avanzado

Sistema de gestión y catálogo de productos desarrollado bajo la arquitectura *MVC (Modelo-Vista-Controlador)* en PHP nativo, aplicando buenas prácticas de programación orientada a objetos (POO), seguridad y persistencia de datos.

# Características del Proyecto

- *Arquitectura MVC Estricta:* Separación clara entre la lógica de negocio, el acceso a datos y la interfaz de usuario.
- *Persistencia con PDO:* Conexión segura a la base de datos MySQL utilizando PDO y manejo de excepciones con bloques try-catch.
- *Seguridad Avanzada:*
  - *Protección CSRF:* Implementación de tokens de seguridad aleatorios en formularios críticos para evitar ataques de falsificación de peticiones en sitios cruzados.
  - *Control de Sesiones:* Restricción de acceso al panel de administración mediante validación de sesiones activas.
- *Rutas Amigables (.htaccess):* Configuración de URLs limpias mediante el motor de reescritura de Apache (mod_rewrite), eliminando el uso visible de index.php?route=.
- *Catálogo Público Paginado:* Vista pública con paginación estricta de 4 en 4 productos.
- *Log (Bitácora) de Auditoría:* Sistema automático que registra en un archivo físico (bitacora.log) las acciones críticas del administrador (Crear, Editar, Eliminar) con marca de tiempo y usuario.

---

# Tecnologías Utilizadas

- *Backend:* PHP 8.x (POO, Namespaces, Autoload)
- *Frontend:* HTML5, CSS3, Bootstrap 5.3 (vía CDN)
- *Base de Datos:* MySQL
- *Servidor:* Apache (.htaccess)

---

# Estructura del Proyecto

```text
TIENDA_MVC/
│
├── config/             # Configuración de base de datos y Autoload
├── Controllers/        # Controladores (Auth, Producto, Public)
├── Models/             # Modelos de datos (Interacción con PDO)
├── views/              # Vistas de la aplicación (HTML/Bootstrap)
│   ├── layouts/        # Cabecera (header) y Pie de página (footer)
│   ├── productos/      # Vistas del panel de administración
│   └── public/         # Vista del catálogo general
│
├── .htaccess           # Configuración de rutas amigables
├── index.php           # Enrutador principal (Front Controller)
└── bitacora.log        # Archivo log de auditoría del administrador

#Uso de la Bitácora (Log)
El sistema genera de forma automática un archivo bitacora.log en la raíz en cuanto el administrador realiza una operación de escritura o borrado exitosa. El formato registrado es el siguiente:
[AÑO-MES-DÍA HORA] USUARIO: correo@admin.com | ACCIÓN: [CREAR/EDITAR/ELIMINAR] | DETALLE: Descripción del cambio