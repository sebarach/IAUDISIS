<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloPermisos extends CI_Controller {
	public function __construct(){

		parent::__construct();
		$this->load->helper("url","form");	
		$this->load->library('form_validation'); 
		$this->load->model("funcion_login");
		
	}

	function creacionPermisos(){
		$this->load->model("ModuloPermisos");
		$this->load->model("ModuloUsuario");
		if (isset($_SESSION["sesion"])) {
			if ($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2) {
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
				$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["listaPermisos"]=$this->ModuloPermisos->listarPermisos();
				$BD=$_SESSION["BDSecundaria"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearPermisos',$data);
			   	$this->load->view('layout/footer',$data);

			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function CrearPermiso(){
		if (isset($_SESSION["sesion"])) {
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$codigoPermiso=$_POST["txtCodigoPermiso"];
				$nombrePermiso=$_POST["txtNombrePermiso"];
				$tipoPermiso=$_POST["sltTipoPermiso"];
				$remuneracion=$_POST["sltRemuneracion"];
				$id_creador=$_SESSION['Usuario'];
				$BD=$_SESSION["BDSecundaria"];
				$this->load->model("ModuloPermisos");
				$existe=$this->ModuloPermisos->validarPermiso($nombrePermiso,$codigoPermiso);
				if ($existe!=1) {
					echo 0;
					$this->ModuloPermisos->ingresarPermiso($nombrePermiso,$tipoPermiso,$remuneracion,$id_creador,$codigoPermiso,$BD);
				}else{
					echo 1;
				}
			}			
		}
	}

	function AdministrarPermisos(){
		if (isset($_SESSION["sesion"])) {
			if ($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2) {
				$this->load->model("ModuloPermisos");
				$this->load->model("ModuloUsuario");
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["listaPermisos"]=$this->ModuloPermisos->listarPermisos();
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
				$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
				$data["Cargo"] = $_SESSION["Cargo"];
				$BD=$_SESSION["BDSecundaria"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminPermisos',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function EditarPermiso(){
		$this->load->model("ModuloPermisos");		
		$idPer=$_POST["idPer"];
		$p=$this->ModuloPermisos->listarIdPermiso($idPer);
		echo "<div class='modal-header'>
                    <h6 class='modal-title' >Editar Permisos</h6>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
				</div>
				<div class='modal-body'>
					<div class='card'>
						<div class='card-header text-theme'>
						Permiso: ".$p['NombrePermiso']."
						</div>
						<div class='card-body'>
	                                <form id='mFrmEditarPermiso' method='POST'>
	                                <input type='hidden' class='form-control' id='mtxtIdPer' name='mtxtIdPer' value='".$p['ID_Permiso']."'>
	                                <input type='hidden' class='form-control' id='mtxtVigencia' name='mtxtVigencia' value='".$p['Vigencia']."'>
	                                <div class='form-group row'>
	                                		<div class='col-md-7'>
	                                		<label for='company'>Nombre Permiso</label>
	                                		<div class='input-group'>
	                                			<span class='input-group-addon'>
	                                                    <i class='mdi mdi-account-key'></i>
	                                            </span>
	                                            <input type='text' class='form-control' id='mtxtNombrePermiso' name='mtxtNombrePermiso' placeholder='Nombre del Permiso' value='".$p['NombrePermiso']."'>
		                                            <div id='merrortxtNombrePermiso' style='color: red; display: none;'  >
	                                                       Debe Escribir el nombre del Permiso...
	                                                </div>
	                                                <div id='merrorPermisoV' style='color: red; display: none;'  >
                                                           El Nombre del Permiso ya existe ...
                                            		</div>
	                                		</div>
											</div>
											<div class='col-md-7'>
	                                		<label for='company'>Tipo Permiso</label>
	                                		<div class='input-group'>
	                                			<span class='input-group-addon'>
	                                                    <i class='mdi mdi-book-open'></i>
	                                            </span>
	                                            <select id='sltTipoPermiso' name='sltTipoPermiso' class='form-control form-control-sm'>
                                                 	<option value=''>Seleccione</option>
                                                    <option value='Licencia Medica LM'>Licencia Medica LM</option>
													<option value='No es Permiso'>No es Permiso</option>
													<option value='Permisos con goce de sueldo PCS'>Permisos con goce de sueldo PCS</option>
													<option value='Permisos sin goce de sueldo PSS'>Permisos sin goce de sueldo PSS</option>
                                                </select>
		                                            <div id='merrorsltTipoPermiso' style='color: red; display: none;'  >
	                                                       Debe seleccionar el tipo...
	                                                </div>
	                                		</div>
											</div>
											<div class='col-md-7'>
	                                		<label for='company'>Tipo Remuneración</label>
	                                		<div class='input-group'>
	                                			<span class='input-group-addon'>
	                                                    <i class='fa fa-dollar'></i>
	                                            </span>
												<select id='sltRemuneracion' name='sltRemuneracion' class='form-control form-control-sm'>
													<option value=''>Seleccione</option>
													<option value='1'>Remunerado</option>
													<option value='0'>No Remunerado</option>
										   		</select>
		                                            <div id='merrorsltRemuneracion' style='color: red; display: none;'  >
	                                                       Debe seleccionar la remuneración...
	                                                </div>
	                                		</div>
											</div>
											
											<div class='col-md-7'>
	                                		<label for='company'>Código Permiso</label>
	                                		<div class='input-group'>
	                                			<span class='input-group-addon'>
	                                                    <i class='mdi mdi-barcode'></i>
	                                            </span>
	                                            <input type='text' class='form-control' id='mtxtCodigoPermiso' name='mtxtCodigoPermiso' placeholder='Código del Permiso' value='".$p['Codigo']."'>
		                                            <div id='merrortxtCodigoPermiso' style='color: red; display: none;'  >
	                                                       Debe Escribir el código del Permiso...
	                                                </div>
	                                		</div>
											</div>
	                                	</div>
	                            </form>    
                                </div>
					</div>
					</div>

                                <div class='modal-footer'>
                				<button type='button' class='btn btn-sm btn-danger' onclick='return validarEditarPermiso();' ><i id='icEditarPermiso'  class=''></i> Guardar Edición</button>
				</div>
				</div>
				<script type='text/javascript'>

				function validarEditarPermiso(){
					if(validarIngresarPermiso()==false){
					alertify.error('Existen Campos Vacios');
					return false;
					}else{
					$('#icEditarPermiso').attr('class','fa fa-spin fa-circle-o-notch');
					$.ajax({                        
					   type: 'POST',                 
					   url:'EditarPermisoF',                     
					   data: $('#mFrmEditarPermiso').serialize(), 
					   success: function(data)             
					   {            
						 if (data==1) {
						 $('#icEditarPermiso').attr('class','');
						 alertify.error('El nombre del permiso ya existe');
						 $('#merrortxtNombrePermiso').attr('class', 'form-control is-invalid');
						 $('#merrorPermisoV').show(); 

						 }else if(data==0){
							$('#icEditarPermiso').attr('class','');
						 alertify.success('Permiso Editado');
						 $('#mtxtNombrePermiso').val('');						
						 setTimeout(function(){
							window.location = 'AdministrarPermisos';
						}, 1);
						 }
					   }         
				   });
				}
			  };

			  function validarIngresarPermiso(){
				var vacios=0;
				var valido=true;
				if($('#mtxtNombrePermiso').val()==''){  
					$('#mtxtNombrePermiso').attr('class', 'form-control is-invalid');
					$('#merrortxtNombrePermiso').show();			
					vacios+=1;
				} else { 
					$('#mtxtNombrePermiso').attr('class', 'form-control is-valid');  
					$('#merrortxtNombrePermiso').hide();
					$('#merrorPermisoV').hide();  
				}

				if($('#sltTipoPermiso').val()==''){
					$('#sltTipoPermiso').attr('class', 'form-control is-invalid');
					$('#merrorsltTipoPermiso').show();
									
					vacios+=1;
				} else {
					$('#sltTipoPermiso').attr('class', 'form-control is-valid');
					$('#merrorsltTipoPermiso').hide();					
				}

				if($('#sltRemuneracion').val()==''){  
					$('#sltRemuneracion').attr('class', 'form-control is-invalid');
					$('#merrorsltRemuneracion').show(); 
					vacios+=1;
				} else { 
					$('#sltRemuneracion').attr('class', 'form-control is-valid');  
					$('#merrorsltRemuneracion').hide();      
				}

				if($('#mtxtCodigoPermiso').val()==''){  
					$('#mtxtCodigoPermiso').attr('class', 'form-control is-invalid');
					$('#merrortxtCodigoPermiso').show(); 
					vacios+=1;
				} else { 
					$('#mtxtCodigoPermiso').attr('class', 'form-control is-valid');  
					$('#merrortxtCodigoPermiso').hide();      
				}

				 if(vacios>0){ valido=false; }
				return valido;
			  }

				</script>

				";
		
	}

	function EditarPermisoF(){
			$this->load->model("ModuloPermisos");
			$codigoPermiso=$_POST['mtxtCodigoPermiso'];
			$idPermiso=$_POST['mtxtIdPer'];
			$NombrePermiso=$_POST['mtxtNombrePermiso'];
			$TipoPermiso=$_POST['sltTipoPermiso'];
			$Remuneracion=$_POST['sltRemuneracion'];
			$id_creador=$_SESSION['Usuario'];
			echo 0;
			$this->ModuloPermisos->EditarPermiso($idPermiso,$NombrePermiso,$TipoPermiso,$Remuneracion,$codigoPermiso);	
	}

	function cambiarPermiso(){		
		$this->load->model("ModuloPermisos");
		$idPer=$_POST["idPer"];
		$p=$this->ModuloPermisos->listarIdPermiso($idPer);
		$estado=$_POST["estado"];

		echo "<form method='post' id='cambiarPermiso' action='cambiarEstadoPermisoF'>";
		if($estado==1){
			echo "<p>¿Esta Seguro que desea Desactivar el Permiso ".$p['NombrePermiso']." ?</p>";						
		}else{
			echo "<p>¿Esta Seguro que desea Activar el Permiso ".$p['NombrePermiso']." ?</p>";
		}
		echo "<input type='hidden' name='txt_id_permiso' value='".$idPer."'>";
		echo "<input type='hidden' name='txt_estado' value='".$estado."'>";
		echo "</form>";
	}
	
	function cambiarEstadoPermisoF(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				if(isset($_POST["txt_id_permiso"])){
					$this->load->model("ModuloPermisos");	
					
					$idPer=$_POST["txt_id_permiso"];
					$vigencia=$_POST["txt_estado"];
					$filas=$this->ModuloPermisos->CambiarVigenciaPermiso($idPer,$vigencia);
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
					$data["Cargo"] = $_SESSION["Cargo"];
					$this->load->model("ModuloPermisos");
					$this->load->model("ModuloUsuario");
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["listaPermisos"]=$this->ModuloPermisos->listarPermisos();
					$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
					$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminPermisos',$data);
				   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloPermisos/adminPermisos"));
				}
			}
		}
	}

	function AsignarPermisos(){
		if (isset($_SESSION["sesion"])) {
			if ($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2) {
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$BD=$_SESSION["BDSecundaria"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminAsignarPermisos',$data);
			   	$this->load->view('layout/footer',$data);

			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function buscarVigencia(){
		$this->load->model("ModuloPermisos");
		if(isset($_SESSION["sesion"])){	
			$vig = $_POST['msltVig'];		
			if($vig!= null){
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];				
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			// $this->load->view('admin/adminListarElemento',$data);
			   	$this->load->view('layout/footer',$data);	
				if($vig==1){		
					$result['listaPermisos']= $this->ModuloPermisos->buscarVigenciaPermisos($vig);
					$this->load->view('admin/AdminPermisos',$result);
				}
				if ($vig==0) {
					$result['listaPermisos']= $this->ModuloPermisos->buscarVigenciaPermisos($vig);
					$this->load->view('admin/AdminPermisos',$result);
				}
				if ($vig==2) {
					$result["listaPermisos"]=$this->ModuloPermisos->listarPermisos();
					$this->load->view('admin/AdminPermisos',$result);
				}
			}
		}else{
			redirect(site_url("menu"));
		}
	}

}