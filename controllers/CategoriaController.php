<?php
require 'models/Usuario_AsociacionModel.php';
require 'models/UsuarioModel.php';
require 'models/AsociacionesModel.php';
require 'models/CategoriaModel.php';
require 'models/ParametrosModel.php';

class CategoriaController
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


    public function ListarSuperAdminCategoria(){

        if (isset($_GET["usuario_superadmin"])) {
            $_SESSION['usuario_superadmin']="superadmin";
          }

        $usuarios=$this->usuario->getAll();
        $asociaciones=$this->asociacion->getAll();
        $categorias=$this->categoria->getAll();
        $parametros=$this->parametro->getAll();
        $usuario_asociaciones=$this->usuario_asociacion->getAll();


        $data["usuarios"]= $usuarios;
        $data["asociaciones"]= $asociaciones;
        $data["categorias"]= $categorias;
        $data["parametros"]= $parametros;
        $data["usuario_asociaciones"]= $usuario_asociaciones;



        $this->view->show("SuperAdminCategoriaView.php",  $data);

    }


    public function editarCategoria(){
       

        $errores = array();
        
        if (isset($_REQUEST['submit'])) {
            if (!isset($_REQUEST['nombre']) || empty($_REQUEST['nombre']))
            $errores['nombre'] = "* Item: Error";

        if (empty($errores)) {
            // Cambia el valor del item y lo guarda en BD
            $CategoriaEdit = $this->categoria->getById($_REQUEST['codigo']);
            $CategoriaEdit->setNombre($_REQUEST['nombre']);
            $CategoriaEdit->setId_Asociacion($_REQUEST['asociaciones']);
            $CategoriaEdit->save();

            // Reenvía a la aplicación a la lista de items
            header("Location: index.php?controlador=Categoria&accion=ListarSuperAdminCategoria");
        }
        } else{
        $CategoriEdit=$this->categoria->getById($_REQUEST['codigo']);
    
        $data["categoria"]=$CategoriEdit;

        $asociacion=$this->asociacion->getAll();
    
        $data["asociaciones"]=$asociacion;

        if ($CategoriEdit != false)
        $this->view->show("CRUD/editarCategoriaView.php", $data);
    else
        $this->view->show("errorView.php", array("error" => "No existe codigo", "enlace" => "index.php?controlador=Categoria&accion=ListarSuperAdminCategoria"));

        } 
}

        public function nuevaCategoria(){

  
    $errores = array();
    if (isset($_REQUEST['submit'])) {
        if (!isset($_REQUEST['nombre']) || empty($_REQUEST['nombre'])){
            $errores['nombre'] = "* Equipo: Hay que indicar un usuario de equipo";
            $this->view->show("ErrorView.php", array('errores' => $errores));
        }
        if (empty($errores)) {
            $this->categoria->setNombre($_REQUEST['nombre']);
            $this->categoria->setId_Asociacion($_REQUEST['asociaciones']);
            $this->categoria->save();
            header("Location: index.php?controlador=Categoria&accion=ListarSuperAdminCategoria");
        }
    }
    $asociacion=$this->asociacion->getAll();
    
    $data["asociaciones"]=$asociacion;
    $this->view->show("CRUD/insertCategoriaView.php", $data);

}


public function eliminarCategoria(){
    
    if(isset($_GET['codigo'])){
        $idCategoria = $_GET['codigo'];

        $categoriaModel = new CategoriaModel();

        $categoriaModel->setIdCategoria($idCategoria);

        $categoriaModel->delete();

        header('Location: index.php?controlador=Categoria&accion=ListarSuperAdminCategoria');
        exit();
    } else {
        echo "ID de categoría no proporcionado";
    }
}

   

}


     



?>