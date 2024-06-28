<?php include_once("common/autentificacionSuperAdmin.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php include_once("common/menu_SuperAdmin.php"); ?>



    <h1>Categorias</h1>

    <table class="table">
<thead class="thead-dark">

        <th>Nombre</th>
        <th>Asociación</th>
        <th>Editar</th>
        <th>Borrar</th>

    </thead>
    <?php
foreach ($categorias as $categoria) {
    if ($categoria->getNombre()!="NULL") {
    ?>

    <td>
        <?php 
        
        echo $categoria->getNombre();
         
     ?>
    </td>
    <td>
        <?php 
           foreach ($asociaciones as $asociacion) {
              if ($categoria->getId_Asociacion()==$asociacion->getIdAsociacion()) {
                
                echo $asociacion->getNombre();

              }
            }
        ?>
    </td>
    <td>
        <?php 
        echo '<a href="index.php?controlador=Categoria&accion=editarCategoria&codigo='. $categoria->getIdCategoria(). '"class="button_css">Editar</a>';     
        ?>
    </td>
    <td>
        <?php 
          echo '<a href="javascript:void(0);" onclick="confirmarEliminacion(' . $categoria->getIdCategoria() . ');" class="button_css">Eliminar</a>';

        ?>
    </td>
    </tr>
    <?php
         }
}
?>
</table>

<div class="button-container">

<form action="index.php">
    <input type="hidden" name="controlador" value="Categoria">
    <input type="hidden" name="accion" value="nuevaCategoria">
    <input type="submit" name="Nuevo" value="Nuevo" class="button_css">
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
                window.location.href = "index.php?controlador=Categoria&accion=eliminarCategoria&codigo=" + codigo;
            }
        });
    }
</script>
    
</body>

</html>