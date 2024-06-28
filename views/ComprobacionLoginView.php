<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="Css/Formulario.css">

</head>
<body>



<form action="index.php?controlador=Login&accion=comprobar_login" method="POST" id="myForm">


    <input type="hidden" name="idcomprobacion" value="<?php echo $idcomprobacion; ?>">

    Email 
    <input type="text" name="email" required>

    <input type="submit" name="Aceptar" value="Aceptar">


    <label><?php echo $error; ?></label>

    </form>
   


   
</body>
</html>