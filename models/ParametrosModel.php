<?php

class ParametrosModel
{
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla ITEMS
    private $intentos ;
    private $tiempo ;
    private $intentos_login;

    
    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getIntentos()
    {
        return $this->intentos;
    }
    public function setIntentos ($intentos)
    {
        return $this->intentos  = $intentos;
    }

    public function getIntentos_login ()
    {
        return $this->intentos_login ;
    }
    public function setIntentos_login ($intentos_login)
    {
        return $this->intentos_login  = $intentos_login ;
    }

    public function getTiempo()
    {
        return $this->tiempo;
    }

    public function setTiempo ($tiempo )
    {
        return $this->tiempo = $tiempo;
    }

   


   

    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT * FROM parametros');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "ParametrosModel");

        return $resultado;
    }

    






   
    public function save()
            {
           
            $consulta = $this->db->prepare('UPDATE `parametros` SET `intentos` = ?, `tiempo` = ?, `intentos_login` = ? LIMIT 1');
            $consulta->bindParam(1, $this->intentos);
            $consulta->bindParam(2, $this->tiempo);
            $consulta->bindParam(3, $this->intentos_login);
            $consulta->execute();
        

    }

   
  
}
?>