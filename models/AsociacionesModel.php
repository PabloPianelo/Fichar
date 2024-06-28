<?php

class AsociacionesModel
{
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla ITEMS
    private $idAsociacion    ;
    private $nombre;
    private $img ;


    
    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getIdAsociacion()
    {
        return $this->idAsociacion;
    }
    public function setIdAsociacion   ($idAsociacion   )
    {
        return $this->idAsociacion     = $idAsociacion   ;
    }

    public function getNombre ()
    {
        return $this->nombre ;
    }
    public function setNombre ($nombre)
    {
        return $this->nombre  = $nombre ;
    }


    public function getImg  ()
    {
        return $this->img ;
    }

    public function setImg  ($img )
    {
        return $this->img  = $img ;
    }



   


   


   
    public function getAll()
    {
       
        $consulta = $this->db->prepare('SELECT * FROM asociaciones');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "AsociacionesModel");

        
        return $resultado;
    }


    public function getById($codigo)
    {
        $gsent = $this->db->prepare('SELECT * FROM asociaciones where idAsociacion = ?');
        $gsent->bindParam(1, $codigo );
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "AsociacionesModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }

    public function getByNombre($nombre)
    {
        $gsent = $this->db->prepare('SELECT * FROM asociaciones where nombre = ?');
        $gsent->bindParam(1, $nombre );
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "AsociacionesModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }




    

    public function getByImagen($codigo)
    {
        $gsent = $this->db->prepare('SELECT img FROM asociaciones where idAsociacion = ?');
        $gsent->bindParam(1, $codigo);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "AsociacionesModel");
        $resultado = $gsent->fetchColumn();

        return $resultado;
    }




   


  
    public function save()
            {
            if (!isset($this->idAsociacion )) {
            $consulta = $this->db->prepare('INSERT INTO `asociaciones` (`nombre`, `img`) VALUES (?, ?)');
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->img);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE `asociaciones` SET `nombre` = ?, `img` = ? WHERE `idAsociacion` = ?');
            $consulta->bindParam(1, $this->nombre);
            $consulta->bindParam(2, $this->img);
            $consulta->bindParam(3, $this->idAsociacion);
            $consulta->execute();
        }

    }

    public function delete($id){

        $consulta = $this->db->prepare('DELETE FROM `categoria` WHERE `id_Asociacion`=? ');
        $consulta->bindParam(1, $id);
        $consulta->execute();

        $consulta = $this->db->prepare('DELETE FROM `usuario_asociacion` WHERE `id_Asociacion`=?');
        $consulta->bindParam(1, $id);
        $consulta->execute();


        $consulta = $this->db->prepare('DELETE FROM `asociaciones` WHERE idAsociacion=?');
        $consulta->bindParam(1, $id);
        $consulta->execute();

        


    }


   
  
}
?>