<?php

class Usuario_AsociacionModel
{
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla ITEMS
    private $id_Usuario ;
    private $id_Asociacion ;
    private $admi;
    private $superAdmi;

    
    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getId_Usuario()
    {
        return $this->id_Usuario;
    }
    public function setId_Usuario ($id_Usuario)
    {
        return $this->id_Usuario  = $id_Usuario;
    }

    public function getId_Asociacion ()
    {
        return $this->id_Asociacion ;
    }
    public function setId_Asociacion ($id_Asociacion)
    {
        return $this->id_Asociacion  = $id_Asociacion ;
    }

    public function getAdmi()
    {
        return $this->admi;
    }

    public function setAdmi ($admi )
    {
        return $this->admi = $admi;
    }

    public function getSuperAdmi()
    {
        return $this->superAdmi;
    }

    public function setSuperAdmi ($superAdmi)
    {
        return $this->superAdmi = $superAdmi;
    }



   


   


    // Método para obtener todos los registros de la tabla ITEMS
    // Devuelve un array de objetos de la clase ItemModel
    public function getAll()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('SELECT * FROM usuario_asociacion');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario_AsociacionModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }



    public function getbyIDUsuario($idUsuario){
        
        $consulta = $this->db->prepare('SELECT * FROM usuario_asociacion where id_Usuario = ?' );
        $consulta->bindParam(1,$idUsuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario_AsociacionModel");

        return $resultado;
    }



    public function getbyIDUsuarioAdmin($idUsuario){
        
        $consulta = $this->db->prepare('SELECT * FROM usuario_asociacion where id_Usuario = ? and admi=1' );
        $consulta->bindParam(1,$idUsuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario_AsociacionModel");

        return $resultado;
    }


    public function getRol($usuario)
    {
        $consultaUsuario = $this->db->prepare('SELECT idUsuario FROM usuario where usuario = ?' );
        $consultaUsuario->bindParam(1, $usuario );
        $consultaUsuario->execute();
        $idUsuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);



        $consultaUS_AS = $this->db->prepare('SELECT * FROM usuario_asociacion where id_Usuario = ?' );
        $consultaUS_AS->bindParam(1, $idUsuario['idUsuario'] );
        $consultaUS_AS->execute();
        $resultado = $consultaUS_AS->fetchAll(PDO::FETCH_ASSOC);


        foreach ($resultado as $result ) {
            
            if ($result["admi"]==1) {
                return "admin";
            }elseif ($result["superAdmi"]==1) {
                return "superadmin";
            }else{
                return "usuario";
            }
        }
       // return $resultado;



        
    }


    public function getUsuario($usuario)
    {
        $consultaUsuario = $this->db->prepare('SELECT idUsuario FROM usuario where usuario = ?' );
        $consultaUsuario->bindParam(1, $usuario );
        $consultaUsuario->execute();
        $idUsuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);



        $consultaUS_AS = $this->db->prepare('SELECT * FROM usuario_asociacion where id_Usuario = ?' );
        $consultaUS_AS->bindParam(1, $idUsuario['idUsuario'] );
        $consultaUS_AS->execute();
        $resultado = $consultaUS_AS->fetchAll(PDO::FETCH_ASSOC);


        return $resultado;



        
    }

    public function NotAdmin() {

        $consulta = $this->db->prepare('SELECT * FROM usuario_asociacion WHERE id_Usuario = ? AND admi = 0');
        $consulta->bindParam(1, $this->getId_Usuario());
        $consulta->execute();
        $usuariosNoAdmin = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario_AsociacionModel");
        return $usuariosNoAdmin;

    }


        public function getUsuarioNotAdmin($usuario) {
            // Obtener todos los ID de asociación del usuario
            $consultaAsociacion = $this->db->prepare('SELECT id_Asociacion FROM usuario_asociacion WHERE id_Usuario = ?');
            $consultaAsociacion->bindParam(1, $usuario);
            $consultaAsociacion->execute();
            $idAsociaciones = $consultaAsociacion->fetchAll(PDO::FETCH_COLUMN);
        
            // Obtener los ID de usuario que no son administradores de las asociaciones encontradas
            $usuariosNoAdmin = [];
            foreach ($idAsociaciones as $idAsociacion) {
                $consultaUsuario = $this->db->prepare('SELECT id_Usuario FROM usuario_asociacion WHERE id_Asociacion = ? AND admi = 0 AND superAdmi = 0');
                $consultaUsuario->bindParam(1, $idAsociacion);
                $consultaUsuario->execute();
                $usuariosNoAdminEnAsociacion = $consultaUsuario->fetchAll(PDO::FETCH_COLUMN);
                $usuariosNoAdmin = array_merge($usuariosNoAdmin, $usuariosNoAdminEnAsociacion);
            }
        
            // Eliminar duplicados (si los hay)
            $usuariosNoAdmin = array_unique($usuariosNoAdmin);
        
            return $usuariosNoAdmin;
        }

    
    
        public function saveAdmin() {
            $consultaUsuario = $this->db->prepare('SELECT admi FROM usuario_asociacion WHERE id_Usuario = ? AND id_Asociacion = ?');
            $consultaUsuario->bindParam(1, $this->id_Usuario);
            $consultaUsuario->bindParam(2, $this->id_Asociacion);
            $consultaUsuario->execute();
            $admin = $consultaUsuario->fetch(PDO::FETCH_ASSOC);
        
            if ($admin) {
                if ($admin['admi'] == 0) {
                    $consultaUpdate = $this->db->prepare('UPDATE usuario_asociacion SET admi = 1 WHERE id_Usuario = ? AND id_Asociacion = ?');
                    $consultaUpdate->bindParam(1, $this->id_Usuario);
                    $consultaUpdate->bindParam(2, $this->id_Asociacion);
                    $consultaUpdate->execute();
                }
            } else {
                $consultaInsert = $this->db->prepare('INSERT INTO usuario_asociacion (id_Usuario, id_Asociacion, admi, superAdmi) VALUES (?, ?, ?, ?)');
                $consultaInsert->bindParam(1, $this->id_Usuario);
                $consultaInsert->bindParam(2, $this->id_Asociacion);
                $consultaInsert->bindParam(3, $this->admi);
                $consultaInsert->bindParam(4, $this->superAdmi);
                $consultaInsert->execute();
            }
        }
        


    public function deleteAdmin(){


        $consulta = $this->db->prepare('DELETE FROM usuario_asociacion WHERE id_Usuario = ? AND id_Asociacion = ?');
        $consulta->bindParam(1, $this->id_Usuario);
        $consulta->bindParam(2, $this->id_Asociacion);
        $consulta->execute();

    }


    public function save()
            {
            $consulta = $this->db->prepare('INSERT INTO `usuario_asociacion` (`id_Usuario`, `id_Asociacion`, `admi`, `superAdmi`) VALUES (?, ?, ?, ?)');
            $consulta->bindParam(1, $this->id_Usuario);
            $consulta->bindParam(2, $this->id_Asociacion);
            $consulta->bindParam(3, $this->admi);
            $consulta->bindParam(4, $this->superAdmi);
            $consulta->execute();
      

    }

    public function delete(){

    $consulta = $this->db->prepare('DELETE FROM usuario_asociacion WHERE id_Usuario = ?');
    $consulta->bindParam(1, $this->id_Usuario);
    $consulta->execute();
   

    }

   
  
}
?>