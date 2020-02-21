<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class App_ModuloPerfilUsuario extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper("url","form");	
		$this->load->library('form_validation'); 	
		$this->load->model("funcion_login");
		$this->load->library('upload');
	}


	function ModificarPerfil(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){ 
			  $this->load->model("ModuloJornadas");
			  $this->load->model("moduloUsuarioApp");									
		   		$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$BD=$_SESSION["BDSecundaria"];
				$idUser=$_SESSION["Usuario"];
				$data["info"]= $this->moduloUsuarioApp->InfoUsuario($idUser);
				$data["clave"] = openssl_decrypt($data["info"]["Clave"],"AES-128-ECB","12314");
				$msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				$data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				$data["cantidadMsj"]=count($data["mensaje"]);
				$data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
				$data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
				$this->load->view('contenido');
				$this->load->view('layout/headerApp',$data);
	        	$this->load->view('layout/sidebarApp',$data);
			   	$this->load->view('App/PerfilApp',$data);
			   	$this->load->view('layout/footerApp',$data);	
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function ModificarDireccion(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){ 
			  	$this->load->model("moduloUsuarioApp");									
		   		$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$BD=$_SESSION["BDSecundaria"];
				$idUser=$_SESSION["Usuario"];
				$direccion=$_POST["dir"];
				$mail=$_POST['mail'];
				$this->moduloUsuarioApp->EditarDireccionUsuario($idUser,$direccion);
				$asunto='Notificación de cambio de Dirección - I-Audisis';
				$EmailEmpleador='notificaciones-audisis@audisischile.com';				
				$mnsj="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
						<html xmlns='http://www.w3.org/1999/xhtml'>
						<head>
						    <meta charset='utf-8'>
						    <meta http-equiv='x-ua-compatible' content='ie=edge'>
						    <meta name='description' content='Admin, Dashboard, Bootstrap' />
						    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
							<meta name='theme-color' content='#ffffff'>
						</head> 
						<body> 
							<section class='container-pages'> 			
								<div class='card pages-card col-lg-4 col-md-6 col-sm-6'> 
									<div class='card-body '> 
										<div class='user-img text-center'> 
											<div class='h4 text-center text-theme'><strong>Notificacion de Cambio de direccion</strong></div></div>
							                <div class='h4 text-center text-dark'> Sr(a). ".$_SESSION["Nombre"]." </div>
							                <div class='small text-center text-dark'>Se ha modificado su dirección(".$direccion.") con exito.</div>	               
							            </div>
							        </div>
							    </section>
							    <div class='half-circle'></div>
							    <div class='small-circle'></div>
							    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>							    
							</body>
						</html>";
				$this->enviaremail($mail,$mnsj,$asunto,$EmailEmpleador);

				echo 1;

			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function ModificarEmail(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){ 
			  	$this->load->model("moduloUsuarioApp");									
		   		$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$BD=$_SESSION["BDSecundaria"];
				$idUser=$_SESSION["Usuario"];
				$email=$_POST["email"];
				$this->moduloUsuarioApp->EditarEmailUsuario($idUser,$email);
				$asunto='Notificación de cambio de Mail - I-Audisis';
				$EmailEmpleador='notificaciones-audisis@audisischile.com';				
				$mnsj="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
						<html xmlns='http://www.w3.org/1999/xhtml'>
						<head>
						    <meta charset='utf-8'>
						    <meta http-equiv='x-ua-compatible' content='ie=edge'>
						    <meta name='description' content='Admin, Dashboard, Bootstrap' />
						    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
							<meta name='theme-color' content='#ffffff'>
						</head> 
						<body> 
							<section class='container-pages'> 			
								<div class='card pages-card col-lg-4 col-md-6 col-sm-6'> 
									<div class='card-body '> 
										<div class='user-img text-center'> 
											<div class='h4 text-center text-theme'><strong>Notificacion de Cambio de Email</strong></div></div>
							                <div class='h4 text-center text-dark'> Sr(a). ".$_SESSION["Nombre"]." </div>
							                <div class='small text-center text-dark'>Se ha modificado su correo con exito.</div>	               
							            </div>
							        </div>
							    </section>
							    <div class='half-circle'></div>
							    <div class='small-circle'></div>
							    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>							    
							</body>
						</html>";
				$this->enviaremail($email,$mnsj,$asunto,$EmailEmpleador);

				echo 1;

			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function ModificarFoto(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){
				if(isset($_FILES["tx_foto"])){
				  	$this->load->model("moduloUsuarioApp");	
				  	$idUser=$_SESSION["Usuario"];
				  	$tipo=str_replace("image/",".",$_FILES['tx_foto']['type']);
				  	$direction ='archivos/foto_trabajador/usuario_'.$idUser.$tipo;
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
					if($_FILES['tx_foto']['type']=='image/jpeg'){
						imagejpeg($lienzo,$direction);
					} else if($_FILES['tx_foto']['type']=='image/png'){
						imagepng($lienzo,$direction);
					} else if($_FILES['tx_foto']['type']=='image/gif'){
						imagegif($lienzo,$direction);
					} else if($_FILES['tx_foto']['type']=='image/jpg'){
						imagejpeg($lienzo,$direction);
					}	
					$this->moduloUsuarioApp->EditarFotoUsuario($idUser,$direction);			
					echo 1;
				}else{
					redirect(site_url("App_ModuloPerfilUsuario/ModificarPerfil"));	
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function ModificarFono(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){ 
			  	$this->load->model("moduloUsuarioApp");									
		   		$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$BD=$_SESSION["BDSecundaria"];
				$idUser=$_SESSION["Usuario"];
				$fono=$_POST["fono"];
				$mail=$_POST['mail'];
				$this->moduloUsuarioApp->EditarFonoUsuario($idUser,$fono);
				$asunto='Notificación de cambio de Telefono - I-Audisis';
				$EmailEmpleador='notificaciones-audisis@audisischile.com';				
				$mnsj="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
						<html xmlns='http://www.w3.org/1999/xhtml'>
						<head>
						    <meta charset='utf-8'>
						    <meta http-equiv='x-ua-compatible' content='ie=edge'>
						    <meta name='description' content='Admin, Dashboard, Bootstrap' />
						    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
							<meta name='theme-color' content='#ffffff'>
						</head> 
						<body> 
							<section class='container-pages'> 			
								<div class='card pages-card col-lg-4 col-md-6 col-sm-6'> 
									<div class='card-body '> 
										<div class='user-img text-center'> 
											<div class='h4 text-center text-theme'><strong>Notificacion de Cambio de Telefono</strong></div></div>
							                <div class='h4 text-center text-dark'> Sr(a). ".$_SESSION["Nombre"]." </div>
							                <div class='small text-center text-dark'>Se ha modificado su Telefono(".$mail.") con exito.</div>	               
							            </div>
							        </div>
							    </section>
							    <div class='half-circle'></div>
							    <div class='small-circle'></div>
							    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>							    
							</body>
						</html>";
				$this->enviaremail($mail,$mnsj,$asunto,$EmailEmpleador);
				echo 1;

			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function ModificarContrasenia(){
	  	$this->load->model("moduloUsuarioApp");											   		
		if(isset($_POST["usuario"])){
			$nombre='';
			$idUser=$_POST["usuario"];
		}else{
			$nombre=$_SESSION["Nombre"];	
			$idUser=$_SESSION["Usuario"];
		}				
		$mail=$_POST['mail'];				
		$pass=openssl_encrypt($_POST["pass"],"AES-128-ECB","12314");
		$this->moduloUsuarioApp->EditarPassUsuario($idUser,$pass);
		$asunto='Notificación de cambio de Contraseña - I-Audisis';
		$EmailEmpleador='notificaciones-audisis@audisischile.com';				
		$mnsj="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
				<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
				    <meta charset='utf-8'>
				    <meta http-equiv='x-ua-compatible' content='ie=edge'>
				    <meta name='description' content='Admin, Dashboard, Bootstrap' />
				    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
					<meta name='theme-color' content='#ffffff'>
				</head> 
				<body> 
					<section class='container-pages'> 			
						<div class='card pages-card col-lg-4 col-md-6 col-sm-6'> 
							<div class='card-body '> 
								<div class='user-img text-center'> 
									<div class='h4 text-center text-theme'><strong>Notificacion de Cambio de Contraseña</strong></div></div>
					                <div class='h4 text-center text-dark'> Sr(a). ".$nombre." </div>
					                <div class='small text-center text-dark'>Se ha modificado su Contraseña con exito.</div>               
					            </div>
					        </div>
					    </section>
					    <div class='half-circle'></div>
					    <div class='small-circle'></div>
					    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>							    
					</body>
				</html>";
		$this->enviaremail($mail,$mnsj,$asunto,$EmailEmpleador);
		echo 1;
	}


	function VerMarcacion(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){ 
				$this->load->model("ModuloJornadas");
				$this->load->model("ModuloReportes");
				$this->load->model("ModuloDocumento");				
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$BD=$_SESSION["BDSecundaria"];
				$idUser=$_SESSION["Usuario"];
				$msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
				$data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				$data["cantidadMsj"]=count($data["mensaje"]);
				$data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
				$data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
				$data["Fechas"]= $this->ModuloReportes->FechasLibroAsistenciaMes($BD,$idUser);
				$this->load->view('contenido');
				$this->load->view('layout/headerApp',$data);
	        	$this->load->view('layout/sidebarApp',$data);
			   	$this->load->view('App/appLibroMarcacion',$data);
			   	$this->load->view('layout/footerApp',$data);	
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function mostrarLibroMarcacion(){	
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){
				if(isset($_POST["fechas"])){
					$this->load->model("moduloUsuarioApp");
					$info=$_POST["fechas"];
			 		$op = explode("/", $info);
			 		$BD=$_SESSION["BDSecundaria"];
					$idUser=$_SESSION["Usuario"];
					$datos= $this->moduloUsuarioApp->ListarLibroMarcacion($idUser,$op[0],$op[1],$BD);
					$locales=$this->moduloUsuarioApp->ListarLocalesAsignados($idUser,$BD);
					$dias=$this->moduloUsuarioApp->ListarDiasAsignados($idUser,$BD);
					echo '
						<div class="col-md-12">
						<input type="hidden" id="fecha" value="'.$info.'">
						<select class="form-control" id="txt_locales" name="txt_locales">						
				              <option value="">Elegir Local</option>';
				                 foreach ($locales as $l) {
				                  	echo '<option value="'.$l["FK_Jornadas_Locales_ID_Local"].'">'.$l["NombreLocal"].'</option>';
				                  } 
				        echo '</select>
				        <br>
				        <select class="form-control" id="txt_dia" name="txt_dia">
				              <option value="">Elegir Día</option>';
				                 foreach ($dias as $d) {
				                  	echo '<option value="'.$d["Fecha"].'">'.$d["Dia"].'</option>';
				                  } 
				        echo '</select>
				        <br>
				        <button type="button" class="form-control btn btn-danger" title="Buscar" id="botonBuscar" onclick="Filtrar()"><i class="mdi mdi-search-web"></i>&nbsp;&nbsp;Buscar Marcaciones</button>
				        <button style="display:none;" type="button" class="form-control btn btn-danger" title="Limpiar" id="botonLimpiar" onclick="Limpiar()"><i class="mdi mdi-refresh"></i>&nbsp;&nbsp;Reiniciar Búsqueda</button>
				        </div>
				        <hr>
						<div class="col-md-12">
		                    <div class="card card-accent-theme">
		                        <div class="card-body">
		                            <h4 class="text-theme">Marcaciones</h4>     
		                            <br>                      
		                            <div class="table-responsive">
		                                <table class="table" style="font-size: 13px;">
	                                        <tr>
	                                            <th>Fecha</th>
	                                            <th>Local</th>
	                                            <th>Programado</th>
	                                            <th>Marcado</th>
	                                            <th>Estado</th>
	                                        </tr>
		                                    <tbody>';
		                                        foreach ($datos as $d) {
		                                        	if($d["Modificado"]==1){$color="color:red;";}else{$color="";}
		                                        	echo '<tr>';
		                                        	echo '<td style="'.$color.'">'.$d["Fecha"].'</td>';
		                                        	echo '<td style="'.$color.'">'.$d["NombreLocal"].'</td>';
		                                        	echo '<td style="'.$color.'">'.$d["Programado"].'</td>';
		                                        	echo '<td style="'.$color.'">'.$d["Marcado"].'</td>';
		                                        	echo '<td>';
		                                        	if($d["Marcado"]!='-'){
		                                        		if(isset($d["HorasAtraso"])){
			                                        		if($d["HorasAtraso"]!='00:00:00'){
			                                        			echo "Atraso";
			                                        		}
			                                        	}else{
			                                        		echo "Libre";
			                                        	}
		                                        	}else{
		                                        		echo "Falta";
		                                        	}
		                                        	echo'</td>';
		                                        	echo '</tr>';
		                                        }
		                                    echo '</tbody>
		                                </table>
		                            </div>
		                        </div>
		                    </div>
		                </div>

		                <script type="text/javascript">

							    function Filtrar(){
							        $("#loader").removeAttr("style","table-loading-overlay");
							        var dia=$("#txt_dia").val(); 
							        var id_local=$("#txt_locales").val(); 
							        var fecha=$("#fecha").val();
							        $.ajax({
							            url: "filtrarHorario",
							            type: "POST",
							            data: "dia="+dia+"&id_local="+id_local+"&fecha="+fecha,
							            success: function(data){
							            	$("#botonBuscar").hide("slow");
				                			$("#botonLimpiar").show("slow");
							                $("#loader").attr("style","display:none;");
							                $("#div_libro").html("");
							                $("#div_libro").html(data);
							            }
							        });
							    }

							    function Limpiar(){
							    	setTimeout(function(){
										window.location = "VerMarcacion";
									}, 1000); 
							    }

						</script>
		                ';
				}else{
					redirect(site_url("App_ModuloPerfilUsuario/VerMarcacion"));	
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function filtrarHorario(){			
		$this->load->model("moduloUsuarioApp");	
		$hoy=getdate();		
		if ($_POST["id_local"]=="" || !isset($_POST["id_local"])) {
			$id_local="00";
		}else{		
			$id_local=$_POST["id_local"];
		}
		if ($_POST["dia"]=="" || !isset($_POST["dia"])) {
			$fecha="00";
		}else{		
			$fecha=$hoy["year"]."-".$hoy["mon"]."-".$_POST["dia"];
		}
		if (!isset($idUser)) {
			$idUser=$_SESSION["Usuario"];
		}else{
			$idUser=$_SESSION["Usuario"];
		}
		$info=$_POST["fecha"];
 		$op = explode("/", $info);
 		$BD=$_SESSION["BDSecundaria"];
		$idUser=$_SESSION["Usuario"];
		// var_dump($id_local,$idUser,$fecha,$op[0],$op[1]);exit();
		$datos= $this->moduloUsuarioApp->ListarLibroMarcacionFiltrado($id_local,$idUser,$fecha,$op[0],$op[1],$BD);
		$locales=$this->moduloUsuarioApp->ListarLocalesAsignados($idUser,$BD);
		$dias=$this->moduloUsuarioApp->ListarDiasAsignados($idUser,$BD);
		echo '
			<div class="col-md-12">
			<select class="form-control" id="txt_locales" name="txt_locales">
	              <option value="">Elegir Local</option>';
	                 foreach ($locales as $l) {
	                  	echo '<option value="'.$l["FK_Jornadas_Locales_ID_Local"].'">'.$l["NombreLocal"].'</option>';
	                  } 
	        echo '</select>
	        <br>
	        <select class="form-control" id="txt_dia" name="txt_dia">
	              <option value="">Elegir Día</option>';
	                 foreach ($dias as $d) {
	                  	echo '<option value="'.$d["Dia"].'">'.$d["Dia"].'</option>';
	                  } 
	        echo '</select>
	        <br>
	        <button style="display:none;" type="button" class="form-control btn btn-danger" title="Buscar" id="botonBuscar" onclick="Filtrar()"><i class="mdi mdi-search-web"></i>&nbsp;&nbsp;Buscar Marcaciones</button>
	        <button type="button" class="form-control btn btn-danger" title="Limpiar" id="botonLimpiar" onclick="Limpiar()"><i class="mdi mdi-refresh"></i>&nbsp;&nbsp;Reiniciar Búsqueda</button>
	        </div>
	        <hr>
			<div class="col-md-12">
                <div class="card card-accent-theme">
                    <div class="card-body">
                        <h4 class="text-theme">Marcaciones</h4>     
                        <br>                      
                        <div class="table-responsive">
                            <table class="table" style="font-size: 13px;">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Local</th>
                                    <th>Programado</th>
                                    <th>Marcado</th>
                                    <th>Estado</th>
                                </tr>
                                <tbody>';
                                    foreach ($datos as $d) {
                                    	if($d["Modificado"]==1){$color="color:red;";}else{$color="";}
                                    	echo '<tr>';
                                    	echo '<td style="'.$color.'">'.$d["Fecha"].'</td>';
                                    	echo '<td style="'.$color.'">'.$d["NombreLocal"].'</td>';
                                    	echo '<td style="'.$color.'">'.$d["Programado"].'</td>';
                                    	echo '<td style="'.$color.'">'.$d["Marcado"].'</td>';
                                    	echo '<td>';
                                    	if($d["Marcado"]!='-'){
                                    		if(isset($d["HorasAtraso"])){
                                        		if($d["HorasAtraso"]!='00:00:00'){
                                        			echo "Atraso";
                                        		}
                                        	}else{
                                        		echo "Libre";
                                        	}
                                    	}else{
                                    		echo "Falta";
                                    	}
                                    	echo'</td>';
                                    	echo '</tr>';
                                    }
                                echo '</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">

				    function Filtrar(){
				        $("#loader").removeAttr("style","table-loading-overlay");
				        var dia=$("#txt_dia").val(); 
				        var id_local=$("#txt_locales").val(); 
				        var usuario=$("#id_user").val(); 
				        $.ajax({
				            url: "filtrarHorario",
				            type: "POST",
				            data: "dia="+dia+"&id_local="+id_local+"&usuario="+usuario,
				            success: function(data){
				                $("#botonBuscar").hide("slow");
				                $("#botonLimpiar").show("slow");
				                $("#loader").attr("style","display:none;");
				                $("#div_libro").html("");
				                $("#div_libro").html(data);
				            }
				        });
				    }

				    function Limpiar(){
				    	setTimeout(function(){
							window.location = "VerMarcacion";
						}, 1000); 
				    }

			</script>
            ';
	}

	function cambiarFotografia(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){
				if(isset($_SESSION["txt_foto"])){

				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}	

	function verDocumentos(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){ 
				$this->load->model("moduloUsuarioApp");
				$this->load->model("ModuloJornadas");
				$this->load->model("ModuloDocumento");
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$BD=$_SESSION["BDSecundaria"];
				$idUser=$_SESSION["Usuario"];
				$data["info"]= $this->moduloUsuarioApp->InfoUsuario($idUser);
				$msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
				$data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				$data["cantidadMsj"]=count($data["mensaje"]);
				$data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
				$data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
				$this->load->view('contenido');
				$this->load->view('layout/headerApp',$data);
	        	$this->load->view('layout/sidebarApp',$data);
			   	$this->load->view('App/BibliotecaApp',$data);
			   	$this->load->view('layout/footerApp',$data);
			}
		}	
	}

	function documentosCarpeta(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){ 
				$data["Nombre_Carpeta"]=$_POST["txt_carpeta_nombre"];
				$id_carpeta=$_POST["txt_carpeta"];
				$this->load->model("moduloUsuarioApp");
				$this->load->model("ModuloJornadas");
				$this->load->model("ModuloDocumento");
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$BD=$_SESSION["BDSecundaria"];
				$idUser=$_SESSION["Usuario"];
				$data["Archivos"]=$this->ModuloDocumento->cargarArchivos($BD,$id_carpeta);
				$data["info"]= $this->moduloUsuarioApp->InfoUsuario($idUser);
				$msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
				$data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				$data["cantidadMsj"]=count($data["mensaje"]);
				$data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
				$data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
				$this->load->view('contenido');
				$this->load->view('layout/headerApp',$data);
	        	$this->load->view('layout/sidebarApp',$data);
			   	$this->load->view('App/DocumentosApp',$data);
			   	$this->load->view('layout/footerApp',$data);
			}
		}	
	}

	function contarDescargado(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){ 
				$id_usuario=$_POST["usuario"];
				$id_archivo=$_POST["archivo"];
				$id_carpeta=$_POST["carpeta"];
				$contador=$_POST["contador"];
				$BD=$_SESSION["BDSecundaria"];
				$this->load->model("moduloUsuarioApp");
				$this->moduloUsuarioApp->ingresarContador($BD,$id_usuario,$id_archivo,$id_carpeta,$contador);
			}
		}
	}

	function Requerimiento(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){ 
				$this->load->model("moduloUsuarioApp");
				$this->load->model("ModuloJornadas");
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$BD=$_SESSION["BDSecundaria"];
				$idUser=$_SESSION["Usuario"];
				$data["info"]= $this->moduloUsuarioApp->InfoUsuario($idUser);
				$msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				$data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
				$data["cantidadMsj"]=count($data["mensaje"]);
				$data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
				$data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
				$this->load->view('contenido');
				$this->load->view('layout/headerApp',$data);
	        	$this->load->view('layout/sidebarApp',$data);
			   	$this->load->view('App/RequerimientoApp',$data);
			   	$this->load->view('layout/footerApp',$data);
			}
		}
	}

	function enviarReq(){
		$this->load->model("moduloUsuarioApp");
		$BD=$_SESSION["BDSecundaria"];
		$mensaje=$_POST["mensaje"];
		$latitud=$_POST["latitud"];
		$longitud=$_POST["longitud"];
		$idUser=$_SESSION["Usuario"];
		$this->moduloUsuarioApp->IngresarRequerimiento($BD,$mensaje,$latitud,$longitud,$idUser);
	}	

	function enviaremail($EmailUser,$msjEmail,$titulo,$EmailCli){
		$cabeceras = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$cabeceras .= 'Cc: '.$EmailCli.' '."\r\n";
		$enviado = mail($EmailUser,$titulo,$msjEmail,$cabeceras);
		// $enviado = null;
		return $enviado;
	}	  
}


