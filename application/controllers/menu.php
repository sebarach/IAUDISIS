<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class menu extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("funcion_login");
	}
	
	

	function index(){
		if(isset($_SESSION["sesion"]))
		{
			
			if(isset($_SESSION["Cliente"]) && $_SESSION["Perfil"]!=3)
			{
				if($_SESSION["Perfil"]==4)
				{				
				   	redirect(site_url("Adm_ModuloReportes/listarLibroAsistenciaFiscalizador"));
				}
				else
				{
				   	$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Cargo"] = $_SESSION["Cargo"];
					$BD=$_SESSION["BDSecundaria"];
					$this->load->model("ModuloPuntosVentas");
					$this->load->model("ModuloDocumento");
					$this->load->model("ModuloUsuario");
					$this->load->model("ModuloElemento");
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["DashU"]= $this->funcion_login->ContadorUsuarios($BD);
					$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
					$data["DashL"]= $this->ModuloPuntosVentas->ContadoresLocalesDash($BD);
					$data["DashF"]= $this->ModuloPuntosVentas->ContadoresFormularioDash($BD);
					$data["DashT"]= $this->ModuloPuntosVentas->ContadoresTareaDash($BD);
					$data["JorLocales"]= $this->ModuloPuntosVentas->ListarJornadasporLocales($BD);
					$data["AsiLocales"]= $this->ModuloPuntosVentas->ListarAsistenciaporLocales($BD);
					$data["CantidadMarcada"]=count($data["AsiLocales"]);
					$data["CantidadElementos"]=$this->ModuloElemento->ListarElementosCategoria($BD);
					$data["CantidadElemento"]=count($data["CantidadElementos"]);
					$data["DesCarpetas"]= $this->ModuloDocumento->ListarDescargaCarpeta($BD);
					$data["DesUsuarios"]= $this->ModuloDocumento->ListarDescargaUsuario($BD);
					$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
					$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
					// var_dump($data["DesCarpetas"][0]);exit();
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
				   	$this->load->view('admin/paginaBase',$data);
				   	$this->load->view('layout/footer',$data);
				}
			}
			elseif($_SESSION["Perfil"]==3)
			{
			        $this->load->model("ModuloUsuarioApp");
			        $this->load->model("ModuloJornadas");                   
			        $data["Nombre"]=$_SESSION["Nombre"];
			        $data["Perfil"] = $_SESSION["Perfil"];
			        $data["Cargo"] = $_SESSION["Cargo"];            
			        $dia=date("j");//dia actual php ini
			        $mes=date("m");//mes actual php ini
			        $anio=date("Y");//año actual php ini
			        $data['hora']=date("h:i A");//hora am/pm actual php ini
			        $idUser=$_SESSION["Usuario"];
			        $BD=$_SESSION["BDSecundaria"];
			        $msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
					if(isset($_SESSION["Cliente"]))
					{
						if($_SESSION["Cliente"]=='9')
						{
			        		$validarQuiebre=$this->ModuloUsuarioApp->QuiebresProductosUsuario($idUser,'  AND CONVERT(date,Fecha_Registro)=CONVERT(date,GETDATE())  ',$BD);			
			        		if(isset($validarQuiebre) && !empty($validarQuiebre)){ $data["TieneQuiebres"]="1"; }else{ $data["TieneQuiebres"]="0"; }
						}
						else
						{
			        		$data["TieneQuiebres"]="0";
			        	}
					}
					else
					{
			        	$data["TieneQuiebres"]="0";
			        }		        
			        $data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
			        $data["cantidadMsj"]=count($data["mensaje"]);
			        $data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
			        $data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
			        $data["info"]=$this->ModuloUsuarioApp->InfoUsuario($idUser);			        
					$this->load->view('contenido');
          			$this->load->view('layout/headerApp',$data);
            		$this->load->view('layout/sidebarApp',$data);
            		$this->load->view('App/BaseAppMenu',$data);
            		$this->load->view('layout/footerApp',$data);        
			}
			else
			{		
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->view('contenido');
				$this->load->view('admin/adminElegirCliente',$data);
			}			
		} 
		else 
		{
			if(isset($_POST["txt_usuario"]) && isset($_POST["txt_contra"]))
			{
				$usuario=$this->limpiarLogin($_POST["txt_usuario"]);
				$contra=openssl_encrypt($_POST["txt_contra"],"AES-128-ECB","12314");
				$login=$this->funcion_login->Login2($usuario,$contra);
				$modulo=array();

				if($login != 0)
				{ 
					$pais= $login["Pais"];
					$nombre=$login["Nombre"];	
					$usuario=$login["ID_Usuario"];
					$perfil=$login["Perfil"];
					$cliente=$login["Cliente"];
					$cargo=$login["Cargo"];
					$nombreCliente=$login["NombreCliente"];
					if(isset($login["NombreBD"])){
						$NombreBD=$login["NombreBD"];
					}
					//creacion de sesiones
						$_SESSION["sesion"]=true;
						$_SESSION["Nombre"]=strtoupper($nombre);
						$_SESSION["Usuario"]=$usuario;
						$_SESSION["Perfil"]=$perfil;
						$_SESSION["BDPrincipal"]="default";
						$_SESSION["NombreCliente"]=$nombreCliente;
						$_SESSION["Cargo"]=$cargo;
						$_SESSION["pais"] = $pais;
						if($perfil==1 || $perfil==4){
							$data["Usuario"]=$_SESSION["Usuario"];					
							$data["Nombre"]=$_SESSION["Nombre"];
							$data["Perfil"] = $_SESSION["Perfil"];
							$data["Cargo"] = $_SESSION["Cargo"];
							$data["Clientes"]= $this->funcion_login->elegirCliente(); 
							$this->load->view('contenido');
							 //$this->load->view('layout/header',$data);
							 //$this->load->view('layout/sidebarApp',$data);
							$this->load->view('admin/adminElegirCliente',$data);
							 //$this->load->view('layout/footer',$data);
					} 
					elseif ($perfil==3)
					{
						$_SESSION["BDSecundaria"]= $NombreBD;
				        $this->load->model("ModuloAsistencia");                   
		        		$this->load->model("ModuloJornadas");
			        	$this->load->model("ModuloDocumento");
			        	$this->load->model("ModuloUsuarioApp");
				        $data["Nombre"]=$_SESSION["Nombre"];
				        $data["Perfil"] = $_SESSION["Perfil"];
				        $data["Cargo"] = $_SESSION["Cargo"];
				        $_SESSION["Cliente"]=$cliente;	            
				        $dia=date("j");//dia actual php ini
				        $mes=date("m");//mes actual php ini
				        $anio=date("Y");//año actual php ini
				        $data['hora']=date("h:i A");//hora am/pm actual php ini
				        $idUser=$_SESSION["Usuario"];
				        $BD=$_SESSION["BDSecundaria"];
				        $msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
						if(isset($_SESSION["Cliente"]))
						{
							if($_SESSION["Cliente"]=='9')
							{
				        		$validarQuiebre=$this->ModuloUsuarioApp->QuiebresProductosUsuario($idUser,'  AND CONVERT(date,Fecha_Registro)=CONVERT(date,GETDATE())  ',$BD);			
				        		if(isset($validarQuiebre) && !empty($validarQuiebre)){ $data["TieneQuiebres"]="1"; }else{ $data["TieneQuiebres"]="0"; }
							}
							else
							{
				        		$data["TieneQuiebres"]="0";
				        	}
						}
						else
						{
				        	$data["TieneQuiebres"]="0";
				        }
				        $data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				        $data["cantidadMsj"]=count($data["mensaje"]);
				        $data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
				        $data["colacion"]=$this->ModuloAsistencia->BuscarColaciones($BD,$idUser);
				        $data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
				        $data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
						$this->load->view('contenido');
	          			$this->load->view('layout/headerApp',$data);
	            		$this->load->view('layout/sidebarApp',$data);
	            		$this->load->view('App/BaseAppMenu',$data);
	            		$this->load->view('layout/footerApp',$data);  
					}
					else
					{
						$_SESSION["BDSecundaria"]= $NombreBD;
						$_SESSION["Cliente"]=$cliente;	
						$_SESSION["NombreCliente"]=$nombreCliente;
						$data["Usuario"]=$_SESSION["Usuario"];			
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["Cargo"] = $_SESSION["Cargo"];
						$BD=$_SESSION["BDSecundaria"];
						$this->load->model("ModuloPuntosVentas");
						$this->load->model("ModuloUsuario");
						$this->load->model("ModuloElemento");
						$this->load->model("ModuloDocumento");
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$data["DashU"]= $this->funcion_login->ContadorUsuarios($BD);
						$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
						$data["DashL"]= $this->ModuloPuntosVentas->ContadoresLocalesDash($BD);
						$data["DashF"]= $this->ModuloPuntosVentas->ContadoresFormularioDash($BD);
						$data["DashT"]= $this->ModuloPuntosVentas->ContadoresTareaDash($BD);
						$data["JorLocales"]= $this->ModuloPuntosVentas->ListarJornadasporLocales($BD);
						$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
						$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
						$data["AsiLocales"]= $this->ModuloPuntosVentas->ListarAsistenciaporLocales($BD);
						$data["CantidadMarcada"]=count($data["AsiLocales"]);
						$data["CantidadElementos"]=$this->ModuloElemento->ListarElementosCategoria($BD);
						$data["CantidadElemento"]=count($data["CantidadElementos"]);
						$data["DesCarpetas"]= $this->ModuloDocumento->ListarDescargaCarpeta($BD);
						$data["DesUsuarios"]= $this->ModuloDocumento->ListarDescargaUsuario($BD);
						$this->load->view('contenido');
						$this->load->view('layout/header',$data);
			   			$this->load->view('layout/sidebar',$data);
					   	$this->load->view('admin/paginaBase',$data);
					   	$this->load->view('layout/footer',$data);
					}					
				} 
				else 
				{
					echo "<script>alert('usuario y/o contraseña incorrectos, ingrese nuevamente'); 
					window.location.href='login'</script>";
				}
			}
			else 
			{
				//die("asad");
				redirect(site_url("login/inicio"));
				//redirect(site_url("menu"));
			   
			}
			
		}

		
		
	}
	function elegirCliente()
	{
		
		if(isset($_POST["txtidCliente"]))
		{			
			//die("aca");
			$idCliente=$_POST["txtidCliente"];
			$nombreBD=$_POST["txt_nombreBD"];
			$NombreCliente=$_POST["txt_nombreCliente"];
			$_SESSION["BDSecundaria"]= $nombreBD;
			$_SESSION["Cliente"]=$idCliente;
			$_SESSION["NombreCliente"]=$NombreCliente;			
			redirect(site_url("menu"));

		}
		elseif(isset($_GET["txcit"]))
		{
			unset($_SESSION["BDSecundaria"]);
			unset($_SESSION["Cliente"]);
			unset($_SESSION["NombreCliente"]);
			$idCliente=base64_decode($_GET["txcit"]);
			$nombreBD=base64_decode($_GET["txdnbt"]);
			$NombreCliente=base64_decode($_GET["txnclt"]);
			$_SESSION["BDSecundaria"]= $nombreBD;
			$_SESSION["Cliente"]=$idCliente;
			$_SESSION["NombreCliente"]=$NombreCliente;
			redirect(site_url("menu"));	
		}
		else
		{
			redirect(site_url("menu"));
		}
	}
	Public function limpiarLogin($parametro){
		$patron = "/[' ']/i";
		$nuevo_dato = preg_replace($patron,"", $parametro);
		return $nuevo_dato; 
	}
}
?>