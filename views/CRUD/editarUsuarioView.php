<?php include_once("views/common/autentificacionAdmin.php"); ?>

<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" type="text/css" href="Css/Formulario.css">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>
<body>
    <!-- <h2>Editar Usuario</h2> -->
    <form action="index.php">
        <input type="hidden" name="controlador" value="Usuario">
        <input type="hidden" name="accion" value="editarUsuario">
        <input type="hidden" name="idUsuario" value="<?php echo $usuario->getIdUsuario(); ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $usuario->getNombre(); ?>">
        <?php echo isset($errores["nombre"]) ? $errores["nombre"] : ""; ?>
        <br>
        <label for="apellido1">Primer Apellido:</label>
        <input type="text" name="apellido1" value="<?php echo $usuario->getApellido1(); ?>">
        <br>
        <label for="apellido2">Segundo Apellido:</label>
        <input type="text" name="apellido2" value="<?php echo $usuario->getApellido2(); ?>">
        <br>
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" value="<?php echo $usuario->getTelefono(); ?>">
        <br>
        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo $usuario->getEmail(); ?>">
        <br>
        <label for="dni">DNI:</label>
        <input type="text" name="dni" value="<?php echo $usuario->getDni(); ?>">
        <br>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" value="<?php echo $usuario->getUsuario(); ?>">
        <br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" value="<?php echo $usuario->getcontraseña(); ?>">
        <br>
        <label for="categoria">Categoria</label>
        <select name="categoria">
            <?php foreach ($categorias as $categoria): 
                
                if ($categoria->getNombre()!="NULL") {
                    
               
                ?>
                
                <?php $selected = ($usuario->getid_Categoria() == $categoria->getIdCategoria()) ? 'selected' : ''; ?>
                <option value="<?php echo $categoria->getIdCategoria(); ?>" <?php echo $selected; ?>><?php echo $categoria->getNombre(); ?></option>
            <?php }endforeach; ?>
        </select>
        


        <input type="submit" name="submit" value="Guardar" class="button_css">
    </form>
    <br>
    <form action="index.php">
		<input type="hidden" name="controlador" value="Admin">
		<input type="hidden" name="accion" value="listar">
        <input type="hidden" name="id_admin" value=<?php echo $id_admin; ?>>
		<input type="submit" name="cancel" value="Cancelar" class="button_css cancel-btn">
		
	</form>
</body>
</html>
