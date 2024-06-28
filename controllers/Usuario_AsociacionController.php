<?php
require 'models/Usuario_AsociacionModel.php';
require 'models/UsuarioModel.php';
require 'models/AsociacionesModel.php';
require 'models/CategoriaModel.php';



class Usuario_AsociacionController
{
 
    protected $view;
    protected $usuario_asociacion;
    protected $usuario;
    protected $asociacion;
    protected $categoria;


    
    function __construct()
    {
        
        $this->view = new View();
        $this->usuario_asociacion = new Usuario_AsociacionModel();
        $this->usuario = new UsuarioModel();
        $this->asociacion = new AsociacionesModel();
        $this->categoria = new CategoriaModel();

    }


    public function listarAdmin(){

                if (!empty($_REQUEST["codigo"])) {
               
                $usuario_asociacion= $this->usuario_asociacion->getbyIDUsuarioAdmin($_REQUEST["codigo"]);


               $usuario= $this->usuario->getById($_REQUEST["codigo"]);
               $asociacion= $this->asociacion->getAll();


                $data["usuarios_asociaciones"]= $usuario_asociacion;
                $data["usuario"]= $usuario;
                $data["asociaciones"]= $asociacion;




                $this->view->show("AñadirAdmin/ListarAdminView.php",  $data);




            }


    }


    public function insertarAdmin(){

        if (!empty($_REQUEST["codigo"])) {


            

            $usuario_asociacion= $this->usuario_asociacion->getbyIDUsuarioAdmin($_REQUEST["codigo"]);

            $asociacion=$this->asociacion->getAll();

            $data["usuarios_asociaciones"]= $usuario_asociacion;
            $data["asociaciones"]=$asociacion;
            $data["codigo"]=$_REQUEST["codigo"];
            $this->view->show("CRUD/insertAdminView.php", $data);
       
      




    }

    if (isset($_REQUEST['submit'])) {

        $this->usuario_asociacion->setId_Usuario($_REQUEST["codigo"]);
        $this->usuario_asociacion->setId_Asociacion($_REQUEST["asociaciones"]);
        $this->usuario_asociacion->setAdmi(1);
        $this->usuario_asociacion->setSuperAdmi(0);
        $UsuarioNotAdmin=  $this->usuario_asociacion->NotAdmin();
        if (!empty($UsuarioNotAdmin)) {
            foreach ($UsuarioNotAdmin as $usuario) {
                $usuario->deleteAdmin();
            }
        }
        $this->usuario_asociacion->saveAdmin();
        $codigo=$_REQUEST["codigo"];
        header("Location: index.php?controlador=Usuario_Asociacion&accion=listarAdmin&codigo=" . urlencode($_REQUEST["codigo"]));
        exit;

    }




}





public function eliminarAdmin(){

      if (!empty($_REQUEST["codigo_usuario"])&&!empty($_REQUEST["codigo_asociacion"])) {
        $this->usuario_asociacion->setId_Usuario($_REQUEST["codigo_usuario"]);
        $this->usuario_asociacion->setId_Asociacion($_REQUEST["codigo_asociacion"]);
        $this->usuario_asociacion->deleteAdmin();
        header("Location: index.php?controlador=Usuario_Asociacion&accion=listarAdmin&codigo=" . urlencode($_REQUEST["codigo_usuario"]));

      }


}


public function cambiarUsuario(){
    //cambiar categoria
    if (!empty($_REQUEST["asociaciones"])&&!empty($_REQUEST["codigo"])) {
        $this->usuario_asociacion->setId_Asociacion($_REQUEST["asociaciones"]);
        $this->usuario_asociacion->setId_Usuario($_REQUEST["codigo"]);
        $this->usuario_asociacion->setAdmi(0);
        $this->usuario_asociacion->setSuperAdmi(0);
        $this->usuario_asociacion->delete();
        $this->usuario_asociacion->save();
       $categoria= $this->categoria->getByIdAsociacionLimite1($_REQUEST["asociaciones"]);
        $usuario = $this->usuario->getById($_REQUEST['codigo']);
        $usuario->setid_Categoria($categoria->getIdCategoria());
        $usuario->save();


        header("Location: index.php?controlador=Usuario_Asociacion&accion=listarAdmin&codigo=" . urlencode($_REQUEST["codigo"]));

      
    }
}

   







}
?>