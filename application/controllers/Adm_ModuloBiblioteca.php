<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloBiblioteca extends CI_Controller {
	public function __construct(){

		parent::__construct();
		$this->load->model("funcion_login");
		$this->load->library('upload');
	}

	function adminDocumentos(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				$this->load->model("ModuloDocumento");
				$this->load->model('ModuloUsuario');
				$BD=$_SESSION["BDSecundaria"];
				$cli=$_SESSION["Cliente"];
				$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
				$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetas($BD);
				$this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			    $this->load->view('layout/sidebar',$data);
			    $this->load->view('admin/adminBiblioteca',$data);
			    $this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login"));
			}
		}
	}

	function subirDocumento(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				$tipo=$_FILES['txt_doc']['name'];
				$ext = pathinfo($tipo, PATHINFO_EXTENSION);
				$this->load->model("ModuloDocumento");	
				$BD=$_SESSION["BDSecundaria"];
				$cliente=$_SESSION["NombreCliente"];
				$descripcion=$_POST["txt_desc_doc"];
				$creador=$_SESSION['Usuario'];
				$nombreDoc=$_POST["txt_nombre_doc"];
				$formato=$_POST["lb_formato"];
				$enlace=$_POST["txt_link"];		
				$directoryName='archivos/'.$cliente.'/';
				
				if ($_POST["txt_nombre_carpeta"]=="") {
					if ($enlace!="") {
						$carpeta=$this->eliminar_tildes($_POST["lb_carpeta"]);
						$this->ModuloDocumento->insertarEnlaceExterno($BD,$creador,$carpeta,null,$enlace,$nombreDoc,$descripcion,null,1);
						$this->load->model("ModuloDocumento");
						$this->load->model('ModuloUsuario');
						$BD=$_SESSION["BDSecundaria"];
						$mens['tipo'] = 22;
						$cli=$_SESSION["Cliente"];
						$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
						$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["Cargo"] = $_SESSION["Cargo"];
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetas($BD);
						$this->load->view('contenido');
					    $this->load->view('layout/header',$data);
					    $this->load->view('layout/sidebar',$data);
					    $this->load->view('admin/adminBiblioteca',$data);
					    $this->load->view('layout/footer',$data);
					    $this->load->view('layout/mensajes',$mens);
					}else{
						$carpeta=$this->eliminar_tildes($_POST["lb_carpeta"]);
						$nombreCarpeta=$this->eliminar_tildes($this->ModuloDocumento->buscarCarpetaPorID($BD,$carpeta));
						$file=$this->eliminar_tildes($this->limpiaEspacio($_FILES['txt_doc']['name']));

						
						$R=$this->subirArchivos($file,$cliente,$nombreCarpeta["Nombre_Carpeta"]);
						$this->ModuloDocumento->insertarEnlaceExterno($BD,$creador,$carpeta,$file,null,$nombreDoc,$descripcion,$ext,0);
						$this->load->model("ModuloDocumento");
						$this->load->model('ModuloUsuario');
						$BD=$_SESSION["BDSecundaria"];
						$mens['tipo'] = 23;
						$cli=$_SESSION["Cliente"];
						$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
						$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
						$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["Cargo"] = $_SESSION["Cargo"];
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetas($BD);
						$this->load->view('contenido');
					    $this->load->view('layout/header',$data);
					    $this->load->view('layout/sidebar',$data);
					    $this->load->view('admin/adminBiblioteca',$data);
					    $this->load->view('layout/footer',$data);
					    $this->load->view('layout/mensajes',$mens);
					}
				}else{
					
					$nombreCarpeta=$this->eliminar_tildes($cliente.'/'.$_POST["txt_nombre_carpeta"]);
					$existe=$this->ModuloDocumento->validarCarpeta($BD,$nombreCarpeta);
					
					if ($existe["existe"]==1) {
						
						$this->load->model("ModuloDocumento");
						$this->load->model('ModuloUsuario');
						$BD=$_SESSION["BDSecundaria"];
						$mens['tipo'] = 21;
						$cli=$_SESSION["Cliente"];
						$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
						$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
						$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["Cargo"] = $_SESSION["Cargo"];
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetas($BD);
						$this->load->view('contenido');
					    $this->load->view('layout/header',$data);
					    $this->load->view('layout/sidebar',$data);
					    $this->load->view('admin/adminBiblioteca',$data);
					    $this->load->view('layout/footer',$data);
					    $this->load->view('layout/mensajes',$mens);
					}else{
					
						$nombreCarpeta=$this->eliminar_tildes($_POST["txt_nombre_carpeta"]);
						$carpeta[1]['ID']=$this->ModuloDocumento->crearCarpeta($BD,$nombreCarpeta,$creador);	
						$carpeta=implode($carpeta[1]['ID']);
						if (!file_exists($directoryName.$nombreCarpeta)) {
							mkdir($directoryName.$nombreCarpeta, 0777, true);	
						}
						if ($enlace!="") {
							
							$this->ModuloDocumento->insertarEnlaceExterno($BD,$creador,$carpeta,null,$enlace,$nombreDoc,$descripcion,null,1);
							$this->load->model("ModuloDocumento");
							$this->load->model('ModuloUsuario');
							$BD=$_SESSION["BDSecundaria"];
							$mens['tipo'] = 22;
							$cli=$_SESSION["Cliente"];
							$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
							$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
							$data["Usuario"]=$_SESSION["Usuario"];					
							$data["Nombre"]=$_SESSION["Nombre"];
							$data["Perfil"] = $_SESSION["Perfil"];
							$data["Cliente"] = $_SESSION["Cliente"];
							$data["NombreCliente"]=$_SESSION["NombreCliente"];
							$data["Cargo"] = $_SESSION["Cargo"];
							$data["Clientes"]= $this->funcion_login->elegirCliente();
							$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetas($BD);
							$this->load->view('contenido');
						    $this->load->view('layout/header',$data);
						    $this->load->view('layout/sidebar',$data);
						    $this->load->view('admin/adminBiblioteca',$data);
						    $this->load->view('layout/footer',$data);
						    $this->load->view('layout/mensajes',$mens);
						}else{
						
							$file=$this->eliminar_tildes($this->limpiaEspacio($_FILES['txt_doc']['name']));	
							
							$R=$this->subirArchivos($file,$cliente,$nombreCarpeta);
							$this->ModuloDocumento->insertarEnlaceExterno($BD,$creador,$carpeta,$file,null,$nombreDoc,$descripcion,$ext,0);
							$this->load->model("ModuloDocumento");
							$this->load->model('ModuloUsuario');
							$BD=$_SESSION["BDSecundaria"];
							$mens['tipo'] = 23;
							$cli=$_SESSION["Cliente"];
							$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
							$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
							$data["Usuario"]=$_SESSION["Usuario"];					
							$data["Nombre"]=$_SESSION["Nombre"];
							$data["Perfil"] = $_SESSION["Perfil"];
							$data["Cliente"] = $_SESSION["Cliente"];
							$data["NombreCliente"]=$_SESSION["NombreCliente"];
							$data["Cargo"] = $_SESSION["Cargo"];
							$data["Clientes"]= $this->funcion_login->elegirCliente();
							$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetas($BD);
							$this->load->view('contenido');
						    $this->load->view('layout/header',$data);
						    $this->load->view('layout/sidebar',$data);
						    $this->load->view('admin/adminBiblioteca',$data);
						    $this->load->view('layout/footer',$data);
						    $this->load->view('layout/mensajes',$mens);
						}					
					}
				}
			}
		}
	}

	function limpiaEspacio($var){
    	$patron = "/[' ']/i";
		$cadena_nueva = preg_replace($patron,"",$var);
		return $cadena_nueva; 
 	}

 	public function subirArchivos($filename,$nombreCarpeta,$cliente){
 		
		$archivo ='txt_doc';
		$config['upload_path'] = "archivos/".$nombreCarpeta.'/'.$cliente;
		// var_dump($config['upload_path']);exit();
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

	function documentosCarpeta(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				$this->load->model("ModuloDocumento");
				$BD=$_SESSION["BDSecundaria"];
				$id_carpeta=$_POST["txt_carpeta"];
				$data["Nombre_Carpeta"]=$_POST["txt_carpeta_name"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetas($BD);
				$data["Archivos"]=$this->ModuloDocumento->cargarArchivos($BD,$id_carpeta);
				$this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			    $this->load->view('layout/sidebar',$data);
			    $this->load->view('admin/adminDocumentos',$data);
			    $this->load->view('layout/footer',$data);
			}
		}else{
			redirect(site_url("admin/adminDocumentos"));
		}
	}

	function eliminarArchivo(){	
		$id_archivo=$_POST["id_archivo"];
		$nombre=$_POST["nombre"];
		echo "<div class='modal-header bg-danger'>
                    <h6 class='modal-title text-white'>Eliminar Archivo</h6>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
              </div>
	        		<div class='card-body'>
	        			<form id='mFrmEliminarArchivo' method='POST'>
	        				<input type='hidden' name='txt_id_arc' id='txt_id_arc' value='".$id_archivo."'>
	        					¿Esta Seguro que desea eliminar el archivo ".$nombre."?
	        			</form>
	        		</div>
              <div class='modal-footer'>
	              	<button type='button' class='btn btn-sm btn-danger' data-dismiss='modal'> Cancelar</button>
	                <button type='button' class='btn btn-sm btn-danger' onclick='return eliminarArchivo();' ><i id='icEliminarArchivo'  class=''></i> Eliminar Archivo</button>
              </div>

              <script type='text/javascript'>

                     function eliminarArchivo(){
                        $('#icEliminarArchivo').attr('class','fa fa-spin fa-circle-o-notch');
                        $.ajax({                        
                           type: 'POST',                 
                           url:'EliminarArchivoF',                     
                           data: $('#mFrmEliminarArchivo').serialize(), 
                           success: function(data)             
                           {                                      
                             alertify.success('Archivo Eliminado');                          
                             $('#MEliminarArchivos').modal('hide');
                             setTimeout(function(){
                             window.location = 'adminDocumentos';
                    		 }, 1000); 
                           }       
                       });
                    }
               </script>

              ";
		
	}

	function EliminarArchivoF(){
		$BD=$_SESSION["BDSecundaria"];
		$id_archivo=$_POST["txt_id_arc"];
		$this->load->model("ModuloDocumento");
		$this->ModuloDocumento->eliminarDocumento($BD,$id_archivo);
	}

	function asignarCarpetas(){
		if (isset($_POST["txt_asignacionUser"])) {
			$this->load->model("ModuloDocumento");
			$this->load->model('ModuloUsuario');
			$BD=$_SESSION["BDSecundaria"];
			$creador=$_SESSION['Usuario'];
			$id_carpetas=$_POST["lb_carpeta_asignacion"];
			$id_usuarios=$_POST["txt_asignacionUser"];
			foreach ($id_usuarios as $u) {
				$validarAsignacion=$this->ModuloDocumento->validarAsignacionCarpeta($u,$id_carpetas,$BD);
				}
				// var_dump($validarAsignacion["existe"]);exit();
				if ($validarAsignacion["existe"]==0) {
					foreach ($id_usuarios as $u) {
						$ingresos=$this->ModuloDocumento->asignarCarpetas($u,$id_carpetas,$creador,$BD);
						}
					$this->load->model("ModuloDocumento");
					$this->load->model('ModuloUsuario');
					$BD=$_SESSION["BDSecundaria"];
					$mens['tipo'] = 25;
					$cli=$_SESSION["Cliente"];
					$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
					$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Cargo"] = $_SESSION["Cargo"];
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetas($BD);
					$this->load->view('contenido');
				    $this->load->view('layout/header',$data);
				    $this->load->view('layout/sidebar',$data);
				    $this->load->view('admin/adminBiblioteca',$data);
				    $this->load->view('layout/footer',$data);
				    $this->load->view('layout/mensajes',$mens);
				}else{
					$BD=$_SESSION["BDSecundaria"];
					$mens['tipo'] = 27;
					$cli=$_SESSION["Cliente"];
					$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
					$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Cargo"] = $_SESSION["Cargo"];
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetas($BD);
					$this->load->view('contenido');
				    $this->load->view('layout/header',$data);
				    $this->load->view('layout/sidebar',$data);
				    $this->load->view('admin/adminBiblioteca',$data);
				    $this->load->view('layout/footer',$data);
				    $this->load->view('layout/mensajes',$mens);
				}
			}else{
			
			$this->load->model("ModuloDocumento");
			$BD=$_SESSION["BDSecundaria"];
			$creador=$_SESSION['Usuario'];
			$id_carpetas=$_POST["lb_carpeta_asignacion"];
			$id_usuariosGrupo=$_POST["txt_asignacionUserGrupo"];
			$contador=0;
			$contadorG=0;
			$contadorC=0;

			for ($i=0; $i < sizeof($id_usuariosGrupo); $i++) { 
				$usuarios[$contador]=$this->ModuloDocumento->buscarUsuariosporGrupoUsuarios($id_usuariosGrupo[$i],$BD);
				$contador++;
			}

			for ($i=0; $i < sizeof($id_usuariosGrupo); $i++){ 
				for ($f=0; $f < sizeof($usuarios[$i]); $f++){ 
					$ingresos=$this->ModuloDocumento->asignarCarpetas($usuarios[$i][$f]["FK_Usuarios_ID_Usuario"],$id_carpetas,$creador,$BD);
				}
			}


			
			$this->load->model("ModuloDocumento");
			$this->load->model('ModuloUsuario');
			$BD=$_SESSION["BDSecundaria"];
			$mens['tipo'] = 26;
			$cli=$_SESSION["Cliente"];
			$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
			$data["UsuariosMovil"]=$this->ModuloUsuario->ListarUsuariosMoviles($BD,$cli);
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"] = $_SESSION["Perfil"];
			$data["Cliente"] = $_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Cargo"] = $_SESSION["Cargo"];
			$data["Clientes"]= $this->funcion_login->elegirCliente();
			$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetas($BD);
			$this->load->view('contenido');
		    $this->load->view('layout/header',$data);
		    $this->load->view('layout/sidebar',$data);
		    $this->load->view('admin/adminBiblioteca',$data);
		    $this->load->view('layout/footer',$data);
		    $this->load->view('layout/mensajes',$mens);
		}	
	}

	function eliminar_tildes($cadena){

	    $cadena = str_replace(
	        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
	        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	        $cadena
	    );
 
	    $cadena = str_replace(
	        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
	        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	        $cadena );
	 
	    $cadena = str_replace(
	        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
	        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	        $cadena );
	 
	    $cadena = str_replace(
	        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
	        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	        $cadena );
	 
	    $cadena = str_replace(
	        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
	        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	        $cadena );
	 
	    $cadena = str_replace(
	        array('ñ', 'Ñ', 'ç', 'Ç'),
	        array('n', 'N', 'c', 'C'),
	        $cadena
	    );
	    return $cadena;
	}
}