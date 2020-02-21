<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;


class appNat_Asistencia extends REST_Controller {


  public function __construct(){

    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Origin: *");

    parent::__construct();
    $this->load->database();
    $this->load->model("app_Asistencia");     

  }

  public function horarios_post(){
      $data = $this->post();


     if( (!isset( $data['usuario'] )  or !isset( $data['accessToken'] )) or ($data['usuario']===""  OR $data['accessToken']==="") ){
        $respuesta = array(
          'error' => TRUE,
          'mensaje'=> 'La información enviada no es válida',
          'data' => $data
        );
        $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST);
        return;
     }

     $usuario=$data['usuario'];
     $token=$data['accessToken'];
     $horarios=$this->app_Asistencia->horarios($usuario,$token);
     $incidencias=$this->app_Asistencia->incidencias($usuario,$token);

     if(count($horarios)==0){
        $respuesta = array(
          'error' => TRUE,
          'mensaje'=> 'Usuario no tiene horarios asignados',
          'data' => $data
        );
        $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST);
        return;
     } else {
        $respuesta=array(0=>array(
          'error' => FALSE,
          'mensaje' => "Información Válida",
          'horarios' => $horarios,
          'incidencias' => $incidencias
        ));
        $this->response($respuesta,200);
        return;
     }


  }


  public function marcarAsistencia_post(){
    $data = $this->post();

    if( (!isset( $data['usuario'] )  or !isset( $data['accessToken'] ) or !isset( $data['marcaciones'] )) or ($data['usuario']===""  OR $data['accessToken']==="" or count($data['marcaciones'])==0)){
      $data["valido"]=0;
      $this->response( $data, REST_Controller::HTTP_BAD_REQUEST);
      return;
    }

    $usuario=$data['usuario'];
    $token=$data['accessToken'];
    $marca=$data['marcaciones'];

    $arra["usuario"]=$data['usuario'];
    $arra["accessToken"]=$data['accessToken'];

    $m=array();
    $i=0;
    foreach ($marca as $d) {
      $m[$i]["id_asistencia"]=$d['id_asistencia'];
      $m[$i]["id_usuario"]=$d['id_usuario'];
      $m[$i]["id_horario"]=$d['id_horario'];
      $m[$i]["fecha_entrada"]=$d['fecha_entrada'];
      $m[$i]["latitud_ent"]=$d['latitud_ent'];
      $m[$i]["longitud_ent"]=$d['longitud_ent'];
      $m[$i]["distanciapdo_ent"]=$d['distanciapdo_ent'];
      $m[$i]["fecha_salida"]=$d['fecha_salida'];
      $m[$i]["latitud_salida"]=$d['latitud_salida'];
      $m[$i]["longitud_salida"]=$d['longitud_salida'];
      $m[$i]["distanciapdo_salida"]=$d['distanciapdo_salida'];
      $m[$i]["entrada_colacion"]=$d['entrada_colacion'];
      $m[$i]["lat_ent_colacion"]=$d['lat_ent_colacion'];
      $m[$i]["long_ent_colacion"]=$d['long_ent_colacion'];
      $m[$i]["salida_colacion"]=$d['salida_colacion'];
      $m[$i]["lat_sal_colacion"]=$d['lat_sal_colacion'];
      $m[$i]["long_sal_colacion"]=$d['long_sal_colacion'];
      $m[$i]["FK_Jornada_ID_Jornada"]=$d['FK_Jornada_ID_Jornada'];
      $m[$i]["GuardaLocal"]=$d['GuardaLocal'];
      if((isset($d['id_horario']) && isset($d['FK_Jornada_ID_Jornada']) && isset($d['id_usuario'])) or (!is_null($d['id_horario']) && !is_null($d['FK_Jornada_ID_Jornada']) && !is_null($d['id_usuario']))){
        if(isset($d['fecha_entrada']) && !is_null($d['fecha_entrada'])){
          $checksum=$d['id_usuario'].$d['fecha_entrada'].$d['latitud_ent'].$d['longitud_ent'].$d['id_horario'];
          $checksum=openssl_encrypt($checksum,"AES-128-ECB","12314");
          $this->app_Asistencia->MarcarAsistenciaEntrada($usuario,$token,$d['id_horario'],$d['fecha_entrada'],$d['latitud_ent'],$d['longitud_ent'],$d['distanciapdo_ent'],$checksum,$d['FK_Jornada_ID_Jornada'])["valido"];
        }
        if(isset($d['entrada_colacion']) && !is_null($d['entrada_colacion'])){
          $this->app_Asistencia->MarcarAsistenciaEntradaColacion($usuario,$token,$d['id_horario'],$d['entrada_colacion'],$d['lat_ent_colacion'],$d['long_ent_colacion'],$d['FK_Jornada_ID_Jornada'])["valido"];
        }     
        if(isset($d['salida_colacion']) && !is_null($d['salida_colacion'])){
          $this->app_Asistencia->MarcarAsistenciaSalidaColacion($usuario,$token,$d['id_horario'],$d['salida_colacion'],$d['lat_sal_colacion'],$d['long_sal_colacion'],$d['FK_Jornada_ID_Jornada'])["valido"];
        }        
        if(isset($d['fecha_salida']) && !is_null($d['fecha_salida'])){
          $checksum=$d['id_usuario'].$d['fecha_salida'].$d['latitud_salida'].$d['longitud_salida'].$d['id_horario'];
          $checksum=openssl_encrypt($checksum,"AES-128-ECB","12314");
           $m[$i]["valido"]=$this->app_Asistencia->MarcarAsistenciaSalida($usuario,$token,$d['id_horario'],$d['fecha_salida'],$d['latitud_salida'],$d['longitud_salida'],$d['distanciapdo_salida'],$checksum,$d['FK_Jornada_ID_Jornada'])["valido"];
        }
      } else {
        $horario= (isset($d['id_horario']) && !is_null($d['id_horario'])) ? $d['id_horario'] : 0;
        $latitud= (isset($d['latitud_ent']) && !is_null($d['latitud_ent'])) ? $d['latitud_ent'] : 0;
        $longitud= (isset($d['longitud_ent']) && !is_null($d['longitud_ent'])) ? $d['longitud_ent'] : 0;
        $jornada= (isset($d['FK_Jornada_ID_Jornada']) && !is_null($d['FK_Jornada_ID_Jornada'])) ? $d['FK_Jornada_ID_Jornada'] : 0;
        $m[$i]["valido"]=$this->app_Asistencia->error($usuario,$token,$horario,$latitud,$longitud,$jornada)["valido"];
      }
      $i++;
    }

    $arra["marcaciones"]=$m;

     $this->response( $arra, 200);

  }

  public function marcarIncidencia_post(){
    $data = $this->post();

    if( (!isset( $data['usuario'] )  or !isset( $data['accessToken'] ) or !isset( $data['incidencias'] )) or ($data['usuario']===""  OR $data['accessToken']==="" or count($data['incidencias'])==0)){
      $data["valido"]=0;
      $this->response( $data, REST_Controller::HTTP_BAD_REQUEST);
      return;
    }


    $usuario=$data['usuario'];
    $token=$data['accessToken'];
    $inci=$data['incidencias'];

    $arra["usuario"]=$data['usuario'];
    $arra["accessToken"]=$data['accessToken'];

    $m=array();
    $i=0;

    foreach ($inci as $d) {
      $m[$i]["id"]=$d['id'];
      $m[$i]["id_incidencia"]=$d['id_incidencia'];
      $m[$i]["id_usuario"]=$d['id_usuario'];
      $m[$i]["id_horario"]=$d['id_horario'];
      $m[$i]["FK_Jornada_ID_Jornada"]=$d['FK_Jornada_ID_Jornada'];
      $m[$i]["fecha_marcada"]=$d['fecha_marcada'];
      $m[$i]["comentario"]=$d['comentario'];
       if((isset($d['id_horario']) && isset($d['FK_Jornada_ID_Jornada']) && isset($d['id_usuario']) && isset($d['id_incidencia'])) or (!is_null($d['id_horario']) && !is_null($d['FK_Jornada_ID_Jornada']) && !is_null($d['id_usuario']) && !is_null($d['id_incidencia']))){
          $m[$i]["valido"]=$this->app_Asistencia->MarcarIncidencia($usuario,$token,$d['id_incidencia'],$d['id_horario'],$d['FK_Jornada_ID_Jornada'],$d['comentario'],$d['fecha_marcada'])["valido"];
        } else {

        }
      $i++;
    }

    $arra["incidencias"]=$m;

    $this->response( $arra, 200);

  }

  //  public function Marcar_Asistencia_post(){
  //   $data = $this->post();
  //   $BD=$data['BDSecundaria'];
  //   $idUser=$data['usuario'];
  //   $idJor=$data['Idjor'];
  //   $idHor=$data['IDhor'];
  //   $distancia=$data['distancia'];
  //   $lat=$data['Lat'];
  //   $lng=$data['Long'];
  //   // var_dump($data);exit;
  //   $dia=date("j");//dia actual php ini
  //   $mes=date("m");//mes actual php ini
  //   $anio=date("Y");//año actual php ini
  //   $error='none';
  //   $idPerf=3;
  //   $idInc='0';
  //   $idNotificacion=1;
  //   $comentario='Marcacion exitoza por App';
  //   $checksum=$lat.$lng.$idHor;
  //   $checksumEncriptado=openssl_encrypt($checksum,"AES-128-ECB","12314");
  //   $VerAsistencia=$this->ModuloAsistencia->BuscarAsistencia($BD,$idJor);
  //   $info=$this->ModuloAsistencia->BuscarInfoUserEmpleador($BD,$idJor,$idHor);
  //   $idLog=$this->ModuloAsistencia->LogMarcaciones($BD,$lat,$lng,$idHor,$idUser,$idJor,$idPerf,$error);
  //   $idLog=implode($idLog);
  //   if ($VerAsistencia['Entrada']=='' && $VerAsistencia['Salida']== ''){
  //     $this->ModuloAsistencia->MarcarAsisteniaEntrada($BD,$lat,$lng,$idUser,$comentario,$idInc,$idJor,$distancia,$idHor,$idNotificacion,$idLog,$checksumEncriptado);
  //     $resp['tp']='Exito!';//Su entrada ha sido registrada con exito.
  //     $resp['msj']='Su entrada ha sido registrada.';
  //     $respuesta=array(
  //       'error' => FALSE,
  //       'msj' => $resp 
  //     );
  //     $this->response($respuesta);
  //     return;
  //   } elseif ($VerAsistencia['Entrada']!='' && $VerAsistencia['Salida'] == '' && $VerAsistencia['SalidaColacion']!='') {
  //     $id_notificacion=2;
  //     $this->ModuloAsistencia->MarcarAsisteniaSalida($BD,$lat,$lng,$idJor,$distancia,$idHor,$id_notificacion,$idLog,$checksumEncriptado);
  //     $resp['tp']='Exito!';//Su salida ha sido registrada con exito.
  //     $resp['msj']='Su salida ha sido registrada.';
  //     $respuesta=array(
  //       'error' => FALSE,
  //       'msj' => $resp 
  //     );
  //     $this->response($respuesta);
  //     return;
  //   } elseif ($info['id_notificacion']==3 && $VerAsistencia['Salida'] != '' && $VerAsistencia['SalidaColacion']!='') {
  //     $id_notificacion=2;
  //     $this->ModuloAsistencia->MarcarAsisteniaSalida($BD,$lat,$lng,$idJor,$distancia,$idHor,$id_notificacion,$idLog,$checksumEncriptado);
  //     $resp['tp']='Exito!';//Su salida ha sido registrada con exito.
  //     $resp["msj"]='Su salida ha sido registrada';
  //     $respuesta=array(
  //       'error' => FALSE,
  //       'msj' => $resp 
  //     );
  //     $this->response($respuesta);
  //     return;
  //   }elseif ($VerAsistencia['Salida'] == '' && $VerAsistencia['SalidaColacion']=='' && $VerAsistencia['EntradaColacion']!='' && $VerAsistencia['Entrada']!='') {
  //     $resp['tp']= 'Error';//No puede marcar salida si no ha finalizado su Colación
  //     $resp['msj']='No puede marcar salida si no ha finalizado su Colación';
  //     $respuesta=array(
  //       'error' => FALSE,
  //       'msj' => $resp 
  //     );
  //     $this->response($respuesta);
  //     return;
  //   }elseif ($VerAsistencia['Entrada']!='' && $VerAsistencia['Salida'] == '' && $VerAsistencia['SalidaColacion']=='' && $VerAsistencia['EntradaColacion']=='') {
  //     $id_notificacion=2;
  //     $this->ModuloAsistencia->MarcarAsisteniaSalida($BD,$lat,$lng,$idJor,$distancia,$idHor,$id_notificacion,$idLog,$checksumEncriptado);
  //     $resp['tp']='Exito!';//Su salida ha sido registrada con exito.
  //     $resp['msj']='Su salida ha sido registrada';
  //     $respuesta=array(
  //       'error' => FALSE,
  //       'msj' => $resp 
  //     );
  //     $this->response($respuesta);
  //     return;
  //   }else{
  //     $resp['tp']='Error';//Usted ya tiene registrada la Asistencia para el dia de hoy
  //     $resp['msj']='Usted ya tiene registrada la Asistencia para el dia de hoy';
  //     $respuesta=array(
  //       'error' => FALSE,
  //       'msj' => $resp 
  //     );
  //     $this->response($respuesta);
  //     return;
  //   }          
  // }  



}
