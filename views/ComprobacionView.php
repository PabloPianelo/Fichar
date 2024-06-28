<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="Css/Formulario.css">

</head>
<body>



<form action="index.php?controlador=Login&accion=comprobar" method="POST" id="myForm">


    <input type="hidden" name="tiempo" value="<?php echo $tiempo; ?>">

    <input type="hidden" name="clave" value="<?php echo $clave; ?>">

    <input type="hidden" name="idcomprobacion" value="<?php echo $idcomprobacion; ?>">

    <!-- <input type="hidden" name="codigo_verificacion" value="<?php echo $codigo_verificacion; ?>"> -->

    <input type="number" name="codigo">
    <label>Codigo:<?php echo $clave; ?></label>
    <input type="submit" name="Aceptar" value="Aceptar">

    </form>
    <div id="cuentaRegresiva"></div>


    <script>
function enviarFormulario() {
    document.getElementById("myForm").submit();
}

function iniciarCuentaRegresiva(tiempo) {
  
    document.getElementById("cuentaRegresiva").innerText = "Tiempo restante: " + tiempo + " segundos";

    
    var intervalo = setInterval(function() {
       
        if (tiempo <= 0) {
            document.getElementById("cuentaRegresiva").innerText = "Tiempo agotado.";
            clearInterval(intervalo); //se detiene
            
            enviarFormulario(); 
        } else {
            tiempo--; 
            document.getElementById("cuentaRegresiva").innerText = "Tiempo restante: " + tiempo + " segundos";
        }
    }, 1000);//cada 1000 milisegundos
}

var tiempo = parseInt(document.querySelector('input[name="tiempo"]').value);
iniciarCuentaRegresiva(tiempo);
</script>
</body>
</html>