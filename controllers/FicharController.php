<?php
require 'models/Usuario_AsociacionModel.php';
require 'models/UsuarioModel.php';
require 'models/AsociacionesModel.php';
require 'models/FicharModel.php';


class FicharController
{
 
    protected $view;
    protected $usuario_asociacion;
    protected $usuario;
    protected $asociacion;
    protected $fichar;

    
    function __construct()
    {
        
        $this->view = new View();
        $this->usuario_asociacion = new Usuario_AsociacionModel();
        $this->usuario = new UsuarioModel();
        $this->asociacion = new AsociacionesModel();
        $this->fichar = new FicharModel();
    }




    

    public function fichar(){

        if (isset($_GET["usuario"])) {
            $_SESSION['usuario']="usuario";
          }

        $id_usuario = $_GET['id_usuario'];
        $id_asociacio = $_GET['id_asociacion'];

        $_SESSION['id_usuario']= $id_usuario;



        $comprobar= $this->fichar->comprobarFichar($id_usuario);

        $data['comprobar'] = $comprobar;

 
        // $data['username'] = $username;

       
        $imagenAsociacion =  $this->asociacion->getByImagen($id_asociacio);
      
        $data['imagenAsociacion'] = $imagenAsociacion;
        $this->view->show("ficharView.php",  $data);


    }


    
    public function insertarFicha(){
       
        $id_usuario =  $_SESSION['id_usuario'];

        if (isset($_REQUEST['boton']) ) {
              
            if ($_REQUEST['entrada_salida'] == 'Entrada') {
                $this->fichar->setEntrada_salida(true);
                
            }else{
                
                $this->fichar->setEntrada_salida(false);
            }
           $fecha_actual = date('Y-m-d H:i:s', time());
            $this->fichar->setFecha_hora($fecha_actual);
            $this->fichar->setId_Usuario($id_usuario);
            $this->fichar->save();

            header("Location: index.php?controlador=login&accion=logout");
        }


    }
       

}



?>