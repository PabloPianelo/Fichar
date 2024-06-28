<?php

class CategoriaModel
{
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla ITEMS
    private $idCategoria   ;
    private $nombre;
    private $id_Asociacion ;


    
    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getIdCategoria  ()
    {
        return $this->idCategoria;
    }
    public function setIdCategoria   ($idCategoria  )
    {
        return $this->idCategoria    = $idCategoria  ;
    }

    public function getNombre ()
    {
        return $this->nombre ;
    }
    public function setNombre ($nombre)
    {
        return $this->nombre  = $nombre ;
    }


    public function getId_Asociacion ()
    {
        return $this->id_Asociacion ;
    }

    public function setId_Asociacion ($id_Asociacion )
    {
        return $this->id_Asociacion  = $id_Asociacion ;
    }



   


   


    public function getAll()
    {
        
        $consulta = $this->db->prepare('SELECT * FROM categoria');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "CategoriaModel");

       
        return $resultado;
    }

    public function getById($codigo)
    {
        $gsent = $this->db->prepare('SELECT * FROM categoria where idCategoria = ?');
        $gsent->bindParam(1, $codigo );
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "CategoriaModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }


    public function getByIdAsociacion($codigo){
        $gsent = $this->db->prepare('SELECT * FROM categoria where id_Asociacion = ?');
        $gsent->bindParam(1, $codigo );
        $gsent->execute();

        $resultado = $gsent->fetchAll(PDO::FETCH_CLASS, "CategoriaModel");


        return $resultado;
    }


    public function getByIdAsociacionLimite1($codigo) {
        $gsent = $this->db->prepare('SELECT * FROM categoria WHERE id_Asociacion = ? LIMIT 1');
        $gsent->bindParam(1, $codigo);
        $gsent->execute();
    
        $gsent->setFetchMode(PDO::FETCH_CLASS, "CategoriaModel");
        $resultado = $gsent->fetch();
        return $resultado;
    }
   


   



    public function save()
            {
            if (!isset($this->idCategoria)) {
            $consulta = $this->db->prepare('INSERT INTO `categoria` (`nombre`, `id_Asociacion`) VALUES (?, ?)');
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->id_Asociacion);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE `categoria` SET `nombre` = ?, `id_Asociacion` = ? WHERE `idCategoria` = ?');
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->id_Asociacion);
            $consulta->bindParam(3, $this->idCategoria);
            $consulta->execute();
        }

    }





    public function delete()
    {
        // Obtener los usuarios asociados a la categoría que se va a eliminar
        $consulta = $this->db->prepare('SELECT idUsuario FROM usuario WHERE id_Categoria = ?');
        $consulta->bindParam(1, $this->idCategoria);
        $consulta->execute();
        $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
        // Si hay usuarios asociados a la categoría
        if (count($usuarios) > 0) {
            // Obtener la asociación de la categoría que se va a eliminar
            $consulta = $this->db->prepare('SELECT id_Asociacion FROM categoria WHERE idCategoria = ?');
            $consulta->bindParam(1, $this->idCategoria);
            $consulta->execute();
            $asociacion = $consulta->fetch(PDO::FETCH_ASSOC);
    
            if ($asociacion) {
                // Obtener la categoría "NULL" de la misma asociación
                $consulta = $this->db->prepare('SELECT idCategoria FROM categoria WHERE nombre = "NULL" AND id_Asociacion = ?');
                $consulta->bindParam(1, $asociacion['id_Asociacion']);
                $consulta->execute();
                $categoria = $consulta->fetch(PDO::FETCH_ASSOC);
    
                if ($categoria) {
                    // Actualizar la categoría asociada a "NULL" para los usuarios
                    foreach ($usuarios as $usuario) {
                        $consulta = $this->db->prepare('UPDATE `usuario` SET `id_Categoria` = ? WHERE `idUsuario` = ?');
                        $consulta->bindParam(1, $categoria['idCategoria']);
                        $consulta->bindParam(2, $usuario['idUsuario']);
                        $consulta->execute();
                    }
                } else {
                    throw new Exception("Categoría 'NULL' no encontrada para la misma asociación.");
                }
            } else {
                throw new Exception("Asociación no encontrada para la categoría a eliminar.");
            }
        }
    
        // Eliminar la categoría original
        $consulta = $this->db->prepare('DELETE FROM `categoria` WHERE `idCategoria` = ?');
        $consulta->bindParam(1, $this->idCategoria);
        $consulta->execute();
    }
  
}
?>