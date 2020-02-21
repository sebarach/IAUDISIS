<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Adm_ModuloTrivia extends CI_Controller {
  public function __construct(){

    parent::__construct();
    $this->load->helper("url","form");  
    $this->load->model("funcion_login");
    $this->load->library('upload');
    $this->load->library('session');
    $this->load->library('form_validation'); 
    $this->load->library('phpexcel');
  }

  function crearPregunta(){
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
        $this->load->model("ModuloTrivia");
        $BD=$_SESSION["BDSecundaria"];
        $data["Usuario"]=$_SESSION["Usuario"];          
        $data["Nombre"]=$_SESSION["Nombre"];
        $data["Perfil"]=$_SESSION["Perfil"];
        $data["Cliente"]=$_SESSION["Cliente"];
        $data["NombreCliente"]=$_SESSION["NombreCliente"];
        $data["Cargo"]=$_SESSION["Cargo"];
        $data["Preguntas"]=$this->ModuloTrivia->listarPreguntas($BD);
        $data["ListarCategoria"]=$this->ModuloTrivia->listarCategorias($BD);
        $data["Clientes"]=$this->funcion_login->elegirCliente();
        $data["Opciones"]=$this->ModuloTrivia->cargarOpciones($BD);
        $this->load->view('contenido');
          $this->load->view('layout/header',$data);
          $this->load->view('layout/sidebar',$data);
          $this->load->view('admin/adminTriviaPregunta',$data);
          $this->load->view('layout/footer',$data);
      }else{
        redirect(site_url("login/inicio")); 
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  //función para generar preguntas para la trivia aleatoria
  function nuevaPregunta(){
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
        $this->load->model("ModuloTrivia");
        $BD=$_SESSION["BDSecundaria"];
        $respCorrecta=intval($_POST["txt_resp"])-1;
        $opcionMaxima=intval($_POST["txt_IDOpcion"])+1;
        $tituloPregunta=$_POST["txtTituloPregunta"];
        if($_POST["mstlCategoria"]==""){
          $categoria=$_POST["txtTipoPregunta"];
          $existe=$this->ModuloTrivia->existeCategoria($categoria,$BD);       
        }else{
          $categoria=$_POST["mstlCategoria"];
          $existe["existe"]=0;
        }
        $dificultad=$_POST["radioInline"];
        $tipoPregunta=$_POST["typePregunta"];
        if ($existe["existe"]==0) {
          $resp[1]['ID']=$this->ModuloTrivia->ingresarPregunta($tituloPregunta,$categoria,$dificultad,$tipoPregunta,$BD);
          $idP=implode($resp[1]['ID']);
          for ($i=0; $i < $opcionMaxima; $i++) { 
            $this->ModuloTrivia->ingresarOpciones($idP,$_POST["txt_elemento".$i],1,$BD);
          }
          $idRespCorrecta=$this->ModuloTrivia->obtenerOpcionCorrecta($idP,$_POST["txt_elemento".$respCorrecta],$BD);
          $this->ModuloTrivia->guardarRespCorrect($idRespCorrecta["ID_TriviaOpciones"],$idP,$BD);
          echo 1;
        }else{
          echo 0;
        }       
      }else{
        redirect(site_url("login/inicio")); 
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  //función para crear la trivia aleatoria
  function crearTrivia(){
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
        $this->load->model("ModuloTrivia");
        $BD=$_SESSION["BDSecundaria"];
        $data["Usuario"]=$_SESSION["Usuario"];          
        $data["Nombre"]=$_SESSION["Nombre"];
        $data["Perfil"]=$_SESSION["Perfil"];
        $data["Cliente"]=$_SESSION["Cliente"];
        $data["NombreCliente"]=$_SESSION["NombreCliente"];
        $data["Cargo"]=$_SESSION["Cargo"];
        $data["Categorias"]=$this->ModuloTrivia->listarPreguntas($BD);
        $data["ListarCategoria"]=$this->ModuloTrivia->listarCategorias($BD);
        $data["Clientes"]=$this->funcion_login->elegirCliente();
        $this->load->view('contenido');
          $this->load->view('layout/header',$data);
          $this->load->view('layout/sidebar',$data);
          $this->load->view('admin/adminTrivias',$data);
          $this->load->view('layout/footer',$data);
      }else{
        redirect(site_url("login/inicio")); 
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  //función para obtener preguntas aleatorias
  function obtenerPreguntaRandom(){
    $this->load->model("ModuloTrivia");
    $BD=$_SESSION["BDSecundaria"];
    $nombreQuiz=$_POST["NombreTrivia"];
    $nModulos=$_POST["nModulos"];
    $nombreModulos=explode(',',$_POST["nombreModulos"]);
    $faciles=explode(',',$_POST["faciles"]);
    $media=explode(',',$_POST["medias"]);
    $dificiles=explode(',',$_POST["dificiles"]);
    $moduleName=json_encode($nombreModulos);
    for ($i=0; $i < $nModulos; $i++) {
      for ($j=0; $j < $faciles[$i]; $j++) { 
        $preguntasFaciles[$i]=$this->ModuloTrivia->listarPreguntasAleatorias($faciles[$i],0,$BD);
      }
      for ($k=0; $k < $media[$i]; $k++) { 
        $preguntasMedias[$i]=$this->ModuloTrivia->listarPreguntasAleatorias($media[$i],1,$BD);
      }
      for ($l=0; $l < $dificiles[$i]; $l++) { 
        $preguntasDificiles[$i]=$this->ModuloTrivia->listarPreguntasAleatorias($dificiles[$i],2,$BD);
      }
    }
    $preguntasFacilesJson=json_encode($preguntasFaciles);
    $contador=1;
    $contadorModulo=1;
    for ($i=0; $i < $nModulos; $i++) { 
      echo "<div class='col-md-12'>
          <form id='frmQuiz' method='POST'>
            <input type='hidden' id='txtNombreQuiz' name='txtNombreQuiz' value='".$nombreQuiz."'>
            <input type='hidden' id='txtNmodulo' name='txtNmodulo' value='".$nModulos."'>
                      <div class='card border-danger text-danger mb-3'>
                          <div class='card-header'>
                              <h1>".$nombreModulos[$i]."</h1>
                          </div>
                          <div class='card-body'>
                              <div class='row'>
                                  <div class='col-md-12'>
                                      <p class='margin'><i class='fa fa-dot-circle-o'></i> Tipo de respuesta esperada</p>";
                                      for ($j=0; $j < $faciles[$i]; $j++) { 
                                        echo "<h6 class='modal-title'>".$preguntasFaciles[$i][$j]["TituloPregunta"]."</h6>";
                                        $opciones=$this->ModuloTrivia->listarOpcionesTrivia($preguntasFaciles[$i][$j]["ID_TriviaPregunta"],$BD);
                                        foreach ($opciones as $op) {
                                          echo "<div class='col-md-2'>
                                                          <div class='radio abc-radio abc-radio-danger radio-inline'>
                                                              <input type='radio' id='inlineRadio".$contador."' name='radioInline".$contadorModulo."'>
                                                              <label for='inlineRadio".$contador."'> ".$op["NombreOpcion"]." </label>
                                                          </div>
                                                      </div>";
                                              $contador++;
                                        }
                                        $contadorModulo++;
                                      }
                                  echo "</div>
                              </div>
                          </div>
                      </div>
                  </form>
                </div>";
    }
    echo "<div class='col-md-12'>
        <button type='button' class='btn btn-theme btn-sm float-md-right' onclick='guardar(".$moduleName.",".$preguntasFacilesJson.");'><i class='fa fa-floppy-o'></i> Guardar Trivia</button>
      </div>

      <script type='text/javascript'>

        function guardar(moduleName,preguntasFaciles){
          var nombreQuiz = $('#txtNombreQuiz').val();
          var nModulos = $('#txtNmodulo').val();
          $.ajax({
            type: 'POST',
                  url: 'guardarTrivia',
                  data: {moduleName:moduleName,nombreQuiz:nombreQuiz,nModulos:nModulos,preguntasFaciles:preguntasFaciles},
                  dataType: 'json',
                  cache: false,
              success: function(data){
              }
          });
        }

      </script>";
  }

  //función para guardar trivia aleatoria

  function guardarTrivia(){
    $this->load->model("ModuloTrivia");
    $id_creador=$_SESSION['Usuario'];
    $BD=$_SESSION["BDSecundaria"];
    $nombreQuiz=$_POST["txtNombreQuiz"];
    $nModulos=$_POST["txtNumeroModulos"];
    $contador=1;
    $id_quiz[1]['ID']=$this->ModuloTrivia->guardarQuiz($id_creador,$nombreQuiz,1,$BD);
    $idq=implode($id_quiz[1]['ID']);
    for ($i=0; $i < $nModulos; $i++) { 
       $this->ModuloTrivia->GuardarModulos($_POST["txtNombreModulo".$contador],$idq,$_POST["txtPorcentaje".$contador],$_POST["txt_baja".$contador],$_POST["txt_media".$contador],$_POST["txt_alta".$contador],$_POST["txt_categoria".$contador],$BD);
       $contador++;
    }
  }

  //función para dibujar el modal que sube un archivo de audio a la pregunta
  function subirAudio(){
    $id_pregunta=$_POST["id"];
    echo "<div class='form-group'>
                <h7 style='color: red;'>Subir Audio</h7> 
                <br>
              <label for='street'>Seleccione un archivo mp3, WMA.</label>
                <div class='btn btn-theme'><i class='mdi mdi-alarm-plus'></i> Selecione Archivo para Ingresar <i id='ingresarExcelSpin' class=''></i> 
                    <form action='subirAudioPregunta' method='POST' id='IngresarAudioPregunta' name='IngresarAudioPregunta' enctype='multipart/form-data' >                    
                        <input type='file' class='btn btn-xs btn-dark' id='audiov' name='audiov'>
                        <input type='hidden' name='txt_id_pregunta' value='".$id_pregunta."'>
                    </form>
                </div>                     
            </div>";
  }

  //función para subir un archivo de audio a la pregunta de la trivia aleatoria
  function subirAudioPregunta(){
    $BD=$_SESSION["BDSecundaria"];
    $id_pregunta=$_POST["txt_id_pregunta"];
    $this->load->model("ModuloTrivia");
    $audio=$this->limpiaEspacio($_FILES['audiov']['name']);
    $R=$this->subirArchivos($audio,0,0);
    $this->ModuloTrivia->guardarAudio($id_pregunta,$audio,$BD);
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
        $this->load->model("ModuloTrivia");
        $BD=$_SESSION["BDSecundaria"];
        $mens['tipo'] = 51; 
        $data["Usuario"]=$_SESSION["Usuario"];          
        $data["Nombre"]=$_SESSION["Nombre"];
        $data["Perfil"]=$_SESSION["Perfil"];
        $data["Cliente"]=$_SESSION["Cliente"];
        $data["NombreCliente"]=$_SESSION["NombreCliente"];
        $data["Cargo"]=$_SESSION["Cargo"];
        $data["Preguntas"]=$this->ModuloTrivia->listarPreguntas($BD);
        $data["ListarCategoria"]=$this->ModuloTrivia->listarCategorias($BD);
        $data["Clientes"]=$this->funcion_login->elegirCliente();
        $data["Opciones"]=$this->ModuloTrivia->cargarOpciones($BD);
        $this->load->view('contenido');
          $this->load->view('layout/header',$data);
          $this->load->view('layout/sidebar',$data);
          $this->load->view('admin/adminTriviaPregunta',$data);
          $this->load->view('layout/footer',$data);
          $this->load->view('layout/mensajes',$mens);
      }
    }
  }

  //función que carga la vista para crear la trivia normal(NO ALEATORIA)
  function crearTriviaNormal(){
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
        $this->load->model("ModuloTrivia");
        $BD=$_SESSION["BDSecundaria"];
        $data["Usuario"]=$_SESSION["Usuario"];          
        $data["Nombre"]=$_SESSION["Nombre"];
        $data["Perfil"]=$_SESSION["Perfil"];
        $data["Cliente"]=$_SESSION["Cliente"];
        $data["NombreCliente"]=$_SESSION["NombreCliente"];
        $data["Cargo"]=$_SESSION["Cargo"];
        $data["ListaMaestraLocales"]=$this->ModuloTrivia->ListarListaMaestraLocales($BD);
        // var_dump($data["ListaMaestraLocales"]);exit();
        $data["Categorias"]=$this->ModuloTrivia->listarPreguntas($BD);
        $data["ListarCategoria"]=$this->ModuloTrivia->listarCategorias($BD);
        $data["Clientes"]=$this->funcion_login->elegirCliente();
        $this->load->view('contenido');
          $this->load->view('layout/header',$data);
          $this->load->view('layout/sidebar',$data);
          $this->load->view('admin/adminCrearTrivias',$data);
          $this->load->view('layout/footer',$data);
      }else{
        redirect(site_url("login/inicio")); 
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  //función para guardar la trivia que se creo en la vista
  function IngresarTriviaPreguntas(){
    // var_dump($_POST);exit();
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
        if (isset($_POST["txt_trivia"])) {
          $this->load->model("ModuloTrivia");
          $igual=0;
          $contadorMod=1;
          $contadorPreg=1;
          $contadorOp=1;
          $contadorOpcion=1;
          $BD=$_SESSION["BDSecundaria"];
          $id_creador=$_SESSION['Usuario'];
          $nombre_trivia=$_POST["txt_trivia"];
          $val=$this->ModuloTrivia->validarExisteTriviaEstatica($nombre_trivia,$BD);
          if ($val=='' || $val==null) {
            echo 1;
            $id_quiz[1]['ID']=$this->ModuloTrivia->guardarQuiz($id_creador,$nombre_trivia,0,$BD);
            $idq=implode($id_quiz[1]['ID']);
             if (isset($_POST["checkTrivia"])) {
                $this->ModuloTrivia->asignarFotoTrivia(1,$idq,$BD);
              }
            if ($_POST["lb_lista_maestra"]=="") {
            }else{
                $this->ModuloTrivia->guardarIdMaestra($idq,intval($_POST["lb_lista_maestra"]),$BD);
            } 
            // primera iteración de módulo
            for ($i=0; $i < intval($_POST["txt_IDModulo"]); $i++) { 
              if (isset($_POST["checkFoto".$contadorMod])) {
                $chkFoto=1;
              }else{
                $chkFoto=0;
              }
              if (isset($_POST["checkObs".$contadorMod])) {
                $chkObs=1;
              }else{
                $chkObs=0;
              }
              if (isset($_POST["checkDesc".$contadorMod])) {
                $checkDesc=1;
              }else{
                $checkDesc=0;
              }
              $id_modulo[$i]=$this->ModuloTrivia->ingresarModuloTriviaEstatica($_POST["txtTituloModulo".$contadorMod],$idq,$_POST["txtPorcentajeModulo".$contadorMod],$chkFoto,$chkObs,$checkDesc,$BD);
              //segunda iteración de preguntas
              for ($j=0; $j < intval($_POST["cuentaPreguntas".$contadorMod]); $j++) { 
                if (isset($_POST["checkNoApl".$contadorMod."_".$contadorPreg])) {
                  $checkNoAplica=1;
                }else{
                  $checkNoAplica=0;
                }
                $id_pregunta[$i][$j]=$this->ModuloTrivia->ingresarPreguntasEstaticas($idq,$_POST["txtTituloPregunta".$contadorMod."-".$contadorPreg],$id_modulo[$i]['ID'],$checkNoAplica,$BD);
                //tercera iteración de opciones
                for ($o=0; $o < intval($_POST["txt_IDOpcion".$contadorMod."_".$contadorPreg]); $o++) { 
                  if (isset($_POST["checkFotoOpcion".$contadorMod."_".$contadorPreg."_".$contadorOp])) {
                    $checkFotoOpcion=1;
                  }else{
                    $checkFotoOpcion=0;
                  }
                  //algoritmo para detectar el ID de la respuesta correcta
                  $matrix[$contadorMod][$contadorPreg][$contadorOp]=$contadorOp;
                  if ($matrix[$contadorMod][$contadorPreg][$contadorOp]==$_POST["txt_resp".$contadorMod."-".$contadorPreg]) {
                    $igual=1;
                  }else{
                    $igual=0;
                  }

                  $id_opcion[$i][$j][$o]=$this->ModuloTrivia->ingresarOpcionesEstaticas($id_pregunta[$i][$j]['ID'],$_POST["txt_elemento".$contadorMod."_".$contadorPreg."_".$contadorOp],$igual,$checkFotoOpcion,$BD);
                  $contadorOp++;
                  $aux=0;
                  if ($id_opcion[$i][$j][$o]==null) {
                  }else{
                    $this->ModuloTrivia->ingresarRespCorrecta($id_opcion[$i][$j][$o]['ID'],$BD);
                    $aux++;
                  }             
                }
                $contadorOp=1;
                $contadorPreg++;
              }
              $contadorPreg=1;
              $contadorMod++;
            }
          }else{
            echo 0;
          }
        }else{
          redirect(site_url("Adm_ModuloTrivia/crearTriviaNormal")); 
        }
      }else{
        redirect(site_url("login/inicio")); 
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  public function subirArchivos($filename){
    $archivo ='audiov';
    $config['upload_path'] = "archivos/audio/"; 
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

  function limpiaEspacio($var){
      $patron = "/[' ']/i";
    $cadena_nueva = preg_replace($patron,"",$var);
    return $cadena_nueva; 
  }

  function adminTrivia(){
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
        $this->load->model("ModuloTrivia");
        $BD=$_SESSION["BDSecundaria"];
        $data["Usuario"]=$_SESSION["Usuario"];          
        $data["Nombre"]=$_SESSION["Nombre"];
        $data["Perfil"]=$_SESSION["Perfil"];
        $data["Cliente"]=$_SESSION["Cliente"];
        $data["NombreCliente"]=$_SESSION["NombreCliente"];
        $data["Cargo"]=$_SESSION["Cargo"];
        $data["Clientes"]=$this->funcion_login->elegirCliente();
        $data["Trivias"]=$this->ModuloTrivia->listarTriviasEstaticas($BD);
        $this->load->view('contenido');
          $this->load->view('layout/header',$data);
          $this->load->view('layout/sidebar',$data);
          $this->load->view('admin/adminTriviasEstaticas',$data);
          $this->load->view('layout/footer',$data);
      }else{
        redirect(site_url("login/inicio")); 
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  //función para editar trivias estáticas, falta guardar los check de descuento,fotografia de modulo,observacion, no aplica y fotografia por opcion
  function editarTrivia(){
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
        $this->load->model("ModuloTrivia");
        $BD=$_SESSION["BDSecundaria"];
        $id_trivia=$_POST["txt_id"];
        $nombre_trivia=$_POST["txt_nombre"];
        $datosModuloQuiz=$this->ModuloTrivia->buscarQuizIDEstaticoModulo($BD,$id_trivia);
        $nModulos=count($datosModuloQuiz);
        $contadorModulos=0;
        $contadorPreguntas=1;
        $contadorPreguntase=2;
        $contadorPreguntasHistorica=1;
        $contadorResp=1;
        $contAux=0;
        $contadorOpcion=1;
        $contadorModulosTotales=0;
        $contMod=1;
        $contPreg=1;
        $contOpci=1;
        $contadorPreguntasModulo=0;
        $datosTrivia=$this->ModuloTrivia->retornoDatosTrivia($id_trivia,$BD);
        $quiz ='<form id="frmEditarQuizStatic" method="POST" enctype="multipart/form-data">
        <div class="row">';
            if($datosTrivia["Foto"]==1){$vigenciaFoto='checked value="1"';}else{$vigenciaFoto='value="0"';}
            $quiz.='<div class="col-md-10">
                Título de la Trivia <input type="text" class="form-control" name="txt_titulo_trivia" id="txt_titulo_trivia" value="'.$nombre_trivia.'">
                <input type="hidden" id="txt_id_titulo_trivia" name="txt_id_titulo_trivia" value="'.$id_trivia.'">
            </div>
            <div class="col-md-2 input-group" style="margin-top:2%;">
                <p class="margin"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p>Fotografía General</p></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" id="vigFotoGeneral" name="vigFotoGeneral" '.$vigenciaFoto.' onclick="vigenciaFoto();"><span class="slider round"></span></label></span>
            </div>
        </div>
        <br>';
        //Aqui se empieza a dibujar el editarTrivia
        for ($i=0; $i < $nModulos; $i++) { 
            if($datosModuloQuiz[$i]["Foto"]==1){$vigenciaFotoMod='checked value="1"';}else{$vigenciaFotoMod='value="0"';}
            if($datosModuloQuiz[$i]["Observacion"]==1){$vigenciaObservacion='checked value="1"';}else{$vigenciaObservacion='value="0"';}
            if($datosModuloQuiz[$i]["Descuento"]==1){$vigenciaDescuento='checked value="1"';}else{$vigenciaDescuento='value="0"';}
            $id_modulo=$datosModuloQuiz[$i]['ID_Modulo_Trivia_Estatica'];
            $TotalPreguntas1 =$this->ModuloTrivia->listarPreguntasPorQuiz($BD,$id_modulo);
            $totals =  $TotalPreguntas1['totalPreguntas'];
            $quiz.='<div class="col-md-12" id="div_modulo_n'.$contMod.'">
                <div class="card border-danger text-danger mb-3"> 
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10"> 
                                <p>Módulo '.$contMod.'</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="nombreModulo'.$contMod.'" name="nombreModulo'.$contMod.'" placeholder="Texto del Módulo" value="'.$datosModuloQuiz[$i]["Nombre_Modulo_Estatica"].'">
                                        <input type="hidden" name="id_modulo'.$contMod.'" id="id_modulo'.$contMod.'" value="'.$datosModuloQuiz[$i]["ID_Modulo_Trivia_Estatica"].'">
                            </div>
                            <div class="col-md-1">
                                <input type="text" class="form-control" id="porcentaje'.$contMod.'" name="porcentaje'.$contMod.'" placeholder="Porcentaje" value="'.$datosModuloQuiz[$i]["Porcentaje"].'">
                            </div>
                            <div class="col-md-2 input-group">
                                <p class="margin"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;<p>Módulo con Descuento</p></p><span class=""><label class="switch"><input type="checkbox" id="vigDescuento'.$contMod.'" name="vigDescuento'.$contMod.'" '.$vigenciaDescuento.' onclick="vigenciaDescuento('.$contMod.');"><span class="slider round"></span></label></span>
                            </div>
                            <div class="col-md-2 input-group">
                                <p class="margin"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p>Fotografía</p></p>&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" id="vigFotoMod'.$contMod.'" name="vigFotoMod'.$contMod.'" '.$vigenciaFotoMod.' onclick="vigenciaFotoMod('.$contMod.');"><span class="slider round"></span></label></span>
                            </div>
                            <div class="col-md-2 input-group">
                                <p class="margin"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p>Observación</p></p>&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" id="vigObservacion'.$contMod.'" name="vigObservacion'.$contMod.'" '.$vigenciaObservacion.' onclick="vigenciaObservacion('.$contMod.');"><span class="slider round"></span></label></span>
                            </div>';
                        $quiz.='</div>
                    </div>
                    
                    <div class="card-body" id="div_modulo'.$contMod.'" tabindex="1">

                    <div class="form__box">
                <button type="button" class="btn btn-theme btn-sm" onclick="agregarPregunta('.$contMod.')"><i class="mdi mdi-plus-circle-outline"></i> Agregar Pregunta</button>
                <button type="button" class="btn btn-theme btn-sm" onclick="quitarPregunta('.$contMod.')"><i class="mdi mdi-minus-circle-outline"></i> Quitar Pregunta</button>
                     </div>
                     <br>
                     <input type="hidden" id="txt_IDPreg'.$contMod.'" name="txt_IDPreg'.$contMod.'" value="'.$totals.'">
                     <input type="hidden" id="txt_IDOpcion'.$contMod.'" value="0">
                        <div class="row">
                        <div class="col-md-12" id="pregunta'.$contMod.'-'.$contadorPreguntas.'">';
                                $preguntas[$i]=$this->ModuloTrivia->listarPreguntasTriviaEstatica($datosModuloQuiz[$i]["ID_Modulo_Trivia_Estatica"],$BD);
                                foreach ($preguntas[$i] as $pr){
                                    if($pr["No_aplica"]==1){$vigenciaNoAplica='checked value="1"';}else{$vigenciaNoAplica='value="0"';}
                                $quiz.='<div class="card border-warning text-warning mb-3" id="pregunta'.$contMod.'-'.$contadorPreguntas.'"
                                > 
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-10"> 
				                                    <p>'.$contadorPreguntas.' .-</p>
				                                </div>
                                    </div>
                                <div class="row">
			                          <div class="col-md-8">
				                            <input type="text" class="form-control" id="nombrePregunta'.$contMod.'-'.$contadorPreguntas.'" name="nombrePregunta'.$contMod.'-'.$contadorPreguntas.'" placeholder="Texto de la Pregunta" value="'.$pr["TituloPreguntaEstatica"].'">
				                            <input type="hidden" name="id_preg'.$contMod.'-'.$contadorPreguntas.'" id="id_preg'.$contMod.'-'.$contadorPreguntas.'" value="'.$pr["ID_TriviaPreguntaEstatica"].'">
				                            <input type="hidden" name="id_preg_correcta'.$contMod.'-'.$contadorPreguntas.'" id="id_preg_correcta'.$contMod.'-'.$contadorPreguntas.'" value="'.$pr["FK_ID_Opcion_Correcta"].'">
			                          </div>
                                <div class="col-md-2 input-group">
                                    <p class="margin"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p>Opción No Aplica</p></p>&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" id="vigNoAplica'.$contMod.'-'.$contadorPreguntas.'" name="vigNoAplica'.$contMod.'-'.$contadorPreguntas.'" '.$vigenciaNoAplica.' onclick="vigenciaNoAplica('.$contMod.','.$contadorPreguntas.');"><span class="slider round"></span></label></span>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-warning btn-sm" name="sube_file" id="sube_file" >Subir Archivo</button>
                                </div>
		                        </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="margin"><i class="fa fa-dot-circle-o"></i> Opciones</p>';
                                    $opciones[$i][$contAux]=$this->ModuloTrivia->listarOpcionesTriviaEstatica($preguntas[$i][$contAux]["ID_TriviaPreguntaEstatica"],$BD);
                                    foreach ($opciones[$i][$contAux] as $op) {
                                        if ($op["NombreOpcion"]==$preguntas[$i][$contAux]["NombreOpcion"]) {
                                              $resp[$i][$contAux]=$contadorResp;
                                            }
                                    $quiz.='
                                    <div class="row">
                                        <div class="input-group col-md-8"><span class="input-group-addon"><i>'.$contadorOpcion.' .-</i></span><input type="text" class="form-control" id="txt_Opcion'.$contMod.'-'.$contadorPreguntas.'-'.$contadorOpcion.'" name="txt_Opcion'.$contMod.'-'.$contadorPreguntas.'-'.$contadorOpcion.'" value="'.$op["NombreOpcion"].'">
                                              <input type="hidden" name="id_opcion'.$contMod.'-'.$contadorPreguntas.'-'.$contadorOpcion.'" id="id_opcion'.$contMod.'-'.$contadorPreguntas.'-'.$contadorOpcion.'" value="'.$op["ID_TriviaOpciones"].'">
                                        </div>
                                        <div class="input-group col-md-2">';
                                            if($op["Activo"]==1){$vigencia='checked value="1"';}else{$vigencia='value="0"';}
                                            $quiz.='<p class="margin"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p id="pActivo'.$contMod.'-'.$contadorPreguntas.'-'.$contadorOpcion.'">Activo</p></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" id="vigModulo'.$contMod.'-'.$contadorPreguntas.'-'.$contadorOpcion.'" name="vigModulo'.$contMod.'-'.$contadorPreguntas.'-'.$contadorOpcion.'" '.$vigencia.' onclick="vigencia('.$contMod.','.$contadorPreguntas.','.$contadorOpcion.');"><span class="slider round"></span></label></span>
                                        </div>
                                        <div class="input-group col-md-2">';
                                            if($op["Foto"]==1){$vigenciaFotoOp='checked value="1"';}else{$vigenciaFotoOp='value="0"';}
                                            $quiz.='<p class="margin"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p id="pActivo'.$contMod.'-'.$contadorPreguntas.'-'.$contadorOpcion.'">Fotografía</p></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" id="vigFotoOp'.$contMod.'-'.$contadorPreguntas.'-'.$contadorOpcion.'" name="vigFotoOp'.$contMod.'-'.$contadorPreguntas.'-'.$contadorOpcion.'" '.$vigenciaFotoOp.' onclick="vigenciaFotoOp('.$contMod.','.$contadorPreguntas.','.$contadorOpcion.');"><span class="slider round"></span></label></span>
                                        </div>
                                    </div>
                                    <br>';
                                    $contadorOpcion++;
                                    $contadorResp++;
                                    $contOpci++;
                                  }
                                  $contOpci=$contOpci-1;
                                  $quiz.='<input type="hidden" id="cuentaOpciones'.$contMod.'_'.$contadorPreguntas.'" value="'.$contOpci.'">
                                  <input type="hidden" name="cuentaOp'.$contMod.'-'.$contadorPreguntas.'" id="cuentaOp'.$contMod.'-'.$contadorPreguntas.'" value="'.$contadorOpcion.'">';
                                  
                                  $contOpci=1;
                                  $contadorOpcion=1;
                                  $quiz.='<hr>
                                  <i class="fa fa-check-circle-o"></i> Respuesta Correcta
                                  <br><br>
                                  <div class="input-group col-md-6"><span class="input-group-addon"><i class="mdi mdi-checkbox-marked-circle-outline"></i></span><input type="number" class="form-control" name="txt_resp'.$contMod.'-'.$contadorPreguntas.'" id="txt_resp'.$contMod.'-'.$contadorPreguntas.'" placeholder="Ingrese el número de la Respuesta Correcta" value="'.$resp[$i][$contAux].'">';
                                  $contadorResp=1;
                                  $quiz.='</div>
                                </div>
                            </div>
                        </div>
                    </div>';  
                    $contPreg++;
                    $contadorPreguntas++;
                    $contadorPreguntasModulo = $contadorPreguntas -1;
                    $contAux++;      
                        }
                        $contPreg=$contPreg-1;
                        $quiz.='<input type="hidden" name="txt_IDPreg_'.$contMod.'" id="txt_IDPreg_'.$contMod.'" value="'.$contPreg.'">
                        <input type="hidden" id="txt_IDPregHistorico' .$contMod.'" name="txt_IDPregHistorico'.$contMod.'" value="'.$contadorPreguntasModulo.'">
                        ';
                        $contPreg=1;
                        $contAux=0;
                        $contadorPreguntas=1;
                        //$contadorPreguntasModulo=0;
                        $quiz.='</div>
                        </div>
                    </div>
                </div>
            </div>';
          $contadorModulos++;
          $contadorModulosTotales++;
          $contMod++;
         // die(var_dump($resp[$i][$contAux]));
          } // termino del primer FOR
          $quiz.='<input type="hidden" id="txt_id_trivia" name="txt_id_trivia" value="'.$id_trivia.'">
              <input type="hidden" id="txt_contador_modulo" name="txt_contador_modulo" value="'.$contadorModulos.'">
              <input type="hidden" id="txt_contador_modulo_origen" name="txt_contador_modulo_origen" value="'.$contadorModulos.'">';
              
              $quiz.='</form>';
          $data["quiz"]=$quiz;
          $data["Usuario"]=$_SESSION["Usuario"];          
          $data["Nombre"]=$_SESSION["Nombre"];
          $data["Perfil"]=$_SESSION["Perfil"];
          $data["Cliente"]=$_SESSION["Cliente"];
          $data["NombreCliente"]=$_SESSION["NombreCliente"];
          $data["Cargo"]=$_SESSION["Cargo"];
          $data["Clientes"]=$this->funcion_login->elegirCliente();
          $this->load->view('contenido');
          $this->load->view('layout/header',$data);
          $this->load->view('layout/sidebar',$data);
          $this->load->view('admin/adminEditarTrivias',$data);
          $this->load->view('layout/footer',$data);
      }else{
        redirect(site_url("login/inicio"));
      }
    }else{
      redirect(site_url("login/inicio"));
    }
  }

  //función que realiza el proceso de edición de las trivias
  function EditarTriviaF(){
    $this->load->model("ModuloTrivia");
    $BD=$_SESSION["BDSecundaria"];
    $id_trivia=$_POST["txt_id_titulo_trivia"];
    $datosModuloQuiz=$this->ModuloTrivia->buscarQuizIDEstaticoModulo($BD,$id_trivia);
    $nombre_trivia=$_POST["txt_titulo_trivia"];
    $nModulos=$_POST["txt_contador_modulo_origen"];
    $ModulosActuales=$_POST["txt_contador_modulo"];
    $contadorModulo=1;
    $contadorPregunta=1;
    $contadorOpcion=1;
    $contadorOp=1;
    $totalModulosHistorico =$nModulos;
    $totalPreguntasHitorico=$_POST["txt_IDPregHistorico".$contadorModulo];
    $DiferenciaPreguntas= $_POST["txt_IDPregHistorico".$contadorModulo] - $_POST["txt_IDPreg".$contadorModulo];
    $nModulosNuevos=intval($_POST["txt_contador_modulo"])-intval($_POST["txt_contador_modulo_origen"]);
    $pI=intval($_POST["txt_contador_modulo_origen"])+1;
    $pF=intval($_POST["txt_contador_modulo"])+1;
    for ($i=0; $i < $nModulos; $i++) {
      if($nModulos > $ModulosActuales) 
      {
        $f = $totalModulosHistorico -1;
        $idmoduloborrar=$datosModuloQuiz[$f]['ID_Modulo_Trivia_Estatica'];
        $resultado = $this->ModuloTrivia->desactivarModuloPorId($idmoduloborrar,$BD);
        $ModulosActuales++;
        $totalModulosHistorico--;
      } 
      $preguntasModulo=$_POST["txt_IDPreg".$contadorModulo];
        
      for ($j=0; $j < $_POST["txt_IDPregHistorico".$contadorModulo]; $j++) 
      { 
      if($_POST["txt_IDPregHistorico".$contadorModulo] > $preguntasModulo) 
      {
        $preguntas=$this->ModuloTrivia->listarPreguntasTriviaEstatica($datosModuloQuiz[$i]["ID_Modulo_Trivia_Estatica"],$BD);
        $UltimaPregunta = $preguntas[0]['cantidad']-1; 
        $idPregunta =  $preguntas[$UltimaPregunta]['ID_TriviaPreguntaEstatica'];
        $this->ModuloTrivia->desactivarPreguntaId($idPregunta,$BD);
      }

        for ($k=1; $k < $_POST["cuentaOp".$contadorModulo."-".$contadorPregunta]; $k++) {
          if ($contadorOpcion==intval($_POST["txt_resp".$contadorModulo."-".$contadorPregunta])) {
            $resp=$_POST["id_opcion".$contadorModulo."-".$contadorPregunta."-".$contadorOpcion];
          }
          if (!isset($resp)) {
            $resp=$_POST["id_preg_correcta".$contadorModulo."-".$contadorPregunta];
          }
          if(isset($_POST["vigModulo".$contadorModulo."-".$contadorPregunta."-".$contadorOpcion])){$vigenciaM="1";}else{ $vigenciaM="0";};
          if(isset($_POST["vigFotoGeneral"])){$vigenciaF="1";}else{ $vigenciaF="0";};
          if(isset($_POST["vigDescuento".$contadorModulo])){$vigenciaDesc="1";}else{ $vigenciaDesc="0";};
          if(isset($_POST["vigFotoMod".$contadorModulo])){$vigenciaFotoMod="1";}else{ $vigenciaFotoMod="0";};
          if(isset($_POST["vigObservacion".$contadorModulo])){$vigenciaObs="1";}else{ $vigenciaObs="0";};
          if(isset($_POST["vigNoAplica".$contadorModulo."-".$contadorPregunta])){$vigenciaNoAplica="1";}else{ $vigenciaNoAplica="0";};
          if(isset($_POST["vigFotoOp".$contadorModulo."-".$contadorPregunta."-".$contadorOpcion])){$vigenciaFotoOP="1";}else{ $vigenciaFotoOP="0";};
          $this->ModuloTrivia->editarTrivia($id_trivia,$nombre_trivia,$_POST["id_modulo".$contadorModulo],$_POST["nombreModulo".$contadorModulo],$_POST["porcentaje".$contadorModulo],$_POST["id_preg".$contadorModulo."-".$contadorPregunta],$_POST["nombrePregunta".$contadorModulo."-".$contadorPregunta],$_POST["id_opcion".$contadorModulo."-".$contadorPregunta."-".$contadorOpcion],$_POST["txt_Opcion".$contadorModulo."-".$contadorPregunta."-".$contadorOpcion],intval($resp),$vigenciaM,$vigenciaF,$vigenciaDesc,$vigenciaFotoMod,$vigenciaObs,$vigenciaNoAplica,$vigenciaFotoOP,$BD); 
          $contadorOpcion++;
        }
        $preguntasModulo++;
        $contadorOpcion=1;
        $contadorPregunta++;
      } 
      $contadorPregunta=1;
      $contadorModulo++;
    }
    $contadorModulo=$pI;
    $contadorPregunta=1;
    $contadorOpcion=1;
    $countAux=0;

    //↑
    //edición existente
    //segunta parte que agrega objetos a la trivia existente
    //edición nueva
    //↓
    // $pI=intval($_POST["txt_contador_modulo_origen"])+1; // 2
    // $pF=intval($_POST["txt_contador_modulo"])+1; // 3
    // $id_modulo[$countAux] = SELECT SCOPE_IDENTITY() as ID = devuelve el ultimo ID INSERTADO
    // $_POST["nombreModulo".$contadorModulo]


  
    for($i=$pI; $i < $pF; $i++) 
    {       
      $titulo = $_POST['nombreModulo'.$contadorModulo];
      $porcentaje = $_POST['porcentaje'.$contadorModulo];
  
      if (isset($_POST["vigFotoMod".$contadorModulo])){
        $chkFoto=1;
      }else{
        $chkFoto=0;
      }
      if (isset($_POST["vigObservacion".$contadorModulo])) {
        $chkObs=1;
      }else{
        $chkObs=0;
      }
      if (isset($_POST["vigDescuento".$contadorModulo])) {
        $checkDesc=1;
      }else{
        $checkDesc=0;
      }
      $id_modulo[$countAux]=$this->ModuloTrivia->ingresarModuloTriviaEstatica($titulo,$id_trivia,$porcentaje,$chkFoto,$chkObs, $checkDesc,$BD);
     
     for ($j=0; $j < $_POST["cuentaPreg".$contadorModulo]; $j++)
      {
        $tituloPregunta = $_POST["nombrePregunta".$contadorModulo."-".$contadorPregunta];
        $idmoduloP = $id_modulo[$countAux]['ID'];
        $id_pregunta[$countAux][$j]=$this->ModuloTrivia->ingresarPreguntasEstaticas($id_trivia,$tituloPregunta,$idmoduloP,$vigenciaNoAplica,$BD);

        for ($k=0; $k < $_POST["cuentaOpciones".$contadorModulo."_".$contadorPregunta]; $k++) 
        {

          if (isset($_POST["vigFotoOp".$contadorModulo.'-'.$contadorPregunta.'-'.$contadorOpcion])){
            $vigFotoOp=1;
          }else{
            $vigFotoOp=0;
          }      
          
          $matrix[$contadorModulo][$contadorPregunta][$contadorOpcion]=$contadorOpcion;
          if ($matrix[$contadorModulo][$contadorPregunta][$contadorOpcion]==$_POST["txt_resp".$contadorModulo."-".$contadorPregunta]) {
            $igual=1;
          }else{
            $igual=0;
          }

          $nombreOpcion = $_POST["txt_Opcion".$contadorModulo."-".$contadorPregunta."-".$contadorOpcion];
          $id_opcion[$countAux][$j][$k]=$this->ModuloTrivia->ingresarOpcionesEstaticas($id_pregunta[$countAux][$j]['ID'],$nombreOpcion,$igual,$vigFotoOp,$BD);
         
          $aux=0;
          if($id_opcion[$countAux][$j][$k]==null) 
          {}
            else
          {            
            $this->ModuloTrivia->ingresarRespCorrecta($id_opcion[$countAux][$j][$k]['ID'],$BD);
            $aux++;
          }
          $contadorOpcion++;
        }
        $contadorOpcion=1;
        $contadorPregunta++;
      }
      $countAux++;
      $contadorPregunta=1;
      $contadorModulo++;
    }

  }

  //función que dibuja el modal para subir cualquier tipo de archivo
  function subirArchivo(){
    $this->load->model("ModuloTrivia");
    $BD=$_SESSION["BDSecundaria"];
    $id_pregunta=$_POST["pregunta"];
    $archivo=$this->ModuloTrivia->preguntaArchivo($BD,$id_pregunta);
    if ($archivo[0]["Archivo"]!=null) {
      echo "<h7 style='color: red;'><i class='mdi mdi-alert-outline'></i> Atención!.</h7><p> Esta pregunta tiene asignado el archivo <h7 style='color: red;'>".$archivo[0]["Archivo"].".</h7> Al subir uno nuevo el antiguo se perdera.</p>";
    }
    echo "<div class='form-group'>
                <h7 style='color: red;'>Subir Archivo</h7> 
                <br>
              <label for='street'>Seleccione un archivo de audio, video o imágen.</label>
                <div class='btn btn-theme'><i class='mdi mdi-alarm-plus'></i> Selecione Archivo para Ingresar <i id='ingresarExcelSpin' class=''></i> 
                    <form method='POST' id='IngresarArchivoPregunta' name='IngresarAudioPregunta' enctype='multipart/form-data'>                    
                        <input type='file' class='btn btn-xs btn-dark' id='audiov' name='audiov'>
                        <input type='hidden' name='txt_id_pregunta' value='".$id_pregunta."'>
                    </form>
                </div>                     
            </div>
            <script src='".site_url()."assets/libs/Alertify/js/alertify.js'></script>
            <script type='text/javascript'>

              function validarArchivo(){        
                var formData = new FormData(document.getElementById('IngresarArchivoPregunta'));  
                $('#cargando').show('slow');      
                $.ajax({
                    url: 'subirArchivoPregunta',
                    type: 'POST',
                    dataType: 'html',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        alertify.success('Archivo Ingresado!');
                    $('#modal-subirArchivo').hide('slow');
                    $('#modal-subirArchivo').modal('toggle');
                    $('#cargando').hide();  
                    }
                });
              }

            </script>";
  }

  //función para subir el archivo
  function subirArchivoPregunta(){
    $BD=$_SESSION["BDSecundaria"];
    $id_pregunta=$_POST["txt_id_pregunta"];
    $this->load->model("ModuloTrivia");
    $archivo=$this->limpiaEspacio($_FILES['audiov']['name']);
    $R=$this->subirArchivos($archivo,0,0);
    $this->ModuloTrivia->guardarArchivo($id_pregunta,$archivo,$BD);
  }

  //función que hace la vista para mostarar lso datos de las respuestas de los usuarios

  function respEncuestas(){
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
        $this->load->model("ModuloTrivia");
        $BD=$_SESSION["BDSecundaria"];
        $data["Usuario"]=$_SESSION["Usuario"];          
        $data["Nombre"]=$_SESSION["Nombre"];
        $data["Perfil"]=$_SESSION["Perfil"];
        $data["Cliente"]=$_SESSION["Cliente"];
        $data["NombreCliente"]=$_SESSION["NombreCliente"];
        $data["Cargo"]=$_SESSION["Cargo"];
        $data["Tabla"]=$this->ModuloTrivia->cargarTablaRespuestas($BD);
        $data["DatosFiltroU"]=$this->ModuloTrivia->cargarDatosFiltroUsuario($BD);
        $data["DatosFiltroGrupoU"]=$this->ModuloTrivia->cargarDatosFiltroGrupoU($BD);
        $data["DatosFiltroLocal"]=$this->ModuloTrivia->cargarDatosFiltroLocal($BD);
        $data["DatosFiltroTrivia"]=$this->ModuloTrivia->cargarDatosFiltroTrivia($BD);
        $data["DatosFiltroFecha"]=$this->ModuloTrivia->cargarDatosFiltroTriviaFecha($BD);
        $data["GraficoTrivia"]=$this->ModuloTrivia->cargarDatosGraficoTrivia($BD);
        $data["GraficoGrupoU"]=$this->ModuloTrivia->cargarDatosGraficoGrupoU($BD);
        $data["Clientes"]=$this->funcion_login->elegirCliente();
        $this->load->view('contenido');
          $this->load->view('layout/header',$data);
          $this->load->view('layout/sidebar',$data);
          $this->load->view('admin/adminTriviasRespuestas',$data);
          $this->load->view('layout/footer',$data);
      }else{
        redirect(site_url("login/inicio"));
      }
    }else{
      redirect(site_url("login/inicio"));
    }
  }

  //función de filtro multiple hecho con json

  function filtro(){
    if(isset($_SESSION["sesion"])){
      if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
        $this->load->model("ModuloTrivia");
        $BD=$_SESSION["BDSecundaria"];

        if(isset($_POST["usuario"]) || $_POST["usuario"]!=""){
          $usuario=$_POST["usuario"];
        } else {
          $usuario="0";
        }

        if(isset($_POST["grupo_usuario"]) || $_POST["grupo_usuario"]!=""){
          $grupo_usuario=$_POST["grupo_usuario"];
        } else {
          $grupo_usuario="0";
        }

        if(isset($_POST["local"]) || $_POST["local"]!=""){
          $local=$_POST["local"];
        } else {
          $local="0";
        }

        if(isset($_POST["zona"]) || $_POST["zona"]!=""){
          $zona=$_POST["zona"];
        } else {
          $zona="0";
        }

        if(isset($_POST["fecha"]) || $_POST["fecha"]!=""){
          $fecha=$_POST["fecha"];
        } else {
          $fecha="01-01-1900";
        }

        if(isset($_POST["trivia"]) || $_POST["trivia"]!=""){
          $trivia=$_POST["trivia"];
        } else {
          $trivia="0";
        }
        $data["tf"]=$this->ModuloTrivia->triviaRespFiltrada($usuario,$grupo_usuario,$local,$zona,$fecha,$trivia,$BD);
          echo json_encode($data);
      }else{
        redirect(site_url("login/inicio"));
      }
    }else{
      redirect(site_url("login/inicio"));
    }
  }

  //función para generar excel según los datos filtrados y promedio calculado en la vista de respuesta
  function generarExcelResultados(){    
    $BD=$_SESSION["BDSecundaria"];
      $this->load->library('phpexcel');
      $this->load->model("ModuloTrivia");
      $respUser=$this->ModuloTrivia->ListarResultadoTriviaPorUsuario($BD);
      $cantidad=$_POST["txt_cont"];
      $column_row=2;
      $contador=1;
      $objReader =  PHPExcel_IOFactory::createReader('Excel2007');    
      $objectUser = $objReader->load("doc/plantilla/RespuestasEncuestas.xlsx");
    $object = $objReader->load("doc/plantilla/RespuestasEncuestas.xlsx");
    $object->setActiveSheetIndex(0); 
    for ($i=0; $i < $cantidad; $i++) { 
      $object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $_POST["txt_nombre_user".$contador]);
      $object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $_POST["txt_grupo_user".$contador]);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $_POST["txt_local".$contador]);
      $object->getActiveSheet()->setCellValueByColumnAndRow(3 , $column_row, $_POST["txt_zona".$contador]);
      $object->getActiveSheet()->setCellValueByColumnAndRow(4 , $column_row, date("d-m-Y",strtotime($_POST["txt_fecha".$contador])));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5 , $column_row, $_POST["txt_nombre".$contador]);
      $object->getActiveSheet()->setCellValueByColumnAndRow(6 , $column_row, $_POST["txt_contador_prom".$contador]);
      $nota[$contador]=$object->getActiveSheet()->getCell('G'.$column_row)->getFormattedValue();  
      //dependiendo del porcentaje pintara las celdas del excel
      if ($nota[$contador]<70) {
        $object->getActiveSheet()->getStyle('G'.$column_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f40000');
      }
      if ($nota[$contador]>70 && $nota[$contador]<90) {
        $object->getActiveSheet()->getStyle('G'.$column_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fff200');
      }
      elseif ($nota[$contador]>90) {
        $object->getActiveSheet()->getStyle('G'.$column_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00ef1b');
      }   
      $column_row++;
      $contador++;
    }
    $contador=1;
    $column_row=2;
    $object->getActiveSheet()->setCellValueByColumnAndRow(8,1,$_POST["txt_resultado_aux"]);
    $object->setActiveSheetIndex(1);
    foreach ($respUser as $ru) {
      $object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $ru["Nombres"]);   
      $object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $ru["GrupoUser"]);
      $object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $ru["NombreLocal"]);
      $object->getActiveSheet()->setCellValueByColumnAndRow(3 , $column_row, $ru["Zona"]);
      $object->getActiveSheet()->setCellValueByColumnAndRow(4 , $column_row, date("d-m-Y",strtotime($ru["Fecha"])));
      $object->getActiveSheet()->setCellValueByColumnAndRow(5 , $column_row, $ru["Porcentaje"]);
      $column_row++;
      $contador++;
    }
    $object->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="RespuestasEncuestas.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    ob_end_clean();
    $objWriter->save('php://output');
  }


  function galeria($id){
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $BD=$cliente["nombrebd"];
      $data["cli"]=$c;
      $data["link"]=$id;
      $this->load->view('contenido');
      $opcion=(isset($_POST["opcion"])) ? (is_numeric($_POST["opcion"])) ? $_POST["opcion"] : 1 : 1;
      $fecha=(isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $local=(isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $trivia=isset($_POST["trivia"]) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $cadena=(isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $data["opcion"]=$opcion;
      $data["trivia"]=$trivia;
      $data["local"]=$local;
      $data['fecha']=$fecha;
      $data["cadena"]=$cadena;
      $data["tipotarea"]=1;
      if(!isset($_GET["view"])){
        $this->load->view("layout/progress",$data);
        $data["fotos"]=$this->ModuloTrivia->ListarGaleriaFotografica($BD,$trivia,$cadena,$local,$fecha,$opcion);
        $gallery="admin/adminGaleriaTrivia";
      } else {
        $data["view"]=$_GET["view"];
        if(!isset($_POST["lb_anio"])){
          $data["tipotarea"]=3;
          $this->load->view("layout/progress",$data);
        } else {
          $this->load->view("layout/progress",$data);
          $zona=(isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
          $territorio=(isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
          $depto=(isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
          $distrito=(isset($_POST["distrito"])) ? (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
          $provincia=(isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
          $data["zona"]=$zona;
          $data["territorio"]=$territorio;
          $data["depto"]=$depto;
          $data["distrito"]=$distrito;
          $data["provincia"]=$provincia;
          $fe=openssl_decrypt($_GET["view"],"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
          if($fe==1){
            $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ? 0 : $_POST["canal"] : 0;
            $data["canal"]=$canal;
            $tr="FE Personas";
          }  else if($fe==2){
            $tr="FE Mayorista";
            $canal=0;
          }
          $data["tr"]=$tr;
          $data["mes"]=$_POST["lb_anio"];
          $data["fotos"]=$this->ModuloTrivia->ListarGaleriaFotograficaFE($BD,$trivia,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$fe,$data["mes"],$opcion);
          $gallery="admin/adminGaleriaTriviaFE";
        } 
      } 
      if(isset($_SESSION["sesion"])){
        $data["Usuario"]=$_SESSION["Usuario"];          
        $data["Nombre"]=$_SESSION["Nombre"];
        $data["Perfil"]=$_SESSION["Perfil"];
        $data["Cliente"]=$_SESSION["Cliente"];
        $data["NombreCliente"]=$_SESSION["NombreCliente"];
        $data["Clientes"]=$this->funcion_login->elegirCliente();
        $data["Cargo"]=$_SESSION["Cargo"];
        $this->load->view('layout/header',$data);
        $this->load->view('layout/sidebar',$data);
      } else {
        $data["Cliente"] = $c;
        $data["NombreCliente"]=$cliente["nombre"];
        $this->load->view('layout/headergaleria',$data);
      }
      if(isset($gallery)){
        $data['cantidad']=(count($data["fotos"])>0) ? ceil((($data["fotos"][0]["total"])+1)/16) : 0;
        $this->load->view($gallery,$data);
      }      
      $this->load->view('layout/footer',$data); 
    }

    public function listartriviasanios(){
        $id=$_POST["tr"];
        $t=$_POST["view"];
        $this->load->model("ModuloTrivia");
        $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
        $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
        $cliente=$this->funcion_login->BuscarCliente($c);
        echo json_encode($this->ModuloTrivia->TriviasAnios($cliente["nombrebd"],$tipo));
    }

    public function listartriviasestaticas(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $mes=$_POST["lb_anio"];
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->TriviasEstaticasActivas($cliente["nombrebd"],0,0,0,0,0,0,0,0,0,0,$tipo,$mes));

    }

    public function listarlocales(){
        $id=$_POST["pdv"];
        $this->load->model("ModuloTrivia");
        $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
        $cliente=$this->funcion_login->BuscarCliente($c);
        echo json_encode($this->ModuloTrivia->LocalesActivos($cliente["nombrebd"]));
    }


    public function powerpoint($id){
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $this->load->model("ModuloTrivia");
      $this->load->library('Ppt_stuff');
      $trivia=$_POST["lb_trivia"];
      $BD=$cliente["nombrebd"];
      $foto["logo"]=$cliente["logo"];
      $arrayfotos=$this->ModuloTrivia->ListarGaleriaFotograficaPPT($BD,$trivia);
      $this->ppt_stuff->ppttrivia($foto,$arrayfotos);

    }

    public function reportcorreo($id){
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $this->load->model("ModuloTrivia");
      header('Location: http://checkroom.cl/audisis/Adm_ModuloTrivia/galeria/'.$id);
      echo $_POST["txt_correotrivia"];
    }


    public function pdf($id){
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $this->load->model("ModuloTrivia");
      $this->load->library('reportepdf');
      $trivia=$_POST["lb_trivia"];
      $BD=$cliente["nombrebd"];
      $data["logo"]=$cliente["logo"];
      $data["fotos"]=$this->ModuloTrivia->ListarGaleriaFotograficaPPT($BD,$trivia);
      $filename=$data["fotos"][0]["nombre"];
      $this->reportepdf->load_view('admin/Reportepdf',$data);
      $this->reportepdf->render();
      $this->reportepdf->setPaper('letter', 'portrait');
      $this->reportepdf->stream($filename.".pdf");
    }

    public function listartriviasreporte(){
      $id=$_POST["tr"];
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->TriviasReporteActivas($cliente["nombrebd"]));
    }

    public function listargaleriatrivia(){
      $id=$_POST["tr"];
      $fecha=(isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $local=(isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $trivia=isset($_POST["trivia"]) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $cadena=(isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->ListartriviasT($cliente["nombrebd"],$trivia,$cadena,$local,$fecha));
    }

    public function listargaleriacadena(){
      $id=$_POST["tr"];
      $fecha=(isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $local=(isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $trivia=isset($_POST["trivia"]) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $cadena=(isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->ListarCadenatrivias($cliente["nombrebd"],$trivia,$cadena,$local,$fecha));
    }

    public function listargalerialocal(){
      $id=$_POST["tr"];
      $fecha=(isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $local=(isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $trivia=isset($_POST["trivia"]) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $cadena=(isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
       echo json_encode($this->ModuloTrivia->ListarLocalestrivias2($cliente["nombrebd"],$trivia,$cadena,$local,$fecha));
    }


  public function listartrivia(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $m=$_POST["lb_anio"];
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $trivia=0;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      echo json_encode($this->ModuloTrivia->TriviasEstaticasActivas($cliente["nombrebd"],$trivia,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$tipo,$m));
  }

  public function listarterritorio(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $m=$_POST["lb_anio"];
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $trivia= (isset($_POST["trivia"])) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio=0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->ListarTerritorio($cliente["nombrebd"],$trivia,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$tipo,$m));
  }

   public function listardepto(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $m=$_POST["lb_anio"];
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $trivia= (isset($_POST["trivia"])) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto=0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->ListarDepto($cliente["nombrebd"],$trivia,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$tipo,$m));
  }

   public function listarprovincia(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $m=$_POST["lb_anio"];
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $trivia= (isset($_POST["trivia"])) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia=0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->ListarProvincia($cliente["nombrebd"],$trivia,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$tipo,$m));
  }

   public function listardistrito(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $m=$_POST["lb_anio"];
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $trivia= (isset($_POST["trivia"])) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito=0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->ListarDistrito($cliente["nombrebd"],$trivia,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$tipo,$m));
  }

   public function listarcadena(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $m=$_POST["lb_anio"];
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $trivia= (isset($_POST["trivia"])) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena=0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->ListarCadena($cliente["nombrebd"],$trivia,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$tipo,$m));
  }

   public function listarlocal(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $m=$_POST["lb_anio"];
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $trivia= (isset($_POST["trivia"])) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $local=0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->ListarLocalesTrivias($cliente["nombrebd"],$trivia,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$tipo,$m));
  }

   public function listarzona(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $m=$_POST["lb_anio"];
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $trivia= (isset($_POST["trivia"])) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona=0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->ListarZonaTrivias($cliente["nombrebd"],$trivia,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$tipo,$m));
  }

   public function listarcanal(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $m=$_POST["lb_anio"];
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $trivia= (isset($_POST["trivia"])) ? (empty($_POST["trivia"])) ? 0 : $_POST["trivia"] : 0;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal=0;
      $this->load->model("ModuloTrivia");
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->ModuloTrivia->ListarCanal($cliente["nombrebd"],$trivia,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$tipo,$m));
  }






}

