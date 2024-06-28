<?php
require 'models/Usuario_AsociacionModel.php';
require 'models/UsuarioModel.php';
require 'models/ComprobacionModel.php';
require 'models/ParametrosModel.php';


class LoginController
{
 
    protected $view;
    protected $usuario_asociacion;
    protected $usuario;
    protected $comprobacion;
    protected $parametros;

    
    function __construct()
    {
        
        $this->view = new View();
        $this->usuario_asociacion = new Usuario_AsociacionModel();
        $this->usuario = new UsuarioModel();
        $this->comprobacion = new ComprobacionModel();
        $this->parametros = new ParametrosModel();

    }


    public function login(){

       $parametros= $this->parametros->getAll();
     
       if ($parametros === false || !is_array($parametros) || empty($parametros)) {
        die("Error: No se pudieron obtener los parámetros.");
    }
    
    if (!isset($_SESSION['intentos'])) {
        $_SESSION['intentos'] = $parametros[0]->getIntentos();
    }
    
    if (!isset($_SESSION['tiempo'])) {
        $_SESSION['tiempo'] = $parametros[0]->getTiempo();
    }
    
    if (!isset($_SESSION['intentos_login'])) {
        $_SESSION['intentos_login'] = $parametros[0]->getIntentos_login();
    }




        $errores = array();


        if (isset($_REQUEST['Login'])) {
            if (!isset($_REQUEST['username']) || empty($_REQUEST['username']))
            $errores['username'] = "* Usuario: Error";
        if (!isset($_REQUEST['password']) || empty($_REQUEST['password']))
            $errores['password'] = "* Contraseña: Error";
            if (empty($errores)) {
                $user = $_REQUEST['username'];
                $password = $_REQUEST['password'];


                $resultado = $this->usuario->ComprobarUser_Password($user, $password);

                if ($resultado) {


                   $this->comprobacion->deletebyUser(1);

                       $rol = $this->usuario_asociacion->getRol($user);
                       $datosUser_Asociacion = $this->usuario_asociacion->getUsuario($user);

                       foreach ($datosUser_Asociacion as $user_asociacion) {
                        $id_usuario = $user_asociacion['id_Usuario'];
                        $id_asociacion= $user_asociacion['id_Asociacion'];
                      }


                            $activo=$this->usuario->Activo_Verificación($id_usuario);

                            if ($activo) {

                           if ($rol=="admin") {

                            session_start();
                            $_SESSION['usuario_admin']="admin";


                             header("Location: index.php?controlador=Admin&accion=listar&id_admin=". $id_usuario);
                            exit();

                           } elseif ($rol=="superadmin") {
                            session_start();
                            $_SESSION['usuario_superadmin']="superadmin";


                            header("Location: index.php?controlador=SuperAdmin&accion=ListarSuperAdmin");
                            exit(); 
                           } else {
                           
                            $_SESSION['id_usuario']= $id_usuario;
                            $_SESSION['id_asociacion']= $id_asociacion;

                    //comprobación de inicio 

                            $comprobacion_Intentos=$this->comprobacion->numeroIntentos($id_usuario);
                            $intentos= $_SESSION['intentos'];
                            if ($comprobacion_Intentos["intentos"]==null&&$comprobacion_Intentos["intentos_login"]==null) {
                                $this->comprobacion->setIntentos(1);
                                $this->comprobacion->setActivo(1);
                                $this->comprobacion->setId_Usuario($id_usuario);
                                $this->comprobacion->insert();

                            }else if($comprobacion_Intentos["intentos"]==$intentos){
                               
                                $idcomprobacion =  $this->comprobacion->getByIDUsuario($id_usuario);
                                $data['idcomprobacion'] = $idcomprobacion;
                                $tiempo= $_SESSION['tiempo'];
                                $data['tiempo']= $tiempo;
                                $data['clave']=$this->codigo();
                                $this->view->show("ComprobacionView.php",  $data);
                                exit();


                            }else{
                                $this->comprobacion->incrementarIntentos($id_usuario);

                              
                            }
                            
                            session_start();
                            $_SESSION['usuario']="usuario";

                             header("Location: index.php?controlador=Fichar&accion=fichar&id_usuario=". $id_usuario."&id_asociacion=". $id_asociacion);
                             exit();
                            
                           }
                       }else{
                        echo '<script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "ERROR!",
                                text: "Usuario desactivado!",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        });
                    </script>';
                       // echo "<script>alert('Usuario desactivado');</script>";

                       }
                   
                   

                    
                }else{
                    //comprobación de fallo de login

                    $comprobacion_Intentos=$this->comprobacion->numeroIntentos(1);
                    $intentos_login= $_SESSION['intentos_login'];
                    if (!$comprobacion_Intentos || !is_array($comprobacion_Intentos)) {
                        $this->comprobacion->setIntentos_login(1);
                        $this->comprobacion->setActivo(1);
                        $this->comprobacion->setId_Usuario(1);
                        $this->comprobacion->insert_login();

                    }else if($comprobacion_Intentos["intentos_login"]==$intentos_login){
                       
                        $idcomprobacion =  $this->comprobacion->getByIDUsuario(1);
                        $data['idcomprobacion'] = $idcomprobacion;
                        $data['error']=" ";


                        $this->view->show("ComprobacionLoginView.php",  $data);
                        exit();


                    }else{
                        $this->comprobacion->incrementarIntentos_login(1);

                      
                    }
                    echo '<script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "ERROR!",
                                text: "Usuario o contraseña incorrectos!",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        });
                    </script>';

                   // echo "<script>alert('Usuario o contraseña incorrectos');</script>";


                }

            }

        }

        $this->view->show("LoginView.php", array('errores' => $errores));

    }

    public function codigo(){
        $longitud_pin = 4; 

       
        $pin = '';
        
        
        for ($i = 0; $i < $longitud_pin; $i++) {
            // Generar un dígito aleatorio entre 0 y 9
            $digito = rand(0, 9);
        
            
            $pin .= $digito;
        }
        
        return $pin;
        
    }

    public function comprobar(){
       



        if (isset($_POST['codigo'])) {

           $codigo=$_POST['codigo'];
           $idcomprobacion=$_POST['idcomprobacion'];
        //    $codigo_verificacion= $_POST['codigo_verificacion']; 
           $id_usuario = $_SESSION['id_usuario'];
           $id_asociacion = $_SESSION['id_asociacion'];
           $clave=$_POST['clave'];
         
           if ($codigo==$clave) {
            
                $this->comprobacion->setIdComprobacion($idcomprobacion);
                $this->comprobacion->delete();
               header("Location: index.php?controlador=Fichar&accion=fichar&id_usuario=". $id_usuario."&id_asociacion=". $id_asociacion);
           } else{
            $this->comprobacion->setIdComprobacion($idcomprobacion);
            $fecha_actual = date('Y-m-d H:i:s', time());
            $this->comprobacion->setFecha_hora( $fecha_actual);
            $this->comprobacion->setActivo(0);
            $this->comprobacion->setIntnetos_Comprobacion(1);
            $this->comprobacion->actualizar();
          
           header("Location: index.php?controlador=Login&accion=logout");
           }
        }else{
            $idcomprobacion=$_POST['idcomprobacion'];
            $this->comprobacion->setIdComprobacion($idcomprobacion);
            $fecha_actual = date('Y-m-d H:i:s', time());
            $this->comprobacion->setFecha_hora( $fecha_actual);
            $this->comprobacion->setActivo(0);
            $this->comprobacion->setIntnetos_Comprobacion(1);
            $this->comprobacion->actualizar();
             header("Location: index.php?controlador=Login&accion=logout");
        }



    }

    public function  comprobar_login(){
        if (isset($_POST['Aceptar'])&&isset($_POST['email'])) {
            $email=$_POST['email'];
            $idcomprobacion=$_POST['idcomprobacion'];

           $idusuario=$this->usuario->getByEmail($email);         
           if (!$idusuario) {
            $idcomprobacion =  $this->comprobacion->getByIDUsuario(1);
            $data['idcomprobacion'] = $idcomprobacion;
            $data['error']="!!ERROR.El email es incorrecto";

            $this->view->show("ComprobacionLoginView.php",  $data);
            exit();
           }
           $this->comprobacion->setIdComprobacion($idcomprobacion);
           $fecha_actual = date('Y-m-d H:i:s', time());
           $this->comprobacion->setFecha_hora( $fecha_actual);
           $this->comprobacion->setActivo(0);
           $this->comprobacion->setLogin_Comprobacion(1);
           $this->comprobacion->setId_Usuario($idusuario);
           $this->comprobacion->actualizar_login();

           
           
            header("Location: index.php?controlador=Login&accion=logout");

        }

    }

    
    public function logout()
    {
        session_start();
        session_unset(); // Elimina todas las variables de sesión
        session_destroy(); // Destruye la sesión
        header("Location: index.php"); // Redirige al usuario a la página principal
        exit();
    }



}

?>