<?php include_once("views/common/autentificacionSuperAdmin.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<link rel="stylesheet" type="text/css" href="Css/Formulario.css">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>

<body>
	<form action="index.php"  method="POST"  enctype="multipart/form-data">
		<input type="hidden" name="controlador" value="Asociaciones">
		<input type="hidden" name="accion" value="editarAsociacion">

		<input type="hidden" name="codigo" value="<?php echo $asociacion->getIdAsociacion(); ?>">

		<?php echo isset($errores["nombre"]) ? "*" : "" ?>
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" value="<?php echo $asociacion->getNombre(); ?>">
		</br>

		<label for="img">Imagen Actual</label>
		<img src="data:image/jpeg;base64,<?php echo base64_encode($asociacion->getImg()); ?>" alt="Imagen asociación" width="100" height="100">
		</br>

		<label for="nueva_img">Seleccionar Nueva Imagen</label>
		<input type="file" name="nueva_img" accept="image/*">
		</br>
        <div class="button-wrapper">

		<input type="submit" name="submit" value="Aceptar" class="button_css">
		</div>
	</form>
	<form action="index.php">
	<div class="button-wrapper">

		<input type="hidden" name="controlador" value="Asociaciones">
		<input type="hidden" name="accion" value="ListarSuperAdminAsociaciones">
		<input type="submit" name="cancel" value="Cancelar"  class="button_css cancel-btn">
		</div>
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
