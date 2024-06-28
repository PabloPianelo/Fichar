<?php
require 'models/Usuario_AsociacionModel.php';
require 'models/UsuarioModel.php';
require 'models/AsociacionesModel.php';
require 'models/CategoriaModel.php';
require 'models/ParametrosModel.php';

class ParametrosController
{
 
    protected $view;
    protected $usuario_asociacion;
    protected $usuario;
    protected $asociacion;
    protected $categoria;
    protected $parametro;


    
    function __construct()
    {
        
        $this->view = new View();
        $this->usuario_asociacion = new Usuario_AsociacionModel();
        $this->usuario = new UsuarioModel();
        $this->asociacion = new AsociacionesModel();
        $this->categoria = new CategoriaModel();
        $this->parametro = new ParametrosModel();

    }


   


        public function editarParametros() {
            $errores = array();
    
            if (isset($_REQUEST['submit'])) {
           
               
                    // Cambia el valor del item y lo guarda en BD
                    $ParametrosEdit = new ParametrosModel();
                    $ParametrosEdit->setIntentos($_REQUEST['intentos']);
                    $ParametrosEdit->setTiempo($_REQUEST['tiempo']);
                    $ParametrosEdit->setIntentos_login($_REQUEST['intentos_login']);
                    $ParametrosEdit->save();
        
                    // Reenvía a la aplicación a la lista de items
                    header("Location: index.php?controlador=SuperAdmin&accion=ListarSuperAdmin");
                    exit;
                
            } else {
                $ParametrosEdit = new ParametrosModel();
                $data["parametros"] = $ParametrosEdit->getAll()[0];
        
                if ($ParametrosEdit != false)
                    $this->view->show("CRUD/editarParametrosView.php", $data);
                else
                    $this->view->show("errorView.php", array("error" => "Error al obtener parámetros", "enlace" => "index.php?controlador=SuperAdmin&accion=ListarSuperAdmin"));
            }
        }





       
   

}


     



?>