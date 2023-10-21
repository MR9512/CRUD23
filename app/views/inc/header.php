<!-- Establece la codificación de caracteres del documento como UTF-8, que es compatible con la mayoría de los caracteres utilizados en varios idiomas. -->
<meta charset="UTF-8"> 
<!-- Establece las propiedades de visualización en dispositivos móviles. width=device-width indica que el ancho del documento se ajustará al ancho del dispositivo.
initial-scale=1.0 establece el nivel de zoom inicial cuando el documento se carga en un dispositivo móvil. -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<!-- Establece el título de la página. La etiqueta PHP se utiliza para imprimir el valor de la constante APP_NAME. -->
<title><?php echo APP_NAME?></title> 
<!-- Vincula la hoja de estilo "bulma.min.css" al documento HTML. -->
<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/bulma.min.css">
<!-- Este elemento <link> se utiliza para vincular la hoja de estilo personalizado al documento HTML. -->
<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/estilos.css">


