<?php
require 'models/Usuario_AsociacionModel.php';
require 'models/UsuarioModel.php';
require 'models/AsociacionesModel.php';
require 'models/CategoriaModel.php';
require 'models/ParametrosModel.php';

class UsuarioController
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


    public function cifrar_contrasena($contraseña){

        $password_encrypt = sha1($contraseña);
        return $password_encrypt;
    }

    

    public function ListarSuperAdminUsuario(){

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



        $this->view->show("SuperAdminUsuarioView.php",  $data);

    }

        public function nuevoUsuarios(){

        
            $errores = array();
            if (isset($_REQUEST['submit'])) {
                if (!isset($_REQUEST['email']) || empty($_REQUEST['email'])) {
                    $errores['email'] = "* Equipo: Hay que indicar un email de usuario";
                    $this->view->show("ErrorView.php", array('errores' => $errores));
                    return; 
                }
                if (empty($errores)) {

                    $this->usuario->setNombre($_REQUEST['nombre']);
                    $this->usuario->setApellido1($_REQUEST['apellido1']);
                    $this->usuario->setApellido2($_REQUEST['apellido2']);
                    $this->usuario->setTelefono($_REQUEST['telefono']);
                    $this->usuario->setDni($_REQUEST['dni']);
                    $this->usuario->setactivo(1);
                    $this->usuario->setEmail($_REQUEST['email']);
                    $this->usuario->setUsuario($_REQUEST['usuario']);
                    $cifrado = $this->cifrar_contrasena($_REQUEST['contraseña']);
                    $this->usuario->setcontraseña($cifrado);
                    $this->usuario->setid_categoria($_REQUEST['id_Categoria']);
                    $this->usuario->save();

                    $idusuario=$this->usuario->getByEmail($_REQUEST['email']);
                    $this->usuario_asociacion->setId_Usuario($idusuario);
                    $this->usuario_asociacion->setId_Asociacion($_REQUEST['asociacion']);
                    $this->usuario_asociacion->setSuperAdmi(0);
                    $this->usuario_asociacion->setAdmi(0);
                    $this->usuario_asociacion->save();



                    header("Location: index.php?controlador=Usuario&accion=ListarSuperAdminUsuario");
                    exit();
                }
            }
        
            $listaAsociacion =  $this->asociacion->getAll();
            $listaCategoria =  $this->categoria->getAll();
            $data['asociaciones'] = $listaAsociacion;
            $data['categorias'] = $listaCategoria;
            $this->view->show("CRUD/insertUsuarioView.php", $data);
        
        }


        public function editarUsuario(){
            $errores = array();
            $id_admin=$_SESSION['id_admin'];
    
            
            if (isset($_REQUEST['submit'])) {
                if (!isset($_REQUEST['nombre']) || empty($_REQUEST['nombre'])) {
                    $errores['nombre'] = "* Nombre: Campo requerido";
                }
        
                if (empty($errores)) {
                    $usuarioEdit = $this->usuario->getById($_REQUEST['idUsuario']);
                    $usuarioEdit->setNombre($_REQUEST['nombre']);
                    $usuarioEdit->setApellido1($_REQUEST['apellido1']);
                    $usuarioEdit->setApellido2($_REQUEST['apellido2']);
                    $usuarioEdit->setTelefono($_REQUEST['telefono']);
                    $usuarioEdit->setEmail($_REQUEST['email']);
                    $usuarioEdit->setactivo($usuarioEdit->getactivo());
                    $usuarioEdit->setDni($_REQUEST['dni']);
                    $cifrado = $this->cifrar_contrasena($_REQUEST['contraseña']);
                    $usuarioEdit->setcontraseña($cifrado);
                    $usuarioEdit->setUsuario($_REQUEST['usuario']);
                    $usuarioEdit->setid_Categoria($_REQUEST['categoria']);
                    $usuarioEdit->save();
        
                    header("Location: index.php?controlador=Admin&accion=listar&id_admin=". $id_admin);
                    exit();
                }
    
                            
            } else {
                $usuarioEdit = $this->usuario->getById($_REQUEST['codigo']);
                $categoriaEdit = $this->categoria->getById($usuarioEdit->getid_Categoria());
                $categoria = $this->categoria->getByIdAsociacion($categoriaEdit->getId_Asociacion());
    
    
                if ($usuarioEdit != false) {
                    $data["usuario"] = $usuarioEdit;
                    $data["categorias"] = $categoria;
                    $data["id_admin"]=$id_admin;
                    
                    $this->view->show("CRUD/editarUsuarioView.php", $data);
                } else {
                    $this->view->show("errorView.php", array("error" => "El usuario no existe", "enlace" => "index.php?controlador=Admin&accion=listar&id_admin=". $id_admin));
                }
            }
        }
       
   
        public function nuevoUsuarioAdmin(){

            $id_admin=$_SESSION['id_admin'];

            $errores = array();
            if (isset($_REQUEST['submit'])) {
                if (!isset($_REQUEST['email']) || empty($_REQUEST['email'])) {
                    $errores['email'] = "* Equipo: Hay que indicar un email de usuario";
                    $this->view->show("ErrorView.php", array('errores' => $errores));
                    return; 
                }
                if (empty($errores)) {

                    $this->usuario->setNombre($_REQUEST['nombre']);
                    $this->usuario->setApellido1($_REQUEST['apellido1']);
                    $this->usuario->setApellido2($_REQUEST['apellido2']);
                    $this->usuario->setTelefono($_REQUEST['telefono']);
                    $this->usuario->setDni($_REQUEST['dni']);
                    $this->usuario->setactivo(1);
                    $this->usuario->setEmail($_REQUEST['email']);
                    $this->usuario->setUsuario($_REQUEST['usuario']);
                    $cifrado = $this->cifrar_contrasena($_REQUEST['contraseña']);
                    $this->usuario->setcontraseña($cifrado);
                    $this->usuario->setid_categoria($_REQUEST['id_Categoria']);
                    $this->usuario->save();

                    $idusuario=$this->usuario->getByEmail($_REQUEST['email']);
                    $this->usuario_asociacion->setId_Usuario($idusuario);
                    $this->usuario_asociacion->setId_Asociacion($_REQUEST['asociacion']);
                    $this->usuario_asociacion->setSuperAdmi(0);
                    $this->usuario_asociacion->setAdmi(0);
                    $this->usuario_asociacion->save();



                    header("Location: index.php?controlador=Admin&accion=listar&id_admin=". $id_admin);
                    exit();
                }
            }
          

            $usuarios_asociaciones = $this->usuario_asociacion->getbyIDUsuario($id_admin);
            $listaAsociacion =  $this->asociacion->getAll();
            $listaCategoria =  $this->categoria->getAll();
            $data['asociaciones'] = $listaAsociacion;
            $data['categorias'] = $listaCategoria;
            $data['usuario_asociaciones'] = $usuarios_asociaciones;
            $data["id_admin"]=$id_admin;
            $this->view->show("CRUD/insertUsuarioAdminView.php", $data);
        
        }


        public function cambiarAsociacion() {
            $id_admin = $_SESSION['id_admin'];
            $errores = array();
            
            if (isset($_REQUEST['submit'])) {
                $idusuario = $this->usuario->getById($_REQUEST['idUsuario']);
                $idUsuarioValue = $idusuario->getIdUsuario(); 
                
                $this->usuario_asociacion->setId_Usuario($idUsuarioValue);
                $this->usuario_asociacion->delete();

                $this->usuario_asociacion->setId_Usuario($idUsuarioValue);
                $this->usuario_asociacion->setId_Asociacion($_REQUEST['asociacion']);
                $this->usuario_asociacion->setSuperAdmi(0);
                $this->usuario_asociacion->setAdmi(0);
                $this->usuario_asociacion->save();
        
                $idusuario->setid_categoria($_REQUEST['id_Categoria']);
                $idusuario->save();
        
                header("Location: index.php?controlador=Admin&accion=listar&id_admin=" . $id_admin);
                exit();
            }
        
            $usuarios_asociaciones = $this->usuario_asociacion->getbyIDUsuario($id_admin);
            $listaAsociacion = $this->asociacion->getAll();
            $listaCategoria = $this->categoria->getAll();
            $usuarioEdit = $this->usuario->getById($_REQUEST['codigo']);
        
            $data['asociaciones'] = $listaAsociacion;
            $data['categorias'] = $listaCategoria;
            $data['usuario_asociaciones'] = $usuarios_asociaciones;
            $data["id_admin"] = $id_admin;
            $data["usuario"] = $usuarioEdit;
            $this->view->show("CRUD/CambiarAsociacionView.php", $data);
        }
        


        
        

        public function eliminarUsuarios(){


            
            if (isset($_REQUEST['codigo'])) {
                $this->usuario->delete($_REQUEST['codigo']);
                header("Location: index.php?controlador=Usuario&accion=ListarSuperAdminUsuario");
            }

        }
        
        

}?>