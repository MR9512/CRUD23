<nav class="navbar"> <!-- Elemento de navegación con la clase "navbar" -->
    <div class="navbar-brand"> <!-- Contenedor del logotipo y el botón de hamburguesa -->
        <a class="navbar-item" href="<?php echo APP_URL; ?>dashboard/"> <!-- Elemento de la barra de navegación como un enlace -->
            <img src="<?php echo APP_URL; ?>app/views/img/bulma.png" alt="Bulma" width="112" height="28"> <!-- Logotipo de la página -->
        </a>
        <div class="navbar-burger" data-target="navbarExampleTransparentExample"> <!-- Botón de hamburguesa para dispositivos móviles -->
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div id="navbarExampleTransparentExample" class="navbar-menu"> <!-- Contenedor de los elementos de la barra de navegación -->

        <div class="navbar-start"> <!-- Elementos de la barra de navegación en la parte izquierda -->
            <a class="navbar-item" href="<?php echo APP_URL; ?>dashboard/"> <!-- Elemento de la barra de navegación como un enlace -->
                Dashboard <!-- Texto del enlace -->
            </a>

            <div class="navbar-item has-dropdown is-hoverable"> <!-- Elemento con menú desplegable -->
                <a class="navbar-link" href="#"> <!-- Elemento de la barra de navegación como un enlace -->
                    Usuarios <!-- Texto del enlace -->
                </a>
                <div class="navbar-dropdown is-boxed"> <!-- Menú desplegable -->
                    <a class="navbar-item" href="<?php echo APP_URL; ?>userNew/"> <!-- Elemento del menú desplegable como un enlace -->
                        Nuevo <!-- Texto del enlace -->
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>userList/">
                        Lista
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>userSearch/">
                        Buscar
                    </a>
                </div>
            </div>
        </div>

        <div class="navbar-end"> <!-- Elementos de la barra de navegación en la parte derecha -->
            <div class="navbar-item has-dropdown is-hoverable"> <!-- Elemento con menú desplegable -->
                <a class="navbar-link"> <!-- Elemento de la barra de navegación como un enlace -->
                    ** User Name ** <!-- Nombre de usuario (puede ser dinámico según la sesión del usuario) -->
                </a>
                <div class="navbar-dropdown is-boxed"> <!-- Menú desplegable -->
                    <a class="navbar-item" href="<?php echo APP_URL; ?>userUpdate/"> <!-- Elemento del menú desplegable como un enlace -->
                        Mi cuenta <!-- Texto del enlace -->
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>userPhoto/">
                        Mi foto
                    </a>
                    <hr class="navbar-divider"> <!-- Línea divisoria del menú desplegable -->
                    <a class="navbar-item" href="<?php echo APP_URL; ?>logOut/" id="btn_exit"> <!-- Elemento del menú desplegable como un enlace con un identificador "btn_exit" -->
                        Salir <!-- Texto del enlace -->
                    </a>
                </div>
            </div>
        </div>

    </div>
</nav>
