<!-- Contenedor principal con clases "container", "is-fluid" y "mb-6" -->
<div class="container is-fluid mb-6">
	<!-- Título principal -->
	<h1 class="title">Usuarios</h1>
	<!-- Subtítulo -->
	<h2 class="subtitle">Nuevo usuario</h2>
</div>

<!-- Contenedor con clases "container", "pb-6" y "pt-6" -->
<div class="container pb-6 pt-6">
	<!-- Formulario con clase "FormularioAjax", acción de usuario, método POST, deshabilita el autocompletar y permite cargar archivos -->
	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
		<!-- Campo oculto para indicar el módulo del usuario -->
		<input type="hidden" name="modulo_usuario" value="registrar">

		<!-- Sección de nombres y apellidos en dos columnas -->
		<div class="columns">
			<div class="column">
				<div class="control">
					<!-- Etiqueta y campo para el nombre del usuario -->
					<label>Nombres</label>
					<input class="input" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<!-- Etiqueta y campo para el apellido del usuario -->
					<label>Apellidos</label>
					<input class="input" type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
				</div>
			</div>
		</div>

		<!-- Sección de usuario y correo electrónico en dos columnas -->
		<div class="columns">
			<div class="column">
				<div class="control">
					<!-- Etiqueta y campo para el nombre de usuario -->
					<label>Usuario</label>
					<input class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<!-- Etiqueta y campo para la dirección de correo electrónico -->
					<label>Email</label>
					<input class="input" type="email" name="usuario_email" maxlength="70">
				</div>
			</div>
		</div>

		<!-- Sección de contraseña y repetir contraseña en dos columnas -->
		<div class="columns">
			<div class="column">
				<div class="control">
					<!-- Etiqueta y campo para la contraseña -->
					<label>Clave</label>
					<input class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<!-- Etiqueta y campo para repetir la contraseña -->
					<label>Repetir clave</label>
					<input class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
				</div>
			</div>
		</div>

		<!-- Sección para cargar una foto -->
		<div class="columns">
			<div class="column">
				<div class="file has-name is-boxed">
					<label class="file-label">
						<!-- Campo para cargar un archivo de imagen -->
						<input class="file-input" type="file" name="usuario_foto" accept=".jpg, .png, .jpeg">
						<span class="file-cta">
							<span class="file-label">
								Seleccione una foto
							</span>
						</span>
						<!-- Indicación del tipo de archivos permitidos y tamaño máximo -->
						<span class="file-name">JPG, JPEG, PNG. (MAX 5MB)</span>
					</label>
				</div>
			</div>
		</div>

		<!-- Botones para limpiar el formulario y enviar los datos -->
		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>
