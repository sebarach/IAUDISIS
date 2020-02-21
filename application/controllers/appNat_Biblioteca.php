<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;


class appNat_Biblioteca extends REST_Controller {

	public function __construct(){

	    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
	    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
	    header("Access-Control-Allow-Origin: *");

	    parent::__construct();
	    $this->load->database();
	    $this->load->model("app_Biblioteca");

	}

	public function biblioteca_post(){
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
     	$carpetas=$this->app_Biblioteca->carpetas($usuario, $token);

     	if(count($carpetas)==0){
	        $respuesta = array(
	          'error' => TRUE,
	          'mensaje'=> 'Usuario no tiene horarios asignados',
	          'data' => $data
	        );
	        $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST);
	        return;
	    } else {
	    	$this->response($carpetas,200);
        	return;
	    }


	}


	public function archivos_post(){
		$data = $this->post();

		if( (!isset( $data['usuario'] )  or !isset( $data['accessToken'] ) or !isset( $data['carpeta'] )) or ($data['usuario']===""  OR $data['accessToken']==="" or $data['carpeta']==="")){
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
     	$carpeta=$data['carpeta'];
     	$documentos=$this->app_Biblioteca->archivos($usuario, $token,$carpeta);

     	if(count($documentos)==0){
	        $respuesta = array(
	          'error' => TRUE,
	          'mensaje'=> 'Esta carpeta no tiene archivos.',
	          'data' => $data
	        );
	        $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST);
	        return;
	    } else {
	    	$this->response($documentos,200);
        	return;
	    }

	}

}