<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;


class appNat_Marcaciones extends REST_Controller {

	public function __construct(){

    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Origin: *");

    parent::__construct();
    $this->load->database();
    $this->load->model("app_Marcaciones");

  }

   public function localesmarcaciones_post(){
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
     	$locales=$this->app_Marcaciones->localesasignados($usuario,$token);


     	if(count($locales)==0){
	        $respuesta = array(
	          'error' => TRUE,
	          'mensaje'=> 'Usuario no tiene locales asignados',
	          'data' => $data
	        );
	        $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST);
	        return;
	     } else {
	     	$respuesta=array(0=>array(
	          'fechamarcaciones' => $locales
	        ));
	        $this->response($respuesta,200);
	        return;
	     }
   }


   public function marcaciones_post(){
	   	$data = $this->post();

	   	if( (!isset( $data['usuario'] )  or !isset( $data['accessToken'] ) or !isset( $data['mes'] ) ) or ($data['usuario']===""  OR $data['accessToken']==="" OR $data['mes']==="") ){
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
     	$mes=$data['mes'];
     	$marcaciones=$this->app_Marcaciones->marcaciones($usuario,$token,$mes);

     	if(count($marcaciones)==0){
	        $respuesta = array(
	          'error' => TRUE,
	          'mensaje'=> 'Usuario no tiene marcaciones para el mes seleccionado',
	          'data' => $data
	        );
	        $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST);
	        return;
	     } else {
	     	$respuesta=array(0=>array(
	          'marcaciones' => $marcaciones
	        ));
	        $this->response($respuesta,200);
	        return;
	     }

   }




}