<?php include_once("views/common/autentificacionSuperAdmin.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="Css/SuperAdmin.css">

</head>
<body>
<h1><?php echo $usuario->getNombre(); ?></h1>
<h2>Asociaciones de las que es Admin</h2>

<table>
    <tr>
        <th>Nombre</th>
        <th>Eliminar</th>
    </tr>
    
    <?php foreach ($usuarios_asociaciones as $usuario_asociacion) { ?>
        <tr>
            <td><?php 
                foreach ($asociaciones as $asociacion) {
                    if ($asociacion->getIdAsociacion() == $usuario_asociacion->getId_Asociacion()) {
                        echo $asociacion->getNombre(); 
                    }
                }
            ?></td>
           
            <td>
                <a href="index.php?controlador=Usuario_Asociacion&accion=eliminarAdmin&codigo_usuario=<?php echo $usuario_asociacion->getId_Usuario(); ?>&codigo_asociacion=<?php echo $usuario_asociacion->getId_Asociacion(); ?>">Eliminar</a>
            </td>
        </tr>
    <?php } ?>
</table>


<a href="index.php?controlador=Usuario_Asociacion&accion=insertarAdmin&codigo=<?php echo $usuario->getIdUsuario(); ?>"class="button_css">Añadir +</a>








<form action="index.php">

<?php if(!empty($usuarios_asociaciones)){?>
    <h2>Cambiar el admin a modo usuario</h2>

<label for="asociaciones">Asociaciones</label>
		<select name="asociaciones">
		<?php 
         
			foreach($asociaciones as $asociacion) {
                echo "<option value='".$asociacion->getIdAsociacion()."' >".$asociacion->getNombre()."</option>";
            }
		?>
		</select>
            <br>
            <br>

		<input type="hidden" name="controlador" value="Usuario_Asociacion">
		<input type="hidden" name="accion" value="cambiarUsuario">
        <input type="hidden" name="codigo" value="<?php echo $usuario->getIdUsuario(); ?>">
		<input type="submit" name="submit" value="Aceptar"class="button_css">
        <?php }?>
        <br>
        <br>
    </form>








    
		<form action="index.php">
		<input type="hidden" name="controlador" value="Usuario">
		<input type="hidden" name="accion" value="ListarSuperAdminUsuario">
		<input type="submit" name="cancel" value="Cancelar"class="button_css">
	    </form>
</body>
</html>