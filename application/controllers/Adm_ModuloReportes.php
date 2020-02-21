<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloReportes extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("funcion_login");
		$this->load->model("ModuloReportes");
	}

	function listarLibroAsistencia(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$this->load->model("ModuloPuntosVentas");		
				$this->load->model("ModuloUsuario");
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];				
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Cargo"] = $_SESSION["Cargo"];
				$BD=$_SESSION["BDSecundaria"];
				$data["Cadenas"]=$this->ModuloPuntosVentas->listarCadenasActivos($BD);
				$data["Fechas"]= $this->ModuloReportes->FechasLibroAsistenciaMes($BD,00);
				$data["Usuarios"]= $this->ModuloUsuario->listarUsuariosActivos($_SESSION["Cliente"]);
				$data["AsignadoNotificacion"]=$this->ModuloUsuario->cargarBotonAsignado($_SESSION["Usuario"],9,$_SESSION["Cliente"]);
				$data["Asignado"]=$this->ModuloUsuario->cargarModuloAsignado($_SESSION["Usuario"]);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminLibroAsistencia',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function listarLibroAsistenciaFiscalizador(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==4){ 
				$this->load->model("ModuloPuntosVentas");		
				$this->load->model("ModuloUsuario");
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];				
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Cargo"] = $_SESSION["Cargo"];
				$BD=$_SESSION["BDSecundaria"];
				$data["Cadenas"]=$this->ModuloPuntosVentas->listarCadenasActivos($BD);
				$data["Fechas"]= $this->ModuloReportes->FechasLibroAsistenciaMes($BD,00);
				$data["Usuarios"]= $this->ModuloUsuario->listarUsuariosActivos($_SESSION["Cliente"]);
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			// $this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/fiscalizadorLibroAsistencia',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function elegirCadena(){
		if(isset($_POST["cad"]) && $_POST["cad"]!=''){
			$this->load->model("ModuloPuntosVentas");		
			$BD=$_SESSION["BDSecundaria"];
			$cadena = $_POST["cad"];		
			$datos=$this->ModuloPuntosVentas->buscarLocalCadena($cadena,$BD);    
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

	function ExportarLibroAsistenciaPorMes(){		
	 	//variables fijas
	 	$info=$_POST["txt_libro"];
	 	$op = explode("/", $info);
	 	if(isset($_POST["txt_nombre"])){
	 		$nombre=$_POST["txt_nombre"];
	 	}else{
	 		$nombre=" ";
	 	}
	 	if(isset($_POST["txt_apellidoP"])){
	 		$apellidoP=$_POST["txt_apellidoP"];
	 	}else{
	 		$apellidoP=" ";
	 	}
	 	if(isset($_POST["txt_rut"])){
	 		$rut=$_POST["txt_rut"];
	 	}else{
	 		$rut=" ";
	 	}
	 	if(isset($_POST["lb_cadena"]) && $_POST["lb_cadena"]!=-1){
	 		$cadena=$_POST["lb_cadena"];
	 	}else{
	 		$cadena="00";
	 	}
	 	if(isset($_POST["lb_local"])  && $_POST["lb_local"]!=-1){
	 		$local=$_POST["lb_local"];
	 	}else{
	 		$local="00";
	 	}
	 	if(isset($_POST["lb_usuarios"])){
	 		$usuarios="";
	 		$tempo=$_POST["lb_usuarios"];
	 		foreach ($tempo as $p) {
	 			$usuarios .= $p."/";
	 		}
	 	}else{
	 		$usuarios="00";
	 	}
	 	$opcion=$_POST["txt_eleccion"];
	 	if($opcion==1){
	 		if($_POST["txt_rango30"]==2){
		 		if($op[0]=="1"){
		 			$mesAnterior="12";
		 			$anioAnterior=($op[1]-1);
		 		}else{
		 			$mesAnterior=($op[0]-1);
		 			$anioAnterior=$op[1];
		 		}
		 	}else{
		 		$mesAnterior=$op[0];
		 		$anioAnterior=$op[1];
	 		}
	 	}elseif($opcion==2){
	 		$mesAnterior=$op[0];
		 	$anioAnterior=$op[1];
	 	}elseif($opcion==3){
	 		$mesAnterior=$op[0];
	 		$anioAnterior=($op[1]-1);
	 	}elseif($opcion==4){
	 		$mesAnterior=$op[0];
		 	$anioAnterior=$op[1];
	 	}elseif($opcion==5){
	 		$mesAnterior=$op[0];
		 	$anioAnterior=$op[1];
	 	}elseif($opcion==6){
	 		$mesAnterior=$op[0];
		 	$anioAnterior=$op[1];
	 	}elseif($opcion==7){
	 		$mesAnterior=$op[0];
		 	$anioAnterior=$op[1];
	 	}else{
	 		redirect(site_url("menu"));
	 	}	 	
	 	
	 	$BD=$_SESSION["BDSecundaria"];

	 	if($opcion==1){
	 		$datos=$this->ModuloReportes->LibroAsistenciaMes($BD,$op[0],$op[1],$mesAnterior,$anioAnterior,$nombre,$apellidoP,$rut,$cadena,$local,$usuarios);
	 		if(isset($datos[0])){
	 			$this->ExportarPDFLibroAsistenciaGeneral($datos,'00');
	 		}else{
	 			echo "<script type='text/javascript'>alert('Sin Información Disponible');window.close();</script>";
	 		}
	 	}elseif($opcion==2){
 			$datos=$this->ModuloReportes->LibroAsistenciaMes($BD,$op[0],$op[1],$mesAnterior,$anioAnterior,$nombre,$apellidoP,$rut,$cadena,$local,$usuarios);
 			if(isset($datos[0])){
	 			$this->ExportarPDFExceso($datos);
	 		}else{
	 			echo "<script type='text/javascript'>alert('Sin Información Disponible');window.close();</script>";
	 		} 			
	 	}elseif($opcion==3){
	 		$datos=$this->ModuloReportes->LibroAsistenciaDF($BD,$op[0],$op[1],$mesAnterior,$anioAnterior,$nombre,$apellidoP,$rut,$cadena,$local,$usuarios);
	 		if(isset($datos[0])){
	 			$this->ExportarPDFLibroAsistenciaGeneral($datos,'00');
	 		}else{
	 			echo "<script type='text/javascript'>alert('Sin Información Disponible');window.close();</script>";
	 		}
	 	}elseif($opcion==4){
	 		$datos=$this->ModuloReportes->LibroModificacionHorarios($BD,$op[0],$op[1],$mesAnterior,$anioAnterior,$nombre,$apellidoP,$rut,$cadena,$local,$usuarios);
	 		if(isset($datos[0])){
	 			$this->ExportarPDFLibroModificacionHorarios($datos);
	 		}else{
	 			echo "<script type='text/javascript'>alert('Sin Información Disponible');window.close();</script>";
	 		}
	 	}elseif($opcion==5){
 			$datos=$this->ModuloReportes->LibroAsistenciaMes($BD,$op[0],$op[1],$mesAnterior,$anioAnterior,$nombre,$apellidoP,$rut,$cadena,$local,$usuarios);
 			if(isset($datos[0])){
	 			$this->ExportarPDFExceso($datos);
	 		}else{
	 			echo "<script type='text/javascript'>alert('Sin Información Disponible');window.close();</script>";
	 		} 			
	 	}elseif($opcion==6){
 			$datos=$this->ModuloReportes->LibroAsistenciaMes($BD,$op[0],$op[1],$mesAnterior,$anioAnterior,$nombre,$apellidoP,$rut,$cadena,$local,$usuarios);
 			if(isset($datos[0])){
	 			$this->ExportarExcelGeneral($datos);
	 		}else{
	 			echo "<script type='text/javascript'>alert('Sin Información Disponible');window.close();</script>";
	 		} 			
	 	}elseif($opcion==7){
	 		$datos=$this->ModuloReportes->LibroAsistenciaMes($BD,$op[0],$op[1],$mesAnterior,$anioAnterior,$nombre,$apellidoP,$rut,$cadena,$local,$usuarios);
	 		$datos2=$this->ModuloReportes->LibroAsistenciaMarcaPromedio($BD,$op[0],$op[1],$nombre,$apellidoP,$rut,$cadena,$local,$usuarios);
	 		if(isset($datos[0])){
	 			$this->ExportarPDFLibroAsistenciaGeneral($datos,$datos2);
	 		}else{
	 			echo "<script type='text/javascript'>alert('Sin Información Disponible');window.close();</script>";
	 		}	 		
	 	}else{
	 		redirect(site_url("menu"));
	 	}
	}

	function ExportarExcelGeneral($datos){
		$this->load->library('phpexcel');	 	
 		$object = new PHPExcel();
 		$object->setActiveSheetIndex(0);
 		$table_columns = array("Nombre", "Rut","Dia", "Fecha", "Turno", "Marca de entrada a jornada", "Localización marca de entrada", "Marca de salida de jornada", "Localización marca de salida", "Horas de atraso","Horas de adelanto","Inicio de colación","Fin de colación","Tiempo en colación","Horas trabajadas","Horas no trabajadas","Horas extras cumplidas","Horas extras autorizadas","Estado");
	 	$excel_row = 0;
	 	foreach($table_columns as $field)
	 	{	 
	 	   $object->getActiveSheet()->setCellValueByColumnAndRow($excel_row, 1, $field);
	 	   $excel_row++;	 	  
	 	}
	 	$column_row=2;
	 	$fila_row=0;
	 	$verificar=0;
	 	set_time_limit(9600);	 	
	 	foreach($datos as $row)
	 	{	 
	 		if($verificar==0){
	 	   		$verificar=$row['ID_Usuario'];
	 	   		$datoNombre=$row['NombreTrabajador'];
	 	   	}else{
	 	   		$dat = explode("/", $row['Fecha']);  
	 	   		if( $dat[0] != "01"){
	 	   		}else{
	 	   			$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $datoNombre);
	 	   			$object->getActiveSheet()->setCellValueByColumnAndRow(9 , $column_row, "Horas de atraso");
	 	   			$object->getActiveSheet()->setCellValueByColumnAndRow(14 , $column_row, "Dias trabajados");
			 		$object->getActiveSheet()->setCellValueByColumnAndRow(15 , $column_row, "Dias No trabaaados");
					$object->getActiveSheet()->setCellValueByColumnAndRow(16 , $column_row, "Horas extras totales");
					$object->getActiveSheet()->setCellValueByColumnAndRow(17 , $column_row, "Horas extras totales Autorizadas");
					$object->getActiveSheet()->setCellValueByColumnAndRow(19 , $column_row, "Dias vacaciones");
					$object->getActiveSheet()->setCellValueByColumnAndRow(20 , $column_row, "Dias Libres");
					$object->getActiveSheet()->setCellValueByColumnAndRow(21 , $column_row, "Dias Licencia");
					$object->getActiveSheet()->setCellValueByColumnAndRow(22 , $column_row, "Dias Permisos");
					$object->getActiveSheet()->getStyle('A'.$column_row.':W'.$column_row)->getFill()->applyFromArray(array(
				        'type' => PHPExcel_Style_Fill::FILL_SOLID,
				        'startcolor' => array(
				             'rgb' => 'F28A8C'
				        )
				    ));
	 	   			$verificar=$row['ID_Usuario'];
	 	   			$datoNombre=$row['NombreTrabajador'];
	 	   			$column_row++;	
	 	   		}
	 	   	}
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['NombreTrabajador']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $row['Rut']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $row['Dia']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(3 , $column_row, $row['Fecha']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(4 , $column_row, $row['Turno']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(5 , $column_row, $row['MarcaEntrada']);
	 		// $object->getActiveSheet()->setCellValueByColumnAndRow(6 , $column_row, $row['LocalizacionEntrada']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(7 , $column_row, $row['MarcaSalida']);
	 		// $object->getActiveSheet()->setCellValueByColumnAndRow(8 , $column_row, $row['LocalizacionSalida']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(9 , $column_row, $row['HorasAtraso']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(10 , $column_row, $row['HorasAdelanto']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(11 , $column_row, "");
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(12 , $column_row, "");
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(13 , $column_row, "01:00:00");
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(14 , $column_row, $row['HorasTrabajadas']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(15 , $column_row, $row['HorasNoTrabajadas']);
			$object->getActiveSheet()->setCellValueByColumnAndRow(16 , $column_row, $row['HorasExtras']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(17 , $column_row, "");
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(18 , $column_row, "Correcto");
	 	   	$column_row++;	 	  	 	   	
	 	}
	 	foreach(range('A1','S1') as $columnID) {
	 		$object->getActiveSheet()->getColumnDimension($columnID)->setWidth(15);

		}
	 	$object->getActiveSheet()->getStyle('A1:S1')->applyFromArray(array('font' => array(
            'bold'=> true,
            'size'  => 11,
        )));

        $object->getActiveSheet()->getStyle('A3:S2000')->applyFromArray(array('font' => array(
            'size'  => 11
        )));
	 	$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
	 	ob_end_clean();
	 	header('Content-Type: application/vnd.ms-excel');
	 	header('Content-Disposition: attachment;filename=Libro-Asistencia.xls');
	 	$object_writer->save('php://output');
	}

	function ExportarPDFLibroAsistenciaGeneral($datos,$datos2){
		$this->load->library('pdf');
		$this->pdf = new Pdf();
		$this->pdf->SetDrawColor(164,164,164);
		set_time_limit(9600);	 	
		$validar=0;
		$dia=0;
		$cont=0;	
		if($datos2!='00'){
			$exModi=1;
			$minimo=0;
			$maximo=0;
		}else{
			$exModi=0;
		}	
		foreach ($datos as $d ) {	
			$tem = explode("/", $d["Fecha"]);
			if($tem[0]<$dia){
				$validar=0;
			}		
			$dia=$tem[0];
			$cont++;
			if($validar==0){
				$validar=1;
				if($exModi==1){
					$minimo=($cont-1);
				}
				$numeroSemana=0;
				$this->pdf->AddPage();
				$this->pdf->SetLeftMargin(8);
				$this->pdf->SetRightMargin(8);				
				$this->pdf->SetFont('Arial','',11);		
				$this->pdf->Cell(0,11,utf8_decode('Libro de Asistencia Progestion S.A 76.909.880-1 Crescente Errazuriz 11875, Ñuñoa, Santiago'),0,0,'L');
				$largo=27;
				$this->pdf->Line(9,$largo,199,$largo);
				$this->pdf->Ln(8);
				$this->pdf->SetFont('Arial','B',9);		
				$this->pdf->Cell(0,11,utf8_decode('Leyenda'),0,0,'C');
				$largo=$largo+7;
				$this->pdf->Line(9,$largo,199,$largo);
				$this->pdf->Ln(8);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(8, $largo);
				$this->pdf->Cell(15,6,utf8_decode('ME:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(8, $largo);
				$this->pdf->Cell(15,6,utf8_decode('        Marca de entrada a jornada laboral'),0,1);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(54, $largo);
				$this->pdf->Cell(15,6,utf8_decode('IC:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(54, $largo);
				$this->pdf->Cell(15,6,utf8_decode('      Inicio de Colación'),0,1);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(79, $largo);
				$this->pdf->Cell(15,6,utf8_decode(' TC:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(79, $largo);
				$this->pdf->Cell(15,6,utf8_decode('        Tiempo en Colación'),0,1);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(109, $largo);
				$this->pdf->Cell(15,6,utf8_decode('HNT:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(109, $largo);
				$this->pdf->Cell(15,6,utf8_decode('          Horas No Trabajadas'),0,1);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(145, $largo);
				$this->pdf->Cell(15,6,utf8_decode('F:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(145, $largo);
				$this->pdf->Cell(15,6,utf8_decode('     Feriado'),0,1);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(174, $largo);
				$this->pdf->Cell(15,6,utf8_decode('V:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(174, $largo);
				$this->pdf->Cell(15,6,utf8_decode('     Vacaciones'),0,1);

				$largo=$largo+6;
				$this->pdf->Line(9,$largo,199,$largo);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(8, $largo);
				$this->pdf->Cell(15,6,utf8_decode('MS: '),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(8, $largo);
				$this->pdf->Cell(15,6,utf8_decode('        Marca de salida a jornada laboral'),0,1);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(54, $largo);
				$this->pdf->Cell(15,6,utf8_decode('FC:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(54, $largo);
				$this->pdf->Cell(15,6,utf8_decode('       Fin de Colación'),0,1);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(79, $largo);
				$this->pdf->Cell(15,6,utf8_decode(' HT:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(79, $largo);
				$this->pdf->Cell(15,6,utf8_decode('        Horas Trabajadas'),0,1);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(109, $largo);
				$this->pdf->Cell(15,6,utf8_decode('HEC:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(109, $largo);
				$this->pdf->Cell(15,6,utf8_decode('          Horas Extras Cumplidas'),0,1);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(145, $largo);
				$this->pdf->Cell(15,6,utf8_decode('FI:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(145, $largo);
				$this->pdf->Cell(15,6,utf8_decode('      Feriado Irrenunciable'),0,1);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(174, $largo);
				$this->pdf->Cell(15,6,utf8_decode('LM:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(174, $largo);
				$this->pdf->Cell(15,6,utf8_decode('       Licencia Médica'),0,1);	

				$largo=$largo+6;
				$this->pdf->Line(9,$largo,199,$largo);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(8, $largo);
				$this->pdf->Cell(15,6,utf8_decode('I: '),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(8, $largo);
				$this->pdf->Cell(15,6,utf8_decode('   Inasistencia'),0,1);

				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(54, $largo);
				$this->pdf->Cell(15,6,utf8_decode('A:'),0,1);
				$this->pdf->SetFont('Arial','',7);
				$this->pdf->SetXY(54, $largo);
				$this->pdf->Cell(15,6,utf8_decode('     Atraso'),0,1);	
				
				$largo=$largo+5;
				$this->pdf->SetFont('Arial','B',12);
				$this->pdf->SetXY(11, $largo);
				$this->pdf->Cell(0,11,utf8_decode($d["NombreTrabajador"]).'  '.$d["Rut"],0,0,'C');	

				$largo=$largo+11;
				$this->pdf->SetFont('Arial','B',8);

				$this->pdf->SetXY(8, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Día'),0,1);
				$this->pdf->SetXY(25, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Fecha'),0,1);
				$this->pdf->SetXY(42, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Turno'),0,1);
				$this->pdf->SetXY(81, $largo);
				$this->pdf->Cell(15,6,utf8_decode('ME'),0,1);
				$this->pdf->SetXY(94, $largo);
				$this->pdf->Cell(15,6,utf8_decode('MS'),0,1);
				$this->pdf->SetXY(108, $largo);
				$this->pdf->Cell(15,6,utf8_decode('IC'),0,1);
				$this->pdf->SetXY(122, $largo);
				$this->pdf->Cell(15,6,utf8_decode('FC'),0,1);
				$this->pdf->SetXY(136, $largo);
				$this->pdf->Cell(15,6,utf8_decode('TC'),0,1);
				$this->pdf->SetXY(150, $largo);
				$this->pdf->Cell(15,6,utf8_decode('HT'),0,1);
				$this->pdf->SetXY(164, $largo);
				$this->pdf->Cell(15,6,utf8_decode('HNT'),0,1);
				$this->pdf->SetXY(178, $largo);
				$this->pdf->Cell(15,6,utf8_decode('HEC'),0,1);
			}					
			$this->pdf->SetFont('Arial','',8);
			$largo=$largo+5;
			$this->pdf->Line(9,$largo,199,$largo);
			$this->pdf->SetXY(9, $largo);
			$this->pdf->Cell(15,6,utf8_decode($d["Dia"]),0,1);

			$this->pdf->SetXY(25, $largo);
			$this->pdf->Cell(15,6,utf8_decode($d["Fecha"]),0,1);

			$this->pdf->SetXY(42, $largo);
			$this->pdf->Cell(15,6,utf8_decode($d["Turno"]),0,1);

			if(isset($d["MarcaEntrada"])){ $marcaEntrada=$d["MarcaEntrada"];}else{ $marcaEntrada='--:--'; }
			$this->pdf->SetXY(81, $largo);
			$this->pdf->Cell(15,6,utf8_decode($marcaEntrada),0,1);

			if(isset($d["MarcaSalida"])){ $marcaSalida=$d["MarcaSalida"];}else{ $marcaSalida='--:--'; }
			$this->pdf->SetXY(94, $largo);
			$this->pdf->Cell(15,6,utf8_decode($marcaSalida),0,1);

			if(isset($d["EntradaColacion"])){ $EntradaColacion=$d["EntradaColacion"];}else{ $EntradaColacion='--:--'; }
			$this->pdf->SetXY(108, $largo);
			$this->pdf->Cell(15,6,utf8_decode($EntradaColacion),0,1);

			if(isset($d["SalidaColacion"])){ $SalidaColacion=$d["SalidaColacion"];}else{ $SalidaColacion='--:--'; }
			$this->pdf->SetXY(122, $largo);
			$this->pdf->Cell(15,6,utf8_decode($SalidaColacion),0,1);

			if($d["Remunerado"]==1){ $horaColacion='--:--';}else{ $horaColacion=$d["TiempoColacion"]; }
			$this->pdf->SetXY(136, $largo);
			$this->pdf->Cell(15,6,utf8_decode($horaColacion),0,1);

			if($d["Remunerado"]==1){ $HorasTrabajadas='--:--';}else{ $HorasTrabajadas=$d["HorasTrabajadas"]; }
			$this->pdf->SetXY(150, $largo);
			$this->pdf->Cell(15,6,utf8_decode($HorasTrabajadas),0,1);

			if($d["Remunerado"]==1){ $HorasNoTrabajadas='--:--';}else{ $HorasNoTrabajadas=$d["HorasNoTrabajadas"]; }
			$this->pdf->SetXY(164, $largo);	
			$this->pdf->Cell(15,6,utf8_decode($HorasNoTrabajadas),0,1);

			if($d["Remunerado"]==1){ $HorasExtras='--:--';}else{ $HorasExtras=$d["HorasExtras"]; }
			$this->pdf->SetXY(178, $largo);
			$this->pdf->Cell(15,6,utf8_decode($HorasExtras),0,1);

			if($numeroSemana!=$d["NumeroSemana"]){
				$numeroSemana=$d["NumeroSemana"];
				$diasTrabajar[$numeroSemana]=0;
				$diasNoTrabajar[$numeroSemana]=0;
				$diasTrabajados[$numeroSemana]=0;
				$diasNoTrabajados[$numeroSemana]=0;
				$horastrabajar[$numeroSemana]="0:00:00";
				$trabajadas[$numeroSemana]="0:00:00";
				$notrabajadas[$numeroSemana]="0:00:00";
				$extras[$numeroSemana]="0:00:00";
			}
			if($d["Remunerado"]==1){
				$diasNoTrabajar[$numeroSemana]=($diasNoTrabajar[$numeroSemana]+1);
			}else if(isset($d["MarcaEntrada"])){	
				if($d["HorasAtraso"]!='00:00:00'){
					$this->pdf->SetFont('Arial','B',8);
					$this->pdf->SetXY(192, $largo);
					$this->pdf->Cell(15,6,utf8_decode('A'),0,1);
					$this->pdf->SetFont('Arial','',8);
				}
				$diasTrabajar[$numeroSemana]=($diasTrabajar[$numeroSemana]+1);
				$diasTrabajados[$numeroSemana]=($diasTrabajados[$numeroSemana]+1);
				$horastrabajar[$numeroSemana]=$this->suma_horas($horastrabajar[$numeroSemana],$d["HorasTrabajar"]);
				$trabajadas[$numeroSemana]=$this->suma_horas($trabajadas[$numeroSemana],$d["HorasTrabajadas"]);
				$notrabajadas[$numeroSemana]=$this->suma_horas($notrabajadas[$numeroSemana],$d["HorasNoTrabajadas"]);
				$extras[$numeroSemana]=$this->suma_horas($extras[$numeroSemana],$d["HorasExtras"]);
			}else{
				$this->pdf->SetFont('Arial','B',8);
				$this->pdf->SetXY(192, $largo);
				$this->pdf->Cell(15,6,utf8_decode('I'),0,1);
				$this->pdf->SetFont('Arial','',8);
				$diasTrabajar[$numeroSemana]=($diasTrabajar[$numeroSemana]+1);
				$diasNoTrabajados[$numeroSemana]=($diasNoTrabajados[$numeroSemana]+1);
				$horastrabajar[$numeroSemana]=$this->suma_horas($horastrabajar[$numeroSemana],$d["HorasTrabajar"]);
				$notrabajadas[$numeroSemana]=$this->suma_horas($notrabajadas[$numeroSemana],$d["HorasNoTrabajadas"]);
			}
			if(isset($datos[$cont]["NumDia"])){
				if($dia>$datos[$cont]["NumDia"]){
					if($exModi==1){
						$maximo=($cont);
					}
					$largo=$largo+4;
					$this->pdf->SetXY(11, $largo);
					$this->pdf->SetFont('Arial','B',9);		
					$this->pdf->Cell(0,11,utf8_decode('Resumen'),0,0,'C');	
					$largo=$largo+8;
					$this->pdf->SetFont('Arial','B',7);
					$this->pdf->SetXY(8, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Semana/Total'),0,1);
					$this->pdf->SetXY(27, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Días a Trabajar'),0,1);
					$this->pdf->SetXY(48, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Dias No Trabaja'),0,1);
					$this->pdf->SetXY(70, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Dias Trabajados'),0,1);
					$this->pdf->SetXY(92, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Inasistencias'),0,1);
					$this->pdf->SetXY(111, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Horas a Trabajar'),0,1);
					$this->pdf->SetXY(134, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Horas Trabajadas'),0,1);
					$this->pdf->SetXY(158, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Hora No Trabajadas'),0,1);
					$this->pdf->SetXY(185, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Hora Extras'),0,1);	
					$TdiasTrabajar=0;
					$TdiasNoTrabajar=0;
					$TdiasTrabajados=0;
					$TdiasNoTrabajados=0;
					$Thorastrabajar="00:00:00";
					$Ttrabajadas="00:00:00";
					$Tnotrabajadas="00:00:00";
					$Textras="00:00:00";
					for($i=1;$i<($numeroSemana+1);$i++){
						$largo=$largo+5;
						$this->pdf->Line(9,$largo,199,$largo);
						$this->pdf->SetFont('Arial','',7);
						$this->pdf->SetXY(8, $largo);
						$this->pdf->Cell(15,6,utf8_decode('Semana '.$i),0,1,'C');
						$this->pdf->SetXY(27, $largo);
						$this->pdf->Cell(15,6,utf8_decode($diasTrabajar[$i]),0,1,'C');
						$this->pdf->SetXY(48, $largo);
						$this->pdf->Cell(15,6,utf8_decode($diasNoTrabajar[$i]),0,1,'C');
						$this->pdf->SetXY(70, $largo);
						$this->pdf->Cell(15,6,utf8_decode($diasTrabajados[$i]),0,1,'C');
						$this->pdf->SetXY(92, $largo);
						$this->pdf->Cell(15,6,utf8_decode($diasNoTrabajados[$i]),0,1,'C');
						$this->pdf->SetXY(111, $largo);
						$this->pdf->Cell(15,6,utf8_decode($horastrabajar[$i]),0,1,'C');
						$this->pdf->SetXY(134, $largo);
						$this->pdf->Cell(15,6,utf8_decode($trabajadas[$i]),0,1,'C');
						$this->pdf->SetXY(158, $largo);
						$this->pdf->Cell(15,6,utf8_decode($notrabajadas[$i]),0,1,'C');
						$this->pdf->SetXY(185, $largo);
						$this->pdf->Cell(15,6,utf8_decode($extras[$i]),0,1,'C');
						$TdiasTrabajar=($TdiasTrabajar+$diasTrabajar[$i]);
						$TdiasNoTrabajar=($TdiasNoTrabajar+$diasNoTrabajar[$i]);
						$TdiasTrabajados=($TdiasTrabajados+$diasTrabajados[$i]);
						$TdiasNoTrabajados=($TdiasNoTrabajados+$diasNoTrabajados[$i]);
						$Thorastrabajar=$this->suma_horas($Thorastrabajar,$horastrabajar[$i]);
						$Ttrabajadas=$this->suma_horas($Ttrabajadas,$trabajadas[$i]);
						$Tnotrabajadas=$this->suma_horas($Tnotrabajadas,$notrabajadas[$i]);
						$Textras=$this->suma_horas($Textras,$extras[$i]);
					}							
					$largo=$largo+7;
					$this->pdf->Line(9,$largo,199,$largo);
					$this->pdf->SetFont('Arial','B',7);
					$this->pdf->SetXY(8, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Total'),0,1,'C');
					$this->pdf->SetXY(27, $largo);
					$this->pdf->Cell(15,6,utf8_decode($TdiasTrabajar),0,1,'C');
					$this->pdf->SetXY(48, $largo);
					$this->pdf->Cell(15,6,utf8_decode($TdiasNoTrabajar),0,1,'C');
					$this->pdf->SetXY(70, $largo);
					$this->pdf->Cell(15,6,utf8_decode($TdiasTrabajados),0,1,'C');
					$this->pdf->SetXY(92, $largo);
					$this->pdf->Cell(15,6,utf8_decode($TdiasNoTrabajados),0,1,'C');
					$this->pdf->SetXY(111, $largo);
					$this->pdf->Cell(15,6,utf8_decode($Thorastrabajar),0,1,'C');
					$this->pdf->SetXY(134, $largo);
					$this->pdf->Cell(15,6,utf8_decode($Ttrabajadas),0,1,'C');
					$this->pdf->SetXY(158, $largo);
					$this->pdf->Cell(15,6,utf8_decode($Tnotrabajadas),0,1,'C');
					$this->pdf->SetXY(185, $largo);
					$this->pdf->Cell(15,6,utf8_decode($Textras),0,1,'C');	
					if($exModi==1){
						$validar2=0;
						for ($i=$minimo;$i<$maximo;$i++){
							if($validar2==0){
								$validar2=1;
								$this->pdf->AddPage();
								$this->pdf->SetLeftMargin(8);
								$this->pdf->SetRightMargin(8);				
								$this->pdf->SetFont('Arial','',11);		
								$this->pdf->Cell(0,11,utf8_decode('Libro de Asistencia Progestion S.A 76.909.880-1 Crescente Errazuriz 11875, Ñuñoa, Santiago'),0,0,'L');
								$largo=27;
								$this->pdf->Line(9,$largo,199,$largo);
								$this->pdf->Ln(8);
								$this->pdf->SetFont('Arial','B',9);		
								$this->pdf->Cell(0,11,utf8_decode('Leyenda'),0,0,'C');
								$largo=$largo+7;
								$this->pdf->Line(9,$largo,199,$largo);
								$this->pdf->Ln(8);

								$this->pdf->SetFont('Arial','B',7);
								$this->pdf->SetXY(8, $largo);
								$this->pdf->Cell(15,6,utf8_decode('PP:'),0,1);
								$this->pdf->SetFont('Arial','',7);
								$this->pdf->SetXY(8, $largo);
								$this->pdf->Cell(15,6,utf8_decode('        Puntos Programados'),0,1);

								$this->pdf->SetFont('Arial','B',7);
								$this->pdf->SetXY(50, $largo);
								$this->pdf->Cell(15,6,utf8_decode('MIE:'),0,1);
								$this->pdf->SetFont('Arial','',7);
								$this->pdf->SetXY(50, $largo);
								$this->pdf->Cell(15,6,utf8_decode('           Mínima Marca Entrada'),0,1);

								$this->pdf->SetFont('Arial','B',7);
								$this->pdf->SetXY(100, $largo);
								$this->pdf->Cell(15,6,utf8_decode('MAE:'),0,1);
								$this->pdf->SetFont('Arial','',7);
								$this->pdf->SetXY(100, $largo);
								$this->pdf->Cell(15,6,utf8_decode('             Máxima Marca Entrada'),0,1);

								$this->pdf->SetFont('Arial','B',7);
								$this->pdf->SetXY(150, $largo);
								$this->pdf->Cell(15,6,utf8_decode('PRE:'),0,1);
								$this->pdf->SetFont('Arial','',7);
								$this->pdf->SetXY(150, $largo);
								$this->pdf->Cell(15,6,utf8_decode('            Promedio Marca Entrada'),0,1);

								$largo=$largo+6;
								$this->pdf->Line(9,$largo,199,$largo);

								$this->pdf->SetFont('Arial','B',7);
								$this->pdf->SetXY(8, $largo);
								$this->pdf->Cell(15,6,utf8_decode('PV:'),0,1);
								$this->pdf->SetFont('Arial','',7);
								$this->pdf->SetXY(8, $largo);
								$this->pdf->Cell(15,6,utf8_decode('        Puntos Visitados'),0,1);

								$this->pdf->SetFont('Arial','B',7);
								$this->pdf->SetXY(50, $largo);
								$this->pdf->Cell(15,6,utf8_decode('MIS:'),0,1);
								$this->pdf->SetFont('Arial','',7);
								$this->pdf->SetXY(50, $largo);
								$this->pdf->Cell(15,6,utf8_decode('           Mínima Marca Salida'),0,1);

								$this->pdf->SetFont('Arial','B',7);
								$this->pdf->SetXY(100, $largo);
								$this->pdf->Cell(15,6,utf8_decode('MAS:'),0,1);
								$this->pdf->SetFont('Arial','',7);
								$this->pdf->SetXY(100, $largo);
								$this->pdf->Cell(15,6,utf8_decode('             Máxima Marca Salida'),0,1);

								$this->pdf->SetFont('Arial','B',7);
								$this->pdf->SetXY(150, $largo);
								$this->pdf->Cell(15,6,utf8_decode('PRS:'),0,1);
								$this->pdf->SetFont('Arial','',7);
								$this->pdf->SetXY(150, $largo);
								$this->pdf->Cell(15,6,utf8_decode('            Promedio Marca Salida'),0,1);	
								
								$largo=$largo+5;
								$this->pdf->SetFont('Arial','B',12);
								$this->pdf->SetXY(11, $largo);
								$this->pdf->Cell(0,11,utf8_decode($datos2[$i]["NombreTrabajador"]),0,0,'C');	

								$largo=$largo+11;
								$this->pdf->SetFont('Arial','B',8);

								$this->pdf->SetXY(8, $largo);
								$this->pdf->Cell(15,6,utf8_decode('Día'),0,1);
								$this->pdf->SetXY(28, $largo);
								$this->pdf->Cell(15,6,utf8_decode('Fecha'),0,1);
								$this->pdf->SetXY(49, $largo);
								$this->pdf->Cell(15,6,utf8_decode('PP'),0,1);
								$this->pdf->SetXY(61, $largo);
								$this->pdf->Cell(15,6,utf8_decode('PV'),0,1);
								$this->pdf->SetXY(73, $largo);
								$this->pdf->Cell(15,6,utf8_decode('MIE'),0,1);
								$this->pdf->SetXY(93, $largo);
								$this->pdf->Cell(15,6,utf8_decode('MAE'),0,1);
								$this->pdf->SetXY(113, $largo);
								$this->pdf->Cell(15,6,utf8_decode('PRE'),0,1);
								$this->pdf->SetXY(133, $largo);
								$this->pdf->Cell(15,6,utf8_decode('MIS'),0,1);
								$this->pdf->SetXY(153, $largo);
								$this->pdf->Cell(15,6,utf8_decode('MAS'),0,1);
								$this->pdf->SetXY(173, $largo);
								$this->pdf->Cell(15,6,utf8_decode('PRS'),0,1);		
							}
							$this->pdf->SetFont('Arial','',8);
							$largo=$largo+5;
							$this->pdf->Line(9,$largo,199,$largo);
							$this->pdf->SetXY(9, $largo);
							$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["Dia"]),0,1);

							$this->pdf->SetXY(28, $largo);
							$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["Fecha"]),0,1);

							$this->pdf->SetXY(49, $largo);
							$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["CantidadHorario"]),0,1);

							$this->pdf->SetXY(61, $largo);
							$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["CantidadEntrada"]),0,1);

							$this->pdf->SetXY(73, $largo);
							$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["MinimoEntrada"]." m."),0,1);

							$this->pdf->SetXY(93, $largo);
							$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["MaximoEntrada"]." m."),0,1);

							$this->pdf->SetXY(113, $largo);
							$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["PromedioEntrada"]." m."),0,1);

							$this->pdf->SetXY(133, $largo);
							$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["MinimoSalida"]." m."),0,1);

							$this->pdf->SetXY(153, $largo);
							$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["MaximoSalida"]." m."),0,1);

							$this->pdf->SetXY(173, $largo);	
							$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["PromedioSalida"]." m."),0,1);
						}
					}				
				}						
			}else{
				if($exModi==1){
					$maximo=($cont);
				}
				$largo=$largo+4;
				$this->pdf->SetXY(11, $largo);
				$this->pdf->SetFont('Arial','B',9);		
				$this->pdf->Cell(0,11,utf8_decode('Resumen'),0,0,'C');	
				$largo=$largo+8;
				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(8, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Semana/Total'),0,1);
				$this->pdf->SetXY(27, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Días a Trabajar'),0,1);
				$this->pdf->SetXY(48, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Dias No Trabaja'),0,1);
				$this->pdf->SetXY(70, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Dias Trabajados'),0,1);
				$this->pdf->SetXY(92, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Inasistencias'),0,1);
				$this->pdf->SetXY(111, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Horas a Trabajar'),0,1);
				$this->pdf->SetXY(134, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Horas Trabajadas'),0,1);
				$this->pdf->SetXY(158, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Hora No Trabajadas'),0,1);
				$this->pdf->SetXY(185, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Hora Extras'),0,1);	
				$TdiasTrabajar=0;
				$TdiasNoTrabajar=0;
				$TdiasTrabajados=0;
				$TdiasNoTrabajados=0;
				$Thorastrabajar="00:00:00";
				$Ttrabajadas="00:00:00";
				$Tnotrabajadas="00:00:00";
				$Textras="00:00:00";
				for($i=1;$i<($numeroSemana+1);$i++){
					$largo=$largo+5;
					$this->pdf->Line(9,$largo,199,$largo);
					$this->pdf->SetFont('Arial','',7);
					$this->pdf->SetXY(8, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Semana '.$i),0,1,'C');
					$this->pdf->SetXY(27, $largo);
					$this->pdf->Cell(15,6,utf8_decode($diasTrabajar[$i]),0,1,'C');
					$this->pdf->SetXY(48, $largo);
					$this->pdf->Cell(15,6,utf8_decode($diasNoTrabajar[$i]),0,1,'C');
					$this->pdf->SetXY(70, $largo);
					$this->pdf->Cell(15,6,utf8_decode($diasTrabajados[$i]),0,1,'C');
					$this->pdf->SetXY(92, $largo);
					$this->pdf->Cell(15,6,utf8_decode($diasNoTrabajados[$i]),0,1,'C');
					$this->pdf->SetXY(111, $largo);
					$this->pdf->Cell(15,6,utf8_decode($horastrabajar[$i]),0,1,'C');
					$this->pdf->SetXY(134, $largo);
					$this->pdf->Cell(15,6,utf8_decode($trabajadas[$i]),0,1,'C');
					$this->pdf->SetXY(158, $largo);
					$this->pdf->Cell(15,6,utf8_decode($notrabajadas[$i]),0,1,'C');
					$this->pdf->SetXY(185, $largo);
					$this->pdf->Cell(15,6,utf8_decode($extras[$i]),0,1,'C');
					$TdiasTrabajar=($TdiasTrabajar+$diasTrabajar[$i]);
					$TdiasNoTrabajar=($TdiasNoTrabajar+$diasNoTrabajar[$i]);
					$TdiasTrabajados=($TdiasTrabajados+$diasTrabajados[$i]);
					$TdiasNoTrabajados=($TdiasNoTrabajados+$diasNoTrabajados[$i]);
					$Thorastrabajar=$this->suma_horas($Thorastrabajar,$horastrabajar[$i]);
					$Ttrabajadas=$this->suma_horas($Ttrabajadas,$trabajadas[$i]);
					$Tnotrabajadas=$this->suma_horas($Tnotrabajadas,$notrabajadas[$i]);
					$Textras=$this->suma_horas($Textras,$extras[$i]);
				}							
				$largo=$largo+7;
				$this->pdf->Line(9,$largo,199,$largo);
				$this->pdf->SetFont('Arial','B',7);
				$this->pdf->SetXY(8, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Total'),0,1,'C');
				$this->pdf->SetXY(27, $largo);
				$this->pdf->Cell(15,6,utf8_decode($TdiasTrabajar),0,1,'C');
				$this->pdf->SetXY(48, $largo);
				$this->pdf->Cell(15,6,utf8_decode($TdiasNoTrabajar),0,1,'C');
				$this->pdf->SetXY(70, $largo);
				$this->pdf->Cell(15,6,utf8_decode($TdiasTrabajados),0,1,'C');
				$this->pdf->SetXY(92, $largo);
				$this->pdf->Cell(15,6,utf8_decode($TdiasNoTrabajados),0,1,'C');
				$this->pdf->SetXY(111, $largo);
				$this->pdf->Cell(15,6,utf8_decode($Thorastrabajar),0,1,'C');
				$this->pdf->SetXY(134, $largo);
				$this->pdf->Cell(15,6,utf8_decode($Ttrabajadas),0,1,'C');
				$this->pdf->SetXY(158, $largo);
				$this->pdf->Cell(15,6,utf8_decode($Tnotrabajadas),0,1,'C');
				$this->pdf->SetXY(185, $largo);
				$this->pdf->Cell(15,6,utf8_decode($Textras),0,1,'C');	
				if($exModi==1){
					$validar2=0;
					for ($i=$minimo;$i<$maximo;$i++){
						if($validar2==0){
							$validar2=1;
							$this->pdf->AddPage();
							$this->pdf->SetLeftMargin(8);
							$this->pdf->SetRightMargin(8);				
							$this->pdf->SetFont('Arial','',11);		
							$this->pdf->Cell(0,11,utf8_decode('Libro de Asistencia Progestion S.A 76.909.880-1 Crescente Errazuriz 11875, Ñuñoa, Santiago'),0,0,'L');
							$largo=27;
							$this->pdf->Line(9,$largo,199,$largo);
							$this->pdf->Ln(8);
							$this->pdf->SetFont('Arial','B',9);		
							$this->pdf->Cell(0,11,utf8_decode('Leyenda'),0,0,'C');
							$largo=$largo+7;
							$this->pdf->Line(9,$largo,199,$largo);
							$this->pdf->Ln(8);

							$this->pdf->SetFont('Arial','B',7);
							$this->pdf->SetXY(8, $largo);
							$this->pdf->Cell(15,6,utf8_decode('PP:'),0,1);
							$this->pdf->SetFont('Arial','',7);
							$this->pdf->SetXY(8, $largo);
							$this->pdf->Cell(15,6,utf8_decode('        Puntos Programados'),0,1);

							$this->pdf->SetFont('Arial','B',7);
							$this->pdf->SetXY(50, $largo);
							$this->pdf->Cell(15,6,utf8_decode('MIE:'),0,1);
							$this->pdf->SetFont('Arial','',7);
							$this->pdf->SetXY(50, $largo);
							$this->pdf->Cell(15,6,utf8_decode('           Mínima Marca Entrada'),0,1);

							$this->pdf->SetFont('Arial','B',7);
							$this->pdf->SetXY(100, $largo);
							$this->pdf->Cell(15,6,utf8_decode('MAE:'),0,1);
							$this->pdf->SetFont('Arial','',7);
							$this->pdf->SetXY(100, $largo);
							$this->pdf->Cell(15,6,utf8_decode('             Máxima Marca Entrada'),0,1);

							$this->pdf->SetFont('Arial','B',7);
							$this->pdf->SetXY(150, $largo);
							$this->pdf->Cell(15,6,utf8_decode('PRE:'),0,1);
							$this->pdf->SetFont('Arial','',7);
							$this->pdf->SetXY(150, $largo);
							$this->pdf->Cell(15,6,utf8_decode('            Promedio Marca Entrada'),0,1);

							$largo=$largo+6;
							$this->pdf->Line(9,$largo,199,$largo);

							$this->pdf->SetFont('Arial','B',7);
							$this->pdf->SetXY(8, $largo);
							$this->pdf->Cell(15,6,utf8_decode('PV:'),0,1);
							$this->pdf->SetFont('Arial','',7);
							$this->pdf->SetXY(8, $largo);
							$this->pdf->Cell(15,6,utf8_decode('        Puntos Visitados'),0,1);

							$this->pdf->SetFont('Arial','B',7);
							$this->pdf->SetXY(50, $largo);
							$this->pdf->Cell(15,6,utf8_decode('MIS:'),0,1);
							$this->pdf->SetFont('Arial','',7);
							$this->pdf->SetXY(50, $largo);
							$this->pdf->Cell(15,6,utf8_decode('           Mínima Marca Salida'),0,1);

							$this->pdf->SetFont('Arial','B',7);
							$this->pdf->SetXY(100, $largo);
							$this->pdf->Cell(15,6,utf8_decode('MAS:'),0,1);
							$this->pdf->SetFont('Arial','',7);
							$this->pdf->SetXY(100, $largo);
							$this->pdf->Cell(15,6,utf8_decode('             Máxima Marca Salida'),0,1);

							$this->pdf->SetFont('Arial','B',7);
							$this->pdf->SetXY(150, $largo);
							$this->pdf->Cell(15,6,utf8_decode('PRS:'),0,1);
							$this->pdf->SetFont('Arial','',7);
							$this->pdf->SetXY(150, $largo);
							$this->pdf->Cell(15,6,utf8_decode('            Promedio Marca Salida'),0,1);	
							
							$largo=$largo+5;
							$this->pdf->SetFont('Arial','B',12);
							$this->pdf->SetXY(11, $largo);
							$this->pdf->Cell(0,11,$datos2[$i]["NombreTrabajador"],0,0,'C');	

							$largo=$largo+11;
							$this->pdf->SetFont('Arial','B',8);

							$this->pdf->SetXY(8, $largo);
							$this->pdf->Cell(15,6,utf8_decode('Día'),0,1);
							$this->pdf->SetXY(28, $largo);
							$this->pdf->Cell(15,6,utf8_decode('Fecha'),0,1);
							$this->pdf->SetXY(49, $largo);
							$this->pdf->Cell(15,6,utf8_decode('PP'),0,1);
							$this->pdf->SetXY(61, $largo);
							$this->pdf->Cell(15,6,utf8_decode('PV'),0,1);
							$this->pdf->SetXY(73, $largo);
							$this->pdf->Cell(15,6,utf8_decode('MIE'),0,1);
							$this->pdf->SetXY(93, $largo);
							$this->pdf->Cell(15,6,utf8_decode('MAE'),0,1);
							$this->pdf->SetXY(113, $largo);
							$this->pdf->Cell(15,6,utf8_decode('PRE'),0,1);
							$this->pdf->SetXY(133, $largo);
							$this->pdf->Cell(15,6,utf8_decode('MIS'),0,1);
							$this->pdf->SetXY(153, $largo);
							$this->pdf->Cell(15,6,utf8_decode('MAS'),0,1);
							$this->pdf->SetXY(173, $largo);
							$this->pdf->Cell(15,6,utf8_decode('PRS'),0,1);		
						}
						$this->pdf->SetFont('Arial','',8);
						$largo=$largo+5;
						$this->pdf->Line(9,$largo,199,$largo);
						$this->pdf->SetXY(9, $largo);
						$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["Dia"]),0,1);

						$this->pdf->SetXY(28, $largo);
						$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["Fecha"]),0,1);

						$this->pdf->SetXY(49, $largo);
						$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["CantidadHorario"]),0,1);

						$this->pdf->SetXY(61, $largo);
						$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["CantidadEntrada"]),0,1);

						$this->pdf->SetXY(73, $largo);
						$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["MinimoEntrada"]." m."),0,1);

						$this->pdf->SetXY(93, $largo);
						$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["MaximoEntrada"]." m."),0,1);

						$this->pdf->SetXY(113, $largo);
						$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["PromedioEntrada"]." m."),0,1);

						$this->pdf->SetXY(133, $largo);
						$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["MinimoSalida"]." m."),0,1);

						$this->pdf->SetXY(153, $largo);
						$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["MaximoSalida"]." m."),0,1);

						$this->pdf->SetXY(173, $largo);	
						$this->pdf->Cell(15,6,utf8_decode($datos2[$i]["PromedioSalida"]." m."),0,1);
					}
				}
			}	
		}
		ob_clean();
		$this->pdf->Output();	
	}

	function ExportarPDFLibroModificacionHorarios($datos){
		$this->load->library('pdf');
		$this->pdf = new Pdf();	
		$this->pdf->SetDrawColor(164,164,164);	
		$usuario=0;		
		$validar=0;
		$cont=0;
		foreach ($datos as $d ) {	
			if($usuario!=$d["ID_Usuario"]){
				$validar=1;
				$usuario=$d["ID_Usuario"];
			}else{
				$validar=0;
			}
			if($validar==1){
				$cont=0;
				$this->pdf->AddPage();
				$this->pdf->SetLeftMargin(11);
				$this->pdf->SetRightMargin(11);				
				$this->pdf->SetFont('Arial','',11);		
				$this->pdf->Cell(0,11,utf8_decode('Libro de Modificaciones Progestion S.A 76.909.880-1 Crescente Errazuriz 11875, Ñuñoa, Santiago'),0,0,'L');
				$largo=27;		
				$this->pdf->SetFont('Arial','B',20);
				$this->pdf->SetXY(11, $largo);
				$this->pdf->Cell(0,11,$d["Nombre"],0,0,'C');	
				$largo=$largo+13;		
				$this->pdf->SetFont('Arial','B',9);	
				$this->pdf->SetXY(11, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Día"),0,1);
				$this->pdf->SetXY(31, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Fecha"),0,1);
				$this->pdf->SetXY(52, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Fecha Creación"),0,1);
				$this->pdf->SetXY(81, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Fecha Edición"),0,1);				
				$this->pdf->SetXY(109, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Turno Anterior"),0,1);
				$this->pdf->SetXY(156, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Nuevo Turno"),0,1);
			}
			if($cont==40){
				$cont=0;
				$this->pdf->AddPage();
				$this->pdf->SetLeftMargin(11);
				$this->pdf->SetRightMargin(11);	
				$largo=30;	
				$this->pdf->SetFont('Arial','B',9);	
				$this->pdf->SetXY(11, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Día"),0,1);
				$this->pdf->SetXY(31, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Fecha"),0,1);
				$this->pdf->SetXY(52, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Fecha Creación"),0,1);
				$this->pdf->SetXY(81, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Fecha Edición"),0,1);				
				$this->pdf->SetXY(109, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Turno Anterior"),0,1);
				$this->pdf->SetXY(156, $largo);
				$this->pdf->Cell(15,6,utf8_decode("Nuevo Turno"),0,1);
			}
			$largo=$largo+5;				
			$this->pdf->Line(12,$largo,196,$largo);
			$this->pdf->SetFont('Arial','',9);
			$this->pdf->SetXY(11, $largo);
			$this->pdf->Cell(15,6,utf8_decode($d["Dia"]),0,1);
			$this->pdf->SetXY(31, $largo);
			$this->pdf->Cell(15,6,utf8_decode($d["Fecha"]),0,1);
			$this->pdf->SetXY(52, $largo);
			$this->pdf->Cell(15,6,utf8_decode($d["FechaModificacionAnterior"]),0,1);
			$this->pdf->SetXY(81, $largo);			
			$this->pdf->Cell(15,6,utf8_decode($d["FechaModificacionNueva"]),0,1);						
			$this->pdf->SetFont('Arial','B',9);	
			// $this->pdf->SetTextColor(179,10,10);			
			$this->pdf->SetXY(109, $largo);			
			$this->pdf->Cell(15,6,utf8_decode($d["TurnoAnterior"]),0,1);			
			$this->pdf->SetXY(156, $largo);
			$this->pdf->Cell(15,6,utf8_decode($d["TurnoNuevo"]),0,1);
			// $this->pdf->SetTextColor(0,0,0);
			$this->pdf->SetFont('Arial','',9);
			$cont++;	
		}
		ob_clean();
		$this->pdf->Output();	
	}

	function ExportarPDFExceso($datos){
		$this->load->library('pdf');
		$this->pdf = new Pdf();
		$this->pdf->SetDrawColor(164,164,164);
		$validar=0;
		$dia=0;
		$cont=0;		
		foreach ($datos as $d ) {	
			$tem = explode("/", $d["Fecha"]);
			if($tem[0]<=$dia){
			// if($tem[0]<$dia){
				$validar=0;
			}		
			$dia=$tem[0];
			$cont++;
			if($validar==0){
				$validar=1;
				$numeroSemana=0;
				$this->pdf->AddPage();
				$this->pdf->SetLeftMargin(8);
				$this->pdf->SetRightMargin(8);				
				$this->pdf->SetFont('Arial','',11);		
				$this->pdf->Cell(0,11,utf8_decode('Libro de Excesos Progestion S.A 76.909.880-1 Crescente Errazuriz 11875, Ñuñoa, Santiago'),0,0,'L');
				$largo=27;
				$this->pdf->SetFont('Arial','B',12);
				$this->pdf->SetXY(11, $largo);
				$this->pdf->Cell(0,11,utf8_decode($d["NombreTrabajador"]),0,0,'C');	

				$largo=$largo+11;
				$this->pdf->SetFont('Arial','B',8);

				$this->pdf->SetXY(10, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Día'),0,1);
				$this->pdf->SetXY(30, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Fecha'),0,1);
				$this->pdf->SetXY(50, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Turno'),0,1);
				$this->pdf->SetXY(92, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Marca Entrada'),0,1);
				$this->pdf->SetXY(117, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Marca Salida'),0,1);
				$this->pdf->SetXY(140, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Horas Extras'),0,1);
				$this->pdf->SetXY(164, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Permitidas'),0,1);
				$this->pdf->SetXY(185, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Excesos'),0,1);
			}		
			$this->pdf->SetFont('Arial','',8);
			$largo=$largo+5;
			$this->pdf->Line(9,$largo,199,$largo);
			$this->pdf->SetXY(10, $largo);
			$this->pdf->Cell(15,6,utf8_decode($d["Dia"]),0,1);

			$this->pdf->SetXY(30, $largo);
			$this->pdf->Cell(15,6,utf8_decode($d["Fecha"]),0,1);

			$this->pdf->SetXY(50, $largo);
			$this->pdf->Cell(15,6,utf8_decode($d["Turno"]),0,1);

			if(isset($d["MarcaEntrada"])){ $marcaEntrada=$d["MarcaEntrada"];}else{ $marcaEntrada='--:--'; }
			$this->pdf->SetXY(92, $largo);
			$this->pdf->Cell(15,6,utf8_decode($marcaEntrada),0,1);

			if(isset($d["MarcaSalida"])){ $marcaSalida=$d["MarcaSalida"];}else{ $marcaSalida='--:--'; }
			$this->pdf->SetXY(117, $largo);
			$this->pdf->Cell(15,6,utf8_decode($marcaSalida),0,1);

			if($d["Remunerado"]==1){ $HorasExtras='--:--';}else{ $HorasExtras=$d["HorasExtras"]; }
			$this->pdf->SetXY(140, $largo);
			$this->pdf->Cell(15,6,utf8_decode($HorasExtras),0,1);

			if($d["Remunerado"]==1){ $HorasExtras='--:--';}else{ $HorasExtras=$d["HorasExtras"]; }
			$this->pdf->SetXY(164, $largo);
			$this->pdf->Cell(15,6,utf8_decode("00:00:00"),0,1);

			$this->pdf->SetXY(185, $largo);
			$this->pdf->Cell(15,6,utf8_decode($HorasExtras),0,1);			

			if($numeroSemana!=$d["NumeroSemana"]){
				$numeroSemana=$d["NumeroSemana"];
				$extras[$numeroSemana]="0:00:00";
			}
			if(isset($d["MarcaEntrada"])){				
				$extras[$numeroSemana]=$this->suma_horas($extras[$numeroSemana],$d["HorasExtras"]);
			}

			if(isset($datos[$cont]["NumDia"])){
				if($dia>=$datos[$cont]["NumDia"]){
				// if($dia>$datos[$cont]["NumDia"]){
					$largo=$largo+6;
					$this->pdf->SetXY(11, $largo);
					$this->pdf->SetFont('Arial','B',9);		
					$this->pdf->Cell(0,11,utf8_decode('Resumen'),0,0,'C');	
					$largo=$largo+9;
					$this->pdf->SetFont('Arial','B',8);
					$this->pdf->SetXY(10, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Semana/Total'),0,1);
					$this->pdf->SetXY(50, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Hora Extras'),0,1);
					$this->pdf->SetXY(90, $largo);					
					$this->pdf->Cell(15,6,utf8_decode('Horas Permitidas'),0,1);
					$this->pdf->SetXY(134, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Horas Excesos'),0,1);
					$Textras="00:00:00";
					for($i=1;$i<($numeroSemana+1);$i++){
						$largo=$largo+5;
						$this->pdf->Line(9,$largo,199,$largo);
						$this->pdf->SetFont('Arial','',8);
						$this->pdf->SetXY(10, $largo);
						$this->pdf->Cell(15,6,utf8_decode('Semana '.$i),0,1,'C');
						$this->pdf->SetXY(50, $largo);
						$this->pdf->Cell(15,6,utf8_decode($extras[$i]),0,1,'C');
						$this->pdf->SetXY(90, $largo);
						$this->pdf->Cell(15,6,utf8_decode("00:00:00"),0,1,'C');						
						$this->pdf->SetXY(134, $largo);						
						$this->pdf->Cell(15,6,utf8_decode($extras[$i]),0,1,'C');
						$Textras=$this->suma_horas($Textras,$extras[$i]);
					}							
					$largo=$largo+7;
					$this->pdf->Line(9,$largo,199,$largo);
					$this->pdf->SetFont('Arial','B',8);
					$this->pdf->SetXY(10, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Total'),0,1,'C');
					$this->pdf->SetXY(50, $largo);
					$this->pdf->Cell(15,6,utf8_decode($Textras),0,1,'C');
					$this->pdf->SetXY(90, $largo);					
					$this->pdf->Cell(15,6,utf8_decode("00:00:00"),0,1,'C');
					$this->pdf->SetXY(134, $largo);					
					$this->pdf->Cell(15,6,utf8_decode($Textras),0,1,'C');
				}								
			}else{
				$largo=$largo+6;
				$this->pdf->SetXY(11, $largo);
				$this->pdf->SetFont('Arial','B',9);		
				$this->pdf->Cell(0,11,utf8_decode('Resumen'),0,0,'C');	
				$largo=$largo+9;
				$this->pdf->SetFont('Arial','B',8);
				$this->pdf->SetXY(10, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Semana/Total'),0,1);
				$this->pdf->SetXY(50, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Hora Extras'),0,1);
				$this->pdf->SetXY(90, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Horas Permitidas'),0,1);				
				$this->pdf->SetXY(134, $largo);				
				$this->pdf->Cell(15,6,utf8_decode('Horas Excesos'),0,1);
				$Textras="00:00:00";
				for($i=1;$i<($numeroSemana+1);$i++){
					$largo=$largo+5;
					$this->pdf->Line(9,$largo,199,$largo);
					$this->pdf->SetFont('Arial','',8);
					$this->pdf->SetXY(10, $largo);
					$this->pdf->Cell(15,6,utf8_decode('Semana '.$i),0,1,'C');
					$this->pdf->SetXY(50, $largo);
					$this->pdf->Cell(15,6,utf8_decode($extras[$i]),0,1,'C');
					$this->pdf->SetXY(90, $largo);
					$this->pdf->Cell(15,6,utf8_decode("00:00:00"),0,1,'C');					
					$this->pdf->SetXY(134, $largo);					
					$this->pdf->Cell(15,6,utf8_decode($extras[$i]),0,1,'C');
					$Textras=$this->suma_horas($Textras,$extras[$i]);
				}							
				$largo=$largo+7;
				$this->pdf->Line(9,$largo,199,$largo);
				$this->pdf->SetFont('Arial','B',8);
				$this->pdf->SetXY(10, $largo);
				$this->pdf->Cell(15,6,utf8_decode('Total'),0,1,'C');
				$this->pdf->SetXY(50, $largo);
				$this->pdf->Cell(15,6,utf8_decode($Textras),0,1,'C');
				$this->pdf->SetXY(90, $largo);				
				$this->pdf->Cell(15,6,utf8_decode("00:00:00"),0,1,'C');
				$this->pdf->SetXY(134, $largo);
				$this->pdf->Cell(15,6,utf8_decode($Textras),0,1,'C');				
			}	
		}
		ob_clean();
		$this->pdf->Output();	
	}

	function suma_horas($hora1,$hora2){ 
	    $hora1=explode(":",$hora1); 
	    $hora2=explode(":",$hora2); 
	    $temp=0; 
	     
	    //sumo segundos 
	    $segundos=(int)$hora1[2]+(int)$hora2[2]; 
	    while($segundos>=60){         
	        $segundos=$segundos-60; 
	        $temp++; 
	    } 
	         
	    //sumo minutos 
	    $minutos=(int)$hora1[1]+(int)$hora2[1]+$temp; 
	    $temp=0; 
	    while($minutos>=60){         
	        $minutos=$minutos-60; 
	        $temp++; 
	    } 
	     
	    //sumo horas 
	    $horas=(int)$hora1[0]+(int)$hora2[0]+$temp; 
	     
	    if($minutos<10) 
	        $minutos= '0'.$minutos; 
	     
	    if($segundos<10) 
	        $segundos= '0'.$segundos; 
	         
	    $sum_hrs = $horas.':'.$minutos.':'.$segundos; 
	     
	    return ($sum_hrs);       
    }  
}