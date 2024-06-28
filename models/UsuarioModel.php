<?php

class UsuarioModel
{
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla ITEMS
    private $idUsuario;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $telefono;
    private $email;
    private $dni;
    private $activo;
    private $usuario;
    private $contraseña;
    private $id_Categoria;
    
    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    public function setIdUsuario ($idUsuario)
    {
        return $this->idUsuario  = $idUsuario;
    }

    public function getNombre ()
    {
        return $this->nombre ;
    }
    public function setNombre ($nombre)
    {
        return $this->nombre  = $nombre ;
    }

    public function getApellido1()
    {
        return $this->apellido1;
    }

    public function setApellido1 ($apellido1 )
    {
        return $this->apellido1 = $apellido1;
    }

    public function getApellido2()
    {
        return $this->apellido2;
    }

    public function setApellido2 ($apellido2)
    {
        return $this->apellido2 = $apellido2;
    }



    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono ($telefono)
    {
        return $this->telefono = $telefono;
    }




    public function getDni()
    {
        return $this->dni;
    }

    public function setDni ($dni)
    {
        return $this->dni = $dni;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail ($email)
    {
        return $this->email = $email;
    }


    public function getactivo ()
    {
        return $this->activo ;
    }

    public function setactivo ($activo )
    {
        return $this->activo  = $activo ;
    }

    public function getcontraseña()
    {
        return $this->contraseña;
    }
    public function setcontraseña($contraseña)
    {
        return $this->contraseña = $contraseña;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario($usuario)
    {
        return $this->usuario = $usuario;
    }

   

    public function getid_Categoria ()
    {
        return $this->id_Categoria ;
    }
    public function setid_Categoria ($id_Categoria)
    {
        return $this->id_Categoria  = $id_Categoria ;
    }


    // Método para obtener todos los registros de la tabla ITEMS
    // Devuelve un array de objetos de la clase ItemModel
    public function getAll()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('SELECT * FROM usuario');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "UsuarioModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }


    public function getById($id)
    {
        $gsent = $this->db->prepare('SELECT * FROM usuario where idUsuario = ?' );
        $gsent->bindParam(1, $id );
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "UsuarioModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }




    
    
    public function ComprobarUser_Password($user, $password)
    {
        
            $gsent = $this->db->prepare('SELECT * FROM usuario WHERE usuario = ? AND contraseña=?');
            $gsent->bindParam(1, $user);
            $password_encrypt = sha1($password);
            $gsent->bindParam(2, $password_encrypt);
            $gsent->execute();

            $gsent->setFetchMode(PDO::FETCH_CLASS, "UsuarioModel");
            $resultado = $gsent->fetch();

        if (!$resultado) {
            return false;
        } else {
            return true;
        }
    }

   

    public function Activo_Verificación($id){

        $gsent = $this->db->prepare('SELECT activo FROM usuario WHERE idUsuario = ?');
        $gsent->bindParam(1, $id);
        $gsent->execute();
    
        $resultado = $gsent->fetch(PDO::FETCH_ASSOC);
    
        if ($resultado) {
            return $resultado['activo'];
        } else {
           
            return false;
        }
    }


    public function getByEmail($email){

        $gsent = $this->db->prepare('SELECT idUsuario FROM usuario WHERE email = ?');
        $gsent->bindParam(1, $email);
        $gsent->execute();
    
        $resultado = $gsent->fetch(PDO::FETCH_ASSOC);
    
        if ($resultado) {
            return $resultado['idUsuario'];
        } else {
           
            return false;
        }
    }




    public function cambiarEstado($id)
{
    // Verificar el estado actual del usuario
    $estadoActual = $this->Activo_Verificación($id);

    // Si el estado actual es true, lo desactivamos; si es false, lo activamos
    $nuevoEstado = !$estadoActual;

    // Actualizamos el estado en la base de datos
    $consulta = $this->db->prepare('UPDATE `usuario` SET `activo` = ? WHERE idUsuario = ?');
    $consulta->bindParam(1, $nuevoEstado);
    $consulta->bindParam(2, $id);
    $consulta->execute();
    
    // Devolvemos el nuevo estado
    return $nuevoEstado;
}
public function getByIdCategoria($idCategoria)
{
    $consulta = $this->db->prepare('SELECT * FROM usuario WHERE id_Categoria = ?');
    $consulta->bindParam(1, $idCategoria);
    $consulta->execute();

    $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "UsuarioModel");

    return $resultado;
}




    // Método que almacena en BD un objeto ItemModel
    // Si tiene ya código actualiza el registro y si no tiene lo inserta
    public function save()
    {
        if (!isset($this->idUsuario )) {
            $consulta = $this->db->prepare('INSERT INTO `usuario`(`nombre`, `apellido1`, `apellido2`, `telefono`, `email`, `activo`, `dni`, `usuario`, `contraseña`, `id_Categoria`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->apellido1);
            $consulta->bindParam(3, $this->apellido2);
            $consulta->bindParam(4, $this->telefono);
            $consulta->bindParam(5, $this->email);
            $consulta->bindParam(6, $this->activo);
            $consulta->bindParam(7, $this->dni);
            $consulta->bindParam(8, $this->usuario);
            $consulta->bindParam(9, $this->contraseña);
            $consulta->bindParam(10, $this->id_Categoria);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE `usuario` SET `nombre` = ?,`apellido1` = ?, `apellido2` = ?,`telefono` = ?,`email` = ?,`activo` = ?,`dni` = ?,`usuario` = ?,`contraseña` = ?,`id_Categoria` = ?  WHERE idUsuario = ?');
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->apellido1);
            $consulta->bindParam(3, $this->apellido2);
            $consulta->bindParam(4, $this->telefono);
            $consulta->bindParam(5, $this->email);
            $consulta->bindParam(6, $this->activo);
            $consulta->bindParam(7, $this->dni);
            $consulta->bindParam(8, $this->usuario);
            $consulta->bindParam(9, $this->contraseña);
            $consulta->bindParam(10, $this->id_Categoria);
            $consulta->bindParam(11, $this->idUsuario);

            $consulta->execute();
        }
    }

    public function delete($id)
    {

        $consulta = $this->db->prepare('DELETE FROM usuario_asociacion WHERE id_Usuario = ?');
        $consulta->bindParam(1, $id);
        $consulta->execute();
        
        $consulta = $this->db->prepare('DELETE FROM usuario WHERE idUsuario = ?');
        $consulta->bindParam(1, $id);
        $consulta->execute();
    }
  
}
?>