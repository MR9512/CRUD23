<?php
// Declaración del espacio de nombres y uso de la clase viewsModel
namespace app\controllers;
use app\models\viewsModel;

class viewsController extends viewsModel {
    // Método para obtener vistas en el controlador
    public function obtenerVistasControlador($vista) {
        // Verificar si se proporciona un nombre de vista válido
        if ($vista != "") {
            // Llama al método heredado de la clase base viewsModel para obtener la ruta del archivo de la vista
            $respuesta = $this->obtenerVistasModelo($vista);
        } else {
            // Si no se proporciona un nombre de vista válido, mostrar la vista de inicio de sesión
            $respuesta = "login";
        }
        // Devolver la respuesta (ruta del archivo de la vista)
        return $respuesta;
    }
}
?>
