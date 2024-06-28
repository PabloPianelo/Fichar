<?php
require 'models/Usuario_AsociacionModel.php';
require 'models/UsuarioModel.php';
require 'models/AsociacionesModel.php';
require 'models/CategoriaModel.php';
require 'models/ParametrosModel.php';
require 'models/ComprobacionModel.php';

class SuperAdminController
{
 
    protected $view;
    protected $usuario_asociacion;
    protected $usuario;
    protected $asociacion;
    protected $categoria;
    protected $parametro;
    protected $comprobacion;


    
    function __construct()
    {
        
        $this->view = new View();
        $this->usuario_asociacion = new Usuario_AsociacionModel();
        $this->usuario = new UsuarioModel();
        $this->asociacion = new AsociacionesModel();
        $this->categoria = new CategoriaModel();
        $this->parametro = new ParametrosModel();
        $this->comprobacion = new ComprobacionModel();
    }


    public function ListarSuperAdmin(){

        if (isset($_GET["usuario_superadmin"])) {
            $_SESSION['usuario_superadmin']="superadmin";
          }

        $usuarios=$this->usuario->getAll();
        $asociaciones=$this->asociacion->getAll();
        $categorias=$this->categoria->getAll();
        $parametros=$this->parametro->getAll();
        $usuario_asociaciones=$this->usuario_asociacion->getAll();
        $comprobaciones=$this->comprobacion->getAll();


        $data["usuarios"]= $usuarios;
        $data["asociaciones"]= $asociaciones;
        $data["categorias"]= $categorias;
        $data["parametros"]= $parametros;
        $data["usuario_asociaciones"]= $usuario_asociaciones;
        $data["comprobaciones"]= $comprobaciones;



        $this->view->show("SuperAdminView.php",  $data);

    }
   



}


     



?>