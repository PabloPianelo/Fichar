<?php include_once("views/common/autentificacionSuperAdmin.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<link rel="stylesheet" type="text/css" href="Css/Formulario.css">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Editar Parámetros</title>
</head>

<body>
    <form action="index.php" method="POST">
        <input type="hidden" name="controlador" value="Parametros">
        <input type="hidden" name="accion" value="editarParametros">

        <label for="intentos">Intentos</label>
        <input type="number" name="intentos" value="<?php echo $parametros->getIntentos(); ?>">
        <br>

        <label for="tiempo">Tiempo</label>
        <input type="number" name="tiempo" value="<?php echo $parametros->getTiempo(); ?>">
        <br>

        <label for="intentos_login">Intentos de login</label>
        <input type="number" name="intentos_login" value="<?php echo $parametros->getIntentos_login(); ?>">
        <br>

        <input type="submit" name="submit" value="Aceptar" class="button_css">
    </form>
    <form action="index.php">
        <input type="hidden" name="controlador" value="SuperAdmin">
        <input type="hidden" name="accion" value="ListarSuperAdmin">
        <input type="submit" name="cancel" value="Cancelar" class="button_css cancel-btn">
    </form>
    <br>
    <?php
    if (isset($errores)) {
        foreach ($errores as $key => $error) {
            echo $error . "<br>";
        }
    }
    ?>
</body>

</html>
