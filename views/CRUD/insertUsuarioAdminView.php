<?php include_once("views/common/autentificacionAdmin.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<link rel="stylesheet" type="text/css" href="Css/Formulario.css">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
    <script>
        function generarNumeroAleatorio() {
            var numeroAleatorio = Math.floor(1000 + Math.random() * 9000); // Generar número aleatorio de 4 cifras
            document.getElementsByName("contraseña")[0].value = numeroAleatorio

            alert("Número aleatorio generado: " + numeroAleatorio);
            
        }

        function calcularNombre() {
            var nombre = document.getElementsByName("nombre")[0].value;
            var apellido1 = document.getElementsByName("apellido1")[0].value;
            var apellido2 = document.getElementsByName("apellido2")[0].value;
            var dni = document.getElementsByName("dni")[0].value;

            // Verificar si todos los campos obligatorios están completos
            if (nombre && dni && apellido1 && apellido2) {
                var primerNombre = nombre.substr(0, 1);
                var primerApellido = apellido1.substr(0, 1);
                var segundoApellidoInicial = apellido2.substr(0, 1);
                var ultimosNumerosDNI = dni.substr(-3);

                var nombreGenerado = primerNombre + primerApellido + segundoApellidoInicial + ultimosNumerosDNI;
                document.getElementsByName("usuario")[0].value = nombreGenerado;

                alert("Nombre generado: " + nombreGenerado);
            } else {
                alert("Debe completar todos los campos obligatorios antes de generar el nombre.");
            }
        }

        function habilitarBotonNombre() {
            var nombre = document.getElementsByName("nombre")[0].value;
            var dni = document.getElementsByName("dni")[0].value;
            var botonNombre = document.getElementById("botonNombre");

            // Verificar si todos los campos obligatorios están completos
            if (nombre && dni) {
                botonNombre.disabled = false;
            } else {
                botonNombre.disabled = true;
            }
        }
    </script>
</head>
<body>
<form action="index.php">
		<input type="hidden" name="controlador" value="Usuario">
		<input type="hidden" name="accion" value="nuevoUsuarioAdmin">

        <label for="nombre">nombre*</label> 
        <input type="text" name="nombre" required oninput="habilitarBotonNombre()">

        <label for="apellido1">apellido1*</label> 
        <input type="text" name="apellido1" required oninput="habilitarBotonNombre()">

        <label for="apellido2">apellido2*</label> 
        <input type="text" name="apellido2"required oninput="habilitarBotonNombre()">

        <label for="dni">dni*</label> 
        <input type="text" name="dni"required oninput="habilitarBotonNombre()">
        
        
        <label for="telefono">telefono</label> 
        <input type="number" name="telefono">


        
        <?php echo isset($errores["email"]) ? "*" : "" ?>
        <label for="email">email*</label> 
        <input type="email" name="email" required>

		<label for="usuario">usuario*</label>
		<input type="text" name="usuario" maxlength="10" required>

		<label for="contraseña">contraseña*</label>
		<input type="password" name="contraseña" required>

		<label for="asociacion">asociación*</label>

		<select name="asociacion" id="selectAsociacion" required>
		<option value=''>Opciones</option>";

		<?php 
        foreach ($asociaciones as $asociacion) { 
			foreach($usuario_asociaciones as $usuario_asociacion) {
                if ($asociacion->getIdAsociacion() == $usuario_asociacion->getId_Asociacion()) { 
				echo "<option value='".$asociacion->getidAsociacion()."'>".$asociacion->getNombre()."</option >";
                }
			}
        }
		?>
		</select>
			
		<label for="categoria" id="Categoria" style="display: none;">Categoria*</label>
		<select name="id_Categoria" id="selectCategoria" style="display: none;" required>
		</select>

        <button type="button" onclick="generarNumeroAleatorio()"class="button_css">Generar Contraeña Aleatorio</button>
        <br>
        <br>
        <button type="button" id="botonNombre" onclick="calcularNombre()"  class="button_css" disabled >Generar Usuario</button>
        <br>




        <script>
           selectAsociacion.addEventListener('change', function() {

    var asociacionSeleccionada = selectAsociacion.value;

	if (asociacionSeleccionada == null) {
		selectCategoria.style.display = 'none';
		Categoria.style.display = 'none';
	}else{

    // Realizar la solicitud AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
				selectCategoria.style.display = 'block';
				Categoria.style.display = 'block';

                // Limpiar opciones actuales
                selectCategoria.innerHTML = '';

				console.log(xhr.responseText)
                // Obtener las categorías devueltas por el servidor
                var categorias = JSON.parse(xhr.responseText);
				
                // Agregar las nuevas opciones al segundo select
                categorias.forEach(function(categoria) {
                    var option = document.createElement('option');
                    option.value = categoria.idCategoria;
                    option.textContent = categoria.nombre;
                    selectCategoria.appendChild(option);
                });
            } else {
                console.error('Hubo un error al obtener las categorías.');
            }
        }
    };

    // Enviar la solicitud al servidor
    xhr.open('GET', 'views/recursos/obtener_categorias_asociacion.php?idasociacion=' + asociacionSeleccionada, true);
    xhr.send();
	}
});
</script>


		
		</br>
		<input type="submit" name="submit" value="Aceptar" class="button_css">
	</form>
    <form action="index.php">
		<input type="hidden" name="controlador" value="Admin">
		<input type="hidden" name="accion" value="listar">
        <input type="hidden" name="id_admin" value=<?php echo $id_admin; ?>>
		<input type="submit" name="cancel" value="Cancelar" class="button_css cancel-btn">
	</form>
	</br>
	<?php
	if (isset($errores)):
		foreach ($errores as $key => $error):
			echo $error . "</br>";
		endforeach;
	endif;
	?>

</body>

</html>
