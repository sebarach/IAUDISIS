<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloNotificaciones extends CI_Controller {
	public function __construct(){

		parent::__construct();
			$this->load->model("funcion_login");
			$this->load->library('upload');
			$this->load->library('form_validation'); 
	}

	function crearNotificaciones(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$this->load->model('ModuloUsuario');
				$cli=$_SESSION["Cliente"];
				$BD=$_SESSION["BDSecundaria"];
				$data["hoy"] = getdate();
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
				$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearNotificaciones',$data);
			   	$this->load->view('layout/footer',$data);			   	
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function enviarMensaje(){
		$this->load->model('ModuloUsuario');
		$BD=$_SESSION["BDSecundaria"];
		$creador=$_POST["txtCreador"];
		$usuarios=$_POST["txt_asignacion"];
		$mensaje=$_POST["textarea-msg"];
		if ($mensaje=="") {
			$this->load->model('ModuloUsuario');
			$cli=$_SESSION["Cliente"];
			$BD=$_SESSION["BDSecundaria"];
			$data["hoy"] = getdate();
			$data["Cargo"] = $_SESSION["Cargo"];
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"] = $_SESSION["Perfil"];
			$data["Cliente"] = $_SESSION["Cliente"];
			$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Clientes"]= $this->funcion_login->elegirCliente();
			$this->load->view('contenido');
			$this->load->view('layout/header',$data);
		   	$this->load->view('layout/sidebar',$data);
		   	$this->load->view('admin/adminCrearNotificaciones',$data);
		    $this->load->view('layout/footer',$data);
		}else{
			foreach ($usuarios as $u) {
			$ingresos=$this->ModuloUsuario->ingresarMensaje($u,$mensaje,$creador,$BD);	
			}
			$this->load->model('ModuloUsuario');
			$cli=$_SESSION["Cliente"];
			$BD=$_SESSION["BDSecundaria"];
			$data["hoy"] = getdate();
			$data["Cargo"] = $_SESSION["Cargo"];
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"] = $_SESSION["Perfil"];
			$data["Cliente"] = $_SESSION["Cliente"];
			$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Clientes"]= $this->funcion_login->elegirCliente();
			$this->load->view('contenido');
			$this->load->view('layout/header',$data);
		   	$this->load->view('layout/sidebar',$data);
		   	$this->load->view('admin/adminCrearNotificaciones',$data);
		    $this->load->view('layout/footer',$data);	
		}		
	}

	function MarcarLeido(){
		// var_dump($_POST);exit();
			$this->load->model('ModuloJornadas');
			$idMsj=$_POST["idmsj"];
			$BD=$_SESSION["BDSecundaria"]; 
			$this->ModuloJornadas->MarcarLeido($BD,$idMsj);
		}
}