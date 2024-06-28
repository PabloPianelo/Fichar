<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1><?php echo $usuarios->getNombre()?></h1>

<form action="index.php" method="post">
<input type="hidden" name="controlador" value="SuperAdmin">
<input type="hidden" name="accion" value="añadirAdmin">

<input type="hidden" name="codigo" value=<?php echo $usuarios->getIdUsuario()?>>


<?php 
foreach($asociaciones as $asociacion){
    $checked = false;
    foreach($usuario_asociaciones as $usuario_asociacion){
        if ($usuario_asociacion->getId_Asociacion() == $asociacion->getIdAsociacion() && $usuario_asociacion->getAdmi()) {
            $checked = true;
            break; 
        }
    }
    echo '<input type="checkbox" name="checkbox[]" value="' . $asociacion->getIdAsociacion() . '"';
    if ($checked) {
        echo ' checked';
    }
    echo '>' . $asociacion->getNombre() . '<br>';
}
?>

<label for="asociacion">indica la asociacion si lo quieres combrertir en usuario y no en admin</label>

<select name="asociacion" >
<option value=''>Opciones</option>";

<?php 
    foreach($asociaciones as $asociacion) {
        echo "<option value='".$asociacion->getidAsociacion()."'>".$asociacion->getNombre()."</option>";
    }
?>
</select>
			
    <input type="submit" name="Enviar" value="Enviar">

</form>


</body>
</html>