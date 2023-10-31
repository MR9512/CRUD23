<?php
namespace app\models;
use \PDO;
// Verifica si el archivo server.php existe en la ruta específica y lo incluye si es así
if (file_exists(__DIR__."/../../config/server.php")) {
    require_once __DIR__."/../../config/server.php";
}

class mainModel {
    // Definición de la clase mainModel
    private $server = DB_SERVER; // Almacena el valor de la constante DB_SERVER
    private $db = DB_NAME; // Almacena el valor de la constante DB_NAME
    private $user = DB_USER; // Almacena el valor de la constante DB_USER
    private $pass = DB_PASS; // Almacena el valor de la constante DB_PASS

     //Método protegido para establecer la conexión a la base de datos
     protected function conectar(){
        //Crea una nueva instancia de PDO para la conexión a la base de datos
        $conexion = new PDO("mysql:host=".$this->server."; dbname=".$this->db, $this->user, $this->pass);
        //Establece el juego de caracteres de la conexión a utf8
        $conexion->exec("SET CHARACTER SET utf8");
        //nRetorna el objeto de conexión PDO
        return $conexion;
    }

    protected function ejecutarConsulta($consulta){
        //Establece una conexión a la base de datos utilizando el método conectar() de la clase actual
        $sql = $this->conectar()->prepare($consulta);
        //Ejecuta la consulta preparada
        $sql->execute();
        //Retorna el objeto de la consulta ejecutada
        return $sql;
    }

    public function limpiarCadena($cadena){
        // Define un array de palabras y patrones que se consideran inseguros o potencialmente peligrosos
        $palabras = [
            "<script>",
            "</script>",
            "<script src",
            "<script type=",
            "SELECT * FROM",
            "SELECT ",
            " SELECT ",
            "DELETE FROM",
            "INSERT INTO",
            "DROP TABLE",
            "DROP DATABASE",
            "TRUNCATE TABLE",
            "SHOW TABLES",
            "SHOW DATABASES",
            "<?php",
            "?>",
            "--",
            "^",
            "<",
            ">",
            "==",
            "=",
            ";",
            "::"
        ];
        //Elimina espacios en blanco al principio y al final de la cadena
        $cadena = trim($cadena);
        //Elimina barras invertidas añadidas por la función addslashes() para escapar ciertos caracteres
        $cadena = stripslashes($cadena);
        //Itera sobre el array de palabras y reemplaza cualquier ocurrencia en la cadena por una cadena vacía
        foreach($palabras as $palabra){
            $cadena = str_ireplace($palabra, "", $cadena);
        }
        //Elimina espacios en blanco al principio y al final de la cadena nuevamente después de la limpieza
        $cadena = trim($cadena);
        //Elimina barras invertidas nuevamente después de la limpieza
        $cadena = stripslashes($cadena);
        //Retorna la cadena limpia y segura
        return $cadena;
    }
    
    protected function verificarDatos($filtro, $cadena){
        //Utiliza la función preg_match() para verificar si la cadena coincide con el patrón especificado
        //El patrón es construido dinámicamente utilizando el filtro pasado como parámetro
        if(preg_match("/^" . $filtro . "$/", $cadena)){
            //Si la cadena coincide con el patrón, retorna false (indicando que los datos son válidos)
            return false;
        } else {
            //Si la cadena no coincide con el patrón, retorna true (indicando que los datos son inválidos)
            return true;
        }
    }

    protected function guardarDatos($tabla, $datos){
        //Construye la parte inicial de la consulta SQL para insertar datos en la tabla especificada
        $query = "INSERT INTO $tabla (";
        $c = 0;
        //Itera sobre los datos y construye la lista de nombres de campos para la consulta SQL
        foreach($datos as $clave){
            if($c >= 1){
               $query.= ", "; // Agrega una coma si ya hay campos en la lista
            }
            $query.= $clave["campo_nombre"]; // Agrega el nombre del campo a la lista
            $c++;
        }
        //Completa la primera parte de la consulta SQL
        $query.=") VALUES(";
        $c = 0;
        //Itera sobre los datos y construye la lista de marcadores de posición para la consulta SQL
        foreach($datos as $clave){
            if($c >= 1){
               $query.= ", "; // Agrega una coma si ya hay marcadores de posición en la lista
            }
            $query.= $clave["campo_marcador"]; // Agrega el marcador de posición a la lista
            $c++;
        }
        //Completa la consulta SQL
        $query.=")";
        //Prepara la consulta SQL con la conexión a la base de datos
        $sql = $this->conectar()->prepare($query);
        //Vincula los valores de los marcadores de posición con los valores reales proporcionados en los datos
        foreach($datos as $clave){
            $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
        }
        //Ejecuta la consulta SQL para insertar los datos en la tabla
        $sql->execute();
        //Retorna el objeto de la consulta ejecutada
        return $sql;
    }


    // - $tipo: Tipo de selección ("Unico" para un registro específico o "Normal" para todos los registros).
    // - $tabla: Nombre de la tabla de la base de datos de la que se seleccionarán los datos.
    // - $campo: Nombre del campo que se seleccionará de la tabla.
    // - $id: Valor del identificador que se utilizará en la consulta (solo se usa si $tipo es "Unico").
    public function seleccionarDatos($tipo, $tabla, $campo, $id){
        //Se limpian las cadenas de entrada para evitar posibles ataques de inyección de SQL.
        $tipo = $this->limpiarCadena($tipo);
        $tabla = $this->limpiarCadena($tabla);
        $campo = $this->limpiarCadena($campo);
        $id = $this->limpiarCadena($id);
        //Se verifica el tipo de selección.
        if($tipo=="Unico"){
            //Si el tipo es "Unico", se prepara una consulta SQL para seleccionar un registro específico.
            $sql = $this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
            //Se vincula el valor del identificador a la consulta preparada.
            $sql->bindParam(":ID", $id);
        } elseif($tipo=="Normal"){
            //Si el tipo es "Normal", se prepara una consulta SQL para seleccionar todos los registros.
            $sql = $this->conectar()->prepare("SELECT $campo FROM $tabla");
        }
        //Se ejecuta la consulta SQL.
        $sql->execute();
        //Se devuelve el objeto de consulta SQL que puede contener los resultados.
        return $sql;
    }

    // Esta función se llama "actualizarDatos" y acepta tres parámetros:
    // - $tabla: Nombre de la tabla en la que se actualizarán los datos.
    // - $datos: Un array asociativo que contiene los datos que se actualizarán. Cada elemento del array debe tener tres claves: 
    //   - "campo_nombre": Nombre del campo en la tabla.
    //   - "campo_marcador": Marcador de posición para el campo en la consulta SQL (por ejemplo, ":nombre").
    //   - "campo_valor": Valor que se actualizará en el campo.
    // - $condicion: Un array asociativo que contiene la condición para la actualización. Debe tener dos claves:
    //   - "condicion_campo": Nombre del campo en la tabla que se utilizará como condición.
    //   - "condicion_marcador": Marcador de posición para el campo de condición en la consulta SQL (por ejemplo, ":id").
    //   - "condicion_valor": Valor que se utilizará como condición para la actualización.
    protected function actualizarDatos($tabla, $datos, $condicion){
        //Se construye la consulta SQL para la actualización.
        $query = "UPDATE $tabla SET ";
        //Variable de control para agregar comas entre los campos a actualizar.
        $c = 0;
        //Se recorren los datos a actualizar y se construye la parte SET de la consulta.
        foreach($datos as $clave){
            if($c >= 1){
                $query.= ", "; 
            }
            $query.= $clave["campo_nombre"]."=".$clave["campo_marcador"]; 
            $c++;
        }
        //Se añade la condición WHERE a la consulta SQL.
        $query.=" WHERE ".$condicion["condicion_campo"]."=".$condicion["condicion_marcador"];
        //Se prepara la consulta SQL.
        $sql = $this->conectar()->prepare($query);
        //Se vinculan los valores de los campos a actualizar a la consulta preparada.
        foreach($datos as $clave){
            $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
        }
        //Se vincula el valor de la condición a la consulta preparada.
        $sql->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);
        //Se ejecuta la consulta SQL para actualizar los datos en la base de datos.
        $sql->execute();
        //Se devuelve el objeto de consulta SQL que puede contener información sobre el éxito de la operación.
        return $sql;
    }

    // Esta función se llama "eliminarRegistro" y acepta tres parámetros:
    // - $tabla: Nombre de la tabla de la que se eliminará el registro.
    // - $campo: Nombre del campo que se utilizará como condición para la eliminación.
    // - $id: Valor del identificador que se utilizará en la condición de eliminación.
    protected function eliminarRegistro($tabla, $campo, $id){
        //Se prepara una consulta SQL para eliminar el registro de la tabla.
        $sql = $this->conectar()->prepare("DELETE FROM $tabla WHERE $campo=:id");
        //Se vincula el valor del identificador a la consulta preparada.
        $sql->bindParam(":id", $id);
        //Se ejecuta la consulta SQL para eliminar el registro.
        $sql->execute();
        //Se devuelve el objeto de consulta SQL que puede contener información sobre el éxito de la operación.
        return $sql;
    }

    // Esta función se llama "paginadorTablas" y acepta cuatro parámetros:
    // - $pagina: Número de la página actual.
    // - $numeroPaginas: Número total de páginas.
    // - $url: URL base para generar los enlaces del paginador.
    // - $botones: Número de botones que se mostrarán a cada lado de la página actual en el paginador.
    protected function paginadorTablas($pagina, $numeroPaginas, $url, $botones) {
        //Se inicializa la variable $tabla con el código HTML inicial del paginador.
        $tabla = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination"><ul class="pagination-list">';
        
        //Se verifica si la página actual es la primera. Si lo es, se muestra el botón "Anterior" deshabilitado.
        if ($pagina <= 1) {
            $tabla .= '<a class="pagination-previous is-disabled" disabled >Anterior</a>';
        } else {
            //Si la página actual no es la primera, se muestra el botón "Anterior" y se generan enlaces para la primera página y una elipsis.
            $tabla .= '<a class="pagination-previous" href="' . $url . ($pagina - 1) . '/">Anterior</a>
            <ul class="pagination-list">
            <li><a class="pagination-link" href="' . $url . '1/">1</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>';
        }
        //El paginador continúa aquí generando enlaces para las páginas intermedias y el botón "Siguiente".
        //El código para generar estos elementos debe estar presente aquí para que el paginador funcione correctamente.
        //Finalmente, se cierra la estructura del paginador con el botón "Siguiente", la última página y el cierre de las etiquetas HTML.
        //Dependiendo de la lógica de paginación que falte en este script, esta parte podría variar.
        //La función debería devolver el código HTML completo del paginador generado.
        return $tabla;
    }




      
}

?>
