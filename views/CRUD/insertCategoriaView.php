<?php include_once("views/common/autentificacionSuperAdmin.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<link rel="stylesheet" type="text/css" href="Css/Formulario.css">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>

<body>
<form action="index.php">
		<input type="hidden" name="controlador" value="Categoria">
		<input type="hidden" name="accion" value="nuevaCategoria">

		<?php echo isset($errores["nombre"]) ? "*" : "" ?>
		<label for="nombre">Nombre*</label>
		<input type="text" name="nombre" maxlength="10" required>
		<label for="asociaciones">Asociaciones</label>
		<select name="asociaciones">
		<?php 
			foreach($asociaciones as $asociacion) {
                echo "<option value='".$asociacion->getIdAsociacion()."' $selected>".$asociacion->getNombre()."</option>";
            }
		?>
		</select>



		</br>
		<input type="submit" name="submit" value="Aceptar"  class="button_css">

		</form>




	</form>
		<form action="index.php">
		<input type="hidden" name="controlador" value="Categoria">
		<input type="hidden" name="accion" value="ListarSuperAdminCategoria">
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