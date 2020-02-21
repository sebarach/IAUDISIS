<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
// require_once( APPPATH.'/libraries/Format.php' );
use Restserver\libraries\REST_Controller;


class appNat_Login extends REST_Controller {


  public function __construct(){

    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Origin: *");

    parent::__construct();
    $this->load->database();
    $this->load->model("app_Login");

  }

  public function login_post(){

      $data = $this->post();

     if( (!isset( $data['usuario'] ) OR !isset( $data['pass'] ) ) or ($data['usuario']==="" OR $data['pass']==="" )){
        $respuesta = array(
          'error' => TRUE,
          'mensaje'=> 'La información enviada no es válida',
          'data' => $data
        );
        $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST);
        return;
     }
    
    // Tenemos usuario y contraseña en un post
    $usuario=$data['usuario'];
    $contra=openssl_encrypt($data['pass'],"AES-128-ECB","12314");
    // $contra=openssl_encrypt(base64_decode($data['pass']),"AES-128-ECB","12314");
    $login=$this->app_Login->Login($usuario,$contra);

    if(!isset($login)){
      $respuesta = array(
        'error' => TRUE,
        'mensaje'=> 'Usuario y/o contraseña no son validos'
      );
      $this->response( $respuesta ,REST_Controller::HTTP_BAD_REQUEST);
      return;
    } else {
      
      $respuesta = array(
        'error' => FALSE,
        'mensaje'=> 'Usuario y contraseña correctos ',
        'usuario'=> $login["usuario"],
        'pass'=> $login["pass"],
        'accessToken'=> $login["accessToken"]
      );
      $this->response( $respuesta ,200);
      return;
    }

  }


  function usuario_post(){

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
    // $contra=openssl_encrypt($data['pass'],"AES-128-ECB","12314");
    $token=$data['accessToken'];

    $usu=$this->app_Login->InfoUsuario($usuario,$token);

    if(!isset($usu)){
      $respuesta = array(
        'error' => TRUE,
        'mensaje'=> 'Usuario y/o contraseña no son validos'
      );
      $this->response( $respuesta ,REST_Controller::HTTP_BAD_REQUEST);
      return;
    } else {
    
      $respuesta = array(
        'error' => FALSE,
        'mensaje'=> 'Usuario y contraseña correctos ',
        'id'=> $usu["id_usuario"],
        'nombre'=> $usu["nombre"],
        'telefono'=> $usu["telefono"] ,
        'email'=> $usu["email"],
        'direccion'=> $usu["direccion"],
        'imagen_perfil'=> $usu["imagen"],
        'cargo'=> $usu["cargo"],
        'cliente'=> $usu["cliente"],
        'logo'=> $usu["logo"],
        'user'=> $usu["usuario"],
        'pass'=> $usu["pass"],
        'rut'=> $usu["rut"],
        'id_pais'=> $usu["id_pais"]
      );
      $this->response( $respuesta ,200);
      return;
    }


  }


  function actualizarPassword_post(){

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


     $old=openssl_encrypt($data['user_pass'][0],"AES-128-ECB","12314");
     $new=openssl_encrypt($data['user_pass'][1],"AES-128-ECB","12314");
     $data['valido']=$this->app_Login->actualizarPassword($data['usuario'], $data['accessToken'],$old,$new)['valido'];


     $this->response($data, 200);
  }


  function actualizarPerfil_post(){

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

    $nomfoto= (is_null($data['user']['foto'])) ? "" : "archivos/foto_trabajador/".base64_encode($data['usuario']).".jpg";

    $usuario["user"]=$this->app_Login->actualizarperfil($data['usuario'],$data['accessToken'],$data['user']['email'],$data['user']['direccion'],$data['user']['telefono'],$nomfoto);

    if(!is_null($data['user']['foto'])){
      $content = base64_decode($data['user']['foto']);
      $im = imagecreatefromstring($content);
      if ($im !== false) {
          header('Content-Type: image/jpeg');
          imagejpeg($im, $nomfoto);
          $config['image_library'] = 'gd2';
          $config['source_image'] = $nomfoto; 
          $config['create_thumb'] = FALSE;  
          $config['maintain_ratio'] = FALSE;  
          $config['quality'] = '70%';  
          $config['width'] = 400;  
          $config['height'] = 400;  
          $config['new_image'] =  $nomfoto; 
          $this->load->library('image_lib', $config);
          $this->image_lib->resize();
      }
      else
      {
          $data["error"]='An error occurred.';
      }

    }

     $this->response($usuario, 200);


  }



  




}
