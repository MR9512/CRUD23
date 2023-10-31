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
    //Implementa el código para manejar las respuestas del servidor y mostrar alertas al usuario
}
