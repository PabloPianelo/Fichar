<?php include_once("views/common/autentificacionAdmin.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<link rel="stylesheet" type="text/css" href="Css/Formulario.css">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
   
</head>
<body>
<form action="index.php">
		<input type="hidden" name="controlador" value="Usuario">
		<input type="hidden" name="accion" value="cambiarAsociacion">
        <input type="hidden" name="idUsuario" value="<?php echo $usuario->getIdUsuario(); ?>">


            <h1>Cambiar Asociación</h1>

           

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
