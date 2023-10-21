<?php
    // Establece el nombre de la sesión como "APP_SESSION_NAME".
    // Esto es útil para identificar la sesión en las cookies del navegador.
    session_name(APP_SESSION_NAME);
    // Inicia o reanuda la sesión existente.
    // Si ya existe una sesión con el nombre especificado (en este caso, "APP_SESSION_NAME"),
    // esa sesión se reanudará. Si no existe, se creará una nueva sesión.
    session_start();
?>
