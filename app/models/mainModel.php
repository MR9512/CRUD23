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
    
      
}

?>
