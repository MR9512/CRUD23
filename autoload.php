<?php
    // Utiliza spl_autoload_register para registrar una función de autocarga personalizada.
    spl_autoload_register(function($clase) {
        // Construye la ruta del archivo de la clase utilizando la ruta del directorio actual (__DIR__) y el nombre de la clase.
        $archivo = __DIR__ . "/" . $clase . ".php";
        // Reemplaza las barras invertidas (\) por barras normales (/) en la ruta del archivo.
        $archivo = str_replace("\\", "/", $archivo);
        // Verifica si el archivo de la clase existe en la ruta especificada.
        if (is_file($archivo)) {
            // Si el archivo existe, lo incluye en el script actual.
            require_once $archivo;
        }
    });
?>
