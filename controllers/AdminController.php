<?php
require 'models/Usuario_AsociacionModel.php';
require 'models/UsuarioModel.php';
require 'models/AsociacionesModel.php';
require 'models/CategoriaModel.php';
require 'models/FicharModel.php';



class AdminController
{
 
    protected $view;
    protected $usuario_asociacion;
    protected $usuario;
    protected $asociacion;
    protected $categoria;
    protected $fichar;


    
    function __construct()
    {
        
        $this->view = new View();
        $this->usuario_asociacion = new Usuario_AsociacionModel();
        $this->usuario = new UsuarioModel();
        $this->asociacion = new AsociacionesModel();
        $this->categoria = new CategoriaModel();
        $this->fichar = new FicharModel();


    }



    public function listar(){

        if (isset($_GET["usuario_admin"])) {
        $_SESSION['usuario_admin']="admin";
      }
       


        $id_usuario = $_GET['id_admin'];

        $_SESSION['id_admin']= $id_usuario;
    
        // Obtener todas las asociaciones del usuario administrador
        $usuarios_asociaciones = $this->usuario_asociacion->getbyIDUsuario($id_usuario);
        $usuarios_asociaciones_notAdmins = $this->usuario_asociacion->getUsuarioNotAdmin($id_usuario);
        $fichar= $this->fichar->getAll();


        // Obtener todas las asociaciones y usuarios
        $asociaciones = $this->asociacion->getAll();
        $usuarios = $this->usuario->getAll();
        $categorias = $this->categoria->getAll();
        $usuario_asociacion= $this->usuario_asociacion->getAll();
    
        // Filtrar los usuarios para mostrar solo los que no son administradores de las asociaciones del usuario administrador
        $usuarios_no_admin = [];
        foreach ($usuarios as $usuario) {
            $es_admin = false;
            foreach ($usuarios_asociaciones_notAdmins as $usuarios_asociaciones_notAdmin) {
                if ($usuarios_asociaciones_notAdmin == $usuario->getIdUsuario() ) {
                    $es_admin = true;
                    break;
                }
            }
            if ($es_admin) {
                $usuarios_no_admin[] = $usuario;
            }
        }
        $data['allUsuario_asociaciones'] = $usuario_asociacion;
        $data['usuarios_asociaciones'] = $usuarios_asociaciones;
        $data['asociaciones'] = $asociaciones;
        $data['usuarios'] = $usuarios_no_admin; // Mostrar solo los usuarios que no son administradores
        $data['categorias'] = $categorias;
        $data['fichajes'] = $fichar;

    
        $this->view->show("AdminView.php", $data);
    }






    public function cambiarActivo(){
    
        $id_usuario = $_GET['codigo'];
        $usuarios = $this->usuario->cambiarEstado( $id_usuario);
        $id_admin=$_SESSION['id_admin'];
    
        header("Location: index.php?controlador=Admin&accion=listar&id_admin=". $id_admin);

    }



   

    




    












}
?>