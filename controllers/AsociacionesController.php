<?php
require 'models/Usuario_AsociacionModel.php';
require 'models/UsuarioModel.php';
require 'models/AsociacionesModel.php';
require 'models/CategoriaModel.php';
require 'models/ParametrosModel.php';

class AsociacionesController
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

    public function ListarSuperAdminAsociaciones(){

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



        $this->view->show("SuperAdminAsociacionesView.php",  $data);

    }
   





    


    public function editarAsociacion(){
       

    $errores = array();
    
    if (isset($_REQUEST['submit'])) {
        if (!isset($_REQUEST['nombre']) || empty($_REQUEST['nombre']))
        $errores['nombre'] = "* Item: Error";

    if (empty($errores)) {
        // Cambia el valor del item y lo guarda en BD
        $AsociacionEdit = $this->asociacion->getById($_REQUEST['codigo']);
        $AsociacionEdit->setNombre($_REQUEST['nombre']);
        if(isset($_FILES['nueva_img']) && !empty($_FILES['nueva_img']['tmp_name'])) {
            $AsociacionEdit->setImg(file_get_contents($_FILES['nueva_img']['tmp_name']));
        }else{
             $AsociacionEdit->setImg($AsociacionEdit->getImg());
        }        
        
        $AsociacionEdit->save();

        // Reenvía a la aplicación a la lista de items
        header("Location: index.php?controlador=Asociaciones&accion=ListarSuperAdminAsociaciones");
    }
    } else{
    $AsociacionEdit=$this->asociacion->getById($_REQUEST['codigo']);

    $data["asociacion"]=$AsociacionEdit;

            if ($AsociacionEdit != false)
            $this->view->show("CRUD/editarAsociacionView.php", $data);
        else
            $this->view->show("errorView.php", array("error" => "No existe codigo", "enlace" => "index.php?controlador=Asociaciones&accion=ListarSuperAdminAsociaciones"));

            } 
        }



                
        public function nuevaAsociacion(){
            $errores = array();
            if (isset($_POST['submit'])) {
                if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
                    $errores['nombre'] = "* Equipo: Hay que indicar un usuario de equipo";
                    $this->view->show("ErrorView.php", array('errores' => $errores));
                }
                if (empty($errores)) {
                    $this->asociacion->setNombre($_POST['nombre']);
                    
                    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['tmp_name'])) {
                        $this->asociacion->setImg(file_get_contents($_FILES['imagen']['tmp_name']));
                    }else{
                        $this->asociacion->setImg(null);
                    }  
                    
                    $this->asociacion->save();
                    $idasociacion= $this->asociacion->getByNombre($_POST['nombre']);
                    $this->categoria->setNombre("NULL");
                    $this->categoria->setId_Asociacion($idasociacion->getIdAsociacion());
                    $this->categoria->save();



                    header("Location: index.php?controlador=Asociaciones&accion=ListarSuperAdminAsociaciones");
                }
            }
            
           
            $this->view->show("CRUD/insertAsociacionView.php");
            
        }
  


        public function  eliminarAsociacion(){

            if (isset($_REQUEST['codigo'])) {
                $this->asociacion->delete($_REQUEST['codigo']);
                header("Location: index.php?controlador=Asociaciones&accion=ListarSuperAdminAsociaciones");
            }
        }


       
   

}


     



?>