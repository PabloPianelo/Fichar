<?php include_once("views/common/autentificacionSuperAdmin.php"); ?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="Css/Formulario.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Asociaciones a las que puedes ser admin</h1>
<form action="index.php">
    <input type="hidden" name="controlador" value="Usuario_Asociacion">
    <input type="hidden" name="accion" value="insertarAdmin">

    <label for="asociaciones">Asociaciones</label>
    <select name="asociaciones">
        <?php 
        
        foreach($asociaciones as $asociacion) {
            $esAdmin = false;
            foreach($usuarios_asociaciones as $usuario_asociacion) {
                if ($asociacion->getIdAsociacion() == $usuario_asociacion->getId_Asociacion()) {
                    $esAdmin = true;
                    break;
                }
            }
            if (!$esAdmin) {
                echo "<option value='".$asociacion->getIdAsociacion()."' >".$asociacion->getNombre()."</option>";
            }
        }
        ?>
    </select>
    <input type="hidden" name="codigo" value="<?php echo $codigo; ?> ">
    <input type="submit" name="submit" value="Aceptar" class="button_css">

</form>
<form action="index.php">
    <input type="hidden" name="controlador" value="Usuario_Asociacion">
    <input type="hidden" name="accion" value="listarAdmin">
    <input type="hidden" name="codigo" value="<?php echo $codigo; ?> ">
    <input type="submit" name="cancel" value="Cancelar" class="button_css cancel-btn">
</form>

</body>
</html>