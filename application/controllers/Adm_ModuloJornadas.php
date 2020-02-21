<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloJornadas extends CI_Controller {
	public function __construct(){

		parent::__construct();
		$this->load->helper("url","form");	
		$this->load->library('form_validation'); 	
		$this->load->model("funcion_login");
	    $this->load->library('session');
		$this->load->library('upload');
		$this->load->library('phpexcel');
	}


	function homeAdmin(){
		if($_SESSION['Perfil']==2 || $_SESSION['Perfil']==1){ 
	   		$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"] = $_SESSION["Perfil"];
			$data["Cliente"] = $_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Cargo"] = $_SESSION["Cargo"];
			$data["Clientes"]= $this->funcion_login->elegirCliente();
			// $data["ID_Modulo"] = $_SESSION["ID_Modulo"];
		    $this->load->view('contenido');
		    $this->load->view('layout/header',$data);
		    $this->load->view('layout/sidebar',$data);
		    $this->load->view('admin/pruebaMapas',$data);
		    $this->load->view('layout/footer',$data);
	    }else{
		   redirect(site_url("login"));
		}
	}

	function adminJornadas(){
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
				$this->load->model("ModuloPermisos");
				$this->load->model("ModuloUsuario");
				$data["listaPermisos"]=$this->ModuloPermisos->listarPermisosTotales();
				$data["ListarEmpresa"]=$this->ModuloCliente->ListarEmpresaActivas();
				$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
				$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
				//vistas
			    $this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			    $this->load->view('layout/sidebar',$data);
			    $this->load->view('admin/adminJornadas',$data);
			    $this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function adminFeriados(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1){ 
				// variables de sesion
		   		$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->model("ModuloJornadas");
				$data["Feriados"]=$this->ModuloJornadas->ListarFeriados();
				//vistas
			    $this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			    $this->load->view('layout/sidebar',$data);
			    $this->load->view('admin/adminFeriados',$data);
			    $this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function validarCreacionFeriado(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1){ 
				// OP1 = Ingresado Correcto
				// OP2 = No se Insertaron las filas
				// OP3 = Editado Correctamente
				$this->load->model("ModuloJornadas");
				$var=0;
 				//Rellenar Variables
				$nombre=$this->limpiarComilla($_POST["txt_Nombre"]);
				$fecha=$this->limpiarComilla($_POST["txt_Fecha"]);
 				if($var==0){
					if(isset($_POST["txt_idFeriado"])){
						//Modificar Feriado
						$idFeriado=$_POST["txt_idFeriado"];
						$filas=$this->ModuloJornadas->editarFeriado($nombre,$fecha,$idFeriado);
						if($filas["CantidadInsertadas"]==0){
							echo "OP2";
						}else{
							echo "OP3".$filas["CantidadInsertadas"];
						}
					}else{
						//Insertar y retonar Cantidad de Registros
						$filas=$this->ModuloJornadas->ingresarFeriado($nombre,$fecha);
						if($filas["CantidadInsertadas"]==0){
							echo "OP2";
						}else{
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
 	function editarFeriado(){
		$Feriado=$_POST["Feriado"];
		$this->load->model("ModuloJornadas");
		$datosFeriado= $this->ModuloJornadas->buscarFeriadoID($Feriado);
		echo '<form method="post" id="FormNuevoFeriado" action="">
                <div class="form-group">
                    <label for="control-demo-1" class="col-sm-6">Nombre Feriado <label style="color:red">* &nbsp;</label></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                        <input type="text" id="txt_Nombre" name="txt_Nombre" class="form-control" placeholder="Nombre del Feriado" value="'.$datosFeriado["Nombre_Feriado"].'" required>
                    </div>
                    <div  id="val_Nombre" style="color:red;"></div>                               
                </div> 
                <div class="form-group">
                    <label for="control-demo-1" class="col-sm-6">Fecha Feriado <label style="color:red">* &nbsp;</label></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                        <input type="text" id="txt_Fecha" name="txt_Fecha" class="form-control" data-mask value="'.$datosFeriado["Fecha_Feriado"].'" required>
                    </div>
                    <div  id="val_Fecha" style="color:red;"></div>                               
                </div>
                <input type="hidden" name="txt_idFeriado" value="'.$datosFeriado["ID_Feriado"].'">
            </form>';
         echo " 	<script src='".site_url()."assets/libs/input-mask/jquery.inputmask.js'></script>
				<script src='".site_url()."assets/libs/input-mask/jquery.inputmask.date.extensions.js'></script>
				<script src='".site_url()."assets/libs/input-mask/jquery.inputmask.extensions.js'></script>
        		<script type='text/javascript'>
        		$('#txt_Fecha').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-aaaa' });  
        		</script>";
	}
 	function cambiarEstadoFeriado(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["Feriado"])){
					$Feriado=$_POST["Feriado"];
					$vigencia=$_POST["estado"];
					echo "<form method='post' id='cambiarEstadoFeriado' action='cambiarEstadoFeriadoFinal'>";
					if($vigencia==1){
						echo "<p>¿Esta Seguro que desea Desactivar la Feriado?</p>";						
					}else{
						echo "<p>¿Esta Seguro que desea Activar la Feriado?</p>";
					}
					echo "<input type='hidden' name='txt_Feriado' value='".$Feriado."'>";
					echo "<input type='hidden' name='txt_estado' value='".$vigencia."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloPuntosVentas/listarFeriados"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}
 	function cambiarEstadoFeriadoFinal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_Feriado"])){				
					$Feriado=$_POST["txt_Feriado"];
					$vigencia=$_POST["txt_estado"];
					$this->load->model("ModuloJornadas");
					$filas=$this->ModuloJornadas->cambiarEstadoFeriado($Feriado,$vigencia);
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
					// variables de sesion
			   		$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Cargo"] = $_SESSION["Cargo"];
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$this->load->model("ModuloJornadas");
					$data["Feriados"]=$this->ModuloJornadas->ListarFeriados();
					//vistas
				    $this->load->view('contenido');
				    $this->load->view('layout/header',$data);
				    $this->load->view('layout/sidebar',$data);
				    $this->load->view('admin/adminFeriados',$data);
				    $this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloPuntosVentas/listarFeriados"));
				}
			}
		}
	}

	function adminIncidencias(){
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
				$BD=$_SESSION["BDSecundaria"];
				$this->load->model("ModuloAsistencia");
				$this->load->model("ModuloCliente");
				$data["ListarEmpresa"]=$this->ModuloCliente->ListarEmpresaActivas();
				$data["ListarIncidencia"]=$this->ModuloAsistencia->ListarIncidenciaActivas($BD);
				// $data["ListarMarcaje"]=$this->ModuloAsistencia->ListarMarcajeActivas($BD);
				//vistas
			    $this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			    $this->load->view('layout/sidebar',$data);
			    $this->load->view('admin/adminIncidencias',$data);
			    $this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function CrearIncidencias(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				$this->load->model("ModuloAsistencia");
				$id_creador=$_SESSION['Usuario'];
				$BD=$_SESSION["BDSecundaria"];
				$nombreIncidencia=$_POST['NewIncidencia'];
				// var_dump($nombreIncidencia);exit();
				$this->ModuloAsistencia->CrearIncidencia($BD,$nombreIncidencia,$id_creador);
				echo 1;
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function CrearMarcaje(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				$this->load->model("ModuloAsistencia");
				$id_creador=$_SESSION['Usuario'];
				$BD=$_SESSION["BDSecundaria"];
				$nombreMarcaje=$_POST['NewMarcaje'];
				// var_dump($nombreIncidencia);exit();
				$this->ModuloAsistencia->CrearMarcaje($BD,$nombreMarcaje,$id_creador);
				echo 1;
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function EliminarIncidencias(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				$this->load->model("ModuloAsistencia");
				$id_creador=$_SESSION['Usuario'];
				$BD=$_SESSION["BDSecundaria"];
				$id_incidencia=$_POST['id'];
				// var_dump($nombreIncidencia);exit();
				$this->ModuloAsistencia->EliminarIncidencia($BD,$id_incidencia,$id_creador);
				echo 1;
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function EliminarMarcaje(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				$this->load->model("ModuloAsistencia");
				$id_creador=$_SESSION['Usuario'];
				$BD=$_SESSION["BDSecundaria"];
				$id_marcaje=$_POST['id'];
				// var_dump($nombreIncidencia);exit();
				$this->ModuloAsistencia->EliminarMarcaje($BD,$id_marcaje,$id_creador);
				echo 1;
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}


		function buscarHorarioUsuario(){
		if(isset($_GET['opcion'])){
			if(is_numeric($_GET['opcion'])){
				$buscasana = $_GET['opcion'];
			}else{
				$buscasana=1;
			}
		}else{
			$buscasana=1;
		}
			
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$this->load->model("ModuloJornadas"); 
				$hoy = getdate();
				$mes = getdate();
				$mesActual=$hoy['mon'];	
				$mes=$mes['mon'];
				$thismonth=date("m");
				$BD=$_SESSION["BDSecundaria"];
				$id_usuario=$_POST["usuario"];
				$opcion=$buscasana;
				$cantidadJ=$this->ModuloJornadas->CantidadJ($BD,$thismonth);					
				$horarios= $this->ModuloJornadas->ListarHorarioUsuario($BD,$id_usuario,$buscasana);	
				$tempoCantidad = $this->ModuloJornadas->cantidadJornadas($BD,$thismonth);
				$cantidad = ceil(($tempoCantidad)/5);
				$cantidadHorario=count($horarios);
    			$ndias=cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
    			echo '<script type="text/javascript">
					            $(document).ready(function() {
							    var table = $("#example").removeAttr("width").DataTable( {
							        scrollY:        "450px",
							        scrollX:        true,
							        searching: false,
							        scrollCollapse: true,
							        paging:         false,
							        fixedColumns:   {
							            leftColumns: 1,
							        },
							            "language": {
							        "sProcessing":    "Procesando...",
							        "sLengthMenu":    "Mostrar _MENU_ registros",
							        "sZeroRecords":   "No se encontraron resultados",
							        "sEmptyTable":    "Ningún dato disponible en esta tabla",
							        "sInfo":          "",
							        "sInfoEmpty":     "",
							        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
							        "sInfoPostFix":   "",
							        "sSearch":        "Buscar:",
							        "sUrl":           "",
							        "sInfoThousands":  ",",
							        "sLoadingRecords": "Cargando...",
							        "oPaginate": {
							            "sFirst":    "Primero",
							            "sLast":    "Último",
							            "sNext":    "Siguiente",
							            "sPrevious": "Anterior"
							        },
							        "oAria": {
							            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
							            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
							        }
							    }
							    } );
							} );


			            </script>';     
			echo '<div id="loader" style="display: none;" ></div>
			<table id="example" class="table color-bordered-table danger-bordered-table"  width="100%" style="font-size: 12px;">
			    <thead>
			        <tr>
			        <th>Nombre</th>
			        <th></th>                                                
			        <th>Nombre Local</th>
			        <th style="text-align: center;">Entrada Día 1</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 1</th>
			        <th style="text-align: center;">Entrada Día 2</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 2</th>
			        <th style="text-align: center;">Entrada Día 3</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 3</th>
			        <th style="text-align: center;">Entrada Día 4</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 4</th>
			        <th style="text-align: center;">Entrada Día 5</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 5</th>
			        <th style="text-align: center;">Entrada Día 6</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 6</th>
			        <th style="text-align: center;">Entrada Día 7</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 7</th>
			        <th style="text-align: center;">Entrada Día 8</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 8</th>
			        <th style="text-align: center;">Entrada Día 9</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 9</th>
			        <th style="text-align: center;">Entrada Día 10</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 10</th>
			        <th style="text-align: center;">Entrada Día 11</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 11</th>
			        <th style="text-align: center;">Entrada Día 12</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 12</th>
			        <th style="text-align: center;">Entrada Día 13</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 13</th>
			        <th style="text-align: center;">Entrada Día 14</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 14</th>
			        <th style="text-align: center;">Entrada Día 15</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 15</th>
			        <th style="text-align: center;">Entrada Día 16</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 16</th>
			        <th style="text-align: center;">Entrada Día 17</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 17</th>
			        <th style="text-align: center;">Entrada Día 18</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 18</th>
			        <th style="text-align: center;">Entrada Día 19</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 19</th>
			        <th style="text-align: center;">Entrada Día 20</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 20</th>
			        <th style="text-align: center;">Entrada Día 21</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 21</th>
			        <th style="text-align: center;">Entrada Día 22</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 22</th>
			        <th style="text-align: center;">Entrada Día 23</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 23</th>
			        <th style="text-align: center;">Entrada Día 24</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 24</th>
			        <th style="text-align: center;">Entrada Día 25</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 25</th>
			        <th style="text-align: center;">Entrada Día 26</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 26</th>
			        <th style="text-align: center;">Entrada Día 27</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 27</th>
			        <th style="text-align: center;">Entrada Día 28</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 28</th>
			        <th style="text-align: center;">Entrada Día 29</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 29</th>
			        <th style="text-align: center;">Entrada Día 30</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 30</th>'; 
			        if ($ndias>=31) {
			    echo'<th style="text-align: center;">Entrada Día 31</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 31</th>';
			    	}
			echo'</tr>
			    </thead>
			    <tbody>';  
			    $b=':' ;// variable den dias Libres
			foreach ($horarios as $c) {                            
			echo"   <tr>                                                                        
			            <td>".$c['Nombres']."<br><small>".$c['Rut']."</small></td>
			            <td>
			                <div class='btn-group btn-group-sm' role='group' aria-label='Basic example'>
			                    <button type='button' class='btn btn-outline-theme' id='EHbtn-".$c['ID_Jornada']."' onclick='EditHorario(".$c['ID_Jornada'].");' ><i class='mdi mdi-table-edit' id='EHicn-".$c['ID_Jornada']."' ></i>Editar</button>";
			            if($c["Activo"]==0){
			                 echo"<button type='button' class='btn btn-danger' title='Activar Usuario'  onclick='cambiarEstadoJornada(".$c['ID_Jornada'].",".$c["Activo"].")'><i class='fa fa-times'></i></button>";
			            }else{
			                echo"<button type='button' class='btn btn-success' title='Desactivar Usuario' onclick='cambiarEstadoJornada(".$c['ID_Jornada'].",".$c["Activo"].")'><i class='fa fa-check'></i></button>";
			            }       
			            echo"</div>
			            </td>                                                      
			            <td><button type='button' style='font-size: 15px; width:100%' class='btn btn-info' data-toggle='modal' data-target='#mapLocal'  title='mapa de Local' onclick='mapaLocal(".$c["ID_Local"].")'><i class='mdi mdi-compass-outline'></i>".$c['NombreLocal']."</button>"; 
			        for ($i=1; $i <= $ndias ; $i++) {
			        echo"<td>"; if ((strpos($c['Entrada'.$i],$b)===false)) {
			        echo"   <button data-toggle='modal' data-target='.bs-example-modal-VerPermiso' id='verPermiso' name='verPermisoEntrada' type='button' class='btn btn-danger' value='".$c['PermisoEntrada'.$i]."' onclick='verPermisoU(".$c['PermisoEntrada'.$i].",".$c['ID_Usuario'].",".$c['ID_Jornada'].",".$c['IDEntrada'.$i].")' style='margin-bottom: 18px; width:50px;'><span>P</span></button>";
			                    }else{
			        echo"   <input  style='font-size: 12px;' type='text' class='form-control' id='Edia-".$i."-".$c['ID_Jornada']."' name='Edia-".$i."-".$c['ID_Jornada']."' value='".$c['Entrada'.$i]."' data-plugin='timepicker' disabled /><input  style='font-size: 12px;' type='hidden' name='IDEdia-".$i."-".$c['ID_Jornada']."' value='".$c['IDEntrada'.$i]."' >";    
			                    }
			        echo"</td>
			            <td>";  if ((strpos($c['Salida'.$i],$b)===false)) {                                    
			        echo"   <button data-toggle='modal' data-target='.bs-example-modal-VerPermiso' id='verPermiso' name='verPermisoSalida' type='button' class='btn btn-danger' onclick='verPermisoU(".$c['PermisoSalida'.$i].",".$c['ID_Usuario'].",".$c['ID_Jornada'].",".$c['IDSalida'.$i].")' style='margin-bottom: 18px; width:50px'>P</button>";
			                    }else{
			        echo"    <input  style='font-size: 12px;' type='text' class='form-control' id='Sdia-".$i."-".$c['ID_Jornada']."' name='Sdia-".$i."-".$c['ID_Jornada']."' value='".$c['Salida'.$i]."' data-plugin='timepicker' disabled /><input  style='font-size: 12px;' type='hidden' name='IDSdia-".$i."-".$c['ID_Jornada']."' value='".$c['IDSalida'.$i]."' >";   
			                    }
			        echo"</td>";                                                                                  
			    } echo "</form>
			    </tr>";
			}  
			echo'</tbody>
			</table>
			<p style="padding-left: 15px;">Mostrando <?php echo $cantidadHorario ?> registros de un total de <?php echo $cantidadJ ?> Jornadas.</p>';
			if ($cantidadHorario>=5) {
			        if(isset($opcion) && $mesActual==$mes){                   
				echo"   <div class='col-md-4' >
			            <nav aria-label='Page navigation example'>
			                <ul class='pagination'>";
			            if($opcion!=1){                       
			                echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion-1)."' ><i class='mdi mdi-arrow-left-bold'></i> Anterior</a></li>";
			                    }
			            if(($opcion-2)>0){                  
			                echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion-2)."' >".($opcion-2)."</a></li>";
			                    }
			            if(($opcion-1)>0){
			                echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion-1)."' >".($opcion-1)."</a></li>";
			                    }   
			                echo "<li class='page-item active'><a class='page-link text-red' style='border-color: #e01111; background-color: #fff; color: #e01111; href=''  ><span class='badge badge-danger hertbit'>$opcion</span></a></li>";
			            if(($opcion+1)<=$cantidad){                
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion+1)."' >".($opcion+1)."</a></li>";
			                }
			                if(($opcion+2)<=$cantidad){
			                    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion+2)."' >".($opcion+2)."</a></li>";
			                }
			                if(($opcion+3)<=$cantidad){
			                     echo "<li class='page-item'><a class='page-link bg-danger text-white'>...</a></li>";
			                    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=$cantidad'>$cantidad</a></li>";
			                }
			                if($opcion!=$cantidad){
			                    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion+1)."'>Siguiente <i class='mdi mdi-arrow-right-bold'></i></a></li>
			                    </ul>
			                </nav>";
			                }
			echo "  </div>";  
			        }
			        if(isset($opcion) && $mesActual!=$mes){
			                   
			                    echo "<div class='col-md-4'>
			                    <nav aria-label='Page navigation example pull-right'>
			                        <ul class='pagination'>";
			                         if($opcion!=1){
			                       
			                        echo "
			                    
			                            <li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion-1)."' ><i class='mdi mdi-arrow-left-bold'></i> Anterior</a></li>";
			                    }
			                    if(($opcion-2)>0){
			                      
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion-2)."' >".($opcion-2)."</a></li>";
			                    }
			                    if(($opcion-1)>0){
			                        
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion-1)."' >".($opcion-1)."</a></li>";
			                    }   

			                    echo "<li class='page-item active'><a class='page-link text-red' style='border-color: #e01111; background-color: #fff; color: #e01111; href=''  ><span class='badge badge-danger hertbit'>$opcion</span></a></li>";

			                    if(($opcion+1)<=$opcion){
			                        
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion+1)."' >".($opcion+1)."</a></li>";
			                    }
			                    if(($opcion+2)<=$cantidad){
			                       
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion+2)."' >".($opcion+2)."</a></li>";
			                    }
			                    if(($opcion+3)<=$cantidad){
			                         echo "<li class='page-item'><a class='page-link bg-danger text-white'>...</a></li>";
			                       
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=$cantidad'>$cantidad</a></li>";
			                    }
			                    if($opcion!=$cantidad){
			                      
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion+1)."'>Siguiente <i class='mdi mdi-arrow-right-bold'></i></a></li>
			                        </ul>
			                    </nav>";
			                    }

			                }  

			            echo"</div>";

			            
				}           

			}else{
					redirect(site_url("login/inicio"));	
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}

	function buscarHorarioLocal(){
		if(isset($_GET['opcion'])){
			if(is_numeric($_GET['opcion'])){
				$buscasana = $_GET['opcion'];
			}else{
				$buscasana=1;
			}
		}else{
			$buscasana=1;
		}
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$this->load->model("ModuloJornadas");
				$hoy = getdate();
				$mes = getdate();
				$mesActual=$hoy['mon'];	
				$mes=$mes['mon']; 
				$thismonth=date("m");
				$BD=$_SESSION["BDSecundaria"];
				$id_local=$_POST["id_local"];
				$opcion=$buscasana;
				$cantidadJ=$this->ModuloJornadas->CantidadJ($BD,$thismonth);					
				$horarios= $this->ModuloJornadas->ListarHorarioLocal($BD,$id_local,$opcion);	
				$tempoCantidad = $this->ModuloJornadas->cantidadJornadas($BD,$thismonth);
				$cantidad = ceil(($tempoCantidad)/5);
				$cantidadHorario=count($horarios);
    			$ndias=cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
    			echo '<script type="text/javascript">
					            $(document).ready(function() {
							    var table = $("#example").removeAttr("width").DataTable( {
							        scrollY:        "450px",
							        scrollX:        true,
							        searching: false,
							        scrollCollapse: true,
							        paging:         false,
							        fixedColumns:   {
							            leftColumns: 1,
							        },
							            "language": {
							        "sProcessing":    "Procesando...",
							        "sLengthMenu":    "Mostrar _MENU_ registros",
							        "sZeroRecords":   "No se encontraron resultados",
							        "sEmptyTable":    "Ningún dato disponible en esta tabla",
							        "sInfo":          "",
							        "sInfoEmpty":     "",
							        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
							        "sInfoPostFix":   "",
							        "sSearch":        "Buscar:",
							        "sUrl":           "",
							        "sInfoThousands":  ",",
							        "sLoadingRecords": "Cargando...",
							        "oPaginate": {
							            "sFirst":    "Primero",
							            "sLast":    "Último",
							            "sNext":    "Siguiente",
							            "sPrevious": "Anterior"
							        },
							        "oAria": {
							            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
							            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
							        }
							    }
							    } );
							} );


			            </script>';     
			echo '<div id="loader" style="display: none;" ></div>
			<table id="example" class="table color-bordered-table danger-bordered-table"  width="100%" style="font-size: 12px;">
			    <thead>
			        <tr>
			        <th>Nombre</th>
			        <th></th>                                                
			        <th>Nombre Local</th>
			        <th style="text-align: center;">Entrada Día 1</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 1</th>
			        <th style="text-align: center;">Entrada Día 2</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 2</th>
			        <th style="text-align: center;">Entrada Día 3</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 3</th>
			        <th style="text-align: center;">Entrada Día 4</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 4</th>
			        <th style="text-align: center;">Entrada Día 5</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 5</th>
			        <th style="text-align: center;">Entrada Día 6</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 6</th>
			        <th style="text-align: center;">Entrada Día 7</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 7</th>
			        <th style="text-align: center;">Entrada Día 8</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 8</th>
			        <th style="text-align: center;">Entrada Día 9</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 9</th>
			        <th style="text-align: center;">Entrada Día 10</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 10</th>
			        <th style="text-align: center;">Entrada Día 11</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 11</th>
			        <th style="text-align: center;">Entrada Día 12</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 12</th>
			        <th style="text-align: center;">Entrada Día 13</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 13</th>
			        <th style="text-align: center;">Entrada Día 14</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 14</th>
			        <th style="text-align: center;">Entrada Día 15</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 15</th>
			        <th style="text-align: center;">Entrada Día 16</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 16</th>
			        <th style="text-align: center;">Entrada Día 17</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 17</th>
			        <th style="text-align: center;">Entrada Día 18</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 18</th>
			        <th style="text-align: center;">Entrada Día 19</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 19</th>
			        <th style="text-align: center;">Entrada Día 20</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 20</th>
			        <th style="text-align: center;">Entrada Día 21</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 21</th>
			        <th style="text-align: center;">Entrada Día 22</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 22</th>
			        <th style="text-align: center;">Entrada Día 23</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 23</th>
			        <th style="text-align: center;">Entrada Día 24</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 24</th>
			        <th style="text-align: center;">Entrada Día 25</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 25</th>
			        <th style="text-align: center;">Entrada Día 26</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 26</th>
			        <th style="text-align: center;">Entrada Día 27</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 27</th>
			        <th style="text-align: center;">Entrada Día 28</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 28</th>
			        <th style="text-align: center;">Entrada Día 29</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 29</th>
			        <th style="text-align: center;">Entrada Día 30</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 30</th>'; 
			        if ($ndias>=31) {
			    echo'<th style="text-align: center;">Entrada Día 31</th>
			        <th style="text-align: center;">&nbsp;Salida &nbsp;Día 31</th>';
			    	}
			echo'</tr>
			    </thead>
			    <tbody>';  
			    $b=':' ;// variable den dias Libres
			foreach ($horarios as $c) {                            
			echo"   <tr>                                                                        
			            <td>".$c['Nombres']."<br><small>".$c['Rut']."</small></td>
			            <td>
			                <div class='btn-group btn-group-sm' role='group' aria-label='Basic example'>
			                    <button type='button' class='btn btn-outline-theme' id='EHbtn-".$c['ID_Jornada']."' onclick='EditHorario(".$c['ID_Jornada'].");' ><i class='mdi mdi-table-edit' id='EHicn-".$c['ID_Jornada']."' ></i>Editar</button>";
			            if($c["Activo"]==0){
			                 echo"<button type='button' class='btn btn-danger' title='Activar Usuario'  onclick='cambiarEstadoJornada(".$c['ID_Jornada'].",".$c["Activo"].")'><i class='fa fa-times'></i></button>";
			            }else{
			                echo"<button type='button' class='btn btn-success' title='Desactivar Usuario' onclick='cambiarEstadoJornada(".$c['ID_Jornada'].",".$c["Activo"].")'><i class='fa fa-check'></i></button>";
			            }       
			            echo"</div>
			            </td>                                                      
			            <td><button type='button' style='font-size: 15px; width:100%' class='btn btn-info' data-toggle='modal' data-target='#mapLocal'  title='mapa de Local' onclick='mapaLocal(".$c["ID_Local"].")'><i class='mdi mdi-compass-outline'></i>".$c['NombreLocal']."</button>"; 
			        for ($i=1; $i <= $ndias ; $i++) {
			        echo"<td>"; if ((strpos($c['Entrada'.$i],$b)===false)) {
			        echo"   <button data-toggle='modal' data-target='.bs-example-modal-VerPermiso' id='verPermiso' name='verPermisoEntrada' type='button' class='btn btn-danger' value='".$c['PermisoEntrada'.$i]."' onclick='verPermisoU(".$c['PermisoEntrada'.$i].",".$c['ID_Usuario'].",".$c['ID_Jornada'].",".$c['IDEntrada'.$i].")' style='margin-bottom: 18px; width:50px;'><span>P</span></button>";
			                    }else{
			        echo"   <input  style='font-size: 12px;' type='text' class='form-control' id='Edia-".$i."-".$c['ID_Jornada']."' name='Edia-".$i."-".$c['ID_Jornada']."' value='".$c['Entrada'.$i]."' data-plugin='timepicker' disabled /><input  style='font-size: 12px;' type='hidden' name='IDEdia-".$i."-".$c['ID_Jornada']."' value='".$c['IDEntrada'.$i]."' >";    
			                    }
			        echo"</td>
			            <td>";  if ((strpos($c['Salida'.$i],$b)===false)) {                                    
			        echo"   <button data-toggle='modal' data-target='.bs-example-modal-VerPermiso' id='verPermiso' name='verPermisoSalida' type='button' class='btn btn-danger' onclick='verPermisoU(".$c['PermisoSalida'.$i].",".$c['ID_Usuario'].",".$c['ID_Jornada'].",".$c['IDSalida'.$i].")' style='margin-bottom: 18px; width:50px'>P</button>";
			                    }else{
			        echo"    <input  style='font-size: 12px;' type='text' class='form-control' id='Sdia-".$i."-".$c['ID_Jornada']."' name='Sdia-".$i."-".$c['ID_Jornada']."' value='".$c['Salida'.$i]."' data-plugin='timepicker' disabled /><input  style='font-size: 12px;' type='hidden' name='IDSdia-".$i."-".$c['ID_Jornada']."' value='".$c['IDSalida'.$i]."' >";   
			                    }
			        echo"</td>";                                                                                  
			    } echo "</form>
			    </tr>";
			}  
			echo'</tbody>
			</table>
			<p style="padding-left: 15px;">Mostrando <?php echo $cantidadHorario ?> registros de un total de <?php echo $cantidadJ ?> Jornadas.</p>';
			if ($cantidadHorario>=5) {
			        if(isset($opcion) && $mesActual==$mes){                   
				echo"   <div class='col-md-4' >
			            <nav aria-label='Page navigation example'>
			                <ul class='pagination'>";
			            if($opcion!=1){                       
			                echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion-1)."' ><i class='mdi mdi-arrow-left-bold'></i> Anterior</a></li>";
			                    }
			            if(($opcion-2)>0){                  
			                echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion-2)."' >".($opcion-2)."</a></li>";
			                    }
			            if(($opcion-1)>0){
			                echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion-1)."' >".($opcion-1)."</a></li>";
			                    }   
			                echo "<li class='page-item active'><a class='page-link text-red' style='border-color: #e01111; background-color: #fff; color: #e01111; href=''  ><span class='badge badge-danger hertbit'>$opcion</span></a></li>";
			            if(($opcion+1)<=$cantidad){                
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion+1)."' >".($opcion+1)."</a></li>";
			                }
			                if(($opcion+2)<=$cantidad){
			                    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion+2)."' >".($opcion+2)."</a></li>";
			                }
			                if(($opcion+3)<=$cantidad){
			                     echo "<li class='page-item'><a class='page-link bg-danger text-white'>...</a></li>";
			                    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=$cantidad'>$cantidad</a></li>";
			                }
			                if($opcion!=$cantidad){
			                    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion+1)."'>Siguiente <i class='mdi mdi-arrow-right-bold'></i></a></li>
			                    </ul>
			                </nav>";
			                }
			echo "  </div>";  
			        }
			        if(isset($opcion) && $mesActual!=$mes){
			                   
			                    echo "<div class='col-md-4'>
			                    <nav aria-label='Page navigation example pull-right'>
			                        <ul class='pagination'>";
			                         if($opcion!=1){
			                       
			                        echo "
			                    
			                            <li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion-1)."' ><i class='mdi mdi-arrow-left-bold'></i> Anterior</a></li>";
			                    }
			                    if(($opcion-2)>0){
			                      
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion-2)."' >".($opcion-2)."</a></li>";
			                    }
			                    if(($opcion-1)>0){
			                        
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion-1)."' >".($opcion-1)."</a></li>";
			                    }   

			                    echo "<li class='page-item active'><a class='page-link text-red' style='border-color: #e01111; background-color: #fff; color: #e01111; href=''  ><span class='badge badge-danger hertbit'>$opcion</span></a></li>";

			                    if(($opcion+1)<=$opcion){
			                        
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion+1)."' >".($opcion+1)."</a></li>";
			                    }
			                    if(($opcion+2)<=$cantidad){
			                       
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion+2)."' >".($opcion+2)."</a></li>";
			                    }
			                    if(($opcion+3)<=$cantidad){
			                         echo "<li class='page-item'><a class='page-link bg-danger text-white'>...</a></li>";
			                       
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=$cantidad'>$cantidad</a></li>";
			                    }
			                    if($opcion!=$cantidad){
			                      
			                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion+1)."'>Siguiente <i class='mdi mdi-arrow-right-bold'></i></a></li>
			                        </ul>
			                    </nav>";
			                    }

			                }  

			            echo"</div>";

			            
				}           

			}else{
					redirect(site_url("login/inicio"));	
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}

	function FiltrarHorario(){
		$this->load->model("ModuloJornadas");
		$this->load->model("ModuloUsuario");
		$BD=$_SESSION["BDSecundaria"];
		$usuario=($_POST["usuario"]=="") ? "0" : $_POST["usuario"];
		$local=($_POST["id_local"]=="") ? "0" : $_POST["id_local"];
		$MA=($_POST["id_fecha"]=="") ? '0' : $_POST["id_fecha"];				
		$horarios= $this->ModuloJornadas->ListarHorarioPaginador($BD,0,$usuario,$local,$MA);
		date_default_timezone_set("Chile/Continental");
		$ndias=cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));     
		echo '<div id="loader" style="display: none;" ></div>
			<table id="example" class="table color-bordered-table danger-bordered-table"  width="100%" style="font-size: 12px;">
			    <thead>
			        <tr>
                        <th>Nombre</th>';
						$editar=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],12,$_SESSION["Cliente"]);
                       	if ($_SESSION["Perfil"]==1 ||  $_SESSION["Perfil"]==2 && $editar["Activo"]==1) {
                       		echo '<th></th>';
                        }                                              
                        echo '<th>Nombre Local</th>';
                       	for ($i=date("j"); $i < $ndias+1; $i++) { 
                            echo '<th style="text-align: center;">Entrada Día '.$i.'</th>
                            <th style="text-align: center;">&nbsp;Salida &nbsp;Día '.$i.'</th>';
                        }
                        for ($i=1; $i < date("j"); $i++) { 
                           	echo '<th style="text-align: center;">Entrada Día '.$i.'</th>
                             <th style="text-align: center;">&nbsp;Salida &nbsp;Día '.$i.'</th>';
                        }
                    echo '</tr>
			    </thead>
			    <tbody>';  
			    $b=':' ;// variable den dias Libres
			foreach ($horarios as $c) {                            
				echo"   <tr> ";                                                                       
			    echo "<form  class='form-horizontal' id='horario-".$c['ID_Jornada']."'  method='POST' enctype='multipart/form-data'>
                        <input type='hidden' id='idjornada' name='idjornada' value='".$c['ID_Jornada']."'>
                        <input type='hidden' name='idUser' value='".$c['ID_Usuario']."' >";
                echo "<td>".$c["Nombres"]."<br><small>".$c['Rut']."</small></td>";
               	if ($_SESSION["Perfil"]==1 ||  $_SESSION["Perfil"]==2 && $editar["Activo"]==1) {
               		echo "<td><div class='btn-group btn-group-sm' role='group' aria-label='Basic example'>
               		<button type='button' class='btn btn-outline-danger btn-table' id='EHbtn-".$c['ID_Jornada']."' onclick='EditHorario(".$c['ID_Jornada'].");' title='Editar Jornada' ><i class='fa fa-edit ' id='EHicn-".$c['ID_Jornada']."' ></i></button>"; 
               		$h=0;
               		for ($i=1; $i < $ndias+1; $i++) { 
               			if ((strpos($c['Entrada'.$i],$b)===false)) { 
               				$h++;
               			}
               			if ((strpos($c['Salida'.$i],$b)===false)) {
               				$h++;
               			}
               		}
               		if($h>0){
               			echo "<button class='btn btn-outline-danger btn-table' title='Revocar Permisos' type='button' data-toggle='modal' data-target='.bs-example-modal-VerPermiso' onclick='verPermisoU(".$c["ID_Jornada"].",".$c["ID_Usuario"].")'><i class='fa fa-calendar'></i></button>";
               		}
               		if($c["Activo"]==0){ 
               			echo "<button type='button' class='btn btn-outline-danger btn-table'   onclick='cambiarEstadoJornada(".$c["ID_Jornada"].",".$c["Activo"].",".$c["ID_Usuario"].")' title='Activar Jornada' ><i class='fa fa-times' ></i></button>";
               		} else {
               			echo "<button type='button' class='btn btn-outline-success btn-table'  onclick='cambiarEstadoJornada(".$c["ID_Jornada"].",".$c["Activo"].",".$c["ID_Usuario"].")' title='Desactivar Jornada' ><i class='fa fa-check' ></i></button>";
               		}
               		echo "</div></td>";
               	}
               	echo "<td><div class='btn-group btn-group-sm' role='group' >
               	<button type='button' class='btn btn-info btn-table' style='width:16rem; font-size:0.75rem; white-space: pre-line;' data-toggle='modal' data-target='#mapLocal'  title='mapa de Local'  onclick='mapaLocal(".$c['ID_Local'].")' ><i class='fa fa-map-marker'></i>".$c['NombreLocal']."</button></div></td>";
                for ($i=date("j"); $i < $ndias+1; $i++) { 
                	$dia= ($i<10) ? "0".$i : $i;
                	if ((strpos($c['Entrada'.$i],$b)===false)) { 
                		echo "<td><span class='badge badge-boxed badge-danger btn-table'>".$c["Entrada".$i]."</span></td>";
                	} else {
                		echo "<td><input  style='font-size: 11px; min-height: 20px; '  type='text' class='form-control' id='Edia-".$i."-".$c['ID_Jornada']."' name='Edia-".$i."-".$c['ID_Jornada']."' value='".$c['Entrada'.$i]."' data-plugin='timepicker' disabled />
                		<input  style='font-size: 12px;' type='hidden' name='IDEdia-".$i."-".$c['ID_Jornada']."' value='".$c['ID_Local']."-".date("Y").date("m").$dia."'>
                		</td>";
                	}
                	if ((strpos($c['Salida'.$i],$b)===false)) {
                		echo "<td><span class='badge badge-boxed badge-danger btn-table'>".$c["Salida".$i]."</span></td>";
                	} else {
                		echo"<td><input  style='font-size: 11px; min-height: 20px;' type='text' class='form-control'  id='Sdia-".$i."-".$c['ID_Jornada']."' name='Sdia-".$i."-".$c['ID_Jornada']."' value='".$c['Salida'.$i]."' data-plugin='timepicker' disabled />
                		<input  style='font-size: 12px;' type='hidden' name='IDSdia-".$i."-".$c['ID_Jornada']."' value='".$c['ID_Local']."-".date("Y").date("m").$dia."'></td>";
                	}
                }
                for ($i=1; $i < date("j"); $i++) {
                	$dia= ($i<10) ? "0".$i : $i;
                	if ((strpos($c['Entrada'.$i],$b)===false)) { 
                		echo "<td><span class='badge badge-boxed badge-danger btn-table'>".$c["Entrada".$i]."</span></td>";
                	} else {
                		echo "<td><input  style='font-size: 11px; min-height: 20px; '  type='text' class='form-control' id='Edia-".$i."-".$c['ID_Jornada']."' name='Edia-".$i."-".$c['ID_Jornada']."' value='".$c['Entrada'.$i]."' data-plugin='timepicker' disabled />
                		<input  style='font-size: 12px;' type='hidden' name='IDEdia-".$i."-".$c['ID_Jornada']."' value='".$c['ID_Local']."-".date("Y").date("m").$dia."'>
                		</td>";
                	}
                	if ((strpos($c['Salida'.$i],$b)===false)) {
                		echo "<td><span class='badge badge-boxed badge-danger btn-table'>".$c["Salida".$i]."</span></td>";
                	} else {
                		echo"<td><input  style='font-size: 11px; min-height: 20px;' type='text' class='form-control'  id='Sdia-".$i."-".$c['ID_Jornada']."' name='Sdia-".$i."-".$c['ID_Jornada']."' value='".$c['Salida'.$i]."' data-plugin='timepicker' disabled />
                		<input  style='font-size: 12px;' type='hidden' name='IDSdia-".$i."-".$c['ID_Jornada']."' value='".$c['ID_Local']."-".date("Y").date("m").$dia."'></td>";
                	}
                }
                echo "</form>
			    </tr>";
			}  
			echo'</tbody>
			</table>';
		echo '<script type="text/javascript">
		$(document).ready(function() {
			var table = $("#example").removeAttr("width").DataTable( {
				scrollY:        "450px",
				scrollX:        true,
				searching: false,
				scrollCollapse: true,
				paging:         false,
				fixedColumns:   {
					leftColumns: 1,
				},
				"language": {
					"sProcessing":    "Procesando...",
					"sLengthMenu":    "Mostrar _MENU_ registros",
					"sZeroRecords":   "No se encontraron resultados",
					"sEmptyTable":    "Ningún dato disponible en esta tabla",
					"sInfo":          "",
					"sInfoEmpty":     "",
					"sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
					"sInfoPostFix":   "",
					"sSearch":        "Buscar:",
					"sUrl":           "",
					"sInfoThousands":  ",",
					"sLoadingRecords": "Cargando...",
					"oPaginate": {
						"sFirst":    "Primero",
						"sLast":    "Último",
						"sNext":    "Siguiente",
						"sPrevious": "Anterior"
					},
					"oAria": {
						"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
						"sSortDescending": ": Activar para ordenar la columna de manera descendente"
					}
				}
				} );

				'; 
		        $numeros = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
		        $b=':' ; 
		        foreach ($horarios as $c) { 
		            for ($i=1; $i < $numeros+1; $i++) { 
		                if ((strpos($c['Entrada'.$i],$b)!== false)) { 
		                    echo '$("#Edia-'.$i.'-'.$c['ID_Jornada'].'").timepicker();';
		                }
		                if ((strpos($c['Salida'.$i],$b)!== false)) { 
		                    echo ' $("#Sdia-'.$i.'-'.$c['ID_Jornada'].'").timepicker();';
		                }
		            }
		        }
		echo'
		} );
		</script>';
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
	

	function EditarHorarioUser(){
	if(isset($_SESSION["sesion"])){
		if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
			if(isset($_POST['idjornada'])){
				date_default_timezone_set("Chile/Continental");
				// var_dump($_POST);Exit();
				// variables de sesion
				$idjor=$_POST['idjornada'];
				$id_creador=$_SESSION['Usuario'];
				$BD=$_SESSION["BDSecundaria"];
				$idUser=$_POST["idUser"];
				$this->load->model("ModuloJornadas");
				$this->load->model("ModuloPuntosVentas");
				
				$validos=0;				
				$diaE= array();
				$diaS= array();
				$IDhor= array();
				$dia= array();
				$numeros = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));				
				//leer los dias
				for ($x=date("j"); $x <=$numeros ; $x++) { 
					if(isset($_POST['Edia-'.$x.'-'.$idjor])){
						$dia[$x]=$x;
						$diaE[$x]=date_format(date_create($_POST['Edia-'.$x.'-'.$idjor]),'H:i:s');
						$diaS[$x]=date_format(date_create($_POST['Sdia-'.$x.'-'.$idjor]),'H:i:s');
						$IDhor[$x]=$_POST['IDEdia-'.$x.'-'.$idjor];
					}
					$validos++;			
				}

				$dias=array();
				for ($i=date("j"); $i <= $numeros ; $i++) { 
					if (isset($IDhor[$i])) {
						$horario=$this->ModuloJornadas->UpdateHorario($BD,$IDhor[$i],$idUser,$dia[$i],date("m"),date("Y"),$diaE[$i],$diaS[$i],$id_creador,$idjor);
						$dias[$i]=$horario["entrada"].'**'.$horario["salida"];
					}					
				}				
		 		echo json_encode($dias);
				}else{
					redirect(site_url("Adm_ModuloJornadas/adminHorario"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}	
	}	

	function EditarEstadoJornada(){

		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["idjor"])){
					$idjor=$_POST["idjor"];
					$vigencia=$_POST["estado"];
					$iduser=$_POST["iduser"];
					echo "<form method='post' id='cambiarEstado' action='cambiarEstadoJornadaFinal'>";
					if($vigencia==1){
						echo "<p>¿Esta Seguro que desea Desactivar este Horario?</p>";						
					}else{
						echo "<p>¿Esta Seguro que desea Activar este Horario?</p>";
					}
					echo "<input type='hidden' name='txt_idjor' value='".$idjor."'>";
					echo "<input type='hidden' name='txt_user' value='".$iduser."'>";
					echo "<input type='hidden' name='txt_estado' value='".$vigencia."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloJornadas/adminHorarios"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}


	public function ValidarEx(){
		if(isset($_FILES['excel']['name'])){
			set_time_limit(600);
			//Creacion de variables
		 	$excel = $this->limpiaEspacio($_FILES['excel']['name']);	
		 	//Guarda Excel
		 	// var_dump($excel);exit;
		 	$this->subirArchivo($excel,0,0);
		 	//llama librerias	 
		 	$this->load->library('phpexcel');
		 	//para validar usuarios existente
		 	$this->load->model("ModuloUsuario");
		 	//para ingresar Jornadas
		 	$this->load->model("ModuloJornadas");
		 	//Lectura de excel
		 	$BD=$_SESSION["BDSecundaria"];

		 	$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
			$objReader = PHPExcel_IOFactory::createReader($tipo);
			$object = $objReader->load("archivos/archivos_Temp/".$excel);
			$object->setActiveSheetIndex(0);
			$defaultPrecision = ini_get('precision');
			ini_set('precision', $defaultPrecision);
		 	$columna=3;
		 	$dias=1;
		 	$cli=$_SESSION["Cliente"];
			$parametro=0;
			
		 	while($parametro==0){	
		 		
		 		if($object->getActiveSheet()->getCell('A'.$columna)->getCalculatedValue()==NULL)
		 		{
		 			$parametro=1;
		 		}else{

		 		$FechaInicio=$object->getActiveSheet()->getCell('B'.$dias)->getFormattedValue();
		 		if ($FechaInicio=='') {
		 			$object->getActiveSheet()->getStyle('C'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('3867d6');
		 		} 

		 		
		 		
		 		$RutSV=$this->limpiarRut($this->limpiarComilla($object->getActiveSheet()->getCell('A'.$columna)->getFormattedValue()));
				$resp=$this->ModuloUsuario->validarRutUsuario($RutSV,$cli);
				
				if($resp["Cliente"]==''){
					$object->getActiveSheet()->getStyle('A'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('8e24aa');
					}	
		 		//columna B PDO	
		 		$PDV=$object->getActiveSheet()->getCell('B'.$columna)->getFormattedValue();
		 		$exisite=$this->ModuloJornadas->ValidarLocal($BD,$PDV);
		 		
				if ($exisite!=1) {
					$object->getActiveSheet()->getStyle('B'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('F6BB42');
	 			}
		 		
		 		// columna C	1 ENTRADA
		 		$timedia1C=$object->getActiveSheet()->getCell('C'.$columna)->getFormattedValue();
		 		$time1C=$this->limpiaHora($timedia1C);
		 		$time11C=$this->limpiarEspacios($time1C);
		 		$time2dC=date_create($time11C);
		 		// var_dump($timedia1C,$time2dC,$columna);exit();
		 		if ($time2dC!=False) {
		 			$time2C=date_format($time2dC, 'H:i:s');
		 		}elseif ($time2dC==False) {
		 			$time2C='L';
		 		}
		 		// var_dump($time2C,$columna);

		 		//validar formato hora q sea :00 :15 :30 :45 
		 		if ($this->validarHora($time2C)!=true) {
		 			$object->getActiveSheet()->getStyle('C'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		} 
		 		//Columna D 1 SALIDA
		 		$timedia1D=$object->getActiveSheet()->getCell('D'.$columna)->getFormattedValue();
		 		$time1D=$this->limpiaHora($timedia1D);
		 		$time11D=$this->limpiarEspacios($time1D);
		 		$time2dD=date_create($time11D);
		 		if ($time2dD!=FALSE) {
		 			$time2D=date_format($time2dD, 'H:i:s');
		 		}else{
		 			$time2D='L';
		 		}		
		 		// var_dump($time2dD,$columna);
		 		if ($this->validarHora($time2D)!=true) {
		 			$object->getActiveSheet()->getStyle('D'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		} 
		 		//validar que la hora de la entrada sea menor que la de la salida y que no sean iguales

		 		if ($time2dD==$time2dC ) {
		 			$object->getActiveSheet()->getStyle('D'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('C'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dD<$time2dC) {
		 			$object->getActiveSheet()->getStyle('D'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('20bf6b');
		 			$object->getActiveSheet()->getStyle('C'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('20bf6b');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1C=='' || $timedia1C=='L') {
		 			$object->getActiveSheet()->getStyle('C'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1D=='' || $timedia1D=='L') {
		 			$object->getActiveSheet()->getStyle('D'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1D!=$time11D) {
		 			$object->getActiveSheet()->getStyle('D'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1C!=$time11C) {
		 			$object->getActiveSheet()->getStyle('C'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna E 2 ENTREDA
		 		$timedia1E=$object->getActiveSheet()->getCell('E'.$columna)->getFormattedValue();
		 		$time1E=$this->limpiaHora($timedia1E);
		 		$time11E=$this->limpiarEspacios($time1E);
		 		$time2dE=date_create($time11E);
		 		if ($time2dE!=False) {
		 			$time2E=date_format($time2dE, 'H:i:s');
		 		}else{
		 			$time2E='L';
		 		}		
		 		if ($this->validarHora($time2E)!=true) {
		 			$object->getActiveSheet()->getStyle('E'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna F 2 SALIDA
		 		$timedia1F=$object->getActiveSheet()->getCell('F'.$columna)->getFormattedValue();
		 		$time1F=$this->limpiaHora($timedia1F);
		 		$time11F=$this->limpiarEspacios($time1F);
		 		$time2dF=date_create($time11F);
		 		if ($time2dF!=False) {
		 			$time2F=date_format($time2dF, 'H:i:s');
		 		}else{
		 			$time2F='L';
		 		}		
		 		if ($this->validarHora($time2F)!=true) {
		 			$object->getActiveSheet()->getStyle('F'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//validar que la hora de la entrada sea menor que la de la salida y que no sean iguales
		 		if ($time2dF==$time2dE ) {
		 			$object->getActiveSheet()->getStyle('E'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('F'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dF<$time2dE) {
		 			$object->getActiveSheet()->getStyle('E'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('F'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1E=='' || $timedia1E=='L') {
		 			$object->getActiveSheet()->getStyle('E'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1F=='' || $timedia1F=='L') {
		 			$object->getActiveSheet()->getStyle('F'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1E!=$time11E) {
		 			$object->getActiveSheet()->getStyle('E'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1F!=$time11F) {
		 			$object->getActiveSheet()->getStyle('F'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		//Columna G 3 ENTRADA
		 		$timedia1G=$object->getActiveSheet()->getCell('G'.$columna)->getFormattedValue();
		 		$time1G=$this->limpiaHora($timedia1G);
		 		$time11G=$this->limpiarEspacios($time1G);
		 		$time2dG=date_create($time11G);
		 		if ($time2dG!=False) {
		 			$time2G=date_format($time2dG, 'H:i:s');
		 		}else{
		 			$time2G='L';
		 		}		
		 		if ($this->validarHora($time2G)!=true) {
		 			$object->getActiveSheet()->getStyle('G'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna H 3 SALIDA
		 		$timedia1H=$object->getActiveSheet()->getCell('H'.$columna)->getFormattedValue();
		 		$time1H=$this->limpiaHora($timedia1H);
		 		$time11H=$this->limpiarEspacios($time1H);
		 		$time2dH=date_create($time11H);
		 		if ($time2dH!=False) {
		 			$time2H=date_format($time2dH, 'H:i:s');
		 		}else{
		 			$time2H='L';
		 		}		
		 		if ($this->validarHora($time2H)!=true) {
		 			$object->getActiveSheet()->getStyle('H'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//validar que la hora de la entrada sea menor que la de la salida y que no sean iguales
		 		if ($time2dH==$time2dG ) {
		 			$object->getActiveSheet()->getStyle('H'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('G'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dH<$time2dG) {
		 			$object->getActiveSheet()->getStyle('H'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('G'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1H=='' || $timedia1H=='L') {
		 			$object->getActiveSheet()->getStyle('H'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1G=='' || $timedia1G=='L') {
		 			$object->getActiveSheet()->getStyle('G'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1H!=$time11H) {
		 			$object->getActiveSheet()->getStyle('H'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1G!=$time11G) {
		 			$object->getActiveSheet()->getStyle('G'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		//Columna I 4 ENTRADA
		 		$timedia1I=$object->getActiveSheet()->getCell('I'.$columna)->getFormattedValue();
		 		$time1I=$this->limpiaHora($timedia1I);
		 		$time11I=$this->limpiarEspacios($time1I);
		 		$time2dI=date_create($time11I);
		 		if ($time2dI!=False) {
		 			$time2I=date_format($time2dI, 'H:i:s');
		 		}else{
		 			$time2I='L';
		 		}		
		 		if ($this->validarHora($time2I)!=true) {
		 			$object->getActiveSheet()->getStyle('I'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna J 4 SALIDA
		 		$timedia1J=$object->getActiveSheet()->getCell('J'.$columna)->getFormattedValue();
		 		$time1J=$this->limpiaHora($timedia1J);
		 		$time11J=$this->limpiarEspacios($time1J);
		 		$time2dJ=date_create($time11J);
		 		if ($time2dJ!=False) {
		 			$time2J=date_format($time2dJ, 'H:i:s');
		 		}else{
		 			$time2J='L';
		 		}		
		 		if ($this->validarHora($time2J)!=true) {
		 			$object->getActiveSheet()->getStyle('J'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//validar que la hora de la entrada sea menor que la de la salida y que no sean iguales
		 		if ($time2dJ==$time2dI ) {
		 			$object->getActiveSheet()->getStyle('I'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('J'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dJ<$time2dI) {
		 			$object->getActiveSheet()->getStyle('I'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('J'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1J=='' || $timedia1J=='L') {
		 			$object->getActiveSheet()->getStyle('I'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1I=='' || $timedia1I=='L') {
		 			$object->getActiveSheet()->getStyle('J'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1J!=$time11J) {
		 			$object->getActiveSheet()->getStyle('J'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1I!=$time11I) {
		 			$object->getActiveSheet()->getStyle('I'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna K 5 ENTRADA
		 		$timedia1K=$object->getActiveSheet()->getCell('K'.$columna)->getFormattedValue();
		 		$time1K=$this->limpiaHora($timedia1K);
		 		$time11k=$this->limpiarEspacios($time1K);
		 		$time2dK=date_create($time11k);
		 		if ($time2dK!=False) {
		 			$time2K=date_format($time2dK, 'H:i:s');
		 		}else{
		 			$time2K='L';
		 		}		
				if ($this->validarHora($time2K)!=true) {
		 			$object->getActiveSheet()->getStyle('K'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		
		 		//Columna L 5 SALIDA
		 		$timedia1L=$object->getActiveSheet()->getCell('L'.$columna)->getFormattedValue();
		 		$time1L=$this->limpiaHora($timedia1L);
		 		$time11L=$this->limpiarEspacios($time1L);
		 		$time2dL=date_create($time11L);
		 		if ($time2dL!=False) {
		 			$time2L=date_format($time2dL, 'H:i:s');
		 		}else{
		 			$time2L='L';
		 		}		
		 		if ($this->validarHora($time2L)!=true) {
		 			$object->getActiveSheet()->getStyle('L'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dL==$time2dK ) {
		 			$object->getActiveSheet()->getStyle('L'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('K'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dL<$time2dK) {
		 			$object->getActiveSheet()->getStyle('L'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('K'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1L=='' || $timedia1L=='L') {
		 			$object->getActiveSheet()->getStyle('L'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1K=='' || $timedia1K=='L') {
		 			$object->getActiveSheet()->getStyle('K'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1L!=$time11L) {
		 			$object->getActiveSheet()->getStyle('L'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1K!=$time11k) {
		 			$object->getActiveSheet()->getStyle('K'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna M 6 ENTRADA
		 		$timedia1M=$object->getActiveSheet()->getCell('M'.$columna)->getFormattedValue();
		 		$time1M=$this->limpiaHora($timedia1M);
		 		$time11M=$this->limpiarEspacios($time1M);
		 		$time2dM=date_create($time11M);
		 		if ($time2dM!=False) {
		 			$time2M=date_format($time2dM, 'H:i:s');
		 		}else{
		 			$time2M='L';
		 		}		
		 		if ($this->validarHora($time2M)!=true) {
		 			$object->getActiveSheet()->getStyle('M'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna N 6 SALIDA
		 		$timedia1N=$object->getActiveSheet()->getCell('N'.$columna)->getFormattedValue();
		 		$time1N=$this->limpiaHora($timedia1N);
		 		$time11N=$this->limpiarEspacios($time1N);
		 		$time2dN=date_create($time11N);
		 		if ($time2dN!=False) {
		 			$time2N=date_format($time2dN, 'H:i:s');
		 		}else{
		 			$time2N='L';
		 		}		
		 		if ($this->validarHora($time2N)!=true) {
		 			$object->getActiveSheet()->getStyle('N'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dN==$time2dM ) {
		 			$object->getActiveSheet()->getStyle('N'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('M'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dN<$time2dM) {
		 			$object->getActiveSheet()->getStyle('N'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('M'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1N=='' || $timedia1N=='L') {
		 			$object->getActiveSheet()->getStyle('N'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1M=='' || $timedia1M=='L') {
		 			$object->getActiveSheet()->getStyle('M'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1N!=$time11N) {
		 			$object->getActiveSheet()->getStyle('N'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1M!=$time11M) {
		 			$object->getActiveSheet()->getStyle('M'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		//Columna O 7 ENTRADA
		 		$timedia1O=$object->getActiveSheet()->getCell('O'.$columna)->getFormattedValue();
		 		$time1O=$this->limpiaHora($timedia1O);
		 		$time11O=$this->limpiarEspacios($time1O);
		 		$time2dO=date_create($time11O);
		 		if ($time2dO!=False) {
		 			$time2O=date_format($time2dO, 'H:i:s');
		 		}else{
		 			$time2O='L';
		 		}		
		 		if ($this->validarHora($time2O)!=true) {
		 			$object->getActiveSheet()->getStyle('O'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna P 7 SALIDA
		 		$timedia1P=$object->getActiveSheet()->getCell('P'.$columna)->getFormattedValue();
		 		$time1P=$this->limpiaHora($timedia1P);
		 		$time11P=$this->limpiarEspacios($time1P);
		 		$time2dP=date_create($time11P);
		 		if ($time2dP!=False) {
		 			$time2P=date_format($time2dP, 'H:i:s');
		 		}else{
		 			$time2P='L';
		 		}		
		 		if ($this->validarHora($time2P)!=true) {
		 			$object->getActiveSheet()->getStyle('P'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dP==$time2dO ) {
		 			$object->getActiveSheet()->getStyle('O'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('P'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dP<$time2dO) {
		 			$object->getActiveSheet()->getStyle('O'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('P'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1P=='' || $timedia1P=='L') {
		 			$object->getActiveSheet()->getStyle('P'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1O=='' || $timedia1O=='L') {
		 			$object->getActiveSheet()->getStyle('O'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1P!=$time11P) {
		 			$object->getActiveSheet()->getStyle('P'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1O!=$time11O) {
		 			$object->getActiveSheet()->getStyle('O'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		//Columna Q 8 ENTRADA
		 		$timedia1Q=$object->getActiveSheet()->getCell('Q'.$columna)->getFormattedValue();
		 		$time1Q=$this->limpiaHora($timedia1Q);
		 		$time11Q=$this->limpiarEspacios($time1Q);
		 		$time2dQ=date_create($time11Q);
		 		if ($time2dQ!=False) {
		 			$time2Q=date_format($time2dQ, 'H:i:s');
		 		}else{
		 			$time2Q='L';
		 		}		
		 		if ($this->validarHora($time2Q)!=true) {
		 			$object->getActiveSheet()->getStyle('Q'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna R 8 SALIDA
		 		$timedia1R=$object->getActiveSheet()->getCell('R'.$columna)->getFormattedValue();
		 		$time1R=$this->limpiaHora($timedia1R);
		 		$time11R=$this->limpiarEspacios($time1R);
		 		$time2dR=date_create($time11R);
		 		if ($time2dR!=False) {
		 			$time2R=date_format($time2dR, 'H:i:s');
		 		}else{
		 			$time2R='L';
		 		}		
		 		if ($this->validarHora($time2R)!=true) {
		 			$object->getActiveSheet()->getStyle('R'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dR==$time2dQ) {
		 			$object->getActiveSheet()->getStyle('R'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('Q'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dR<$time2dQ) {
		 			$object->getActiveSheet()->getStyle('R'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('Q'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1R=='' || $timedia1R=='L') {
		 			$object->getActiveSheet()->getStyle('R'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1Q=='' || $timedia1Q=='L') {
		 			$object->getActiveSheet()->getStyle('Q'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1R!=$time11R) {
		 			$object->getActiveSheet()->getStyle('R'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1Q!=$time11Q) {
		 			$object->getActiveSheet()->getStyle('K'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		//Columna S 9 ENTRADA
		 		$timedia1S=$object->getActiveSheet()->getCell('S'.$columna)->getFormattedValue();
		 		$time1S=$this->limpiaHora($timedia1S);
		 		$time11S=$this->limpiarEspacios($time1S);
		 		$time2dS=date_create($time11S);
		 		if ($time2dS!=False) {
		 			$time2S=date_format($time2dS, 'H:i:s');
		 		}else{
		 			$time2S='L';
		 		}		
		 		if ($this->validarHora($time2S)!=true) {
		 			$object->getActiveSheet()->getStyle('S'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna T 9 SALIDA
		 		$timedia1T=$object->getActiveSheet()->getCell('T'.$columna)->getFormattedValue();
		 		$time1T=$this->limpiaHora($timedia1T);
		 		$time11T=$this->limpiarEspacios($time1T);
		 		$time2dT=date_create($time11T);
		 		if ($time2dT!=False) {
		 			$time2T=date_format($time2dT, 'H:i:s');
		 		}else{
		 			$time2T='L';
		 		}		
		 		if ($this->validarHora($time2T)!=true) {
		 			$object->getActiveSheet()->getStyle('T'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dT==$time2dS ) {
		 			$object->getActiveSheet()->getStyle('T'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('S'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dT<$time2dS) {
		 			$object->getActiveSheet()->getStyle('T'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('S'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1T=='' || $timedia1T=='L') {
		 			$object->getActiveSheet()->getStyle('T'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1S=='' || $timedia1S=='L') {
		 			$object->getActiveSheet()->getStyle('S'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1T!=$time11T) {
		 			$object->getActiveSheet()->getStyle('T'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1S!=$time11S) {
		 			$object->getActiveSheet()->getStyle('S'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		//Columna U 10 ENTRADA
		 		$timedia1U=$object->getActiveSheet()->getCell('U'.$columna)->getFormattedValue();
		 		$time1U=$this->limpiaHora($timedia1U);
		 		$time11U=$this->limpiarEspacios($time1U);
		 		$time2dU=date_create($time11U);
		 		if ($time2dU!=False) {
		 			$time2U=date_format($time2dU, 'H:i:s');
		 		}else{
		 			$time2U='L';
		 		}		
		 		if ($this->validarHora($time2U)!=true) {
		 			$object->getActiveSheet()->getStyle('U'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna V 10 SALIDA
		 		$timedia1V=$object->getActiveSheet()->getCell('V'.$columna)->getFormattedValue();
		 		$time1V=$this->limpiaHora($timedia1V);
		 		$time11V=$this->limpiarEspacios($time1V);
		 		$time2dV=date_create($time11V);
		 		if ($time2dV!=False) {
		 			$time2V=date_format($time2dV, 'H:i:s');
		 		}else{
		 			$time2V='L';
		 		}		
		 		if ($this->validarHora($time2V)!=true) {
		 			$object->getActiveSheet()->getStyle('V'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dV==$time2dU ) {
		 			$object->getActiveSheet()->getStyle('V'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('U'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dV<$time2dU) {
		 			$object->getActiveSheet()->getStyle('V'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('U'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1V=='' || $timedia1V=='L') {
		 			$object->getActiveSheet()->getStyle('V'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1U=='' || $timedia1U=='L') {
		 			$object->getActiveSheet()->getStyle('U'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1V!=$time11V) {
		 			$object->getActiveSheet()->getStyle('V'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1U!=$time11U) {
		 			$object->getActiveSheet()->getStyle('U'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		//Columna W 11 ENTRADA
		 		$timedia1W=$object->getActiveSheet()->getCell('W'.$columna)->getFormattedValue();
		 		$time1W=$this->limpiaHora($timedia1W);
		 		$time11W=$this->limpiarEspacios($time1W);
		 		$time2dW=date_create($time11W);
		 		if ($time2dW!=False) {
		 			$time2W=date_format($time2dW, 'H:i:s');
		 		}else{
		 			$time2W='L';
		 		}		
		 		if ($this->validarHora($time2W)!=true) {
		 			$object->getActiveSheet()->getStyle('W'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna X 11 SALIDA
		 		$timedia1X=$object->getActiveSheet()->getCell('X'.$columna)->getFormattedValue();
		 		$time1X=$this->limpiaHora($timedia1X);
		 		$time11X=$this->limpiarEspacios($time1X);
		 		$time2dX=date_create($time11X);
		 		if ($time2dX!=False) {
		 			$time2X=date_format($time2dX, 'H:i:s');
		 		}else{
		 			$time2X='L';
		 		}		
		 		if ($this->validarHora($time2X)!=true) {
		 			$object->getActiveSheet()->getStyle('X'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dX==$time2dW) {
		 			$object->getActiveSheet()->getStyle('X'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('W'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dX<$time2dW) {
		 			$object->getActiveSheet()->getStyle('X'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('W'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1X=='' || $timedia1X=='L') {
		 			$object->getActiveSheet()->getStyle('X'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1W=='' || $timedia1W=='L') {
		 			$object->getActiveSheet()->getStyle('W'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1X!=$time11X) {
		 			$object->getActiveSheet()->getStyle('X'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1W!=$time11W) {
		 			$object->getActiveSheet()->getStyle('W'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna Y 12 ENTRADA
		 		$timedia1Y=$object->getActiveSheet()->getCell('Y'.$columna)->getFormattedValue();
		 		$time1Y=$this->limpiaHora($timedia1Y);
		 		$time11Y=$this->limpiarEspacios($time1Y);
		 		$time2dY=date_create($time11Y);
		 		if ($time2dY!=False) {
		 			$time2Y=date_format($time2dY, 'H:i:s');
		 		}else{
		 			$time2Y='L';
		 		}		
		 		if ($this->validarHora($time2Y)!=true) {
		 			$object->getActiveSheet()->getStyle('Y'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna Z 12 SALIDA
		 		$timedia1Z=$object->getActiveSheet()->getCell('Z'.$columna)->getFormattedValue();
		 		$time1Z=$this->limpiaHora($timedia1Z);
		 		$time11Z=$this->limpiarEspacios($time1Z);
		 		$time2dZ=date_create($time11Z);
		 		if ($time2dZ!=False) {
		 			$time2Z=date_format($time2dZ, 'H:i:s');
		 		}else{
		 			$time2Z='L';
		 		}		
		 		if ($this->validarHora($time2Z)!=true) {
		 			$object->getActiveSheet()->getStyle('Z'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		if ($time2dZ==$time2dY) {
		 			$object->getActiveSheet()->getStyle('Z'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('Y'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dZ<$time2dY) {
		 			$object->getActiveSheet()->getStyle('Z'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('Y'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1Z=='' || $timedia1Z=='L') {
		 			$object->getActiveSheet()->getStyle('Z'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1Y=='' || $timedia1Y=='L') {
		 			$object->getActiveSheet()->getStyle('Y'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1Z!=$time11Z) {
		 			$object->getActiveSheet()->getStyle('Z'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1Y!=$time11Y) {
		 			$object->getActiveSheet()->getStyle('Y'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AA 13 ENTRADA
		 		$timedia1AA=$object->getActiveSheet()->getCell('AA'.$columna)->getFormattedValue();
		 		$time1AA=$this->limpiaHora($timedia1AA);
		 		$time11AA=$this->limpiarEspacios($time1AA);
		 		$time2dAA=date_create($time11AA);
		 		if ($time2dAA!=False) {
		 			$time2AA=date_format($time2dAA, 'H:i:s');
		 		}else{
		 			$time2AA='L';
		 		}		
		 		if ($this->validarHora($time2AA)!=true) {
		 			$object->getActiveSheet()->getStyle('AA'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AB 13 SALIDA
		 		$timedia1AB=$object->getActiveSheet()->getCell('AB'.$columna)->getFormattedValue();
		 		$time1AB=$this->limpiaHora($timedia1AB);
		 		$time11AB=$this->limpiarEspacios($time1AB);
		 		$time2dAB=date_create($time11AB);
		 		if ($time2dAB!=False) {
		 			$time2AB=date_format($time2dAB, 'H:i:s');
		 		}else{
		 			$time2AB='L';
		 		}		
		 		if ($this->validarHora($time2AB)!=true) {
		 			$object->getActiveSheet()->getStyle('AB'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		if ($time2dAB==$time2dAA ) {
		 			$object->getActiveSheet()->getStyle('AA'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AB'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAB<$time2dAA) {
		 			$object->getActiveSheet()->getStyle('AA'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AB'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AA=='' || $timedia1AA=='L') {
		 			$object->getActiveSheet()->getStyle('AA'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AB=='' || $timedia1AB=='L') {
		 			$object->getActiveSheet()->getStyle('AB'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AA!=$time11AA) {
		 			$object->getActiveSheet()->getStyle('AA'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AB!=$time11AB) {
		 			$object->getActiveSheet()->getStyle('AB'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AC 14 ENTRADA
		 		$timedia1AC=$object->getActiveSheet()->getCell('AC'.$columna)->getFormattedValue();
		 		$time1AC=$this->limpiaHora($timedia1AC);
		 		$time11AC=$this->limpiarEspacios($time1AC);
		 		$time2dAC=date_create($time11AC);
		 		if ($time2dAC!=False) {
		 			$time2AC=date_format($time2dAC, 'H:i:s');
		 		}else{
		 			$time2AC='L';
		 		}		
		 		if ($this->validarHora($time2AC)!=true) {
		 			$object->getActiveSheet()->getStyle('AC'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AD 14 SALIDA
		 		$timedia1AD=$object->getActiveSheet()->getCell('AD'.$columna)->getFormattedValue();
		 		$time1AD=$this->limpiaHora($timedia1AD);
		 		$time11AD=$this->limpiarEspacios($time1AD);
		 		$time2dAD=date_create($time11AD);
		 		if ($time2dAD!=False) {
		 			$time2AD=date_format($time2dAD, 'H:i:s');
		 		}else{
		 			$time2AD='L';
		 		}		
		 		if ($this->validarHora($time2AD)!=true) {
		 			$object->getActiveSheet()->getStyle('AD'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dAD==$time2dAC ) {
		 			$object->getActiveSheet()->getStyle('AC'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AD'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAD<$time2dAC) {
		 			$object->getActiveSheet()->getStyle('AC'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AD'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AD=='' || $timedia1AD=='L') {
		 			$object->getActiveSheet()->getStyle('AD'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AC=='' || $timedia1AC=='L') {
		 			$object->getActiveSheet()->getStyle('AC'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AD!=$time11AD) {
		 			$object->getActiveSheet()->getStyle('AD'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AC!=$time11AC) {
		 			$object->getActiveSheet()->getStyle('AC'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AE 15 ENTRADA
		 		$timedia1AE=$object->getActiveSheet()->getCell('AE'.$columna)->getFormattedValue();
		 		$time1AE=$this->limpiaHora($timedia1AE);
		 		$time11AE=$this->limpiarEspacios($time1AE);
		 		$time2dAE=date_create($time11AE);
		 		if ($time2dAE!=False) {
		 			$time2AE=date_format($time2dAE, 'H:i:s');
		 		}else{
		 			$time2AE='L';
		 		}		
		 		if ($this->validarHora($time2AE)!=true) {
		 			$object->getActiveSheet()->getStyle('AE'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AF 15 SALIDA
		 		$timedia1AF=$object->getActiveSheet()->getCell('AF'.$columna)->getFormattedValue();
		 		$time1AF=$this->limpiaHora($timedia1AF);
		 		$time11AF=$this->limpiarEspacios($time1AF);
		 		$time2dAF=date_create($time11AF);
		 		if ($time2dAF!=False) {
		 			$time2AF=date_format($time2dAF, 'H:i:s');
		 		}else{
		 			$time2AF='L';
		 		}		
		 		if ($this->validarHora($time2AF)!=true) {
		 			$object->getActiveSheet()->getStyle('AF'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		if ($time2dAF==$time2dAE) {
		 			$object->getActiveSheet()->getStyle('AE'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AF'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAF<$time2dAE) {
		 			$object->getActiveSheet()->getStyle('AF'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AE'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AF=='' || $timedia1AF=='L') {
		 			$object->getActiveSheet()->getStyle('AF'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AE=='' || $timedia1AE=='L') {
		 			$object->getActiveSheet()->getStyle('AE'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AF!=$time11AF) {
		 			$object->getActiveSheet()->getStyle('AF'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AE!=$time11AE) {
		 			$object->getActiveSheet()->getStyle('AE'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AG 16 ENTRADA
		 		$timedia1AG=$object->getActiveSheet()->getCell('AG'.$columna)->getFormattedValue();
		 		$time1AG=$this->limpiaHora($timedia1AG);
		 		$time11AG=$this->limpiarEspacios($time1AG);
		 		$time2dAG=date_create($time11AG);
		 		if ($time2dAG!=False) {
		 			$time2AG=date_format($time2dAG, 'H:i:s');
		 		}else{
		 			$time2AG='L';
		 		}		
		 		if ($this->validarHora($time2AG)!=true) {
		 			$object->getActiveSheet()->getStyle('AG'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AH 16 SALIDA
		 		$timedia1AH=$object->getActiveSheet()->getCell('AH'.$columna)->getFormattedValue();
		 		$time1AH=$this->limpiaHora($timedia1AH);
		 		$time11AH=$this->limpiarEspacios($time1AH);
		 		$time2dAH=date_create($time11AH);
		 		if ($time2dAH!=False) {
		 			$time2AH=date_format($time2dAH, 'H:i:s');
		 		}else{
		 			$time2AH='L';
		 		}		
		 		if ($this->validarHora($time2AH)!=true) {
		 			$object->getActiveSheet()->getStyle('AH'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dAH==$time2dAG) {
		 			$object->getActiveSheet()->getStyle('AH'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AG'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAH<$time2dAG) {
		 			$object->getActiveSheet()->getStyle('AH'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AG'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AH=='' || $timedia1AH=='L') {
		 			$object->getActiveSheet()->getStyle('AH'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AG=='' || $timedia1AG=='L') {
		 			$object->getActiveSheet()->getStyle('AG'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AH!=$time11AH) {
		 			$object->getActiveSheet()->getStyle('AH'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AG!=$time11AG) {
		 			$object->getActiveSheet()->getStyle('AG'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AI 17 ENTRADA
		 		$timedia1AI=$object->getActiveSheet()->getCell('AI'.$columna)->getFormattedValue();
		 		$time1AI=$this->limpiaHora($timedia1AI);
		 		$time11AI=$this->limpiarEspacios($time1AI);
		 		$time2dAI=date_create($time11AI);
		 		if ($time2dAI!=False) {
		 			$time2AI=date_format($time2dAI, 'H:i:s');
		 		}else{
		 			$time2AI='L';
		 		}		
		 		if ($this->validarHora($time2AI)!=true) {
		 			$object->getActiveSheet()->getStyle('AI'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AJ 17 SALIDA
		 		$timedia1AJ=$object->getActiveSheet()->getCell('AJ'.$columna)->getFormattedValue();
		 		$time1AJ=$this->limpiaHora($timedia1AJ);
		 		$time11AJ=$this->limpiarEspacios($time1AJ);
		 		$time2dAJ=date_create($time11AJ);
		 		if ($time2dAJ!=False) {
		 			$time2AJ=date_format($time2dAJ, 'H:i:s');
		 		}else{
		 			$time2AJ='L';
		 		}	
		 		if ($this->validarHora($time2AJ)!=true) {
		 			$object->getActiveSheet()->getStyle('AJ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		if ($time2dAJ==$time2dAI ) {
		 			$object->getActiveSheet()->getStyle('AJ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AI'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAJ<$time2dAI) {
		 			$object->getActiveSheet()->getStyle('AJ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AI'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AJ=='' || $timedia1AJ=='L') {
		 			$object->getActiveSheet()->getStyle('AJ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AI=='' || $timedia1AI=='L') {
		 			$object->getActiveSheet()->getStyle('AI'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AJ!=$time11AJ) {
		 			$object->getActiveSheet()->getStyle('AJ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AI!=$time11AI) {
		 			$object->getActiveSheet()->getStyle('AI'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AK 18 ENTRADA
		 		$timedia1AK=$object->getActiveSheet()->getCell('AK'.$columna)->getFormattedValue();
		 		$time1AK=$this->limpiaHora($timedia1AK);
		 		$time11AK=$this->limpiarEspacios($time1AK);
		 		$time2dAK=date_create($time11AK);
		 		if ($time2dAK!=False) {
		 			$time2AK=date_format($time2dAK, 'H:i:s');
		 		}else{
		 			$time2AK='L';
		 		}	
		 		if ($this->validarHora($time2AK)!=true) {
		 			$object->getActiveSheet()->getStyle('AK'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AL 18 SALIDA
		 		$timedia1AL=$object->getActiveSheet()->getCell('AL'.$columna)->getFormattedValue();
		 		$time1AL=$this->limpiaHora($timedia1AL);
		 		$time11AL=$this->limpiarEspacios($time1AL);
		 		$time2dAL=date_create($time11AL);
		 		if ($time2dAL!=False) {
		 			$time2AL=date_format($time2dAL, 'H:i:s');
		 		}else{
		 			$time2AL='L';
		 		}	
		 		if ($this->validarHora($time2AL)!=true) {
		 			$object->getActiveSheet()->getStyle('AL'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		if ($time2dAL==$time2dAK ) {
		 			$object->getActiveSheet()->getStyle('AL'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AK'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAL<$time2dAK) {
		 			$object->getActiveSheet()->getStyle('AL'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AK'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AK=='' || $timedia1AK=='L') {
		 			$object->getActiveSheet()->getStyle('AK'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AL=='' || $timedia1AL=='L') {
		 			$object->getActiveSheet()->getStyle('AL'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AK!=$time11AK) {
		 			$object->getActiveSheet()->getStyle('AK'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AL!=$time11AL) {
		 			$object->getActiveSheet()->getStyle('AL'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AM 19 ENTRADA
		 		$timedia1AM=$object->getActiveSheet()->getCell('AM'.$columna)->getFormattedValue();
		 		$time1AM=$this->limpiaHora($timedia1AM);
		 		$time11AM=$this->limpiarEspacios($time1AM);
		 		$time2dAM=date_create($time11AM);
		 		if($time2dAM!=False) {
		 			$time2AM=date_format($time2dAM, 'H:i:s');
		 		}else{
		 			$time2AM='L';
		 		}	
		 		if ($this->validarHora($time2AM)!=true) {
		 			$object->getActiveSheet()->getStyle('AM'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AN 19 SALIDA
		 		$timedia1AN=$object->getActiveSheet()->getCell('AN'.$columna)->getFormattedValue();
		 		$time1AN=$this->limpiaHora($timedia1AN);
		 		$time11AN=$this->limpiarEspacios($time1AN);
		 		$time2dAN=date_create($time11AN);
		 		if ($time2dAN!=False) {
		 			$time2AN=date_format($time2dAN, 'H:i:s');
		 		}else{
		 			$time2AN='L';
		 		}	
		 		if ($this->validarHora($time2AN)!=true) {
		 			$object->getActiveSheet()->getStyle('AN'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dAN==$time2dAM ) {
		 			$object->getActiveSheet()->getStyle('AN'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AM'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAN<$time2dAM) {
		 			$object->getActiveSheet()->getStyle('AN'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AM'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AN=='' || $timedia1AN=='L') {
		 			$object->getActiveSheet()->getStyle('AN'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AM=='' || $timedia1AM=='L') {
		 			$object->getActiveSheet()->getStyle('AM'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AN!=$time11AN) {
		 			$object->getActiveSheet()->getStyle('AN'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AM!=$time11AM) {
		 			$object->getActiveSheet()->getStyle('AM'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AO 20 ENTRADA
		 		$timedia1AO=$object->getActiveSheet()->getCell('AO'.$columna)->getFormattedValue();
		 		$time1AO=$this->limpiaHora($timedia1AO);
		 		$time11AO=$this->limpiarEspacios($time1AO);
		 		$time2dAO=date_create($time11AO);
		 		if ($time2dAO!=False) {
		 			$time2AO=date_format($time2dAO, 'H:i:s');
		 		}else{
		 			$time2AO='L';
		 		}	
		 		if ($this->validarHora($time2AO)!=true) {
		 			$object->getActiveSheet()->getStyle('AO'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AP 20 SALIDA
		 		$timedia1AP=$object->getActiveSheet()->getCell('AP'.$columna)->getFormattedValue();
		 		$time1AP=$this->limpiaHora($timedia1AP);
		 		$time11AP=$this->limpiarEspacios($time1AP);
		 		$time2dAP=date_create($time11AP);
		 		if($time2dAP!=False) {
		 			$time2AP=date_format($time2dAP, 'H:i:s');
		 		}else{
		 			$time2AP='L';
		 		}	
		 		if ($this->validarHora($time2AP)!=true) {
		 			$object->getActiveSheet()->getStyle('AP'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		if ($time2dAP==$time2dAO ) {
		 			$object->getActiveSheet()->getStyle('AP'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AO'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAP<$time2dAO) {
		 			$object->getActiveSheet()->getStyle('AP'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AO'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AP=='' || $timedia1AP=='L') {
		 			$object->getActiveSheet()->getStyle('AP'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AO=='' || $timedia1AO=='L') {
		 			$object->getActiveSheet()->getStyle('AO'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AP!=$time11AP) {
		 			$object->getActiveSheet()->getStyle('AP'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AO!=$time11AO) {
		 			$object->getActiveSheet()->getStyle('AO'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AQ 21 ENTRADA
		 		$timedia1AQ=$object->getActiveSheet()->getCell('AQ'.$columna)->getFormattedValue();
		 		$time1AQ=$this->limpiaHora($timedia1AQ);
		 		$time11AQ=$this->limpiarEspacios($time1AQ);
		 		$time2dAQ=date_create($time11AQ);
		 		if ($time2dAQ!=False) {
		 			$time2AQ=date_format($time2dAQ, 'H:i:s');
		 		}else{
		 			$time2AQ='L';
		 		}	
		 		if ($this->validarHora($time2AQ)!=true) {
		 			$object->getActiveSheet()->getStyle('AQ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AR 21 SALIDA
		 		$timedia1AR=$object->getActiveSheet()->getCell('AR'.$columna)->getFormattedValue();
		 		$time1AR=$this->limpiaHora($timedia1AR);
		 		$time11AR=$this->limpiarEspacios($time1AR);
		 		$time2dAR=date_create($time11AR);
		 		if ($time2dAR!=False) {
		 			$time2AR=date_format($time2dAR, 'H:i:s');
		 		}else{
		 			$time2AR='L';
		 		}	
		 		if ($this->validarHora($time2AR)!=true) {
		 			$object->getActiveSheet()->getStyle('AR'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dAR==$time2dAQ ) {
		 			$object->getActiveSheet()->getStyle('AR'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AQ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAR<$time2dAQ) {
		 			$object->getActiveSheet()->getStyle('AR'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AQ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AR=='' || $timedia1AR=='L') {
		 			$object->getActiveSheet()->getStyle('AR'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AQ=='' || $timedia1AQ=='L') {
		 			$object->getActiveSheet()->getStyle('AQ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AR!=$time11AR) {
		 			$object->getActiveSheet()->getStyle('AR'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AQ!=$time11AQ) {
		 			$object->getActiveSheet()->getStyle('AQ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AS 22 ENTRADA
		 		$timedia1AS=$object->getActiveSheet()->getCell('AS'.$columna)->getFormattedValue();
		 		$time1AS=$this->limpiaHora($timedia1AS);
		 		$time11AS=$this->limpiarEspacios($time1AS);
		 		$time2dAS=date_create($time11AS);
		 		if ($time2dAS!=False) {
		 			$time2AS=date_format($time2dAS, 'H:i:s');
		 		}else{
		 			$time2AS='L';
		 		}	
		 		if ($this->validarHora($time2AS)!=true) {
		 			$object->getActiveSheet()->getStyle('AS'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AT 22 SALIDA
		 		$timedia1AT=$object->getActiveSheet()->getCell('AT'.$columna)->getFormattedValue();
		 		$time1AT=$this->limpiaHora($timedia1AT);
		 		$time11AT=$this->limpiarEspacios($time1AT);
		 		$time2dAT=date_create($time11AT);
		 		if($time2dAT!=False) {
		 			$time2AT=date_format($time2dAT, 'H:i:s');
		 		}else{
		 			$time2AT='L';
		 		}	
		 		if ($this->validarHora($time2AT)!=true) {
		 			$object->getActiveSheet()->getStyle('AT'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		if ($time2dAT==$time2dAS) {
		 			$object->getActiveSheet()->getStyle('AT'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AS'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAT<$time2dAS) {
		 			$object->getActiveSheet()->getStyle('AT'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AS'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AS=='' || $timedia1AS=='L') {
		 			$object->getActiveSheet()->getStyle('AS'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AT=='' || $timedia1AT=='L') {
		 			$object->getActiveSheet()->getStyle('AT'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AS!=$time11AS) {
		 			$object->getActiveSheet()->getStyle('AS'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AT!=$time11AT) {
		 			$object->getActiveSheet()->getStyle('AT'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AU 23 ENTRADA
		 		$timedia1AU=$object->getActiveSheet()->getCell('AU'.$columna)->getFormattedValue();
		 		$time1AU=$this->limpiaHora($timedia1AU);
		 		$time11AU=$this->limpiarEspacios($time1AU);
		 		$time2dAU=date_create($time11AU);
		 		if($time2dAU!=False) {
		 			$time2AU=date_format($time2dAU, 'H:i:s');
		 		}else{
		 			$time2AU='L';
		 		}	
		 		if ($this->validarHora($time2AU)!=true) {
		 			$object->getActiveSheet()->getStyle('AU'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AV 23 SALIDA
		 		$timedia1AV=$object->getActiveSheet()->getCell('AV'.$columna)->getFormattedValue();
		 		$time1AV=$this->limpiaHora($timedia1AV);
		 		$time11AV=$this->limpiarEspacios($time1AV);
		 		$time2dAV=date_create($time11AV);
		 		if($time2dAV!=False) {
		 			$time2AV=date_format($time2dAV, 'H:i:s');
		 		}else{
		 			$time2AV='L';
		 		}	
		 		if ($this->validarHora($time2AV)!=true) {
		 			$object->getActiveSheet()->getStyle('AV'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		if ($time2dAV==$time2dAU) {
		 			$object->getActiveSheet()->getStyle('AV'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AU'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAV<$time2dAU) {
		 			$object->getActiveSheet()->getStyle('AV'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AU'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AV=='' || $timedia1AV=='L') {
		 			$object->getActiveSheet()->getStyle('AV'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AU=='' || $timedia1AU=='L') {
		 			$object->getActiveSheet()->getStyle('AU'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}
		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AV!=$time11AV) {
		 			$object->getActiveSheet()->getStyle('AV'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AU!=$time11AU) {
		 			$object->getActiveSheet()->getStyle('AU'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AW 24 ENTRADA
		 		$timedia1AW=$object->getActiveSheet()->getCell('AW'.$columna)->getFormattedValue();
		 		$time1AW=$this->limpiaHora($timedia1AW);
		 		$time11AW=$this->limpiarEspacios($time1AW);
		 		$time2dAW=date_create($time11AW);
		 		if ($time2dAW!=False) {
		 			$time2AW=date_format($time2dAW, 'H:i:s');
		 		}else{
		 			$time2AW='L';
		 		}	
		 		if ($this->validarHora($time2AW)!=true) {
		 			$object->getActiveSheet()->getStyle('AW'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AX 24 SALIDA
		 		$timedia1AX=$object->getActiveSheet()->getCell('AX'.$columna)->getFormattedValue();
		 		$time1AX=$this->limpiaHora($timedia1AX);
		 		$time11AX=$this->limpiarEspacios($time1AX);
		 		$time2dAX=date_create($time11AX);
		 		if ($time2dAX!=False) {
		 			$time2AX=date_format($time2dAX, 'H:i:s');
		 		}else{
		 			$time2AX='L';
		 		}	
		 		if ($this->validarHora($time2AX)!=true) {
		 			$object->getActiveSheet()->getStyle('AX'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		if ($time2dAX==$time2dAW ) {
		 			$object->getActiveSheet()->getStyle('AW'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AX'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAX<$time2dAW) {
		 			$object->getActiveSheet()->getStyle('AX'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AW'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AW=='' || $timedia1AW=='L') {
		 			$object->getActiveSheet()->getStyle('AW'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AX=='' || $timedia1AX=='L') {
		 			$object->getActiveSheet()->getStyle('AX'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AW!=$time11AW) {
		 			$object->getActiveSheet()->getStyle('AW'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AX!=$time11AX) {
		 			$object->getActiveSheet()->getStyle('AX'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna AY 25 ENTRADA
		 		$timedia1AY=$object->getActiveSheet()->getCell('AY'.$columna)->getFormattedValue();
		 		$time1AY=$this->limpiaHora($timedia1AY);
		 		$time11AY=$this->limpiarEspacios($time1AY);
		 		$time2dAY=date_create($time11AY);
		 		if ($time2dAY!=False) {
		 			$time2AY=date_format($time2dAY, 'H:i:s');
		 		}else{
		 			$time2AY='L';
		 		}	
		 		if ($this->validarHora($time2AY)!=true) {
		 			$object->getActiveSheet()->getStyle('AY'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna AZ 25 SALIDA
		 		$timedia1AZ=$object->getActiveSheet()->getCell('AZ'.$columna)->getFormattedValue();
		 		$time1AZ=$this->limpiaHora($timedia1AZ);
		 		$time11AZ=$this->limpiarEspacios($time1AZ);
		 		$time2dAZ=date_create($time11AZ);
		 		if($time2dAZ!=False) {
		 			$time2AZ=date_format($time2dAZ, 'H:i:s');
		 		}else{
		 			$time2AZ='L';
		 		}	
		 		if ($this->validarHora($time2AZ)!=true) {
		 			$object->getActiveSheet()->getStyle('AZ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		if ($time2dAZ==$time2dAY ) {
		 			$object->getActiveSheet()->getStyle('AY'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('AZ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dAZ<$time2dAY) {
		 			$object->getActiveSheet()->getStyle('AY'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('AZ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1AZ=='' || $timedia1AZ=='L') {
		 			$object->getActiveSheet()->getStyle('AZ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1AY=='' || $timedia1AY=='L') {
		 			$object->getActiveSheet()->getStyle('AY'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1AZ!=$time11AZ) {
		 			$object->getActiveSheet()->getStyle('AZ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1AY!=$time11AY) {
		 			$object->getActiveSheet()->getStyle('AY'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna BA 26 ENTRADA
		 		$timedia1BA=$object->getActiveSheet()->getCell('BA'.$columna)->getFormattedValue();
		 		$time1BA=$this->limpiaHora($timedia1BA);
		 		$time11BA=$this->limpiarEspacios($time1BA);
		 		$time2dBA=date_create($time11BA);
		 		if($time2dBA!=False) {
		 			$time2BA=date_format($time2dBA, 'H:i:s');
		 		}else{
		 			$time2BA='L';
		 		}	
		 		if ($this->validarHora($time2BA)!=true) {
		 			$object->getActiveSheet()->getStyle('BA'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna BB 26 SALIDA
		 		$timedia1BB=$object->getActiveSheet()->getCell('BB'.$columna)->getFormattedValue();
		 		$time1BB=$this->limpiaHora($timedia1BB);
		 		$time11BB=$this->limpiarEspacios($time1BB);
		 		$time2dBB=date_create($time11BB);
		 		if ($time2dBB!=False) {
		 			$time2BB=date_format($time2dBB, 'H:i:s');
		 		}else{
		 			$time2BB='L';
		 		}	
		 		if ($this->validarHora($time2BB)!=true) {
		 			$object->getActiveSheet()->getStyle('BB'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dBB==$time2dBA) {
		 			$object->getActiveSheet()->getStyle('BB'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('BA'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dBB<$time2dBA) {
		 			$object->getActiveSheet()->getStyle('BB'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('BA'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1BB=='' || $timedia1BB=='L') {
		 			$object->getActiveSheet()->getStyle('BB'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1BA=='' || $timedia1BA=='L') {
		 			$object->getActiveSheet()->getStyle('BA'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1BA!=$time11BA) {
		 			$object->getActiveSheet()->getStyle('BA'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1BB!=$time11BB) {
		 			$object->getActiveSheet()->getStyle('BB'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna BC 27 ENTRADA
		 		$timedia1BC=$object->getActiveSheet()->getCell('BC'.$columna)->getFormattedValue();
		 		$time1BC=$this->limpiaHora($timedia1BC);
		 		$time11BC=$this->limpiarEspacios($time1BC);
		 		$time2dBC=date_create($time11BC);
		 		if ($time2dBC!=False) {
		 			$time2BC=date_format($time2dBC, 'H:i:s');
		 		}else{
		 			$time2BC='L';
		 		}	
		 		if ($this->validarHora($time2BC)!=true) {
		 			$object->getActiveSheet()->getStyle('BC'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna BD 27 SALIDA
		 		$timedia1BD=$object->getActiveSheet()->getCell('BD'.$columna)->getFormattedValue();
		 		$time1BD=$this->limpiaHora($timedia1BD);
		 		$time11BD=$this->limpiarEspacios($time1BD);
		 		$time2dBD=date_create($time1BD);
		 		if ($time2dBD!=False) {
		 			$time2BD=date_format($time2dBD, 'H:i:s');
		 		}else{
		 			$time2BD='L';
		 		}	
		 		if ($this->validarHora($time2BD)!=true) {
		 			$object->getActiveSheet()->getStyle('BD'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dBD==$time2dBC ) {
		 			$object->getActiveSheet()->getStyle('BD'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('BC'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dBD<$time2dBC) {
		 			$object->getActiveSheet()->getStyle('BD'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('BC'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1BD=='' || $timedia1BD=='L') {
		 			$object->getActiveSheet()->getStyle('BD'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1BC=='' || $timedia1BC=='L') {
		 			$object->getActiveSheet()->getStyle('BC'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1BD!=$time11BD) {
		 			$object->getActiveSheet()->getStyle('BD'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1BC!=$time11BC) {
		 			$object->getActiveSheet()->getStyle('BC'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna BE 28 ENTRADA
		 		$timedia1BE=$object->getActiveSheet()->getCell('BE'.$columna)->getFormattedValue();
		 		$time1BE=$this->limpiaHora($timedia1BE);
		 		$time11BE=$this->limpiarEspacios($time1BE);
		 		$time2dBE=date_create($time11BE);
		 		if ($time2dBE!=False) {
		 			$time2BE=date_format($time2dBE, 'H:i:s');
		 		}else{
		 			$time2BE='L';
		 		}	
		 		if ($this->validarHora($time2BE)!=true) {
		 			$object->getActiveSheet()->getStyle('BE'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna BF 28 SALIDA
		 		$timedia1BF=$object->getActiveSheet()->getCell('BF'.$columna)->getFormattedValue();
		 		$time1BF=$this->limpiaHora($timedia1BF);
		 		$time11BF=$this->limpiarEspacios($time1BF);
		 		$time2dBF=date_create($time11BF);
		 		if ($time2dBF!=False) {
		 			$time2BF=date_format($time2dBF, 'H:i:s');
		 		}else{
		 			$time2BF='L';
		 		}	
		 		if ($this->validarHora($time2BF)!=true) {
		 			$object->getActiveSheet()->getStyle('BF'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dBF==$time2dBE ) {
		 			$object->getActiveSheet()->getStyle('BF'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('BE'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dBF<$time2dBE) {
		 			$object->getActiveSheet()->getStyle('BE'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('BF'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1BF=='' || $timedia1BF=='L') {
		 			$object->getActiveSheet()->getStyle('BF'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1BE=='' || $timedia1BE=='L') {
		 			$object->getActiveSheet()->getStyle('BE'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1BF!=$time11BF) {
		 			$object->getActiveSheet()->getStyle('BF'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1BE!=$time11BE) {
		 			$object->getActiveSheet()->getStyle('BE'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna BG 29 ENTRADA
		 		$timedia1BG=$object->getActiveSheet()->getCell('BG'.$columna)->getFormattedValue();
		 		$time1BG=$this->limpiaHora($timedia1BG);
		 		$time11BG=$this->limpiarEspacios($time1BG);
		 		$time2dBG=date_create($time11BG);
		 		if ($time2dBG!=False) {
		 			$time2BG=date_format($time2dBG, 'H:i:s');
		 		}else{
		 			$time2BG='L';
		 		}	
		 		if ($this->validarHora($time2BG)!=true) {
		 			$object->getActiveSheet()->getStyle('BG'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna BH 29 SALIDA
		 		$timedia1BH=$object->getActiveSheet()->getCell('BH'.$columna)->getFormattedValue();
		 		$time1BH=$this->limpiaHora($timedia1BH);
		 		$time11BH=$this->limpiarEspacios($time1BH);
		 		$time2dBH=date_create($time11BH);
		 		if ($time2dBH!=False) {
		 			$time2BH=date_format($time2dBH, 'H:i:s');
		 		}else{
		 			$time2BH='L';
		 		}	
		 		if ($this->validarHora($time2BH)!=true) {
		 			$object->getActiveSheet()->getStyle('BH'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}


		 		if ($time2dBH==$time2dBG) {
		 			$object->getActiveSheet()->getStyle('BH'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('BG'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dBH<$time2dBG) {
		 			$object->getActiveSheet()->getStyle('BH'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('BG'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1BH=='' || $timedia1BH=='L') {
		 			$object->getActiveSheet()->getStyle('BH'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1BG=='' || $timedia1BG=='L') {
		 			$object->getActiveSheet()->getStyle('BG'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1BH!=$time11BH) {
		 			$object->getActiveSheet()->getStyle('BH'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1BG!=$time11BG) {
		 			$object->getActiveSheet()->getStyle('BG'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna BI 30 SALIDA
		 		$timedia1BI=$object->getActiveSheet()->getCell('BI'.$columna)->getFormattedValue();
		 		$time1BI=$this->limpiaHora($timedia1BI);
		 		$time11BI=$this->limpiarEspacios($time1BI);
		 		$time2dBI=date_create($time11BI);
		 		if ($time2dBI!=False) {
		 			$time2BI=date_format($time2dBI, 'H:i:s');
		 		}else{
		 			$time2BI='L';
		 		}	
		 		if ($this->validarHora($time2BI)!=true) {
		 			$object->getActiveSheet()->getStyle('BI'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna BJ 30 ENTRADA
		 		$timedia1BJ=$object->getActiveSheet()->getCell('BJ'.$columna)->getFormattedValue();
		 		$time1BJ=$this->limpiaHora($timedia1BJ);
		 		$time11BJ=$this->limpiarEspacios($time1BJ);
		 		$time2dBJ=date_create($time11BJ);
		 		if ($time2dBJ!=False) {
		 			$time2BJ=date_format($time2dBJ, 'H:i:s');
		 		}else{
		 			$time2BJ='L';
		 		}	
		 		if ($this->validarHora($time2BJ)!=true) {
		 			$object->getActiveSheet()->getStyle('BJ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dBJ==$time2dBI) {
		 			$object->getActiveSheet()->getStyle('BJ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('BI'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dBJ<$time2dBI) {
		 			$object->getActiveSheet()->getStyle('BI'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('BJ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1BJ=='' || $timedia1BJ=='L') {
		 			$object->getActiveSheet()->getStyle('BJ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1BI=='' || $timedia1BI=='L') {
		 			$object->getActiveSheet()->getStyle('BI'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1BJ!=$time11BJ) {
		 			$object->getActiveSheet()->getStyle('BJ'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1BI!=$time11BI) {
		 			$object->getActiveSheet()->getStyle('BI'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		//Columna BK 31 SALIDA
		 		$timedia1BK=$object->getActiveSheet()->getCell('BK'.$columna)->getFormattedValue();
		 		$time1BK=$this->limpiaHora($timedia1BK);
		 		$time11BK=$this->limpiarEspacios($time1BK);
		 		$time2dBK=date_create($time11BK);
		 		if ($time2dBK!=False) {
		 			$time2BK=date_format($time2dBK, 'H:i:s');
		 		}else{
		 			$time2BK='L';
		 		}	
		 		if ($this->validarHora($time2BK)!=true) {
		 			$object->getActiveSheet()->getStyle('BK'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		//Columna BL 31 ENTRADA
		 		$timedia1BL=$object->getActiveSheet()->getCell('BL'.$columna)->getFormattedValue();
		 		$time1BL=$this->limpiaHora($timedia1BL);
		 		$time11BL=$this->limpiarEspacios($time1BL);
		 		$time2dBL=date_create($time11BL);
		 		if ($time2dBL!=False) {
		 			$time2BL=date_format($time2dBL, 'H:i:s');
		 		}else{
		 			$time2BL='L';
		 		}	
		 		if ($this->validarHora($time2BL)!=true) {
		 			$object->getActiveSheet()->getStyle('BL'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}

		 		if ($time2dBL==$time2dBK) {
		 			$object->getActiveSheet()->getStyle('BK'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 			$object->getActiveSheet()->getStyle('BL'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00a65a');
		 		} elseif ($time2dBL<$time2dBK) {
		 			$object->getActiveSheet()->getStyle('BK'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 			$object->getActiveSheet()->getStyle('BL'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6bbd97');
		 		} 
		 		//VALIDAR QUE SI ES CAMPO ES "L" O VACIO PINTAR EN BLANCO
		 		if ($timedia1BL=='' || $timedia1BL=='L') {
		 			$object->getActiveSheet()->getStyle('BL'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		} 
		 		if ($timedia1BK=='' || $timedia1BK=='L') {
		 			$object->getActiveSheet()->getStyle('BK'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
		 		}

		 		// Validar Formato de hora (que no tenga espacios)
		 		if ($time1BL!=$time11BL) {
		 			$object->getActiveSheet()->getStyle('BL'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}	
		 		if ($time1BK!=$time11BK) {
		 			$object->getActiveSheet()->getStyle('BK'.$columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e91e63');
		 		}
		 		// var_dump($time11BK,$timedia1BL,$);exit;
		 		// echo "holita n|".$columna;
		 		$columna++;
		 		echo 1;
		 	}
		 			echo 3;
		 		
		 		// $columna++;
		 	}
		 	var_dump(5);
		 	echo 6;
		 	header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="ExcelValidado.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
			ob_end_clean();
			$objWriter->save('php://output');
			redirect(site_url("Adm_ModuloJornadas/adminJornadas"));

				 	
		}else{
			echo "alert('Error')";
			redirect(site_url("Adm_ModuloJornadas/adminJornadas"));
		}
		// redirect(site_url("Adm_ModuloJornadas/adminJornadas"));
	}

		public function IngExcel(){		
			if(isset($_SESSION["sesion"])){
    			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
    				if(isset($_FILES['excelv']['name'])){	
    					$fecha = getdate();
						$mes = $fecha['mon'];
						$anio = $fecha['year'];
						$excel = $this->limpiaEspacio($_FILES['excelv']['name']);	
					 	$R=$this->subirArchivos($excel,0,0);
					 	$this->load->library('phpexcel');
					 	$this->load->model("ModuloJornadas");
						$this->load->model("ModuloUsuario");
						$this->load->model("ModuloPermisos");
					 	$BD=$_SESSION["BDSecundaria"];
					 	$cli=$_SESSION["Cliente"];
					 	$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
						$objReader = PHPExcel_IOFactory::createReader($tipo);
						$object = $objReader->load("archivos/archivos_Temp/".$excel);
						$object->setActiveSheetIndex(0);
						$defaultPrecision = ini_get('precision');
						ini_set('precision', $defaultPrecision);
						$parametro=0;
						$parametroDias=0;
						$id_creador=$_SESSION['Usuario'];
						$fila=3;
						$filaVal=3;
						$filaDia=1;
						$filaRP=3;
						$contador=0;
						$error=0;
						$contadorValDias=0;
						$lineaDia=0;
						$columna='C';
						$columnDay='C';
						$columnaS='D';
						$dayHour='C';
						$dayHourE='C';
						$dayHourS='D';
						$highRow=$object->setActiveSheetIndex(0)->getHighestRow();
						$FechaInicioDias=date('d/m/Y', strtotime($object->getActiveSheet()->getCell('B1')->getFormattedValue()));
						$fechaDias=explode('/',$FechaInicioDias);
	 			 		$mes=$fechaDias[1];
				 		$anio=$fechaDias[2];
				 		$mesExiste=intval($fechaDias[1]);
				 		$anioExiste=intval($fechaDias[2]);
				 		$horaDiaCol='C';
				 		$contadorDiaEntrada=0;
				 		$cont=0;
				 		$filaSpace=3;
				 		$b=":";
				 		$errorChar="";
	 			 		$numerosDias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); 
	 			 		$fechaVal=$mes."/".$anio;
	 			 		$existeHorario=$this->ModuloJornadas->BuscarHorarioFecha($mesExiste,$anioExiste,$BD);
	 			 		setlocale(LC_ALL,"es_ES");
	 			 		$date=DateTime::createFromFormat("d/m/Y", $FechaInicioDias);
						$mesVal=strftime("%B",$date->getTimestamp());
	 			 		if ($existeHorario["Fecha"]!=$fechaVal) {
	 			 		// exit();
	 			 		// var_dump($highRow);exit();
	 			 		//POR TERMINAR LA VALIDACION DE ESPACIOS EN BLANCO
	 			 		// for ($j=0; $j <2; $j++) { 	 			 		
		 			 	// 	for ($i=0; $i < $numerosDias*2; $i++) { 
		 			 	// 		$diaEspacio[$contadorDiaEntrada]=$object->getActiveSheet()->getCell($horaDiaCol.$filaSpace)->getFormattedValue();
		 			 	// 		if ($diaEspacio[$contadorDiaEntrada]==null) {
		 			 	// 			# code...
		 			 	// 		}
		 			 	// 		$horaDiaCol++;
		 			 	// 		$contadorDiaEntrada++;
		 			 	// 	}
		 			 	// 	$filaSpace++;
		 			 	// 	$horaDiaCol='C';
		 			 	// 	// $cont++;
		 			 		
	 			 			
	 			 		// }
	 			 		// if (in_array(null, $diaEspacio)) {
	 			 		// 	echo "espacio vacio";
	 			 		// }else{
	 			 		// 	echo "todo ok";
	 			 		// }
	 			 	// 	while($parametroDias==0){	
					 	// 	if($object->getActiveSheet()->getCell('A'.$filaSpace)->getCalculatedValue()==NULL){
					 	// 		$parametroDias=1;
					 	// 	}else{	
			 			//  		for ($i=0; $i < $numerosDias*2; $i++) { 
			 			//  			$entrada[$cont][$contadorDiaEntrada]=$object->getActiveSheet()->getCell($horaDia.$filaSpace)->getFormattedValue();
			 			//  			if ($entrada[$cont][$contadorDiaEntrada]==null) {
			 			//  				$parametroDias=1;
			 			//  				$error=43;
			 			//  			}
			 			//  			$contadorDiaEntrada++;
			 			//  		}
			 			//  		$cont++;
			 			//  	}
			 			// }
			 			 	// var_dump($diaEspacio);
	 			 		// exit();		 		
	 			 		for ($i=3; $i < $highRow; $i++) { 
	 			 			$columnasTotales[$i]=$object->setActiveSheetIndex(0)->getHighestColumn($filaVal);
		 			 		if ($columnasTotales[$i]=='BL' || $columnasTotales[$i]=='BK') {
		 			 			$colTotales[$i]=31;
		 			 		}elseif ($columnasTotales[$i]=='BJ' || $columnasTotales[$i]=='BI') {
		 			 			$colTotales[$i]=30;
		 			 		}elseif ($columnasTotales[$i]=='BH' || $columnasTotales[$i]=='BG') {
		 			 			$colTotales[$i]=29;
		 			 		}elseif ($columnasTotales[$i]=='BE' || $columnasTotales[$i]=='BF') {
		 			 			$colTotales[$i]=28;
		 			 		}else{
		 			 			$colTotales[$i]=0;
		 			 		}

		 			 		if ($colTotales[$i]!=$numerosDias) {
		 			 			$mesIncorrecto[$i]=1;
		 			 			$error=42;
		 			 		}else{
		 			 			$mesIncorrecto[$i]=0;
		 			 		}		 			 		
		 			 		$filaVal++;
		 			 		$contadorValDias++;
	 			 		}
	 			 		// var_dump($colTotales,$error);exit();
	 			 		if (in_array(1, $mesIncorrecto)) {
	 			 			$mens['tipo'] = $error;	
			    			$data["Usuario"]=$_SESSION["Usuario"];					
							$data["Nombre"]=$_SESSION["Nombre"];
							$data["Perfil"] = $_SESSION["Perfil"];
							$data["Cliente"] = $_SESSION["Cliente"];
							$data["NombreCliente"]=$_SESSION["NombreCliente"];
							$data["Cargo"] = $_SESSION["Cargo"];
							$data["Clientes"]= $this->funcion_login->elegirCliente();
							$this->load->model("ModuloCliente");
							$this->load->model("ModuloPermisos");
							$data["listaPermisos"]=$this->ModuloPermisos->listarPermisos();
							$data["ListarEmpresa"]=$this->ModuloCliente->ListarEmpresaActivas();
							$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
							$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
						    $this->load->view('contenido');
						    $this->load->view('layout/header',$data);
						    $this->load->view('layout/sidebar',$data);
						    $this->load->view('admin/adminJornadas',$data);
						    $this->load->view('layout/footer',$data);
						    $this->load->view('layout/mensajes',$mens);
	 			 		}else{	 			 		
		 			 		echo '<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>';
		 			 		while($parametro==0){	
					 		if($object->getActiveSheet()->getCell('A'.$filaRP)->getCalculatedValue()==NULL)
					 		{
					 			$parametro=1;
					 		}else{				
					 			$Rut[$contador]=$object->getActiveSheet()->getCell('A'.$filaRP)->getFormattedValue();
					 			$RutSV=$this->limpiarRut($this->limpiarComilla($Rut));
					 			$resp=$this->ModuloUsuario->validarRutUsuario($RutSV[$contador],$cli);
					 			if($resp==null){
					 				$parametro=1;
					 				$error=9;
					 				break;
					 			}
					 			$PDV[$contador]=$object->getActiveSheet()->getCell('B'.$filaRP)->getFormattedValue();
					 			$exisite=$this->ModuloJornadas->ValidarLocal($BD,$PDV[$contador]);
					 			if($PDV[$contador]==null || $exisite!=1){
					 				$parametro=1;
					 				$error=10;
					 				break;	
					 			}
					 			$filaRP++;
						 		$contE=0;
						 		$contS=0;
								for ($i=0; $i < $numerosDias*2; $i++) { 
										if ($i%2==0) {
											$diaEntrada[]=$object->getActiveSheet()->getCell($dayHour.$filaDia)->getCalculatedValue();
											$dayHour++;
										}else{
											$diaSalida[]=$object->getActiveSheet()->getCell($dayHour.$filaDia)->getCalculatedValue();			
											$dayHour++;
									}
								}	
								$dayHour='C';
								$contEntrada=0;
								$contSalida=0;
								$row=0;
								for ($i=0; $i < $numerosDias*2; $i++) { 
										if ($i%2==0) {
												$entrada[$contador][$contEntrada]=$object->getActiveSheet()->getCell($dayHourE.$fila)->getFormattedValue();
												$idPermisoEntrada[$contador][$contEntrada]=$this->ModuloPermisos->buscarIdPermiso($entrada[$contador][$contEntrada]);
													if ($idPermisoEntrada[$contador][$contEntrada]==null) {
														$idPermisoEntrada[$contador][$contEntrada]['id_permiso']=0;
														if (strpos($entrada[$contador][$contEntrada],$b)===false) {
															$lineaDia=$contador;
															$parametro=1;
															$error=49;
															$errorChar=$entrada[$contador][$contEntrada];
															break;
														}
													}else{
														$entrada[$contador][$contEntrada]='00:00:00';
													}
												$contEntrada++;
											}else{
												$salida[$contador][$contSalida]=$object->getActiveSheet()->getCell($dayHourE.$fila)->getFormattedValue();
												$idPermisoSalida[$contador][$contSalida]=$this->ModuloPermisos->buscarIdPermiso($salida[$contador][$contSalida]);
													if ($idPermisoSalida[$contador][$contSalida]==null) {
														$idPermisoSalida[$contador][$contSalida]['id_permiso']=0;
														if (strpos($salida[$contador][$contSalida],$b)===false) {
															$lineaDia=$contador;
															$parametro=1;
															$error=49;
															$errorChar=$salida[$contador][$contSalida];
															break;
														}
													}else{
														$salida[$contador][$contSalida]='00:00:00';
													}
												$contSalida++;
											}
											$dayHourE++;							
										}
										$dayHourE='C';
										$fila++;
										$contador++;
									}
						}	
						$suma=0;
					if($error==0){
					for ($f=0; $f < $contador; $f++) { 
							$idJornada[1]['ID']=$this->ModuloJornadas->ingresarJornada($Rut[$f],$PDV[$f],$id_creador,$BD);
							$idJ=implode($idJornada[1]['ID']);
			
					for ($i=0; $i <$numerosDias; $i++) { 
		    					$cant=$this->ModuloJornadas->IngresarHorario($idJ,$diaEntrada[$i],$FechaInicioDias,$entrada[$f][$i],$salida[$f][$i],$id_creador,intval($idPermisoEntrada[$f][$i]['id_permiso']),$BD);
		    				}
		    			}
		    			$mens['tipo'] = 8;	
		    			$mens['cantidad']=$contador;
		    			$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["Cargo"] = $_SESSION["Cargo"];
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$this->load->model("ModuloCliente");
						$this->load->model("ModuloPermisos");
						$data["listaPermisos"]=$this->ModuloPermisos->listarPermisos();
						$data["ListarEmpresa"]=$this->ModuloCliente->ListarEmpresaActivas();
						$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
						$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
					    $this->load->view('contenido');
					    $this->load->view('layout/header',$data);
					    $this->load->view('layout/sidebar',$data);
					    $this->load->view('admin/adminJornadas',$data);
					    $this->load->view('layout/footer',$data);
					    $this->load->view('layout/mensajes',$mens);
					}else{
						$mens['lineaDia']=$lineaDia+3;
						$mens['tipo'] = $error;	
						$mens['char']=$errorChar;
		    			$mens['cantidad']=($contador+3);
		    			$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["Cargo"] = $_SESSION["Cargo"];
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$this->load->model("ModuloCliente");
						$this->load->model("ModuloPermisos");
						$data["listaPermisos"]=$this->ModuloPermisos->listarPermisos();
						$data["ListarEmpresa"]=$this->ModuloCliente->ListarEmpresaActivas();
						$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
						$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
					    $this->load->view('contenido');
					    $this->load->view('layout/header',$data);
					    $this->load->view('layout/sidebar',$data);
					    $this->load->view('admin/adminJornadas',$data);
					    $this->load->view('layout/footer',$data);
					    $this->load->view('layout/mensajes',$mens);
					}
				}
			}else{
	 			$mens['tipo'] = 48;
	 			$mens['mes'] = $mesVal;		
    			$mens['cantidad']=$contador;
    			$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->model("ModuloCliente");
				$this->load->model("ModuloPermisos");
				$data["listaPermisos"]=$this->ModuloPermisos->listarPermisos();
				$data["ListarEmpresa"]=$this->ModuloCliente->ListarEmpresaActivas();
				$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
				$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
			    $this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			    $this->load->view('layout/sidebar',$data);
			    $this->load->view('admin/adminJornadas',$data);
			    $this->load->view('layout/footer',$data);
			    $this->load->view('layout/mensajes',$mens);
		 		}
			}
		}
	}
}
				
	function limpiaHora($rut){
		$patron = "/[PMA ]/i";
		$cadena_nueva = preg_replace($patron, "", $rut);
		return $cadena_nueva;
	}

	function cambiarEstadoJornadaFinal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_idjor"])){
					if(isset($_GET['opcion'])){
						if(is_numeric($_GET['opcion'])){
							$buscasana = $_GET['opcion'];
						}else{
							$buscasana=1;
						}
					}else{
						$buscasana=1;
					}
					$this->load->model("ModuloJornadas");
					$thismonth=date("m");
					$BD=$_SESSION["BDSecundaria"];					
					$id_creador=$_SESSION["Usuario"];
					$id_usuario=$_POST["txt_user"];
					$idjor=$_POST["txt_idjor"];
					$vigencia=$_POST["txt_estado"];
					$filas=$this->ModuloJornadas->cambiarEstadoJornada($idjor,$vigencia,$id_creador,$BD);
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
					redirect(site_url("Adm_ModuloJornadas/adminHorario"));
				}else{
					redirect(site_url("Adm_ModuloJornadas/adminHorario"));
				}
			}
		}
	}

	public function validateTime($time){
    	$pattern="/^([0-1][0-9]|2[0-3])(:)([0-5][0-9])(:)([0-5][0-9])$/";
    	if(preg_match($pattern,$time))
        	return true;
    	return false;
	}

	public function validarHora($time){
		$vhora1=date_create('00:00:00');
		$vhora2=date_create('00:05:00');
		$vhora3=date_create('00:10:00');
		$vhora4=date_create('00:20:00');
		$vhora5=date_create('00:30:00');
		$vhora6=date_create('00:40:00');
		$vhora7=date_create('00:50:00');
		$vhora8=date_create('00:15:00');
		$vhora9=date_create('00:25:00');
		$vhora10=date_create('00:35:00');
		$vhora11=date_create('00:45:00');
		$vhora12=date_create('00:55:00');
		$vhora13='L';
		$vhora14='';
		$time1=date_create($time);
		$vhora1a=date_format($vhora1,"i:s");
		$vhora2a=date_format($vhora2,"i:s");
		$vhora3a=date_format($vhora3,"i:s");
		$vhora4a=date_format($vhora4,"i:s");
		$vhora5a=date_format($vhora5,"i:s");
		$vhora6a=date_format($vhora6,"i:s");
		$vhora7a=date_format($vhora7,"i:s");
		$vhora8a=date_format($vhora8,"i:s");
		$vhora9a=date_format($vhora9,"i:s");
		$vhora10a=date_format($vhora10,"i:s");
		$vhora11a=date_format($vhora11,"i:s");
		$vhora12a=date_format($vhora12,"i:s");
		$time11=date_format($time1,"i:s");
    	if($time11==$vhora1a || $time11==$vhora2a || $time11==$vhora3a || $time11==$vhora4a || $time11==$vhora5a || $time11==$vhora6a || $time11==$vhora7a || $time11==$vhora8a || $time11==$vhora9a || $time11==$vhora10a || $time11==$vhora11a || $time11==$vhora12a || $time==$vhora14 || $time==$vhora14)
        	return true;
    	return false;
	}
	

    function limpiaEspacio($var){
    	$patron = "/[' ']/i";
		$cadena_nueva = preg_replace($patron,"",$var);
		return $cadena_nueva; 
 	}

 	  function limpiarEspacios($var){
    	$patron = "/[' ']/i";
		$cadena_nueva = preg_replace("' '","",$var);
		return $cadena_nueva; 
 	}

 	function limpialetras($var){
  		$nuevo = preg_replace("/[^0-9]/", "",$var);
  		$nuevo2 = preg_replace("['-']", "",$nuevo);
  		$nuevo3 = preg_replace("[' ']", "",$nuevo2);
  		return $nuevo3;
 	}	

 	public function subirArchivo($filename){
		$archivo ='excel';
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

	function limpiarut($rut){
		//$cadena = "13.987.458-2";
		$patron = "/[.]/i";    //<---- asi
		$cadena_nueva = preg_replace($patron, "", $rut);
		return $cadena_nueva; //Esto dar�a "13987458-2"
	}

	// function limpiaHora($rut){
	// 	$patron = "/[PMA ]/i";
	// 	$cadena_nueva = preg_replace($patron, "", $rut);
	// 	return $cadena_nueva;
	// }
	
	function rangoFechaSql($rangoFecha){
		$patron = "/[-]/i";   
		$cadena_nueva = preg_replace($patron, "", $rangoFecha);
		return $cadena_nueva; 
	}

	function VerPermiso(){
		// var_dump($_POST);exit();
		$idUser=$_POST["idUser"];
		$idJornada=$_POST["idJornada"];
		$BD=$_SESSION["BDSecundaria"];
		$this->load->model("ModuloPermisos");
		$permisos=$this->ModuloPermisos->listarPermisosPorId($idUser,$idJornada,$BD);
		echo "<div class='modal-header'>
			<h6 class='modal-title'>Permisos</h6>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
		</div>		
		<div class='modal-body'>	
			<form id='mCerrarPermiso' method='POST' >
				<input type='hidden' id='idUser' name='idUser' value='".$idUser."'>
				<input type='hidden' id='idJor' name='idJor' value='".$idJornada."'>
				<div class='row'>
					<div class='col-md-12'>
						<select class='form-control' name='idHor' id='idHor' onchange='verrevoc()'>
							<option value='0'> Seleccione Permiso</option>";								
							foreach ($permisos as $p) {
								echo "<option value='".$p["id_horario"]."' >Fecha: ".date('d-m-Y',strtotime($p["fecha"]))."  -  Permiso: ".$p["NombrePermiso"]." (".$p["Tipo"].")</option>";
								$hor[]="<div class='col-md-12' id='divperm".$p["id_horario"]."' style='display:none;'>
									<div class='card border-danger mb-3'>
										<div class='card-body'>
											<div class='row'>
												<div class='col-md-4'><div class='heading'>Fecha: ".date('d-m-Y',strtotime($p["fecha"]))."</div></div>
												<div class='col-md-8'><div class='heading'>Permiso: ".$p["NombrePermiso"]." - ".$p["Remunerado"]."</div></div>
												<div class='col-md-12 mb-3'><div class='btn-group'><button type='button' class='btn btn-danger btn-sm' style='font-size: 12px; min-height: 20px; ' onclick='veraddhora(".$p["id_horario"].")'>Revocar Permiso</button></div></div>
												<div class='col-md-12 row' id='divhora".$p["id_horario"]."'  style='display:none;'>
													<div class='col-md-4'><input  style='font-size: 11px; min-height: 20px; '  type='text' class='form-control' id='Edia-".$p["id_horario"]."' placeholder='Entrada' name='Edia-".$p["id_horario"]."' data-plugin='timepicker'  /></div>
													<div class='col-md-4'><input  style='font-size: 11px; min-height: 20px; '  type='text' class='form-control' id='Sdia-".$p["id_horario"]."' placeholder='Salida' name='Sdia-".$p["id_horario"]."' data-plugin='timepicker' /></div>
													<div class='col-md-4'><button type='button' class='btn btn-danger btn-sm' style='margin-top:0px; font-size: 12px; min-height: 20px; ' onclick='revocarPermiso();'>Agregar Horario</button></div>
												</div>
											</div>
										</div>
									</div>
								</div>";
								$shor[]=" $('#Edia-".$p["id_horario"]."').timepicker(); $('#Sdia-".$p["id_horario"]."').timepicker();";
							}

					echo"	</select><br>
					</div>";
					foreach ($hor as $h) {
						echo $h;
					}
					echo "<script>";
					foreach ($shor as $h) {
						echo $h;
					}
					echo "</script>";
			echo"</div>
			</form>		
		</div>";
	}

	function RevocarPermisoF(){
		$idUser=$_POST["idUser"];
		$idJor=$_POST["idJor"];
		if(isset($_POST["idHor"])){
			$idHor=$_POST["idHor"];
			$entrada=$_POST["Edia-".$idHor];
			$salida=$_POST["Sdia-".$idHor];
			$BD=$_SESSION["BDSecundaria"];
			$this->load->model("ModuloPermisos");
			echo json_encode($this->ModuloPermisos->revocarPermiso($idUser,$idJor,$idHor,$entrada,$salida,$BD));
		}		
	}

	function AsignarPermisoUsuario(){
			$this->load->model("ModuloPermisos");
			$this->load->model("ModuloJornadas");
			$BD=$_SESSION["BDSecundaria"];
			$fechas=$this->ModuloJornadas->ListarFechas($BD);
			$mes=$this->ModuloJornadas->ListarMesesAsignados($BD);
			$permisos=$this->ModuloPermisos->listarPermisosTotales();
			$usuarios= $this->ModuloJornadas->ListarUsuariosAsiganadosHorario($BD);
			$dia=date("d");
			$mes=date("m");
			$anio=date("Y");
			$numerosDias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); 
			for ($i=$dia; $i < $numerosDias+1; $i++) { 
				$arrayDias[]=$i;
			}
			// var_dump($arrayDias);exit();
			echo "<div class='modal-header'>
						<h6 class='modal-title'>Asignar Permisos</h6>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
					</div>";
					echo "<div class='modal-body'>
								<div class='card'>
									<div class='card-body'>
										<form id='mFrmAsignarPermisoU' method='POST'>
										<div class='form-group'>
										<div class='col-md-8' style='margin-top:10px;'>
										<label for='company'>Usuario</label>
											<div class='input-group'>
												<span class='input-group-addon'><i class='fa fa-user'></i></span>
												<select id='msltUser' class='form-control select2' data-plugin='select2' multiple  id='txt_asignacion[]' name='txt_asignacion[]' style='width: 100%;'>
												";
												
													foreach ($usuarios as $u) {
														echo "<option value='".$u['id_usuario']."'>".$u['Nombres']."</option>";
												}
											echo"</select>
											</div>
										<div id='errormsltUsuario' style='color: red; display: none;'  >
											   Debe seleccionar el Usuario...
										</div>
									    </div>
										<div class='col-md-8' style='margin-top:10px;'>
										<label for='company'>Permisos</label>
											<div class='input-group'>
												<span class='input-group-addon'><i class='mdi mdi-account-key'></i></span>
												<select id='msltPermiso' name='msltPermiso' class='form-control form-control-sm'>
                                                    <option value=''>Por favor Seleccione el Permiso</option>";
                                                    
                                                        foreach ($permisos as $p) {
                                                            echo "<option value='".$p['id_permiso']."'>".$p['NombrePermiso']."</option>";
                                                    }
                                                echo"</select>
											</div>
										<div id='errormsltPermiso' style='color: red; display: none;'  >
											   Debe seleccionar el Permiso...
										</div>
										</div>
										
										<div class='col-md-8' style='margin-top:10px; display:none' id='div_hora'>
										<label for='company'>Hora de Inicio</label>
											<div class='input-group clockpicker'>
												<span class='input-group-addon'>
                                                    <span class='mdi mdi-timer'></span>
                                                </span>
                                                <input name='hora_inicio' id='hora_inicio' type='text' class='form-control' value=''>
                                            </div>
										</div>

										<div class='col-md-8' style='margin-top:10px; display:none' id='div_hora_fin'>
										<label for='company'>Hora Fin</label>
											<div class='input-group clockpickerFin'>
												<span class='input-group-addon'>
	                                                <span class='mdi mdi-timer'></span>
	                                            </span>
	                                            <input name='hora_fin' id='hora_fin' type='text' class='form-control' value=''>        
	                                        </div>
										</div>

										
										
										<div class='col-md-8' style='margin-top:10px;'>
										<label for='company'>Día</label>
											<div class='input-group'>
												<span class='input-group-addon'><i class='mdi mdi-calendar'></i></span>
												<select id='msltfechaDesde' name='msltfechaDesde' class='form-control form-control-sm'>
                                                    <option value=''>Por favor Seleccione el Día</option>";
                                                    
                                                        foreach ($arrayDias as $a) {
                                                            echo "<option value='".$a."'>Día: ".$a."</option>";
                                                    }
                                                echo"</select>
											</div>
										<div id='errormsltDia' style='color: red; display: none;'  >
											   Debe seleccionar el Día...
										</div>
										</div>
										
										<div style='margin-top:10px; margin-left:45px;' class='checkbox abc-checkbox abc-checkbox-danger abc-checkbox-circle'>
											<div class='input-group'>
												<input  type='checkbox' name='rango' value='rango' id='rango' class='styled' ><label for='rango'>
												Insertar Rango de Días
											</label>
											</div>
										</div>
										</div>
										
										<div id='hasta' style='display: none;' class='col-md-8' style='margin-top:10px;'>
										<label for='company'>Día Hasta</label>
											<div class='input-group'>
												<span class='input-group-addon'><i class='mdi mdi-calendar'></i></span>
												<select id='msltfechaHasta2' name='msltfechaHasta2' class='form-control form-control-sm'>
                                                    <option value=''>Por favor Seleccione el Día hasta llegar</option>";      
                                                        foreach ($arrayDias as $b) {
                                                            echo "<option value='".$b."'>Día: ".$b."</option>";
                                                    }
                                                echo"</select>
											</div>
										<div id='errormsltDiaHasta' style='color: red; display: none;'  >
											   Debe seleccionar el Día...
										</div>
										</div>
	
										</form>
									</div>
								</div>
						</div>	

						<div id='botonAgregar' class='modal-footer'>
	            			<button type='button' class='btn btn-sm btn-danger' onclick='return validarAsignarPermiso();' ><i id='icAsignarPermiso'  class=''></i> Asignar Permiso</button>
						</div>
						
						<div id='botonAgregarRango' style='display: none;' class='modal-footer'>
	            			<button type='button' class='btn btn-sm btn-danger' onclick='return validarAsignarPermisoRango();' ><i id='icAsignarPermisoRango'  class=''></i> Asignar Permiso</button>
	            		</div>

						<script src='"; echo  site_url(); echo "assets/libs/select2/dist/js/select2.min.js'></script>
						<script src='"; echo  site_url(); echo "assets/libs/clockpicker/dist/bootstrap-clockpicker.min.js'></script>
						
						<script type='text/javascript'>
							$('.clockpicker').clockpicker({
							    placement: 'top',
							    align: 'left',
							    donetext: 'Hecho',
							    autoclose: true,
							    'default': 'now',
							});

							$('.clockpickerFin').clockpicker({
							    placement: 'top',
							    align: 'left',
							    donetext: 'Hecho',
							    autoclose: true,
							    'default': 'now',
							});

							$('#msltPermiso').change(function() {
								if($('#msltPermiso').val()==2 || $('#msltPermiso').val()==3 || $('#msltPermiso').val()==4 || $('#msltPermiso').val()==5 || $('#msltPermiso').val()==6 ){
							  		$('#div_hora').show('slow'); 
							  		$('#div_hora_fin').show('slow'); 
								}else{
									$('#div_hora').hide('slow');
									$('#div_hora_fin').hide('slow'); 
									$('#hora_inicio').val('');
									$('#hora_fin').val('');   
								}
							});

							$('#rango').click( function(){
								if($(this).is(':checked')){
									$('#hasta').show('slow');
									$('#botonAgregar').fadeOut(1);
									$('#botonAgregarRango').fadeIn(1);
								}
								else {
									$('#hasta').hide('slow');
									$('#botonAgregar').fadeIn(1);
									$('#botonAgregarRango').fadeOut(1);
								};
							});
													
							$('#msltUser').select2({});

							function validarAsignarPermiso(){
								if(validarAsignacion()==false){
									alertify.error('Existen Campos Vacios');
									return false;
									}else{
									$('#icAsignarPermiso').attr('class','fa fa-spin fa-circle-o-notch');
									$.ajax({                        
									   type: 'POST',                 
									   url:'AsignarPermisoF',                     
									   data: $('#mFrmAsignarPermisoU').serialize(), 
									   success: function(data)             
									    {            
											if(data.match('OP1')){
												var resp = data.replace('OP1', '');
												alertify.success('Se han asignado los permisos correctamente');
												setTimeout(function(){
													window.location = 'adminHorario';
												}, 1000);
											}
										 return data;
									    }         
								    });
								}
							};

							

							function validarAsignacion(){
								var vacios=0;
								var valido=true;
								if($('#msltPermiso').val()==2 || $('#msltPermiso').val()==3 || $('#msltPermiso').val()==4 || $('#msltPermiso').val()==5 || $('#msltPermiso').val()==6){
									if($('#hora_inicio').val()==''){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio y fin no pueden quedar vacías');
									vacios+=1;
									}
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#hora_inicio').val()!='' && $('#hora_inicio').val() > $('#hora_fin').val()){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio no puede ser mayor a la hora final');
									vacios+=1;
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#hora_inicio').val()!='' && $('#hora_inicio').val()==$('#hora_fin').val()){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio y fin no pueden ser iguales');
									vacios+=1;
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#msltUser').val()==''){  
									$('#msltUser').attr('class', 'form-control is-invalid');
									$('#errormsltUsuario').show(); 
									alertify.error('Existen Campos Vacios');
									vacios+=1;
								} else { 
									$('#msltUser').attr('class', 'form-control is-valid');  
									$('#errormsltUsuario').hide();   
									$('#msltUser').hide();  
								}
		
								if($('#msltPermiso').val()==''){  
									$('#msltPermiso').attr('class', 'form-control is-invalid');
									$('#errormsltPermiso').show();
									alertify.error('Existen Campos Vacios'); 
									vacios+=1;
								} else { 
									$('#msltPermiso').attr('class', 'form-control is-valid');  
									$('#errormsltPermiso').hide();      
								}

								if($('#msltfechaDesde').val()==''){  
									$('#msltfechaDesde').attr('class', 'form-control is-invalid');
									$('#errormsltDia').show(); 
									vacios+=1;
								} else { 
									$('#msltfechaDesde').attr('class', 'form-control is-valid');  
									$('#errormsltDia').hide();      
								}
		
								if(vacios>0){ valido=false; }
								return valido;
							  }

							  function validarAsignarPermisoRango(){
								if(validarAsignacionRango()==false){								
									return false;
									}else{
									$('#icAsignarPermisoRango').attr('class','fa fa-spin fa-circle-o-notch');
									$.ajax({                        
									   type: 'POST',                 
									   url:'AsignarPermisoRangoF',                     
									   data: $('#mFrmAsignarPermisoU').serialize(), 
									   success: function(data)             
									    {            
											if(data.match('OP1')){
												var resp = data.replace('OP1', '');
												alertify.success('Se han asignado los permisos correctamente');
												setTimeout(function(){
													window.location = 'adminHorario';
												}, 1000);
											}
										 return data;
									    }         
								    });
								}
							};

							function validarAsignacionRango(){
								var vacios=0;
								var valido=true;
								var fechaDesde = $('#msltfechaDesde').find(':selected').text();
								var fechaHasta = $('#msltfechaHasta2').find(':selected').text();
								if(fechaDesde > fechaHasta){
									alertify.error('La fecha de inicio no puede ser mayor que la fecha fin');
								}
								if($('#msltPermiso').val()==2 || $('#msltPermiso').val()==3 || $('#msltPermiso').val()==4 || $('#msltPermiso').val()==5 || $('#msltPermiso').val()==6){
									if($('#hora_inicio').val()==''){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio y fin no pueden quedar vacías');
									vacios+=1;
									}
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#hora_inicio').val()!='' && $('#hora_inicio').val() > $('#hora_fin').val()){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio no puede ser mayor a la hora final');
									vacios+=1;
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#hora_inicio').val()!='' && $('#hora_inicio').val()==$('#hora_fin').val()){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio y fin no pueden ser iguales');
									vacios+=1;
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#msltUser').val()==''){  
									$('#msltUser').attr('class', 'form-control is-invalid');
									$('#errormsltUsuario').show(); 
									vacios+=1;
								} else { 
									$('#msltUser').attr('class', 'form-control is-valid');  
									$('#errormsltUsuario').hide();   
									$('#msltUser').hide();  
								}
		
								if($('#msltPermiso').val()==''){  
									$('#msltPermiso').attr('class', 'form-control is-invalid');
									$('#errormsltPermiso').show(); 
									vacios+=1;
								} else { 
									$('#msltPermiso').attr('class', 'form-control is-valid');  
									$('#errormsltPermiso').hide();      
								}

								

								if($('#msltfechaDesde').val()==''){  
									$('#msltfechaDesde').attr('class', 'form-control is-invalid');
									$('#errormsltDia').show(); 
									vacios+=1;
								} else { 
									$('#msltfechaDesde').attr('class', 'form-control is-valid');  
									$('#errormsltDia').hide();      
								}

								if($('#msltfechaHasta2').val()==''){  
									$('#msltfechaHasta2').attr('class', 'form-control is-invalid');
									$('#errormsltDiaHasta').show(); 
									vacios+=1;
								} else { 
									$('#msltfechaHasta2').attr('class', 'form-control is-valid');  
									$('#errormsltDiaHasta').hide();      
								}
		
								if(vacios>0){ valido=false; }
								return valido;
							  }
						</script>"; 
		}

		

		function AsignarPermisoUsuarioGrupo(){
			$this->load->model("ModuloPermisos");
			$this->load->model("ModuloJornadas");
			$this->load->model("ModuloUsuario");
			$BD=$_SESSION["BDSecundaria"];
			$cliente=$_SESSION["Cliente"];
			$fechas=$this->ModuloJornadas->ListarFechas($BD);
			$permisos=$this->ModuloPermisos->listarPermisosTotales();
			$usuarios= $this->ModuloUsuario->listarGrupoUsuariosActivos($cliente);
			$dia=date("d");
			$mes=date("m");
			$anio=date("Y");
			$numerosDias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); 
			for ($i=$dia; $i < $numerosDias+1; $i++) { 
				$arrayDias[]=$i;
			}
			echo "<div class='modal-header'>
						<h6 class='modal-title'>Asignar Permisos a Grupo de Usuarios</h6>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
					</div>";

					echo "<div class='modal-body'>
								<div class='card'>
									<div class='card-body'>
										<form id='mFrmAsignarPermiso' method='POST' action='#'>
										<div class='form-group'>
										<div class='col-md-8' style='margin-top:10px;'>
										<label for='company'>Grupos Usuarios</label>
											<div class='input-group'>
												<span class='input-group-addon'><i class='fa fa-user'></i></span>
												<select id='msltUser' class='form-control'  id='txt_asignacion' name='txt_asignacion' style='width: 100%;'>
												<option value=''>Por favor Seleccione el Grupo</option>";
												
													foreach ($usuarios as $u) {
														echo "<option value='".$u['ID_GrupoUsuario']."'>".$u['NombreGrupoUsuario']."</option>";
												}
											echo"</select>
											</div>
										<div id='errormsltUsuario' style='color: red; display: none;'  >
											   Debe seleccionar el Usuario...
										</div>
									    </div>
										<div class='col-md-8' style='margin-top:10px;'>
										<label for='company'>Permisos</label>
											<div class='input-group'>
												<span class='input-group-addon'><i class='mdi mdi-account-key'></i></span>
												<select id='msltPermiso' name='msltPermiso' class='form-control form-control-sm'>
                                                    <option value=''>Por favor Seleccione el Permiso</option>";
                                                    
                                                        foreach ($permisos as $p) {
                                                            echo "<option value='".$p['id_permiso']."'>".$p['NombrePermiso']."</option>";
                                                    }
                                                echo"</select>
											</div>
										<div id='errormsltPermiso' style='color: red; display: none;'  >
											   Debe seleccionar el Permiso...
										</div>
										</div>
										</div>

										<div class='col-md-8' style='margin-top:10px; display:none' id='div_hora'>
										<label for='company'>Hora de Inicio</label>
											<div class='input-group clockpicker'>
												<span class='input-group-addon'>
                                                    <span class='mdi mdi-timer'></span>
                                                </span>
                                                <input name='hora_inicio' id='hora_inicio' type='text' class='form-control' value=''>
                                            </div>
										</div>

										<div class='col-md-8' style='margin-top:10px; display:none' id='div_hora_fin'>
										<label for='company'>Hora Fin</label>
											<div class='input-group clockpickerFin'>
												<span class='input-group-addon'>
	                                                <span class='mdi mdi-timer'></span>
	                                            </span>
	                                            <input name='hora_fin' id='hora_fin' type='text' class='form-control' value=''>        
	                                        </div>
										</div>

										<div class='col-md-8' style='margin-top:10px;'>
										<label for='company'>Día</label>
											<div class='input-group'>
												<span class='input-group-addon'><i class='mdi mdi-calendar'></i></span>
												<select id='msltfechaDesde' name='msltfechaDesde' class='form-control form-control-sm'>
                                                    <option value=''>Por favor Seleccione el Día</option>";
                                                    
                                                        foreach ($arrayDias as $a) {
                                                            echo "<option value='".$a."'>Día: ".$a."</option>";
                                                    }
                                                echo"</select>
											</div>
											<div id='errormsltPermiso' style='color: red; display: none;'  >
												   Debe seleccionar el Día...
											</div>
										</div>

										<div style='margin-top:10px; margin-left:45px;' class='checkbox abc-checkbox abc-checkbox-danger abc-checkbox-circle'>
											<div class='input-group'>
												<input  type='checkbox' name='rango' value='rango' id='rango' class='styled' ><label for='rango'>
												Insertar Rango de Días
											</label>
											</div>
										</div>

										<div id='hasta' style='display: none;' class='col-md-8' style='margin-top:10px;'>
										<label for='company'>Día Hasta</label>
											<div class='input-group'>
												<span class='input-group-addon'><i class='mdi mdi-calendar'></i></span>
												<select id='msltfechaHasta' name='msltfechaHasta' class='form-control form-control-sm'>
                                                    <option value=''>Por favor Seleccione el Día</option>";
                                                    
                                                        foreach ($arrayDias as $b) {
                                                            echo "<option value='".$b."'>Día: ".$b."</option>";
                                                    }
                                                echo"</select>
											</div>
										<div id='errormsltPermiso' style='color: red; display: none;'  >
											   Debe seleccionar el Día...
										</div>
										</div>
										</div>										
										</div>										
										</div>
										</div>
										</div>	
									</form>
								</div>
							</div>		
						</div>
						
						

						<div class='modal-footer'>
	            			<button type='button' id='botonAgregar' class='btn btn-sm btn-danger' onclick='return validarAsignarPermiso();' ><i id='icAsignarPermiso'  class=''></i> Asignar Permiso</button>
	            			<button style='display:none;' id='botonAgregarRango' type='button' class='btn btn-sm btn-danger' onclick='return validarAsignarPermisoRango();' ><i id='icAsignarPermiso'  class=''></i> Asignar Permiso</button>
						</div>
						
						<script src='"; echo  site_url(); echo "assets/libs/clockpicker/dist/bootstrap-clockpicker.min.js'></script>				
						<script type='text/javascript'>

							$('#rango').click( function(){
								if($(this).is(':checked')){
									$('#hasta').show('slow');
									$('#botonAgregar').fadeOut(1);
									$('#botonAgregarRango').fadeIn(1);
								}
								else {
									$('#hasta').hide('slow');
									$('#botonAgregar').fadeIn(1);
									$('#botonAgregarRango').fadeOut(1);
								};
							});

							$('.clockpicker').clockpicker({
							    placement: 'top',
							    align: 'left',
							    donetext: 'Hecho',
							    autoclose: true,
							    'default': 'now',
							});

							$('.clockpickerFin').clockpicker({
							    placement: 'top',
							    align: 'left',
							    donetext: 'Hecho',
							    autoclose: true,
							    'default': 'now',
							});

							$('#msltPermiso').change(function() {
								if($('#msltPermiso').val()==2 || $('#msltPermiso').val()==3 || $('#msltPermiso').val()==4 || $('#msltPermiso').val()==5 || $('#msltPermiso').val()==6 ){
							  		$('#div_hora').show('slow'); 
							  		$('#div_hora_fin').show('slow'); 
								}else{
									$('#div_hora').hide('slow');
									$('#div_hora_fin').hide('slow'); 
									$('#hora_inicio').val('');
									$('#hora_fin').val('');   
								}
							});

							$('#rango').click( function(){
								if($(this).is(':checked')){
									$('#hasta').fadeIn('slow');								
								}else{
									$('#hasta').fadeOut('slow');
									
								};
							});

							function validarAsignarPermiso(){
								if(validarAsignacion()==false){
									alertify.error('Existen Campos Vacios');
									return false;
									}else{
									$('#icAsignarPermiso').attr('class','fa fa-spin fa-circle-o-notch');
									$.ajax({                        
									   type: 'POST',                 
									   url:'AsignarPermisoGrupoF',                     
									   data: $('#mFrmAsignarPermiso').serialize(), 
									   success: function(data)             
									    {            
											if(data.match('OP1')){
												var resp = data.replace('OP1', '');
												alertify.success('Se han asignado los usuarios correctamente');
												
											}
										 return data;
									    }         
								    });
								}
							};

							function validarAsignacion(){
								var vacios=0;
								var valido=true;
								if($('#msltPermiso').val()==2 || $('#msltPermiso').val()==3 || $('#msltPermiso').val()==4 || $('#msltPermiso').val()==5 || $('#msltPermiso').val()==6){
									if($('#hora_inicio').val()==''){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio y fin no pueden quedar vacías');
									vacios+=1;
									}
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#hora_inicio').val()!='' && $('#hora_inicio').val() > $('#hora_fin').val()){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio no puede ser mayor a la hora final');
									vacios+=1;
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#hora_inicio').val()!='' && $('#hora_inicio').val()==$('#hora_fin').val()){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio y fin no pueden ser iguales');
									vacios+=1;
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#msltUser').val()==''){  
									$('#msltUser').attr('class', 'form-control is-invalid');
									$('#errormsltUsuario').show(); 
									vacios+=1;
								} else { 
									$('#msltUser').attr('class', 'form-control is-valid');  
									$('#errormsltUsuario').hide();    
								}
		
								if($('#msltPermiso').val()==''){  
									$('#msltPermiso').attr('class', 'form-control is-invalid');
									$('#errormsltPermiso').show(); 
									vacios+=1;
								} else { 
									$('#msltPermiso').attr('class', 'form-control is-valid');  
									$('#errormsltPermiso').hide();      
								}
		
								if(vacios>0){ valido=false; }
								return valido;
							}

							function validarAsignarPermisoRango(){
								if(validarAsignacionRango()==false){
									alertify.error('Existen Campos Vacios');
									return false;
									}else{
									$('#icAsignarPermiso').attr('class','fa fa-spin fa-circle-o-notch');
									$.ajax({                        
									   type: 'POST',                 
									   url:'AsignarPermisoGrupoRangoF',                     
									   data: $('#mFrmAsignarPermiso').serialize(), 
									   success: function(data)             
									    {            		
											alertify.success('Se han asignado los permisos correctamente');
											setTimeout(function(){
												window.location = 'adminHorario';
											}, 1000);
										 return data;
									    }         
								    });
								}
							}

							function validarAsignacionRango(){
								var vacios=0;
								var valido=true;
								if($('#msltPermiso').val()==2 || $('#msltPermiso').val()==3 || $('#msltPermiso').val()==4 || $('#msltPermiso').val()==5 || $('#msltPermiso').val()==6){
									if($('#hora_inicio').val()==''){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio y fin no pueden quedar vacías');
									vacios+=1;
									}
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#hora_inicio').val()!='' && $('#hora_inicio').val() > $('#hora_fin').val()){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio no puede ser mayor a la hora final');
									vacios+=1;
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#hora_inicio').val()!='' && $('#hora_inicio').val()==$('#hora_fin').val()){
									$('#hora_inicio').attr('class', 'form-control is-invalid');
									$('#hora_fin').attr('class', 'form-control is-invalid');
									alertify.error('La hora de inicio y fin no pueden ser iguales');
									vacios+=1;
								}else{
									$('#hora_inicio').attr('class', 'form-control is-valid');
									$('#hora_fin').attr('class', 'form-control is-valid');
								}
								if($('#msltUser').val()==''){  
									$('#msltUser').attr('class', 'form-control is-invalid');
									$('#errormsltUsuario').show(); 
									vacios+=1;
								} else { 
									$('#msltUser').attr('class', 'form-control is-valid');  
									$('#errormsltUsuario').hide();    
								}
		
								if($('#msltPermiso').val()==''){  
									$('#msltPermiso').attr('class', 'form-control is-invalid');
									$('#errormsltPermiso').show(); 
									vacios+=1;
								} else { 
									$('#msltPermiso').attr('class', 'form-control is-valid');  
									$('#errormsltPermiso').hide();      
								}
		
								if(vacios>0){ valido=false; }
								return valido;
							}

						</script>";

		}

		// setTimeout(function(){
		// 											window.location = 'adminHorario';
		// 										}, 1000);

		function AsignarPermisoGrupoF(){	
			if(isset($_SESSION["sesion"])){
				if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
					$BD=$_SESSION["BDSecundaria"];
					$fechaDesde=$_POST["msltfechaDesde"];
					$idGrupo=$_POST["txt_asignacion"];
					$idPermiso=$_POST["msltPermiso"];
					$mes=date("m");
					$this->load->model("ModuloJornadas");
					$this->load->model("ModuloTarea");
					if ($_POST["hora_inicio"]=="") {		
						$this->ModuloJornadas->AsignarPermisoGrupo($idGrupo,$idPermiso,$fechaDesde,$BD);
						echo "OP1";
					}else{
						$hora_inicio=$_POST["hora_inicio"];
						$hora_fin=$_POST["hora_fin"];
						$usuarios=$this->ModuloTarea->buscarUsuariosporGrupoUsuarios($idGrupo,$BD);
						foreach ($usuarios as $u) {
							$this->ModuloJornadas->AsignarPermisoGrupoUser($u["FK_Usuarios_ID_Usuario"],$idPermiso,$hora_inicio,$hora_fin,$mes,$fechaDesde,$BD);
						}
					}
				}
			}
		}

		function AsignarPermisoGrupoRangoF(){
			if (isset($_SESSION["sesion"])) {
				if ($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2) {
					$this->load->model("ModuloJornadas");
					$this->load->model("ModuloTarea");
					$BD=$_SESSION["BDSecundaria"];
					$idGrupo=$_POST["txt_asignacion"];
					$idPermiso=$_POST["msltPermiso"];
					$fechaDesde=$_POST["msltfechaDesde"];
					$fechaHasta=$_POST["msltfechaHasta"];
					$usuarios=$this->ModuloTarea->buscarUsuariosporGrupoUsuarios($idGrupo,$BD);
					//si la hora viene vacia asigna permiso sin hora, caso contrario agrega la hora
					if ($_POST["hora_inicio"]=="") {	
						foreach ($usuarios as $u) {
							$this->ModuloJornadas->AsignarPermisoGrupoRango($u["FK_Usuarios_ID_Usuario"],$idPermiso,$fechaDesde,$fechaHasta,$BD);
						}
					}else{
						$hora_inicio=$_POST["hora_inicio"];
						$hora_fin=$_POST["hora_fin"];
						foreach ($usuarios as $u) {
							$this->ModuloJornadas->AsignarPermisoGrupoRangoHora($u["FK_Usuarios_ID_Usuario"],$idPermiso,$fechaDesde,$fechaHasta,$hora_inicio,$hora_fin,$BD);
						}
					}
				}
			}
		}

	// 	function EditarEstadoJornada(){
	// 	if(isset($_SESSION["sesion"])){
	// 		if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
	// 			if(isset($_POST["idjor"])){
	// 				$idjor=$_POST["idjor"];
	// 				$vigencia=$_POST["estado"];
	// 				echo "<form method='post' id='cambiarEstado' action='cambiarEstadoJornadaFinal'>";
	// 				if($vigencia==1){
	// 					echo "<p>¿Esta Seguro que desea Desactivar este Horario?</p>";						
	// 				}else{
	// 					echo "<p>¿Esta Seguro que desea Activar este Horario?</p>";
	// 				}
	// 				echo "<input type='hidden' name='txt_idjor' value='".$idjor."'>";
	// 				echo "<input type='hidden' name='txt_estado' value='".$vigencia."'>";
	// 				echo "</form>";
	// 			}else{
	// 				redirect(site_url("Adm_ModuloJornadas/adminHorarios"));
	// 			}
	// 		}else{
	// 			redirect(site_url("login/inicio"));	
	// 		}
	// 	}else{
	// 	   redirect(site_url("login/inicio"));
	// 	}
	// }

		function AsignarPermisoRangoF(){
			if(isset($_SESSION["sesion"])){
				if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
					$BD=$_SESSION["BDSecundaria"]; 
					$this->load->model("ModuloJornadas");
					if (isset($_POST["hora_inicio"])) {
						$hora_inicio=$_POST["hora_inicio"];
						$hora_fin=$_POST["hora_fin"];
						$fechaDesde=$_POST["msltfechaDesde"];
						$fechaHasta=$_POST["msltfechaHasta2"];
						$idAsigUser=$_POST["txt_asignacion"];
						$idPermiso=$_POST["msltPermiso"];
						$mes=date("m");
						foreach($idAsigUser as $idUser){
							$this->ModuloJornadas->AsignarPermisoRango($idUser,$idPermiso,$fechaDesde,$fechaHasta,$mes,$hora_inicio,$hora_fin,$BD);
							echo "OP1";
						}
					}else{
						$fechaDesde=$_POST["msltfechaDesde"];
						$fechaHasta=$_POST["msltfechaHasta2"];
						$idAsigUser=$_POST["txt_asignacion"];
						$idPermiso=$_POST["msltPermiso"];
						$mes=date("m");
						foreach($idAsigUser as $idUser){
							$this->ModuloJornadas->AsignarPermisoRango($idUser,$idPermiso,$fechaDesde,$fechaHasta,$mes,null,null,$BD);
							echo "OP1";
						}
					}
				}
			}
		}

		function AsignarPermisoF(){
			// var_dump($_POST);exit();
			if(isset($_SESSION["sesion"])){
				if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
					$BD=$_SESSION["BDSecundaria"];  
					$this->load->model("ModuloJornadas");
					if (isset($_POST["hora_inicio"])) {					
						$fechaDesde=$_POST["msltfechaDesde"];
						$idAsigUser=$_POST["txt_asignacion"];
						$idPermiso=$_POST["msltPermiso"];
						$mes=date("m");
						$hora_inicio=$_POST["hora_inicio"];
						$hora_fin=$_POST["hora_fin"];
						$fechaHasta=$fechaDesde;
						foreach($idAsigUser as $idUser){
							$this->ModuloJornadas->AsignarPermisoRango($idUser,$idPermiso,$fechaDesde,$fechaHasta,$mes,$hora_inicio,$hora_fin,$BD);
							echo "OP1";
						}
					}else{
						$fechaDesde=$_POST["msltfechaDesde"];
						$idAsigUser=$_POST["txt_asignacion"];
						$idPermiso=$_POST["msltPermiso"];
						$mes=date("m");
						$fechaHasta=$fechaDesde;
						foreach($idAsigUser as $idUser){
							$this->ModuloJornadas->AsignarPermisoRango($idUser,$idPermiso,$fechaDesde,$fechaHasta,$mes,null,null,$BD);
							echo "OP1";
						}
					}
				}
			}
		}

	function generarExcel(){
    	$BD=$_SESSION["BDSecundaria"];
    	$this->load->library('phpexcel');
		$this->load->model("ModuloPuntosVentas");	
		$this->load->model("ModuloTarea");	
		$this->load->model("ModuloPermisos");
		$objReader =  PHPExcel_IOFactory::createReader('Excel2007');		
		$object = $objReader->load("doc/plantilla/PlantillaJornadasEjemplo.xlsx");
		$objectUser = $objReader->load("doc/plantilla/PlantillaJornadasEjemplo.xlsx");
		$object->setActiveSheetIndex(1); 
		$dataLocal = $this->ModuloPuntosVentas->listarLocales($BD);
		$dataUser = $this->ModuloTarea->listarUsuarios($BD);
		$dataPermiso=$this->ModuloPermisos->listarPermisos();
		$column_row=2;
	 	foreach($dataLocal as $row)
	 	{	 
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['NombreLocal']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $row['Direccion']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $row['Latitud']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(3 , $column_row, $row['Longitud']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(4 , $column_row, $row['Rango']);
	 		$column_row++;	 		
	 	}
	 	$column_row=2;
	 	$object->setActiveSheetIndex(2); 
	 	foreach ($dataUser as $rowU) {
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $rowU['Rut']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $rowU['Nombres']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $rowU['Email']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(3 , $column_row, $rowU['Cargo']);
	 		$column_row++;
	 	}
	 	$column_row=2;
	 	$object->setActiveSheetIndex(3); 
	 	foreach ($dataPermiso as $rowU) {
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $rowU['Codigo']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $rowU['NombrePermiso']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $rowU['Tipo']);
	 		$column_row++;
	 	}
	 	$object->setActiveSheetIndex(0);
	 	header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="AsignacionJornadas.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
    }


    function adminHistoricoHorarios(){	
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
		   		$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$BD=$_SESSION["BDSecundaria"];
				$this->load->model("ModuloPuntosVentas");
				$this->load->model("ModuloReportes");
				$this->load->model("ModuloJornadas");
				$this->load->model("ModuloUsuario");
				$hoy = date("d-m-y");
				$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
				$data["Fechas"]= $this->ModuloReportes->FechasLibroAsistenciaMes($BD,00);
				$data["horarios"]= $this->ModuloJornadas->ListarHorariohistorico($BD,$hoy);
				$data["cantidadHorario"]=count($data['horarios']);
				$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
				$data["AnioHorario"]= $this->ModuloJornadas->ListarAnio($BD);
				$data["ListarUsuario"]= $this->ModuloJornadas->ListarUsuario($BD);
				$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
			    $this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			    $this->load->view('layout/sidebar',$data);
			    $this->load->view('admin/adminHorarioHistorico',$data);
			    $this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}


	 function FiltroMesAnioHistoricoJornadas(){	
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				$this->load->model("ModuloPuntosVentas");
				$this->load->model("ModuloJornadas");
				$BD=$_SESSION["BDSecundaria"];
				$MEsAnio=$_POST["MEsAnio"];
				$MA='01/'.$MEsAnio;
				$fechas =  explode("/", $MA);
				
				$horarios= $this->ModuloJornadas->ListarHorariohistorico($BD,$MA);
				echo '<div id="loader" style="display: none;"></div>  
				<table id="TablaF" class="table color-bordered-table danger-bordered-table"  width="100%" style="font-size: 12px;">
                    	<thead>
                        	<tr>
	                            <th>Nombre</th>
	                            <th>Nombre Local</th>
	                            <th style="text-align: center;"> Día 1</th>
	                            <th style="text-align: center;"> Día 2</th>
	                            <th style="text-align: center;"> Día 3</th>
	                            <th style="text-align: center;"> Día 4</th>
	                            <th style="text-align: center;"> Día 5</th>
	                            <th style="text-align: center;"> Día 6</th>
	                            <th style="text-align: center;"> Día 7</th>
	                            <th style="text-align: center;"> Día 8</th>
	                            <th style="text-align: center;"> Día 9</th>
	                            <th style="text-align: center;"> Día 10</th>
	                            <th style="text-align: center;"> Día 11</th>
	                            <th style="text-align: center;"> Día 12</th>
	                            <th style="text-align: center;"> Día 13</th>
	                            <th style="text-align: center;"> Día 14</th>
	                            <th style="text-align: center;"> Día 15</th>
	                            <th style="text-align: center;"> Día 16</th>
	                            <th style="text-align: center;"> Día 17</th>
	                            <th style="text-align: center;"> Día 18</th>
	                            <th style="text-align: center;"> Día 19</th>
	                            <th style="text-align: center;"> Día 20</th>
	                            <th style="text-align: center;"> Día 21</th>
	                            <th style="text-align: center;"> Día 22</th>
	                            <th style="text-align: center;"> Día 23</th>                              
	                            <th style="text-align: center;"> Día 24</th>
	                            <th style="text-align: center;"> Día 25</th>
	                            <th style="text-align: center;"> Día 26</th>
	                            <th style="text-align: center;"> Día 27</th>
	                            <th style="text-align: center;"> Día 28</th>
	                            <th style="text-align: center;"> Día 29</th>
	                            <th style="text-align: center;"> Día 30</th>';
	                          if (cal_days_in_month(CAL_GREGORIAN,  $fechas[1], $fechas[2])>=31) {
	                            echo'  
	                            <th style="text-align: center;"> Día 31</th>
	                             ';}
	                        echo'</tr>
                    </thead>
                    <tbody>';
                        $b=':' ;// variable den dias Libres
                        $ndias=cal_days_in_month(CAL_GREGORIAN,  $fechas[1], $fechas[2]);    
                        foreach ($horarios as $c) {                            
                		echo"<tr>                                                                        
                                <td>".$c['Nombres']."<br><small>".$c['Rut']."</small></td>                            
                                <td style='width: 1000px;'>".$c['NombreLocal']."</td>"; 
                                    for ($i=1; $i <= $ndias ; $i++) {
                                echo"<td>"; 
                                        if ((strpos($c['Entrada'.$i],$b)===false)) { 
                                            echo " ";
                                        }else{
                                            $he = date_create($c['Entrada'.$i]); 
                                            echo"<i class='mdi mdi-clock-in'></i>".date_format($he, 'G:i');   
                                        }
                                        if ((strpos($c['Salida'.$i],$b)===false)) {                                    
                                    echo $c['PermisoSalida'.$i];
                                        }else{
                                            $hs = date_create($c['Salida'.$i]);  
                                     echo"<br<i class='mdi mdi-clock-out'></i>".date_format($hs, 'G:i');
                                        }
                                echo"</td>";
                                    } 
                      echo "</tr>";}  
                        echo" </tbody>
                    </table>";

                    echo'<script type="text/javascript">
                    		$(document).ready(function() {
    						var table = $("#TablaF").removeAttr("width").DataTable( {
						        scrollY:        "450px",
						        scrollX:        true,
						        searching: true,
						        scrollCollapse: true,
						        fixedColumns:   {
						            leftColumns: 1,
						        },
						            "language": {
						        "sProcessing":    "Procesando...",
						        "sLengthMenu":    "Mostrar _MENU_ registros",
						        "sZeroRecords":   "No se encontraron resultados",
						        "sEmptyTable":    "Ningún dato disponible en esta tabla",
						        "sInfo":          "",
						        "sInfoEmpty":     "",
						        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
						        "sInfoPostFix":   "",
						        "sSearch":        "Buscar:",
						        "sUrl":           "",
						        "sInfoThousands":  ",",
						        "sLoadingRecords": "Cargando...",
						        "oPaginate": {
						            "sFirst":    "Primero",
						            "sLast":    "Último",
						            "sNext":    "Siguiente",
						            "sPrevious": "Anterior"
						        },
						        "oAria": {
						            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
						            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
						        }
					    	}
    						} );
						} );
                    </script>';
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	function generarExcelHistoricoJornadas(){
    	$this->load->model("ModuloPuntosVentas");
		$this->load->model("ModuloJornadas");
		$this->load->library('phpexcel');
		$BD=$_SESSION["BDSecundaria"];
		$MA=$_POST["MA"];
		$horarios= $this->ModuloJornadas->ListarHorariohistoricoCode($BD,$MA);
		$objReader =  PHPExcel_IOFactory::createReader('Excel2007');		
		$object = $objReader->load("doc/plantilla/PlantillaHistoricaJornadas.xlsx");
		$object->setActiveSheetIndex(0); 
		$column_row=3;
		// $fecha = date(strtotime($MA));
		$fechas =  explode("/", $MA);
		// var_dump($fechas[2],$MA);exit();
		$ndias=cal_days_in_month(CAL_GREGORIAN, $fechas[1], $fechas[2] ); 
		$b=':' ;  
		$object->getActiveSheet()->setCellValueByColumnAndRow(1,1, $MA);
		foreach($horarios as $row)
	 	{	 
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['Rut']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $row['NombreLocal']);
	 		// var_dump('entro a la antes de for ',$MA,$ndias);exit();
	 		for ($i=2; $i <= $ndias ; $i++) {
	 			//entrada
                if ((strpos($row['Entrada'.$i],$b)===false)) {
                	$object->getActiveSheet()->setCellValueByColumnAndRow($i , $column_row, $row['Entrada'.$i]);
                	// var_dump('entro a la permisos ',$row['Entrada'.$i]);exit();
                }else{
                    // $he = date_create($row['Entrada'.$i]); 
                    $object->getActiveSheet()->setCellValueByColumnAndRow($i , $column_row, $row['Entrada'.$i]);
                    // var_dump('entro a la hora entrada ');exit();   
                }
                //salida
                if ((strpos($row['Salida'.$i],$b)===false)) {                                    
                	
                    $object->getActiveSheet()->setCellValueByColumnAndRow($i , $column_row, $row['PermisoSalida'.$i]);
                }else{
                	// $hs = date_create($c['Salida'.$i]);
                    $object->getActiveSheet()->setCellValueByColumnAndRow($i , $column_row, $row['Salida'.$i]);
                }
                              
            }
	 		
	 		$column_row++;	 		
	 	}
	 	header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="HistoricoJornadas'.$MA.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
    }


    function adminHorario(){	
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				$hoy = getdate();
				$mes = getdate();
				$thismonth = $mes['mon'];
				$this->load->model("ModuloJornadas");
				$this->load->model("ModuloUsuario"); 
				$BD=$_SESSION["BDSecundaria"];
				if(isset($_GET['opcion'])){
					if(is_numeric($_GET['opcion'])){
						$buscasan = $_GET['opcion'];
					}else{
						$buscasan=1;
					}
				}else{
					$buscasan=1;
				}
				$data["horarios"]= $this->ModuloJornadas->ListarHorarioPaginador($BD,$buscasan-1,0,0,0);
				$data['opcion']=$buscasan;			
				$tempoCantidad = $data["horarios"][0]["total"];
				$data['cantidad'] = ceil(($tempoCantidad)/20);
		   		$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data['mesActual']=$hoy['mon'];	
				$data['mes']=$mes['mon'];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$BD=$_SESSION["BDSecundaria"];
				$this->load->model("ModuloPermisos");				
				$this->load->model("ModuloPuntosVentas");
				//Asignar Permisos
				$data["AsignadoBoton"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],11,$_SESSION["Cliente"]);
				// //Editar Jornadas
				$data["AsignadoEditar"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],12,$_SESSION["Cliente"]);
				// //Crear Notificaciones
				$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
				$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
				$data["permisos"]=$this->ModuloPermisos->listarPermisos();
				// $data["cantidadHorario"]=count($data['horarios']);
				$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
				$data["AnioHorario"]= $this->ModuloJornadas->ListarAnio($BD);
				$data["ListarUsuario"]= $this->ModuloJornadas->ListarUsuario($BD);
				$data["ListarFechaFuturo"]=$this->ModuloJornadas->buscarFechaFuturo($BD);
				//vistas
			    $this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			    $this->load->view('layout/sidebar',$data);
			    $this->load->view('admin/adminHorarios',$data);
			    $this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

	public function mapaLocal(){
		// $iduser=$_SESSION["id_usuario"];
		$local=$_POST["ID_Local"];
		$BD=$_SESSION["BDSecundaria"];
		$this->load->model("ModuloPuntosVentas");
		$l= $this->ModuloPuntosVentas->buscarLocalID($local,$BD);
		$la=$l['Latitud'];
		$lo=$l['Longitud'];
		$ra=$l['Rango'];
		
		echo"

		<div class='chart tab-pane active' id='revenue-chart' style='position: relative; height: 300px;'><div style='width: 100%; height: 100%;' id='map'></div></div>
        <script type='text/javascript'>      
      		var map, infoWindow;

      // First, create an object containing LatLng and population for each city.
      //fijamos algunos puntos en el mapa con un circulo
      var citymap = {
          losangeles: {
          center: {lat: ".$la.", lng: ".$lo."},
          population: 1
        }
      };
      
      //dibujar la posicion donde nos encontramos en el mapa
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: ".$la.", lng: ".$lo."},
          zoom: 15,
          mapTypeControl: false,
          disableDefaultUI: false, // le dejamos solo el mapa por default
          styles: [
            {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{color: '#263c3f'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'labels.text.fill',
              stylers: [{color: '#6b9a76'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{color: '#38414e'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{color: '#212a37'}]
            },
            {
              featureType: 'road',
              elementType: 'labels.text.fill',
              stylers: [{color: '#9ca5b3'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{color: '#746855'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{color: '#1f2835'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'labels.text.fill',
              stylers: [{color: '#f3d19c'}]
            },
            {
              featureType: 'transit',
              elementType: 'geometry',
              stylers: [{color: '#2f3948'}]
            },
            {
              featureType: 'transit.station',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#17263c'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#515c6d'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#17263c'}]
            }
          ]
        });

        var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
        var icons = {
          parking: {
            name: 'Parking',
            icon: iconBase + 'parking_lot_maps.png'
          },
          library: {
            name: 'Library',
            icon: iconBase + 'library_maps.png'
          },
          info: {
            name: 'Info',
            icon: iconBase + 'info-i_maps.png'
          }
        };

        var features = [
          {
            position: new google.maps.LatLng(".$la.",".$lo."),
            type: 'info',
            title: 'Punto de Venta'
          }
          ];

        features.forEach(function(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.type].icon,
            map: map
          });
        });
        
         for (var city in citymap) {
          // Add the circle for this city to the map.
          var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: citymap[city].center,
            radius: Math.sqrt(citymap[city].population) * ".$ra."
          });
        }

        infoWindow = new google.maps.InfoWindow;

      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: El servicio de Geolocalización no esta disponible.' :
                              'Error: Puede que no este Activado el GPS o no ha comportido su Localización');
        infoWindow.open(map);
      }    
    	</script>
    	<script  type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=AIzaSyA5BfUJGjqlE8QrDNE4Gd-hA_99HYl9wnQ&callback=initMap' async defer></script>

    	";

	}

	function ingresarJornadaNueva(){
		$BD=$_SESSION["BDSecundaria"];
		echo "<div class='modal-header'>
                    <h6 class='modal-title' >Ingresar Jornadas</h6>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                </div>
                <div class='modal-body'>
                	<p class='text-theme'>Descargar Excel para ingresar nuevas jornadas</p>
                	<p><form method='POST' action='generarExcel'><button type='submit' class='btn btn-theme' title='Descargar Plantilla' onclick='Cargando();'><i class='mdi mdi-file-excel'></i> Descargar Plantilla</button>
			            </form></p>
                        <hr>
                    <p class='text-theme'>Ingresar Jornadas</p>
                    <p>
                        <label for='street'>Ingrese el archivo excel con las nuevas jornadas.</label>
                        <form action='IngresarExcelJornadasNuevas' method='POST' id='IngresarExcelJornadasNuevas' name='IngresarExcelJornadasNuevas' enctype='multipart/form-data'>
               			<div class='btn btn-theme' style='margin-bottom:20px;'><i class='mdi mdi-alarm-plus'></i><i id='ingresarExcelSpin' class=''></i> 
	                		<input type='file' class='btn btn-xs btn-dark' id='excelv' name='excelv'>   
	                	</div>
	                	<div id='progress' style='display: none;'>
	                		<p>Descargando horario, por favor, espere ...  <i class='fa fa-spin fa-spinner'></i></p> 
	                	</div>
	                	<div id='exito' style='display: none;'>
	                		<p>Plantilla descargado exitosamente!</p>
	                	</div>
	                	<div id='progressAct' style='display: none;'>
	                		<p>Ingresando jornadas, esto puede tomar varios minutos dependiendo de la cantidad de datos, por favor, espere ...  <i class='fa fa-spin fa-spinner'></i></p> 
	                	</div>
	                	<div class='modal-footer'>
		                    <button type='submit' class='btn btn-danger' onclick='CargandoAct();'>Ingresar Jornadas</button>
		                    <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
		                </div>                     		
        		</form>
        		<script type='text/javascript'>
        			function Cargando(){
        				$('#progress').show('slow');
        				$.ajax({
				            url: 'generarExcelEditarHorario',
				            type: 'POST',
				            success: function(data) {
				              $('#progress').hide('slow');
				              alertify.success('Plantilla Descargada con Éxito'); 
				            }
				        });
        			}

        			function CargandoAct(){
        				$('#progressAct').show('slow');
        				$.ajax({
				            url: 'generarExcelEditarHorario',
				            type: 'POST',
				            success: function(data) {
				              $('#progressAct').hide('slow'); 
				            }
				        });
        			}
        		</script>
        		";
	}

	function actualizarHorario(){
		$this->load->model("ModuloUsuario");
		$BD=$_SESSION["BDSecundaria"];
		$usuarios=$this->ModuloUsuario->listarUsuarioHorarioFechaActual($BD);
		$dia=date("d")+1;
		// $dia=25;
		$mes=date("m");
		$anio=date("Y");
		$numerosDias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); 
		$valFecha=$numerosDias-$dia; 
		for ($i=$dia+1; $i < $numerosDias+1; $i++) { 
			$arrayDias[]=$i;
		}
		echo "<div class='modal-header'>
                    <h6 class='modal-title' >Editar Horario</h6>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                </div>
                <form method='POST' id='FormDescargaExcel' action='generarExcelEditarHorarioFiltrado' enctype='multipart/form-data'> 
	                <div class='modal-body'>
	                	<div class='col-md-8' style='margin-top:10px;'>
							<label for='company'>Usuarios</label>
							<div class='input-group'>
								<span class='input-group-addon'><i class='fa fa-user'></i></span>
								<select id='msltUser' class='form-control select2' data-plugin='select2' multiple  id='txt_usuario[]' name='txt_usuario[]' style='width: 100%;'>";
									foreach ($usuarios as $u) {
										echo "<option value='".$u['ID_Usuario']."'>".$u['Nombres']."</option>";
								}
							echo "</select>
							</div>
						</div>
						<div class='col-md-6' id='rangoFechaInput' padding-right:50px;'>
	                        <div class='card-body'>
	                            <label for='company'>Rango de Días</label>
	                            <input class='range-example-input-1' type='text' min='".$dia."' max='".$numerosDias."' name='points' id='points' step='1'/>
	                        </div> 
	                        <div id='errorPoints' style='color: red; display: none;'  >
							   Debe declarar un rango de días...
							</div>          
	                    </div>
	                    <div class='col-md-12'>
	                    	<p class='text-theme'>Descargar Excel para editar</p>
	                    	<button id='btnSubmit' type='submit' class='btn btn-theme' title='Descargar Plantilla' onclick='CargandoDatos();'><i class='mdi mdi-file-excel'></i> Descargar Horario</button>
	                    </div>
	                    <div id='progress' style='display: none;'>
	                		<p>Descargando horario, por favor, espere ...  <i class='fa fa-spin fa-spinner'></i></p> 
	                	</div>
	                </div>
	                <hr>
                </form>
                <form method='POST' id='FormEditarExcel' action='ActualizarHorarioActual' enctype='multipart/form-data'> 
	                <div class='modal-body'>
	                	<div class='col-md-8'>
	                		<p class='text-theme'>Ingresar Plantilla Editada</p>
		                	<div class='btn btn-theme'><i class='mdi mdi-alarm-plus'></i><i id='ingresarExcelSpin' class=''></i> 
		            			<input type='file' class='btn btn-xs btn-dark' id='excelv' name='excelv'>   
		            		</div>
		            		<div id='progressBar' style='display: none;'>
		            			<p>Actualizando horario, el tiempo puede depender de la cantidad de jornadas, por favor, espere ...  <i class='fa fa-spin fa-spinner'></i></p> 
		                	</div>
		                	<div class='modal-footer'>
			                    <button type='submit' class='btn btn-danger' onclick='SubiendoAct();'>Ingresar Jornadas</button>
			                    <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
			                </div> 
		            	</div>
		            </div>
	            </form>
                <link rel='stylesheet' href='"; echo  site_url(); echo "assets/libs/sliderrange/dist/css/asRange.css'>
                <script src='"; echo  site_url(); echo "assets/libs/sliderrange/dist/jquery-asRange.min.js'></script>
                <script type='text/javascript'>

                	$('#msltUser').select2({});

                	$('.range-example-input-1').asRange({
				        range: true,
				        limit: false,
				    });

				    function CargandoDatos(){
				    	if($('#msltUser').val()==''){
				    		$('form').submit(function(e){
						        e.preventDefault();
						    });
				    		alertify.error('Debe elegir a lo menos un usuario');
				    	}else{
				    		$('#progress').show('slow');
	        				$.ajax({
					            url: 'generarExcelEditarHorarioFiltrado',
					            method: 'POST',
					            success: function(data) {
					              $('#progress').hide('slow');
					              alertify.success('Horario Descargado con Éxito'); 
					            }
					        });
				    	}			    		
			    	}

			    	function SubiendoAct(){
			    		$('#progressBar').show('slow');
			    		$.ajax({
				            url: 'ActualizarHorarioActual',
				            method: 'POST',
				            complete: function(data) {
				              $('#progressBar').hide('slow');
				              $('#actualizarHorarios').modal('hide');
				            }
				        });
			    	}
                </script>";
	}

	function generarExcelEditarHorarioFiltrado(){
		if(isset($_POST["txt_usuario"])){
			$cont=0;
			if ($_POST["points"]=="") {
			$diaInicio=date("d")+1;
			$diaFin=date("d")+1;
			$dias=1;
			}else{
				$points=explode(",", $_POST["points"]);
				$diaInicio=intval(min($points));
				$diaFin=intval(max($points));
				$dias=($diaFin-$diaInicio);
			}
			$this->load->model("ModuloJornadas");
			$this->load->library('phpexcel');
			set_time_limit(9600);
			$BD=$_SESSION["BDSecundaria"];
			$key=md5(microtime().rand());
			$this->ModuloJornadas->guardarKeyActHorario($key,$BD);
			$objReader=PHPExcel_IOFactory::createReader('Excel2007');
			$object=$objReader->load("doc/plantilla/EditarHorario.xlsx");
			$object->setActiveSheetIndex(0);
			$usuarios=array_values($_POST["txt_usuario"]);
			for ($i=0; $i < sizeof($_POST["txt_usuario"]); $i++) { 
				$horario[$i]=$this->ModuloJornadas->ListarHorarioEditarFiltrado($usuarios[$cont],$diaInicio,$diaFin,$BD);
				$cont++;
			}
			$fecha=date('d/m/Y', strtotime("01/".$horario[0][0]["Mes"]."/".$horario[0][0]["Anio"]));
			$numerosDias=cal_days_in_month(CAL_GREGORIAN, $horario[0][0]["Mes"], $horario[0][0]["Anio"]); 
			$column_row=3;
			$column_row_entrada=3;
			$column_row_salida=3;
			$contadorEntrada=2;
			$contadorSalida=3;
			$cuentaDiaEntrada=$diaInicio;
			$cuentaDiaSalida=$diaInicio;
			$contaFilas=0;
			$object->getActiveSheet()->setCellValueByColumnAndRow(64, 1, $key);
			for ($i=0; $i < sizeof($horario); $i++) { 
				for ($j=0; $j < sizeof($horario[$i]); $j++) { 
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $column_row, $horario[$i][$j]['rut']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $column_row, $horario[$i][$j]['NombreLocal']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(63, $column_row, $horario[$i][$j]['ID_Jornada']);
					$jornadas[]=$horario[$i][$j]['ID_Jornada'];
					$column_row++;
					$column_row_entrada++;
					$contaFilas++;
				}
				$column_row_entrada=3;
			}
			$contadorEntrada=2;
			$contadorSalida=3;
			$column_row_salida=3;
			$countPermiso=0;
			for ($i=0; $i < $contaFilas; $i++) { 
				$jor[$i]=$this->ModuloJornadas->ListarHoraEntradaSalidaPorJornada($jornadas[$i],$diaInicio,$diaFin,$BD);
				for ($j=0; $j < $dias+1; $j++) { 
					if($jor[$i][$j]['ID_Permiso']==0){
						$object->getActiveSheet()->setCellValueByColumnAndRow($contadorEntrada, $column_row_salida, substr_replace($jor[$i][$j]['Entrada'],"",-8));
						$object->getActiveSheet()->setCellValueByColumnAndRow($contadorSalida, $column_row_salida, substr_replace($jor[$i][$j]['Salida'],"",-8));
					}else{
						$object->getActiveSheet()->setCellValueByColumnAndRow($contadorEntrada, $column_row_salida, $jor[$i][$j]['Codigo']);
						$object->getActiveSheet()->setCellValueByColumnAndRow($contadorSalida, $column_row_salida, $jor[$i][$j]['Codigo']);
					}			
					$contadorSalida=$contadorSalida+2;
					$contadorEntrada=$contadorEntrada+2;
				}
				$column_row_salida++;
				$contadorSalida=3;
				$contadorEntrada=2;
			}
			$contadorEntrada=2;
			$contadorSalida=3;
			for ($f=0; $f < $dias+1; $f++) { 
				$object->getActiveSheet()->setCellValueByColumnAndRow($contadorEntrada,1,$cuentaDiaEntrada);
				$object->getActiveSheet()->setCellValueByColumnAndRow($contadorSalida,1,$cuentaDiaSalida);
				$object->getActiveSheet()->setCellValueByColumnAndRow($contadorEntrada,2,'Entrada');
				$object->getActiveSheet()->setCellValueByColumnAndRow($contadorSalida,2,'Salida');
				$contadorEntrada=$contadorEntrada+2;
				$contadorSalida=$contadorSalida+2;
				$cuentaDiaEntrada++;
				$cuentaDiaSalida++;
			}
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="EditarHorarioMes.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
			ob_end_clean();
			$objWriter->save('php://output');
		}
	}

	function columnLetter($c){
	    $c = intval($c);
	    if ($c <= 0) return '';
	    $letter = '';            
	    while($c != 0){
	       $p = ($c - 1) % 26;
	       $c = intval(($c - $p) / 26);
	       $letter = chr(65 + $p) . $letter;
	    }
	    return $letter;       
	}

	function ActualizarHorarioActual(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_FILES['excelv']['name'])){
					$this->load->model("ModuloUsuario");
					$this->load->model("ModuloJornadas");
					$this->load->model("ModuloPermisos");
					$excel=$this->limpiaEspacio($_FILES['excelv']['name']);	
				 	$R=$this->subirArchivos($excel,0,0);
				 	$BD=$_SESSION["BDSecundaria"];
				 	$cli=$_SESSION["Cliente"];
				 	$id_creador=$_SESSION['Usuario'];
				 	$tipo=PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
					$objReader=PHPExcel_IOFactory::createReader($tipo);
					$object=$objReader->load("archivos/archivos_Temp/".$excel);
					$object->setActiveSheetIndex(0);
					$defaultPrecision=ini_get('precision');
					ini_set('precision', $defaultPrecision);
					$parametro=0;
					$initialLetter='C';
					$dayHour='C';
					$countColumn=0;
					$fila=3;
					$filaDia=1;
					$contador=0;
					$error=0;
					$file=1;
					$highRow=intval($object->setActiveSheetIndex(0)->getHighestRow())-2;
					$key=$object->getActiveSheet()->getCell('BM1')->getCalculatedValue();
					$keyBD=$this->ModuloJornadas->BuscarKeyHorario($BD);
					if ($keyBD["Nombre_Archivo"]==$key) {
						while($parametro==0){
							if($object->getActiveSheet()->getCell($initialLetter.'3')->getCalculatedValue()==NULL){
				 				$parametro=1;
				 			}else{
				 				$initialLetter++;
				 				$countColumn++;
				 			}	
						}
						$initialLetter='C';
						for ($i=0; $i < $highRow; $i++) { 
							$countEnt=0;
			 				$countSalida=0;
							$IdJornada[$i]=intval($object->getActiveSheet()->getCell('BL'.$fila)->getCalculatedValue());
							for ($j=0; $j < $countColumn; $j++) { 
								if ($j%2==0) {
									$diaEntrada[$countEnt]=$object->getActiveSheet()->getCell($dayHour.$filaDia)->getCalculatedValue();
									$entrada[$i][]=$object->getActiveSheet()->getCell($dayHour.$fila)->getFormattedValue();	
									$idPermisoEntrada[$i][]=$this->ModuloPermisos->buscarIdPermiso($entrada[$i][$countEnt]);
									if ($idPermisoEntrada[$i][$countEnt]==null) {
										$idPermisoEntrada[$i][$countEnt]['id_permiso']=0;
									}else{
										$entrada[$i][$countEnt]='00:00:00';
									}
									$dayHour++;
									$countEnt++;
								}else{
									$salida[$i][]=$object->getActiveSheet()->getCell($dayHour.$fila)->getFormattedValue();
									$idPermisoSalida[$i][]=$this->ModuloPermisos->buscarIdPermiso($salida[$i][$countSalida]);
									if ($idPermisoSalida[$i][$countSalida]==null) {
										$idPermisoSalida[$i][$countSalida]['id_permiso']=0;
									}else{
										$salida[$i][$countSalida]='00:00:00';
									}
									$dayHour++;
									$countSalida++;
								}
								$initialLetter++;
							}	
							$contador++;
							$contSalida=0;
							$auxEntrada=1;
							$auxSalida=1;
							$dayHour='C';
							$initialLetter='C';	
							$fila++;		
						}			
						if ($error==0) {
							for ($i=0; $i < $highRow; $i++) {
								for ($j=0; $j < $countColumn/2; $j++) { 
									$cant=$this->ModuloJornadas->UpdateHorarioMasivo($IdJornada[$i],$entrada[$i][$j],$salida[$i][$j],intval($idPermisoEntrada[$i][$j]['id_permiso']),$diaEntrada[$j],$BD);
								} 
							}
						}
						//Carga vista en caso de tener errores
						if(isset($highRow)){
							if(isset($_SESSION["sesion"])){
								if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){		
									$hoy = getdate();
									$mes = getdate();
									$thismonth = $mes['mon'];
									$this->load->model("ModuloJornadas");
									$this->load->model("ModuloUsuario"); 
									$BD=$_SESSION["BDSecundaria"];
									if(isset($_GET['opcion'])){
										if(is_numeric($_GET['opcion'])){
											$buscasan = $_GET['opcion'];
										}else{
											$buscasan=1;
										}
									}else{
										$buscasan=1;
									}
									$mens['tipo'] = 47;	
					    			$mens['cantidad']=$contador;
									$data["horarios"]= $this->ModuloJornadas->ListarHorarioPaginador($BD,$buscasan-1,0,0,0);
									$data['opcion']=$buscasan;			
									$tempoCantidad = $this->ModuloJornadas->cantidadJornadas($BD,$thismonth);
									$data['cantidad'] = ceil(($tempoCantidad)/5);
							   		$data["Usuario"]=$_SESSION["Usuario"];					
									$data["Nombre"]=$_SESSION["Nombre"];
									$data["Perfil"] = $_SESSION["Perfil"];
									$data["Cliente"] = $_SESSION["Cliente"];
									$data["NombreCliente"]=$_SESSION["NombreCliente"];
									$data["Cargo"] = $_SESSION["Cargo"];
									$data['mesActual']=$hoy['mon'];	
									$data['mes']=$mes['mon'];
									$data["Clientes"]= $this->funcion_login->elegirCliente();
									$BD=$_SESSION["BDSecundaria"];
									$this->load->model("ModuloPermisos");				
									$this->load->model("ModuloPuntosVentas");
									$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
									$data["permisos"]=$this->ModuloPermisos->listarPermisos();
									$data["cantidadHorario"]=count($data['horarios']);
									$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
									$data["AnioHorario"]= $this->ModuloJornadas->ListarAnio($BD);
									$data["ListarUsuario"]= $this->ModuloJornadas->ListarUsuario($BD);
									$data["ListarFechaFuturo"]=$this->ModuloJornadas->buscarFechaFuturo($BD);
									$data["AsignadoBoton"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],11,$_SESSION["Cliente"]);
									$data["AsignadoEditar"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],12,$_SESSION["Cliente"]);
									$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
									//vistas
								    $this->load->view('contenido');
								    $this->load->view('layout/header',$data);
								    $this->load->view('layout/sidebar',$data);
								    $this->load->view('admin/adminHorarios',$data);
								    $this->load->view('layout/footer',$data);
								    $this->load->view('layout/mensajes',$mens);
								}else{

									redirect(site_url("login/inicio"));	
								}
							}else{
								redirect(site_url("login/inicio"));	
							}	
						}else{
							redirect(site_url("Adm_ModuloJornadas/adminHorario"));	
						}					
					}else{
						if(isset($_SESSION["sesion"])){
							if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){		
								$hoy = getdate();
								$mes = getdate();
								$thismonth = $mes['mon'];
								$this->load->model("ModuloJornadas");
								$this->load->model("ModuloUsuario"); 
								$BD=$_SESSION["BDSecundaria"];
								if(isset($_GET['opcion'])){
									if(is_numeric($_GET['opcion'])){
										$buscasan = $_GET['opcion'];
									}else{
										$buscasan=1;
									}
								}else{
									$buscasan=1;
								}
								$mens['tipo'] = 73;	
				    			$mens['cantidad']=$contador;
								$data["horarios"]= $this->ModuloJornadas->ListarHorarioPaginador($BD,$buscasan-1,0,0,0);
								$data['opcion']=$buscasan;			
								$tempoCantidad = $this->ModuloJornadas->cantidadJornadas($BD,$thismonth);
								$data['cantidad'] = ceil(($tempoCantidad)/5);
						   		$data["Usuario"]=$_SESSION["Usuario"];					
								$data["Nombre"]=$_SESSION["Nombre"];
								$data["Perfil"] = $_SESSION["Perfil"];
								$data["Cliente"] = $_SESSION["Cliente"];
								$data["NombreCliente"]=$_SESSION["NombreCliente"];
								$data["Cargo"] = $_SESSION["Cargo"];
								$data['mesActual']=$hoy['mon'];	
								$data['mes']=$mes['mon'];
								$data["Clientes"]= $this->funcion_login->elegirCliente();
								$BD=$_SESSION["BDSecundaria"];
								$this->load->model("ModuloPermisos");				
								$this->load->model("ModuloPuntosVentas");
								$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
								$data["permisos"]=$this->ModuloPermisos->listarPermisos();
								$data["cantidadHorario"]=count($data['horarios']);
								$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
								$data["AnioHorario"]= $this->ModuloJornadas->ListarAnio($BD);
								$data["ListarUsuario"]= $this->ModuloJornadas->ListarUsuario($BD);
								$data["ListarFechaFuturo"]=$this->ModuloJornadas->buscarFechaFuturo($BD);
								$data["AsignadoBoton"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],11,$_SESSION["Cliente"]);
								$data["AsignadoEditar"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],12,$_SESSION["Cliente"]);
								$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
								//vistas
							    $this->load->view('contenido');
							    $this->load->view('layout/header',$data);
							    $this->load->view('layout/sidebar',$data);
							    $this->load->view('admin/adminHorarios',$data);
							    $this->load->view('layout/footer',$data);
							    $this->load->view('layout/mensajes',$mens);
							}else{
								redirect(site_url("login/inicio"));	
							}
						}else{
							redirect(site_url("login/inicio"));	
						}	
					}
				}else{
					redirect(site_url("Adm_ModuloJornadas/adminHorario"));
				}
			}
		}
	}


	function ActualizarHorarioActuala(){
	//Bienvenido al derrame cerebral	
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_FILES['excelv']['name'])){
					if ($_FILES['excelv']['size']==0) {
						$hoy = getdate();
						$mes = getdate();
						$thismonth = $mes['mon'];
						$this->load->model("ModuloJornadas");
						$this->load->model("ModuloUsuario"); 
						$BD=$_SESSION["BDSecundaria"];
						if(isset($_GET['opcion'])){
							if(is_numeric($_GET['opcion'])){
								$buscasan = $_GET['opcion'];
							}else{
								$buscasan=1;
							}
						}else{
							$buscasan=1;
						}
						$mens['tipo'] = 31;	
						$data["horarios"]= $this->ModuloJornadas->ListarHorarioPaginador($BD,$buscasan-1,0,0,0);
						$data['opcion']=$buscasan;			
						$tempoCantidad = $this->ModuloJornadas->cantidadJornadas($BD,$thismonth);
						$data['cantidad'] = ceil(($tempoCantidad)/5);
				   		$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["Cargo"] = $_SESSION["Cargo"];
						$data['mesActual']=$hoy['mon'];	
						$data['mes']=$mes['mon'];
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$BD=$_SESSION["BDSecundaria"];
						$this->load->model("ModuloPermisos");				
						$this->load->model("ModuloPuntosVentas");
						$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
						$data["permisos"]=$this->ModuloPermisos->listarPermisos();
						$data["cantidadHorario"]=count($data['horarios']);
						$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
						$data["AnioHorario"]= $this->ModuloJornadas->ListarAnio($BD);
						$data["ListarUsuario"]= $this->ModuloJornadas->ListarUsuario($BD);
						$data["ListarFechaFuturo"]=$this->ModuloJornadas->buscarFechaFuturo($BD);
						//vistas
					    $this->load->view('contenido');
					    $this->load->view('layout/header',$data);
					    $this->load->view('layout/sidebar',$data);
					    $this->load->view('admin/adminHorarios',$data);
					    $this->load->view('layout/footer',$data);
					    $this->load->view('layout/mensajes',$mens);
					}else{					
						//Declaración de variables
						$this->load->model("ModuloUsuario");
						$this->load->model("ModuloJornadas");
						$this->load->model("ModuloPermisos");
						$excel=$this->limpiaEspacio($_FILES['excelv']['name']);	
					 	$R=$this->subirArchivos($excel,0,0);
					 	$BD=$_SESSION["BDSecundaria"];
					 	$cli=$_SESSION["Cliente"];
					 	$id_creador=$_SESSION['Usuario'];
					 	$tipo=PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
						$objReader=PHPExcel_IOFactory::createReader($tipo);
						$object=$objReader->load("archivos/archivos_Temp/".$excel);
						$object->setActiveSheetIndex(0);
						$defaultPrecision=ini_get('precision');
						ini_set('precision', $defaultPrecision);
						$horarioMax=$this->ModuloJornadas->ListarHorarioEditar($BD);
						$FechaInicioDias=date('d/m/Y', strtotime($object->getActiveSheet()->getCell('B1')->getFormattedValue()));
						$fechaDias=explode('/',date('d/m/Y'));
						$dayHour='C';
						$dayHourE='C';
						$dayHourS='D';
						$dias=$fechaDias[0];
			 			$mes=$fechaDias[1];
				 		$anio=$fechaDias[2];
				 		$parametro=0;
				 		$lineaDia="";
				 		$numerosDias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); 
						$fila=3;
						$filaDia=1;
						$highRow=$object->setActiveSheetIndex(0)->getHighestRow();
						$contador=0;
						$filaMaximaHorario=max(array_keys($horarioMax))+1;
						$diaInicio=date('d')+1;
						$lastday=date('t');
						$contadorHorarioArray=0;
						$error=0;
						$diaError='';
						$lineaDia=0;
						$b=":";
						$errorChar='';
						set_time_limit(9000);
						$letra=date('d')+7;
						$diaEntradaLetra=$this->columnLetter($letra);
						//Llenado de variables en arrays vacíos
						foreach ($horarioMax as $h) {
							$jornadas[]=$h["ID_Jornada"];
						}
						//Proceso de lectura del excel
						while($parametro==0){	
					 		if($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue()==NULL)
					 		{
					 			$parametro=1;
					 		}else{	
					 			
								for ($i=2; $i < $highRow; $i++) { 
						 			$countEnt=0;
						 			$countSalida=0;
						 			for ($d=0; $d < $numerosDias*2; $d++) { 
										if ($d%2==0) {
											$diaEntrada[$countEnt]=$object->getActiveSheet()->getCell($dayHour.$filaDia)->getCalculatedValue();
											$dayHour++;
											$countEnt++;
										}else{
											$diaSalida[$countSalida]=$object->getActiveSheet()->getCell($dayHour.$filaDia)->getCalculatedValue();
											$dayHour++;
											$countSalida++;
										}
									}	
									$dayHour='C';
									$contEntrada=0;
									$contSalida=0;
									$auxEntrada=1;
									$auxSalida=1;
									$row=0;
									for ($n=0; $n < $numerosDias*2; $n++) { 
										if ($n%2==0) {
											$entrada[$contador][$contEntrada]=$object->getActiveSheet()->getCell($dayHourE.$fila)->getFormattedValue();							
											$auxEntrada++;
											$idPermisoEntrada[$contador][$contEntrada]=$this->ModuloPermisos->buscarIdPermiso($entrada[$contador][$contEntrada]);
												if ($idPermisoEntrada[$contador][$contEntrada]==null) {
													$idPermisoEntrada[$contador][$contEntrada]['id_permiso']=0;
													if (strpos($entrada[$contador][$contEntrada],$b)===false) {
															$lineaDia=$contador;
															$parametro=1;
															$error=49;
															$errorChar=$entrada[$contador][$contEntrada];
															break;
														}
												}else{
													$entrada[$contador][$contEntrada]='00:00:00';
												}
											$contEntrada++;
										}else{
											$salida[$contador][$contSalida]=$object->getActiveSheet()->getCell($dayHourE.$fila)->getFormattedValue();
											$auxSalida++;
											$idPermisoSalida[$contador][$contSalida]=$this->ModuloPermisos->buscarIdPermiso($salida[$contador][$contSalida]);
												if ($idPermisoSalida[$contador][$contSalida]==null) {
													$idPermisoSalida[$contador][$contSalida]['id_permiso']=0;
													if (strpos($salida[$contador][$contSalida],$b)===false) {
															$lineaDia=$contador;
															$parametro=1;
															$error=49;
															$errorChar=$salida[$contador][$contSalida];
															break;
														}
												}else{
													$salida[$contador][$contSalida]='00:00:00';
												}
											$contSalida++;
										}
										$dayHourE++;							
									}
									$IdJornada[$contador]=$object->getActiveSheet()->getCell('BM'.$fila)->getCalculatedValue();
									$dayHourE='C';
									$fila++;
									$contador++;
							}
						}
					}
					for ($i=0; $i < $lastday; $i++) { 
						$fecha[]=$anio."-".$mes."-".$diaEntrada[$i];
					}
					//Si el error es 0 la función editará e ingresará según corresponda, de lo contrario mostrara mensaje de error dependiendo del error.
					if ($error==0) {
						//For de Edición
						for ($j=0; $j < $filaMaximaHorario; $j++) { 
							for ($i=0; $i <$numerosDias; $i++) { 
	    					$cant=$this->ModuloJornadas->UpdateHorarioMasivo(intval($IdJornada[$j]),$entrada[$j][$i],$salida[$j][$i],intval($idPermisoEntrada[$j][$i]['id_permiso']),$diaEntrada[$i],$BD);
	    					}
						}
			    			//Carga vista en caso de no haber errores
			    			if(isset($_SESSION["sesion"])){
								if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){		
									$hoy = getdate();
									$mes = getdate();
									$thismonth = $mes['mon'];
									$this->load->model("ModuloJornadas");
									$this->load->model("ModuloUsuario"); 
									$BD=$_SESSION["BDSecundaria"];
									if(isset($_GET['opcion'])){
										if(is_numeric($_GET['opcion'])){
											$buscasan = $_GET['opcion'];
										}else{
											$buscasan=1;
										}
									}else{
										$buscasan=1;
									}
									$mens['tipo'] = 47;	
					    			$mens['cantidad']=$contador;
									$data["horarios"]= $this->ModuloJornadas->ListarHorarioPaginador($BD,$buscasan-1,0,0,0);
									$data['opcion']=$buscasan;			
									$tempoCantidad = $this->ModuloJornadas->cantidadJornadas($BD,$thismonth);
									$data['cantidad'] = ceil(($tempoCantidad)/5);
							   		$data["Usuario"]=$_SESSION["Usuario"];					
									$data["Nombre"]=$_SESSION["Nombre"];
									$data["Perfil"] = $_SESSION["Perfil"];
									$data["Cliente"] = $_SESSION["Cliente"];
									$data["NombreCliente"]=$_SESSION["NombreCliente"];
									$data["Cargo"] = $_SESSION["Cargo"];
									$data['mesActual']=$hoy['mon'];	
									$data['mes']=$mes['mon'];
									$data["Clientes"]= $this->funcion_login->elegirCliente();
									$BD=$_SESSION["BDSecundaria"];
									$this->load->model("ModuloPermisos");				
									$this->load->model("ModuloPuntosVentas");
									$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
									$data["permisos"]=$this->ModuloPermisos->listarPermisos();
									$data["cantidadHorario"]=count($data['horarios']);
									$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
									$data["AnioHorario"]= $this->ModuloJornadas->ListarAnio($BD);
									$data["ListarUsuario"]= $this->ModuloJornadas->ListarUsuario($BD);
									$data["ListarFechaFuturo"]=$this->ModuloJornadas->buscarFechaFuturo($BD);
									$data["AsignadoBoton"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],11,$_SESSION["Cliente"]);
									$data["AsignadoEditar"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],12,$_SESSION["Cliente"]);
									$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
									//vistas
								    $this->load->view('contenido');
								    $this->load->view('layout/header',$data);
								    $this->load->view('layout/sidebar',$data);
								    $this->load->view('admin/adminHorarios',$data);
								    $this->load->view('layout/footer',$data);
								    $this->load->view('layout/mensajes',$mens);
								}else{

									redirect(site_url("login/inicio"));	
								}
							}else{
								redirect(site_url("login/inicio"));	
							}	
										    
				    	}else{
				    		//Carga vista mostrando error
				    		if(isset($_SESSION["sesion"])){
								if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
									$hoy = getdate();
									$mes = getdate();
									$thismonth = $mes['mon'];
									$this->load->model("ModuloJornadas");
									$this->load->model("ModuloUsuario"); 
									$BD=$_SESSION["BDSecundaria"];
									if(isset($_GET['opcion'])){
										if(is_numeric($_GET['opcion'])){
											$buscasan = $_GET['opcion'];
										}else{
											$buscasan=1;
										}
									}else{
										$buscasan=1;
									}
									$mens['tipo'] = $error;	
					    			$mens['cantidad']=$contador+1;
					    			$mens['cantidadU']=$contador;
					    			$mens['dia']=$diaError;
					    			$mens['char']=$errorChar;
					    			$mens['lineaDia']=$lineaDia+3;
									$data["horarios"]= $this->ModuloJornadas->ListarHorarioPaginador($BD,$buscasan-1,0,0,0);
									$data['opcion']=$buscasan;			
									$tempoCantidad = $this->ModuloJornadas->cantidadJornadas($BD,$thismonth);
									$data['cantidad'] = ceil(($tempoCantidad)/5);
							   		$data["Usuario"]=$_SESSION["Usuario"];					
									$data["Nombre"]=$_SESSION["Nombre"];
									$data["Perfil"] = $_SESSION["Perfil"];
									$data["Cliente"] = $_SESSION["Cliente"];
									$data["NombreCliente"]=$_SESSION["NombreCliente"];
									$data["Cargo"] = $_SESSION["Cargo"];
									$data['mesActual']=$hoy['mon'];	
									$data['mes']=$mes['mon'];
									$data["Clientes"]= $this->funcion_login->elegirCliente();
									$BD=$_SESSION["BDSecundaria"];
									$this->load->model("ModuloPermisos");				
									$this->load->model("ModuloPuntosVentas");
									$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
									$data["permisos"]=$this->ModuloPermisos->listarPermisos();
									$data["cantidadHorario"]=count($data['horarios']);
									$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
									$data["AnioHorario"]= $this->ModuloJornadas->ListarAnio($BD);
									$data["ListarUsuario"]= $this->ModuloJornadas->ListarUsuario($BD);
									$data["ListarFechaFuturo"]=$this->ModuloJornadas->buscarFechaFuturo($BD);
									//vistas
								    $this->load->view('contenido');
								    $this->load->view('layout/header',$data);
								    $this->load->view('layout/sidebar',$data);
								    $this->load->view('admin/adminHorarios',$data);
								    $this->load->view('layout/footer',$data);
								    $this->load->view('layout/mensajes',$mens);
								}else{
									redirect(site_url("login/inicio"));	
								}
							}else{
								redirect(site_url("login/inicio"));	
							}
						}
			    	}
				}
			}
    	}
	}

	function ingresarJornada(){
		$BD=$_SESSION["BDSecundaria"];
		$this->load->model("ModuloJornadas");
		$usuarios=$this->ModuloJornadas->ListarUsuario($BD);
		$locales=$this->ModuloJornadas->listarLocales($BD);
		$fechas=$this->ModuloJornadas->ListarFechas($BD);
		// $dia=25+1;//debe ser mas uno para asignar el horario al dia siguiente y no el actual
		$dia=date("d");
		$mes=date("m");
		$anio=date("Y");
		$numerosDias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); 
		$valFecha=$numerosDias-$dia; //$numerosDias-$dia, se modifica el valor para hacer prueba
		for ($i=$dia; $i < $numerosDias+1; $i++) { 
			$arrayDias[]=$i;
		}
		echo "<div class='modal-header'>
				<h6 class='modal-title'>Ingresar Jornada</h6>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
			</div>";
		echo "<div class='modal-body'>
					<div class='card'>
						<div class='card-body'>
							<form id='mFrmIngresarJor' method='POST'>
							<div class='row'>
								<div class='col-md-6' style='margin-top:10px;'>
								<label for='company'>Usuario</label>
									<div class='input-group'>
										<span class='input-group-addon'><i class='mdi mdi-account'></i></span>
										<select id='msltUserJor' name='msltUserJor' class='form-control form-control-sm'>
		                                    <option value=''>Por favor Seleccione el Usuario</option>";     
		                                        foreach ($usuarios as $u) {
		                                            echo "<option value='".$u['id_usuario']."'>".$u['Nombres']."</option>";
		                                    }
		                                echo"</select>
									</div>
								<div id='errormsltUser' style='color: red; display: none;'>
									   Debe seleccionar el Usuario...
								</div>
								</div>

								<div class='col-md-6' style='margin-top:10px;'>
								<label for='company'>Local</label>
									<div class='input-group'>
										<span class='input-group-addon'><i class='mdi mdi-factory'></i></span>
										<select id='msltLocal' name='msltLocal' class='form-control form-control-sm'>
		                                    <option value=''>Por favor Seleccione el Local</option>";
		                                        foreach ($locales as $l) {
		                                            echo "<option value='".$l['ID_Local']."'>".$l['NombreLocal']."</option>";
		                                    }
		                                echo"</select>
									</div>
								<div id='errormsltLocal' style='color: red; display: none;'  >
									   Debe seleccionar el Local...
								</div>
								</div>
							</div>
							<hr>
							<div class='row'>
								<div class='col-md-6' style='margin-top:10px;' id='diaInicio'>
								<label for='company'>Dia de Inicio</label>
									<div class='input-group'>
										<span class='input-group-addon'><i class='mdi mdi-calendar'></i></span>
										<select id='msltDiaInicio' name='msltDiaInicio' class='form-control form-control-sm'>
		                                    <option value='' id='default'>Por favor Seleccione el Inicio</option>";
		                                        foreach ($arrayDias as $a) {
	                                                echo "<option value='".$a."'>Día: ".$a."</option>";
	                                            }
		                                echo"</select>
									</div>
								<div id='errormsltDiaInicio' style='color: red; display: none;'  >
									   Debe seleccionar el Día de inicio...
								</div>
								</div>";
								if ($valFecha>1) {
									echo "<div style='margin-top:45px; margin-left:10px;' class='checkbox abc-checkbox abc-checkbox-danger abc-checkbox-circle'>
										<div class='input-group'>
											<input  type='checkbox' name='rango' value='rango' id='rango' class='styled'><label for='rango'>
											Insertar Rango de Días
										</label>
										</div>
									</div>";
								}
                            echo "</div>
                            <div class='col-md-6' id='rangoFechaInput' style='display:none; padding-right:50px;'>
                                <div class='card-body'>
                                    <label for='company'>Rango de Días</label>
                                    <input class='range-example-input-1' type='text' min='".$dia."' max='".$numerosDias."' name='points' id='points' step='1'/>
                                </div> 
                                <div id='errorPoints' style='color: red; display: none;'  >
								   Debe declarar un rango de días...
								</div>          
                            </div>
                            <hr>
                            <div class='row'>
								<div class='col-md-6' style='margin-top:10px; id='div_hora'>
									<label for='company'>Hora de Inicio</label>
									<div class='input-group clockpicker'>
										<span class='input-group-addon'>
	                                        <span class='mdi mdi-timer'></span>
	                                    </span>
	                                    <input name='hora_inicio' id='hora_inicio' type='text' class='form-control' value=''>
	                                </div>
	                                <div id='errormsltHoraInicio' style='color: red; display: none;'  >
									   Debe seleccionar la hora de inicio...
									</div>
								</div>

								<div class='col-md-6' style='margin-top:10px; id='div_hora_fin'>
									<label for='company'>Hora Fin</label>
									<div class='input-group clockpickerFin'>
										<span class='input-group-addon'>
                                            <span class='mdi mdi-timer'></span>
                                        </span>
                                        <input name='hora_fin' id='hora_fin' type='text' class='form-control' value=''>        
                                    </div>
                                    <div id='errormsltHoraFin' style='color: red; display: none;'  >
									   Debe seleccionar la hora fin...
									</div>
								</div>
							</div>
								
							</form>
						</div>
					</div>
			</div>	

			<div id='botonAgregar' class='modal-footer'>
				<button type='button' class='btn btn-sm btn-danger' onclick='return validarCrearJornada();' ><i id='icAsignarPermiso'  class=''></i> Crear Jornada</button>
			</div>
			<link rel='stylesheet' href='"; echo  site_url(); echo "assets/libs/sliderrange/dist/css/asRange.css'>
			<script src='"; echo  site_url(); echo "assets/libs/jquery/dist/jquery.min.js'></script>
			<script src='"; echo  site_url(); echo "assets/libs/select2/dist/js/select2.min.js'></script>
			<script src='"; echo  site_url(); echo "assets/libs/clockpicker/dist/bootstrap-clockpicker.min.js'></script>
			<script src='"; echo  site_url(); echo "assets/libs/sliderrange/dist/jquery-asRange.min.js'></script>
			<script type='text/javascript'>

			function validarCrearJornada(){
				if(validarJornadas()==false){
					alertify.error('Existen Campos Vacios');
					return false;
				}else{
					$.ajax({                        
				   	type: 'POST',                 
					url:'ingresarJornadaF',                     
					data: $('#mFrmIngresarJor').serialize(), 
						success: function(data){            							
								alertify.success('Se ha creado la jornada correctamente');
								setTimeout(function(){
									window.location = 'adminHorario';
								}, 1000);
						 return data;
						}     
			    	});
				}	
			}

			function validarJornadas(){
				var vacios=0;
				var valido=true;
				if($('#msltUserJor').val()==''){  
					$('#msltUserJor').attr('class', 'form-control is-invalid');
					$('#errormsltUser').show();
					alertify.error('Seleccione un usuario'); 
					vacios+=1;
				} else { 
					$('#msltUserJor').attr('class', 'form-control is-valid');  
					$('#errormsltUser').hide();      
				}
				if($('#msltLocal').val()==''){  
					$('#msltLocal').attr('class', 'form-control is-invalid');
					$('#errormsltLocal').show();
					alertify.error('Seleccione un local'); 
					vacios+=1;
				} else { 
					$('#msltLocal').attr('class', 'form-control is-valid');  
					$('#errormsltLocal').hide();      
				}
				if($('#hora_inicio').val()==''){  
					$('#hora_inicio').attr('class', 'form-control is-invalid');
					$('#errormsltHoraInicio').show();
					alertify.error('Seleccione la hora de inicio'); 
					vacios+=1;
				} else { 
					$('#hora_inicio').attr('class', 'form-control is-valid');  
					$('#errormsltHoraInicio').hide();      
				}
				if($('#hora_fin').val()==''){  
					$('#hora_fin').attr('class', 'form-control is-invalid');
					$('#errormsltHoraFin').show();
					alertify.error('Seleccione la hora fin'); 
					vacios+=1;
				} else { 
					$('#hora_fin').attr('class', 'form-control is-valid');  
					$('#errormsltHoraFin').hide();      
				}
				if($('#hora_inicio').val()!='' && $('#hora_inicio').val() > $('#hora_fin').val()){
					$('#hora_inicio').attr('class', 'form-control is-invalid');
					$('#hora_fin').attr('class', 'form-control is-invalid');
					alertify.error('La hora de inicio no puede ser mayor a la hora final');
					vacios+=1;
				}else{
					$('#hora_inicio').attr('class', 'form-control is-valid');
					$('#hora_fin').attr('class', 'form-control is-valid');
				}
				if($('#rango').prop('checked')){
					if($('#points').val()==''){
						$('#points').attr('class', 'form-control is-invalid');
						$('#errorPoints').show();
						alertify.error('Elija un rango de días'); 
						vacios+=1;
					}else{
						$('#points').attr('class', 'form-control is-valid');  
						$('#errorPoints').hide(); 
					}
				}else{
					if($('#msltDiaInicio').val()==''){
						$('#msltDiaInicio').attr('class', 'form-control is-invalid');
						$('#errormsltDiaInicio').show();
						alertify.error('Elija un día'); 
						vacios+=1;
					}else{
						$('#msltDiaInicio').attr('class', 'form-control is-valid');  
						$('#errormsltDiaInicio').hide(); 
					}
				}
				if(vacios>0){ valido=false; }
				return valido;
			}

			$('.range-example-input-1').asRange({
		        range: true,
		        limit: false,
		    });

			$('.clockpicker').clockpicker({
			    placement: 'top',
			    align: 'left',
			    donetext: 'Hecho',
			    autoclose: true,
			    'default': 'now',
			});

			$('.clockpickerFin').clockpicker({
			    placement: 'top',
			    align: 'left',
			    donetext: 'Hecho',
			    autoclose: true,
			    'default': 'now',
			});			

			$('#rango').click( function(){
				if($(this).is(':checked')){
					$('#rangoFechaInput').show('slow');
					$('#diaInicio').hide('slow');
					document.getElementById('default').selected = 'true';
				}else{
					$('#rangoFechaInput').hide('slow');
					$('#diaInicio').show('slow');
				};
			});
			</script>"; 

	}

	function ingresarJornadaF(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$this->load->model("ModuloJornadas");
				// var_dump($_POST);exit();
				// $dia=25+1;
				$dia=date("d");
				$mes=date("m");
				$anio=date("Y");
				$FechaInicioDias=date('d/m/Y');
				$numerosDias=cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
				$BD=$_SESSION["BDSecundaria"];
				$id_creador=$_SESSION['Usuario'];
				$usuario=$_POST["msltUserJor"];
				$local=$_POST["msltLocal"];
				$hora_inicio=$_POST["hora_inicio"];
				$hora_fin=$_POST["hora_fin"];
				//RECUERDA SETEAR VACIO EL SELECT AL HACER CHECK EN EL CHECK :V
				if ($_POST["msltDiaInicio"]!=""){
					$diaUnitario=$_POST["msltDiaInicio"];
					$diasSinTurno=$diaUnitario-$dia;
					// $diasSinTurnoRestantes=$numerosDias-$diaUnitario;
					for ($i=1; $i < $diaUnitario; $i++) { 
						$entrada[]='00:00:00';
						$salida[]='00:00:00';
						$permiso[]=1;
						$diaArray[]=$i;
					}
						$entrada[]=$hora_inicio.':00';
						$salida[]=$hora_fin.':00';
						$permiso[]=0;
						$diaArray[]=$i;
					for ($i=$diaUnitario+1; $i < $numerosDias+1; $i++) { 
						$entrada[]='00:00:00';
						$salida[]='00:00:00';
						$permiso[]=1;
						$diaArray[]=$i;
					}
					$idJornada[1]['ID']=$this->ModuloJornadas->ingresarJornadaUnitaria($usuario,$local,$id_creador,$BD);
					$idJ=implode($idJornada[1]['ID']);
					for ($i=0; $i <$numerosDias; $i++) { 
						$cant=$this->ModuloJornadas->IngresarHorario($idJ,$diaArray[$i],$FechaInicioDias,$entrada[$i],$salida[$i],$id_creador,$permiso[$i],$BD);
					}
				}else{
					$points=explode(",", $_POST["points"]);
					$diaInicial=min($points);
					$diaFinal=max($points);
					$diaUltimoMes=cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); 					
					for ($i=1; $i < $diaInicial; $i++) { 
						$entrada[]='00:00:00';
						$salida[]='00:00:00';
						$permiso[]=1;
						$diaArray[]=$i;
					}
					for ($i=$diaInicial; $i < $diaFinal+1; $i++) { 
						$entrada[]=$hora_inicio.':00';
						$salida[]=$hora_fin.':00';
						$permiso[]=0;
						$diaArray[]=$i;
					}
					for ($i=$diaFinal+1; $i < $diaUltimoMes+1; $i++) { 
						$entrada[]='00:00:00';
						$salida[]='00:00:00';
						$permiso[]=1;
						$diaArray[]=$i;
					}
					$idJornada[1]['ID']=$this->ModuloJornadas->ingresarJornadaUnitaria($usuario,$local,$id_creador,$BD);
					$idJ=implode($idJornada[1]['ID']);
					for ($i=0; $i <$numerosDias; $i++) { 
						$cant=$this->ModuloJornadas->IngresarHorario($idJ,$diaArray[$i],$FechaInicioDias,$entrada[$i],$salida[$i],$id_creador,$permiso[$i],$BD);
					}
				}
			}
		}
	}

	function IngresarExcelJornadasNuevas(){
			if(isset($_SESSION["sesion"])){
    			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
    				if(isset($_FILES['excelv']['name'])){	
    					$fecha = getdate();
						$mes = $fecha['mon'];
						$anio = $fecha['year'];
						$excel = $this->limpiaEspacio($_FILES['excelv']['name']);	
					 	$R=$this->subirArchivos($excel,0,0);
					 	$this->load->library('phpexcel');
					 	$this->load->model("ModuloJornadas");
						$this->load->model("ModuloUsuario");
						$this->load->model("ModuloPermisos");
					 	$BD=$_SESSION["BDSecundaria"];
					 	$cli=$_SESSION["Cliente"];
					 	$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
						$objReader = PHPExcel_IOFactory::createReader($tipo);
						$object = $objReader->load("archivos/archivos_Temp/".$excel);
						$object->setActiveSheetIndex(0);
						$defaultPrecision = ini_get('precision');
						ini_set('precision', $defaultPrecision);
						set_time_limit(9000);
						$parametro=0;
						$parametroDias=0;
						$id_creador=$_SESSION['Usuario'];
						$fila=3;
						$filaVal=3;
						$filaDia=1;
						$filaRP=3;
						$contador=0;
						$error=0;
						$contadorValDias=0;
						$lineaDia=0;
						$columna='C';
						$columnDay='C';
						$columnaS='D';
						$dayHour='C';
						$dayHourE='C';
						$dayHourS='D';
						$highRow=$object->setActiveSheetIndex(0)->getHighestRow();
						$FechaInicioDias=date('d/m/Y', strtotime($object->getActiveSheet()->getCell('B1')->getFormattedValue()));
						$fechaDias=explode('/',$FechaInicioDias);
	 			 		$mes=$fechaDias[1];
				 		$anio=$fechaDias[2];
				 		$mesExiste=intval($fechaDias[1]);
				 		$anioExiste=intval($fechaDias[2]);
				 		$horaDiaCol='C';
				 		$contadorDiaEntrada=0;
				 		$cont=0;
				 		$filaSpace=3;
				 		$b=":";
				 		$errorChar="";
	 			 		$numerosDias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); 
	 			 		$fechaVal=$mes."/".$anio;
	 			 		$existeHorario=$this->ModuloJornadas->BuscarHorarioFecha($mesExiste,$anioExiste,$BD);
	 			 		setlocale(LC_ALL,"es_ES");
	 			 		$date=DateTime::createFromFormat("d/m/Y", $FechaInicioDias);
						$mesVal=strftime("%B",$date->getTimestamp());
	 			 		if ($existeHorario["Fecha"]==$fechaVal) { 		
	 			 		for ($i=2; $i < $highRow; $i++) { 
	 			 			$columnasTotales[$i]=$object->setActiveSheetIndex(0)->getHighestColumn($filaVal);
		 			 		if ($columnasTotales[$i]=='BL' || $columnasTotales[$i]=='BK') {
		 			 			$colTotales[$i]=31;
		 			 		}elseif ($columnasTotales[$i]=='BJ' || $columnasTotales[$i]=='BI') {
		 			 			$colTotales[$i]=30;
		 			 		}elseif ($columnasTotales[$i]=='BH' || $columnasTotales[$i]=='BG') {
		 			 			$colTotales[$i]=29;
		 			 		}elseif ($columnasTotales[$i]=='BE' || $columnasTotales[$i]=='BF') {
		 			 			$colTotales[$i]=28;
		 			 		}else{
		 			 			$colTotales[$i]=0;
		 			 		}

		 			 		if ($colTotales[$i]!=$numerosDias) {
		 			 			$mesIncorrecto[$i]=1;
		 			 			$error=42;
		 			 		}else{
		 			 			$mesIncorrecto[$i]=0;
		 			 		}		 			 		
		 			 		$filaVal++;
		 			 		$contadorValDias++;
	 			 		}
	 			 		if(!isset($mesIncorrecto)){
	 			 			$mesIncorrecto[0]=0;
	 			 		}
	 			 		if (in_array(1, $mesIncorrecto)) {
	 			 			if(isset($_SESSION["sesion"])){
								if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
									$hoy = getdate();
									$mes = getdate();
									$thismonth = $mes['mon'];
									$this->load->model("ModuloJornadas");
									$this->load->model("ModuloUsuario"); 
									$BD=$_SESSION["BDSecundaria"];
									if(isset($_GET['opcion'])){
										if(is_numeric($_GET['opcion'])){
											$buscasan = $_GET['opcion'];
										}else{
											$buscasan=1;
										}
									}else{
										$buscasan=1;
									}
									$mens['tipo'] = $error;
									$data["horarios"]= $this->ModuloJornadas->ListarHorarioPaginador($BD,$buscasan-1,0,0,0);
									$data['opcion']=$buscasan;			
									$tempoCantidad = $this->ModuloJornadas->cantidadJornadas($BD,$thismonth);
									$data['cantidad'] = ceil(($tempoCantidad)/5);
							   		$data["Usuario"]=$_SESSION["Usuario"];					
									$data["Nombre"]=$_SESSION["Nombre"];
									$data["Perfil"] = $_SESSION["Perfil"];
									$data["Cliente"] = $_SESSION["Cliente"];
									$data["NombreCliente"]=$_SESSION["NombreCliente"];
									$data["Cargo"] = $_SESSION["Cargo"];
									$data['mesActual']=$hoy['mon'];	
									$data['mes']=$mes['mon'];
									$data["Clientes"]= $this->funcion_login->elegirCliente();
									$BD=$_SESSION["BDSecundaria"];
									$this->load->model("ModuloPermisos");				
									$this->load->model("ModuloPuntosVentas");
									$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
									$data["permisos"]=$this->ModuloPermisos->listarPermisos();
									$data["cantidadHorario"]=count($data['horarios']);
									$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
									$data["AnioHorario"]= $this->ModuloJornadas->ListarAnio($BD);
									$data["ListarUsuario"]= $this->ModuloJornadas->ListarUsuario($BD);
									$data["ListarFechaFuturo"]=$this->ModuloJornadas->buscarFechaFuturo($BD);
									//vistas
								    $this->load->view('contenido');
								    $this->load->view('layout/header',$data);
								    $this->load->view('layout/sidebar',$data);
								    $this->load->view('admin/adminHorarios',$data);
								    $this->load->view('layout/footer',$data);
								    $this->load->view('layout/mensajes',$mens);
								}else{
									redirect(site_url("login/inicio"));	
								}
							}else{
								redirect(site_url("login/inicio"));	
							}
	 			 		}else{	 			 		
		 			 		while($parametro==0){	
					 		if($object->getActiveSheet()->getCell('A'.$filaRP)->getCalculatedValue()==NULL)
					 		{
					 			$parametro=1;
					 		}else{				
					 			$Rut[$contador]=$object->getActiveSheet()->getCell('A'.$filaRP)->getFormattedValue();
					 			$RutSV=$this->limpiarRut($this->limpiarComilla($Rut));
					 			$resp=$this->ModuloUsuario->validarRutUsuario($RutSV[$contador],$cli);
					 			if($resp==null){
					 				$parametro=1;
					 				$error=9;
					 				break;
					 			}
					 			$PDV[$contador]=$object->getActiveSheet()->getCell('B'.$filaRP)->getFormattedValue();
					 			$exisite=$this->ModuloJornadas->ValidarLocal($BD,$PDV[$contador]);
					 			if($PDV[$contador]==null || $exisite!=1){
					 				$parametro=1;
					 				$error=10;
					 				break;	
					 			}
					 			$filaRP++;
						 		$contE=0;
						 		$contS=0;
								for ($i=0; $i < $numerosDias*2; $i++) { 
										if ($i%2==0) {
											$diaEntrada[]=$object->getActiveSheet()->getCell($dayHour.$filaDia)->getCalculatedValue();
											$dayHour++;
										}else{
											$diaSalida[]=$object->getActiveSheet()->getCell($dayHour.$filaDia)->getCalculatedValue();			
											$dayHour++;
									}
								}	
								$dayHour='C';
								$contEntrada=0;
								$contSalida=0;
								$row=0;
								for ($i=0; $i < $numerosDias*2; $i++) { 
										if ($i%2==0) {
												$entrada[$contador][$contEntrada]=$object->getActiveSheet()->getCell($dayHourE.$fila)->getFormattedValue();
												$idPermisoEntrada[$contador][$contEntrada]=$this->ModuloPermisos->buscarIdPermiso($entrada[$contador][$contEntrada]);
													if ($idPermisoEntrada[$contador][$contEntrada]==null) {
														$idPermisoEntrada[$contador][$contEntrada]['id_permiso']=0;
														if (strpos($entrada[$contador][$contEntrada],$b)===false) {
															$lineaDia=$contador;
															$parametro=1;
															$error=49;
															$errorChar=$entrada[$contador][$contEntrada];
															break;
														}
													}else{
														$entrada[$contador][$contEntrada]='00:00:00';
													}
												$contEntrada++;
											}else{
												$salida[$contador][$contSalida]=$object->getActiveSheet()->getCell($dayHourE.$fila)->getFormattedValue();
												$idPermisoSalida[$contador][$contSalida]=$this->ModuloPermisos->buscarIdPermiso($salida[$contador][$contSalida]);
													if ($idPermisoSalida[$contador][$contSalida]==null) {
														$idPermisoSalida[$contador][$contSalida]['id_permiso']=0;
														if (strpos($salida[$contador][$contSalida],$b)===false) {
															$lineaDia=$contador;
															$parametro=1;
															$error=49;
															$errorChar=$salida[$contador][$contSalida];
															break;
														}
													}else{
														$salida[$contador][$contSalida]='00:00:00';
													}
												$contSalida++;
											}
											$dayHourE++;							
										}
										$dayHourE='C';
										$fila++;
										$contador++;
									}
						}	
						$suma=0;
					if($error==0){
					for ($f=0; $f < $contador; $f++) { 
							$idJornada[1]['ID']=$this->ModuloJornadas->ingresarJornada($Rut[$f],$PDV[$f],$id_creador,$BD);
							$idJ=implode($idJornada[1]['ID']);
			
					for ($i=0; $i <$numerosDias; $i++) { 
		    					$cant=$this->ModuloJornadas->IngresarHorario($idJ,$diaEntrada[$i],$FechaInicioDias,$entrada[$f][$i],$salida[$f][$i],$id_creador,intval($idPermisoEntrada[$f][$i]['id_permiso']),$BD);
		    				}
		    			}	
		    			if(isset($_SESSION["sesion"])){
							if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
								$hoy = getdate();
								$mes = getdate();
								$thismonth = $mes['mon'];
								$this->load->model("ModuloJornadas");
								$this->load->model("ModuloUsuario"); 
								$BD=$_SESSION["BDSecundaria"];
								if(isset($_GET['opcion'])){
									if(is_numeric($_GET['opcion'])){
										$buscasan = $_GET['opcion'];
									}else{
										$buscasan=1;
									}
								}else{
									$buscasan=1;
								}
								$mens['tipo'] = 8;
								$data["horarios"]= $this->ModuloJornadas->ListarHorarioPaginador($BD,$buscasan-1,0,0,0);
								$data['opcion']=$buscasan;			
								$tempoCantidad = $this->ModuloJornadas->cantidadJornadas($BD,$thismonth);
								$data['cantidad'] = ceil(($tempoCantidad)/5);
						   		$data["Usuario"]=$_SESSION["Usuario"];					
								$data["Nombre"]=$_SESSION["Nombre"];
								$data["Perfil"] = $_SESSION["Perfil"];
								$data["Cliente"] = $_SESSION["Cliente"];
								$data["NombreCliente"]=$_SESSION["NombreCliente"];
								$data["Cargo"] = $_SESSION["Cargo"];
								$data['mesActual']=$hoy['mon'];	
								$data['mes']=$mes['mon'];
								$data["Clientes"]= $this->funcion_login->elegirCliente();
								$BD=$_SESSION["BDSecundaria"];
								$this->load->model("ModuloPermisos");				
								$this->load->model("ModuloPuntosVentas");
								$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
								$data["permisos"]=$this->ModuloPermisos->listarPermisos();
								$data["cantidadHorario"]=count($data['horarios']);
								$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
								$data["AnioHorario"]= $this->ModuloJornadas->ListarAnio($BD);
								$data["ListarUsuario"]= $this->ModuloJornadas->ListarUsuario($BD);
								$data["ListarFechaFuturo"]=$this->ModuloJornadas->buscarFechaFuturo($BD);
								//vistas
							    $this->load->view('contenido');
							    $this->load->view('layout/header',$data);
							    $this->load->view('layout/sidebar',$data);
							    $this->load->view('admin/adminHorarios',$data);
							    $this->load->view('layout/footer',$data);
							    $this->load->view('layout/mensajes',$mens);
							}else{
								redirect(site_url("login/inicio"));	
							}
						}else{
							redirect(site_url("login/inicio"));	
						}
					}else{
		    			if(isset($_SESSION["sesion"])){
							if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
								$hoy = getdate();
								$mes = getdate();
								$thismonth = $mes['mon'];
								$this->load->model("ModuloJornadas");
								$this->load->model("ModuloUsuario"); 
								$BD=$_SESSION["BDSecundaria"];
								if(isset($_GET['opcion'])){
									if(is_numeric($_GET['opcion'])){
										$buscasan = $_GET['opcion'];
									}else{
										$buscasan=1;
									}
								}else{
									$buscasan=1;
								}
								$mens['tipo'] = 50;
								$mens['lineaDia']=$lineaDia+3;
								$mens['tipo'] = $error;	
								$mens['char']=$errorChar;
		    					$mens['cantidad']=($contador+3);
								$data["horarios"]= $this->ModuloJornadas->ListarHorarioPaginador($BD,$buscasan-1,0,0,0);
								$data['opcion']=$buscasan;			
								$tempoCantidad = $this->ModuloJornadas->cantidadJornadas($BD,$thismonth);
								$data['cantidad'] = ceil(($tempoCantidad)/5);
						   		$data["Usuario"]=$_SESSION["Usuario"];					
								$data["Nombre"]=$_SESSION["Nombre"];
								$data["Perfil"] = $_SESSION["Perfil"];
								$data["Cliente"] = $_SESSION["Cliente"];
								$data["NombreCliente"]=$_SESSION["NombreCliente"];
								$data["Cargo"] = $_SESSION["Cargo"];
								$data['mesActual']=$hoy['mon'];	
								$data['mes']=$mes['mon'];
								$data["Clientes"]= $this->funcion_login->elegirCliente();
								$BD=$_SESSION["BDSecundaria"];
								$this->load->model("ModuloPermisos");				
								$this->load->model("ModuloPuntosVentas");
								$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
								$data["permisos"]=$this->ModuloPermisos->listarPermisos();
								$data["cantidadHorario"]=count($data['horarios']);
								$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
								$data["AnioHorario"]= $this->ModuloJornadas->ListarAnio($BD);
								$data["ListarUsuario"]= $this->ModuloJornadas->ListarUsuario($BD);
								$data["ListarFechaFuturo"]=$this->ModuloJornadas->buscarFechaFuturo($BD);
								//vistas
							    $this->load->view('contenido');
							    $this->load->view('layout/header',$data);
							    $this->load->view('layout/sidebar',$data);
							    $this->load->view('admin/adminHorarios',$data);
							    $this->load->view('layout/footer',$data);
							    $this->load->view('layout/mensajes',$mens);
							}else{
								redirect(site_url("login/inicio"));	
							}
						}else{
							redirect(site_url("login/inicio"));	
						}
					}
				}
			}else{	 			
	 			if(isset($_SESSION["sesion"])){
					if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
								$hoy = getdate();
								$mes = getdate();
								$thismonth = $mes['mon'];
								$this->load->model("ModuloJornadas");
								$this->load->model("ModuloUsuario"); 
								$BD=$_SESSION["BDSecundaria"];
								if(isset($_GET['opcion'])){
									if(is_numeric($_GET['opcion'])){
										$buscasan = $_GET['opcion'];
									}else{
										$buscasan=1;
									}
								}else{
									$buscasan=1;
								}
								$mens['tipo'] = 50;
								$data["horarios"]= $this->ModuloJornadas->ListarHorarioPaginador($BD,$buscasan-1,0,0,0);
								$data['opcion']=$buscasan;			
								$tempoCantidad = $this->ModuloJornadas->cantidadJornadas($BD,$thismonth);
								$data['cantidad'] = ceil(($tempoCantidad)/5);
						   		$data["Usuario"]=$_SESSION["Usuario"];					
								$data["Nombre"]=$_SESSION["Nombre"];
								$data["Perfil"] = $_SESSION["Perfil"];
								$data["Cliente"] = $_SESSION["Cliente"];
								$data["NombreCliente"]=$_SESSION["NombreCliente"];
								$data["Cargo"] = $_SESSION["Cargo"];
								$data['mesActual']=$hoy['mon'];	
								$data['mes']=$mes['mon'];
								$data["Clientes"]= $this->funcion_login->elegirCliente();
								$BD=$_SESSION["BDSecundaria"];
								$this->load->model("ModuloPermisos");				
								$this->load->model("ModuloPuntosVentas");
								$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
								$data["permisos"]=$this->ModuloPermisos->listarPermisos();
								$data["cantidadHorario"]=count($data['horarios']);
								$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
								$data["AnioHorario"]= $this->ModuloJornadas->ListarAnio($BD);
								$data["ListarUsuario"]= $this->ModuloJornadas->ListarUsuario($BD);
								$data["ListarFechaFuturo"]=$this->ModuloJornadas->buscarFechaFuturo($BD);
								//vistas
							    $this->load->view('contenido');
							    $this->load->view('layout/header',$data);
							    $this->load->view('layout/sidebar',$data);
							    $this->load->view('admin/adminHorarios',$data);
							    $this->load->view('layout/footer',$data);
							    $this->load->view('layout/mensajes',$mens);
							}else{
								redirect(site_url("login/inicio"));	
							}
						}else{
							redirect(site_url("login/inicio"));	
						}
			 		}
				}
			}
		}
	}

	// setTimeout(function(){
	// 								window.location = 'adminHorario';
	// 							}, 1000);

	// function prueba(){
	// 	$n=$this->session->flashdata('n');
	// 	echo $n;
	// 	if (!isset($n)) {
	// 		echo "nulo";
	// 		$n=1;
	// 		$this->session->set_flashdata('n', $n);
	// 		$this->prueba();
	// 	}
	// }	
}
	
			  


