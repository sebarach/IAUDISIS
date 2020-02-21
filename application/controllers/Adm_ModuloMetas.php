<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloMetas extends CI_Controller {
	public function __construct(){

		parent::__construct();	
		$this->load->model("funcion_login");
		$this->load->model("ModuloMetas");
		$this->load->library('upload');
	}


	function cargamasiva(){
		if($_SESSION['Perfil']==2 || $_SESSION['Perfil']==1){ 
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"] = $_SESSION["Perfil"];
			$data["Cliente"] = $_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Cargo"] = $_SESSION["Cargo"];
			$data["Clientes"]= $this->funcion_login->elegirCliente();
		    $this->load->view('contenido');
		    $this->load->view('layout/header',$data);
		   	$this->load->view('layout/sidebar',$data);
			$this->load->view('admin/adminCargaMasiva',$data);
			$this->load->view('layout/footer',$data);
		} else {
		   redirect(site_url("login"));
		}
	}

	function reporteMetasVentas(){
		if($_SESSION['Perfil']==2 || $_SESSION['Perfil']==1){ 
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"] = $_SESSION["Perfil"];
			$data["Cliente"] = $_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Cargo"] = $_SESSION["Cargo"];
			$data["Clientes"]= $this->funcion_login->elegirCliente();
			$data["Fechas"]=$this->ModuloMetas->listarFechasMetas($_SESSION["BDSecundaria"]);
		    $this->load->view('contenido');
		    $this->load->view('layout/header',$data);
		   	$this->load->view('layout/sidebar',$data);
			$this->load->view('admin/adminReporteMetasVentas',$data);
			$this->load->view('layout/footer',$data);
		} else {
		   redirect(site_url("login"));
		}
	}


	function listmetas(){
		if($_SESSION['Perfil']==2 || $_SESSION['Perfil']==1){ 
			$this->load->library('phpexcel');
			$excel = new PHPExcel();
			$excel->setActiveSheetIndex(0);
			$excel->getActiveSheet()->setTitle("Hoja1");
			$c=array("PDO","Categoria/Producto","Ponderado","Año","Mes","Meta");
			for ($i=0; $i < count($c); $i++) { 
				$excel->getActiveSheet()->setCellValueByColumnAndRow($i,1,$c[$i]);
				$excel->getActiveSheet()->getStyleByColumnAndRow($i,1)->getFont()->setBold(true);
			}
			for ($i=2; $i < 4 ; $i++) { 
				$excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,"Audisis");
				$excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,"Categoria ".($i-1)."/Producto ".($i-1));
				$excel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,($i/10));
				$excel->getActiveSheet()->getStyleByColumnAndRow(2,$i)->getNumberFormat()->setFormatCode('0.0'); 
				$excel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,date("Y"));
				$excel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,date("n"));
				$excel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,($i*1000));
			}
			foreach(range('A','C') as $columnID) {
		 		$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			ob_end_clean();
			$excel_writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
			header('Content-Disposition: attachment;filename="Formato-Masiva-Metas.xlsx"');
			header('Cache-Control: max-age=0');		
			$excel_writer->save('php://output');
		} else {
		   redirect(site_url("login"));
		}
	}

	function listventas(){
		if($_SESSION['Perfil']==2 || $_SESSION['Perfil']==1){ 
			$this->load->library('phpexcel');
			$excel = new PHPExcel();
			$excel->setActiveSheetIndex(0);
			$excel->getActiveSheet()->setTitle("Hoja1");
			$c=array("PDO","Categoria/Producto","Año","Mes","Dia","Venta");
			for ($i=0; $i < count($c); $i++) { 
				$excel->getActiveSheet()->setCellValueByColumnAndRow($i,1,$c[$i]);
				$excel->getActiveSheet()->getStyleByColumnAndRow($i,1)->getFont()->setBold(true);
			}
			for ($i=2; $i < 4 ; $i++) { 
				$excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,"Audisis");
				$excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,"Categoria ".($i-1)."/Producto ".($i-1));
				$excel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,date("Y")); 
				$excel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,date("n"));
				$excel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,date("j"));
				$excel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,($i*1000));
			}
			foreach(range('A','C') as $columnID) {
		 		$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			ob_end_clean();
			$excel_writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
			header('Content-Disposition: attachment;filename="Formato-Masiva-Metas.xlsx"');
			header('Cache-Control: max-age=0');		
			$excel_writer->save('php://output');
		} else {
		   redirect(site_url("login"));
		}

	}


	function addmetas(){
		$vacios=0;
		$mensaje="";
		if(!isset($_FILES["ex_metas"])){
			$vacios++;
		}
		if($vacios==0){
			$this->load->library('phpexcel');	
			$this->load->model("ModuloPuntosVentas");
			$this->load->library('phpexcel');
			$nombre=$_SESSION["BDSecundaria"].'_'.str_replace(' ','',date("Y-m-d"));
			move_uploaded_file($_FILES['ex_metas']['tmp_name'],'doc/metas/'.$nombre);
			$tipo = PHPExcel_IOFactory::identify("doc/metas/".$nombre);
			$objReader = PHPExcel_IOFactory::createReader($tipo);
			$object = $objReader->load("doc/metas/".$nombre);
			$object->setActiveSheetIndex(0);
			$defaultPrecision = ini_get('precision');
			ini_set('precision', $defaultPrecision);
			$fila=2;
		 	set_time_limit(600);
		 	$parametro=0;	 
		 	$error=0;	
		 	$contador=0;
	 		while($parametro==0){	
		 		if($object->getActiveSheet()->getCell('A'.$fila)->getValue()==NULL)
		 		{
		 			$parametro=1;
		 		}else{
		 			$TLocal=$object->getActiveSheet()->getCell('A'.$fila)->getValue();		 		
	 				if($TLocal==null || $TLocal==''){
	 					$parametro=1;
	 					$error=61;	
		 				break;
		 			}else{
		 				$local=$this->ModuloPuntosVentas->BuscarIdLocal($_SESSION["BDSecundaria"],$TLocal);
		 				if($local==null || $local==''){
		 					$parametro=1;
		 					$error=63;	
			 				break;
		 				}else{
		 					$Local[$contador]=$local->ID_Local;
		 				}
		 			}
		 			$TElemento=$object->getActiveSheet()->getCell('B'.$fila)->getValue();
		 			if ($TElemento==null || $TElemento=='') {
		 				$parametro=1;
	 					$error=66;	
		 				break;
		 			}else{				 				
		 				$Elemento[$contador]=$TElemento;
		 			}
		 			$TPonderado=$object->getActiveSheet()->getCell('C'.$fila)->getValue();
		 			if ($TPonderado==null || $TPonderado=='') {
		 				$Ponderado[$contador]='0';
		 			}else{				 				
		 				$Ponderado[$contador]=$TPonderado;
		 			}
		 			$TAnio=$object->getActiveSheet()->getCell('D'.$fila)->getValue();
		 			if($TAnio==null || $TAnio=='') {
		 				$parametro=1;
	 					$error=67;	
		 				break;
		 			}else{				 				
		 				$Anio[$contador]=$this->limpiarNumero($TAnio);
		 			}
		 			$TMes=$object->getActiveSheet()->getCell('E'.$fila)->getValue();
		 			if ($TMes==null || $TMes=='') {
		 				$parametro=1;
	 					$error=68;	
		 				break;
		 			}else{				 				
		 				$Mes[$contador]=$this->limpiarNumero($TMes);
		 			}
		 			$TMeta=$object->getActiveSheet()->getCell('F'.$fila)->getFormattedValue();
		 			if ($TMeta==null || $TMeta=='') {
		 				$parametro=1;
	 					$error=69;	
		 				break;
		 			}else{				 				
		 				$Meta[$contador]=str_replace(",",".",$TMeta);
		 			}
	 				$fila++;
	 				$contador++;
		 		}
			}
			$suma=0;
			if($error==0){	
    			for($i=0; $i <$contador; $i++){ 
					$cant=$this->ModuloMetas->ingresarMetas($_SESSION["BDSecundaria"],$Local[$i],$Elemento[$i],$Ponderado[$i],$Anio[$i],$Mes[$i],$Meta[$i]);
					$suma=($suma+$cant["CantidadInsertadas"]);    					
				}   
				$mens['tipo'] = 72;
				$mens['cantidad']=$suma;					
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
			    $this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			   	$this->load->view('layout/sidebar',$data);
				$this->load->view('admin/adminCargaMasiva',$data);
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
				$data["Cargo"] = $_SESSION["Cargo"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
			    $this->load->view('contenido');
			    $this->load->view('layout/header',$data);
			   	$this->load->view('layout/sidebar',$data);
				$this->load->view('admin/adminCargaMasiva',$data);
				$this->load->view('layout/footer',$data);
				$this->load->view('layout/mensajes',$mens);
			}	
		} else {
			redirect(site_url("Adm_ModuloMetas/cargamasiva"));
		}
	}

	function reportesMetas(){
    	$data["Usuario"]=$_SESSION["Usuario"];					
		$data["Nombre"]=$_SESSION["Nombre"];
		$data["Perfil"] = $_SESSION["Perfil"];
		$data["Cliente"] = $_SESSION["Cliente"];
		$data["NombreCliente"]=$_SESSION["NombreCliente"];
		$data["Cargo"] = $_SESSION["Cargo"];
		$data["Clientes"]= $this->funcion_login->elegirCliente();
	    $this->load->view('contenido');
	    $this->load->view('layout/header',$data);
	   	$this->load->view('layout/sidebar',$data);
		$this->load->view('admin/adminCargaMasiva',$data);
		$this->load->view('layout/footer',$data);
    }

	function limpiaEspacio($var){
  		$nuevo3 = preg_replace("/[' ']/", "",$var);
  		return $nuevo3;
 	}

 	function limpiarNumero($rut){
    	$patron = "/[^0-9]/i";    
        $cadena_nueva = preg_replace($patron, "", $rut);
        return $cadena_nueva; 
    }    

    function CbuscarLocalesMetas(){
		if(isset($_POST["fechas"]) && $_POST["fechas"]!=''){
			$BD=$_SESSION["BDSecundaria"];
			$fechas = $_POST["fechas"];	
			$op = explode("/", $fechas);	
			$mes=$op[0];
		 	$anio=$op[1];
			$datos=$this->ModuloMetas->MbuscarLocalesMetas($BD,$mes,$anio);    
	        if(count($datos)==0){
	            echo '';
	        } else {
	            foreach ($datos as $da) {
	                echo "<option value='".$da["ID_Local"]."' >".$da["NombreLocal"]."</option>";
	            }
	        }
	    }else{
	        echo '';
		}
	}

	function CListarDashMetas(){
		if(isset($_POST["local"]) && $_POST["local"]!=''){		
			$BDB2B=$this->ModuloMetas->buscarClienteB2B($_SESSION["Cliente"])->NombreBDB2B;			
			$BD=$_SESSION["BDSecundaria"];
			$fechas = $_POST["fechas"];	
			$local = $_POST["local"];	
			$op = explode("/", $fechas);	
			$mes=$op[0];
		 	$anio=$op[1];  
			$metas=$this->ModuloMetas->MetasB2B($BD,$local,$mes,$anio);
			$sumametas=0;
			$sumaventas=0;
			$cont=1;
			$dash="";
			echo '<script src="'.site_url().'assets/libs/raphael/raphael.min.js"></script>
					 <script src="'.site_url().'assets/libs/charts-morris-chart/morris.min.js"></script>';
			foreach ($metas as $m) {
				if(isset($BDB2B) && $BDB2B!=''){
					$ventas=$this->ModuloMetas->VentasB2B($BDB2B,$local,$mes,$anio,$m["elemento"]);	
				}else{
					$ventas["VentaMetas"]='0';
				}
				if(!isset($ventas) || $ventas==''){
					$ventas["VentaMetas"]='0';
				}
				if($ventas["VentaMetas"]<$m["meta"]){  
					$claseI='fa fa-arrow-down';
					$claseC='text-danger';
				}else{
					$claseI='fa fa-arrow-up';
					$claseC='text-success';
				}
				$porcentaje=round((($ventas["VentaMetas"]*100)/$m["meta"]),0);
				$dash.= '
                    <div class="col-md-4">
                        <div class="card card-accent-theme">
                            <div class="card-body">
                                <div class="h5 text-dark">
                                    <strong>'.$m["elemento"].'</strong>
                                </div>
                                <div class="h5 text-theme">'.$porcentaje.'% de Avance</div>
                                <div id="pie-chart-'.$cont.'"></div>

                                <div class="h6">
                                    <span class="fa fa-circle text-danger"></span> -Metas
                                    <span class="">'.str_replace('.',',',$m["meta"]).'
                                        <i class=""></i>
                                    </span>
                                </div>
                                <div class="h6">
                                    <span class="fa fa-circle text-success"></span> -Ventas
                                    <span class="'.$claseC.'">'.str_replace('.',',',$ventas["VentaMetas"]).'
                                        <i class="'.$claseI.'"></i>
                                    </span>
                                </div>


                            </div>
                        </div>
                    </div>
                <script type="text/javascript">
                	setTimeout ( function () {
						Morris.Donut({
						    element: "pie-chart-'.$cont.'",
						    data: [
						      {label: "Metas'; if($_SESSION=='26') { $dash.='(Kg)'; } $dash.='", value: parseInt('.round($m["meta"],0).'), color:"#E53D37"},
						      {label: "Ventas'; if($_SESSION=='26') { $dash.='(Kg)'; } $dash.='", value: parseInt('.round($ventas["VentaMetas"],0).'), color:"#4BE339"}
						     
						    ]
						});
					}, 500);
				 </script>';
				$sumametas=$sumametas+$m["meta"];
				$sumaventas=$sumaventas+$ventas["VentaMetas"];
				$cont++;
			}
			if($sumaventas<$sumametas){  
				$claseI='fa fa-arrow-down';
				$claseC='text-danger';
			}else{
				$claseI='fa fa-arrow-up';
				$claseC='text-success';
			}
			$porcentaje=round((($sumaventas*100)/$sumametas),0);
			echo '<div class="col-md-4">
                        <div class="card card-accent-theme">
                            <div class="card-body">
                                <div class="h5 text-dark">
                                    <strong> General </strong>
                                </div>
                                <div class="h5 text-theme">'.$porcentaje.'% de Avance</div>
                                <div id="pie-chart-'.$cont.'"></div>

                                <div class="h6">
                                    <span class="fa fa-circle text-danger"></span> -Metas
                                    <span class="">'.str_replace('.',',',$sumametas).'
                                        <i class=""></i>
                                    </span>
                                </div>
                                <div class="h6">
                                    <span class="fa fa-circle text-success"></span> -Ventas
                                    <span class="'.$claseC.'">'.str_replace('.',',',$sumaventas).'
                                        <i class="'.$claseI.'"></i>
                                    </span>
                                </div>


                            </div>
                        </div>
                    </div>
                <script type="text/javascript">
                	setTimeout ( function () {
						Morris.Donut({							
						    element: "pie-chart-'.$cont.'",
						    data: [
						      {label: "Metas'; if($_SESSION=='26') {echo '(Kg)'; } echo '", value: parseInt('.round($sumametas,0).'), color:"#E53D37"},
						      {label: "Ventas'; if($_SESSION=='26') {echo '(Kg)'; } echo '", value: parseInt('.round($sumaventas,0).'), color:"#4BE339"}
						     
						    ]
						});
					}, 500);						
				 </script>';
				echo $dash;
	    }else{
	        echo '';
		}
	}

}

?>