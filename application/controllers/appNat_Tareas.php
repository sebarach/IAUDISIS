<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;


class appNat_Tareas extends REST_Controller {


  public function __construct(){

    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Origin: *");

    parent::__construct();
    $this->load->database();
    $this->load->model("app_Tareas");

  }

  public function tareasFormularios_post(){
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

    $tareas=$this->app_Tareas->tareas($usuario,$token);
    $form=$this->app_Tareas->formularios($usuario,$token);
    $mod=$this->app_Tareas->modulos($usuario,$token);
    $preg=$this->app_Tareas->preguntas($usuario,$token);
    $cl=$this->app_Tareas->clusterlocales($usuario,$token);
    $op=$this->app_Tareas->listaopciones($usuario,$token);
    $cel=$this->app_Tareas->clusterelementos($usuario,$token);

    $respuesta = array(0=>array(
      'tareas' => $tareas,
      'formularios' => $form,
      'modulos' => $mod,
      'preguntas' => $preg,
      'clocales' => $cl,
      'opciones' => $op,
      'celementos' => $cel
    ));
    
    $this->response($respuesta);
    return;
  }


  public function respuestasFormulario_post(){
    $data = $this->post();

    if( (!isset( $data['usuario'] )  or !isset( $data['accessToken'] ) or !isset($data['listData'])) or ($data['usuario']===""  OR $data['accessToken']==="" or count($data['listData'])===0) ){
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
    $respuestas=$data['listData'];


    foreach ($respuestas as $res) {
      // //latitud,longitud
      $elemento=(is_null($res["IdElemento"])) ? 'NULL' : $res["IdElemento"];
      $preguntaelemento=(is_null($res["IdPreguntaElemento"])) ? 'NULL' : $res["IdPreguntaElemento"];
      $folder=$this->app_Tareas->agregarRespuestaFormulario($usuario,$token,$res["IdFormulario"],$res["IdAsignacion"],$res["IdLocal"],$res["IdPregunta"],$elemento,$res["Respuesta"],$res["FechaRegistro"],$res["ClaveUnica"],$preguntaelemento,$res["TipoPregunta"],0,0);

      if (!file_exists($folder["ruta"])) {
          mkdir($folder["ruta"], 0777, true); 
      } 


      if(!is_null($res['FotoArray'])){
        $content = base64_decode($res['FotoArray']);
        $im = imagecreatefromstring($content);
        if ($im !== false) {
            header('Content-Type: image/jpeg');
            imagejpeg($im, $folder["folder"]);
        }
        else
        {
            $data["error"]='An error occurred.';
        }
      }

    }

    $this->response($data);
  }


  // public function responder_formulario_post(){
  //   $data = $this->post();
  //   $BD=$data['BDSecundaria'];
  //   $Formulario=$data['Formulario'];  
  //   $Usuario=$data['Usuario'];    
  //   $Pregunta=$data['Pregunta'];
  //   $Asignacion=$data['Asignacion'];
  //   $Local=$data['Local'];
  //   $Elemento=$data['Elemento'];  
  //   $Respuesta=$data['Respuesta'];    
  //   $Latitud=$data['Latitud'];
  //   $Longitud=$data['Longitud'];
  //   $Clave=$data['Clave'];
  //   $resp=$this->moduloFormularioApp->IngresarFormularioRespuesta($BD,$Formulario,$Usuario,$Pregunta,$Asignacion,$Local,$Elemento,$Respuesta,$Latitud,$Longitud,$Clave);
  //   if($resp==''){
  //     $respuesta=array(
  //       'error' => TRUE,
  //     );
  //     $this->response($respuesta);
  //     return;
  //   }
  //   $respuesta=array(
  //     'error' => FALSE,
  //     'Respuesta' => $resp->ID
  //   );
  //   $this->response($respuesta);
  //   return;
  // }

  // public function responder_formulario_foto(){
  //   $target_dir = "archivos/fotosFormulario/I-Audisis_EntelPeru/";
  //   $target_file = $target_dir . basename($_FILES["photo"]["name"]);
  //   $uploadOk = 1;
  //   $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  //   $check = getimagesize($_FILES["photo"]["tmp_name"]);
  //   if($check !== false) {
  //     echo "File is an image - " . $check["mime"] . ".";
  //     $uploadOk = 1;
  //     if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
  //       echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
  //     } else {
  //       echo "Sorry, there was an error uploading your file.";
  //     }
  //   } else {
  //     echo "File is not an image.";
  //     $uploadOk = 0;
  //   }
  // }

  

 

}
