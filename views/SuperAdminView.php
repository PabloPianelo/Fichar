<?php include_once("common/autentificacionSuperAdmin.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php include_once("common/menu_SuperAdmin.php"); ?>

<body>
    

<h1>Parametros</h1>

<table class="table">
<thead class="thead-dark">
    <tr>

        <th>Intentos</th>
        <th>Tiempo</th>
        <th>Intentos_login</th>
        <th>Editar</th>


    </tr>
    </thead>
    <?php
foreach ($parametros as $parametro) {
    ?>

    <td>
        <?php 
        echo $parametro->getIntentos();
     ?>
    </td>
    <td>
        <?php 
        echo $parametro->getTiempo();

        ?>
    </td>
    <td>
        <?php 
        echo $parametro->getIntentos_login();

        ?>
    </td>
    <td>
        <?php 
        echo '<a href="index.php?controlador=Parametros&accion=editarParametros "class="button_css"">Editar</a>';     
        ?>
    </td>

    </tr>
    <?php
}
?>
</table>



<h1>Comprobaciones</h1>


<table class="table">
<thead class="thead-dark">
        <th>Usuario</th>
        <th>Fecha/Hora</th>
        <th>Fallo por inicio de sesión</th>
        <th>Fallos por comprobación de usuario</th>

</thead>
    <?php
foreach ($comprobaciones as $comprobacion) {

    if (!$comprobacion->getActivo()) {
        
    
    ?>

    <td>
        <?php 
         foreach ($usuarios as $usuario) {

            if ( $comprobacion->getId_Usuario()==$usuario->getIdUsuario()) {
                echo  $usuario->getNombre();

            }
         }
     ?>
    </td>
    <td>
        <?php 
        echo $comprobacion->getFecha_hora();

        ?>
    </td>
    <td>
        <?php 
         if ($comprobacion->getLogin_Comprobacion()) {
            echo "SI";
          }else{
              echo "NO";
          }

        ?>
    </td>

    <td>
        <?php 
         if ($comprobacion->getIntnetos_Comprobacion()) {
            echo "SI";
          }else{
              echo "NO";
          }

        ?>
    </td>
    

    </tr>
    <?php
    }
}
?>
</table>


</body>

</html>