<?php
// Declaración del espacio de nombres y la clase
namespace app\models;
class viewsModel {
    // Método para obtener vistas
    protected function obtenerVistasModelo($vista) {
        // Lista blanca de vistas permitidas
        $listaBlanca = ["dashboard", "userNew","userList","userSearch","userUpdate","userPhoto","logOut"];

        // Verificar si la vista está en la lista blanca
        if (in_array($vista, $listaBlanca)) {
            // Si la vista existe como archivo en el directorio de vistas, establecer la ruta del archivo
            if (is_file("app/views/content/" . $vista . "-view.php")) {
                $contenido = "app/views/content/" . $vista . "-view.php";
            } else {
                // Si el archivo de vista no existe, mostrar la página de error 404
                $contenido = "404";
            }
        } else if ($vista == "login" || $vista == "index") {
            // Si la vista es "login" o "index", mostrar la vista de inicio de sesión
            $contenido = "login";
        } else {
            // Si la vista no está permitida, mostrar la página de error 404
            $contenido = "404";
        }

        // Devolver la ruta del archivo de la vista
        return $contenido;
    }
}
?>
