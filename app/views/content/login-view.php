<div class="main-container">
    <!--Contenedor principal del formulario -->
    <form class="box login" action="" method="POST" autocomplete="off">
        <!--Formulario con clase 'box login', método de envío POST y autocompletado deshabilitado-->
        <h5 class="title is-5 has-text-centered is-uppercase">LOGIN</h5>
        <!--Título del formulario con estilo de encabezado 5, centrado y en mayúsculas-->
        <div class="field">
            <!--Campo de entrada del usuario-->
            <label class="label">Usuario</label>
            <!--Etiqueta del campo de entrada-->
            <div class="control">
                <!--Contenedor del campo de entrada-->
                <input class="input" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                <!--Campo de entrada de texto para el nombre de usuario con patrón y longitud mínima/requerida-->
            </div>
        </div>

        <div class="field">
            <!--Campo de entrada de la contraseña-->
            <label class="label">Clave</label>
            <!--Etiqueta del campo de entrada de la contraseña-->
            <div class="control">
                <!--Contenedor del campo de entrada de la contraseña -->
                <input class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                <!--Campo de entrada de contraseña con patrón y longitud mínima/requerida-->
            </div>
        </div>

        <p class="has-text-centered mb-4 mt-3">
            <!--Párrafo con texto centrado, margen inferior y superior-->
            <button type="submit" class="button is-info is-rounded">Iniciar sesion</button>
            <!--Botón de envío del formulario con estilo de botón de información y esquinas redondeadas-->
        </p>
    </form>
</div>
<?php
//Verifica si se recibieron los datos de usuario y clave mediante el método POST
if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
    //Si se recibieron los datos, llama al método iniciarSesionControlador del objeto $insLogin
    //para iniciar sesión del usuario y realizar el control correspondiente.
    $insLogin->iniciarSesionControlador();
}
?>

