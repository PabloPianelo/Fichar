<?php include_once("views/common/autentificacionSuperAdmin.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<link rel="stylesheet" type="text/css" href="Css/Formulario.css">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>

<body>
	<form action="index.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="controlador" value="Asociaciones">
		<input type="hidden" name="accion" value="nuevaAsociacion">

		<?php echo isset($errores["nombre"]) ? "*" : "" ?>
		<label for="nombre">Nombre*</label>
		<input type="text" name="nombre" maxlength="10" required>
		
        
		<label for="imagen">Imagen*</label>
		<input type="file" name="imagen" accept="image/*" required>

		</br>
		<input type="submit" name="submit" value="Aceptar" class="button_css">
	</form>
	<form action="index.php">
		<input type="hidden" name="controlador" value="Asociaciones">
		<input type="hidden" name="accion" value="ListarSuperAdminAsociaciones">
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
