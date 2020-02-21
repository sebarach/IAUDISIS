<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloAsistencia extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper("url","form");	
		$this->load->library('form_validation'); 	
		$this->load->model("funcion_login");
		$this->load->library('upload');
    //$this->load->library('email');
    $this->load->library('phpmailer_lib');
	}


  function Asistencia(){
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==3){ 
        $this->load->model("ModuloAsistencia");                   
        $this->load->model("ModuloJornadas");
        $this->load->model("ModuloDocumento");
        $data["Nombre"]=$_SESSION["Nombre"];
        $data["Perfil"] = $_SESSION["Perfil"];
        $data["Cargo"] = $_SESSION["Cargo"];            
        $dia=date("j");//dia actual php ini
        $mes=date("m");//mes actual php ini
        $anio=date("Y");//año actual php ini
        $data['hora']=date("h:i A");//hora am/pm actual php ini
        $idUser=$_SESSION["Usuario"];
        $BD=$_SESSION["BDSecundaria"];
        $msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
        $data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
        $data["cantidadMsj"]=count($data["mensaje"]);
        $data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
        $data["colacion"]=$this->ModuloAsistencia->BuscarColaciones($BD,$idUser);
        $data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
        $data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
        $CantIdjor = $this->ModuloJornadas->CantidaIDjor($BD,$idUser,$dia,$mes,$anio);
        $cant = implode($CantIdjor);
        $this->load->model("moduloUsuarioApp");
        $data["info"]= $this->moduloUsuarioApp->InfoUsuario($_SESSION["Usuario"]);
        if ($cant>1) {// ver cuantas jornadas tiene
          $ListarJornadas = $this->ModuloAsistencia->ListarHorariosDia($BD,$idUser,$dia,$mes,$anio);//ver que jornada tiene abierta
          if (isset($ListarJornadas['FK_Jornadas_ID_Jornada'])) {
            $idJor=$ListarJornadas['FK_Jornadas_ID_Jornada'];
            $data["JornadaUser"]= $this->ModuloJornadas->BuscarHorarioIDjor($BD,$idJor,$idUser,$dia,$mes,$anio);
            $data["ListarIncidencia"]=$this->ModuloAsistencia->ListarIncidenciaActivas($BD);
            $data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
            $this->load->view('contenido');
            $this->load->view('layout/headerApp',$data);
            $this->load->view('layout/sidebarApp',$data);
            $this->load->view('App/BaseApp4',$data);
            $this->load->view('layout/footerApp',$data);
          }else{
            $data["ListarJornadas"] = $this->ModuloJornadas->ListarJornadas($BD,$idUser,$dia,$mes,$anio);//selecionar jornadas por llenar
            $this->load->view('contenido');
            $this->load->view('layout/headerApp',$data);
            $this->load->view('layout/sidebarApp',$data);
            $this->load->view('App/BaseApp3',$data);
            $this->load->view('layout/footerApp',$data);
            }
        }else{    //jornada que queda por llenar            
          $data["JornadaUser"]= $this->ModuloJornadas->BuscarHorario($BD,$idUser,$dia,$mes,$anio);
          $data["ListarIncidencia"]=$this->ModuloAsistencia->ListarIncidenciaActivas($BD);
          $this->load->view('contenido');
          $this->load->view('layout/headerApp',$data);
          $this->load->view('layout/sidebarApp',$data);
          $this->load->view('App/BaseApp2',$data);
          $this->load->view('layout/footerApp',$data);        
        }
      }else{
        redirect(site_url("login/inicio")); 
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

	function AsistenciaPorIdJor(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==3){ 
        if (isset($_POST['Jornada']) && isset($_SESSION["Usuario"]) ) {
          $this->load->model("ModuloAsistencia");                   
          $this->load->model("ModuloJornadas");
          $data["Usuario"]=$_SESSION["Usuario"];          
          $data["Nombre"]=$_SESSION["Nombre"];
          $data["Perfil"] = $_SESSION["Perfil"];
          $data["Cargo"] = $_SESSION["Cargo"];
          $data["Cliente"] = $_SESSION["Cliente"];
          $BD=$_SESSION["BDSecundaria"];
          $idJor=$_POST['Jornada'];

          if ($BD=='I-Audisis_EntelPeru' || $BD=='I-Audisis_AtentoPeru' ) {
            setlocale(LC_TIME, 'es_PE.UTF-8');
            $dia=date("j");//dia actual php ini
            $mes=date("m");//mes actual php ini
            $anio=date("Y");//año actual php ini
            $data['hora']=date("F j, Y, g:i a");//hora am/pm actual php ini
          }else{
            $dia=date("j");//dia actual php ini
            $mes=date("m");//mes actual php ini
            $anio=date("Y");//año actual php ini
            $data['hora']=date("F j, Y, g:i a");//hora am/pm actual php ini              
          }
          $idUser=$_SESSION["Usuario"];
          $data["JornadaUser"]= $this->ModuloJornadas->BuscarHorarioIDjor($BD,$idJor,$idUser,$dia,$mes,$anio);
          $data["ListarIncidencia"]=$this->ModuloAsistencia->ListarIncidenciaActivas($BD);
          $data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
          $data["colacion"]=$this->ModuloAsistencia->BuscarColaciones($BD,$idUser);
          $data["cantidadMsj"]=count($data["mensaje"]);
          $data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
          $data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
          $CantIdjor = $this->ModuloJornadas->CantidaIDjor($BD,$idUser,$dia,$mes,$anio);
          $cant = implode($CantIdjor);
          $this->load->model("moduloUsuarioApp");
          $data["info"]= $this->moduloUsuarioApp->InfoUsuario($_SESSION["Usuario"]);
        
          $this->load->view('contenido');
          $this->load->view('layout/headerApp',$data);
          $this->load->view('layout/sidebarApp',$data);
          $this->load->view('App/BaseApp4',$data);
          $this->load->view('layout/footerApp',$data);
          // header("location:AsistenciaPorIdJor"); 
           // return $this->redirect(array('Adm_ModuloAsistencia/AsistenciaPorIdJor' => 'pages', 'action' => 'AsistenciaPorIdJor')); 
        }else{
          redirect(site_url("menu"));
        }
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
			redirect(site_url("login/inicio"));	
		}
	}

  function MarcarAsistencia(){
    try{
      $this->load->model("ModuloAsistencia");
      $bd1=$_SESSION["BDSecundaria"];
      $lat1=$_POST['latitud1A'];
      $long1=$_POST['longitud1A'];
      $idHor1=$_POST['idHor'];
      $idUsr1=$_SESSION['Usuario'];
      $idJor1=$_POST['idJor'];
      $idPerf1=$_SESSION['Perfil'];
      $error='none';
      if ($bd1=='') {
        $bd1=0;
        $error='Session perdida';
      }  if ($lat1==''){
        $lat1=0;
        $error='Variable vacia';
      }  if ($long1==''){
        $long1=0;
        $error='Variable vacia';
      }  if ($idHor1==''){
        $idHor1=0;
        $error='Variable vacia';
      }  if ($idUsr1==''){
        $idUsr1=0;
        $error='Session perdida';
      }  if ($idJor1==''){
        $idJor1=0;
        $error='Variable vacia';
      }  if ($idPerf1==''){
        $idPerf1=0;
        $error='Session perdida';
      }           
      $idLog=$this->ModuloAsistencia->LogMarcaciones($bd1,$lat1,$long1,$idHor1,$idUsr1,$idJor1,$idPerf1,$error);
		  if($_SESSION['Perfil']==3 ){ 
        $latitud1=$_POST['latitud1A'];
        $longitud1=$_POST['longitud1A'];
        $latitud=$_POST['latitud1A'];
        $longitud=$_POST['longitud1A'];
	   		$idJor=$_POST['idJor'];
	   		$idHor=$_POST['idHor'];
	   		$HoraE=$_POST['_HoraE'];
	   		$HoraS=$_POST['_HoraS'];
	   		$idInc='0'; 
	   		$hora=$_POST['HoraA'];
	   		$comentario=$_POST['txt_comentario'];
	   		$distancia=$_POST['DistanciaPDO'];
	   		$idUser=$_SESSION['Usuario'];
	   		$BD=$_SESSION["BDSecundaria"];
        if($BD=='I-Audisis_EntelPeru' || $BD=='I-Audisis_AtentoPeru' ) {
          setlocale(LC_TIME, 'es_PE.UTF-8');
          $fechaMarcaje=date("F j, Y, g:i a");
          $hora=date('Y-d-m H:i:s');
        }else{
          $fechaMarcaje=date("F j, Y, g:i a");              
        }  	   		
        $idLog=implode($idLog);
        $logM=$this->ModuloAsistencia->BuscarLogMarcaciones($BD,$idLog);
        if ($logM['error']=='none' ) {
          $VerAsistencia=$this->ModuloAsistencia->BuscarAsistencia($BD,$idJor);
          $info=$this->ModuloAsistencia->BuscarInfoUserEmpleador($BD,$idJor,$idHor);
          $NombreUser=$info['nombre'];
          $RutUser=$info['rut'];
          $EmailUser=$info['Email'];
          $EmailCli=$info['EmailCliente'];
          $RutCli=$info['RutEmpresa'];
          $RazonSocial=$info['RazonSocial'];
          $NombreLc=$info['NombreLocal'];
          $Direccion=$info['Direccion'];
          $checksum=$_POST['latitud1A'].$_POST['longitud1A'].$_POST['HoraA'].$fechaMarcaje.$RutUser;
          $checksumEncriptado=openssl_encrypt($checksum,"AES-128-ECB","12314");
          $validar="0";
          if($VerAsistencia['Entrada']!='' && $VerAsistencia['Salida']== ''){
            $entrada= strtotime('+10 minute' , strtotime ( $VerAsistencia['Entrada'] ) );
            $salida= strtotime("now");
            if( $entrada >= $salida ) {
              $validar="0";
            }else{
              $validar="1";
            }
          }else{
            $validar="0";
          }
          if($VerAsistencia['Entrada']=='' && $VerAsistencia['Salida']== ''){
  	   			$hro="Entrada";
  	   			$titulo="Notificacion de Asistencia ".$hro." en el Local:".$NombreLc;
  	   			$idNotificacion=1;
  	   			$msjEmail="
              <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
              <html xmlns='http://www.w3.org/1999/xhtml'>
                <style type='text/css'>
                  ::selection { background-color: #E13300; color: white; }
                  ::-moz-selection { background-color: #E13300; color: white; }

                  body {
                    background-color: #fff;
                    margin: 40px;
                    font: 13px/20px normal Helvetica, Arial, sans-serif;
                    color: #4F5155;
                  }

                  a {
                    color: #003399;
                    background-color: transparent;
                    font-weight: normal;
                  }

                  h1 {
                    color: #444;
                    background-color: transparent;
                    border-bottom: 1px solid #D0D0D0;
                    font-size: 19px;
                    font-weight: normal;
                    margin: 0 0 14px 0;
                    padding: 14px 15px 10px 15px;
                  }

                  h2 {
                    color: #444;
                    background-color: transparent;
                    /*border-bottom: 1px solid #D0D0D0;*/
                    font-size: 15px;
                    font-weight: normal;
                    margin: 0 0 14px 0;
                    padding: 14px 15px 10px 15px;
                  }

                  code {
                    font-family: Consolas, Monaco, Courier New, Courier, monospace;
                    font-size: 12px;
                    background-color: #f9f9f9;
                    border: 1px solid #D0D0D0;
                    color: #002166;
                    display: block;
                    margin: 14px 0 14px 0;
                    padding: 12px 10px 12px 10px;
                  }

                  #container {
                    margin: 10px;
                    border: 1px solid #D0D0D0;
                    box-shadow: 0 0 8px #D0D0D0;
                  }

                  p {
                    margin: 12px 15px 12px 15px;
                  }
                </style>
                <head>
                    <meta charset='utf-8'>
                    <meta http-equiv='x-ua-compatible' content='ie=edge'>
                    <meta name='description' content='Admin, Dashboard, Bootstrap' />
                    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                  <meta name='theme-color' content='#ffffff'>
                </head> 
                <body> 
                  <div id='container'>
                     <div class='list-group'>
                        <h1>Notificaci&oacute;n: <strong>Asistencia </strong></h1>
                        <h2>Estimad@ Sr(a).".$NombreUser."</h2>  
                        <p><h1>Datos del Usuario</h1><br>
                        Rut: ".$RutUser."<br>
                        Hora Marcaje ".$hro.": ".$fechaMarcaje."<br>
                        Hora Entrada: ".$HoraE."<br>
                        Hora Salida: ".$HoraS."<br>
                        Geolocalización(GPS): latitud: ".$latitud." longitud: ".$longitud."
                        incidencia: <br>
                        Comentario de incidencia: ".$comentario."<br>
                      </p>
                        <h1></h1>
                        <p><h1>Datos del Empleador</h1><br>
                          Rut Empleador: ".$RutCli."<br>
                          Razon Social:".$RazonSocial."<br>
                          Nombre de Local: ".$NombreLc."<br>
                          Direcion Local: ".$Direccion."<br>
                        <h2><small class='text-muted'>Est&acute; notificacion se enviar&acute; al Trabajor y al Empleador.</small></h2>
                          <br> 
                          <h1></h1>                           
                          <p>Cheksum: ".$checksumEncriptado."</p>
                        
                    </p>
                    
                    <hr>
                    <h1 style='text-align: right;'><a href='#' >I-Audisis</a> &copy; 2019. </h1>
                  </div>                 
                </body>
              </html>";
    				$this->enviaremail($EmailUser,$msjEmail,$titulo,$EmailCli);
            if($BD=='I-Audisis_EntelPeru' || $BD=='I-Audisis_AtentoPeru' ) {
              $this->ModuloAsistencia->MarcarAsisteniaEntradaPeru($BD,$latitud1,$longitud1,$idUser,$comentario,$idInc,$idJor,$distancia,$idHor,$idNotificacion,$idLog,$checksumEncriptado,$hora);
              echo 1;
            }else{
              $this->ModuloAsistencia->MarcarAsisteniaEntrada($BD,$latitud1,$longitud1,$idUser,$comentario,$idInc,$idJor,$distancia,$idHor,$idNotificacion,$idLog,$checksumEncriptado);
              echo 1;
            }
  	   		}elseif ($VerAsistencia['Entrada']!='' && $VerAsistencia['Salida'] == '' && $VerAsistencia['SalidaColacion']!=''){
  	   			$hro="Salida";
  	   			$titulo="Notificacion de Asistencia ".$hro." en el Local:".$NombreLc;
  	   			$msjEmail="
              <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
              <html xmlns='http://www.w3.org/1999/xhtml'>
                <style type='text/css'>
                  ::selection { background-color: #E13300; color: white; }
                ::-moz-selection { background-color: #E13300; color: white; }
                body {
                  background-color: #fff;
                  margin: 40px;
                  font: 13px/20px normal Helvetica, Arial, sans-serif;
                  color: #4F5155;
                }

                a {
                  color: #003399;
                  background-color: transparent;
                  font-weight: normal;
                }

                h1 {
                  color: #444;
                  background-color: transparent;
                  border-bottom: 1px solid #D0D0D0;
                  font-size: 19px;
                  font-weight: normal;
                  margin: 0 0 14px 0;
                  padding: 14px 15px 10px 15px;
                }

                h2 {
                  color: #444;
                  background-color: transparent;
                  /*border-bottom: 1px solid #D0D0D0;*/
                  font-size: 15px;
                  font-weight: normal;
                  margin: 0 0 14px 0;
                  padding: 14px 15px 10px 15px;
                }

                code {
                  font-family: Consolas, Monaco, Courier New, Courier, monospace;
                  font-size: 12px;
                  background-color: #f9f9f9;
                  border: 1px solid #D0D0D0;
                  color: #002166;
                  display: block;
                  margin: 14px 0 14px 0;
                  padding: 12px 10px 12px 10px;
                }

                #container {
                  margin: 10px;
                  border: 1px solid #D0D0D0;
                  box-shadow: 0 0 8px #D0D0D0;
                }

                p {
                  margin: 12px 15px 12px 15px;
                }
              </style>
              <head>
                <meta charset='utf-8'>
                <meta http-equiv='x-ua-compatible' content='ie=edge'>
                <meta name='description' content='Admin, Dashboard, Bootstrap' />
                <meta name='viewport' content='width=device-width, initial-scale=1.0' />
              <meta name='theme-color' content='#ffffff'>
              </head> 
              <body> 
                <div id='container'>
                   <div class='list-group'>
                      <h1>Notificacio&acute;n: <strong>Asistencia </strong></h1>
                      <h2>Estimad@ Sr(a).".$NombreUser."</h2>  
                      <p><h1>Datos del Usuario</h1><br>
                      Rut: ".$RutUser."<br>
                      Hora Marcaje ".$hro.": ".$fechaMarcaje."<br>
                      Hora Entrada: ".$HoraE."<br>
                      Hora Salida: ".$HoraS."<br>
                      Geolocalización(GPS): latitud: ".$latitud." longitud: ".$longitud."
                      incidencia: <br>
                      Comentario de incidencia: ".$comentario."<br>
                    </p>
                      <h1></h1>
                      <p><h1>Datos del Empleador</h1><br>
                        Rut Empleador: ".$RutCli."<br>
                        Razon Social:".$RazonSocial."<br>
                        Nombre de Local: ".$NombreLc."<br>
                        Direcion Local: ".$Direccion."<br>
                      <h2><small class='text-muted'>Est&acute; notificacion se enviar&acute; al Trabajor y al Empleador.</small></h2>                           
                      <br> 
                        <h1></h1>                           
                        <p>Cheksum: ".$checksumEncriptado."</p>
                  </p>
                  
                  <hr>
                  <h1 style='text-align: right;'><a href='#' >I-Audisis</a> &copy; 2019. </h1>
                </div>                 
                </body>
              </html>";
    				$this->enviaremail($EmailUser,$msjEmail,$titulo,$EmailCli);
    				$id_notificacion=2;
            if ($BD=='I-Audisis_EntelPeru' || $BD=='I-Audisis_AtentoPeru' ) {
              $this->ModuloAsistencia->MarcarAsisteniaSalidaPeru($BD,$latitud1,$longitud1,$idJor,$distancia,$idHor,$id_notificacion,$idLog,$checksumEncriptado,$hora);
              echo 2;
            }else{
              $this->ModuloAsistencia->MarcarAsisteniaSalida($BD,$latitud1,$longitud1,$idJor,$distancia,$idHor,$id_notificacion,$idLog,$checksumEncriptado);
              echo 2;
            }
    	   	}elseif ($info['id_notificacion']==3 && $VerAsistencia['Salida'] != '' && $VerAsistencia['SalidaColacion']!='') {
    	   			$hro="Salida";
    	   			$titulo="Notificacion de Asistencia ".$hro." en el Local:".$NombreLc;
    	   			$msjEmail="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html xmlns='http://www.w3.org/1999/xhtml'>
            <style type='text/css'>
              ::selection { background-color: #E13300; color: white; }
              ::-moz-selection { background-color: #E13300; color: white; }

              body {
                background-color: #fff;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
                color: #4F5155;
              }

              a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
              }

              h1 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 19px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
              }

              h2 {
                color: #444;
                background-color: transparent;
                /*border-bottom: 1px solid #D0D0D0;*/
                font-size: 15px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
              }

              code {
                font-family: Consolas, Monaco, Courier New, Courier, monospace;
                font-size: 12px;
                background-color: #f9f9f9;
                border: 1px solid #D0D0D0;
                color: #002166;
                display: block;
                margin: 14px 0 14px 0;
                padding: 12px 10px 12px 10px;
              }

              #container {
                margin: 10px;
                border: 1px solid #D0D0D0;
                box-shadow: 0 0 8px #D0D0D0;
              }

              p {
                margin: 12px 15px 12px 15px;
              }
            </style>
            <head>
                <meta charset='utf-8'>
                <meta http-equiv='x-ua-compatible' content='ie=edge'>
                <meta name='description' content='Admin, Dashboard, Bootstrap' />
                <meta name='viewport' content='width=device-width, initial-scale=1.0' />
              <meta name='theme-color' content='#ffffff'>
            </head> 
            <body> 
              <div id='container'>
                 <div class='list-group'>
                    <h1>Notificaci&oacute;n: <strong>Asistencia </strong></h1>
                    <h2>Estimad@ Sr(a).".$NombreUser."</h2>  
                    <p>Datos del Usuario<br>
                    Rut: ".$RutUser."<br>
                    Hora Marcaje ".$hro.": ".$fechaMarcaje."<br>
                    Hora Entrada: ".$HoraE."<br>
                    Hora Salida: ".$HoraS."<br>
                    Geolocalización(GPS): latitud: ".$latitud." longitud: ".$longitud."
                    incidencia: <br>
                    Comentario de incidencia: ".$comentario."<br>
                  </p>
                    <h1></h1>
                    <p>Datos del Empleador<br>
                      Rut Empleador: ".$RutCli."<br>
                      Razon Social:".$RazonSocial."<br>
                      Nombre de Local: ".$NombreLc."<br>
                      Direcion Local: ".$Direccion."<br>
                    <h2><small class='text-muted'>Est&acute; notificaci&ocute;n se enviar&acute; al Trabajor y al Empleador.</small></h2>                           
                    <br> 
                      <h1></h1>                           
                      <p>Cheksum: ".$checksumEncriptado."</p>
                </p>
                
                <hr>
                <h1 style='text-align: right;'><a href='#' >I-Audisis</a> &copy; 2019. </h1>
              </div>                 
              </body>
            </html>";	   			
    	   			$this->enviaremail($EmailUser,$msjEmail,$titulo,$EmailCli);
    					$id_notificacion=2;
              if ($BD=='I-Audisis_EntelPeru' || $BD=='I-Audisis_AtentoPeru' ) {
              $this->ModuloAsistencia->MarcarAsisteniaSalidaPeru($BD,$latitud1,$longitud1,$idJor,$distancia,$idHor,$id_notificacion,$idLog,$checksumEncriptado,$hora);
              echo 4;
              }else{
                $this->ModuloAsistencia->MarcarAsisteniaSalida($BD,$latitud1,$longitud1,$idJor,$distancia,$idHor,$id_notificacion,$idLog,$checksumEncriptado);
              echo 4;
            
              }
    	   		}elseif ($VerAsistencia['Salida'] == '' && $VerAsistencia['SalidaColacion']=='' && $VerAsistencia['EntradaColacion']!='' && $VerAsistencia['Entrada']!='') {
    	   			// Jornada marcada
    	   			echo 5;
    	   			// exit;
    	   		}elseif ($VerAsistencia['Entrada']!='' && $VerAsistencia['Salida'] == '' && $VerAsistencia['SalidaColacion']=='' && $VerAsistencia['EntradaColacion']=='') {
              $hro="Salida";
              $titulo="Notificacion de Asistencia ".$hro." en el Local:".$NombreLc;
              $msjEmail="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html xmlns='http://www.w3.org/1999/xhtml'>
            <style type='text/css'>
              ::selection { background-color: #E13300; color: white; }
              ::-moz-selection { background-color: #E13300; color: white; }
              body {
                background-color: #fff;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
                color: #4F5155;
              }

              a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
              }

              h1 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 19px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
              }

              h2 {
                color: #444;
                background-color: transparent;
                /*border-bottom: 1px solid #D0D0D0;*/
                font-size: 15px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
              }

              code {
                font-family: Consolas, Monaco, Courier New, Courier, monospace;
                font-size: 12px;
                background-color: #f9f9f9;
                border: 1px solid #D0D0D0;
                color: #002166;
                display: block;
                margin: 14px 0 14px 0;
                padding: 12px 10px 12px 10px;
              }

              #container {
                margin: 10px;
                border: 1px solid #D0D0D0;
                box-shadow: 0 0 8px #D0D0D0;
              }

              p {
                margin: 12px 15px 12px 15px;
              }
            </style>
            <head>
                <meta charset='utf-8'>
                <meta http-equiv='x-ua-compatible' content='ie=edge'>
                <meta name='description' content='Admin, Dashboard, Bootstrap' />
                <meta name='viewport' content='width=device-width, initial-scale=1.0' />
              <meta name='theme-color' content='#ffffff'>
            </head> 
            <body> 
              <div id='container'>
                 <div class='list-group'>
                    <h1>Notificaci&oacute;n: <strong>Asistencia </strong></h1>
                    <h2>Estimad@ Sr(a).".$NombreUser."</h2>  
                    <p>Datos del Usuario<br>
                    Rut: ".$RutUser."<br>
                    Hora Marcaje ".$hro.": ".$fechaMarcaje."<br>
                    Hora Entrada: ".$HoraE."<br>
                    Hora Salida: ".$HoraS."<br>
                    Geolocalización(GPS): latitud: ".$latitud." longitud: ".$longitud."
                    incidencia: <br>
                    Comentario de incidencia: ".$comentario."<br>
                  </p>
                    <h1></h1>
                    <p>Datos del Empleador<br>
                      Rut Empleador: ".$RutCli."<br>
                      Razon Social:".$RazonSocial."<br>
                      Nombre de Local: ".$NombreLc."<br>
                      Direcion Local: ".$Direccion."<br>
                    <h2><small class='text-muted'>Est&acute; notificacion se enviar&acute; al Trabajor y al Empleador.</small></h2>                           
                    <br> 
                      <h1></h1>                           
                      <p>Cheksum: ".$checksumEncriptado."</p>
                </p>
                
                <hr>
                <h1 style='text-align: right;'><a href='#' >I-Audisis</a> &copy; 2019. </h1>
              </div>                 
              </body>
            </html>";
            $this->enviaremail($EmailUser,$msjEmail,$titulo,$EmailCli);
            $id_notificacion=2;
            if ($BD=='I-Audisis_EntelPeru' || $BD=='I-Audisis_AtentoPeru' ) {
              $this->ModuloAsistencia->MarcarAsisteniaSalidaPeru($BD,$latitud1,$longitud1,$idJor,$distancia,$idHor,$id_notificacion,$idLog,$checksumEncriptado,$hora);
              echo 6;
              }else{
                $this->ModuloAsistencia->MarcarAsisteniaSalida($BD,$latitud1,$longitud1,$idJor,$distancia,$idHor,$id_notificacion,$idLog,$checksumEncriptado);
              echo 6;
            
              }
              
              exit;
            }else{
              echo 3;
              exit;
            }          
          }else{
            
            $msjUsuario="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html xmlns='http://www.w3.org/1999/xhtml'>
              <style type='text/css'>
                ::selection { background-color: #E13300; color: white; }
                ::-moz-selection { background-color: #E13300; color: white; }

                body {
                  background-color: #fff;
                  margin: 40px;
                  font: 13px/20px normal Helvetica, Arial, sans-serif;
                  color: #4F5155;
                }

                a {
                  color: #003399;
                  background-color: transparent;
                  font-weight: normal;
                }

                h1 {
                  color: #444;
                  background-color: transparent;
                  border-bottom: 1px solid #D0D0D0;
                  font-size: 19px;
                  font-weight: normal;
                  margin: 0 0 14px 0;
                  padding: 14px 15px 10px 15px;
                }

                h2 {
                  color: #444;
                  background-color: transparent;
                  /*border-bottom: 1px solid #D0D0D0;*/
                  font-size: 15px;
                  font-weight: normal;
                  margin: 0 0 14px 0;
                  padding: 14px 15px 10px 15px;
                }

                code {
                  font-family: Consolas, Monaco, Courier New, Courier, monospace;
                  font-size: 12px;
                  background-color: #f9f9f9;
                  border: 1px solid #D0D0D0;
                  color: #002166;
                  display: block;
                  margin: 14px 0 14px 0;
                  padding: 12px 10px 12px 10px;
                }

                #container {
                  margin: 10px;
                  border: 1px solid #D0D0D0;
                  box-shadow: 0 0 8px #D0D0D0;
                }

                p {
                  margin: 12px 15px 12px 15px;
                }
              </style>
              <head>
                  <meta charset='utf-8'>
                  <meta http-equiv='x-ua-compatible' content='ie=edge'>
                  <meta name='description' content='Admin, Dashboard, Bootstrap' />
                  <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                <meta name='theme-color' content='#ffffff'>
              </head> 
              <body> 
                <div id='container'>
                   <div class='list-group'>
                      <h1><strong>Error: </strong>Al marcar asistencia</h1>
                      <h2>Estimado. </h2>  
                      <p>Este correo se envía al momento de ocurrir un error al marcar. Favor de comunicarse con su Coordinador. Saludos <br>
                      Error en (GPS): latitud: ".$latitud." longitud: ".$longitud." <br>
                      Usuario con rut:".$RutUser." <br>
                      Erro a las ".$fechaMarcaje." <br>
                    </p>
                  <p><small class='text-muted'>Est&acute; notificación se enviar&acute; al Trabajor y al Empleador.</small></p>
                  <hr>
                  <h1 style='text-align: right;'><a href='#' >I-Audisis</a> &copy; 2019. </h1>
                </div>                 
                </body>
              </html>";
              $msjSoporte="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
              <html xmlns='http://www.w3.org/1999/xhtml'>
              <style type='text/css'>
                ::selection { background-color: #E13300; color: white; }
                ::-moz-selection { background-color: #E13300; color: white; }

                body {
                  background-color: #fff;
                  margin: 40px;
                  font: 13px/20px normal Helvetica, Arial, sans-serif;
                  color: #4F5155;
                }

                a {
                  color: #003399;
                  background-color: transparent;
                  font-weight: normal;
                }

                h1 {
                  color: #444;
                  background-color: transparent;
                  border-bottom: 1px solid #D0D0D0;
                  font-size: 19px;
                  font-weight: normal;
                  margin: 0 0 14px 0;
                  padding: 14px 15px 10px 15px;
                }

                h2 {
                  color: #444;
                  background-color: transparent;
                  /*border-bottom: 1px solid #D0D0D0;*/
                  font-size: 15px;
                  font-weight: normal;
                  margin: 0 0 14px 0;
                  padding: 0px 0px 10px 15px;
                }

                code {
                  font-family: Consolas, Monaco, Courier New, Courier, monospace;
                  font-size: 12px;
                  background-color: #f9f9f9;
                  border: 1px solid #D0D0D0;
                  color: #002166;
                  display: block;
                  margin: 14px 0 14px 0;
                  padding: 12px 10px 12px 10px;
                }

                #container {
                  margin: 10px;
                  border: 1px solid #D0D0D0;
                  box-shadow: 0 0 8px #D0D0D0;
                }

                p {
                  margin: 12px 15px 12px 15px;
                }
              </style>
              <head>
                  <meta charset='utf-8'>
                  <meta http-equiv='x-ua-compatible' content='ie=edge'>
                  <meta name='description' content='Admin, Dashboard, Bootstrap' />
                  <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                <meta name='theme-color' content='#ffffff'>
              </head> 
              <body> 
                <div id='container'>
                   <div class='list-group'>
                      <h1><strong>Error: </strong>Al marcar asistencia</h1>
                      <h2>Falta una variable</h2>  
                      <p>Posibles variable vacias: <br>
                        Nombre BD: ".$logM['NombreBD']." <br>
                        Latitud: ".openssl_decrypt($logM['Lat'],"AES-128-ECB","12314")."<br>
                        Longitud: ".openssl_decrypt($logM['Long'],"AES-128-ECB","12314")."<br>
                        idUsuario: ".$logM['idUsuario']."<br>
                        idHorario: ".$logM['idHorario']."<br>
                        idJor: ".$logM['idJornada']."<br>
                        idPerfil: ".$logM['idPerfil']."</p>
                  
                  <hr>
                  <p>Est&acute; notificación se enviar&acute; solo a soporte.</p>
                  
                </div>                 
              </body>
            </html>";
            $titulo="Error de marcación: ".$error;
            $this->enviaremail($logM['Email'],$msjUsuario,$titulo,$logM['EmailCliente']);
            $this->enviaremailError($msjSoporte,$titulo);
          }
  	    }else{
          $titulo="Error Session";
          // $this->ModuloAsistencia->LogMarcaciones($titulo,$idLog);
          $this->enviaremailError($msjSoporte,$titulo);
  		    redirect(site_url("login"));
  		  }
      } catch (TestException $e) {
          $titulo="Caught TestException ('{$e->getMessage()}')\n{$e}\n";
          // $this->ModuloAsistencia->LogMarcaciones($titulo,$idLog);
          $this->enviaremailError($msjSoporte,$titulo);
      } catch (Exception $e) {
          $titulo= "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
          $this->enviaremailError($msjSoporte,$titulo);
          // $this->ModuloAsistencia->LogMarcaciones($titulo,$idLog);
      }
	} 

 
  public function MarcarColacion(){
    try {
      if ($_SESSION['Perfil']==3 ) {
        $this->load->model("ModuloAsistencia");
        $BD=$_SESSION["BDSecundaria"];
         if ($BD=='I-Audisis_EntelPeru' || $BD=='I-Audisis_AtentoPeru' ) {
            setlocale(LC_TIME, 'es_PE.UTF-8');
            $fechaMarcaje=date("F j, Y, g:i a");
          }else{
            $fechaMarcaje=date("F j, Y, g:i a");              
          }  
        $idJor=$_POST['idJor'];
        $idHor=$_POST['idHor'];
        // $latitud1=openssl_encrypt($_POST['latitud1A'],"AES-128-ECB","12314");
        // $longitud1=openssl_encrypt($_POST['longitud1A'],"AES-128-ECB","12314");
        $latitud1=$_POST['latitud1A'];
        $longitud1=$_POST['longitud1A'];
        $idUser=$_SESSION['Usuario'];
        $idPerf1=$_SESSION['Perfil'];
        $error='none';
        $idLog=$this->ModuloAsistencia->LogMarcaciones($BD,$latitud1,$longitud1,$idHor,$idUser,$idJor,$idPerf1,$error);
        $idLog=implode($idLog);
        $infos=$this->ModuloAsistencia->BuscarColaciones($BD,$idUser);
        $logM=$this->ModuloAsistencia->BuscarLogMarcaciones($BD,$idLog);
        // var_dump($infos['EntradaColacion'],$infos['SalidaColacion']);exit();
        if ($logM['error']=='none') {
           if (!isset($infos['EntradaColacion']) && !isset($infos['SalidaColacion'])) {
            $info=$this->ModuloAsistencia->BuscarCol($BD,$idUser,$idJor);
            // $fechaMarcaje=date("F j, Y, g:i a");
            $hro="Entrada a Colación";
                $titulo="Notificacion de ".$hro." en el Local:".$info['NombreLocal'];
                $msjEmail="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
              <html xmlns='http://www.w3.org/1999/xhtml'>
              <style type='text/css'>
                ::selection { background-color: #E13300; color: white; }
                ::-moz-selection { background-color: #E13300; color: white; }
                body {
                  background-color: #fff;
                  margin: 40px;
                  font: 13px/20px normal Helvetica, Arial, sans-serif;
                  color: #4F5155;
                }

                a {
                  color: #003399;
                  background-color: transparent;
                  font-weight: normal;
                }

                h1 {
                  color: #444;
                  background-color: transparent;
                  border-bottom: 1px solid #D0D0D0;
                  font-size: 19px;
                  font-weight: normal;
                  margin: 0 0 14px 0;
                  padding: 14px 15px 10px 15px;
                }

                h2 {
                  color: #444;
                  background-color: transparent;
                  /*border-bottom: 1px solid #D0D0D0;*/
                  font-size: 15px;
                  font-weight: normal;
                  margin: 0 0 14px 0;
                  padding: 14px 15px 10px 15px;
                }

                code {
                  font-family: Consolas, Monaco, Courier New, Courier, monospace;
                  font-size: 12px;
                  background-color: #f9f9f9;
                  border: 1px solid #D0D0D0;
                  color: #002166;
                  display: block;
                  margin: 14px 0 14px 0;
                  padding: 12px 10px 12px 10px;
                }

                #container {
                  margin: 10px;
                  border: 1px solid #D0D0D0;
                  box-shadow: 0 0 8px #D0D0D0;
                }

                p {
                  margin: 12px 15px 12px 15px;
                }
              </style>
              <head>
                  <meta charset='utf-8'>
                  <meta http-equiv='x-ua-compatible' content='ie=edge'>
                  <meta name='description' content='Admin, Dashboard, Bootstrap' />
                  <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                <meta name='theme-color' content='#ffffff'>
              </head> 
              <body> 
                <div id='container'>
                   <div class='list-group'>
                      <h1>Notificaci&oacute;n: <strong>Colaci&oacute;n </strong></h1>
                      <h2>Estimad@ Sr(a).".$info['Nombre']."</h2>  
                      <p>Datos<br>
                      Hora de ".$hro.": ".$fechaMarcaje."<br>
                      Latitud: ".openssl_decrypt($latitud1,"AES-128-ECB","12314")."<br>
                      Longitud: ".openssl_decrypt($longitud1,"AES-128-ECB","12314")."<br>
                      Nombre del Local: ".$info['NombreLocal']."<br>
                    </p>
                      <h1></h1>
                      <h2><small class='text-muted'>Est&acute; notificacion se enviar&acute; al Trabajor y al Empleador.</small></h2>                           
                      <br> 
                        <h1></h1>
                  </p>
                  
                  <hr>
                  <h1 style='text-align: right;'><a href='#' >I-Audisis</a> &copy; 2019. </h1>
                </div>                 
                </body>
              </html>";
            $this->ModuloAsistencia->MarcarEntradaColacion($BD,$info['ID_Asistencia'],$idUser,$latitud1,$longitud1,$idLog);
            $this->enviaremail($info['Email'],$msjEmail,$titulo,$info['EmailCliente']);
            echo 1;
          }elseif (isset($infos['EntradaColacion']) && !isset($infos['SalidaColacion'])){
            $info=$this->ModuloAsistencia->BuscarCol($BD,$idUser,$idJor);
            $fechaMarcaje=date("F j, Y, g:i a");
            $hro="Salida de Colación";
            $titulo="Notificacion de ".$hro." en el Local:".$info['NombreLocal'];
            $msjEmail="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
          <html xmlns='http://www.w3.org/1999/xhtml'>
          <style type='text/css'>
            ::selection { background-color: #E13300; color: white; }
            ::-moz-selection { background-color: #E13300; color: white; }
            body {
              background-color: #fff;
              margin: 40px;
              font: 13px/20px normal Helvetica, Arial, sans-serif;
              color: #4F5155;
            }

            a {
              color: #003399;
              background-color: transparent;
              font-weight: normal;
            }

            h1 {
              color: #444;
              background-color: transparent;
              border-bottom: 1px solid #D0D0D0;
              font-size: 19px;
              font-weight: normal;
              margin: 0 0 14px 0;
              padding: 14px 15px 10px 15px;
            }

            h2 {
              color: #444;
              background-color: transparent;
              /*border-bottom: 1px solid #D0D0D0;*/
              font-size: 15px;
              font-weight: normal;
              margin: 0 0 14px 0;
              padding: 14px 15px 10px 15px;
            }

            code {
              font-family: Consolas, Monaco, Courier New, Courier, monospace;
              font-size: 12px;
              background-color: #f9f9f9;
              border: 1px solid #D0D0D0;
              color: #002166;
              display: block;
              margin: 14px 0 14px 0;
              padding: 12px 10px 12px 10px;
            }

            #container {
              margin: 10px;
              border: 1px solid #D0D0D0;
              box-shadow: 0 0 8px #D0D0D0;
            }

            p {
              margin: 12px 15px 12px 15px;
            }
          </style>
          <head>
              <meta charset='utf-8'>
              <meta http-equiv='x-ua-compatible' content='ie=edge'>
              <meta name='description' content='Admin, Dashboard, Bootstrap' />
              <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            <meta name='theme-color' content='#ffffff'>
          </head> 
          <body> 
            <div id='container'>
               <div class='list-group'>
                  <h1>Notificación: <strong>Colación </strong></h1>
                  <h2>Estimad@ Sr(a).".$info['Nombre']."</h2>  
                  <p>Datos<br>
                  Hora de ".$hro.": ".$fechaMarcaje."<br>
                  Latitud: ".openssl_decrypt($latitud1,"AES-128-ECB","12314")."<br>
                  Longitud: ".openssl_decrypt($longitud1,"AES-128-ECB","12314")."<br>
                  Nombre del Local: ".$info['NombreLocal']."<br>
                </p>
                  <h1></h1>
                  <h2><small class='text-muted'>Está notificacion se enviará al Trabajor y al Empleador.</small></h2>                           
                  <br> 
             
              </p>
              
              <hr>
              <h1 style='text-align: right;'><a href='#' >I-Audisis</a> &copy; 2019. </h1>
            </div>                 
            </body>
          </html>";
            $this->ModuloAsistencia->MarcarSalidaColacion($BD,$idUser,$latitud1,$longitud1,$idLog);
            $this->enviaremail($info['Email'],$msjEmail,$titulo,$info['EmailCliente']);
            echo 2;
          }else{
            echo 3;
          }
        }
      }else{
        redirect(site_url("login"));
      }

    } catch (Exception $e) {
      $titulo= "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
      $this->enviaremailError($msjSoporte,$titulo);
      // $this->ModuloAsistencia->LogMarcaciones($titulo,$idLog);
    }
  }


  function CorreoSoporte(){
    echo "<div class='modal-content'>
              <div class='modal-header'>
                    <h6 class='modal-title''>Enviar Mensaje a Soporte</h6>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
              </div>
                    <div class='modal-body'>
                    <form id='mCorreoSoporte' method='POST'>
                        <div class='form-group'>
                            <label style='color:white;' for='message-text' class='col-form-label'>Mensaje:</label>
                            <textarea class='form-control' id='msgCorreo' name='msgCorreo' placeholder='Escriba su mensaje'></textarea>
                            <div id='merrormsgCorreo' style='color: red; display: none;'  >
                                                         Debe escribir un mensaje...
                            </div>
                        </div>
                    </form>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-outline-danger' data-dismiss='modal'>Cerrar</button>
                    <button type='button' class='btn btn-outline-danger' onclick='return enviarMensaje();'>Enviar Mensaje</button>
                </div>
            </div>
            <script src='".site_url()."assets/libs/Alertify/js/alertify.js'></script>
            <script type='text/javascript'>

                function enviarMensaje(){
                  $.ajax({                        
                           type: 'POST',                 
                           url:'".site_url()."Adm_ModuloAsistencia/CorreoSoporteF',                   
                           data: $('#mCorreoSoporte').serialize(), 
                           success: function(data)             
                           {                                      
                            alertify.success('Mensaje Enviado');
                            $('#CorreoSoportes').modal('hide');
                           }
                });
               }
             

            </script>
            ";
  }

  function CorreoSoporteF(){
        $msj=$_POST['msgCorreo'];
        $user=$_SESSION["Nombre"];


    $mensaje = "<html xmlns='http://www.w3.org/1999/xhtml'>
   <style type='text/css'>
     ::selection { background-color: #E13300; color: white; }
     ::-moz-selection { background-color: #E13300; color: white; }
     body {
       background-color: #fff;
       margin: 40px;
       font: 13px/20px normal Helvetica, Arial, sans-serif;
       color: #4F5155;
     }

     a {
       color: #003399;
       background-color: transparent;
       font-weight: normal;
     }

     h1 {
       color: #444;
       background-color: transparent;
       border-bottom: 1px solid #D0D0D0;
       font-size: 19px;
       font-weight: normal;
       margin: 0 0 14px 0;
       padding: 14px 15px 10px 15px;
     }

     h2 {
       color: #444;
       background-color: transparent;
       /*border-bottom: 1px solid #D0D0D0;*/
       font-size: 15px;
       font-weight: normal;
       margin: 0 0 14px 0;
       padding: 14px 15px 10px 15px;
     }

     code {
       font-family: Consolas, Monaco, Courier New, Courier, monospace;
       font-size: 12px;
       background-color: #f9f9f9;
       border: 1px solid #D0D0D0;
       color: #002166;
       display: block;
       margin: 14px 0 14px 0;
       padding: 12px 10px 12px 10px;
     }

     #container {
       margin: 10px;
       border: 1px solid #D0D0D0;
       box-shadow: 0 0 8px #D0D0D0;
     }

     p {
       margin: 12px 15px 12px 15px;
     }
   </style>
   <head>
       <meta http-equiv='x-ua-compatible' content='ie=edge'>
       <meta name='description' content='Admin, Dashboard, Bootstrap' />
       <meta name='viewport' content='width=device-width, initial-scale=1.0' />
     <meta name='theme-color' content='#ffffff'>
   </head> 
   <body> 
     <div id='container'>
        <div class='list-group'>
           <h1>Notificaci&#243;n: <strong>Soporte</strong></h1>
           <p>Solicitante:".$user." </p><br>
           <p>Nombre del Cliente:".$_SESSION["NombreCliente"]." </p><br>
           <p></p><br>
           <p>Causal del problema : . $msj .</p><br>
           <p></p><br>
           <p></p><br>
       </p>
       <hr>
       <h1 style='text-align: right;'><a href='#' >I-Audisis</a> &copy; 2019. </h1>
     </div>                 
     </body>
   </html>";

           $this->enviaremailErrorSoporte($mensaje);
  }

   function CorreoSoportePDV(){
        $this->load->model("ModuloAsistencia");
        $latAct=$_POST['latitud2PDO'];
        $lonAct=$_POST['longitud2PDO'];
        $NombrePDV=$_POST['NombrePDV'];
        $latNew=$_POST['latitud1A'];
        $lonNew=$_POST['longitud1A'];
        $idJor=$_POST['idJor'];
        $idHor=$_POST['idHor'];
        $DistanciaPDO=$_POST['DistanciaPDO'];
        $idcliente=$_SESSION["Cliente"];
        $idUsr1=$_SESSION['Usuario'];
        $user=$_SESSION["Nombre"];
        $this->ModuloAsistencia->SoliActPDV($NombrePDV,$latAct,$lonAct,$idUsr1,$idcliente,$idHor,$idJor,$latNew,$lonNew,$DistanciaPDO);
        $hro="Actualizacion Geografica de PDV";
            $titulo="Notificacion de ".$hro;
            $msjEmail="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
          <html xmlns='http://www.w3.org/1999/xhtml'>
          <style type='text/css'>
            ::selection { background-color: #E13300; color: white; }
            ::-moz-selection { background-color: #E13300; color: white; }
            body {
              background-color: #fff;
              margin: 40px;
              font: 13px/20px normal Helvetica, Arial, sans-serif;
              color: #4F5155;
            }

            a {
              color: #003399;
              background-color: transparent;
              font-weight: normal;
            }

            h1 {
              color: #444;
              background-color: transparent;
              border-bottom: 1px solid #D0D0D0;
              font-size: 19px;
              font-weight: normal;
              margin: 0 0 14px 0;
              padding: 14px 15px 10px 15px;
            }

            h2 {
              color: #444;
              background-color: transparent;
              /*border-bottom: 1px solid #D0D0D0;*/
              font-size: 15px;
              font-weight: normal;
              margin: 0 0 14px 0;
              padding: 14px 15px 10px 15px;
            }

            code {
              font-family: Consolas, Monaco, Courier New, Courier, monospace;
              font-size: 12px;
              background-color: #f9f9f9;
              border: 1px solid #D0D0D0;
              color: #002166;
              display: block;
              margin: 14px 0 14px 0;
              padding: 12px 10px 12px 10px;
            }

            #container {
              margin: 10px;
              border: 1px solid #D0D0D0;
              box-shadow: 0 0 8px #D0D0D0;
            }

            p {
              margin: 12px 15px 12px 15px;
            }
          </style>
          <head>
              <meta charset='utf-8'>
              <meta http-equiv='x-ua-compatible' content='ie=edge'>
              <meta name='description' content='Admin, Dashboard, Bootstrap' />
              <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            <meta name='theme-color' content='#ffffff'>
          </head> 
          <body> 
            <div id='container'>
               <div class='list-group'>
                  <h1>Notificación: <strong>Soporte </strong></h1>
                  <h2>Solicitud de Actualizaci&oacuten Geografica de PDV</h2>  
                  <p>Solicitante:".$user." </p><br>
                  <p>Nombre del Cliente:".$_SESSION["NombreCliente"]." </p><br>
                  <p>Nombre del Local: ".$NombrePDV." </p><br>
                  <p>Georeferencia Ingresada Actualmente del local : latitud(".$latAct.") - longitud(".$lonAct.")</p><br>
                  <p>Nueva Georeferencia Solicitada por el Usuario : latitud ".$latNew." - longitud(".$lonNew.")</p><br>
                  <p></p><br>
                  <p></p><br>
                  <p></p><br>
                  <p></p><br>

              </p>
              
              <hr>
              <h1 style='text-align: right;'><a href='#' >I-Audisis</a> &copy; 2019. </h1>
            </div>                 
            </body>
          </html>";
          $this->enviarEmailsoporte($msjEmail,$titulo);
  }

  
  
   function enviaremail($email,$mensaje,$titulo,$EmailCli){
       
        
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
        $mail->addCC($EmailCli);
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
	
	function enviarEmailsoporte($msjEmail,$titulo){
       
        
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
        $mail->addAddress("notificaciones-audisis@audisischile.com");
        
        // Add cc or bcc 
        $mail->addCC("notificaciones-audisis@audisischile.com");
        $mail->addBCC('');
        
        // Email subject
        $mail->Subject = $titulo;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = $msjEmail;
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
	
	function enviaremailError($msjEmail,$titulo){
       
        
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
        $mailContent = $msjEmail;
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

    function enviaremailErrorSoporte($msjEmail){
       
      // PHPMailer object
      $mail = $this->phpmailer_lib->load();
      
      // SMTP configuration
      $mail->isSMTP();
      $mail->SMTPDebug = 2;
      $mail->Host     ='smtp.tie.cl';
      $mail->SMTPAuth = true;
      $mail->Username = 'no-contestar@audisischile.com';
      $mail->Password = 'Audisis2015';
      $mail->SMTPSecure = 'tls';
      $mail->Port     = 25;
      
      $mail->setFrom('no-contestar@audisischile.com','Equipo Audisis');
      $mail->addReplyTo('','');
      
      // Add a recipient
      $mail->addAddress("powerbi@audisischile.com");
      
      // Add cc or bcc 
      $mail->addCC("notificaciones-audisis@audisischile.com");
      $mail->addBCC('');
      
      // Email subject
      $mail->Subject ="Soporte Iaudisis Chile";
      
      // Set email format to HTML
      $mail->isHTML(true);
      
      // Email body content
      $mailContent = $msjEmail;
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


