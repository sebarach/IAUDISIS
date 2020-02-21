<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloUsuario extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->model("funcion_login");
		$this->load->model("ModuloUsuario");
		$this->load->library('upload');
	}

	function listarModuloUsuario(){
		
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				if(isset($_POST["lb_activo"])){
					$vigencia=$_POST["lb_activo"];					
					if($vigencia=='1'){
						$data["Titulo"] = 'Activos';
					}elseif($vigencia=='0'){
						$data["Titulo"] = 'Inactivos';
					}else{
						$data["Titulo"] ='';
					}		
				}else{
					$vigencia="2";
					$data["Titulo"] ='';
				}
				
				$data["Estado"]=$vigencia;
				$data["AsignadoBoton"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],10,$_SESSION["Cliente"]);
				$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
				$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
				// var_dump($data["Asignado"]["Activo"]);exit();
				$data["Usuarios"]= $this->ModuloUsuario->listarUsuariosEstado($_SESSION["Cliente"],$vigencia);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Cargo"] = $_SESSION["Cargo"];				
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminUsuarios',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function listarGrupoUsuarios(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuarios($_SESSION["Cliente"]);
				$data["UsuariosA"]= $this->ModuloUsuario->listarUsuariosActivos($_SESSION["Cliente"]);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Cargo"] = $_SESSION["Cargo"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminGrupoUsuarios',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function creacionUsuario(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Perfiles"]  = $this->ModuloUsuario->listarPerfilesActivos();
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Grupos"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
				$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearUsuarios',$data);
			   	$this->load->view('layout/footer',$data);			   	
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}	

	function validarCreacionUsuario(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				// OP1 = Ingresado Correcto
				// OP2 = Rut Invalido
				// OP3 = Rut Ya Ingresado
				// OP4 = Usuario Ya Ingresado
				// OP5 = No se Insertaron las filas
				// OP6 = Se edito Correctamente
				$var=0;

				//Rellenar Variables				
				$nombre=$this->limpiarComilla($_POST["txt_nombres"]);
				$paterno=$this->limpiarComilla($_POST["txt_appaterno"]);
				$materno=$this->limpiarComilla($_POST["txt_apmaterno"]);
				$genero=$this->limpiarComilla($_POST["rb_genero"]);
				$telefono=$this->limpiarNumero($this->limpiarComilla($_POST["txt_telefono"]));
				$email=$this->limpiarComilla($_POST["txt_email"]);
				$direccion=$this->limpiarComilla($_POST["txt_direccion"]);
				if(isset($_POST["txt_cargo"])){
					$cargo=$this->limpiarComilla($_POST["txt_cargo"]);
				}else{
					$cargo="";
				}
				$creador=$_SESSION["Usuario"];
				$cliente=$_SESSION["Cliente"];
				$perfil=$this->limpiarComilla($_POST["lb_perfil"]);				
				$usuario=$this->limpiarComilla(strtolower($_POST["txt_usuario"]));
				$clave=openssl_encrypt($_POST["txt_clave"],"AES-128-ECB","12314");	

				$esEditar=$_POST["txt_editar"];				
				//Creamos el Token de cada usuario
				$token = $this->CrearToken();
				
				//Validador				
				if($esEditar>0){
					if($var==0){
						//Insertar y retonar Cantidad de Registros
						$filas=$this->ModuloUsuario->editarUsuario($nombre,$paterno,$materno,$genero,$telefono,$email,$direccion,$cargo,$creador,$cliente,$perfil,$esEditar);
						if($filas["CantidadInsertadas"]==0){
							echo "OP5";
						}else{							
							//descativar registros
							$this->ModuloUsuario->desactivarUsuarioG($esEditar);

							if(isset($_POST['txt_grupos'])){
								$grupo=$_POST['txt_grupos'];
								foreach ($grupo as $g) {
									$this->ModuloUsuario->editarITGrupoU($esEditar,$g,$cliente,$creador);	
								}
							}	

							echo "OP6".$filas["CantidadInsertadas"];
						}
					}
				}else{
					if(isset($_POST["txt_rut"]) && $_POST["txt_rut"]!=""){
						$rut=$this->limpiarRut($this->limpiarComilla(strtolower($_POST["txt_rut"])));
						$validador=$this->validaRut($rut);
						if($validador==false){					
							echo "OP2";
							$var++;
						}
						$resp=$this->ModuloUsuario->validarRutUsuario($rut);
						if(isset($resp["Cliente"])){
							echo "OP3".$resp["Cliente"];
							$var++;
						}	
					}else{
						$rut="";
					}					
					$resp2=$this->ModuloUsuario->validarUserUsuario($usuario);
					if(isset($resp2["Cliente"])){						
						if($var==0){
							echo "OP4".$resp2["Cliente"];													
						}else{
							echo "OP4";												
						}
						$var++;
					}	
					if($var==0){
						//Insertar y retonar Cantidad de Registros
						$filas=$this->ModuloUsuario->ingresarUsuario($rut,$nombre,$paterno,$materno,$genero,$telefono,$email,$direccion,$cargo,$creador,$cliente,$perfil,$usuario,$clave);
						//Se inserta el Token de usuario. 
						$msj = $this->ModuloUsuario->ingresarTokenUsuario($rut,$token);
						if($msj['MENSAJE'] == "ERROR"){
							echo "error al crear token de usuario";
						}
						
						if($filas["CantidadInsertadas"]==0){
							echo "OP5";
						}else{							
							if(isset($_POST['txt_grupos'])){
								$grupo=$_POST['txt_grupos'];
								foreach ($grupo as $g) {
									$ingresos=$this->ModuloUsuario->ingresarITUsuarioG($rut,$g,$cliente,$creador);	
								}
							}
							echo "OP1".$filas["CantidadInsertadas"];
						}
					}
				}	
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function ValidarCreacionGrupoUsuario(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				// OP1 = Ingresado Correcto
				// OP2 = No se Insertaron las filas
				// OP3 = Editado Correctamente
				// OP4 = Cantidad Usuarios Asignados
				$var=0;
				$exito=0;
				$correctos=0;
				$incorrectos=0;

				//Rellenar Variables
				$grupoU=$this->limpiarComilla($_POST["txt_grupoUsuario"]);
				$cliente=$_SESSION["Cliente"];
				$creador=$_SESSION["Usuario"];					
				if($var==0){					
					if(isset($_POST["txt_idGrupoUsuario"])){
						//Modificar Cadena
						$idGrupoU=$_POST["txt_idGrupoUsuario"];					

						$filas=$this->ModuloUsuario->editarGrupoU($grupoU,$creador,$idGrupoU);
						if($filas["CantidadInsertadas"]==0){
							echo "OP2";
						}else{
							//descativar registros
							$this->ModuloUsuario->desactivarGrupoU($idGrupoU);

							if(isset($_POST['txt_usuarios'])){			
								$usuarios=$_POST['txt_usuarios'];
								foreach ($usuarios as $u) {
									$ingresos=$this->ModuloUsuario->editarITGrupoU($u,$idGrupoU,$cliente,$creador);	
									if($ingresos["CantidadInsertadas"]==0){
										$incorrectos++;
									}else{
										$correctos++;
									}
								}
								echo "OP5".$correctos;
							}else{
								echo "OP3".$filas["CantidadInsertadas"];
							}
						}
					}else{
						//Insertar y retonar Cantidad de Registros
						$filas=$this->ModuloUsuario->ingresarGrupoU($grupoU,$cliente,$creador);						
						if($filas["CantidadInsertadas"]==0){
							echo "OP2";
						}else{
							if(isset($_POST['txt_usuarios'])){			
								$usuarios=$_POST['txt_usuarios'];
								foreach ($usuarios as $u) {
									$ingresos=$this->ModuloUsuario->ingresarITGrupoU($u,$grupoU,$cliente,$creador);	
									if($ingresos["CantidadInsertadas"]==0){
										$incorrectos++;
									}else{
										$correctos++;
									}
								}
								echo "OP4".$correctos;
							}else{
								echo "OP1".$filas["CantidadInsertadas"];
							}
						}
					}					

				}			
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function editarUsuario(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_id"])){
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Perfiles"]  = $this->ModuloUsuario->listarPerfilesActivos();
					$data["datosUsuario"]=$this->ModuloUsuario->buscarUsuarioID($_POST["txt_id"]);
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Grupos"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
					$data["GruposActivos"] = $this->ModuloUsuario->listarGruposActivosGrupoUsuarios($_POST["txt_id"]);
					$data["Cargo"] = $_SESSION["Cargo"];
					$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
					$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminCrearUsuarios',$data);
				   	$this->load->view('layout/footer',$data);			 
				}else{
					redirect(site_url("Adm_ModuloUsuario/listarModuloUsuario"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function editarGrupoU(){
		$NombreGrupo=$_POST["NombreGrupo"];
		$opcion=$_POST["Opcion"];
		$datosGrupoU= $this->ModuloUsuario->buscarGrupoUsuarioID($NombreGrupo);
		$UsuariosA= $this->ModuloUsuario->listarUsuariosActivos($_SESSION["Cliente"]);
		$activos = $this->ModuloUsuario->listarUsuariosActivosGrupoUsuarios($NombreGrupo);
		echo "<form method='post' id='FormNuevoGrupoU' action='#'>";
		echo '<div class="form-group">';
			if($opcion==1){
                   echo '<label for="control-demo-1" class="col-sm-6">Nombre Grupo Usuario <label style="color:red">* &nbsp;</label></label>
                   	<div class="input-group">
                       	<span class="input-group-addon"><i class="fa fa-group"></i></span>
                       	<input type="text" id="txt_grupoUsuario" name="txt_grupoUsuario" class="form-control" placeholder="Nombre del Grupo Usuario" value="';
                       	if(isset($datosGrupoU["NombreGrupoUsuario"])){ echo $datosGrupoU["NombreGrupoUsuario"]; }
               		   	echo '" required>
                   	</div>
                   	<div  id="val_grupoUsuario" style="color:red;"></div>';   
            }else{
            	echo '<h4 align="center">'.$datosGrupoU["NombreGrupoUsuario"].'</h4>
            	<br>
            	<label for="control-demo-1" class="col-sm-6">Agregar Usuarios</label>
               	<div class="input-group">
                   	<span class="input-group-addon"><i class="fa fa-user"></i></span>
                   	<select id="select2" class="form-control select2" data-plugin="select2" multiple  id="txt_usuarios[]" name="txt_usuarios[]" style="width: 100%;">';
                            foreach ($UsuariosA as $U) {                            	
                                echo "<option value='".$U["ID_Usuario"]."' ";
                                foreach ($activos as $a) {
                            		if($a["ID_Usuario"]==$U["ID_Usuario"]){
                            			echo " selected ";
                            		}
                            	}
                                echo ">".$U["Nombre"]."</option>";                                
                            }
                    echo '</select> 
               	</div>';   
               	echo '<input type="hidden" name="txt_grupoUsuario" id="txt_grupoUsuario" value="'; echo $datosGrupoU["NombreGrupoUsuario"]; echo '">';
            }    
        echo '</div>';		
        echo "<input type='hidden' name='txt_idGrupoUsuario' value='". $datosGrupoU["ID_GrupoUsuario"]."'>";
		echo "</form>";
		echo '<script src="';echo  site_url(); echo'assets/libs/select2/dist/js/select2.min.js"></script>
				<script src="';echo  site_url(); echo'assets/libs/multiselect/js/jquery.multi-select.js"></script>

				<script type="text/javascript">
					$("#select2").select2({});
				</script>';
	}

	function cambiarEstadoUsuario(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["usuario"])){
					$usuario=$_POST["usuario"];
					$vigencia=$_POST["estado"];
					echo "<form method='post' id='cambiarEstado' action='cambiarEstadoUsuarioFinal'>";
					if($vigencia==1){
						echo "<p>¿Esta Seguro que desea Desactivar al Usuario?</p>";						
					}else{
						echo "<p>¿Esta Seguro que desea Activar al Usuario?</p>";
					}
					echo "<input type='hidden' name='txt_usuario' value='".$usuario."'>";
					echo "<input type='hidden' name='txt_estado' value='".$vigencia."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloUsuario/listarModuloUsuario"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function cambiarEstadoUsuarioFinal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_usuario"])){		
					$BD=$_SESSION["BDSecundaria"];		
					$usuario=$_POST["txt_usuario"];
					$vigencia=$_POST["txt_estado"];
					$filas=$this->ModuloUsuario->cambiarEstadoUsuario($usuario,$vigencia,$_SESSION["Usuario"]);
					$this->ModuloUsuario->cambiarEstadoHorarioUsuario($BD,$usuario,$vigencia);
					if($vigencia=1){
						$var="desactivado";
					}else{
						$var="activado";
					}
					if($filas["CantidadInsertadas"]==0){
						$data['mensaje']='alertify.success("No se pudo realizar la operacion")';
					}else{
						$data['mensaje']='alertify.success("Se ha "'.$var.'" correctamente")';
					}
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Usuarios"]= $this->ModuloUsuario->listarUsuarios($_SESSION["Cliente"]);
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Cargo"] = $_SESSION["Cargo"];
					$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
					$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
					$data["AsignadoBoton"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],10,$_SESSION["Cliente"]);
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminUsuarios',$data);
				   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloUsuario/listarModuloUsuario"));
				}
			}
		}
	}		

	function cambiarEstadoGrupoUsuario(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["GrupoU"])){
					$GrupoU=$_POST["GrupoU"];
					$vigencia=$_POST["estado"];
					echo "<form method='post' id='cambiarEstadoGrupoUsuario' action='cambiarEstadoGrupoUsuarioFinal'>";
					if($vigencia==1){
						echo "<p>¿Esta Seguro que desea Desactivar al Grupo Usuario?</p>";						
					}else{
						echo "<p>¿Esta Seguro que desea Activar al Grupo Usuario?</p>";
					}
					echo "<input type='hidden' name='txt_grupoUsuario' value='".$GrupoU."'>";
					echo "<input type='hidden' name='txt_estado' value='".$vigencia."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloUsuario/listarGrupoUsuarios"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function cambiarEstadoGrupoUsuarioFinal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_grupoUsuario"])){				
					$GrupoU=$_POST["txt_grupoUsuario"];
					$vigencia=$_POST["txt_estado"];
					$filas=$this->ModuloUsuario->cambiarEstadoGrupoUsuario($GrupoU,$vigencia,$_SESSION["Usuario"]);
					if($vigencia=1){
						$var="desactivado";
					}else{
						$var="activado";
					}
					if($filas["CantidadInsertadas"]==0){
						$data['mensaje']='alertify.success("No se pudo realizar la operacion")';
					}else{
						$data['mensaje']='alertify.success("Se ha "'.$var.'" correctamente")';
					}
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuarios($_SESSION["Cliente"]);
					$data["UsuariosA"]= $this->ModuloUsuario->listarUsuariosActivos($_SESSION["Cliente"]);
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Cargo"] = $_SESSION["Cargo"];
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminGrupoUsuarios',$data);
				   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloUsuario/listarGrupoUsuarios"));
				}
			}
		}
	}		

	function limpiarRut($rut){
    	$patron = "/[^-k0-9]/i";    
        $cadena_nueva = preg_replace($patron, "", $rut);
        return $cadena_nueva; 
    }

    function limpiarNumero($rut){
    	$patron = "/[^0-9]/i";    
        $cadena_nueva = preg_replace($patron, "", $rut);
        return $cadena_nueva; 
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

	function IngExcel(){		
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_FILES['excelv']['name'])){
					$excel = $this->limpiaEspacio($_FILES['excelv']['name']);	
					$R=$this->subirArchivos($excel,0,0);
					$this->load->library('phpexcel');
					$BD=$_SESSION["BDSecundaria"];
					$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
					$objReader = PHPExcel_IOFactory::createReader($tipo);
					$object = $objReader->load("archivos/archivos_Temp/".$excel);
					$object->setActiveSheetIndex(0);
					$defaultPrecision = ini_get('precision');
					ini_set('precision', $defaultPrecision);
					$fila=2;
					$var=0;
					$user= array();
				 	set_time_limit(600);
				 	$parametro=0;
				 	$ingr=0;
				 	$error=0;
				 	$contador=0;
				 	$suma=0;
				 	$creador=$_SESSION["Usuario"];
					$cliente=$_SESSION["Cliente"];
				 	while ($parametro==0) {
				 		if($object->getActiveSheet()->getCell('A'.$fila)->getValue()==NULL)
				 		{
				 			$parametro=1;
				 		}else{
				 			$rut[$contador]=$object->getActiveSheet()->getCell('A'.$fila)->getValue();
				 			$idRut[$contador]=$this->limpiarRut($this->limpiarComilla(strtolower($rut[$contador])));
							$userRut=$this->ModuloUsuario->validarRutUsuario($idRut[$contador]);
							if ($userRut!=null) {
								$error=34;
								break;
							}
							$nombre[$contador]=$object->getActiveSheet()->getCell('B'.$fila)->getValue();
							$paterno[$contador]=$object->getActiveSheet()->getCell('C'.$fila)->getValue();
							$materno[$contador]=$object->getActiveSheet()->getCell('D'.$fila)->getValue();
							$genero[$contador]=$object->getActiveSheet()->getCell('E'.$fila)->getValue();
							$genero[$contador]=strtolower($genero[$contador]);
				 			if ($genero[$contador]==null || $genero[$contador]=="" || $genero[$contador]!="masculino" && $genero[$contador]!="femenino") {
				 				$error=35;
				 				echo 3;
				 				break;
				 			}
				 			if ($genero[$contador]=="femenino") {
				 				$genero_id[$contador]=2;
				 			}
				 			elseif ($genero[$contador]=="masculino") {
				 				$genero_id[$contador]=1;
				 			}
					 		$telefono[$contador]=str_replace("+","",str_replace(" ","",$object->getActiveSheet()->getCell('F'.$fila)->getValue()));
					 		if (strlen($telefono[$contador])>12) {
					 			$error=36;
					 			echo 4;
					 			break;
					 		}
					 		$email[$contador]=$object->getActiveSheet()->getCell('G'.$fila)->getValue();
					 		$direccion[$contador]=$object->getActiveSheet()->getCell('H'.$fila)->getValue();
					 		$cargo[$contador]=$object->getActiveSheet()->getCell('I'.$fila)->getValue();
					 		$perfil[$contador]=$object->getActiveSheet()->getCell('J'.$fila)->getValue();
					 		$perfilVal[$contador]=$this->ModuloUsuario->BuscarIdPerfilMasivo($perfil[$contador]);
					 		if ($perfilVal[$contador]["id_perfil"]==null) {
					 			$error=37;
					 			echo 5;
					 			break;
					 		}
					 		$usuario[$contador]=$object->getActiveSheet()->getCell('K'.$fila)->getValue();
					 		$clave[$contador]=$object->getActiveSheet()->getCell('L'.$fila)->getValue();
				 			$fila++;
				 			$contador++;
				 		}
				 	}
				 	if ($error==0) {
				 		for ($i=0; $i <$contador; $i++) { 
							//Creamos el Token de cada usuario
							$token = $this->CrearToken();
				 			$cant=$this->ModuloUsuario->ingresarUsuario($idRut[$i],$nombre[$i],$paterno[$i],$materno[$i],$genero_id[$i],$telefono[$i],$email[$i],$direccion[$i],$cargo[$i],$creador,$cliente,$perfilVal[$i]["id_perfil"],$usuario[$i],openssl_encrypt($clave[$i],"AES-128-ECB","12314"));
				 			$this->ModuloUsuario->ingresarTokenUsuario($idRut[$i],$token);
							$suma=($suma+$cant['CantidadInsertadas']);
				 		}
				 		$mens['tipo'] = 33;
				 		$mens['cantidad']=$suma;
				 		$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["Perfiles"]  = $this->ModuloUsuario->listarPerfilesActivos();
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$data["Grupos"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
						$data["Cargo"] = $_SESSION["Cargo"];
						$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
						$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
						$this->load->view('contenido');
						$this->load->view('layout/header',$data);
			   			$this->load->view('layout/sidebar',$data);
			   			$this->load->view('admin/adminCrearUsuarios',$data);
					   	$this->load->view('layout/footer',$data);
					   	$this->load->view('layout/mensajes',$mens);
				 	}else{
				 		$mens['tipo'] = $error;
				 		$mens['cantidad']=($contador+1);
				 		$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["Perfiles"]  = $this->ModuloUsuario->listarPerfilesActivos();
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$data["Grupos"] = $this->ModuloUsuario->listarGrupoUsuariosActivos($_SESSION["Cliente"]);
						$data["Cargo"] = $_SESSION["Cargo"];
						$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
						$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
						$this->load->view('contenido');
						$this->load->view('layout/header',$data);
			   			$this->load->view('layout/sidebar',$data);
			   			$this->load->view('admin/adminCrearUsuarios',$data);
					   	$this->load->view('layout/footer',$data);
					   	$this->load->view('layout/mensajes',$mens);
				 		}
					}		
				}
			}
		}


	function IngExcelGrupo(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_FILES['excelvg']['name'])){
					$excel = $this->limpiaEspacio($_FILES['excelvg']['name']);	
					$R=$this->subirArchivosG($excel,0,0);
					$this->load->library('phpexcel');
					$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
					$objReader = PHPExcel_IOFactory::createReader($tipo);
					$object = $objReader->load("archivos/archivos_Temp/".$excel);
					$object->setActiveSheetIndex(0);
					$defaultPrecision = ini_get('precision');
					ini_set('precision', $defaultPrecision);
					$fila=2;
					$var=0;
				 	set_time_limit(600);
				 	$parametro =0;	 
				 	$error=0;
				 	$contador=0;	
					$creador=$_SESSION["Usuario"];
				 	$cliente=$_SESSION["Cliente"];
			 		while($parametro==0){	
				 		if($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue()==NULL)
				 		{
				 			$parametro=1;
				 		}else{
				 			$grupoU=$object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue();		 				
			 				if($grupoU==null || $grupoU==''){
			 					$parametro=1;
			 					$error=55;	
				 				break;
				 			}else{
				 				$validarGU=$this->ModuloUsuario->validarITGrupoU($grupoU);
				 				if($validarGU==null || $validarGU==''){
				 					$parametro=1;
				 					$error=57;	
					 				break;
				 				}else{
				 					$GU[$contador]=$grupoU;
				 				}
				 			}
				 			$u=$object->getActiveSheet()->getCell('B'.$fila)->getCalculatedValue();
				 			if ($u==null || $u=='') {
				 				$parametro=1;
			 					$error=56;	
				 				break;
				 			}else{	
				 				$us=$this->ModuloUsuario->buscarIdUser($u);
				 				if($us==null || $us==''){
				 					$parametro=1;
				 					$error=58;	
					 				break;
				 				}else{
				 					$Usu[$contador]=$us->id_usuario;
				 				}
				 			}
			 				$fila++;
			 				$contador++;
				 		}
					}
					$suma=0;
	    			if($error==0){	
		    			for($i=0; $i <$contador; $i++){ 
	    					$cant=$this->ModuloUsuario->ingresarITGrupoU($Usu[$i],$GU[$i],$cliente,$creador);
	    					$suma=($suma+$cant["CantidadInsertadas"]);
	    				}    				 					
	    				$mens['tipo'] = 59;
	    				$mens['cantidad']=$suma;					
						$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuarios($_SESSION["Cliente"]);
						$data["UsuariosA"]= $this->ModuloUsuario->listarUsuariosActivos($_SESSION["Cliente"]);
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$data["Cargo"] = $_SESSION["Cargo"];
						$this->load->view('contenido');						
						$this->load->view('layout/header',$data);
			   			$this->load->view('layout/sidebar',$data);
			   			$this->load->view('admin/adminGrupoUsuarios',$data);
					   	$this->load->view('layout/footer',$data);
					   	$this->load->view('layout/mensajes',$mens);
	 				}else{
	 					$mens['tipo'] = $error;
	    				$mens['cantidad']=($contador+1);
						$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["GrupoU"] = $this->ModuloUsuario->listarGrupoUsuarios($_SESSION["Cliente"]);
						$data["UsuariosA"]= $this->ModuloUsuario->listarUsuariosActivos($_SESSION["Cliente"]);
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$data["Cargo"] = $_SESSION["Cargo"];
						$this->load->view('contenido');						
						$this->load->view('layout/header',$data);
			   			$this->load->view('layout/sidebar',$data);
			   			$this->load->view('admin/adminGrupoUsuarios',$data);
					   	$this->load->view('layout/footer',$data);
					   	$this->load->view('layout/mensajes',$mens);
	 				}	
				}else{
					redirect(site_url("Adm_ModuloUsuario/listarGrupoUsuarios"));
				}	    		
			}else{
				redirect(site_url("login/inicio"));
			}
		}else{
			redirect(site_url("login/inicio"));
		}
	}

	function limpiaEspacio($var){
    	$patron = "/[' ']/i";
		$cadena_nueva = preg_replace($patron,"",$var);
		return $cadena_nueva; 
 	}

 	public function subirArchivos($filename){
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

	public function subirArchivosG($filename){
		$archivo ='excelvg';
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

	function generarExcelUsuarios(){
    	$BD=$_SESSION["BDSecundaria"];
    	$this->load->library('phpexcel');
		$objReader =  PHPExcel_IOFactory::createReader('Excel2007');		
		$object = $objReader->load("doc/plantilla/PlantillaListaUsuarios.xlsx");
		if(isset($_POST["txt_activo"])){
			$vigencia=$_POST["txt_activo"];
		}else{
			$vigencia='2';
		}
		$dataUsuarios= $this->ModuloUsuario->listarUsuariosEstado($_SESSION["Cliente"],$vigencia);
		$object->setActiveSheetIndex(0); 
		$column_row=2;
	 	foreach($dataUsuarios as $row)
	 	{	 
	 		if($row["Activo"]==0){
	 			$estado='Inactivo';
	 		}else{
	 			$estado='Activo';
	 		}
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['RUT']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $row['Nombres']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $row['ApellidoP']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(3 , $column_row, $row['ApellidoM']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(4 , $column_row, $row['Genero']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(5 , $column_row, $row['Telefono']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(6 , $column_row, $row['Email']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(7 , $column_row, $row['Direccion']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(8 , $column_row, $row['Cargo']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(9 , $column_row, $row['NombrePerfil']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(10 , $column_row, $row['Usuario']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(11 , $column_row, $estado);
	 		$column_row++;	 		
	 	}
	 	header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="ListaUsuarios.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
    }

	function adminPermisos(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Usuarios"]= $this->ModuloUsuario->listarUsuariosCoordinador($_SESSION["Cliente"]);
				$data["Modulos"]=$this->ModuloUsuario->listarModuloUsuario();
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Cargo"] = $_SESSION["Cargo"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminUsuariosPermisos',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function asignarModulo(){
		$id_usuario=$_POST["id"];
		$Modulos=$this->ModuloUsuario->listarModuloUsuario();
		$mod=$this->ModuloUsuario->cargarModuloAsignado($id_usuario);	
		echo"<div class='modal-body'>
				<div class='card-body'>
				<form method='POST' id='formModulo'>
					<label for='company'>Módulos</label>
                    <div class='input-group'>
                        <span class='input-group-addon'><i class='fa fa-gears (alias)'></i></span>
                            <select id='msltModulo' class='form-control select2' data-plugin='select2' multiple  id='txt_modulo[]' name='txt_modulo[]' style='width: 100%;''>";  
                                    foreach ($Modulos as $mm) {
                                        echo "<option value='".$mm['ID_Modulo']."'";
                                        foreach ($mod as $m) {
		                            		if($m["FK_ID_Modulo"]==$mm["ID_Modulo"]){
		                            			echo " selected ";
		                            		}
		                            	}
		                            	echo ">".$mm['NombreModulo']."</option>";    
                                	}
                             echo "</select> 
                             <input type='hidden' name='txt_id_usuario' id='txt_id_usuario' value='".$id_usuario."'>
                    </div> 
                    </form>
				</div>
			</div>

			<div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'><i class='fa fa-window-close-o'></i> Cerrar</button>
                <button type='submit' class='btn btn-danger' onclick='return ValidarAsignarModulo();'><i class='fa fa-check-square-o'  id='botonAsignarModulo'></i> Asignar Módulos</button>
            </div>

			<script src='".site_url()."assets/libs/select2/dist/js/select2.min.js'></script>
            <script type='text/javascript'>

            	$('#msltModulo').select2({});

            	function ValidarAsignarModulo(){
            		if(validarModuloAsig()==false){
                        return false;
                        }else{   					   
					         $.ajax({
					            url: 'AsignarModuloUsuario',
					            method: 'POST',
					            data: $('#formModulo').serialize(), 
					            success: function(data) {
					            	alertify.success('Modulos Asignados');
					            	setTimeout(function(){
			                             window.location = 'adminPermisos';
			                    		 }, 1000); 
					            }
					        });
					    }
            	}

            	function validarModuloAsig(){
						var vacios=0;
                        var valido=true;
                        if($('#msltModulo').val()==''){  
                            alertify.error('Debe elegir a lo menos un módulo'); 
                            vacios+=1;
                        } else { 
                            $('#msltModulo').attr('class', 'form-control is-valid');   
                        }
                        if($('#msltModulo').val()=='10'){  
                            alertify.error('Debe elegir el módulo usuarios para poder asignar este botón'); 
                            vacios+=1;
                        } else { 
                            $('#msltModulo').attr('class', 'form-control is-valid');   
                        }
                        if($('#msltModulo').val()=='11'){  
                            alertify.error('Debe elegir el módulo jornadas para poder asignar este botón'); 
                            vacios+=1;
                        } else { 
                            $('#msltModulo').attr('class', 'form-control is-valid');   
                        }
                        if($('#msltModulo').val()=='12'){  
                            alertify.error('Debe elegir el módulo jornadas para poder asignar este botón'); 
                            vacios+=1;
                        } else { 
                            $('#msltModulo').attr('class', 'form-control is-valid');   
                        }
                        if(vacios>0){ valido=false; }
                        return valido;
					}

            </script>";
	}

	function AsignarModuloUsuario(){
		$this->load->model("ModuloUsuario");
		$id_cliente=$_SESSION["Cliente"];
		$id_usuario=$_POST["txt_id_usuario"];
		$modulos=$_POST["txt_modulo"];
		foreach ($modulos as $mm) {
    		$this->ModuloUsuario->DesactivarModuloAsignado($id_usuario);
    	}
		foreach ($modulos as $m) {
			$this->ModuloUsuario->asignarModulo($id_cliente,$id_usuario,$m);
		}
	}
	
	function CrearToken(){
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
	    $d = new DateTime(date('Y-m-d H:i:s.'.$micro, $t));
		$newtoken =  hash("sha512",$d->format("Y-m-d H:i:s.u"));
		return $newtoken;
	}
	
	
} 