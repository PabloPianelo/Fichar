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
    <h1>Asociaciones</h1>

    <table class="table">
<thead class="thead-dark">

            <th>Nombre</th>
            <th>imagen</th>
            <th>Editar</th>
            <th>Borrar</th>
        </thead>
        <?php
    foreach ($asociaciones as $asociacion) {
        ?>

        <td>
            <?php 
            echo $asociacion->getNombre();
         ?>
        </td>
        <td>
            <?php 


          $imagen_base64 = base64_encode($asociacion->getImg());

          echo '<img src="data:image/jpeg;base64,' . $imagen_base64 . '" style="width: 150px; height: auto;">';
          
            ?>
        </td>
        <td>
            <?php 
            echo '<a href="index.php?controlador=Asociaciones&accion=editarAsociacion&codigo='. $asociacion->getIdAsociacion(). '"class="button_css">Editar</a>';     
            ?>
        </td>
        <td>
            <?php 
           echo '<a href="javascript:void(0);" onclick="confirmarEliminacion(' . $asociacion->getIdAsociacion() . ');" class="button_css">Eliminar</a>';

            ?>
        </td>
        </tr>
        <?php
    }
    ?>
    </table>
    <div class="button-container">

    <form action="index.php">
		<input type="hidden" name="controlador" value="Asociaciones">
		<input type="hidden" name="accion" value="nuevaAsociacion">
		<input type="submit" name="Nuevo" value="Nuevo" class="button_css" >
	</form>

</div>


<script type="text/javascript">
    function confirmarEliminacion(codigo) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?controlador=Asociaciones&accion=eliminarAsociacion&codigo=" + codigo;
            }
        });
    }
</script>
    
</body>

</html>