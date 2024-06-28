<?php include_once("common/autentificacionAdmin.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css/Admin.css">

    <title>Document</title>
   
</head>
<body>
<li> <a href="index.php?controlador=Login&accion=logout"class="a_underline">Cerrar sesión</a> </li>

    <?php foreach ($asociaciones as $asociacion) { 
        foreach ($usuarios_asociaciones as $usuario_asociacion) { 
            if ($asociacion->getIdAsociacion() == $usuario_asociacion->getId_Asociacion()) { 
                $imagen_base64 = base64_encode($asociacion->getImg()); ?>
                <td>
                    <img src="data:image/jpeg;base64,<?php echo $imagen_base64; ?>" style="width: 200px; height: auto;" />
                </td>
            <?php } 
        }
    } ?>

<h1>Usuarios</h1>

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th>Nombre</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
            <th>Telefono</th>
            <th>Email</th>
            <th>dni</th>
            <th>Activo</th>
            <th>Usuario</th>
            <th>Categoria</th>
            <th>Asociación</th>
            <th>Editar</th>
            <th> Cambiar Asociación</th>
            <th>Activar/Desactivar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario) { ?>
            <tr class="activo" data-activo="<?php echo $usuario->getActivo() ? 'Sí' : 'No'; ?>">
                <td><?php echo $usuario->getNombre(); ?></td>
                <td><?php echo $usuario->getApellido1(); ?></td>
                <td><?php echo $usuario->getApellido2(); ?></td>
                <td><?php echo $usuario->getTelefono(); ?></td>
                <td><?php echo $usuario->getEmail(); ?></td>
                <td><?php echo $usuario->getDni(); ?></td>
                <td><?php echo $usuario->getActivo() ? 'Sí' : 'No'; ?></td>
                <td><?php echo $usuario->getUsuario(); ?></td>
                <td>
                    <?php foreach ($categorias as $categoria) {
                        if ($categoria->getIdCategoria() == $usuario->getid_categoria()) {
                            echo $categoria->getNombre();
                        }
                    } ?>
                </td>
                <td>
                    <?php 
                    foreach ($allUsuario_asociaciones as $allUsuario_asociacion) { 
                        if ($allUsuario_asociacion->getId_Usuario() == $usuario->getIdUsuario()) { 
                            foreach ($asociaciones as $asociacion) { 
                                if ($asociacion->getIdAsociacion() == $allUsuario_asociacion->getId_Asociacion()) { 
                                    echo $asociacion->getNombre(); 
                                } 
                            } 
                        } 
                    } 
                    ?>
                </td>
                <td>
                    <a href="index.php?controlador=Usuario&accion=editarUsuario&codigo=<?php echo $usuario->getIdUsuario(); ?>" class="button_css">Editar</a>
                </td>
                <td>
                    <a href="index.php?controlador=Usuario&accion=cambiarAsociacion&codigo=<?php echo $usuario->getIdUsuario(); ?>" class="button_css">Cambiar</a>
                </td>
                <td>
                    <a href="index.php?controlador=Admin&accion=cambiarActivo&codigo=<?php echo $usuario->getIdUsuario(); ?>" class="button_css">Activar/Desactivar</a>
                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="button-container">
<form action="index.php">
		<input type="hidden" name="controlador" value="Usuario">
		<input type="hidden" name="accion" value="nuevoUsuarioAdmin">
		<input type="submit" name="Nuevo" value="Nuevo" class="button_css" >
	</form>

    </div>



        <h1>Fichar</h1>

<table class="table">
<thead class="thead-dark">
        <th>Nombre</th>
        <th>Entrada/Salida</th>
        <th>Fecha y Hora</th>
        
    </thead>
    
    <?php foreach ($fichajes as $fichar) { ?>
        <tr>
            <td>
                <?php foreach ($usuarios as $usuario) {
                    if ($fichar->getId_Usuario() == $usuario->getIdUsuario()) {
                       echo  $usuario->getNombre();
                    }
                } ?>
                </td>
            <td><?php echo $fichar->getEntrada_salida() ? 'Entrada' : 'Salida'; ?></td>
            <td><?php echo $fichar->getFecha_hora(); ?></td>
            
        </tr>
    <?php } ?>
</table>



<br>
<br>
<br>




    </table>
</body>
</html>
