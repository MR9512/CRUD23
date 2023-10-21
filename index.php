<?php
    // Incluye el archivo de configuración de la aplicación, que contiene definiciones de constantes y configuraciones.
    require_once "config/app.php";
    // Incluye el archivo "autoload.php", que se utiliza para cargar automáticamente clases y archivos necesarios en la aplicación.
    require_once "autoload.php";
    //  se establecerá el nombre de la sesión como "APP_SESSION_NAME" y se iniciará o reanudará la sesión
    require_once "app/views/inc/session_start.php";


    // Verifica si el parámetro 'views' está presente en la URL usando isset()
    if(isset($_GET['views'])){
        // Si 'views' está presente, divide la URL en partes usando "/" como delimitador y almacena las partes en un array llamado $url
        $url = explode("/", $_GET['views']);
    } else {
        // Si 'views' no está presente en la URL, asigna un array con el elemento "login" a la variable $url por defecto
        $url = ["login"];
    }
        // Ahora, la variable $url contiene las partes de la URL o el valor predeterminado "login" si 'views' no está presente
?>
    <!DOCTYPE html> <!-- Declaración del tipo de documento HTML -->
    <html lang="es"> <!-- Etiqueta de apertura de HTML con atributo de idioma español ("es") -->
    <head>
        <?php require_once "app/views/inc/header.php"; ?>
        <!-- Incluye el contenido del archivo "header.php".
            La directiva "require_once" asegura que el archivo se incluye solo una vez para evitar duplicados. -->
    </head>
    <body>
        
        <?php require_once "app/views/inc/script.php"; ?>
        <!-- Incluye el contenido del archivo "script.php"  -->
    </body>
    </html> <!-- Etiqueta de cierre de HTML -->


