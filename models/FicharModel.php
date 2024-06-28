<?php

class FicharModel
{
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla ITEMS
    private $idFichar  ;
    private $entrada_salida ;
    private $fecha_hora;
    private $id_Usuario ;

    
    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getIdFichar ()
    {
        return $this->idFichar ;
    }
    public function setIdFichar  ($idFichar )
    {
        return $this->idFichar   = $idFichar ;
    }

    public function getEntrada_salida ()
    {
        return $this->entrada_salida ;
    }
    public function setEntrada_salida ($entrada_salida)
    {
        return $this->entrada_salida  = $entrada_salida ;
    }

    public function getFecha_hora()
    {
        return $this->fecha_hora;
    }

    public function setFecha_hora ($fecha_hora )
    {
        return $this->fecha_hora = $fecha_hora;
    }

    public function getId_Usuario ()
    {
        return $this->id_Usuario ;
    }

    public function setId_Usuario ($id_Usuario )
    {
        return $this->id_Usuario  = $id_Usuario ;
    }



  
    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT * FROM fichar');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "FicharModel");

        return $resultado;
    }

    
    public function comprobarFichar($id_usuario){
        $consulta = $this->db->prepare('SELECT entrada_salida  FROM fichar WHERE id_Usuario = ?  ORDER BY STR_TO_DATE(fecha_hora, "%Y-%m-%d %H:%i:%s") DESC LIMIT 1;');
        $consulta->bindParam(1, $id_usuario );
        $consulta->execute();
        $resultados = $consulta->fetchAll(PDO::FETCH_CLASS, "FicharModel");

        if (!empty($resultados)) {
            $resultado = $resultados[0];
            $entradaSalida = $resultado->getentrada_salida();
            if ($entradaSalida) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }





 
    public function save()
            {
            if (!isset($this->idFichar)) {
            $consulta = $this->db->prepare('INSERT INTO `fichar` (`entrada_salida`, `fecha_hora`, `id_Usuario`) VALUES (?, ?, ?)');
            $consulta->bindParam(1, $this->entrada_salida);
            $consulta->bindParam(2, $this->fecha_hora);
            $consulta->bindParam(3, $this->id_Usuario);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE `fichar` SET `entrada_salida` = ?, `fecha_hora` = ?, `id_Usuario ` = ?,  WHERE `idFichar ` = ?');
            $consulta->bindParam(1, $this->entrada_salida);
            $consulta->bindParam(2, $this->fecha_hora);
            $consulta->bindParam(3, $this->id_Usuario );
            $consulta->bindParam(4, $this->idFichar );
            $consulta->execute();
        }

    }

   
  
}
?>