<?php include_once("common/autentificacion.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="Css/Fichar.css">

</head>
<body>
<li> <a href="index.php?controlador=Login&accion=logout"class="a_underline">Cerrar sesión</a> </li>

<?php 


$imagen_base64 = base64_encode($imagenAsociacion);


?>

<td>
    <img src="data:image/jpeg;base64,<?php echo $imagen_base64; ?>" style="width: 200px; height: auto;" />
</td>

<form action="index.php">
<input type="hidden" name="controlador" value="Fichar">
<input type="hidden" name="accion" value="insertarFicha">

<?php
$entrada_salida="";
// echo $username;
if ($comprobar) {
    $entrada_salida= "Entrada" ;
}else{
  
     $entrada_salida= "Salida" ;
}

//posiblemente se quede en el estado de enviar y por eso entra al boton
//hacerlo en otra funcion y luego mandarla a fichar
?>  
<input type="hidden" name="entrada_salida" value="<?php echo $entrada_salida; ?>">

<input type="submit" name="boton" value="<?php echo $entrada_salida; ?>" class="button_css">
</form>
</body>
</html>