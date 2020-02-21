<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloElementos extends CI_Controller {
	public function __construct(){

		parent::__construct();
			$this->load->model("funcion_login");
			$this->load->library('upload');
			$this->load->library('form_validation'); 
	}

	function administrarElementos(){
		if (isset($_SESSION["sesion"])) {
			if ($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2) {
				$this->load->model("ModuloUsuario");
				$this->load->model("ModuloElemento");
				$BD=$_SESSION["BDSecundaria"];
				$data["Cluster"] = $this->ModuloElemento->listarCluster($BD);
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearCluster',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}			
		}else{
			redirect(site_url("login/inicio"));
		}
	}

	function IngExcelElemento(){
		if(isset($_FILES['excelv']['name'])){
			$excel = $this->limpiaEspacio($_FILES['excelv']['name']);
			$this->load->model("ModuloElemento");	
			$R=$this->subirArchivos($excel,0,0);
			$this->load->library('phpexcel');							
			$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
			$objReader = PHPExcel_IOFactory::createReader($tipo);
			$object = $objReader->load("archivos/archivos_Temp/".$excel);
			$object->setActiveSheetIndex(0);
			$defaultPrecision = ini_get('precision');
			ini_set('precision', $defaultPrecision);
 			set_time_limit(9600);
			$error=0;
			$parametro=0;
			$BD=$_SESSION["BDSecundaria"];	
			$nombreCluster=pathinfo($_FILES['excelv']['name']);
			$nombreClu=$this->ModuloElemento->BuscarNombreCluster($nombreCluster['filename'],$BD);
			if ($nombreClu!=null) {
				$parametro=1;
				$error=14;
			}		
			$fila=2;			
			$contador=0;			
			$suma=0;
			$id_creador=$_SESSION['Usuario'];
			$filaMaxima=$object->setActiveSheetIndex(0)->getHighestRow();
			while ($parametro==0) {
				if ($object->getActiveSheet()->getCell('B'.$fila)->getCalculatedValue()==NULL) {
					$parametro=1;
				}else{
					$local[$contador]=$object->getActiveSheet()->getCell('A'.$fila)->getFormattedValue();
					if ($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue()!=NULL) {	
						$idLocal[$contador]=$this->ModuloElemento->BuscarIdLocal($local[$contador],$BD);
						if ($idLocal[$contador]["ID_Local"]==null) {
							$error=10;
							$parametro=1;
							break;
						}else{
							$idLocal[$contador]["ID_Local"];
						}
					}else{
						$idLocal[$contador]["ID_Local"]=0;
					}

					$producto[$contador]=$object->getActiveSheet()->getCell('B'.$fila)->getFormattedValue();
					$idProducto[$contador]=$this->ModuloElemento->BuscarIdProducto($producto[$contador],$BD);
					if ($idProducto[$contador]["ID_Elemento"]==null) {
						$error=19;
						$parametro=1;
						break;
					}else{
						$idProducto[$contador]["ID_Elemento"];
					}	
					$fila++;
					$contador++;
				}
			}

				if ($error==0) {
					$idCluster[1]['ID']=$this->ModuloElemento->ingresarCluster($nombreCluster['filename'],$id_creador,$BD);
						$idC=implode($idCluster[1]['ID']);
						for ($i=0; $i <$contador; $i++) { 
	    					$cant=$this->ModuloElemento->ingresarElementoCluster($idC,$idLocal[$i]["ID_Local"],$idProducto[$i]["ID_Elemento"],$BD);
    					}

    				$mens['tipo']=39;	
	    			$this->load->model("ModuloUsuario");
					$this->load->model("ModuloElemento");
					$BD=$_SESSION["BDSecundaria"];
					$data["Cluster"] = $this->ModuloElemento->listarCluster($BD);
					$data["Cargo"] = $_SESSION["Cargo"];
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminCrearCluster',$data);
				   	$this->load->view('layout/footer',$data);
				   	$this->load->view('layout/mensajes',$mens);
				}else{
					$mens['tipo'] = $error;	
	    			$mens['cantidad']=($contador+2);
					$this->load->model("ModuloUsuario");
					$this->load->model("ModuloElemento");
					$BD=$_SESSION["BDSecundaria"];
					$data["Cluster"] = $this->ModuloElemento->listarCluster($BD);
					$data["Cargo"] = $_SESSION["Cargo"];
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminCrearCluster',$data);
				   	$this->load->view('layout/footer',$data);
				   	$this->load->view('layout/mensajes',$mens);
				}		
		}
	}

	function verCluster()
	{
		$this->load->model("ModuloElemento");
		$BD=$_SESSION["BDSecundaria"];
		if(isset($_GET['opcion'])){
			if(is_numeric($_GET['opcion']))
			{
				$buscasana = $_GET['opcion'];
			}
			else
			{
				$buscasana=1;
			}
		}
		else
		{
			$buscasana=1;
		}
		if (!isset($_GET['idClus'])) 
		{
			if (!$id_cluster=$_POST["var"]) 
			{
				redirect(site_url("Adm_ModuloElementos/administrarElementos"));
			}
			
		$id_cluster=$_POST["var"];
		$data["var_clus"]=$id_cluster;
		}
		else
		{
			$id_cluster=$_GET["idClus"];
			$data["var_clus"]=$id_cluster;
		}

		$data["clus"]=$this->ModuloElemento->ListarElementosClusterPorID($id_cluster,$buscasana,$BD);
		//$data["opcion"]=$this->ModuloElemento->ListarTotalFilasClusterXid($id_cluster,$BD);
		$data['opcion']=$buscasana;
		//$tempoCantidad = $this->ModuloElemento->cantidadElementos($BD,$id_cluster);
		$tempoCantidad = $this->ModuloElemento->ListarTotalFilasClusterXid($id_cluster,$BD);
		$data['cantidadRegistrosCluster'] = $tempoCantidad['total'];
		$data['cantidad']=ceil(($tempoCantidad['total'])/5);
		$data["Cargo"] = $_SESSION["Cargo"];
		$data["Usuario"]=$_SESSION["Usuario"];					
		$data["Nombre"]=$_SESSION["Nombre"];
		$data["Perfil"] = $_SESSION["Perfil"];
		$data["Cliente"] = $_SESSION["Cliente"];
		$data["NombreCliente"]=$_SESSION["NombreCliente"];
		$data["Clientes"]= $this->funcion_login->elegirCliente();
		$this->load->view('contenido');
		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('admin/adminVerElementos',$data);
	   	$this->load->view('layout/footer',$data);
	}


	function limpiaEspacio($var){
    	$patron = "/[' ']/i";
		$cadena_nueva = preg_replace($patron,"",$var);
		return $cadena_nueva; 
 	}

 	function IngExcelElementosSimples(){
 		if (isset($_FILES['excelv']['name'])) {
 			$excel=$this->limpiaEspacio($_FILES['excelv']['name']);
 			$R=$this->subirArchivos($excel,0,0);
 			$this->load->library('phpexcel');
 			$this->load->model("ModuloElemento");
 			$BD=$_SESSION["BDSecundaria"];
 			$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
 			$objReader = PHPExcel_IOFactory::createReader($tipo);
 			$object = $objReader->load("archivos/archivos_Temp/".$excel);
 			$object->setActiveSheetIndex(0);
 			$defaultPrecision = ini_get('precision');
 			ini_set('precision', $defaultPrecision);
 			$fila=2;
 			$error=0;
 			$contador=0;
 			set_time_limit(9600);
 			$parametro=0;
 			$id_creador=$_SESSION['Usuario'];
 			while ($parametro==0) {
 				if ($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue()==null) {
 					$parametro=1;
 				}else{
 					$nombre[$contador]=$object->getActiveSheet()->getCell('A'.$fila)->getFormattedValue();
		 			if ($nombre[$contador]==null) {
		 				$parametro=1;	 				
		 				break;
		 			}

		 			$validarElemento=$this->ModuloElemento->ValidarElemento($nombre[$contador],$BD);
		 			if ($validarElemento!=null) {
		 				$parametro=1;
		 				$error=18;
		 				break;
		 			}

		 			$categoria[$contador]=$object->getActiveSheet()->getCell('B'.$fila)->getFormattedValue();
		 			$marca[$contador]=$object->getActiveSheet()->getCell('C'.$fila)->getFormattedValue();
		 			$sku[$contador]=$object->getActiveSheet()->getCell('D'.$fila)->getFormattedValue();
 				}
 				$fila++;
 				$contador++;
 			}

 			$foto=null;
 			$suma=0;
 			if ($error==0) {
 				for ($i=0; $i <$contador-1; $i++) { 
 					$cant=$this->ModuloElemento->ingresarElemento($nombre[$i],$categoria[$i],$marca[$i],$sku[$i],$id_creador,$foto,$BD);
 				}
 				$mens['tipo'] = 16;
 				$data["Cargo"] = $_SESSION["Cargo"];
				$this->load->model("ModuloUsuario");
				$this->load->model("ModuloElemento");
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearElemento',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
 			}else{
 				$mens['tipo'] = $error;
 				$mens['cantidad']=($contador+2);
 				$data["Cargo"] = $_SESSION["Cargo"];
				$this->load->model("ModuloUsuario");
				$this->load->model("ModuloElemento");
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearElemento',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
 			}
 		}
 	}

 	function ListaElementos(){
 		if (isset($_SESSION["sesion"])) {
			if ($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2) {
				$BD=$_SESSION["BDSecundaria"];
				$this->load->model("ModuloUsuario");
				$this->load->model("ModuloElemento");
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Elementos"]=$this->ModuloElemento->listarElementos($BD);
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminListarElemento',$data);
			   	$this->load->view('layout/footer',$data);
			}
		}
 	}

 	function cambiarElemento(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["idele"])){	
				    $BD=$_SESSION["BDSecundaria"];			
					$this->load->model("ModuloElemento");
					$idEle=$_POST["idele"];
					$e=$this->ModuloElemento->listarElementosPorId($idEle,$BD);
					$estado=$_POST["estado"];
					echo "<form method='post' id='cambiarElemento' action='cambiarEstadoElementoF'>";
					if($estado==1){
						echo "<p>¿Esta Seguro que desea Desactivar el Elemento ".$e['Nombre']." ?</p>";						
					}else{
						echo "<p>¿Esta Seguro que desea Activar  el Elemento ".$e['Nombre']." ?</p>";
					}
					echo "<input type='hidden' name='txt_id_elemento' value='".$idEle."'>";
					echo "<input type='hidden' name='txt_estado' value='".$estado."'>";
					echo "</form>";
		 		}else{
					redirect(site_url("Adm_ModuloElementos/listarElemento"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}
	}	


 	function cambiarEstadoElementoF(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_id_elemento"])){
					$this->load->model("ModuloElemento");
					$BD=$_SESSION["BDSecundaria"];					
					$idEle=$_POST["txt_id_elemento"];
					$vigencia=$_POST["txt_estado"];

					$filas=$this->ModuloElemento->CambiarVigenciaElemento($idEle,$vigencia,$BD);
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
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$this->load->model("ModuloCliente");
					$data["Elementos"]=$this->ModuloElemento->listarElementos($BD);
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminListarElemento',$data);
				   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloElementos/listarElemento"));
				}
			}
		}
	}

	function EditarElemento(){
			$this->load->model("ModuloElemento");
			$BD=$_SESSION["BDSecundaria"];
			$idEle=$_POST['idele'];
			$e=$this->ModuloElemento->listarElementosPorId($idEle,$BD);
			echo "<div class='modal-header'>
                    <h6 class='modal-title' >Editar Elementos</h6>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                </div>
                <div class='modal-body'>
                	<div class='card'>
                				<div class='card-header text-theme'>
                                    Elemento: ".$e['Nombre']."
                                </div>
                                <div class='card-body'>
	                                <form id='mFrmEditarElemento' method='POST'>
	                                <input type='hidden' class='form-control' id='mtxtIdEle' name='mtxtIdEle' value='".$e['ID_Elemento']."'>
	                                <input type='hidden' class='form-control' id='mtxtVigencia' name='mtxtVigencia' value='".$e['Activo']."'>
	                                	<div class='form-group row'>
	                                		<div class='col-md-7'>
	                                		<label for='company'>Nombre Elemento</label>
	                                		<div class='input-group'>
	                                			<span class='input-group-addon'>
	                                                    <i class='fa fa-cube'></i>
	                                            </span>
	                                            <input type='text' class='form-control' id='mtxtNombreElemento' name='mtxtNombreElemento' placeholder='Nombre del Elemento' value='".$e['Nombre']."'>
		                                            <div id='merrortxtNombreElemento' style='color: red; display: none;'  >
	                                                       Debe Escribir el nombre del Elemento...
	                                                </div>
	                                                <div id='merrorElementoV' style='color: red; display: none;'  >
                                                        El Nombre del Elemento ya existe ...
                                            		</div>
	                                		</div>
	                                		</div>
	                                	</div>

	                                	<div class='form-group row'>
	                                		<div class='col-md-7'>
	                                		<label for='company'>Categoría</label>
	                                		<div class='input-group'>
	                                			<span class='input-group-addon'>
	                                                    <i class='mdi mdi-animation'></i>
	                                            </span>
	                                            <input type='text' class='form-control' id='mtxtCategoria' name='mtxtCategoria' placeholder='Categoría' value='".$e['Categoria']."'>
		                                            <div id='merrortxtCategoria' style='color: red; display: none;'  >
	                                                        Debe Escribir la categoría...
	                                                </div>
	                                                <div id='merrorCategoriaV' style='color: red; display: none;'  >
                                                        	Ya existe la categoría
                                            		</div>
	                                		</div>
	                                		</div>
	                                	</div>

	                                	<div class='form-group row'>
	                                		<div class='col-md-7'>
	                                		<label for='company'>Marca</label>
	                                		<div class='input-group'>
	                                			<span class='input-group-addon'>
	                                                    <i class='mdi mdi-basket'></i>
	                                            </span>
	                                            <input type='text' class='form-control' id='mtxtMarca' name='mtxtMarca' placeholder='Marca' value='".$e['Marca']."'>
		                                            <div id='merrortxtMarca' style='color: red; display: none;'  >
	                                                        Debe Escribir la marca...
	                                                </div>
	                                                <div id='merrorMarcaV' style='color: red; display: none;'  >
                                                        	Ya existe la marca
                                            		</div>
	                                		</div>
	                                		</div>
	                                	</div>

                                        <div class='form-group row'>
	                                		<div class='col-md-7'>
	                                		<label for='company'>Código SKU</label>
	                                		<div class='input-group'>
	                                			<span class='input-group-addon'>
	                                                    <i class='fa fa-barcode'></i>
	                                            </span>
	                                            <input type='text' class='form-control' id='mtxtCodigo' name='mtxtCodigo' placeholder='Marca' value='".$e['Cod_SKU']."'>
		                                            <div id='merrortxtCodigo' style='color: red; display: none;'  >
	                                                        Debe Escribir el código...
	                                                </div>
	                                                <div id='merrorCodigoV' style='color: red; display: none;'  >
                                                        	Ya existe el código
                                            		</div>
	                                		</div>
	                                		</div>
	                                	</div>
	                                </form>
                                </div>
                	</div>
                </div>

                <div class='modal-footer'>
                <button type='button' class='btn btn-sm btn-danger' onclick='return validarEditarElemento();' ><i id='icEditarElemento'  class=''></i> Guardar Edición</button>";
                
                echo "

                <script type='text/javascript'>

			    

                     function validarEditarElemento(){
                        if(validarIngresarElemento()==false){
                        alertify.error('Existen Campos Vacios');
                        return false;
                        }else{
                        $('#icEditarElemento').attr('class','fa fa-spin fa-circle-o-notch');
                        $.ajax({                        
                           type: 'POST',                 
                           url:'EditarElementoF',                     
                           data: $('#mFrmEditarElemento').serialize(), 
                           success: function(data)             
                           {            
                             if (data==1) {
                             $('#icEditarElemento').attr('class','');
                             alertify.error('El Elemento ya existe');
                             $('#mtxtNombreElemento').attr('class', 'form-control is-invalid');
                             $('#merrorElementoV').show(); 

                             }else if(data==0){
                                $('#icEditarElemento').attr('class','');
                             alertify.success('Elemento Editado');
                             $('#mtxtNombreElemento').val('');
                             $('#mtxtCategoria').val('');
                             $('#merrortxtMarca').val('');
                             $('#mtxtCodigo').val('');
                             $('#MEditarElementos').modal('hide');
                             setTimeout(function(){
                             window.location = 'ListaElementos';
                    		 }, 1000); 

                             }
                           }         
                       });
                    }
                  };

                   function validarIngresarElemento(){
                        var vacios=0;
                        var valido=true;
                        if($('#mtxtNombreElemento').val()==''){  
                            $('#mtxtNombreElemento').attr('class', 'form-control is-invalid');
                            $('#merrortxtNombreElemento').show(); 
                            vacios+=1;
                        } else { 
                            $('#mtxtNombreElemento').attr('class', 'form-control is-valid');  
                            $('#merrortxtNombreElemento').hide();
                            $('#merrorElementoV').hide();  
                        }

                        if($('#mtxtCategoria').val()==''){  
                            $('#mtxtCategoria').attr('class', 'form-control is-invalid');
                            $('#merrortxtCategoria').show(); 
                            vacios+=1;
                        } else { 
                            $('#mtxtCategoria').attr('class', 'form-control is-valid');  
                            $('#merrortxtCategoria').hide();
                            $('#merrorCategoriaV').hide();  
                        }

                        if($('#mtxtMarca').val()==''){  
                            $('#mtxtMarca').attr('class', 'form-control is-invalid');
                            $('#merrortxtMarca').show(); 
                            vacios+=1;
                        } else { 
                            $('#mtxtMarca').attr('class', 'form-control is-valid');  
                            $('#merrortxtMarca').hide();
                            $('#merrorCodigoV').hide();  
                        }

                        if($('#mtxtCodigo').val()==''){  
                            $('#mtxtCodigo').attr('class', 'form-control is-invalid');
                            $('#merrortxtCodigo').show(); 
                            vacios+=1;
                        } else { 
                            $('#mtxtCodigo').attr('class', 'form-control is-valid');  
                            $('#merrortxtCodigo').hide();
                            $('#merrorCodigoV').hide();  
                        }
                        if(vacios>0){ valido=false; }
                        return valido;
                      }

                </script>";
		}

		function EditarElementoF(){
			$idEle=$_POST['mtxtIdEle'];
			$vigencia=$_POST['mtxtVigencia'];
			$nombreEle=$_POST['mtxtNombreElemento'];
			$categoria=$_POST['mtxtCategoria'];
			$marca=$_POST['mtxtMarca'];
			$SKU=$_POST['mtxtCodigo'];
			$this->load->model("ModuloElemento");
			$BD=$_SESSION["BDSecundaria"];
			$existe=$this->ModuloElemento->ValidarElemento($nombreEle,$BD);
			if ($existe==null) {
				echo 0;	
				$this->ModuloElemento->EditarElementos($idEle,$vigencia,$nombreEle,$categoria,$marca,$SKU,$BD);
			}else{
				echo 1;
			}
		}

		function cambiarClusterC(){
			$this->load->model("ModuloElemento");
			$BD=$_SESSION["BDSecundaria"];
			$idCluster=$_POST["id"];
			$p=$this->ModuloElemento->listarClusterPorId($idCluster,$BD);

			$estado=$_POST["estado"];
			echo "<form method='post' id='cambiarCluster' action='cambiarClusterF'>";
			if($estado==1){
				echo "<p>¿Esta Seguro que desea Desactivar el Cluster ".$p['NombreCluster']." ?</p>";						
			}else{
				echo "<p>¿Esta Seguro que desea Activar el Cluster ".$p['NombreCluster']." ?</p>";
			}
			echo "<input type='hidden' name='txt_id_cluster' value='".$idCluster."'>";
			echo "<input type='hidden' name='txt_estado' value='".$estado."'>";
			echo "</form>";
		}

		function cambiarClusterF(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				if(isset($_POST["txt_id_cluster"])){
					$BD=$_SESSION["BDSecundaria"];
					$this->load->model("ModuloElemento");	
					$idCluster=$_POST["txt_id_cluster"];
					$vigencia=$_POST["txt_estado"];
					$filas=$this->ModuloElemento->CambiarVigenciaCluster($idCluster,$vigencia,$BD);
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
					$this->load->model("ModuloUsuario");
					$this->load->model("ModuloElemento");			
					$data["Cluster"] = $this->ModuloElemento->listarCluster($BD);
					$data["Cargo"] = $_SESSION["Cargo"];
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminCrearCluster',$data);
				   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloElementos/administrarElementos"));
				}
			}
		}
	}

	function actualizarCluster(){
		$this->load->model("ModuloElemento");	
		$BD=$_SESSION["BDSecundaria"];
		$id_cluster=$_POST["id"];
		$c=$this->ModuloElemento->listarClusterPorId($id_cluster,$BD);
		echo "<div class='form-group'>

		<p class='text-theme'>Descargar Excel para editar</p>
		<p><form method='POST' action='generarExcelEditarCluster'>  
			<input type='hidden' id='txt_id_cluster' name='txt_id_cluster' value='".$id_cluster."'>               
			<button type='submit' class='btn btn-theme' title='Descargar Plantilla'><i class='mdi mdi-file-excel'></i> Descargar Plantilla</button>
			</form>
			</p>
			<hr>
            		<h7 style='color: red;'>Cluster ".$c["NombreCluster"].".</h7> 
            		<br>
            	<label for='street'>Recuerde que para actualizar el cluster el nombre debe ser igual.</label>
                <div class='btn btn-theme'><i class='mdi mdi-alarm-plus'></i> Selecione Excel para Ingresar <i id='ingresarExcelSpin' class=''></i> 
                    <form action='ActualizarClusterMasivo' method='POST' id='IngresarExcelCluster' name='IngresarExcelCluster' enctype='multipart/form-data' >                    
                        <input type='file' class='btn btn-xs btn-dark' id='excelv' name='excelv'>
                        <input type='hidden' name='txt_id_cluster' value='".$id_cluster."'>
                    </form>
                </div>                     
        	  </div>
        	  ";
	}

	function ActualizarClusterMasivo(){	
		$nombreCluster=pathinfo($_FILES['excelv']['name']);
		$BD=$_SESSION["BDSecundaria"];
		$id_cluster=$_POST["txt_id_cluster"];
		$this->load->model("ModuloElemento");				
		$excel=$this->limpiaEspacio($_FILES['excelv']['name']);
		$R=$this->subirArchivos($excel,0,0);
		$this->load->library('phpexcel');
		$this->load->model("ModuloElemento");   
		//Pruebas en local , colocar ruta de descarga en C:
		//C:/Users/Administrador/Downloads/ 	 
		$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
		$objReader = PHPExcel_IOFactory::createReader($tipo);
		$object = $objReader->load("archivos/archivos_Temp/".$excel);
		$object->setActiveSheetIndex(0);
		$defaultPrecision = ini_get('precision');
		ini_set('precision', $defaultPrecision);
		$error=0;
		$parametro=0;
		$BD=$_SESSION["BDSecundaria"];	
		$nombreCluster=pathinfo($_FILES['excelv']['name']);
		$fila=2;			
		$contador=0;			
		$suma=0;
		$id_creador=$_SESSION['Usuario'];
		$filaMaxima=$object->setActiveSheetIndex(0)->getHighestRow();
		while ($parametro==0) {
			if ($object->getActiveSheet()->getCell('B'.$fila)->getCalculatedValue()==NULL) {
				$parametro=1;
			}else{
				$local[$contador]=$object->getActiveSheet()->getCell('A'.$fila)->getFormattedValue();
					if ($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue()!=NULL) {	
						$idLocal[$contador]=$this->ModuloElemento->BuscarIdLocal($local[$contador],$BD);
						if ($idLocal[$contador]["ID_Local"]==null) {
							$error=10;
							$parametro=1;
							break;
						}else{
							$idLocal[$contador]["ID_Local"];
						}
					}else{
						$idLocal[$contador]["ID_Local"]=0;
					}
					$producto[$contador]=$object->getActiveSheet()->getCell('B'.$fila)->getFormattedValue();
					$idProducto[$contador]=$this->ModuloElemento->BuscarIdProducto($producto[$contador],$BD);
					if ($idProducto[$contador]["ID_Elemento"]==null) {
						$error=19;
						$parametro=1;
						break;
					}else{
						$idProducto[$contador]["ID_Elemento"];
					}	
					$fila++;
					$contador++;
					}
				}	
			if ($error==0) {
					$this->ModuloElemento->desactivarElementosCluster($id_cluster,$BD);
					for ($i=0; $i <$contador; $i++) { 
    					$cant=$this->ModuloElemento->editarElementoCluster($id_cluster,$idLocal[$i]["ID_Local"],$idProducto[$i]["ID_Elemento"],$BD);
					}
				$mens['tipo']=24;	
    			$this->load->model("ModuloUsuario");
				$this->load->model("ModuloElemento");
				$BD=$_SESSION["BDSecundaria"];
				$data["Cluster"] = $this->ModuloElemento->listarCluster($BD);
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearCluster',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
			}else{
				$mens['tipo'] = $error;	
    			$mens['cantidad']=($contador+2);
				$this->load->model("ModuloUsuario");
				$this->load->model("ModuloElemento");
				$BD=$_SESSION["BDSecundaria"];
				$data["Cluster"] = $this->ModuloElemento->listarCluster($BD);
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearCluster',$data);
			   	$this->load->view('layout/footer',$data);
			   	$this->load->view('layout/mensajes',$mens);
			}						
	}

	function generarExcelEditarCluster(){
		$id_cluster=$_POST["txt_id_cluster"];
		$BD=$_SESSION["BDSecundaria"];
		$this->load->library('phpexcel');
		 $this->load->model("ModuloPuntosVentas");   
		 //$this->load->model("ModuloTarea");
		 $this->load->model("ModuloElemento");
		 if(isset($_GET['opcion']))
		 {
			 if(is_numeric($_GET['opcion'])){
				 $buscasana = $_GET['opcion'];
			 }
			 else
			 {
				 $buscasana=1;
			 }
		 }
		 else
		 {
			 $buscasana=1;
		 }
		 $cluster=$this->ModuloElemento->ListarElementosClusterPorID2($id_cluster,$BD);
		 $objReader = PHPExcel_IOFactory::createReader('Excel2007');
		 $object = $objReader->load("doc/plantilla/PlantillaElementosEjemplo.xlsx");
		 $locales=$this->ModuloElemento->cargarLocales($BD);
		 $productos=$this->ModuloElemento->listarElementos($BD);
		 $object->setActiveSheetIndex(0);
		 $column_row=2;
		 foreach($cluster as $rowA)
		 {	
			 $object->getActiveSheet()->setCellValueByColumnAndRow(0,$column_row, $rowA['NombreLocal']);
			 $object->getActiveSheet()->setCellValueByColumnAndRow(1,$column_row, $rowA['Nombre']);
			 $column_row++;          
		 }
		 $column_row=1;
		 $object->setActiveSheetIndex(1);
		 foreach($locales as $row)
		 {	
			 $object->getActiveSheet()->setCellValueByColumnAndRow(0,$column_row,$row['NombreLocal']);
			 $column_row++;          
		 }
		 $column_row=1;
		 $object->setActiveSheetIndex(2);
		 foreach ($productos as $rowU) {
			 $object->getActiveSheet()->setCellValueByColumnAndRow(0,$column_row, $rowU['Nombre']);
			 $column_row++;
		 }
		 $object->setActiveSheetIndex(0);
		 header('Content-Type: application/vnd.ms-excel');
		 header('Content-Disposition: attachment;filename="PlantillaElementosEjemplo.xls"');
		 header('Cache-Control: max-age=0');
		 $objWriter = PHPExcel_IOFactory::createWriter($object,'Excel5');
		 ob_end_clean();
		 $objWriter->save('php://output');
	}
 
	
 

	function administrarLocales(){
		if (isset($_SESSION["sesion"])) {
			if ($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2) {
				$this->load->model("ModuloUsuario");
				$this->load->model("ModuloElemento");
				$BD=$_SESSION["BDSecundaria"];
				$data["Cargo"]=$_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"]=$_SESSION["Perfil"];
				$data["Cliente"]=$_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["ClusterLocal"]=$this->ModuloElemento->cargarClusterLocal($BD);
				$data["Clientes"]=$this->funcion_login->elegirCliente();
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminClusterLocal',$data);
			   	$this->load->view('layout/footer',$data);
			}
		}
	}

	function IngExcelClusterLocal(){
		if (isset($_SESSION["sesion"])) {
			if ($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2) {			
				if (isset($_FILES['excelv']['name'])) {
		 			$excel=$this->limpiaEspacio($_FILES['excelv']['name']);
		 			$R=$this->subirArchivos($excel,0,0);
		 			$this->load->library('phpexcel');
		 			$this->load->model("ModuloElemento");
		 			$BD=$_SESSION["BDSecundaria"];
		 			$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
		 			$objReader = PHPExcel_IOFactory::createReader($tipo);
		 			$object = $objReader->load("archivos/archivos_Temp/".$excel);
		 			$object->setActiveSheetIndex(0);
		 			$defaultPrecision = ini_get('precision');
		 			ini_set('precision', $defaultPrecision);
		 			$parametro=0;
		 			$error=0;
		 			$nombreCluster=pathinfo($_FILES['excelv']['name']);
		 			$nombreClu=$this->ModuloElemento->BuscarNombreClusterLocal($nombreCluster['filename'],$BD);
					if ($nombreClu!=null) {
						$parametro=1;
						$error=14;
					}
		 			$fila=2; 			
		 			$contador=0;
		 			set_time_limit(9600);	 			
		 			$id_creador=$_SESSION['Usuario'];
		 			while ($parametro==0) {
						if ($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue()==NULL) {
							$parametro=1;
						}else{
							$local[$contador]=$object->getActiveSheet()->getCell('A'.$fila)->getValue();
							$id_local[$contador]=$this->ModuloElemento->BuscarIDLocal($local[$contador],$BD);
							if ($id_local[$contador]==null) {
								$parametro=1;
								$error=10;
							}
							$fila++;
							$contador++;
						}
					}
					if ($error==0) {
						$idCluster[1]['ID']=$this->ModuloElemento->ingresarClusterLocal($nombreCluster['filename'],$id_creador,$BD);
						$idC=implode($idCluster[1]['ID']);
						for ($i=0; $i <$contador; $i++) { 
    					$cant=$this->ModuloElemento->ingresarLocalesCluster($idC,$id_local[$i]["ID_Local"],$BD);
						}
							$mens['tipo']=39;
							$this->load->model("ModuloUsuario");
							$this->load->model("ModuloElemento");
							$BD=$_SESSION["BDSecundaria"];
							$data["Cargo"] = $_SESSION["Cargo"];
							$data["Usuario"]=$_SESSION["Usuario"];					
							$data["Nombre"]=$_SESSION["Nombre"];
							$data["Perfil"] = $_SESSION["Perfil"];
							$data["Cliente"] = $_SESSION["Cliente"];
							$data["NombreCliente"]=$_SESSION["NombreCliente"];
							$data["ClusterLocal"]=$this->ModuloElemento->cargarClusterLocal($BD);
							$data["Clientes"]= $this->funcion_login->elegirCliente();
							$this->load->view('contenido');
							$this->load->view('layout/header',$data);
				   			$this->load->view('layout/sidebar',$data);
				   			$this->load->view('admin/adminClusterLocal',$data);
						   	$this->load->view('layout/footer',$data);	
						   	$this->load->view('layout/mensajes',$mens);
						}else{	
							$mens['tipo'] = $error;	
    						$mens['cantidad']=($contador+1);	
    						$this->load->model("ModuloUsuario");
							$this->load->model("ModuloElemento");
							$BD=$_SESSION["BDSecundaria"];
							$data["Cargo"] = $_SESSION["Cargo"];
							$data["Usuario"]=$_SESSION["Usuario"];					
							$data["Nombre"]=$_SESSION["Nombre"];
							$data["Perfil"] = $_SESSION["Perfil"];
							$data["Cliente"] = $_SESSION["Cliente"];
							$data["NombreCliente"]=$_SESSION["NombreCliente"];
							$data["ClusterLocal"]=$this->ModuloElemento->cargarClusterLocal($BD);
							$data["Clientes"]= $this->funcion_login->elegirCliente();
							$this->load->view('contenido');
							$this->load->view('layout/header',$data);
				   			$this->load->view('layout/sidebar',$data);
				   			$this->load->view('admin/adminClusterLocal',$data);
						   	$this->load->view('layout/footer',$data);	
						   	$this->load->view('layout/mensajes',$mens);								
						}
		 			}
				}
			}
		}

		function ActivarCluster(){
			if(isset($_SESSION["sesion"])){
				if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
					if(isset($_POST["idcluster"])){
						$this->load->model("ModuloElemento");
						$BD=$_SESSION["BDSecundaria"];	
						$idcluster=$_POST["idcluster"];
						$c=$this->ModuloElemento->listarClusterLocalID($BD,$idcluster);
						$estado=$c["Activo"];					
						echo "<form method='post' id='cambiarCluster' action='cambiarEstadoClusterF'>";
						if ($estado==1) {
							echo "<p>¿Esta Seguro que desea Desactivar la Tarea ".$c['Nombre_Cluster_Local']." ?</p>";
						}else{
							echo "<p>¿Esta Seguro que desea Activar la Tarea ".$c['Nombre_Cluster_Local']." ?</p>";
						}
						echo "<input type='hidden' name='txt_id_cluster' value='".$idcluster."'>";
						echo "<input type='hidden' name='txt_estado' value='".$estado."'>";
						echo "</form>";
					}else{
						redirect(site_url("Adm_ModuloElementos/administrarLocales"));
					}
				}else{
					redirect(site_url("login/inicio"));
				}
			}
		}

		function cambiarEstadoClusterF(){			
			if(isset($_SESSION["sesion"])){
				if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
					if(isset($_POST["txt_id_cluster"])){
						$this->load->model("ModuloElemento");
						$BD=$_SESSION["BDSecundaria"];					
						$idcluster=$_POST["txt_id_cluster"];
						$vigencia=$_POST["txt_estado"];
						$filas=$this->ModuloElemento->CambiarVigenciaClusterLocal($idcluster,$vigencia,$BD);
						$this->load->model("ModuloUsuario");
						$this->load->model("ModuloElemento");
						$BD=$_SESSION["BDSecundaria"];
						$data["Cargo"] = $_SESSION["Cargo"];
						$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["ClusterLocal"]=$this->ModuloElemento->cargarClusterLocal($BD);
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$this->load->view('contenido');
						$this->load->view('layout/header',$data);
			   			$this->load->view('layout/sidebar',$data);
			   			$this->load->view('admin/adminClusterLocal',$data);
					   	$this->load->view('layout/footer',$data);	
					}else{
						redirect(site_url("Adm_ModuloElementos/administrarLocales"));
					}
				}
			}
		}

		function verClusterLocal(){
			$BD=$_SESSION["BDSecundaria"];
			if(isset($_SESSION["sesion"])){
				if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
					$this->load->model("ModuloElemento");

					if(isset($_GET['opcion'])){
						if(is_numeric($_GET['opcion']))
						{
							$buscasana = $_GET['opcion'];
						}
						else
						{
							$buscasana=0;
						}
					}
					else
					{
						$buscasana=0;
					}
					if(!isset($_GET['idClus']))
					{
						if (!$id_cluster=$_POST["var"]) 
						{
							redirect(site_url("Adm_ModuloElementos/administrarLocales"));
						}
						
					$id_cluster=$_POST["var"];
					$data["var_clus"]=$id_cluster;
					}
					else
					{
						$id_cluster=$_GET["idClus"];
						$data["var_clus"]=$id_cluster;
					}
					//$id_cluster=$_POST["var"];
					//$data["ListaLocales"]=$this->ModuloElemento->cargarLocalClusterID($id_cluster,$BD);
					$data["ListaLocales"]=$this->ModuloElemento->cargarLocalClusterIDSeba($id_cluster,$buscasana,$BD);
					//die(var_dump($data["ListaLocales"]));
					$totalfilas=$this->ModuloElemento->listarClusterCantidadLocales($id_cluster,$BD);
					$data['total']=$totalfilas['total'];
					$data['cantidad']=ceil(($totalfilas['total'])/20)-1;
					$data['opcion']=$buscasana;
					$data["Cargo"] = $_SESSION["Cargo"];
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
					$this->load->view('layout/sidebar',$data);
					$this->load->view('admin/adminVerClusterLocal',$data);
				   	$this->load->view('layout/footer',$data);
				   }
				   else
				   {
	   				redirect(site_url("Adm_ModuloElementos/administrarLocales"));
	   			}
			}
		}

		function actualizarClusterLocal(){
			$this->load->model("ModuloElemento");	
			$BD=$_SESSION["BDSecundaria"];
			$id_cluster=$_POST["id"];
			echo "<div class='modal-body'>
                	<p class='text-theme'>Descargar Excel para editar</p>
                	<p><form method='POST' action='generarExcelEditarLocal'>  
                		<input type='hidden' id='txt_id_cluster' name='txt_id_cluster' value='".$id_cluster."'>               
			            <button type='submit' class='btn btn-theme' title='Descargar Plantilla'><i class='mdi mdi-file-excel'></i> Descargar Plantilla</button>
			            </form></p>
                        <hr>
                    <p class='text-theme'>Ingresar Excel Editado</p>
                    <p>
                        <label for='street'>Recuerde ingresar el Excel descargado mas arribo para finalizar la edición.</label>
                        <form action='ActualizarLocalMasivo' method='POST' id='IngresarExcelLocal' name='IngresarExcelLocal' enctype='multipart/form-data'>
               			<div class='btn btn-theme' style='margin-bottom:20px;'><i class='mdi mdi-alarm-plus'></i><i id='ingresarExcelSpin' class=''></i> 
	                		<input type='hidden' id='txt_id_cluster' name='txt_id_cluster' value='".$id_cluster."'> 
	                			<input type='file' class='btn btn-xs btn-dark' id='excelv' name='excelv'>   
	                	</div>
	                	<div class='modal-footer'>
		                    <button type='submit' class='btn btn-danger'>Actualizar Excel</button>
		                    <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
		                </div>                     		
        		</form>";
		}

		function DescargaExcelClusterElemento(){
			$this->load->model("ModuloElemento");
			$this->load->library('phpexcel');
			$BD=$_SESSION["BDSecundaria"];
			$objReader=PHPExcel_IOFactory::createReader('Excel2007');
			$object=$objReader->load("doc/plantilla/PlantillaElementosEjemplo.xlsx");
			$object->setActiveSheetIndex(0);
			$locales=$this->ModuloElemento->cargarLocales($BD);
			$productos=$this->ModuloElemento->listarElementos($BD);
			$object->setActiveSheetIndex(1);
			$column_row=1;
			foreach ($locales as $loc) {
				$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $loc['NombreLocal']);
				$column_row++;	
			}
			$column_row=1;
			$object->setActiveSheetIndex(2);
			foreach ($productos as $prod) {
				$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $prod['Nombre']);
				$column_row++;	
			}
			$object->setActiveSheetIndex(0);
	 		header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="PlantillaElementosEjemplo.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
			ob_end_clean();
			$objWriter->save('php://output');		
		}

		function generarExcelEditarLocal(){		
			$id_cluster=$_POST["txt_id_cluster"];
			$this->load->model("ModuloElemento");
			$this->load->library('phpexcel');
			$BD=$_SESSION["BDSecundaria"];
			$objReader=PHPExcel_IOFactory::createReader('Excel2007');
			$object=$objReader->load("doc/plantilla/PlantillaClusterLocal.xlsx");
			$object->setActiveSheetIndex(0);
			$locales=$this->ModuloElemento->cargarLocales($BD);
			$cluster_local=$this->ModuloElemento->cargarExcelClusterLocal($BD,$id_cluster);
			$column_row=2;
			foreach($cluster_local as $rowC){	 
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(0,$column_row, $rowC['NombreLocal']);
		 		$column_row++;	 		
	 		}
	 		$column_row=2;
	 		$object->setActiveSheetIndex(1);
	 		foreach($locales as $rowL){	 
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $rowL['NombreLocal']);
		 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $rowL['Direccion']);
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

		function ActualizarLocalMasivo(){			
			$BD=$_SESSION["BDSecundaria"];
			$id_cluster=$_POST["txt_id_cluster"];
			$this->load->model("ModuloElemento");
			$this->load->library('phpexcel');
	    	$excel=$this->limpiaEspacio($_FILES['excelv']['name']);
			$R=$this->subirArchivos($excel,0,0);
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
			while ($parametro==0) {
				if ($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue()==NULL) {
				$parametro=1;
				}else{
					$local[$contador]=$object->getActiveSheet()->getCell('A'.$fila)->getFormattedValue();
					$id_local[$contador]=$this->ModuloElemento->BuscarIDLocal($local[$contador],$BD);
					if ($id_local[$contador]==null) {
						$parametro=1;
						$error=10;
					}
					$contador++;
					$fila++;
				}
			}

			if($error==0){
			$this->ModuloElemento->desactivarClusterLocal($id_cluster,$BD);
			for ($i=0; $i <$contador; $i++) { 
				$cant=$this->ModuloElemento->actualizarLocalCluster($id_cluster,$id_local[$i]["ID_Local"],$BD);
				}
				$mens['tipo']=24;
				$this->load->model("ModuloUsuario");
				$this->load->model("ModuloElemento");
				$BD=$_SESSION["BDSecundaria"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["ClusterLocal"]=$this->ModuloElemento->cargarClusterLocal($BD);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminClusterLocal',$data);
			   	$this->load->view('layout/footer',$data);	
			   	$this->load->view('layout/mensajes',$mens);
			}else{
				$this->load->model("ModuloUsuario");
				$this->load->model("ModuloElemento");
				$BD=$_SESSION["BDSecundaria"];
				$mens['tipo'] = $error;	
				$mens['cantidad']=($contador+1);
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["ClusterLocal"]=$this->ModuloElemento->cargarClusterLocal($BD);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminClusterLocal',$data);
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

	function creacionElemento(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$data["Cargo"] = $_SESSION["Cargo"];
				$this->load->model("ModuloUsuario");
				$this->load->model("ModuloElemento");
				$BD=$_SESSION["BDSecundaria"];
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearElemento',$data);
			   	$this->load->view('layout/footer',$data);			   	
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function listarElemento(){
		$data["Usuario"]=$_SESSION["Usuario"];					
		$data["Nombre"]=$_SESSION["Nombre"];
		$data["Cargo"] = $_SESSION["Cargo"];
		$data["Perfil"] = $_SESSION["Perfil"];
		$data["Cliente"]=$_SESSION["Cliente"];
		$data["NombreCliente"]=$_SESSION["NombreCliente"];
		$this->load->model("ModuloElemento");
		$BD=$_SESSION["BDSecundaria"];
		$data["Clientes"]= $this->funcion_login->elegirCliente();
		$data["ListarElemento"]=$this->ModuloElemento->listarElementosTotales($BD);
		$this->load->view('contenido');
		$this->load->view('layout/header',$data);
		$this->load->view('layout/sidebar',$data);
		$this->load->view('admin/adminListarElemento',$data);
	   	$this->load->view('layout/footer',$data);	
	}

	

	

	function validarCreacionElemento(){	
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
				echo '<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>';
				$this->load->model("ModuloElemento");
				$BD=$_SESSION["BDSecundaria"];
				$nombre=$_POST['txt_elemento'];
				$categoria=$_POST['txt_categoria'];
				$marca=$_POST['txt_marca'];
				$sku=$_POST['txt_sku'];		
				$id_creador=$_SESSION['Usuario'];
				$name=$_FILES["txt_foto"]["name"];
				if ($_FILES["txt_foto"]["name"]!="") {				
					$tipo=str_replace("image/",".",$_FILES['txt_foto']['type']);
				  	$direction ='archivos/foto_elemento/'.$name.$id_creador.$tipo;
				  	$max_ancho = 800;
					$max_alto = 600;
					$rtOriginal=$_FILES["txt_foto"]['tmp_name'];
					if($_FILES['txt_foto']['type']=='image/jpeg'){
						$original = imagecreatefromjpeg($rtOriginal);
					} else if($_FILES['txt_foto']['type']=='image/png'){
						$original = imagecreatefrompng($rtOriginal);
					} else if($_FILES['txt_foto']['type']=='image/gif'){
						$original = imagecreatefromgif($rtOriginal);
					} else if($_FILES['txt_foto']['type']=='image/jpg'){
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
					if($_FILES['txt_foto']['type']=='image/jpeg'){
						imagejpeg($lienzo,$direction);
					} else if($_FILES['txt_foto']['type']=='image/png'){
						imagepng($lienzo,$direction);
					} else if($_FILES['txt_foto']['type']=='image/gif'){
						imagegif($lienzo,$direction);
					} else if($_FILES['txt_foto']['type']=='image/jpg'){
						imagejpeg($lienzo,$direction);
					}
				}else{
					$direction="archivos/foto_elemento/ej.png";
				}
				if ($nombre!=null) {
					$var = $this->ModuloElemento->listarElementos($BD);
					$count = 0;
					foreach ($var as $v) {
						if (trim($v['Nombre'])==$nombre) {
							$count=$count+1;					
						}
					}
					if ($count>0) {
						$mens['tipo']=15;
						$data["Cargo"] = $_SESSION["Cargo"];
						$this->load->model("ModuloUsuario");
						$this->load->model("ModuloElemento");
						$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"]=$_SESSION["Perfil"];
						$data["Cliente"]=$_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["Clientes"]=$this->funcion_login->elegirCliente();
						$this->load->view('contenido');
						$this->load->view('layout/header',$data);
			   			$this->load->view('layout/sidebar',$data);
			   			$this->load->view('admin/adminCrearElemento',$data);
					   	$this->load->view('layout/footer',$data);
					   	$this->load->view('layout/mensajes',$mens);
					}else{
						$this->ModuloElemento->ingresarElemento($nombre,$categoria,$marca,$sku,$id_creador,$direction,$BD);
						$mens['tipo']=16;
						$data["Cargo"] = $_SESSION["Cargo"];
						$this->load->model("ModuloUsuario");
						$this->load->model("ModuloElemento");
						$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"]=$_SESSION["Perfil"];
						$data["Cliente"]=$_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$data["Clientes"]=$this->funcion_login->elegirCliente();
						$this->load->view('contenido');
						$this->load->view('layout/header',$data);
			   			$this->load->view('layout/sidebar',$data);
			   			$this->load->view('admin/adminCrearElemento',$data);
					   	$this->load->view('layout/footer',$data);
					   	$this->load->view('layout/mensajes',$mens);
					}
			    }else{
					redirect(site_url("mantenedores/creacionElemento"));
				}						
			}
		}
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

	function limpiarComilla($rut){
    	$patron = "/['’]/i";    
        $cadena_nueva = preg_replace($patron, "", $rut);
        return $cadena_nueva; 
    }
	
}
