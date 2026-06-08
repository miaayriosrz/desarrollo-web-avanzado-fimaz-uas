
<?php

//este automatiza la inclusión de archivos de clases.
//detecta cuando el sistema intenta usar una clase (ej. un Controlador o 
//un Modelo), traduce su Namespace a una ruta de archivos física en el 
//servidor, ajusta el nombre de la carpeta raíz a minúsculas y carga el 
//archivo automáticamente sin necesidad de usar "require_once" manualmente.///
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/../';
    $class = str_replace('\\', '/', $class);
    $parts = explode('/', $class);
    if (!empty($parts)) {
        $parts[0] = strtolower($parts[0]);
    }
    
    $file = $baseDir . implode('/', $parts) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

?> 