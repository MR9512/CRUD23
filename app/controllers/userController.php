<?php
    //Declara un namespace para el controlador
    namespace app\controllers;
    //Importa la clase mainModel desde el espacio de nombres app\models
    use app\models\mainModel;
    //Define la clase userController que extiende de mainModel
    class userController extends mainModel{
        //Método para registrar un nuevo usuario
        public function registrarUsuarioControlador(){
            //Obtiene y limpia los datos del formulario
            $nombre = $this->limpiarCadena($_POST['usuario_nombre']);
            $apellido = $this->limpiarCadena($_POST['usuario_apellido']);
            $usuario = $this->limpiarCadena($_POST['usuario_usuario']);
            $email = $this->limpiarCadena($_POST['usuario_email']);
            $clave1 = $this->limpiarCadena($_POST['usuario_clave_1']);
            $clave2 = $this->limpiarCadena($_POST['usuario_clave_2']);
            //Verifica si algún campo obligatorio está vacío
            if($nombre==""  || $apellido=="" || $usuario=="" || $clave1=="" || $clave2==""){
               $alerta=[
                  "tipo"=>"simple",
                  "titulo"=>"Ocurrió un error inesperado",
                  "texto"=>"No has llenado todos los campos que son obligatorios",
                  "icono"=>"error"
               ];
               return json_encode($alerta); // Devuelve un mensaje de error en formato JSON
               exit();
            }
            //Verifica el formato del nombre, apellido, usuario y claves utilizando expresiones regulares
            if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
                //Devuelve un mensaje de error si el nombre no cumple con el formato solicitado
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrió un error inesperado",
                    "texto"=>"El Nombre no coincide con el formato solicitado",
                    "icono"=>"error"
                 ];
                 return json_encode($alerta);
                 exit();
            }
            //Verifica el formato del apellido
            if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
                //Devuelve un mensaje de error si el apellido no cumple con el formato solicitado
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrió un error inesperado",
                    "texto"=>"El Apellido no coincide con el formato solicitado",
                    "icono"=>"error"
                 ];
                 return json_encode($alerta);
                 exit();
            }
            //Verifica el formato del nombre de usuario
            if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$usuario)){
                //Devuelve un mensaje de error si el nombre de usuario no cumple con el formato solicitado
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrió un error inesperado",
                    "texto"=>"El Usuario no coincide con el formato solicitado",
                    "icono"=>"error"
                 ];
                 return json_encode($alerta);
                 exit();
            }

            //Verifica el formato de las claves
            if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || $this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave2)){
                //Devuelve un mensaje de error si las claves no cumplen con el formato solicitado
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrió un error inesperado",
                    "texto"=>"Las Claves no coinciden con el formato solicitado",
                    "icono"=>"error"
                 ];
                 return json_encode($alerta);
                 exit();
            }
            //Verificando email
            if($email!=""){
                //Verifica si el email tiene un formato válido
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    //Realiza una consulta en la base de datos para verificar si el email ya está registrado
                    $check_email=$this->ejecutarConsulta("SELECT usuario_email FROM usuarios WHERE usuario_email='$email'");
                    //Verifica si la consulta devuelve algún resultado (si el email ya está en la base de datos)
                    if($check_email->rowCount()>0){
                        //Si el email ya está registrado, devuelve un mensaje de error
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"Ocurrió un error inesperado",
                            "texto"=>"El Email que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
                            "icono"=>"error"
                        ];
                        //Convierte el mensaje de error a formato JSON y lo devuelve
                        return json_encode($alerta);
                        //Finaliza la ejecución del script
                        exit();
                    }
                }else{
                    //Si el email no tiene un formato válido, devuelve un mensaje de error
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"Ha ingresado un correo electrónico no válido",
                        "icono"=>"error"
                    ];
                    //Convierte el mensaje de error a formato JSON y lo devuelve
                    return json_encode($alerta);
                    //Finaliza la ejecución del script
                    exit();
                }
            }
        //Verificando claves
        //Verifica si las contraseñas ingresadas coinciden
        if($clave1!=$clave2){
            //Si las contraseñas no coinciden, devuelve un mensaje de error
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"Las contraseñas que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
                "icono"=>"error"
            ];
            //Convierte el mensaje de error a formato JSON y lo devuelve
            return json_encode($alerta);
            //Finaliza la ejecución del script
            exit();
        }else{
            //Si las contraseñas coinciden, hashea la contraseña para almacenarla de forma segura en la base de datos
            $clave=password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
        }
        //Verifica si el nombre de usuario ya está registrado en la base de datos
        $check_usuario=$this->ejecutarConsulta("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario='$usuario'");
        if($check_usuario->rowCount()>0){
            //Si el nombre de usuario ya está registrado, devuelve un mensaje de error
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"El Usuario que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
                "icono"=>"error"
            ];
            //Convierte el mensaje de error a formato JSON y lo devuelve
            return json_encode($alerta);
            //Finaliza la ejecución del script
            exit();
        }
            //Directorio donde se almacenarán las imágenes de perfil
            $img_dir="../views/fotos/";

            if($_FILES['usuario_foto']['name']!="" && $_FILES['usuario_foto']['size']>0){
                // Verifica si se ha seleccionado un archivo de imagen y su tamaño es mayor que cero
                
                if(!file_exists($img_dir)){
                    // Verifica si el directorio de imágenes no existe
                    // Si no existe, intenta crear el directorio con permisos 0777
                    if(!mkdir($img_dir, 0777)){
                        // Si no se puede crear el directorio, devuelve un mensaje de error
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"Ocurrió un error inesperado",
                            "texto"=>"Error al crear el directorio",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }  
            
                if(mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/png"){
                    //Verifica si el tipo de archivo de la imagen no es JPEG ni PNG
                    //Si no es uno de estos tipos, devuelve un mensaje de error
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"La imagen que ha seleccionado es de un formato no permitido",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if(($_FILES['usuario_foto']['size']/1024)>5120){
                    //Verifica si el tamaño del archivo de imagen supera los 5 MB (5120 KB)
                    //Si es demasiado grande, devuelve un mensaje de error
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"La imagen que ha seleccionado supera el peso permitido",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                //Obtiene el nombre del archivo del formulario y reemplaza los espacios por guiones bajos
                $nombreFoto = $_FILES['usuario_foto']['name'];
                $foto = str_ireplace(" ", "_", $nombreFoto);
                //Agrega un número aleatorio entre 0 y 100 al nombre del archivo para evitar duplicados
                $foto = $foto . "_" . rand(0, 100);
                //Verifica el tipo de archivo de la imagen cargada y ajusta la extensión del archivo
                switch (mime_content_type($_FILES['usuario_foto']['tmp_name'])) {
                    case "image/jpeg":
                        $foto = $foto . ".jpeg";
                        break;
                    case "image/png":
                        $foto = $foto . ".png";
                        break;
                }
                //Cambia los permisos del directorio a 0777 (lectura, escritura y ejecución para todos los usuarios)
                chmod($img_dir, 0777);
                //Sino se puede mover el archivo de imagen al directorio de imágenes
                if(!move_uploaded_file($_FILES['usuario_foto']['tmp_name'], $img_dir.$foto)){
                    //Devuelve un mensaje de error
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"No podemos subir la imagen al sistema en este momento",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }else{
                //Si no se selecciona una imagen, establece el nombre del archivo de imagen como una cadena vacía
                $foto = "";
            }

            $usuario_datos_reg = [
                [
                    "campo_nombre"=>"usuario_nombre",
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre
                ],
                [
                    "campo_nombre"=>"usuario_apellido",
                    "campo_marcador"=>":Apellido",
                    "campo_valor"=>$apellido
                ],
                [
                    "campo_nombre"=>"usuario_email",
                    "campo_marcador"=>":Email",
                    "campo_valor"=>$email
                ],
                [
                    "campo_nombre"=>"usuario_usuario",
                    "campo_marcador"=>":Usuario",
                    "campo_valor"=>$usuario
                ],
                [
                    "campo_nombre"=>"usuario_clave",
                    "campo_marcador"=>":Clave",
                    "campo_valor"=>$clave
                ],
                [
                    "campo_nombre"=>"usuario_foto",
                    "campo_marcador"=>":Foto",
                    "campo_valor"=>$foto
                ],
                [
                    "campo_nombre"=>"usuario_creado",
                    "campo_marcador"=>":Creado",
                    "campo_valor"=>date("Y-m-d H:i:s")
                ],
                [
                    "campo_nombre"=>"usuario_actualizado",
                    "campo_marcador"=>":Actualizado",
                    "campo_valor"=>date("Y-m-d H:i:s")
                ],
            ];

            $registrar_usuario=$this->guardarDatos("usuarios",$usuario_datos_reg);
            if($registrar_usuario->rowCount()==1){
                $alerta=[
                    "tipo"=>"limpiar",
                    "titulo"=>"Usuario registrado",
                    "texto"=>"El usuario ".$nombre." ".$apellido." se registro con éxito",
                    "icono"=>"success"
                ];
            }else{

                if(is_file($img_dir.$foto)){
                   chmod($img_dir.$foto,0777);
                   unlink($img_dir.$foto);
                }
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrió un error inesperado",
                    "texto"=>"No se pudo registrar el usuario, por favor intente nuevamente",
                    "icono"=>"error"
                ];
            }
            return json_encode($alerta);

        }
    }
?>
