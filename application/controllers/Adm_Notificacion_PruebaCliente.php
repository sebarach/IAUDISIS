<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_Notificacion_PruebaCliente extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper("url","form");	
		$this->load->library('form_validation');
		$this->load->model("funcion_login");
		$this->load->library('upload');
		//$this->load->library('email');
		$this->load->library('phpexcel');
		$this->load->library('phpmailer_lib');
	}

	function NotificacionAtrasoEntrada(){
		$this->load->model("moduloNotificacion");
		$BD="I-Audisis_PruebaCliente";
		$Noti=$this->moduloNotificacion->NotificacionAtrazoEntrada($BD);
		$i=0;		
		foreach ($Noti as $c) {
			if (isset($Noti)) {
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
											<div class='h4 text-center text-theme'><strong>Estas Atrasado!</strong></div></div>
							                <div class='h4 text-center text-dark'> Sr(a). ".$c['nombre']." </div>
							                <div class='small text-center text-dark'> Tiene un atraso en el Local:".$c['NombreLocal']."</div>
							                <div class='small text-center text-dark'> Dirección:".$c['Direccion']."</div>
							                <div class='small text-center text-dark'> Hora de Entrada:".$c['entrada']."</div>	               
							            </div>
							            
							        </div>
							        
							    </section>
							    
							    <div class='half-circle'></div>
							    <div class='small-circle'></div>
							    
							    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>
							</body>

							</html>";

				$asunto='Atraso en el Local :'.$c['NombreLocal'];
				$EmailEmpleador=$c['emailCliente'];
				$EmailUser=$c['emailUser'];
				$this->enviaremail($EmailUser,$mnsj,$asunto,$EmailEmpleador);
				$a=$this->moduloNotificacion->ActualizarNotificacionAtrazoEntrada($BD,$c['id_horario']);
				$i++;
			}			
		}
		echo $i;
		
	}

	function ActualizacionNotificacionSalida(){
		$this->load->model("moduloNotificacion");
		$BD="I-Audisis_PruebaCliente";
		$Noti=$this->moduloNotificacion->BuscarNotificacionSalida($BD);
		$i=0;		
		foreach ($Noti as $c) {
			if (isset($Noti)) {
				$mnsj="
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='x-ua-compatible' content='ie=edge'>
    <meta name='description' content='Admin, Dashboard, Bootstrap' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>octAdmin - powerfull minimal ultimate all in one bootstrap admin Template</title>
	<meta name='theme-color' content='#ffffff'>	 
</head> 
	<body> 
		<section class='container-pages'> 
			<div class='brand-logo float-left'>
				<a class='' href='#'>I-audisis</a>
			</div> 
			<div class='pages-tag-line text-white'> 
				<div class='h4'>Bienvenidos a I - Audisis</div> 
				<small> Una nueva experiencia en asistencia y formularios en Ruta.</small> 
			</div> 
			<div class='card pages-card col-lg-4 col-md-6 col-sm-6'> 
				<div class='card-body '> 
					<h4 class='text-theme'>Cierre automatico de Asistencia</h4>
                        <small class='text-muted'>Sr(a) ".$c['nombre'].". ya que usted no ha marcado su salida, el sistema la cerrará automaticamente. Si usted aun esta en su lugar de trabajo, igual lo dejará marcar salida.</small>
                        <hr>
                        <div class='list-group'>
                          <div class='d-flex w-100 justify-content-between'>
                            <h5 class='mb-1 text-muted'>Datos del Usuario</h5>
                            <small>Nombre:".$c['nombre']."</small><br>
                            <small>Rut: ".$c['rut']." </small><br>                                                     
                            <small>Hora Salida: ".$c['salida']."</small><br>                          
                          </div>
                          <hr>
                          <div class='d-flex w-100 justify-content-between'>
                            <h5 class='mb-1'>Datos del Empleador</h5>
                            <small >Rut Empleador: ".$c['RutEmpresa']."</small><br>
                            <small >Razon Social:".$c['RazonSocial']."</small><br>
                            <small >Nombre de Local: ".$c['NombreLocal']."</small><br>
                            <small >Direcion Local: ".$c['Direccion']."</small><br>
                          </div>
                          <hr>
		            <!-- end card-body -->
		        </div>
		        <!-- end card -->
		    </section>
		    <!-- end section container -->
		    <div class='half-circle'></div>
		    <div class='small-circle'></div>

		    <!-- end mybutton -->

		    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>
		    
		   
		    
		</body>

		</html>";


				$asunto='Cierre automatico de Jornada en el Local :'.$c['NombreLocal'];
				$EmailEmpleador=$c['emailCliente'];
				$EmailUser=$c['emailUser'];
				$this->enviaremail($EmailUser,$mnsj,$asunto,$EmailEmpleador);
				$a=$this->moduloNotificacion->ActualizarNotificacionSalida($BD,$c['id_horario'],$c['FK_Jornadas_ID_Jornada'],$c['Latitud'],$c['Longitud'],$c['Salida']);
				$i++;
			}			
		}
		echo $i;
		
	}

	function NotificacionAtrasoEntradaClienteAndina(){
		$this->load->model("moduloNotificacion");
		$BD="I-Audisis_Andina";
		$Noti=$this->moduloNotificacion->NotificacionAtrazoEntrada($BD);
		$i=0;		
		foreach ($Noti as $c) {
			if (isset($Noti)) {
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
											<div class='h4 text-center text-theme'><strong>Estas Atrasado!</strong></div></div>
							                <div class='h4 text-center text-dark'> Sr(a). ".$c['nombre']." </div>
							                <div class='small text-center text-dark'> Tiene un atraso en el Local:".$c['NombreLocal']."</div>
							                <div class='small text-center text-dark'> Dirección:".$c['Direccion']."</div>
							                <div class='small text-center text-dark'> Hora de Entrada:".$c['entrada']."</div>	               
							            </div>
							            
							        </div>
							        
							    </section>
							    
							    <div class='half-circle'></div>
							    <div class='small-circle'></div>
							    
							    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>
							</body>

							</html>";



				$asunto='Atraso en el Local :'.$c['NombreLocal'];
				$EmailEmpleador=$c['emailCliente'];
				$EmailUser=$c['emailUser'];
				$this->enviaremail($EmailUser,$mnsj,$asunto,$EmailEmpleador);
				$a=$this->moduloNotificacion->ActualizarNotificacionAtrazoEntrada($BD,$c['id_horario']);
				$i++;
			}			
		}
		echo $i;
		
	}


	function ActualizacionNotificacionSalidaClienteAndina(){
		$this->load->model("moduloNotificacion");
		$BD="I-Audisis_Andina";
		$Noti=$this->moduloNotificacion->BuscarNotificacionSalida($BD);
		$i=0;		
		foreach ($Noti as $c) {
			if (isset($Noti)) {
				$mnsj="
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='x-ua-compatible' content='ie=edge'>
    <meta name='description' content='Admin, Dashboard, Bootstrap' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>octAdmin - powerfull minimal ultimate all in one bootstrap admin Template</title>
	<meta name='theme-color' content='#ffffff'>	 
</head> 
	<body> 
		<section class='container-pages'> 
			<div class='brand-logo float-left'>
				<a class='' href='#'>I-audisis</a>
			</div> 
			<div class='pages-tag-line text-white'> 
				<div class='h4'>Bienvenidos a I - Audisis</div> 
				<small> Una nueva experiencia en asistencia y formularios en Ruta.</small> 
			</div> 
			<div class='card pages-card col-lg-4 col-md-6 col-sm-6'> 
				<div class='card-body '> 
					<h4 class='text-theme'>Cierre automatico de Asistencia</h4>
                        <small class='text-muted'>Sr(a) ".$c['nombre'].". ya que usted no ha marcado su salida, el sistema la cerrará automaticamente. Si usted aun esta en su lugar de trabajo, igual lo dejará marcar salida.</small>
                        <hr>
                        <div class='list-group'>
                          <div class='d-flex w-100 justify-content-between'>
                            <h5 class='mb-1 text-muted'>Datos del Usuario</h5>
                            <small>Nombre:".$c['nombre']."</small><br>
                            <small>Rut: ".$c['rut']." </small><br>                                                     
                            <small>Hora Salida: ".$c['salida']."</small><br>                          
                          </div>
                          <hr>
                          <div class='d-flex w-100 justify-content-between'>
                            <h5 class='mb-1'>Datos del Local</h5>
                            <small >Nombre de Local: ".$c['NombreLocal']."</small><br>
                            <small >Direcion Local: ".$c['Direccion']."</small><br>
                          </div>
                          <hr>
		            <!-- end card-body -->
		        </div>
		        <!-- end card -->
		    </section>
		    <!-- end section container -->
		    <div class='half-circle'></div>
		    <div class='small-circle'></div>

		    <!-- end mybutton -->

		    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>
		    
		   
		    
		</body>

		</html>";



				$asunto='Cierre automatico de Jornada en el Local :'.$c['NombreLocal'];
				$EmailEmpleador=$c['emailCliente'];
				$EmailUser=$c['emailUser'];
				$this->enviaremail($EmailUser,$mnsj,$asunto,$EmailEmpleador);
				$a=$this->moduloNotificacion->ActualizarNotificacionSalida($BD,$c['id_horario'],$c['FK_Jornadas_ID_Jornada'],$c['Latitud'],$c['Longitud'],$c['Salida']);
				$i++;
			}			
		}
		echo $i;
		
	}

function NotificacionAtrasoEntradaClienteForus(){
		$this->load->model("moduloNotificacion");
		$BD="I-Audisis_Forus";
		$Noti=$this->moduloNotificacion->NotificacionAtrazoEntrada($BD);
		$i=0;		
		foreach ($Noti as $c) {
			if (isset($Noti)) {
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
											<div class='h4 text-center text-theme'><strong>Estas Atrasado!</strong></div></div>
							                <div class='h4 text-center text-dark'> Sr(a). ".$c['nombre']." </div>
							                <div class='small text-center text-dark'> Tiene un atraso en el Local:".$c['NombreLocal']."</div>
							                <div class='small text-center text-dark'> Dirección:".$c['Direccion']."</div>
							                <div class='small text-center text-dark'> Hora de Entrada:".$c['entrada']."</div>	               
							            </div>
							            
							        </div>
							        
							    </section>
							    
							    <div class='half-circle'></div>
							    <div class='small-circle'></div>
							    
							    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>
							</body>

							</html>";



				$asunto='Atraso en el Local :'.$c['NombreLocal'];
				$EmailEmpleador=$c['emailCliente'];
				$EmailUser=$c['emailUser'];
				$this->enviaremail($EmailUser,$mnsj,$asunto,$EmailEmpleador);
				$a=$this->moduloNotificacion->ActualizarNotificacionAtrazoEntrada($BD,$c['id_horario']);
				$i++;
			}			
		}
		echo $i;
		
	}


	function ActualizacionNotificacionSalidaClienteForus(){
		$this->load->model("moduloNotificacion");
		$BD="I-Audisis_Forus";
		$Noti=$this->moduloNotificacion->BuscarNotificacionSalida($BD);
		$i=0;		
		foreach ($Noti as $c) {
			if (isset($Noti)) {
				$mnsj="
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='x-ua-compatible' content='ie=edge'>
    <meta name='description' content='Admin, Dashboard, Bootstrap' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>octAdmin - powerfull minimal ultimate all in one bootstrap admin Template</title>
	<meta name='theme-color' content='#ffffff'>	 
</head> 
	<body> 
		<section class='container-pages'> 
			<div class='brand-logo float-left'>
				<a class='' href='#'>I-audisis</a>
			</div> 
			<div class='pages-tag-line text-white'> 
				<div class='h4'>Bienvenidos a I - Audisis</div> 
				<small> Una nueva experiencia en asistencia y formularios en Ruta.</small> 
			</div> 
			<div class='card pages-card col-lg-4 col-md-6 col-sm-6'> 
				<div class='card-body '> 
					<h4 class='text-theme'>Cierre automatico de Asistencia</h4>
                        <small class='text-muted'>Sr(a) ".$c['nombre'].". ya que usted no ha marcado su salida, el sistema la cerrará automaticamente. Si usted aun esta en su lugar de trabajo, igual lo dejará marcar salida.</small>
                        <hr>
                        <div class='list-group'>
                          <div class='d-flex w-100 justify-content-between'>
                            <h5 class='mb-1 text-muted'>Datos del Usuario</h5>
                            <small>Nombre:".$c['nombre']."</small><br>
                            <small>Rut: ".$c['rut']." </small><br>                                                     
                            <small>Hora Salida: ".$c['salida']."</small><br>                          
                          </div>
                          <hr>
                          <div class='d-flex w-100 justify-content-between'>
                            <h5 class='mb-1'>Datos del Empleador</h5>
                            <small >Rut Empleador: ".$c['RutEmpresa']."</small><br>
                            <small >Razon Social:".$c['RazonSocial']."</small><br>
                            <small >Nombre de Local: ".$c['NombreLocal']."</small><br>
                            <small >Direcion Local: ".$c['Direccion']."</small><br>
                          </div>
                          <hr>
		            <!-- end card-body -->
		        </div>
		        <!-- end card -->
		    </section>
		    <!-- end section container -->
		    <div class='half-circle'></div>
		    <div class='small-circle'></div>

		    <!-- end mybutton -->

		    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>
		    
		   
		    
		</body>

		</html>";



				$asunto='Cierre automatico de Jornada en el Local :'.$c['NombreLocal'];
				$EmailEmpleador=$c['emailCliente'];
				$EmailUser=$c['emailUser'];
				$this->enviaremail($EmailUser,$mnsj,$asunto,$EmailEmpleador);
				$a=$this->moduloNotificacion->ActualizarNotificacionSalida($BD,$c['id_horario'],$c['FK_Jornadas_ID_Jornada'],$c['Latitud'],$c['Longitud'],$c['Salida']);
				$i++;
			}			
		}
		echo $i;
		
	}

	function NotificacionAtrasoEntradaClientePF(){
		$this->load->model("moduloNotificacion");
		$BD="I-Audisis_PFAlimentos";
		$Noti=$this->moduloNotificacion->NotificacionAtrazoEntrada($BD);
		$i=0;		
		foreach ($Noti as $c) {
			if (isset($Noti)) {
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
											<div class='h4 text-center text-theme'><strong>Estas Atrasado!</strong></div></div>
							                <div class='h4 text-center text-dark'> Sr(a). ".$c['nombre']." </div>
							                <div class='small text-center text-dark'> Tiene un atraso en el Local:".$c['NombreLocal']."</div>
							                <div class='small text-center text-dark'> Dirección:".$c['Direccion']."</div>
							                <div class='small text-center text-dark'> Hora de Entrada:".$c['entrada']."</div>	               
							            </div>
							            
							        </div>
							        
							    </section>
							    
							    <div class='half-circle'></div>
							    <div class='small-circle'></div>
							    
							    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>
							</body>

							</html>";



				$asunto='Atraso en el Local :'.$c['NombreLocal'];
				$EmailEmpleador=$c['emailCliente'];
				$EmailUser=$c['emailUser'];
				$this->enviaremail($EmailUser,$mnsj,$asunto,$EmailEmpleador);
				$a=$this->moduloNotificacion->ActualizarNotificacionAtrazoEntrada($BD,$c['id_horario']);
				$i++;
			}			
		}
		echo $i;
		
	}


	function ActualizacionNotificacionSalidaClientePF(){
		$this->load->model("moduloNotificacion");
		$BD="I-Audisis_PFAlimentos";
		$Noti=$this->moduloNotificacion->BuscarNotificacionSalida($BD);
		$i=0;		
		foreach ($Noti as $c) {
			if (isset($Noti)) {
				$mnsj="
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='x-ua-compatible' content='ie=edge'>
    <meta name='description' content='Admin, Dashboard, Bootstrap' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>octAdmin - powerfull minimal ultimate all in one bootstrap admin Template</title>
	<meta name='theme-color' content='#ffffff'>	 
</head> 
	<body> 
		<section class='container-pages'> 
			<div class='brand-logo float-left'>
				<a class='' href='#'>I-audisis</a>
			</div> 
			<div class='pages-tag-line text-white'> 
				<div class='h4'>Bienvenidos a I - Audisis</div> 
				<small> Una nueva experiencia en asistencia y formularios en Ruta.</small> 
			</div> 
			<div class='card pages-card col-lg-4 col-md-6 col-sm-6'> 
				<div class='card-body '> 
					<h4 class='text-theme'>Cierre automatico de Asistencia</h4>
                        <small class='text-muted'>Sr(a) ".$c['nombre'].". ya que usted no ha marcado su salida, el sistema la cerrará automaticamente. Si usted aun esta en su lugar de trabajo, igual lo dejará marcar salida.</small>
                        <hr>
                        <div class='list-group'>
                          <div class='d-flex w-100 justify-content-between'>
                            <h5 class='mb-1 text-muted'>Datos del Usuario</h5>
                            <small>Nombre:".$c['nombre']."</small><br>
                            <small>Rut: ".$c['rut']." </small><br>                                                     
                            <small>Hora Salida: ".$c['salida']."</small><br>                          
                          </div>
                          <hr>
                          <div class='d-flex w-100 justify-content-between'>
                            <h5 class='mb-1'>Datos del Empleador</h5>
                            <small >Rut Empleador: ".$c['RutEmpresa']."</small><br>
                            <small >Razon Social:".$c['RazonSocial']."</small><br>
                            <small >Nombre de Local: ".$c['NombreLocal']."</small><br>
                            <small >Direcion Local: ".$c['Direccion']."</small><br>
                          </div>
                          <hr>
		            <!-- end card-body -->
		        </div>
		        <!-- end card -->
		    </section>
		    <!-- end section container -->
		    <div class='half-circle'></div>
		    <div class='small-circle'></div>

		    <!-- end mybutton -->

		    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>
		    
		   
		    
		</body>

		</html>";



				$asunto='Cierre automatico de Jornada en el Local :'.$c['NombreLocal'];
				$EmailEmpleador=$c['emailCliente'];
				$EmailUser=$c['emailUser'];
				$this->enviaremail($EmailUser,$mnsj,$asunto,$EmailEmpleador);
				$a=$this->moduloNotificacion->ActualizarNotificacionSalida($BD,$c['id_horario'],$c['FK_Jornadas_ID_Jornada'],$c['Latitud'],$c['Longitud'],$c['Salida']);
				$i++;
			}			
		}
		echo $i;
		
	}

	function ReporteAtrasoDiaAnterior(){
		$hoy = getdate();
		$hoyDia = $hoy["mday"];
		$hoyMes = $hoy["mon"];
		$hoyAnio = $hoy["year"];
		$fecha = $hoyDia."/".$hoyMes."/".$hoyAnio;
		$this->load->model("moduloNotificacion");
		$BD="I-Audisis_PruebaCliente";
		$objReader=PHPExcel_IOFactory::createReader('Excel2007');
		$object=$objReader->load("doc/plantilla/ReporteDiarioAtrasos.xlsx");
		$object->setActiveSheetIndex(0);
		$reporte=$this->moduloNotificacion->ReporteAtraso($BD);
		$column_row=2;
			foreach($reporte as $rowR){	 
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $rowR['NombreTrabajador']);
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $rowR['Entrada']);
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $rowR['Salida']);
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(3 , $column_row, $rowR['NombreLocal']);
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(4 , $column_row, $rowR['DistanciaPdo']);
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(5 , $column_row, $rowR['DistanciaPdoS']);
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(6 , $column_row, $rowR['EntradaReal']);
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(7 , $column_row, $rowR['HoraSalida']);
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(8 , $column_row, $rowR['Diferencia']);
		 		$column_row++;	 		
	 		}
		$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		ob_end_clean();
		ob_start();
		$objWriter->save('doc/ReporteDiarioAtraso.xls');
        $data=1;
       // $data['firstname']=$this->input->post('txtName');			
       // $data['body']=$this->input->post('txtdescription');
		$asunto ='Reporte Diario de atrasos '. $fecha;
		$EmailUser ='jordan.fernandez@audisischile.com';
		$emaildescription=$this->load->view('mail/Correo',$data,TRUE);
		$mnsj = $emaildescription;
		$excel ="doc/ReporteDiarioAtraso.xls";
		
		$this->enviaReporteAtrasoDiaAnterior($EmailUser,$mnsj,$asunto,$excel);
		echo "run";
	}

	function enviaremail($EmailUser,$mnsj,$asunto,$EmailEmpleador){
       
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        
       // SMTP configuration
       $mail->isSMTP();
       $mail->Host     ='smtp.tie.cl';
       $mail->SMTPAuth = true;
       $mail->Username = 'no-contestar@audisischile.com';
       $mail->Password = 'Audisis2015';
       $mail->SMTPSecure = 'tls';
       $mail->Port     = 25;
        
        $mail->setFrom('no-contestar@audisischile.com','Equipo Audisis');
        $mail->addReplyTo('','');
        
        // Add a recipient
        $mail->addAddress($EmailUser);
        
        // Add cc or bcc 
        $mail->addCC($EmailEmpleador);
        $mail->addBCC('');
        
        // Email subject
        $mail->Subject =$asunto;
        
        // Set email format to HTML
		$mail->isHTML(true);
		
		//Adjuntar Archivo
		//$mail->addAttachment($excel);

        
        // Email body content
        $mailContent = $mnsj;
        $mail->Body = $mailContent;
        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
			Return False;
        }else{
           return True;
        }
    }






	function enviaReporteAtrasoDiaAnterior($EmailUser,$mnsj,$asunto,$excel){
       
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        
       // SMTP configuration
       $mail->isSMTP();
       $mail->Host     ='smtp.tie.cl';
       $mail->SMTPAuth = true;
       $mail->Username = 'no-contestar@audisischile.com';
       $mail->Password = 'Audisis2015';
       $mail->SMTPSecure = 'tls';
       $mail->Port     = 25;
        
        $mail->setFrom('no-contestar@audisischile.com','Equipo Audisis');
        $mail->addReplyTo('','');
        
        // Add a recipient
        $mail->addAddress($EmailUser);
        
        // Add cc or bcc 
        $mail->addCC('');
        $mail->addBCC('');
        
        // Email subject
        $mail->Subject =$asunto;
        
        // Set email format to HTML
		$mail->isHTML(true);
		
		//Adjuntar Archivo
		$mail->addAttachment($excel);

        
        // Email body content
        $mailContent = $mnsj;
        $mail->Body = $mailContent;
        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
			Return False;
        }else{
           return True;
        }
    }
		  
}


 