//Selecciona todos los elementos con la clase "FormularioAjax" y almacena en formularios_ajax
const formularios_ajax = document.querySelectorAll(".FormularioAjax");
//Itera sobre cada formulario seleccionado
formularios_ajax.forEach(formularios => {
    //Agrega un evento de escucha al evento submit de cada formulario
    formularios.addEventListener("submit", function(e) {
        //Previene el comportamiento por defecto del formulario (evita la recarga de la página)
        e.preventDefault();
        //Muestra un cuadro de diálogo de confirmación al usuario
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas realizar la acción solicitada?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, realizar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            //Si el usuario confirma la acción
            if (result.isConfirmed) {
                //Crea un objeto FormData con los datos del formulario actual
                let data = new FormData(this);
                //Obtiene el método y la acción del formulario
                let method = this.getAttribute("method");
                let action = this.getAttribute("action");
                //Configura los encabezados para la solicitud fetch
                let encabezados = new Headers();
                //Configura el objeto de configuración para la solicitud fetch
                let config = {
                    method: method,
                    headers: encabezados,
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data
                };
                //Realiza la solicitud fetch al servidor
                fetch(action, config)
                .then(respuesta => respuesta.json()) //Convierte la respuesta a JSON
                .then(respuesta => {
                    //Llama a la función alertas_ajax con la respuesta del servidor
                    return alertas_ajax(respuesta);
                });
            }
        });
    });
});

//Función para manejar las alertas y respuestas del servidor
function alertas_ajax(alerta) {
    //Comprobar el tipo de alerta recibida del servidor
    if(alerta.tipo=="simple"){
        //Mostrar una alerta simple utilizando la biblioteca SweetAlert2
        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        });
    } else if(alerta.tipo=="recargar"){
        //Mostrar una alerta y recargar la página si el usuario confirma
        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {
               location.reload(); //Recargar la página actual
            }
          });
    } else if(alerta.tipo=="limpiar"){
        //Mostrar una alerta y limpiar un formulario si el usuario confirma
        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(".FormularioAjax").reset(); // Limpiar el formulario con la clase .FormularioAjax
            }
        });
    } else if(alerta.tipo=="redireccionar"){
        //Redirigir a una URL especificada en la alerta
        window.location.href=alerta.url; //Cambiar la ubicación del navegador a la URL proporcionada
    }
}
//Obtener el elemento del botón con el id "btn_exit"
let btn_exit = document.getElementById("btn_exit");
//Agregar un evento de clic al botón
btn_exit.addEventListener("click", function(e) {
    //Prevenir el comportamiento predeterminado del clic (por ejemplo, evitar que se siga un enlace)
    e.preventDefault();
    //Mostrar un cuadro de diálogo de confirmación usando SweetAlert
    Swal.fire({
        title: '¿Quieres salir del sistema?',
        text: "La sesión actual se cerrará y saldrás del sistema",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, realizar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        //Si el usuario confirma la acción
        if (result.isConfirmed) {
            //Obtener la URL del atributo "href" del botón
            let url = this.getAttribute("href");
            //Redirigir a la URL obtenida
            window.location.href = url;
        }
    });
});


