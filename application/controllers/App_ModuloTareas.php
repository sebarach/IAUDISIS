<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class App_ModuloTareas extends CI_Controller {
	public function __construct(){

		parent::__construct();
		$this->load->helper("url","form");	
		$this->load->library('form_validation'); 
		$this->load->model("funcion_login");
		$this->load->model("ModuloJornadas");
		$this->load->model("ModuloDocumento");
		
	}

	function elegirTareasAsignadas(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){
				$this->load->model("ModuloJornadas");
				$this->load->model("ModuloTarea");
				$BD=$_SESSION["BDSecundaria"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$idUser=$_SESSION["Usuario"];
				if(isset($_POST["local"])){
					$local=$_POST["local"];
				}else{
					$local='00';
				}
				$data["listaTareas"]=$this->ModuloTarea->ListarTareaPorUsuario($BD,$idUser,$local);
				$data["listaTareasHorario"]=$this->ModuloTarea->ListarTareaFormularioHorarioPorUsuario($BD,$idUser,$local);	
				$dataL=$this->ModuloTarea->ListarLocalesHorariosPorUsuario($BD,$idUser);
				if(isset($dataL)){		
					$data["locales"]=$this->ModuloTarea->ListarLocalesHorariosPorUsuario($BD,$idUser);			
				}else{
					$data["locales"]=$this->ModuloTarea->ListarLocalesPorUsuario($BD,$idUser);
				}				
				$data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				$data["cantidadMsj"]=count($data["mensaje"]);
				$data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
				$data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
				$this->load->view('contenido');
				$this->load->view('layout/headerApp',$data);
	        	$this->load->view('layout/sidebarApp',$data);
			   	$this->load->view('App/elegirTareaApp',$data);
			   	$this->load->view('layout/footerApp',$data);		   	
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function verTareas(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3 ){
				if(isset($_POST["txt_id_tarea"]) && isset($_POST["txt_id_asignacion"]) && isset($_POST["txt_local"])){
					$id_tarea=$_POST["txt_id_tarea"];
					$data["Nombre_tarea"]=$_POST["txt_Nombre_tarea"];
					$this->load->model("ModuloJornadas");
					$this->load->model("ModuloTarea");
					$BD=$_SESSION["BDSecundaria"];
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cargo"] = $_SESSION["Cargo"];
					$idUser=$_SESSION["Usuario"];	
					$tipo=$this->ModuloTarea->BuscarTipoTarea($id_tarea,$BD);
					$data["asignacion"]=$_POST["txt_id_asignacion"];	
					$data["local"]=$_POST["txt_local"];
					if ($tipo["FK_ID_Tipo"]==1 || $tipo["FK_ID_Tipo"]==4) {
					$data["listaFormulario"]=$this->ModuloTarea->ListarFormularioPorTareaActivas($BD,$id_tarea,$_POST["txt_id_asignacion"],$_POST["txt_local"],$_SESSION["Usuario"]);
					}
					if ($tipo["FK_ID_Tipo"]==3) {
						$data["listaTrivia"]=$this->ModuloTarea->ListarTriviaPorTareaActivas($BD,$id_tarea,$_POST["txt_id_asignacion"],$_POST["txt_local"],$_SESSION["Usuario"]);
					}
					if ($tipo["FK_ID_Tipo"]==5) {
						$data["listaFormularioEsp"]=$this->ModuloTarea->ListarFormularioEspPorTareaActivas($BD,$id_tarea);
					}
					$data["tipo"]=$tipo["FK_ID_Tipo"];
					$data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
					$data["cantidadMsj"]=count($data["mensaje"]);
					$data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
					$data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
					$this->load->view('contenido');
					$this->load->view('layout/headerApp',$data);
		        	$this->load->view('layout/sidebarApp',$data);
				   	$this->load->view('App/verFormulariosApp',$data,$tipo);
				   	$this->load->view('layout/footerApp',$data);
				}else{
					redirect(site_url("App_ModuloTareas/elegirTareasAsignadas"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}
}