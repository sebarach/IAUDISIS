<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloCliente extends CI_Controller {
	public function __construct(){

		parent::__construct();
		$this->load->helper("url","form");	
		$this->load->library('form_validation'); 	
		$this->load->model("funcion_login");
		$this->load->library('upload');
	}


	function homeAdmin(){
		if($_SESSION['Perfil']==2 || $_SESSION['Perfil']==1){ 
	   		$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"] = $_SESSION["Perfil"];
			$data["Cliente"] = $_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["ID_Modulo"] = $_SESSION["ID_Modulo"];
			$data["Cargo"] = $_SESSION["Cargo"];
			$data["Clientes"]= $this->funcion_login->elegirCliente();
		    $this->load->view('contenido');
		    $this->load->view('layout/header',$data);
		    $this->load->view('layout/sidebar',$data);
		    $this->load->view('admin/HomeAdmin',$data);
		    $this->load->view('layout/footer',$data);
	    }else{
		   redirect(site_url("login"));
		}
	}

	function Clientes(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				// variables de sesion
		   		$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->model("ModuloCliente");
				$data["ListarEmpresa"]=$this->ModuloCliente->ListarEmpresaActivas();
				$data["ListarPaises"]=$this->ModuloCliente->ListarPaises();
				//vistas
			    $this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			    $this->load->view('layout/sidebar',$data);
			    $this->load->view('admin/adminCrearCliente',$data);
			    $this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}


	function AdministracionClientes(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				// variables de sesion
		   		$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->model("ModuloCliente");
				$data["ListarEmpresa"]=$this->ModuloCliente->ListarEmpresa();
				$data["ListarCliente"]=$this->ModuloCliente->ListarCliente();
				//vistas
			    $this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			    $this->load->view('layout/sidebar',$data);
			    $this->load->view('admin/adminCliente',$data);
			    $this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));
			}
		}else{
			redirect(site_url("login/inicio"));	
		}

	}


	function CrearEmpresa(){
		$NombreEmpresa=$this->limpiarComilla($_POST['txtNombreEmpresa']);
		$RazonSocial=$this->limpiarComilla($_POST['txtRazonSocial']);
		$RutEmpresaSL=$this->limpiarComilla($_POST['txtRutEmpresa']);
		$id_creador=$_SESSION['Usuario'];
		$RutEmpresaSV=$this->limpiarRut($this->limpiarComilla($RutEmpresaSL));

		$this->load->model("ModuloCliente");
		$exisite=$this->ModuloCliente->ValidarEmpresa($RutEmpresaSV);
		if ($exisite!=1) {
			
			$validador=$this->validaRut($RutEmpresaSV);
			if ($validador==true) {
				
				echo 0;
				$this->ModuloCliente->crearEmpresa($NombreEmpresa,$RazonSocial,$RutEmpresaSV,$id_creador);
				
			}else{
				//mail
				echo 2;
			}
		}else{
			//nombre
			echo 1;
		}
		
	}	

		function CrearCliente(){
			$idEmpresa=$this->limpiarComilla($_POST['sltEmpresa']);
			$NombreCliente=$this->limpiarComilla($_POST['txtNombreCliente']);
			$MailEmpresa=$this->limpiarComilla($_POST['txtMailEmpresa']);
			$idPais=$this->limpiarComilla($_POST['sltPaises']);
			$id_creador=$_SESSION['Usuario'];
			$this->load->model("ModuloCliente");
			$exisite=$this->ModuloCliente->ValidarClienteEmpresa($idEmpresa,$NombreCliente);
			if ($exisite!=1) 
			{
				$vemail=$this->validarEmail($MailEmpresa);
				if ($vemail==true) 
				{
					if ($_FILES["tx_foto"]["name"]!="") {
					$tipo=str_replace("image/",".",$_FILES['tx_foto']['type']);
				  	$direction ='archivos/foto_Cliente/logo_I-Audisis_'.$_POST['txtNombreCliente'].$tipo;
				  	$max_ancho = 200;
					$max_alto = 200;
					$rtOriginal=$_FILES["tx_foto"]['tmp_name'];
					if($_FILES['tx_foto']['type']=='image/jpeg'){
						$original = imagecreatefromjpeg($rtOriginal);
					} else if($_FILES['tx_foto']['type']=='image/png'){
						$original = imagecreatefrompng($rtOriginal);
					} else if($_FILES['tx_foto']['type']=='image/gif'){
						$original = imagecreatefromgif($rtOriginal);
					}	else if($_FILES['tx_foto']['type']=='image/jpg'){
						$original = imagecreatefromjpeg($rtOriginal);
					}
					list($ancho,$alto)=getimagesize($rtOriginal);
					$x_ratio = $max_ancho / $ancho;
					$y_ratio = $max_alto / $alto;
					if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
						$ancho_final = $ancho;
						$alto_final = $alto;
					} else if (($x_ratio * $alto) < $max_alto){
						$alto_final = ceil($x_ratio * $alto);
						$ancho_final = $max_ancho;
					} else {
						$ancho_final = ceil($y_ratio * $ancho);
						$alto_final = $max_alto;
					}
					$lienzo=imagecreatetruecolor($ancho_final,$alto_final); 
					imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
					$cal=8;
					if($_FILES['tx_foto']['type']=='image/jpeg'){
						imagejpeg($lienzo,$direction);
					} else if($_FILES['tx_foto']['type']=='image/png'){
						imagepng($lienzo,$direction);
					} else if($_FILES['tx_foto']['type']=='image/gif'){
						imagegif($lienzo,$direction);
					} else if($_FILES['tx_foto']['type']=='image/jpg'){
						imagejpeg($lienzo,$direction);
					}
					}
					else
					{
						$direction="";
					}	
					echo "OP0";	
					$this->ModuloCliente->crearCliente($NombreCliente,$MailEmpresa,$idEmpresa,$id_creador,$direction,$idPais);
				}
				else
				{
					//Mail
					echo "OP2";
				}
			}
			else
			{
				//Nombre
				echo "OP1";
			}
		}

		public function subirFotoCliente($foto){
		$archivo ='foto';
		$config['upload_path'] = "archivos/archivos_Temp/FotoCliente";	
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

		function EditarClienteF(){
			$hidCliente=$this->limpiarComilla($_POST['hidCliente']);
			$idEmpresa=$_POST['msltEmpresa'];
			$MailEmpresa=$this->limpiarComilla($_POST['mtxtEmailCliente']);
			$NombreCliente=$this->limpiarComilla($_POST['mtxtNombreCliente']);
			$paisCliente =$this->limpiarComilla($_POST['msltPais']);
			$id_creador=$_SESSION['Usuario'];
			$this->load->model("ModuloCliente");
			$nombreClienteEmpresa = $this->ModuloCliente->ListarClienteXid($_POST['hidCliente']);
			if(isset($_FILES['tx_foto']["name"])){
				if($_FILES['tx_foto']["name"]!=''){
					var_dump($_FILES['tx_foto']);exit;
					$tipo=str_replace("image/",".",$_FILES['tx_foto']['type']);
				  	$direction ='archivos/foto_Cliente/logo_'.$id_creador.$tipo;
				  	$max_ancho = 800;
					$max_alto = 600;
					$rtOriginal=$_FILES["tx_foto"]['tmp_name'];
					if($_FILES['tx_foto']['type']=='image/jpeg'){
						$original = imagecreatefromjpeg($rtOriginal);
					} else if($_FILES['tx_foto']['type']=='image/png'){
						$original = imagecreatefrompng($rtOriginal);
					} else if($_FILES['tx_foto']['type']=='image/gif'){
						$original = imagecreatefromgif($rtOriginal);
					}	else if($_FILES['tx_foto']['type']=='image/jpg'){
						$original = imagecreatefromjpeg($rtOriginal);
					}
					list($ancho,$alto)=getimagesize($rtOriginal);
					$x_ratio = $max_ancho / $ancho;
					$y_ratio = $max_alto / $alto;
					if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
						$ancho_final = $ancho;
						$alto_final = $alto;
					} else if (($x_ratio * $alto) < $max_alto){
						$alto_final = ceil($x_ratio * $alto);
						$ancho_final = $max_ancho;
					} else {
						$ancho_final = ceil($y_ratio * $ancho);
						$alto_final = $max_alto;
					}
					$lienzo=imagecreatetruecolor($ancho_final,$alto_final); 
					imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
					$cal=8;
					if($_FILES['tx_foto']['type']=='image/jpeg')
					{
						imagejpeg($lienzo,$direction);
					} 
					else if($_FILES['tx_foto']['type']=='image/png')
					{
						imagepng($lienzo,$direction);
					} 
					else if($_FILES['tx_foto']['type']=='image/gif')
					{
						imagegif($lienzo,$direction);
					} 
					else if($_FILES['tx_foto']['type']=='image/jpg')
					{
						iimagejpeg($lienzo,$direction);
					}	
				}
				else
				{
					if(isset($_POST["tx_fotoAntigua"]))
					{
						$direction=$_POST["tx_fotoAntigua"];
					}
					else
					{
						$direction='';
					}
				}
			}
			else
			{
				if(isset($_POST["tx_fotoAntigua"]))
				{
					$direction=$_POST["tx_fotoAntigua"];
				}
				else
				{
					$direction='';
				}
			}
			
			$exisite = $this->ModuloCliente->ValidarClienteEmpresa($idEmpresa, $NombreCliente);
			$vemail = $this->validarEmail($MailEmpresa);
			if ($NombreCliente != $nombreClienteEmpresa['Nombre']) {
			    if ($exisite == 1) {
			        echo 1;

			    } else if ($vemail != true) {
			        echo 2;
			    } else {
			        echo 0;
			        $_SESSION['pais'] = $paisCliente;
			        $this->ModuloCliente->EditarCliente($NombreCliente, $MailEmpresa, $idEmpresa, $id_creador, $hidCliente, $direction, $paisCliente);
			    }
			} else if ($vemail != true) {
			    echo 2;
			} else {
			    echo 0;
			    $_SESSION['pais'] = $paisCliente;
			    $this->ModuloCliente->EditarCliente($NombreCliente, $MailEmpresa, $idEmpresa, $id_creador, $hidCliente, $direction, $paisCliente);
			}
}

		function EditarEmpresaF(){
			$this->load->model("ModuloCliente");
			$NombreEmpresa=$this->limpiarComilla($_POST['mtxtNombreEmpresa']);
			$RazonSocial=$this->limpiarComilla($_POST['mtxtRazonSocial']);
			$RutEmpresa=$_POST['hRutEmpresa'];
			$id_creador=$_SESSION['Usuario'];
			echo 0;
			// var_dump($NombreEmpresa,$RazonSocial,$RutEmpresaSV);exit;
			$this->ModuloCliente->EditarEmpresa($NombreEmpresa,$RazonSocial,$RutEmpresa,$id_creador);		
		}

		function DesactivarEmpresa(){
			$idEmpresa=$_POST['idemp'];
			$this->load->model("ModuloCliente");
			// echo $idEmpresa;exit;
			$c=$this->ModuloCliente->ListarEmpresXid($idEmpresa);

			echo "<div class='modal-header bg-danger'>
                    <h6 class='modal-title text-white'>Desactivar</h6>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                    </button>
                </div>
                <div class='modal-body'>
                	<form id='DesactivarEmpresa' method='POST' >
	                    <p>Esta seguro de desactivar la empresa ".$c['NombreEmpresa']." ?</p>
	                    <input type='hidden' name='hidEmpresa' id='hidEmpresa' value='".$idEmpresa."'>
                    </form>
                </div>
                <div class='modal-footer'>
                

                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>

                    <button type='button' class='btn btn-danger' onclick='DesactivarEmpresa();'> <i id='icDesactivarEmpresa'  class=''></i>Desactivar </button>
                
                </div>";
                echo "

                <script type='text/javascript'>

                	 function DesactivarEmpresa(){
				        				        
					        $('#icDesactivarEmpresa').attr('class','fa fa-spin fa-circle-o-notch');
					        $.ajax({                        
					           type: 'POST',                 
					           url:'audisis/Adm_ModuloCliente/DesactivarEmpresaF',                     
					           data: $('#DesactivarEmpresa').serialize(), 
					           success: function(data)             
					           {            
					           	 if (data==0){
					                $('#icDesactivarEmpresa').attr('class','');
					                alertify.error('Empresa Desactivada');
					                $('#ModaldaActivarEmpresas').modal('hide');
					             }
				           	}         
					       });
					    
					  };

				 


                </script>";



		}



	function cambiarEstadoEmpresaF(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_idEmpresa"])){
					$this->load->model("ModuloCliente");					
					$idEmpresa=$_POST["txt_idEmpresa"];
					$vigencia=$_POST["txt_estado"];
					$idusercreador=$_POST["txt_usuarioCreador"];
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					// var_dump($idEmpresa,$vigencia);exit();
					$filas=$this->ModuloCliente->cambiarEstadoEmpresa($idEmpresa,$vigencia,$idusercreador);
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
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Cargo"] = $_SESSION["Cargo"];
					$this->load->model("ModuloCliente");
					$data["ListarEmpresa"]=$this->ModuloCliente->ListarEmpresa();
					$data["ListarCliente"]=$this->ModuloCliente->ListarCliente();
					//vistas
				    $this->load->view('contenido');
				    $this->load->view('layout/header',$data);
				    $this->load->view('layout/sidebar',$data);
				    $this->load->view('admin/adminCliente',$data);
				    $this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloUsuario/listarModuloUsuario"));
				}
			}
		}
	}


		function cambiarEstadoEmpresa(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["idemp"])){
					$this->load->model("ModuloCliente");
					$idemp=$_POST["idemp"];
					$c=$this->ModuloCliente->ListarEmpresXid($idemp);
					$estado=$_POST["estado"];
					// echo"holitaaaa";exit;
					echo "<form method='post' id='cambiarEstadoEmpresa' action='cambiarEstadoEmpresaF'>";
					if($estado==1){
						echo "<p>¿Esta Seguro que desea Desactivar la Empresa ".$c['NombreEmpresa']." ?</p>";						
					}else{
						echo "<p>¿Esta Seguro que desea Activar  la Empresa ".$c['NombreEmpresa']." ?</p>";
					}
					echo "<input type='hidden' name='txt_idEmpresa' value='".$idemp."'>";
					echo "<input type='hidden' name='txt_usuarioCreador' value='".$_SESSION["sesion"]."'>";
					echo "<input type='hidden' name='txt_estado' value='".$estado."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloCliente/AdministracionClientes"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function cambiarEstadoClienteF(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_idCliente"])){
					$this->load->model("ModuloCliente");					
					$idCliente=$_POST["txt_idCliente"];
					$vigencia=$_POST["txt_estado"];
					$idusercreador=$_POST["txt_usuarioCreador"];
					// var_dump($idEmpresa,$vigencia);exit();
					$filas=$this->ModuloCliente->cambiarEstadoCliente($idCliente,$vigencia,$idusercreador);
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
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Cargo"] = $_SESSION["Cargo"];
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$this->load->model("ModuloCliente");
					$data["ListarEmpresa"]=$this->ModuloCliente->ListarEmpresa();
					$data["ListarCliente"]=$this->ModuloCliente->ListarCliente();
					//vistas
				    $this->load->view('contenido');
				    $this->load->view('layout/header',$data);
				    $this->load->view('layout/sidebar',$data);
				    $this->load->view('admin/adminCliente',$data);
				    $this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloUsuario/listarModuloUsuario"));
				}
			}
		}
	}


	function cambiarEstadoCliente(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["idcli"])){
					$this->load->model("ModuloCliente");
					$idCliente=$_POST["idcli"];
					$e=$this->ModuloCliente->ListarClienteXid($idCliente);
					$estado=$_POST["estado"];
					// echo"holitaaaa";exit;
					echo "<form method='post' id='cambiarEstadoCliente' action='cambiarEstadoClienteF'>";
					if($estado==1){
						echo "<p>¿Esta Seguro que desea Desactivar el Cliente ".$e['Nombre']." ?</p>";						
					}else{
						echo "<p>¿Esta Seguro que desea Activar  el Cliente ".$e['Nombre']." ?</p>";
					}
					echo "<input type='hidden' name='txt_idCliente' value='".$idCliente."'>";
					echo "<input type='hidden' name='txt_usuarioCreador' value='".$_SESSION["sesion"]."'>";
					echo "<input type='hidden' name='txt_estado' value='".$estado."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloCliente/AdministracionClientes"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}				

		function EditarCliente(){
			$this->load->model("ModuloCliente");
			$idCliente=$_POST['idemp'];
			$e=$this->ModuloCliente->ListarClienteXid($idCliente);
			$ListarEmpresa=$this->ModuloCliente->ListarEmpresa();
			$listarPaises=$this->ModuloCliente->ListarPaises();

			echo "<div class='modal-header'>
			<h6 class='modal-title' >Editar Cliente</h6>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
		</div>
		<div class='modal-body'>
		<div class='card'>
						<div class='card-header text-theme'>
							Cliente: ".$e['Nombre']."
						</div>
						<div class='card-body'>
							<form id='mFrmEditarCliente' method='POST' >
								<div class='form-group row'>
									<div class='col-md-7'>
										<label for='company'>Nombre Cliente</label>
										<div class='input-group'>
											<span class='input-group-addon'>
												<i class='mdi mdi-castle'></i>
											</span>
											<input type='text' class='form-control' id='mtxtNombreCliente' name='mtxtNombreCliente' placeholder='Nombre del Cliente' value='".$e['Nombre']."'>
										</div>
										<div id='merrortxtNombreCliente' style='color: red; display: none;'  >
											   Debe Escribir el nombre del Cliente...
									</div>
									<div id='merrorClienteEmpresaV' style='color: red; display: none;'  >
												El Nombre del Cliente ya existe para esta Empresa
									</div>
									</div>
								</div>
								<div class='form-group row'>
									<div class='col-md-8'>
										<label for='company'>Email del Cliente</label>
										<div class='input-group'>
											<span class='input-group-addon'>
												<i class='mdi mdi-mail-ru'></i>
											</span>
											<input type='text' class='form-control' id='mtxtEmailCliente' name='mtxtEmailCliente' placeholder='NombreCliente@algo.com' value='".$e['EmailCliente']."' >
											<input type='hidden' name='hidCliente' id='hidCliente' value='".$e['ID_Cliente']."'>
										</div>	                                           
										<div id='merrortxtMailEmpresa' style='color: red; display: none;'  >
											   Debe ecribir el mail del Cliente... 
									</div>
									<div id='merrortxtMailEmpresaV' style='color: red; display: none;'  >
											   El mail del Cliente no es Valido... 
									</div>             
									</div>
								</div>
								<div class='form-group row'>
									<div class='col-md-8'>
										<label for='company'>Nombre Empresa del Cliente</label>
										<div class='input-group'>
											<span class='input-group-addon'>
												<i class='mdi mdi-castle'></i>
											</span>
											<select id='msltEmpresa' name='msltEmpresa' class='form-control form-control-sm'>
											<option value='".$e['FK_Empresas_ID_empresa']."'>".$e['NombreEmpresa']."</option>";
											
												foreach ($ListarEmpresa as $c) {
													echo "<option value='".$c['ID_Empresa']."'>".$c['NombreEmpresa']."</option>";
											}
										echo"</select>
										</div>
										<div id='errorsltEmpresa' style='color: red; display: none;'  >
											   Debe selecionar la Empresa...
									</div>
									</div>                                          
								</div>
								
								<div class='form-group row'>
								<div class='col-md-8'>
									<label for='company'>Pais del cliente</label>
									<div class='input-group'>
										<span class='input-group-addon'>
											<i class='mdi mdi-castle'></i>
										</span>
										<select id='msltPais' name='msltPais' class='form-control form-control-sm'>
										<option value='".$e['FK_ID_Pais']."'>".$e['Pais']."</option>";
										
											foreach ($listarPaises as $p) {
												echo "<option value='".$p['ID_Pais']."'>".$p['Pais']."</option>";
										}
									echo"</select>
									</div>
									<div id='errorsltEmpresa' style='color: red; display: none;'  >
										   Debe selecionar la Empresa...
								</div>
								</div>                                          
							</div>
								<div class='form-group row'>
									<div class='col-md-8'>
										<label for='company'>Nueva Imagen</label>
										<div class='input-group'>
											<span class='input-group-addon'>
												<i class='mdi mdi-camera'></i>
											</span>
											<input type='file' id='tx_foto' name='tx_foto' class='dropify'  />
											<input type='hidden' id='tx_fotoAntigua' name='tx_fotoAntigua' value='";if(isset($e['logo'])){ echo $e['logo'];}else{ echo'';}; echo "'>
										</div>
									</div>                                          
								</div>
							</form>
						</div>
					</div>
	   </div>
		<div class='modal-footer'>
		<button type='button' class='btn btn-sm btn-danger' onclick='return validarEditarCliente();' ><i id='icEditarCliente'  class=''></i> Guardar Edición</button>
		  
		</div>";
				
		
				echo 
				" <script type='text/javascript'>
						

				function validarEditarCliente(){
					if(validarIngresarCliente()==false){
					alertify.error('Existen Campos Vacios');
					return false;
					   }else{
					$('#icEditarCliente').attr('class','fa fa-spin fa-circle-o-notch');
					var formData = new FormData(document.getElementById('mFrmEditarCliente'));
					$.ajax({                        
					   type:'POST',                  
					   url:'EditarClienteF',
					   dataType: 'html',                     
					   data:formData, 
					   cache: false,
					   contentType: false,
						  processData: false,
					   success:function(data)             
					   {            
						 if (data==1) 
						 {
						 $('#icEditarCliente').attr('class','');
						 alertify.error('El Cliente ya existe para esta Empresa');
						 $('#mtxtNombreCliente').attr('class', 'form-control is-invalid');
						 $('#merrorClienteEmpresaV').show(); 
						 }
						 else if(data==0)
						 {
							$('#icEditarCliente').attr('class','');
						 alertify.success('Cliente Editado');
						 setTimeout(function(){
							window.location = 'AdministracionClientes';
						 }, 1000);
						 }
						 
						 else if(data==2)
						 {
						 alertify.error('El mail ingresado no es valido');
						 $('#mtxtMailEmpresa').attr('class', 'form-control is-invalid');
						 $('#merrortxtMailEmpresaV').show(); 
						 
						 }
						  
						 else
						 {
							 $('#icEditarCliente').attr('class','');
						 alertify.success('Cliente Editado');
						 setTimeout(function(){
							window.location = 'AdministracionClientes';
						 }, 1000);
						 }
						 
					   },error:function(data){
							$('#icEditarCliente').attr('class','');
							alertify.error('Error desconocido');           
						   }
				   });
				}
			  };


				   function validarIngresarCliente(){
					    var vacios=0;
					    var valido=true;
					    if($('#msltEmpresa').val()==''){  
					        $('#msltEmpresa').attr('class', 'form-control is-invalid');
					        $('#merrorsltEmpresa').show(); 
					        vacios+=1;
					    } else { 
					        $('#msltEmpresa').attr('class', 'form-control is-valid');  
					        $('#merrorsltEmpresa').hide(); 
					    }

					    if($('#mtxtNombreCliente').val()==''){  
					        $('#mtxtNombreCliente').attr('class', 'form-control is-invalid');
					        $('#merrortxtNombreCliente').show(); 
					        vacios+=1;
					    } else { 
					        $('#mtxtNombreCliente').attr('class', 'form-control is-valid');  
					        $('#merrortxtNombreCliente').hide();
					        $('#merrorClienteEmpresaV').hide();  
					    }

					    if($('#mtxtEmailCliente').val()==''){  
					        $('#mtxtEmailCliente').attr('class', 'form-control is-invalid');
					        $('#merrortxtMailEmpresa').show(); 
					        vacios+=1;
					    } else { 
					        $('#mtxtEmailCliente').attr('class', 'form-control is-valid');  
					        $('#merrortxtMailEmpresa').hide();
					        $('#merrortxtMailEmpresaV').hide();
					        
					    }
					    
					    if(vacios>0){ valido=false; }
					    return valido;
					  }



                </script>";



		}



		function EditarEmpresa(){
			$idEmpresa=$_POST['idemp'];
			$this->load->model("ModuloCliente");
	
			$c=$this->ModuloCliente->ListarEmpresXid($idEmpresa);

			echo "<div class='modal-header'>
                    <h6 class='modal-title' >Editar Empresa</h6>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                </div>
                <div class='modal-body'>
                <div class='card'>
                                <div class='card-header text-theme'>
                                    Empresa: ".$c['NombreEmpresa']."
                                </div>
                                <div class='card-body'>
                                    <form id='mFrmEditarEmpresa' method='POST' >
                                        <div class='form-group row'>
                                            <div class='col-md-12'>
                                               <div class='row'>
			                                    <div class='col-sm-9'>
			                                        <form id='FrmCreaEmpresa' method='POST' > 
			                                        <div class='form-group'>
			                                            <label for='company'>Nombre Empresa</label>
			                                            <div class='input-group'>
			                                                <span class='input-group-addon'>
			                                                    <i class='mdi mdi-factory'></i>
			                                                </span>

			                                                <input type='text' class='form-control' id='mtxtNombreEmpresa' name='mtxtNombreEmpresa' placeholder='Nombre de la Empresa' value='".$c['NombreEmpresa']."' >
			                                                <input type='hidden' name='hRutEmpresa' id='hRutEmpresa' value='".$c['RutEmpresa']."'>
			                                                
			                                            </div><br><div id='merrorNombreEmpres' style='color: red; display: none;'  >
			                                                        Debe escribir el Nombre de la Empresa...
			                                                    </div>

			                                            
			                                        </div>

                                        

                                        <div class='form-group'>
                                            <label for='street'>Razon Social</label>
                                            <div class='input-group'>
                                                <span class='input-group-addon'>
                                                    <i class='mdi mdi-content-paste'></i>
                                                </span>
                                            <input type='text' class='form-control' id='mtxtRazonSocial' name='mtxtRazonSocial' placeholder='Ra<on social' value='".$c['RazonSocial']."'>
                                            </div>
                                            <br>
                                            <div id='merrorRazonSocial' style='color: red; display: none;'  >
                                                        Debe escribir la Razon Social de la Empresa...
                                            </div>
                                            
                                        </div>                            
                                        </div>
                                    </form>
                                </div>
                            </div>
               </div>
                <div class='modal-footer'>
                <button type='button' class='btn btn-sm btn-danger' onclick='return validarEditarEmpresa();' ><i id='micEditarEmpresa'  class=''></i> Guardar Edición</button>

                  
                </div>";
                echo "

                <script type='text/javascript'>

                	 function validarEditarEmpresa(){
				        if(validarIngresarEmpresa()==false){
					        alertify.error('Existen Campos Vacios');
					        return false;
					    }else{					        
					        $('#micEditarEmpresa').attr('class','fa fa-spin fa-circle-o-notch');
					        $.ajax({                        
					           type: 'POST',                 
					           url:'EditarEmpresaF',                     
					           data: $('#mFrmEditarEmpresa').serialize(), 
					           success: function(data)             
					           {            
					           	 if (data==0){
					                $('#micEditarEmpresa').attr('class','');
					                alertify.success('Empresa Editada');
					                setTimeout(function(){
				                        window.location = 'AdministracionClientes';
				                    }, 1000);

					             }
				           	}         
					       });
					    }
					  };

				   function validarIngresarEmpresa(){
				    var vacios=0;
				    var valido=true;
				    if($('#mtxtNombreEmpresa').val()==''){  
				        $('#mtxtNombreEmpresa').attr('class', 'form-control is-invalid');
				        $('#merrorNombreEmpres').show(); 
				        vacios+=1;
				    } else { 
				        $('#mtxtNombreEmpresa').attr('class', 'form-control is-valid');  
				        $('#merrorNombreEmpres').hide(); 
				    }				    
				    if($('#mtxtRazonSocial').val()==''){  
				        $('#mtxtRazonSocial').attr('class', 'form-control is-invalid'); 
				        $('#merrorRazonSocial').show();    
				        vacios+=1;
				    } else { 
				        $('#mtxtRazonSocial').attr('class', 'form-control is-valid');  
				        $('#merrorRazonSocial').hide();    
				    }
				    if(vacios>0){ valido=false; }
				    return valido;
				  }


                </script>";



		}		


	function limpiarRut($rut){
    	$patron = "/[^-kK0-9]/i";    
        $cadena_nueva = preg_replace($patron, "", $rut);
        return $cadena_nueva; 
    }

    function validarEmail($Email){
    	if (filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    		return true;
   		}else{
    		return false;
    	}
	}

    function limpiarComilla($rut){
    	$patron = "/[']/i";    
        $cadena_nueva = preg_replace($patron, "", $rut);
        return $cadena_nueva; 
    }

    function validaRut($rut){
		$resultado =preg_replace("/[^0-9]/","", $rut);
		$suma = 0;
		if(strlen($resultado)>0){
	    if(strpos($rut,"-")==false){
	        $RUT[0] = substr($rut, 0, -1);
	        $RUT[1] = substr($rut, -1);
	    }else{
	        $RUT = explode("-", trim($rut));
	    }
	    $elRut = str_replace(".", "", trim($RUT[0]));
	    $factor = 2;
	    for($i = strlen($elRut)-1; $i >= 0; $i--):
	        $factor = $factor > 7 ? 2 : $factor;
	        $suma += $elRut{$i}*$factor++;
	    endfor;
	    $resto = $suma % 11;
	    $dv = 11 - $resto;
	    if($dv == 11){
	        $dv=0;
	    }else if($dv == 10){
	        $dv="k";
	    }else{
	        $dv=$dv;
	    }
	   if($dv == trim(strtolower($RUT[1]))){
	       return true;
	   }else{
	       return false;
	   }
	   }else{
			return false;
		}
	}

			  
}


