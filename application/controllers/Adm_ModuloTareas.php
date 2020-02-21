<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloTareas extends CI_Controller {
	public function __construct(){

		parent::__construct();
		$this->load->helper("url","form");	
		$this->load->library('form_validation'); 
		$this->load->model("funcion_login");
		$this->load->library('upload');
		$this->load->model("ModuloTarea");
		$this->load->model("ModuloPuntosVentas");
	}

	function crearTarea(){
		$this->load->model("ModuloTarea");
		$this->load->model('ModuloUsuario');
		if (isset($_SESSION["sesion"])) {
			if ($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2) {
				$BD=$_SESSION["BDSecundaria"];
				$cli=$_SESSION["Cliente"];
				$data["Cargo"]=$_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]=$this->funcion_login->elegirCliente();
				$data["TipoTareas"]=$this->ModuloTarea->cargarTipoTareas($BD);
				$data["ListaFormularios"]=$this->ModuloTarea->cargarFormularios($BD);	
				$data["ListaFormulariosEspeciales"]=$this->ModuloTarea->listarFormulariosEspecialesActivos($BD);
				$data["UsuariosMoviles"]=$this->ModuloTarea->cargarUsuarios($BD);
				$data["GrupoU"]=$this->ModuloUsuario->listarGrupoUsuariosActivos($cli);	
				$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);	
				$data["ListaTrivias"]=$this->ModuloTarea->listarTrivias($BD);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearTareas',$data);
			   	$this->load->view('layout/footer',$data);
			}
		}
	}

	function asignarTareaUnitario(){
		$this->load->model('ModuloUsuario');
		$this->load->model("ModuloTarea");
		$BD=$_SESSION["BDSecundaria"];	
		$validador=$_POST["txt_validador"];
		//Si el validador es 0 la asignación es para grupo de usuarios.
		if(isset($_POST["txt_tipoTarea"])){
			if($_POST["txt_tipoTarea"]=='4'){
				if(isset($_POST["txt_GrupoL"])){
					foreach ($_POST["txt_GrupoL"] as $gl) {
						$this->ModuloTarea->asignarTareaGrupoLocal($BD,$_POST["msltTarea"],$gl);
					}
				}
			}
		}
		if ($_POST["txt_validador"]==0) {
			if (isset($_POST["txt_local"]) && isset($_POST["txt_fecha_fin"])) {
				$contador=0;
				$grupoU=$_POST["txt_userGrupo"];
				if(isset($_POST["txt_fecha_inicio"])){
					$fecha_inicio=date('d/m/Y', strtotime($_POST["txt_fecha_inicio"]));
				}else{
					$fecha_inicio=date('d/m/Y', strtotime(date('Y-m-d')));
				}
				$fecha_fin=date('d/m/Y', strtotime($_POST["txt_fecha_fin"]));
				$local=$_POST["txt_local"];
				$tarea=$_POST["msltTarea"];
				for ($i=0; $i < sizeof($grupoU); $i++) { 
					$usuarios[$contador]=$this->ModuloTarea->buscarUsuariosporGrupoUsuarios($grupoU[$i],$BD);
					$contador++;
				}

				for ($i=0; $i < sizeof($grupoU); $i++){ 
					for ($f=0; $f < sizeof($usuarios[$i]); $f++){ 
						for ($lc=0; $lc < sizeof($local); $lc++) {
						$ingresos=$this->ModuloTarea->AsignarTarea($usuarios[$i][$f]["FK_Usuarios_ID_Usuario"],$tarea,$fecha_inicio,$local[$lc],$fecha_fin,$BD);
						}	
					}
				}
				$mens['tipo'] = 29;
				$cli=$_SESSION["Cliente"];
				$data["Cargo"]=$_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]=$this->funcion_login->elegirCliente();
				$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
				$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
				$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
				$data["GrupoU"]=$this->ModuloUsuario->listarGrupoUsuariosActivos($cli);
				$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
				$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
				$this->load->view('layout/sidebar',$data);
				$this->load->view('admin/adminAsignarTarea',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
			}
			elseif (isset($_POST["txt_local"]) && !isset($_POST["txt_fecha_fin"])) {
				$tarea=$_POST["msltTarea"];
				$local=$_POST["txt_local"];
				$fecha_fin=null;
				$grupoU=$_POST["txt_userGrupo"];
				if(isset($_POST["txt_fecha_inicio"])){
					$fecha_inicio=date('d/m/Y', strtotime($_POST["txt_fecha_inicio"]));
				}else{
					$fecha_inicio=date('d/m/Y', strtotime(date('Y-m-d')));
				}
				$contador=0;
				for ($i=0; $i < sizeof($grupoU); $i++) { 
					$usuarios[$contador]=$this->ModuloTarea->buscarUsuariosporGrupoUsuarios($grupoU[$i],$BD);
					$contador++;
				}	
				for ($i=0; $i < sizeof($grupoU); $i++){ 
					for ($f=0; $f < sizeof($usuarios[$i]); $f++){ 
						for ($lc=0; $lc < sizeof($local); $lc++) {
						$ingresos=$this->ModuloTarea->AsignarTarea($usuarios[$i][$f]["FK_Usuarios_ID_Usuario"],$tarea,$fecha_inicio,$local[$lc],$fecha_fin,$BD);
						}	
					}
				}
				$mens['tipo'] = 29;
				$cli=$_SESSION["Cliente"];
				$data["Cargo"]=$_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]=$this->funcion_login->elegirCliente();
				$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
				$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
				$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
				$data["GrupoU"]=$this->ModuloUsuario->listarGrupoUsuariosActivos($cli);
				$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
				$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
				$this->load->view('layout/sidebar',$data);
				$this->load->view('admin/adminAsignarTarea',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
			}
			elseif (!isset($_POST["txt_local"]) && isset($_POST["txt_fecha_fin"])) {
				// echo 3444; exit();
				$tarea=$_POST["msltTarea"];
				$local=0;
				$grupoU=$_POST["txt_userGrupo"];
				if(isset($_POST["txt_fecha_inicio"])){
					$fecha_inicio=date('d/m/Y', strtotime($_POST["txt_fecha_inicio"]));
				}else{
					$fecha_inicio=date('d/m/Y', strtotime(date('Y-m-d')));
				}
				$fecha_fin=date('d/m/Y', strtotime($_POST["txt_fecha_fin"]));
				$contador=0;
				for ($i=0; $i < sizeof($grupoU); $i++) { 
					$usuarios[$contador]=$this->ModuloTarea->buscarUsuariosporGrupoUsuarios($grupoU[$i],$BD);
					$contador++;
				}				
				for ($i=0; $i < sizeof($grupoU); $i++){ 
					for ($f=0; $f < sizeof($usuarios[$i]); $f++){ 			
						$ingresos=$this->ModuloTarea->AsignarTarea($usuarios[$i][$f]["FK_Usuarios_ID_Usuario"],$tarea,$fecha_inicio,$local,$fecha_fin,$BD);						
					}
				}
				$mens['tipo'] = 29;
				$cli=$_SESSION["Cliente"];
				$data["Cargo"]=$_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]=$this->funcion_login->elegirCliente();
				$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
				$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
				$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
				$data["GrupoU"]=$this->ModuloUsuario->listarGrupoUsuariosActivos($cli);
				$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
				$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
				$this->load->view('layout/sidebar',$data);
				$this->load->view('admin/adminAsignarTarea',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
			}
			elseif (!isset($_POST["txt_local"]) && !isset($_POST["txt_fecha_fin"])) {
				$tarea=$_POST["msltTarea"];
				$grupoU=$_POST["txt_userGrupo"];
				$local=0;
				if(isset($_POST["txt_fecha_inicio"])){
					$fecha_inicio=date('d/m/Y', strtotime($_POST["txt_fecha_inicio"]));
				}else{
					$fecha_inicio=date('d/m/Y', strtotime(date('Y-m-d')));
				}
				$fecha_fin="";
				$contador=0;
				for ($i=0; $i < sizeof($grupoU); $i++) { 
					$usuarios[$contador]=$this->ModuloTarea->buscarUsuariosporGrupoUsuarios($grupoU[$i],$BD);
					$contador++;
				}
				for ($i=0; $i < sizeof($grupoU); $i++){ 
					for ($f=0; $f < sizeof($usuarios[$i]); $f++){ 
						$ingresos=$this->ModuloTarea->AsignarTarea($usuarios[$i][$f]["FK_Usuarios_ID_Usuario"],$tarea,$fecha_inicio,$local,$fecha_fin,$BD);
					}
				}
				$mens['tipo'] = 29;
				$cli=$_SESSION["Cliente"];
				$data["Cargo"]=$_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]=$this->funcion_login->elegirCliente();
				$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
				$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
				$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
				$data["GrupoU"]=$this->ModuloUsuario->listarGrupoUsuariosActivos($cli);
				$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
				$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
				$this->load->view('layout/sidebar',$data);
				$this->load->view('admin/adminAsignarTarea',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
			}
			// var_dump($local);
			//Aquí es el caso contrario para asignar a a muchos usuarios y no grupos de usuarios.
		}else{
		// exit();
		if (isset($_POST["txt_user"])) {
			$tarea=$_POST["msltTarea"];
			$usuario=$_POST["txt_user"];
			if(isset($_POST["txt_fecha_inicio"])){
				$fecha_inicio=date('d/m/Y', strtotime($_POST["txt_fecha_inicio"]));
			}else{
				$fecha_inicio=date('d/m/Y', strtotime(date('Y-m-d')));
			}
			if (isset($_POST["txt_local"]) && isset($_POST["txt_fecha_fin"])) {
				$local=$_POST["txt_local"];
				$fecha_fin=date('d/m/Y', strtotime($_POST["txt_fecha_fin"]));
				foreach ($usuario as $u) {
					foreach ($local as $l) {
						$this->ModuloTarea->AsignarTarea($u,$tarea,$fecha_inicio,$l,$fecha_fin,$BD);
					}
				}			
				$this->load->model('ModuloUsuario');
				$this->load->model("ModuloTarea");
				$BD=$_SESSION["BDSecundaria"];
				$mens['tipo'] = 29;
				$cli=$_SESSION["Cliente"];
				$data["Cargo"]=$_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]=$this->funcion_login->elegirCliente();
				$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
				$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
				$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
				$data["GrupoU"]=$this->ModuloUsuario->listarGrupoUsuariosActivos($cli);
				$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
				$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
				$this->load->view('layout/sidebar',$data);
				$this->load->view('admin/adminAsignarTarea',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
			}
			elseif (isset($_POST["txt_local"]) && !isset($_POST["txt_fecha_fin"])) {
				$local=$_POST["txt_local"];
				$fecha_fin=null;
				foreach ($usuario as $u) {
					foreach ($local as $l) {
						$this->ModuloTarea->AsignarTarea($u,$tarea,$fecha_inicio,$l,$fecha_fin,$BD);
					}
				}
				$this->load->model('ModuloUsuario');
				$this->load->model("ModuloTarea");
				$BD=$_SESSION["BDSecundaria"];
				$mens['tipo'] = 29;
				$cli=$_SESSION["Cliente"];
				$data["Cargo"]=$_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]=$this->funcion_login->elegirCliente();
				$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
				$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
				$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
				$data["GrupoU"]=$this->ModuloUsuario->listarGrupoUsuariosActivos($cli);
				$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
				$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
				$this->load->view('layout/sidebar',$data);
				$this->load->view('admin/adminAsignarTarea',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
			}
			elseif (!isset($_POST["txt_local"]) && isset($_POST["txt_fecha_fin"])) {
				$local=0;
				$fecha_fin=date('d/m/Y', strtotime($_POST["txt_fecha_fin"]));
				foreach ($usuario as $u) {
					$this->ModuloTarea->AsignarTarea($u,$tarea,$fecha_inicio,$local,$fecha_fin,$BD);
				}
				$this->load->model('ModuloUsuario');
				$this->load->model("ModuloTarea");
				$BD=$_SESSION["BDSecundaria"];
				$mens['tipo'] = 29;
				$cli=$_SESSION["Cliente"];
				$data["Cargo"]=$_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]=$this->funcion_login->elegirCliente();
				$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
				$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
				$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
				$data["GrupoU"]=$this->ModuloUsuario->listarGrupoUsuariosActivos($cli);
				$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
				$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
				$this->load->view('layout/sidebar',$data);
				$this->load->view('admin/adminAsignarTarea',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
			}
			elseif (!isset($_POST["txt_local"]) && !isset($_POST["txt_fecha_fin"])) {
				$local=0;
				$fecha_fin="";
				foreach ($usuario as $u) {
					$this->ModuloTarea->AsignarTarea($u,$tarea,$fecha_inicio,$local,$fecha_fin,$BD);
				}
				$this->load->model('ModuloUsuario');
				$this->load->model("ModuloTarea");
				$BD=$_SESSION["BDSecundaria"];
				$mens['tipo'] = 29;
				$cli=$_SESSION["Cliente"];
				$data["Cargo"]=$_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]=$this->funcion_login->elegirCliente();
				$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
				$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
				$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
				$data["GrupoU"]=$this->ModuloUsuario->listarGrupoUsuariosActivos($cli);
				$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
				$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
				$this->load->view('layout/sidebar',$data);
				$this->load->view('admin/adminAsignarTarea',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
			}		
		}else{
			redirect(site_url("Adm_ModuloTareas/asignarTarea"));
		}
	}
}

	function ActivarTarea(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				if(isset($_POST["idtarea"])){
					$this->load->model("ModuloTarea");
					$BD=$_SESSION["BDSecundaria"];			
					$idTarea=$_POST["idtarea"];
					$t=$this->ModuloTarea->listarTareasID($BD,$idTarea);
					$estado=$t["Activo"];
					echo "<form method='post' id='cambiarTarea' action='cambiarEstadoTareaF'>";
					if ($estado==1) {
						echo "<p>¿Esta Seguro que desea Desactivar la Tarea ".$t['NombreTarea']." ?</p>";
					}else{
						echo "<p>¿Esta Seguro que desea Activar la Tarea ".$t['NombreTarea']." ?</p>";
					}
					echo "<input type='hidden' name='txt_id_tarea' value='".$idTarea."'>";
					echo "<input type='hidden' name='txt_estado' value='".$estado."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloTareas/asignarTarea"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}
	}

	function cambiarEstadoTareaF(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_id_tarea"])){
					$this->load->model("ModuloTarea");
					$BD=$_SESSION["BDSecundaria"];					
					$idTarea=$_POST["txt_id_tarea"];
					$vigencia=$_POST["txt_estado"];

					$filas=$this->ModuloTarea->CambiarVigenciaTarea($idTarea,$vigencia,$BD);
					if($vigencia=1){
						$var="desactivado";
						$typeAlert="error";
					}else{
						$var="activado";
						$typeAlert="success";
					}
					if($filas["CantidadInsertadas"]==0){
						$data['mensaje']='alertify.error("No se pudo realizar la operacion")';
					}else{
						$data['mensaje']='alertify.success("Se ha "'.$var.'" correctamente")';
					}
					$this->load->model('ModuloUsuario');
					$BD=$_SESSION["BDSecundaria"];
					$cli=$_SESSION["Cliente"];
					$data["Cargo"]=$_SESSION["Cargo"];
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"]=$_SESSION["Perfil"];
					$data["Cliente"]=$_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Clientes"]=$this->funcion_login->elegirCliente();
					$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
					$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
					$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
					$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
					$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
					$this->load->view('layout/sidebar',$data);
					$this->load->view('admin/adminAsignarTarea',$data);
				   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloTareas/asignarTarea"));
				}
			}
		}
	}

	function crearTareaTipo(){	
		$this->load->model('ModuloUsuario');
		$this->load->model("ModuloTarea");
		$BD=$_SESSION["BDSecundaria"];
		$tipo=$_POST["msltTipoTarea"];
		$nombre=$_POST["txtNombreTarea"];
		$id_creador=$_SESSION['Usuario'];
		if (isset($_POST["txt_formu"])) {
			$formulario=$_POST["txt_formu"];
		}
		if (isset($_POST["txt_quiz"])) {
			$quiz=$_POST["txt_quiz"];
		}
		if (isset($_POST["txt_horario"])) {
			$horario=$_POST["txt_horario"];
		}

		if (isset($_POST["txt_formuEspecial"])) {
			$fomuEsp=$_POST["txt_formuEspecial"];
		}
		$idTarea[1]['ID']=$this->ModuloTarea->ingresarTarea($BD,$tipo,$id_creador,$nombre);
		$idT=implode($idTarea[1]['ID']);
		if ($tipo==1) {
			foreach ($formulario as $f) {
			$this->ModuloTarea->ingresarTareaFormulario($BD,$idT,$f);
			}
		}

		if ($tipo==3) {
			foreach ($quiz as $q) {
			$this->ModuloTarea->ingresarTareaQuiz($BD,$idT,$q);
			}
		}

		if ($tipo==4) {
			foreach ($horario as $h) {
			$this->ModuloTarea->ingresarTareaFormulario($BD,$idT,$h);
			}
		}

		if ($tipo==5) {
			foreach ($fomuEsp as $e) {
			$this->ModuloTarea->ingresarTareaFormulario($BD,$idT,$e);
			}
		}
		
		$mens['tipo'] = 28;
		$cli=$_SESSION["Cliente"];
		$data["Cargo"]=$_SESSION["Cargo"];
		$data["Usuario"]=$_SESSION["Usuario"];					
		$data["Nombre"]=$_SESSION["Nombre"];
		$data["Perfil"]=$_SESSION["Perfil"];
		$data["Cliente"]=$_SESSION["Cliente"];
		$data["NombreCliente"]=$_SESSION["NombreCliente"];
		$data["Clientes"]=$this->funcion_login->elegirCliente();
		$data["TipoTareas"]=$this->ModuloTarea->cargarTipoTareas($BD);
		$data["ListaFormularios"]=$this->ModuloTarea->cargarFormularios($BD);	
		$data["UsuariosMoviles"]=$this->ModuloTarea->cargarUsuarios($BD);
		$data["GrupoU"]=$this->ModuloUsuario->listarGrupoUsuariosActivos($cli);	
		$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);	
		$this->load->view('contenido');
		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('admin/adminCrearTareas',$data);
	   	$this->load->view('layout/footer',$data);
	   	$this->load->view('layout/mensajes',$mens);

	}

	function asignarTarea(){
		$this->load->model('ModuloUsuario');
		$this->load->model("ModuloTarea");
		$BD=$_SESSION["BDSecundaria"];
		$cli=$_SESSION["Cliente"];
		$data["Cargo"]=$_SESSION["Cargo"];
		$data["Usuario"]=$_SESSION["Usuario"];					
		$data["Nombre"]=$_SESSION["Nombre"];
		$data["Perfil"]=$_SESSION["Perfil"];
		$data["Cliente"]=$_SESSION["Cliente"];
		$data["NombreCliente"]=$_SESSION["NombreCliente"];
		$data["Clientes"]=$this->funcion_login->elegirCliente();
		$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
		$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
		$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
		$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
		$data["GrupoU"]=$this->ModuloTarea->listarGrupoUsuariosActivos($cli);
		$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
		$this->load->view('contenido');
		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('admin/adminAsignarTarea',$data);
	   	$this->load->view('layout/footer',$data);
	}

	function elegirtarea(){
		$this->load->model("ModuloTarea");
		$dato=$this->ModuloTarea->BuscarTipoTarea($_POST["tarea"],$_SESSION["BDSecundaria"]);
		echo $dato["FK_ID_Tipo"];
	}

	function VerFormulariosAsignados(){		
		$this->load->model("ModuloTarea");
		$BD=$_SESSION["BDSecundaria"];
		$id_tarea=$_POST["idform"];
		$tipo_tarea=$this->ModuloTarea->listarTareasID($BD,$id_tarea);
		if ($tipo_tarea["FK_ID_Tipo"]==1 || $tipo_tarea["FK_ID_Tipo"]==4 || $tipo_tarea["FK_ID_Tipo"]==5) {
			if($tipo_tarea["FK_ID_Tipo"]==5){
				$formu=$this->ModuloTarea->ListarFormularioEspecialPorTarea($BD,$id_tarea);	
			}else{
				$formu=$this->ModuloTarea->ListarFormularioPorTarea($BD,$id_tarea);	
			}			
			$contador=1;
			$cont=0;
			echo "<div class='modal-header'>
	                    <h6 class='modal-title' >Ver Formularios</h6>
	                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
	                </div>

	                <div class='card-body'>
		                <table class='table color-bordered-table danger-bordered-table'>
		                <thead>
			                <tr>
			                    <th>#</th>
			                    <th>Formulario</th>
			                </tr>
			            </thead>";
		                    foreach ($formu as $f) {
		                    echo "<tbody>
		                        <tr>
		                        	<td>"; echo $contador; echo"</td>
		                            <td>"; echo $f["NombreFormulario"]; echo"</td>";
		                        "</tr>
		                    </tbody>";
		                    $cont++;
		                    $contador++;
		                }
		                echo "</table>
		            </div>

		            <div class='modal-footer'>
	                	<button type='button' class='btn btn-danger' data-dismiss='modal'> Cerrar </button>
	                </div>";
			}
		if ($tipo_tarea["FK_ID_Tipo"]==3) {
			$quiz=$this->ModuloTarea->ListarQuizPorTarea($BD,$id_tarea);
			$contador=1;
			$cont=0;
			echo "<div class='modal-header'>
	                    <h6 class='modal-title' >Ver Trivias</h6>
	                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
	                </div>

	                <div class='card-body'>
		                <table class='table color-bordered-table danger-bordered-table'>
		                <thead>
			                <tr>
			                    <th>#</th>
			                    <th>Formulario</th>
			                    <th>Fecha Registro</th>
			                </tr>
			            </thead>";
		                    foreach ($quiz as $q) {
		                    echo "<tbody>
		                        <tr>
		                        	<td>"; echo $contador; echo"</td>
		                            <td>"; echo $q["Nombre"]; echo"</td>
		                            <td>"; echo date('d/m/Y', strtotime($q["Fecha_Registro"])); echo"</td>";
		                        "</tr>
		                    </tbody>";
		                    $cont++;
		                    $contador++;
		                }
		                echo "</table>
		            </div>

		            <div class='modal-footer'>
	                	<button type='button' class='btn btn-danger' data-dismiss='modal'> Cerrar </button>
	                </div>";
		}
		
    }

    function VerUsuariosLocales(){
    	$this->load->model("ModuloTarea");
		$BD=$_SESSION["BDSecundaria"];
		$id_tarea=$_POST["idtarea"];
		$asignacion=$this->ModuloTarea->ListarAsignacionUsuarioLocal($BD,$id_tarea);
		$contador=1;
		$cont=0;
    	echo "<div class='modal-header'>
                    <h6 class='modal-title' >Ver Usuarios Asignados</h6>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                </div>
    	
    			<div class='card-body'>
	                <table class='table color-bordered-table danger-bordered-table'>
	                <thead>
		                <tr>
		                    <th>#</th>
		                    <th>Usuario(Rut)</th>
		                    <th>Local</th>
		                </tr>
		            </thead>";
	                    foreach ($asignacion as $a) {
	                    echo "<tbody>
	                        <tr>
	                        	<td>"; echo $contador; echo"</td>
	                            <td>"; echo $a["Nombres"]; echo " ("; echo $a["Usuario"]; echo")</td>
	                            <td>"; if ($a["NombreLocal"]!=null) {
	                            echo $a["NombreLocal"]; echo"</td>";
	                        }else{
	                        	echo "<i class='fa fa-ban text-danger'></i>";
	                        }
	                    echo "</tr>
	                    </tbody>";
	                    $cont++;
	                    $contador++;
	                }
	                echo "</table>
	            </div>

	            <div class='modal-footer'>
                	<button type='button' class='btn btn-danger' data-dismiss='modal'> Cerrar </button>
                </div>";
    }

    function IngExcelTarea(){
    	$cont=$_POST["txt_contador"];
    	if (($_FILES['excelv-'.$cont]['name']=="")) {
    		$this->load->model('ModuloUsuario');
			$this->load->model('ModuloElemento');
			$this->load->model('ModuloTarea');
			$mens['tipo']=30;	
			$BD=$_SESSION["BDSecundaria"];
			$cli=$_SESSION["Cliente"];
			$data["Cargo"]=$_SESSION["Cargo"];
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"]=$_SESSION["Perfil"];
			$data["Cliente"]=$_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Clientes"]=$this->funcion_login->elegirCliente();
			$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
			$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
			$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
			$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
			$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
			$this->load->view('contenido');
			$this->load->view('layout/header',$data);
			$this->load->view('layout/sidebar',$data);
			$this->load->view('admin/adminAsignarTarea',$data);
		   	$this->load->view('layout/footer',$data);
		   	$this->load->view('layout/mensajes',$mens);
			$cont=$_POST["txt_contador"];
    	}else{
    		$cont=$_POST["txt_contador"];
    		if (pathinfo($_FILES['excelv-'.$cont]['name'],PATHINFO_EXTENSION)=="xls" || pathinfo($_FILES['excelv-'.$cont]['name'],PATHINFO_EXTENSION)=="xlsx") {
    		$this->load->model('ModuloUsuario');
			$this->load->model('ModuloElemento');
			$this->load->model('ModuloTarea');
			$BD=$_SESSION["BDSecundaria"];
			$cli=$_SESSION["Cliente"];
			$excel = $this->limpiaEspacio($_FILES['excelv-'.$cont]['name']);
			$R=$this->subirArchivos($excel,$cont,0);
			$this->load->library('phpexcel');							
			$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
			$objReader = PHPExcel_IOFactory::createReader($tipo);
			$object = $objReader->load("archivos/archivos_Temp/".$excel);
			$object->setActiveSheetIndex(0);
			$defaultPrecision = ini_get('precision');
			ini_set('precision', $defaultPrecision);
			$error=0;
			$parametro=0;
			$id_tarea=$_POST["txt_id_tarea"];
			$fila=2;
			$contador=0;		
			$filaMaxima=$object->setActiveSheetIndex(0)->getHighestRow();
			while ($parametro==0) {
				if ($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue()==NULL) {
					$parametro=1;
				}else{
					$usuario[$contador]=$object->getActiveSheet()->getCell('A'.$fila)->getFormattedValue();
					$usuarioLimpio=$this->limpiarComilla($usuario);
					$id_usuario[$contador]=$this->ModuloTarea->buscarIdUsuario($usuarioLimpio[$contador]);	
				 	if($id_usuario[$contador]["id_usuario"]==null){
		 				$parametro=1;
		 				$error=9;
		 				break;
		 			}
					$local[$contador]=$object->getActiveSheet()->getCell('B'.$fila)->getFormattedValue();
					if ($local[$contador]=='') {
						$idLocal[$contador]["ID_Local"]=0;
					}else{
						$idLocal[$contador]=$this->ModuloElemento->BuscarIdLocal($local[$contador],$BD);
		 			if($idLocal[$contador]["ID_Local"]==null){
		 				$parametro=1;
		 				$error=10;
		 				break;	
		 				}
					}
		 			$fecha_inicio[$contador]=$object->getActiveSheet()->getCell('C'.$fila)->getFormattedValue();
		 			if ($fecha_inicio[$contador]!=null) {
		 				$fecha_inicio[$contador]=date('d/m/Y', strtotime($fecha_inicio[$contador]));
		 			}else{
		 				$fecha_inicio[$contador]==null;
		 				$parametro=1;
						$error=38;
		 			}
		 			
		 			$fecha_fin[$contador]=$object->getActiveSheet()->getCell('D'.$fila)->getFormattedValue();
		 			if ($fecha_fin[$contador]!=null) {
		 				$fecha_fin[$contador]=date('d/m/Y', strtotime($fecha_fin[$contador]));
		 			}else{
		 				$fecha_fin[$contador]==null;
		 			}
		 			$fila++;
					$contador++;
				}
			}
			if ($error==0) {
				for ($i=0; $i <$contador; $i++) { 
					$this->ModuloTarea->AsignarTarea($id_usuario[$i]["id_usuario"],$id_tarea,$fecha_inicio[$i],$idLocal[$i]["ID_Local"],$fecha_fin[$i],$BD);
				}
					$mens['tipo']=29;	
					$BD=$_SESSION["BDSecundaria"];
					$cli=$_SESSION["Cliente"];
					$data["Cargo"]=$_SESSION["Cargo"];
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"]=$_SESSION["Perfil"];
					$data["Cliente"]=$_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Clientes"]=$this->funcion_login->elegirCliente();
					$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
					$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
					$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
					$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
					$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
					$this->load->view('layout/sidebar',$data);
					$this->load->view('admin/adminAsignarTarea',$data);
				   	$this->load->view('layout/footer',$data);
				   	$this->load->view('layout/mensajes',$mens);
				}else{
					$mens['tipo']=$error;	
					$mens['cantidad']=$contador+2;
					$BD=$_SESSION["BDSecundaria"];
					$cli=$_SESSION["Cliente"];
					$data["Cargo"]=$_SESSION["Cargo"];
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"]=$_SESSION["Perfil"];
					$data["Cliente"]=$_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Clientes"]=$this->funcion_login->elegirCliente();
					$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
					$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
					$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
					$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
					$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
					$this->load->view('layout/sidebar',$data);
					$this->load->view('admin/adminAsignarTarea',$data);
				   	$this->load->view('layout/footer',$data);
				   	$this->load->view('layout/mensajes',$mens);
				}
			
    		}else{
    			$this->load->model('ModuloUsuario');
				$this->load->model('ModuloElemento');
				$this->load->model('ModuloTarea');
				$mens['tipo']=31;	
				$BD=$_SESSION["BDSecundaria"];
				$cli=$_SESSION["Cliente"];
				$data["Cargo"]=$_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]=$this->funcion_login->elegirCliente();
				$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
				$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
				$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
				$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
				$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
				$this->load->view('layout/sidebar',$data);
				$this->load->view('admin/adminAsignarTarea',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
    		}
    	}
    }

	function limpiaEspacio($var){
    	$patron = "/[' ']/i";
		$cadena_nueva = preg_replace($patron,"",$var);
		return $cadena_nueva; 
 	}

 	function limpiarComilla($rut){
    	$patron = "/[']/i";    
        $cadena_nueva = preg_replace($patron, "", $rut);
        return $cadena_nueva; 
    }

 	public function subirArchivos($filename,$cont){
		$archivo ='excelv-'.$cont;
		$config['upload_path'] = "archivos/archivos_Temp/";	
		$config['file_name'] =$filename;
		$config['max_size'] = "2097152";
		$config['max_width'] = "2000";
		$config['max_height'] = "2000";
		$config['allowed_types'] = "*";
		$config['overwrite'] = TRUE;	
		$this->upload->initialize($config);
		if (!$this->upload->do_upload($archivo)) {
			$data['uploadError'] = $this->upload->display_errors();
			echo $this->upload->display_errors();
			return;
		}
		$data = $this->upload->data();
		$nombre= $data['file_name'];
		return $nombre;
	}

	public function subirArchivosE($filename){
		$archivo ='excelv';
		$config['upload_path'] = "archivos/archivos_Temp/";	
		$config['file_name'] =$filename;
		$config['max_size'] = "2097152";
		$config['max_width'] = "2000";
		$config['max_height'] = "2000";
		$config['allowed_types'] = "*";
		$config['overwrite'] = TRUE;	
		$this->upload->initialize($config);
		if (!$this->upload->do_upload($archivo)) {
			$data['uploadError'] = $this->upload->display_errors();
			echo $this->upload->display_errors();
			return;
		}
		$data = $this->upload->data();
		$nombre= $data['file_name'];
		return $nombre;
	}

	function limpiarRut($rut){
    	$patron = "/[^-kK0-9]/i";    
        $cadena_nueva = preg_replace($patron, "", $rut);
        return $cadena_nueva; 
    }

    function generarExcel(){
    	$BD=$_SESSION["BDSecundaria"];
    	$this->load->library('phpexcel');
		$this->load->model("ModuloPuntosVentas");	
		$this->load->model("ModuloTarea");	
		$objReader =  PHPExcel_IOFactory::createReader('Excel2007');		
		$object = $objReader->load("doc/plantilla/PlantillaAsignacionTareas.xlsx");
		$objectUser = $objReader->load("doc/plantilla/PlantillaAsignacionTareas.xlsx");
		$object->setActiveSheetIndex(1); 
		$dataLocal = $this->ModuloPuntosVentas->listarLocales($BD);
		$dataUser = $this->ModuloTarea->listarUsuarios($BD);
		$column_row=2;
	 	foreach($dataLocal as $row)
	 	{	 
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['NombreLocal']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $row['NombreCadena']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $row['Direccion']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(3 , $column_row, $row['Rango']);	 		
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(4 , $column_row, $row['Latitud']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(5 , $column_row, $row['Longitud']);
	 		$column_row++;	 		
	 	}
	 	$column_row=2;
	 	$object->setActiveSheetIndex(2); 
	 	foreach ($dataUser as $rowU) {
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $rowU['Usuario']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $rowU['Nombres']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $rowU['Rut']);
	 		$column_row++;
	 	}
	 	$object->setActiveSheetIndex(0); 
	 	header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="PlantillaAsignacionTareas.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
    }

    function generarExcelEditar(){
    	$id_tarea=$_POST["txt_id_tarea"];
    	$BD=$_SESSION["BDSecundaria"];
    	$this->load->library('phpexcel');
		$this->load->model("ModuloPuntosVentas");	
		$this->load->model("ModuloTarea");	
		$objReader =  PHPExcel_IOFactory::createReader('Excel2007');
		$object = $objReader->load("doc/plantilla/PlantillaAsignacionTareas.xlsx");
		$objectUser = $objReader->load("doc/plantilla/PlantillaAsignacionTareas.xlsx");
		$object->setActiveSheetIndex(1); 
		$asignacion=$this->ModuloTarea->ListarAsignacionUsuarioLocal($BD,$id_tarea);
		$dataLocal = $this->ModuloPuntosVentas->listarLocales($BD);
		$dataUser = $this->ModuloTarea->listarUsuarios($BD);
		$column_row=2;
		$object->setActiveSheetIndex(0);
	 	foreach($asignacion as $rowA)
	 	{	 
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $rowA['Usuario']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $rowA['NombreLocal']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $rowA['Fecha_Inicio']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(3 , $column_row, $rowA['Fecha_Fin']);
	 		$column_row++;	 		
	 	}
	 	$column_row=1;
		$object->setActiveSheetIndex(1);
	 	foreach($dataLocal as $row)
	 	{	 
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['NombreLocal']);
	 		$column_row++;	 		
	 	}
	 	$column_row=1;
	 	$object->setActiveSheetIndex(2); 
	 	foreach ($dataUser as $rowU) {
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $rowU['Usuario']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $rowU['Nombres']);
	 		$column_row++;
	 	}
	 	$object->setActiveSheetIndex(0);
	 	header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="PlantillaAsignacionTareas.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
    }

    function editarTarea(){
    	$id_tarea=$_POST["idtarea"];
    	echo "<div class='modal-header'>
                    <h6 class='modal-title' >Editar Tarea</h6>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                </div>

                <div class='modal-body'>
                	<p class='text-theme'>Descargar Excel para editar</p>
                	<p><form method='POST' action='generarExcelEditar'>  
                		<input type='hidden' id='txt_id_tarea' name='txt_id_tarea' value='".$id_tarea."'>               
			            <button type='submit' class='btn btn-theme' title='Descargar Plantilla'><i class='mdi mdi-file-excel'></i> Descargar Plantilla</button>
			            </form></p>
                        <hr>
                    <p class='text-theme'>Ingresar Excel Editado</p>
                    <p>
                        <label for='street'>Recuerde ingresar el Excel descargado mas arribo para finalizar la edición.</label>
                        <form action='ActualizarTareaMasivo' method='POST' id='IngresarExcelTarea' name='IngresarExcelTarea' enctype='multipart/form-data'>
               			<div class='btn btn-theme' style='margin-bottom:20px;'><i class='mdi mdi-alarm-plus'></i><i id='ingresarExcelSpin' class=''></i> 
	                		<input type='hidden' id='txt_id_tarea' name='txt_id_tarea' value='".$id_tarea."'> 
	                			<input type='file' class='btn btn-xs btn-dark' id='excelv' name='excelv'>                    
	                		
                		</div>

                <div class='modal-footer'>
                    <button type='button' class='btn btn-theme' data-dismiss='modal'>Cerrar</button>
                    <button type='submit' class='btn btn-theme'>Guardar Cambios</button>
                </div></form>
                ";
    }

    function ActualizarTareaMasivo(){
    	$BD=$_SESSION["BDSecundaria"];
    	$id_tarea=$_POST["txt_id_tarea"];
    	$this->load->model("ModuloTarea");
		$this->load->library('phpexcel');
    	$excel=$this->limpiaEspacio($_FILES['excelv']['name']);
		$R=$this->subirArchivosE($excel,0,0);		
		$this->load->model("ModuloElemento"); 			
		$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
		$objReader = PHPExcel_IOFactory::createReader($tipo);
		$object = $objReader->load("archivos/archivos_Temp/".$excel);
		$object->setActiveSheetIndex(0);
		$defaultPrecision = ini_get('precision');
		ini_set('precision', $defaultPrecision);
		$error=0;
		$fila=2;
		$parametro=0;
		$contador=0;	
		$filaMaxima=$object->setActiveSheetIndex(0)->getHighestRow();
		while ($parametro==0) {
			if ($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue()==NULL) {
				$parametro=1;
			}else{
				$usuario[$contador]=$object->getActiveSheet()->getCell('A'.$fila)->getFormattedValue();			
				$usuarioLimpio=$this->limpiarComilla($usuario);
				$id_usuario[$contador]=$this->ModuloTarea->buscarIdUsuario($usuarioLimpio[$contador]);
			 	if($id_usuario[$contador]["id_usuario"]==null){
	 				$parametro=1;
	 				$error=9;
	 				break;
	 			}
				$local[$contador]=$object->getActiveSheet()->getCell('B'.$fila)->getFormattedValue();
				if ($local[$contador]=='') {
					$idLocal[$contador]["ID_Local"]=0;
				}else{
					$idLocal[$contador]=$this->ModuloElemento->BuscarIdLocal($local[$contador],$BD);
	 			if($idLocal[$contador]["ID_Local"]==null){
	 				$parametro=1;
	 				$error=10;
	 				break;	
	 				}
				}
				
	 			$fecha_inicio[$contador]=$object->getActiveSheet()->getCell('C'.$fila)->getFormattedValue();
	 			if ($fecha_inicio[$contador]!=null) {
	 				$fecha_inicio[$contador]=date('d/m/Y', strtotime($fecha_inicio[$contador]));
	 			}else{
	 				$fecha_inicio[$contador]==null;
	 				$parametro=1;
					$error=38;
	 			}
	 			
	 			$fecha_fin[$contador]=$object->getActiveSheet()->getCell('D'.$fila)->getFormattedValue();
	 			if ($fecha_fin[$contador]!=null) {
	 				$fecha_fin[$contador]=date('d/m/Y', strtotime($fecha_fin[$contador]));
	 			}else{
	 				$fecha_fin[$contador]==null;
	 			}
	 			$fila++;
				$contador++;
			}
		}
		$filaMaxima=$object->setActiveSheetIndex(0)->getHighestRow();
		if ($error==0) {
			$this->ModuloTarea->desactivarTarea($id_tarea,$BD);
			for ($i=0; $i <$contador; $i++) { 
				$cant=$this->ModuloTarea->EditarTarea($id_usuario[$i]["id_usuario"],$id_tarea,$fecha_inicio[$i],$idLocal[$i]["ID_Local"],$fecha_fin[$i],$BD);
			}
			$mens['tipo']=32;			
			$this->load->model('ModuloUsuario');
			$this->load->model("ModuloTarea");
			$BD=$_SESSION["BDSecundaria"];
			$cli=$_SESSION["Cliente"];
			$data["Cargo"]=$_SESSION["Cargo"];
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"]=$_SESSION["Perfil"];
			$data["Cliente"]=$_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Clientes"]=$this->funcion_login->elegirCliente();
			$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
			$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
			$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
			$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
			$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
			$this->load->view('contenido');
			$this->load->view('layout/header',$data);
			$this->load->view('layout/sidebar',$data);
			$this->load->view('admin/adminAsignarTarea',$data);
		   	$this->load->view('layout/footer',$data);
		   	$this->load->view('layout/mensajes',$mens);
		}else{
			$mens['tipo']=$error;
			$mens['cantidad']=($contador+1);
			$this->load->model('ModuloUsuario');
			$this->load->model("ModuloTarea");
			$BD=$_SESSION["BDSecundaria"];
			$cli=$_SESSION["Cliente"];
			$data["Cargo"]=$_SESSION["Cargo"];
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"]=$_SESSION["Perfil"];
			$data["Cliente"]=$_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Clientes"]=$this->funcion_login->elegirCliente();
			$data["ListaTarea"]=$this->ModuloTarea->listarTareaAsignacion($BD);
			$data["ListaTareaNoAsignada"]=$this->ModuloTarea->listarTareaAsignacionNoAsignada($BD);
			$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
			$data["Usuarios"]=$this->ModuloTarea->listarUsuarios($BD);
			$data["Locales"]=$this->ModuloTarea->cargarLocales($BD);
			$this->load->view('contenido');
			$this->load->view('layout/header',$data);
			$this->load->view('layout/sidebar',$data);
			$this->load->view('admin/adminAsignarTarea',$data);
		   	$this->load->view('layout/footer',$data);
		   	$this->load->view('layout/mensajes',$mens);
		}
    }

    function EditarForm(){
    	$this->load->model("ModuloTarea");
    	$id_tarea=$_POST["idtarea"];
    	$BD=$_SESSION["BDSecundaria"];
    	$tipo_tarea=$this->ModuloTarea->listarTareasID($BD,$id_tarea);
		if ($tipo_tarea["FK_ID_Tipo"]==1 || $tipo_tarea["FK_ID_Tipo"]==4) {
			$formu=$this->ModuloTarea->ListarFormularioPorTarea($BD,$id_tarea);
			$ListaFormularios=$this->ModuloTarea->cargarFormularios($BD);
			// var_dump($formu[0]["FK_ID_Tarea"]);exit();
	    	echo "<div class='modal-header'>
	                    <h6 class='modal-title' >Editar Formularios Asignados</h6>
	                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
	                </div>

	                <div class='modal-body'>
	                	<div class='card-body'>
	                		<form method='POST' id='FormEditarFormu'>
		                		<label for='street'>Nombre Tarea</label>
			                	<div class='input-group'>
				                    <span class='input-group-addon'>
				                        <i class='mdi mdi-content-paste'></i>
				                    </span>			               
				                <input type='text' class='form-control' id='txt_nombre_tarea' name='txt_nombre_tarea' value='".$formu[0]['NombreTarea']."'>
				                </div>   

				                <label for='company' style='padding-top:10px'>Formularios</label>
		                            <div class='input-group'>
		                                <span class='input-group-addon'><i class='mdi mdi-pencil'></i></span>
		                                    <select id='msltForm' class='form-control select2' data-plugin='select2' multiple  id='txt_formu[]' name='txt_formu[]' style='width: 100%;''>";  
		                                            foreach ($ListaFormularios as $lf) {
		                                                    echo "<option value='".$lf['ID_Formulario']."'";
		                                                    foreach ($formu as $l) {
							                            		if($l["FK_ID_Formulario"]==$lf["ID_Formulario"]){
							                            			echo " selected ";
							                            		}
							                            	}
							                            	echo ">".$lf['NombreFormulario']."</option>";    
		                                            	}
		                                     echo "</select> 
		                                     <input type='hidden' name='txt_id_tarea' id='txt_id_tarea' value='".$id_tarea."'>
		                            </div>	                            
	                        </form>
	                	</div>
	                </div>

	                <div class='modal-footer'>
	                    <button type='button' class='btn btn-secondary' data-dismiss='modal'><i class='fa fa-window-close-o'></i> Cerrar</button>
	                    <button type='submit' class='btn btn-danger' onclick='return ValidarEditarFormu();'><i class='fa fa-check-square-o'  id='botonAgregarFormu'></i> Editar Formularios Asignados</button>
	                </div>

					<script src='".site_url()."assets/libs/select2/dist/js/select2.min.js'></script>
	                <script type='text/javascript'>

	                	$('#msltForm').select2({});

	                	function ValidarEditarFormu(){ 
		                	if(validarEditarFormAsig()==false){
		                        alertify.error('Existen Campos Vacios');
		                        return false;
		                        }else{   					   
							         $.ajax({
							            url: 'EditarFormulario',
							            method: 'POST',
							            data: $('#FormEditarFormu').serialize(), 
							            success: function(data) {
							            	alertify.success('Formularios Editados');
							            	setTimeout(function(){
					                             window.location = 'asignarTarea';
					                    		 }, 1000); 
							            }
							        });
							    }
							}

						function validarEditarFormAsig(){
							var vacios=0;
	                        var valido=true;
	                        if($('#txt_nombre_tarea').val()==''){  
	                            $('#txt_nombre_tarea').attr('class', 'form-control is-invalid');
	                            alertify.error('El nombre de la tarea no puede quedar vacío'); 
	                            vacios+=1;
	                        } else { 
	                            $('#txt_nombre_tarea').attr('class', 'form-control is-valid');   
	                        }

	                        if(vacios>0){ valido=false; }
	                        return valido;
						}

	                </script>";
	            }
            if ($tipo_tarea["FK_ID_Tipo"]==3) {
            	$quiz=$this->ModuloTarea->ListarQuizPorTarea($BD,$id_tarea);
            	$ListaTrivias=$this->ModuloTarea->cargarTrivias($BD);
            	echo "<div class='modal-header'>
	                    <h6 class='modal-title' >Editar Trivias Asignadas</h6>
	                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
	                </div>

	                <div class='modal-body'>
	                	<div class='card-body'>
	                		<form method='POST' id='FormEditarTrivia'>
		                		<label for='street'>Nombre Tarea</label>
			                	<div class='input-group'>
				                    <span class='input-group-addon'>
				                        <i class='mdi mdi-content-paste'></i>
				                    </span>			               
				                <input type='text' class='form-control' id='txt_nombre_tarea' name='txt_nombre_tarea' value='".$quiz[0]['Nombre']."'>
				                </div>   

				                <label for='company' style='padding-top:10px'>Formularios</label>
		                            <div class='input-group'>
		                                <span class='input-group-addon'><i class='mdi mdi-pencil'></i></span>
		                                    <select id='msltQuiz' class='form-control select2' data-plugin='select2' multiple  id='txt_trivia[]' name='txt_trivia[]' style='width: 100%;''>";  
		                                            foreach ($ListaTrivias as $lt) {
		                                                    echo "<option value='".$lt['ID_Trivia']."'";
		                                                    foreach ($quiz as $q) {
							                            		if($q["FK_ID_Trivia"]==$lt["ID_Trivia"]){
							                            			echo " selected ";
							                            		}
							                            	}
							                            	echo ">".$lt['Nombre']."</option>";    
		                                            	}
		                                     echo "</select> 
		                                     <input type='hidden' name='txt_id_tarea' id='txt_id_tarea' value='".$id_tarea."'>
		                            </div>	                            
	                        </form>
	                	</div>
	                </div>

	                <div class='modal-footer'>
	                    <button type='button' class='btn btn-secondary' data-dismiss='modal'><i class='fa fa-window-close-o'></i> Cerrar</button>
	                    <button type='button' class='btn btn-danger' onclick='return ValidarEditarQuiz();'><i class='fa fa-check-square-o'  id='botonAgregarFormu'></i> Editar Trivias Asignadas</button>
	                </div>

					<script src='".site_url()."assets/libs/select2/dist/js/select2.min.js'></script>
	                <script type='text/javascript'>

	                	$('#msltQuiz').select2({});

	                	function ValidarEditarQuiz(){ 
		                	if(validarEditarQuizAsig()==false){
		                        alertify.error('Existen Campos Vacios');
		                        return false;
		                        }else{   					   
							         $.ajax({
							            url: 'EditarQuiz',
							            method: 'POST',
							            data: $('#FormEditarTrivia').serialize(), 
							            success: function(data) {
							            	alertify.success('Trivias Editadas');
							            	setTimeout(function(){
					                             window.location = 'asignarTarea';
					                    		 }, 1000); 
							            }
							        });
							    }
							}

						function validarEditarQuizAsig(){
							var vacios=0;
	                        var valido=true;
	                        if($('#txt_nombre_tarea').val()==''){  
	                            $('#txt_nombre_tarea').attr('class', 'form-control is-invalid');
	                            alertify.error('El nombre de la tarea no puede quedar vacío'); 
	                            vacios+=1;
	                        } else { 
	                            $('#txt_nombre_tarea').attr('class', 'form-control is-valid');   
	                        }

	                        if(vacios>0){ valido=false; }
	                        return valido;
						}

	                </script>";
            }
    }

    function EditarFormulario(){
    	$this->load->model("ModuloTarea");
    	$BD=$_SESSION["BDSecundaria"];
    	$id_tarea=$_POST["txt_id_tarea"];
    	$id_formularios=$_POST["txt_formu"];
    	$nombre_tarea=$_POST["txt_nombre_tarea"];
    	foreach ($id_formularios as $if) {
    		$this->ModuloTarea->DesactivarFormularioAsignado($BD,$id_tarea);
    	}
    	foreach ($id_formularios as $f) {
    		$this->ModuloTarea->EditarFormularioAsignado($BD,$id_tarea,$f,$nombre_tarea);
    	}
    }

    function EditarQuiz(){
    	$this->load->model("ModuloTarea");
    	$BD=$_SESSION["BDSecundaria"];
    	$id_tarea=$_POST["txt_id_tarea"];
    	$id_quiz=$_POST["txt_trivia"];
    	$nombre_tarea=$_POST["txt_nombre_tarea"];
    	foreach ($id_quiz as $iq) {
    		$this->ModuloTarea->DesactivarTriviaAsignada($BD,$id_tarea);
    	}
    	foreach ($id_quiz as $q) {
    		$this->ModuloTarea->EditarTriviaAsignada($BD,$id_tarea,$q,$nombre_tarea);
    	}
    }
}