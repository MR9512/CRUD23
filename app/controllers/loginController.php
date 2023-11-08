<?php
	//Declaración del espacio de nombres "app\controllers"
	namespace app\controllers;
	//Importa la clase "mainModel" del espacio de nombres "app\models"
	use app\models\mainModel;
	//Definición de la clase "loginController" que extiende la clase "mainModel"
	class loginController extends mainModel {
	//Método para iniciar sesión del usuario
	public function iniciarSesionControlador() {
		//Obtiene y limpia el valor del campo 'login_usuario' del formulario de inicio de sesión
		$usuario = $this->limpiarCadena($_POST['login_usuario']);
		//Obtiene y limpia el valor del campo 'login_clave' del formulario de inicio de sesión
		$clave = $this->limpiarCadena($_POST['login_clave']);
			// Verifica si el usuario o la contraseña están vacíos.
			if($usuario=="" || $clave==""){
				//Si alguno de los campos está vacío, muestra un mensaje de error utilizando SweetAlert.
				echo "<script>
						Swal.fire({
						icon: 'error',
						title: 'Ocurrió un error inesperado',
						text: 'No has llenado todos los campos que son obligatorios'
						});
					</script>";
			}else{
					//Si tanto el usuario como la contraseña están presentes, continúa con las verificaciones de integridad de datos.
				    //Utiliza una expresión regular para verificar si el usuario coincide con el formato esperado.
					if($this->verificarDatos("[a-zA-Z0-9]{4,20}", $usuario)){
						//Si el usuario no coincide con el formato solicitado, muestra un mensaje de error utilizando SweetAlert.
						echo "<script>
								Swal.fire({
								  icon: 'error',
								  title: 'Ocurrió un error inesperado',
								  text: 'El Usuario no coincide con el formato solicitado'
								});
							  </script>";
					}else{
			    	//Utiliza una expresión regular para verificar si la contraseña coincide con el formato esperado.
				    if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
					    //Si la contraseña no coincide con el formato solicitado, muestra un mensaje de error utilizando SweetAlert.
				        echo "<script>
					        Swal.fire({
							  icon: 'error',
							  title: 'Ocurrió un error inesperado',
							  text: 'La Clave no coincide con el formato solicitado'
							});
						</script>";
				    }else{
			        //Realiza una consulta SQL para seleccionar un usuario de la base de datos donde el nombre de usuario coincida con el valor proporcionado en la variable $usuario.
					$check_usuario = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE usuario_usuario='$usuario'");
					//Verifica si se encontró exactamente un usuario en la base de datos con el nombre de usuario proporcionado.
					if($check_usuario->rowCount() == 1) {
						//Si se encontró un usuario, obtiene los datos del usuario desde el resultado de la consulta.
						$check_usuario = $check_usuario->fetch();
						//Compara el nombre de usuario y la contraseña proporcionados con los valores almacenados en la base de datos.
						if($check_usuario['usuario_usuario'] == $usuario && password_verify($clave, $check_usuario['usuario_clave'])) {
							//Si el nombre de usuario y la contraseña coinciden, establece las variables de sesión para el usuario.
							$_SESSION['id'] = $check_usuario['usuario_id'];
							$_SESSION['nombre'] = $check_usuario['usuario_nombre'];
							$_SESSION['apellido'] = $check_usuario['usuario_apellido'];
							$_SESSION['usuario'] = $check_usuario['usuario_usuario'];
							$_SESSION['foto'] = $check_usuario['usuario_foto'];
                                //Verifica si las cabeceras HTTP ya se han enviado al cliente.
					            if(headers_sent()){
									//Si las cabeceras ya se han enviado, redirige al usuario a la página de dashboard utilizando JavaScript.
					                echo "<script> window.location.href='".APP_URL."dashboard/'; </script>";
					            }else{
									//Si las cabeceras no se han enviado, redirige al usuario a la página de dashboard utilizando la función header() de PHP.
					                header("Location: ".APP_URL."dashboard/");
					            }
						    //Si las credenciales del usuario no coinciden, muestra un mensaje de error utilizando SweetAlert.		
					    	}else{
								//Este bloque de código se ejecuta si el nombre de usuario o la contraseña son incorrectos.
					    		echo "<script>
							        Swal.fire({
									  icon: 'error',
									  title: 'Ocurrió un error inesperado',
									  text: 'Usuario o clave incorrectos'
									});
								</script>";
					    	}
					    }else{
							//Este bloque de código se ejecuta si el nombre de usuario o la contraseña son incorrectos.
					        echo "<script>
						        Swal.fire({
								  icon: 'error',
								  title: 'Ocurrió un error inesperado',
								  text: 'Usuario o clave incorrectos'
								});
							</script>";
					    }
				    }
			    }
		    }
		}
        //Este es un método público llamado cerrarSesionControlador.
		public function cerrarSesionControlador(){
			//Destruye todas las variables de sesión.
			session_destroy();
			//Verifica si las cabeceras HTTP ya se han enviado al cliente.
			if(headers_sent()){
				//Si las cabeceras ya se han enviado, redirige al usuario a la página de inicio de sesión utilizando JavaScript.
				echo "<script> window.location.href='".APP_URL."login/'; </script>";
			} else {
				//Si las cabeceras no se han enviado, redirige al usuario a la página de inicio de sesión utilizando la función header() de PHP.
				header("Location: ".APP_URL."login/");
			}
		}
		

	}