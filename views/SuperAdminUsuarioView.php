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
   
<h1>Usuarios Admin</h1>

<table class="table">
<thead class="thead-dark">
        <th>Nombre</th>
        <th>Admin</th>
        <th>Acciones</th>
    </thead>
    <?php
    foreach ($usuarios as $usuario) {
        foreach ($usuario_asociaciones as $usuario_asociacion) {
            if ($usuario_asociacion->getId_Usuario() == $usuario->getIdUsuario() && !$usuario_asociacion->getSuperAdmi()) {
                echo "<tr>";
                echo "<td>" . $usuario->getNombre() . "</td>";
                if ($usuario_asociacion->getAdmi()) {
                    echo "<td> Admin </td>";
                }else{
                    echo "<td> Usuario </td>";

                }
                
                echo "<td>";
                echo '<a href="index.php?controlador=Usuario_Asociacion&accion=listarAdmin&codigo=' . $usuario->getIdUsuario() . '"class="button_css">Crear admin </a>';
                echo ' | ';
                // echo '<a href="index.php?controlador=usuario&accion=eliminarUsuarios&codigo=' . $usuario->getIdUsuario() . '"class="button_css">Eliminar Usuario </a>';
                echo '<a href="javascript:void(0);" onclick="confirmarEliminacion(' . $usuario->getIdUsuario() . ');" class="button_css">Eliminar Usuario</a>';
                echo "</td>";
                echo "</tr>";
                // Rompe el bucle después de encontrar una correspondencia para evitar repeticiones
                break;
            }
        }
    }
    ?>
</table>
<div class="button-container">

<form action="index.php">
		<input type="hidden" name="controlador" value="Usuario">
		<input type="hidden" name="accion" value="nuevoUsuarios">
		<input type="submit" name="Nuevo" value="Nuevo Usuario" class="button_css">
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
                window.location.href = "index.php?controlador=usuario&accion=eliminarUsuarios&codigo=" + codigo;
            }
        });
    }
</script>
    
</body>

</html>