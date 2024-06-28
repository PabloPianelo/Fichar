<?php

class ComprobacionModel
{
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla ITEMS
    private $idComprobacion;
    private $intentos;
    private $intentos_login;
    private $fecha_hora;
    private $activo;
    private $login_Comprobacion ;
    private $intnetos_Comprobacion ;
    private $id_Usuario  ;

    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getIdComprobacion ()
    {
        return $this->idComprobacion ;
    }
    public function setIdComprobacion  ($idComprobacion )
    {
        return $this->idComprobacion   = $idComprobacion ;
    }
    
    public function getIntentos ()
    {
        return $this->intentos ;
    }
    public function setIntentos ($intentos)
    {
        return $this->intentos  = $intentos ;
    }

    public function getIntentos_login ()
    {
        return $this->intentos_login ;
    }
    public function setIntentos_login ($intentos_login)
    {
        return $this->intentos_login  = $intentos_login ;
    }

    public function getFecha_hora()
    {
        return $this->fecha_hora;
    }

    public function setFecha_hora ($fecha_hora )
    {
        return $this->fecha_hora = $fecha_hora;
    }

    public function getActivo ()
    {
        return $this->activo ;
    }

    public function setActivo ($activo )
    {
        return $this->activo  = $activo ;
    }

    public function getLogin_Comprobacion ()
    {
        return $this->login_Comprobacion ;
    }

    public function setLogin_Comprobacion ($login_Comprobacion )
    {
        return $this->login_Comprobacion  = $login_Comprobacion ;
    }


    public function getIntnetos_Comprobacion ()
    {
        return $this->intnetos_Comprobacion ;
    }

    public function setIntnetos_Comprobacion ($intnetos_Comprobacion )
    {
        return $this->intnetos_Comprobacion  = $intnetos_Comprobacion ;
    }


    public function getId_Usuario()
    {
        return $this->id_Usuario;
    }
    public function setId_Usuario ($id_Usuario)
    {
        return $this->id_Usuario  = $id_Usuario;
    }

   


    
    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT * FROM comprobacion');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "ComprobacionModel");

        return $resultado;
    }
    public function getByIDUsuario($id_usuario)
    {
        $gsent = $this->db->prepare('SELECT idComprobacion FROM comprobacion where id_Usuario = ? and activo= 1' );
        $gsent->bindParam(1, $id_usuario);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "ComprobacionModel");
        $resultado = $gsent->fetchColumn();

        return $resultado;
    }

    
    public function numeroIntentos($id_usuario)
    {
        $gsent = $this->db->prepare('SELECT intentos,intentos_login FROM comprobacion where id_Usuario = ? and activo= 1' );
        $gsent->bindParam(1, $id_usuario );
        $gsent->execute();

        $resultado = $gsent->fetch(PDO::FETCH_ASSOC);
        return $resultado;


       
    }


    public function incrementarIntentos($id_usuario) {

        $gsent = $this->db->prepare("SELECT intentos FROM comprobacion WHERE id_usuario = ?  and activo= 1");
        $gsent->bindParam(1, $id_usuario);
        $gsent->execute();
        $resultado = $gsent->fetch(PDO::FETCH_ASSOC);
    
      
            $intentos_actuales = $resultado['intentos'];
            $intentos_nuevos = $intentos_actuales + 1;
    
            $stmt = $this->db->prepare("UPDATE  comprobacion  SET intentos = ? WHERE id_usuario = ?  and activo= 1");
            $stmt->bindParam(1, $intentos_nuevos);
            $stmt->bindParam(2, $id_usuario);
            $stmt->execute();
       

    }


    public function incrementarIntentos_login($id_usuario) {

        $gsent = $this->db->prepare("SELECT intentos_login FROM comprobacion WHERE id_usuario = ?  and activo= 1");
        $gsent->bindParam(1, $id_usuario);
        $gsent->execute();
        $resultado = $gsent->fetch(PDO::FETCH_ASSOC);
    
      
            $intentos_actuales = $resultado['intentos_login'];
            $intentos_nuevos = $intentos_actuales + 1;
    
            $stmt = $this->db->prepare("UPDATE  comprobacion  SET intentos_login = ? WHERE id_usuario = ?  and activo= 1");
            $stmt->bindParam(1, $intentos_nuevos);
            $stmt->bindParam(2, $id_usuario);
            $stmt->execute();
       

    }





    


    public function insert()
    {
       
            $consulta = $this->db->prepare('INSERT INTO comprobacion (`intentos`, `activo`,  `id_Usuario`) VALUES (?, ?, ?)');
            $consulta->bindParam(1, $this->intentos);
            $consulta->bindParam(2, $this->activo);
            $consulta->bindParam(3, $this->id_Usuario);
            $consulta->execute();
        
    }
    public function insert_login()
    {
       
            $consulta = $this->db->prepare('INSERT INTO comprobacion (`intentos_login`, `activo`,  `id_Usuario`) VALUES (?, ?, ?)');
            $consulta->bindParam(1, $this->intentos_login);
            $consulta->bindParam(2, $this->activo);
            $consulta->bindParam(3, $this->id_Usuario);
            $consulta->execute();
        
    }



    public function actualizar(){
        $consulta = $this->db->prepare('UPDATE comprobacion SET  fecha_hora = ?, activo = ? , intnetos_Comprobacion = ? WHERE idComprobacion = ?');
        $consulta->bindParam(1, $this->fecha_hora);
        $consulta->bindParam(2, $this->activo);
        $consulta->bindParam(3, $this->intnetos_Comprobacion);
        $consulta->bindParam(4, $this->idComprobacion);

        $consulta->execute();
    }

    public function actualizar_login(){
        $consulta = $this->db->prepare('UPDATE comprobacion SET  fecha_hora = ?, activo = ? , login_Comprobacion = ? , id_Usuario = ?  WHERE idComprobacion = ?');
        $consulta->bindParam(1, $this->fecha_hora);
        $consulta->bindParam(2, $this->activo);
        $consulta->bindParam(3, $this->login_Comprobacion);
        $consulta->bindParam(4, $this->id_Usuario);
        $consulta->bindParam(5, $this->idComprobacion);

        $consulta->execute();
    }

    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM  comprobacion WHERE idComprobacion =  ?');
        $consulta->bindParam(1, $this->idComprobacion);
        $consulta->execute();
    }

    public function deletebyUser($id)
    {
        $consulta = $this->db->prepare('DELETE FROM  comprobacion WHERE id_Usuario =  ? and activo= 1');
        $consulta->bindParam(1, $id);
        $consulta->execute();
    }
    
    

   
  
}
?>