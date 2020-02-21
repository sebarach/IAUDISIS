<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class App_ModuloFunciones extends CI_Controller {

	public function __construct(){
		parent::__construct(); 	
    $this->load->model("moduloUsuarioApp");
    $this->load->model("ModuloJornadas");
    $this->load->model("ModuloDocumento"); 
	}

  function QuiebresProductos(){
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==3){
        $BD=$_SESSION["BDSecundaria"];
        $data["Nombre"]=$_SESSION["Nombre"];
        $data["Perfil"] = $_SESSION["Perfil"];
        $data["Cargo"] = $_SESSION["Cargo"];
        $idUser=$_SESSION["Usuario"];
        if(isset($_POST["txt_tipo"])){
          if($_POST["txt_tipo"]=="1"){
            $data["Titulo"]="Mensuales";
            $data["Tipo"]="0";
            $data["Quiebres"]=$this->ModuloUsuarioApp->QuiebresProductosUsuario($idUser,'',$BD);  
          }else{
            $data["Titulo"]="Diarios";
            $data["Tipo"]="1";
            $data["Quiebres"]=$this->ModuloUsuarioApp->QuiebresProductosUsuario($idUser,' AND CONVERT(date,Fecha_Registro)=CONVERT(date,GETDATE()) ',$BD);  
          }
        }else{
          $data["Titulo"]="Diarios";
          $data["Tipo"]="1";
          $data["Quiebres"]=$this->moduloUsuarioApp->QuiebresProductosUsuario($idUser,' AND CONVERT(date,Fecha_Registro)=CONVERT(date,GETDATE()) ',$BD);  
        }        
        // var_dump($data["Quiebres"]);
        $msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
        $data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
        $data["cantidadMsj"]=count($data["mensaje"]);
        $data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
        $data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
        $data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
        $this->load->view('contenido');
        $this->load->view('layout/headerApp',$data);
        $this->load->view('layout/sidebarApp',$data);
        $this->load->view('App/QuiebresApp',$data);
        $this->load->view('layout/footerApp',$data);
      }else{
        redirect(site_url("login/inicio")); 
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  } 

}

   
?>
