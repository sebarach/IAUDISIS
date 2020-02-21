<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloConsolidado extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper("url","form");	
		$this->load->library('form_validation'); 	
		$this->load->model("funcion_login");
		$this->load->library('upload');
		//$this->load->library('email');
		$this->load->library('phpmailer_lib');
	}

	function ConsolidadoForus(){
		$BD="I-Audisis_Forus";
		$this->load->model("ModuloConsolidado");
		$data["Rutas"]=$this->ModuloConsolidado->ContarRutasActivas($BD);
		$data["Marcas"]=$this->ModuloConsolidado->ContarMarcaUsuarios($BD);
		$data["Ejec"]=$this->ModuloConsolidado->ContarRutasEjecucion($BD);
		$data["NUsuarios"]=$this->ModuloConsolidado->ContarUsuariosRutas($BD);
		$data["TablaUser"]=$this->ModuloConsolidado->CargarTablaUsuarios($BD);
		$data["Requerimiento"]=$this->ModuloConsolidado->TablaConReq($BD);
		$data["Req"]=$this->ModuloConsolidado->TablaUsuarioRequerimiento($BD);
		$tablaMaestra=$this->ModuloConsolidado->CargarTablaUsuariosTop10($BD);
		$tablaReq=$this->ModuloConsolidado->TablaConReqTop10($BD);
		$tablaRequerimiento=$this->ModuloConsolidado->TablaUsuarioRequerimientoTop10($BD);
		$resultado=$this->ModuloConsolidado->PromedioTiempoRutas($BD);
		$ruta_ejec=$data["NUsuarios"]["Usuarios"]-$data["Marcas"]["Asistencias"];
		$faltante=$data["Rutas"]["Rutas"]-$data["Marcas"]["Asistencias"];
		$data["Promedio"]=$resultado["Diferencia"];
		$data["foto"]="usuario_1.png";
		$promedioLocal=$this->ModuloConsolidado->LocalesPorUsuarios($BD);
		if ($promedioLocal!=null) {
			foreach ($promedioLocal as $pr) {
			$sumaTotal[]=$pr["NLocales"];
			}
			$data["promedioLocalResuelto"]=intval((array_sum($sumaTotal))/count($sumaTotal));
		}else{
			$data["promedioLocalResuelto"]=1;
		}
		$tabla='<p>Pulse <a style="color: #f03434;background-color: transparent;text-decoration: none;" href="'.site_url().'Adm_ModuloConsolidado/ConsolidadoForusReporte" target="_blank">Aquí</a> para ver el detalle del reporte...</p>
		<h2 align="center" style="font-family: Verdana, Geneva, sans-serif;color:#F03434;">Registro de Rutas</h2>
		<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Número de Rutas</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas Completadas</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas en Ejecución</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas Faltantes</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Requerimiento</th>
                    </tr>
                </thead>
                <tbody>';
		foreach ($tablaReq as $tr) {
			$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NRutas"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NCompletadas"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NEjecucion"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NRutasFaltantes"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["Requerimiento"].'</td>
				</tr>';
		}
		$tabla.='</tbody>
			</table>
			<br>';
			$tabla.='<h2 align="center" style="font-family: Verdana, Geneva, sans-serif;color:#F03434;">Requerimientos Especiales</h2>
			<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Requerimiento</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Fecha</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Latitud</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Longitud</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($tablaRequerimiento as $tb) {
        	$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Requerimiento"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Fecha"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Latitud"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Longitud"].'</td>
				</tr>';
        }
        $tabla.='</tbody>
			</table>
			<br>';
		$tabla.='<h2 align="center" style="font-family: Verdana, Geneva, sans-serif;color:#F03434;">Registro de Marcación</h2>
		<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Cargo</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Local</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Entrada</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Salida</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Marca Entrada</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Marca Salida</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Tiempo en PDO</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Permiso</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($tablaMaestra as $tm) {
        	$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Cargo"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["NombreLocal"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Entrada"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Salida"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["HoraEntrada"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["HoraSalida"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["TiempoPDO"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["NombrePermiso"].'</td>
				</tr>';
        }
        $tabla.='</tbody>
			</table>
			<br>';
		$this->load->view('contenido');
	   	$this->load->view('admin/adminConsolidado',$data);
		$titulo='Reporte Diario de atrasos';
		$email   = 'jordan.fernandez@audisischile.com';
		$mensaje = '<!DOCTYPE html>
		<html>
		<head>
  		<meta charset="utf-8" />
			<title>Reporte</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		</head>

		<body>
			<div>
			<img src="http://forus.cl/wp-content/uploads/2013/10/LOGO-FORUS.png">

			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Programadas para Hoy: '.$data["Rutas"]["Rutas"].' </p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas en Ejecución: '.$ruta_ejec.'</p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Completadas: '.$data["Marcas"]["Asistencias"].'</p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Faltantes: '.$faltante.'</p></div>
			</div>
			<br>
			'.$tabla.'
		</body>
		</html>';

		$this->enviaremailReporte($email,$mensaje,$titulo);
	}

	function ConsolidadoForusReporte(){
		$BD="I-Audisis_Forus";
		$this->load->model("ModuloConsolidado");
		$data["Rutas"]=$this->ModuloConsolidado->ContarRutasActivas($BD);
		$data["Marcas"]=$this->ModuloConsolidado->ContarMarcaUsuarios($BD);
		$data["Ejec"]=$this->ModuloConsolidado->ContarRutasEjecucion($BD);
		$data["NUsuarios"]=$this->ModuloConsolidado->ContarUsuariosRutas($BD);
		$data["TablaUser"]=$this->ModuloConsolidado->CargarTablaUsuarios($BD);
		$data["Req"]=$this->ModuloConsolidado->TablaUsuarioRequerimiento($BD);
		$resultado=$this->ModuloConsolidado->PromedioTiempoRutas($BD);
		$data["Requerimiento"]=$this->ModuloConsolidado->TablaConReq($BD);
		$ruta_ejec=$data["NUsuarios"]["Usuarios"]-$data["Marcas"]["Asistencias"];
		$faltante=$data["Rutas"]["Rutas"]-$data["Marcas"]["Asistencias"];
		$data["Promedio"]=$resultado["Diferencia"];
		$data["foto"]="LOGO-FORUS.png";
		$promedioLocal=$this->ModuloConsolidado->LocalesPorUsuarios($BD);
		if ($promedioLocal!=null) {
			foreach ($promedioLocal as $pr) {
			$sumaTotal[]=$pr["NLocales"];
			}
			$data["promedioLocalResuelto"]=intval((array_sum($sumaTotal))/count($sumaTotal));
		}else{
			$data["promedioLocalResuelto"]=1;
		}
		$this->load->view('contenido');
	   	$this->load->view('admin/adminConsolidado',$data);
	}

	function ConsolidadoAndina(){
		$BD="I-Audisis_Andina";
		$this->load->model("ModuloConsolidado");
		$data["Rutas"]=$this->ModuloConsolidado->ContarRutasActivas($BD);
		$data["Marcas"]=$this->ModuloConsolidado->ContarMarcaUsuarios($BD);
		$data["Ejec"]=$this->ModuloConsolidado->ContarRutasEjecucion($BD);
		$data["NUsuarios"]=$this->ModuloConsolidado->ContarUsuariosRutas($BD);
		$data["TablaUser"]=$this->ModuloConsolidado->CargarTablaUsuarios($BD);
		$data["Requerimiento"]=$this->ModuloConsolidado->TablaConReq($BD);
		$data["Req"]=$this->ModuloConsolidado->TablaUsuarioRequerimiento($BD);
		$tablaMaestra=$this->ModuloConsolidado->CargarTablaUsuariosTop10($BD);
		$tablaReq=$this->ModuloConsolidado->TablaConReqTop10($BD);
		$tablaRequerimiento=$this->ModuloConsolidado->TablaUsuarioRequerimientoTop10($BD);
		$resultado=$this->ModuloConsolidado->PromedioTiempoRutas($BD);
		$ruta_ejec=$data["NUsuarios"]["Usuarios"]-$data["Marcas"]["Asistencias"];
		$faltante=$data["Rutas"]["Rutas"]-$data["Marcas"]["Asistencias"];
		$data["Promedio"]=$resultado["Diferencia"];
		$data["foto"]="usuario_1.png";
		$promedioLocal=$this->ModuloConsolidado->LocalesPorUsuarios($BD);
		if ($promedioLocal!=null) {
			foreach ($promedioLocal as $pr) {
			$sumaTotal[]=$pr["NLocales"];
			}
			$data["promedioLocalResuelto"]=intval((array_sum($sumaTotal))/count($sumaTotal));
		}else{
			$data["promedioLocalResuelto"]=1;
		}
		$tabla='<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Número de Rutas</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas Completadas</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas en Ejecución</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas Faltantes</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Requerimiento</th>
                    </tr>
                </thead>
                <tbody>';
		foreach ($tablaReq as $tr) {
			$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NRutas"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NCompletadas"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NEjecucion"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NRutasFaltantes"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["Requerimiento"].'</td>
				</tr>';
		}
		$tabla.='</tbody>
			</table>
			<p>Pulse <a style="color: #f03434;background-color: transparent;text-decoration: none;" href="'.site_url().'Adm_ModuloConsolidado/ConsolidadoAndinaReporte" target="_blank">Aquí</a> para ver el detalle del reporte...</p>
			<br>';
			$tabla.='<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Requerimiento</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Fecha</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Latitud</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Longitud</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($tablaRequerimiento as $tb) {
        	$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Requerimiento"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Fecha"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Latitud"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Longitud"].'</td>
				</tr>';
        }
        $tabla.='</tbody>
			</table>
			<p>Pulse <a style="color: #f03434;background-color: transparent;text-decoration: none;" href="'.site_url().'Adm_ModuloConsolidado/ConsolidadoAndinaReporte" target="_blank">Aquí</a> para ver el detalle del reporte...</p>
			<br>';
		$tabla.='<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Cargo</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Local</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Entrada</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Salida</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Marca Entrada</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Marca Salida</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Tiempo en PDO</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Permiso</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($tablaMaestra as $tm) {
        	$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Cargo"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["NombreLocal"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Entrada"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Salida"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["HoraEntrada"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["HoraSalida"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["TiempoPDO"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["NombrePermiso"].'</td>
				</tr>';
        }
        $tabla.='</tbody>
			</table>
			<p>Pulse <a style="color: #f03434;background-color: transparent;text-decoration: none;" href="'.site_url().'Adm_ModuloConsolidado/ConsolidadoAndinaReporte" target="_blank">Aquí</a> para ver el detalle del reporte...</p>
			<br>';
		$this->load->view('contenido');
	   	$this->load->view('admin/adminConsolidado',$data);
		$titulo  ='Reporte Diario de atrasos';
		$email   ='jordan.fernandez@audisischile.com';
		$mensaje = '<!DOCTYPE html>
		<html>
		<head>
  		<meta charset="utf-8" />
			<title>Reporte</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		</head>

		<body>
			<div>
			<img src="https://amchamchile.cl/wp-content/uploads/2018/10/coca-cola.png">

			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Programadas para Hoy: '.$data["Rutas"]["Rutas"].' </p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas en Ejecución: '.$ruta_ejec.'</p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Completadas: '.$data["Marcas"]["Asistencias"].'</p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Faltantes: '.$faltante.'</p></div>
			</div>
			<br>
			<br>
			'.$tabla.'
		</body>
		</html>';
		$this->enviaremailReporte($email,$mensaje,$titulo);
	}

	function ConsolidadoAndinaReporte(){
		$BD="I-Audisis_Andina";
		$this->load->model("ModuloConsolidado");
		$data["Rutas"]=$this->ModuloConsolidado->ContarRutasActivas($BD);
		$data["Marcas"]=$this->ModuloConsolidado->ContarMarcaUsuarios($BD);
		$data["Ejec"]=$this->ModuloConsolidado->ContarRutasEjecucion($BD);
		$data["NUsuarios"]=$this->ModuloConsolidado->ContarUsuariosRutas($BD);
		$data["TablaUser"]=$this->ModuloConsolidado->CargarTablaUsuarios($BD);
		$data["Req"]=$this->ModuloConsolidado->TablaUsuarioRequerimiento($BD);
		$resultado=$this->ModuloConsolidado->PromedioTiempoRutas($BD);
		$data["Requerimiento"]=$this->ModuloConsolidado->TablaConReq($BD);
		$ruta_ejec=$data["NUsuarios"]["Usuarios"]-$data["Marcas"]["Asistencias"];
		$faltante=$data["Rutas"]["Rutas"]-$data["Marcas"]["Asistencias"];
		$data["Promedio"]=$resultado["Diferencia"];
		$data["foto"]="usuario_1.jpeg";
		$promedioLocal=$this->ModuloConsolidado->LocalesPorUsuarios($BD);
		if ($promedioLocal!=null) {
			foreach ($promedioLocal as $pr) {
			$sumaTotal[]=$pr["NLocales"];
			}
			$data["promedioLocalResuelto"]=intval((array_sum($sumaTotal))/count($sumaTotal));
		}else{
			$data["promedioLocalResuelto"]=1;
		}
		$this->load->view('contenido');
	   	$this->load->view('admin/adminConsolidado',$data);
	}

	function ConsolidadoJSC(){
		$BD="I-Audisis_JSC";
		$this->load->model("ModuloConsolidado");
		$data["Rutas"]=$this->ModuloConsolidado->ContarRutasActivas($BD);
		$data["Marcas"]=$this->ModuloConsolidado->ContarMarcaUsuarios($BD);
		$data["Ejec"]=$this->ModuloConsolidado->ContarRutasEjecucion($BD);
		$data["NUsuarios"]=$this->ModuloConsolidado->ContarUsuariosRutas($BD);
		$data["TablaUser"]=$this->ModuloConsolidado->CargarTablaUsuarios($BD);
		$data["Requerimiento"]=$this->ModuloConsolidado->TablaConReq($BD);
		$data["Req"]=$this->ModuloConsolidado->TablaUsuarioRequerimiento($BD);
		$tablaMaestra=$this->ModuloConsolidado->CargarTablaUsuariosTop10($BD);
		$tablaReq=$this->ModuloConsolidado->TablaConReqTop10($BD);
		$tablaRequerimiento=$this->ModuloConsolidado->TablaUsuarioRequerimientoTop10($BD);
		$resultado=$this->ModuloConsolidado->PromedioTiempoRutas($BD);
		$ruta_ejec=$data["NUsuarios"]["Usuarios"]-$data["Marcas"]["Asistencias"];
		$faltante=$data["Rutas"]["Rutas"]-$data["Marcas"]["Asistencias"];
		$data["Promedio"]=$resultado["Diferencia"];
		$data["foto"]="usuario_1.png";
		$promedioLocal=$this->ModuloConsolidado->LocalesPorUsuarios($BD);
		if ($promedioLocal!=null) {
			foreach ($promedioLocal as $pr) {
			$sumaTotal[]=$pr["NLocales"];
			}
			$data["promedioLocalResuelto"]=intval((array_sum($sumaTotal))/count($sumaTotal));
		}else{
			$data["promedioLocalResuelto"]=1;
		}
		$tabla='<p>Pulse <a style="color: #f03434;background-color: transparent;text-decoration: none;" href="'.site_url().'Adm_ModuloConsolidado/ConsolidadoJSCReporte" target="_blank">Aquí</a> para ver el detalle del reporte...</p>
		<h2 align="center" style="font-family: Verdana, Geneva, sans-serif;color:#F03434;">Registro de Rutas</h2>
		<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Número de Rutas</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas Completadas</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas en Ejecución</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas Faltantes</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Requerimiento</th>
                    </tr>
                </thead>
                <tbody>';
		foreach ($tablaReq as $tr) {
			$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NRutas"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NCompletadas"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NEjecucion"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NRutasFaltantes"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["Requerimiento"].'</td>
				</tr>';
		}
		$tabla.='</tbody>
			</table>
			<br>';
			$tabla.='<h2 align="center" style="font-family: Verdana, Geneva, sans-serif;color:#F03434;">Requerimientos Especiales</h2>
			<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Requerimiento</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Fecha</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Latitud</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Longitud</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($tablaRequerimiento as $tb) {
        	$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Requerimiento"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Fecha"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Latitud"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Longitud"].'</td>
				</tr>';
        }
        $tabla.='</tbody>
			</table>
			<br>';
		$tabla.='<h2 align="center" style="font-family: Verdana, Geneva, sans-serif;color:#F03434;">Registro de Marcación</h2>
		<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Cargo</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Local</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Entrada</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Salida</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Marca Entrada</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Marca Salida</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Tiempo en PDO</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Permiso</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($tablaMaestra as $tm) {
        	$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Cargo"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["NombreLocal"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Entrada"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Salida"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["HoraEntrada"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["HoraSalida"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["TiempoPDO"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["NombrePermiso"].'</td>
				</tr>';
        }
        $tabla.='</tbody>
			</table>
			<br>';
		$this->load->view('contenido');
	   	$this->load->view('admin/adminConsolidado',$data);
		$titulo  ='Reporte Diario de atrasos';
		$email   ='jordan.fernandez@audisischile.com';
		$mensaje ='<!DOCTYPE html>
		<html>
		<head>
  		<meta charset="utf-8" />
			<title>Reporte</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		</head>

		<body>
			<div style="width:800px; margin:0 auto;">
			<img align="center" style="padding-left:35%;width: 200px;height: 110px;" src="https://rsandk.com/wp-content/uploads/2016/11/SC-Johnson-150x120.png">

			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Programadas para Hoy: '.$data["Rutas"]["Rutas"].' </p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas en Ejecución: '.$ruta_ejec.'</p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Completadas: '.$data["Marcas"]["Asistencias"].'</p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Faltantes: '.$faltante.'</p></div>
			</div>
			<br>
			'.$tabla.'
		</body>
		</html>';

		$this->enviaremailReporte($email,$mensaje,$titulo);
	}

	function ConsolidadoJSCReporte(){
		$BD="I-Audisis_JSC";
		$this->load->model("ModuloConsolidado");
		$data["Rutas"]=$this->ModuloConsolidado->ContarRutasActivas($BD);
		$data["Marcas"]=$this->ModuloConsolidado->ContarMarcaUsuarios($BD);
		$data["Ejec"]=$this->ModuloConsolidado->ContarRutasEjecucion($BD);
		$data["NUsuarios"]=$this->ModuloConsolidado->ContarUsuariosRutas($BD);
		$data["TablaUser"]=$this->ModuloConsolidado->CargarTablaUsuarios($BD);
		$data["Req"]=$this->ModuloConsolidado->TablaUsuarioRequerimiento($BD);
		$resultado=$this->ModuloConsolidado->PromedioTiempoRutas($BD);
		$data["Requerimiento"]=$this->ModuloConsolidado->TablaConReq($BD);
		$ruta_ejec=$data["NUsuarios"]["Usuarios"]-$data["Marcas"]["Asistencias"];
		$faltante=$data["Rutas"]["Rutas"]-$data["Marcas"]["Asistencias"];
		$data["Promedio"]=$resultado["Diferencia"];
		$data["foto"]="jsc.png";
		$promedioLocal=$this->ModuloConsolidado->LocalesPorUsuarios($BD);
		if ($promedioLocal!=null) {
			foreach ($promedioLocal as $pr) {
			$sumaTotal[]=$pr["NLocales"];
			}
			$data["promedioLocalResuelto"]=intval((array_sum($sumaTotal))/count($sumaTotal));
		}else{
			$data["promedioLocalResuelto"]=1;
		}
		$this->load->view('contenido');
	   	$this->load->view('admin/adminConsolidado',$data);
	}

	function ConsolidadoPFAlimentos(){
		$BD="I-Audisis_PFAlimentos";
		$this->load->model("ModuloConsolidado");
		$data["Rutas"]=$this->ModuloConsolidado->ContarRutasActivas($BD);
		$data["Marcas"]=$this->ModuloConsolidado->ContarMarcaUsuarios($BD);
		$data["Ejec"]=$this->ModuloConsolidado->ContarRutasEjecucion($BD);
		$data["NUsuarios"]=$this->ModuloConsolidado->ContarUsuariosRutas($BD);
		$data["Requerimiento"]=$this->ModuloConsolidado->TablaConReq($BD);
		$data["TablaUser"]=$this->ModuloConsolidado->CargarTablaUsuarios($BD);
		$data["Req"]=$this->ModuloConsolidado->TablaUsuarioRequerimiento($BD);
		$resultado=$this->ModuloConsolidado->PromedioTiempoRutas($BD);
		$data["Promedio"]=substr($resultado["Diferencia"],0,4).substr($resultado["Diferencia"],5,3);
		$data["foto"]="LOGO-PGAlimentos.png";
		$promedioLocal=$this->ModuloConsolidado->LocalesPorUsuarios($BD);
		if ($promedioLocal!=null) {
			foreach ($promedioLocal as $pr) {
			$sumaTotal[]=$pr["NLocales"];
			}
			$data["promedioLocalResuelto"]=intval((array_sum($sumaTotal))/count($sumaTotal));
		}else{
			$data["promedioLocalResuelto"]=1;
		}
		$this->load->view('contenido');
	   	$this->load->view('admin/adminConsolidado',$data);
	}

	function ConsolidadoPruebaCliente(){
		$BD="I-Audisis_PruebaCliente";
		$this->load->model("ModuloConsolidado");
		$data["Rutas"]=$this->ModuloConsolidado->ContarRutasActivas($BD);
		$data["Marcas"]=$this->ModuloConsolidado->ContarMarcaUsuarios($BD);
		$data["Ejec"]=$this->ModuloConsolidado->ContarRutasEjecucion($BD);
		$data["NUsuarios"]=$this->ModuloConsolidado->ContarUsuariosRutas($BD);
		$data["TablaUser"]=$this->ModuloConsolidado->CargarTablaUsuarios($BD);
		$data["Requerimiento"]=$this->ModuloConsolidado->TablaConReq($BD);
		$data["Req"]=$this->ModuloConsolidado->TablaUsuarioRequerimiento($BD);
		$tablaMaestra=$this->ModuloConsolidado->CargarTablaUsuariosTop10($BD);
		$tablaReq=$this->ModuloConsolidado->TablaConReqTop10($BD);
		$tablaRequerimiento=$this->ModuloConsolidado->TablaUsuarioRequerimientoTop10($BD);
		$resultado=$this->ModuloConsolidado->PromedioTiempoRutas($BD);
		$ruta_ejec=$data["NUsuarios"]["Usuarios"]-$data["Marcas"]["Asistencias"];
		$faltante=$data["Rutas"]["Rutas"]-$data["Marcas"]["Asistencias"];
		$data["Promedio"]=$resultado["Diferencia"];
		$data["foto"]="usuario_1.png";
		$promedioLocal=$this->ModuloConsolidado->LocalesPorUsuarios($BD);
		if ($promedioLocal!=null) {
			foreach ($promedioLocal as $pr) {
			$sumaTotal[]=$pr["NLocales"];
			}
			$data["promedioLocalResuelto"]=intval((array_sum($sumaTotal))/count($sumaTotal));
		}else{
			$data["promedioLocalResuelto"]=1;
		}
		$tabla='<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Número de Rutas</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas Completadas</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas en Ejecución</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas Faltantes</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Requerimiento</th>
                    </tr>
                </thead>
                <tbody>';
		foreach ($tablaReq as $tr) {
			$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NRutas"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NCompletadas"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NEjecucion"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NRutasFaltantes"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["Requerimiento"].'</td>
				</tr>';
		}
		$tabla.='</tbody>
			</table>
			<p>Pulse <a style="color: #f03434;background-color: transparent;text-decoration: none;" href="'.site_url().'Adm_ModuloConsolidado/ConsolidadoPruebaClienteReporte" target="_blank">Aquí</a> para ver el detalle del reporte...</p>
			<br>';
			$tabla.='<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Requerimiento</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Fecha</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Latitud</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Longitud</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($tablaRequerimiento as $tb) {
        	$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Requerimiento"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Fecha"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Latitud"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Longitud"].'</td>
				</tr>';
        }
        $tabla.='</tbody>
			</table>
			<p>Pulse <a style="color: #f03434;background-color: transparent;text-decoration: none;" href="'.site_url().'Adm_ModuloConsolidado/ConsolidadoPruebaClienteReporte" target="_blank">Aquí</a> para ver el detalle del reporte...</p>
			<br>';
		$tabla.='<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Cargo</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Local</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Entrada</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Salida</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Marca Entrada</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Marca Salida</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Tiempo en PDO</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Permiso</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($tablaMaestra as $tm) {
        	$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Cargo"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["NombreLocal"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Entrada"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Salida"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["HoraEntrada"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["HoraSalida"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["TiempoPDO"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["NombrePermiso"].'</td>
				</tr>';
        }
        $tabla.='</tbody>
			</table>
			<p>Pulse <a style="color: #f03434;background-color: transparent;text-decoration: none;" href="'.site_url().'Adm_ModuloConsolidado/ConsolidadoPruebaClienteReporte" target="_blank">Aquí</a> para ver el detalle del reporte...</p>
			<br>';
		$this->load->view('contenido');
	   	$this->load->view('admin/adminConsolidado',$data);
	   	// $config = array(
		//   'mailtype' => 'html',
		//   'charset'  => 'utf-8',
		//   'priority' => '1'
		// );
		//$this->email->initialize($config);
		//$this->email->from('audisis@gmail.com', 'audisis');
		$titulo  = 'Reporte Diario de atrasos';
		$email   = 'jordan.fernandez@audisischile.com';
		$mensaje = '<!DOCTYPE html>
		<html>
		<head>
  		<meta charset="utf-8" />
			<title>Reporte</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		</head>

		<body>
			<div>
			<img src="http://www.grupoprogestion.com/assets/img/empresas/audisis-logo.png">

			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Programadas para Hoy: '.$data["Rutas"]["Rutas"].' </p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas en Ejecución: '.$ruta_ejec.'</p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Completadas: '.$data["Marcas"]["Asistencias"].'</p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Faltantes: '.$faltante.'</p></div>
			</div>
			<br>
			<br>
			'.$tabla.'
		</body>
		</html>';
		$this->enviaremailReporte($email,$mensaje,$titulo);
		//$this->email->send();
	}

	function ConsolidadoPruebaClienteReporte(){
		$BD="I-Audisis_PruebaCliente";
		$this->load->model("ModuloConsolidado");
		$data["Rutas"]=$this->ModuloConsolidado->ContarRutasActivas($BD);
		$data["Marcas"]=$this->ModuloConsolidado->ContarMarcaUsuarios($BD);
		$data["Ejec"]=$this->ModuloConsolidado->ContarRutasEjecucion($BD);
		$data["NUsuarios"]=$this->ModuloConsolidado->ContarUsuariosRutas($BD);
		$data["TablaUser"]=$this->ModuloConsolidado->CargarTablaUsuarios($BD);
		$data["Requerimiento"]=$this->ModuloConsolidado->TablaConReq($BD);
		$data["Req"]=$this->ModuloConsolidado->TablaUsuarioRequerimiento($BD);
		$resultado=$this->ModuloConsolidado->PromedioTiempoRutas($BD);
		$data["Promedio"]=$resultado["Diferencia"];
		$data["foto"]="usuario_1.png";
		$promedioLocal=$this->ModuloConsolidado->LocalesPorUsuarios($BD);
		if ($promedioLocal!=null) {
			foreach ($promedioLocal as $pr) {
			$sumaTotal[]=$pr["NLocales"];
			}
			$data["promedioLocalResuelto"]=intval((array_sum($sumaTotal))/count($sumaTotal));
		}else{
			$data["promedioLocalResuelto"]=1;
		}
		$this->load->view('contenido');
	   	$this->load->view('admin/adminConsolidado',$data);
	}

	function ConsolidadoSofrucoReporte(){
		$BD="I-Audisis_Sofruco";
		$this->load->model("ModuloConsolidado");
		$data["Rutas"]=$this->ModuloConsolidado->ContarRutasActivas($BD);
		$data["Marcas"]=$this->ModuloConsolidado->ContarMarcaUsuarios($BD);
		$data["Ejec"]=$this->ModuloConsolidado->ContarRutasEjecucion($BD);
		$data["NUsuarios"]=$this->ModuloConsolidado->ContarUsuariosRutas($BD);
		$data["TablaUser"]=$this->ModuloConsolidado->CargarTablaUsuarios($BD);
		$data["Requerimiento"]=$this->ModuloConsolidado->TablaConReq($BD);
		$data["Req"]=$this->ModuloConsolidado->TablaUsuarioRequerimiento($BD);
		$resultado=$this->ModuloConsolidado->PromedioTiempoRutas($BD);
		$data["Promedio"]=$resultado["Diferencia"];
		$data["foto"]="logo_I-Audisis_Sofruco.png";
		$promedioLocal=$this->ModuloConsolidado->LocalesPorUsuarios($BD);
		if ($promedioLocal!=null) {
			foreach ($promedioLocal as $pr) {
			$sumaTotal[]=$pr["NLocales"];
			}
			$data["promedioLocalResuelto"]=intval((array_sum($sumaTotal))/count($sumaTotal));
		}else{
			$data["promedioLocalResuelto"]=1;
		}
		$this->load->view('contenido');
	   	$this->load->view('admin/adminConsolidado',$data);
	}

	function ConsolidadoSofruco(){
		$BD="I-Audisis_PruebaCliente";
		$this->load->model("ModuloConsolidado");
		$data["Rutas"]=$this->ModuloConsolidado->ContarRutasActivas($BD);
		$data["Marcas"]=$this->ModuloConsolidado->ContarMarcaUsuarios($BD);
		$data["Ejec"]=$this->ModuloConsolidado->ContarRutasEjecucion($BD);
		$data["NUsuarios"]=$this->ModuloConsolidado->ContarUsuariosRutas($BD);
		$data["TablaUser"]=$this->ModuloConsolidado->CargarTablaUsuarios($BD);
		$data["Requerimiento"]=$this->ModuloConsolidado->TablaConReq($BD);
		$data["Req"]=$this->ModuloConsolidado->TablaUsuarioRequerimiento($BD);
		$tablaMaestra=$this->ModuloConsolidado->CargarTablaUsuariosTop10($BD);
		$tablaReq=$this->ModuloConsolidado->TablaConReqTop10($BD);
		$tablaRequerimiento=$this->ModuloConsolidado->TablaUsuarioRequerimientoTop10($BD);
		$resultado=$this->ModuloConsolidado->PromedioTiempoRutas($BD);
		$ruta_ejec=$data["NUsuarios"]["Usuarios"]-$data["Marcas"]["Asistencias"];
		$faltante=$data["Rutas"]["Rutas"]-$data["Marcas"]["Asistencias"];
		$data["Promedio"]=$resultado["Diferencia"];
		$data["foto"]="usuario_1.png";
		$promedioLocal=$this->ModuloConsolidado->LocalesPorUsuarios($BD);
		if ($promedioLocal!=null) {
			foreach ($promedioLocal as $pr) {
			$sumaTotal[]=$pr["NLocales"];
			}
			$data["promedioLocalResuelto"]=intval((array_sum($sumaTotal))/count($sumaTotal));
		}else{
			$data["promedioLocalResuelto"]=1;
		}
		$tabla='<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Número de Rutas</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas Completadas</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas en Ejecución</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Rutas Faltantes</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Requerimiento</th>
                    </tr>
                </thead>
                <tbody>';
		foreach ($tablaReq as $tr) {
			$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NRutas"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NCompletadas"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NEjecucion"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["NRutasFaltantes"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tr["Requerimiento"].'</td>
				</tr>';
		}
		$tabla.='</tbody>
			</table>
			<p>Pulse <a style="color: #f03434;background-color: transparent;text-decoration: none;" href="'.site_url().'Adm_ModuloConsolidado/ConsolidadoPruebaClienteReporte" target="_blank">Aquí</a> para ver el detalle del reporte...</p>
			<br>';
			$tabla.='<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Requerimiento</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Fecha</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Latitud</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Longitud</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($tablaRequerimiento as $tb) {
        	$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Requerimiento"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Fecha"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Latitud"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tb["Longitud"].'</td>
				</tr>';
        }
        $tabla.='</tbody>
			</table>
			<p>Pulse <a style="color: #f03434;background-color: transparent;text-decoration: none;" href="'.site_url().'Adm_ModuloConsolidado/ConsolidadoPruebaClienteReporte" target="_blank">Aquí</a> para ver el detalle del reporte...</p>
			<br>';
		$tabla.='<table style="font-family: Verdana, Geneva, sans-serif;border: 2px solid #F03434;background-color: #EEEEEE;width: 100%;text-align: center;border-collapse: collapse;">
				<thead style="background: #f03434;color:white;">
                    <tr>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Nombres (Rut)</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Cargo</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Local</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Entrada</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Salida</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Marca Entrada</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Marca Salida</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Tiempo en PDO</th>
                        <th style="border: 1px solid #AAAAAA;padding: 3px 2px;font-weight: lighter;">Permiso</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($tablaMaestra as $tm) {
        	$tabla.='<tr style="background: #DEE5EC;">
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Nombres"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Cargo"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["NombreLocal"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Entrada"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["Salida"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["HoraEntrada"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["HoraSalida"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["TiempoPDO"].'</td>
					<td style="border: 1px solid #AAAAAA;padding: 3px 2px;font-size: 13px;">'.$tm["NombrePermiso"].'</td>
				</tr>';
        }
        $tabla.='</tbody>
			</table>
			<p>Pulse <a style="color: #f03434;background-color: transparent;text-decoration: none;" href="'.site_url().'Adm_ModuloConsolidado/ConsolidadoPruebaClienteReporte" target="_blank">Aquí</a> para ver el detalle del reporte...</p>
			<br>';
		$this->load->view('contenido');
	   	$this->load->view('admin/adminConsolidado',$data);
	   	// $config = array(
		//   'mailtype' => 'html',
		//   'charset'  => 'utf-8',
		//   'priority' => '1'
		// );
		//$this->email->initialize($config);
		//$this->email->from('audisis@gmail.com', 'audisis');
		$titulo  = 'Reporte Diario de atrasos';
		$email   = 'jordan.fernandez@audisischile.com';
		$mensaje = '<!DOCTYPE html>
		<html>
		<head>
  		<meta charset="utf-8" />
			<title>Reporte</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		</head>

		<body>
			<div>
			<img src="http://www.grupoprogestion.com/assets/img/empresas/audisis-logo.png">

			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Programadas para Hoy: '.$data["Rutas"]["Rutas"].' </p></div>
			<br>	
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas en Ejecución: '.$ruta_ejec.'</p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Completadas: '.$data["Marcas"]["Asistencias"].'</p></div>
			<br>
			<div style="width: 90%;height: 50px;background: #DEE5EC;border-right:10px solid #f03434;text-align: center;vertical-align: middle;line-height: 45px;" width="152" height="108">Rutas Faltantes: '.$faltante.'</p></div>
			</div>
			<br>
			<br>
			'.$tabla.'
		</body>
		</html>';

		$this->enviaremailReporte($email,$mensaje,$titulo);
		//$this->email->send();
	}



	function enviaremailReporte($email,$mensaje,$titulo){
        
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
        $mail->addAddress($email);
        
        // Add cc or bcc 
		$mail->addCC("notificaciones-audisis@audisischile.com");
		
        $mail->addBCC('');
        
        // Email subject
        $mail->Subject = $titulo;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = $mensaje;
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