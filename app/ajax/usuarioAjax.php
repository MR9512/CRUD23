<?php
    //Incluye el archivo de configuración de la aplicación
    require_once "../../config/app.php";
    //Inicia la sesión
    require_once "../views/inc/session_start.php";
    //Carga el archivo de autoloader para cargar automáticamente las clases
    require_once "../../autoload.php";
    //Usa el controlador de usuario del espacio de nombres app\controllers
    use app\controllers\userController;
    //Verifica si la variable POST 'modulo_usuario' está seteada
    if(isset($_POST['modulo_usuario'])){
        //Crea una instancia del controlador de usuario
        $insUsuario = new userController();
        //Verifica si 'modulo_usuario' es igual a "registrar"
        if($_POST['modulo_usuario']=="registrar"){
            //Llama al método registrarUsuarioControlador del controlador de usuario y muestra el resultado
            echo $insUsuario->registrarUsuarioControlador();
        }
    } else {
        //Si 'modulo_usuario' no está seteada, destruye la sesión y redirige al usuario a la página de inicio de sesión
        session_destroy();
        header("Location: ".APP_URL."login/");
    }
?>
