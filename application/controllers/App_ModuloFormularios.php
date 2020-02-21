<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class App_ModuloFormularios extends CI_Controller {

	public function __construct(){
		parent::__construct(); 	
		$this->load->model("moduloFormularioApp");
		$this->load->model("ModuloJornadas");
		$this->load->model("ModuloDocumento");	
	    $this->load->library('upload');
	}

	function verFormulario(){
    if(isset($_SESSION["BDSecundaria"])){
  		if($_SESSION['Perfil']==3){ 
        $this->load->model("ModuloUsuarioApp");
  			$data["Usuario"]=$_SESSION["Usuario"];					
  			$data["Nombre"]=$_SESSION["Nombre"];
  			$data["Perfil"] = $_SESSION["Perfil"];
  			$data["Cargo"] = $_SESSION["Cargo"];
        if(isset($_POST["tx_form"])){
          $formulario=$_POST["tx_form"];
        }else{
          redirect(site_url("App_ModuloTareas/elegirTareasAsignadas")); 
        }
  			$BD=$_SESSION["BDSecundaria"];
  			$idUser=$_SESSION["Usuario"];
        $asignacion=$_POST["txt_id_asignacion"];
        $local=$_POST["txt_local"];
        $pais=$this->ModuloUsuarioApp->BuscarPaisCliente($_SESSION["Cliente"])->FK_ID_Pais;
  			$msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
  			$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
  			$data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
  			$data["cantidadMsj"]=count($data["mensaje"]);
  			$data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
  			$data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
        $info=$this->ModuloUsuarioApp->InfoUsuario($idUser);
        $contador=0;   			
  			$formularioPrincipal=$this->moduloFormularioApp->ListarFormularioUsuario($BD,$formulario);
  			$formu='<form class="form-horizontal" id="Formulario" enctype="multipart/form-data">';
  			$formu.='<div  class="app-body " style="margin-top:15px;">';
        $formu.='<div  class="container-fluid ">';
        $formu.='<div  class="animated-fadeIn ">';
            $formu.='<div  class="row">';
                $formu.='<div  class="col-md-12">';
                $formu.='<a class="navbar-brand"><strong><img width="70%"    src="'.site_url();
                    if(isset($info['logo'])){
                      $formu.=$info['logo'];
                    }else{
                      $formu.='archivos/foto_trabajador/default.png';
                    }
                     $formu.='"></strong></a>';
                // $formu.='</div>';
                // $formu.='<div  class="col-md-8">';
                $formu.='<div  class="card-body">';
                $formu.='<h4 class="tex-center text-theme">'.$formularioPrincipal["NombreFormulario"].'</h4>';
                $formu.='</div>';
                $formu.='</div>
                <input type="hidden" name="tx_formulario" value="'.$formularioPrincipal["ID_Formulario"].'">
                <input type="hidden" name="txt_id_asignacion" value="'.$asignacion.'">
                <input type="hidden" id="txt_local" name="txt_local" value="'.$local.'">
                <input type="hidden" name="f_latitud" id="f_latitud" value="">
                <input type="hidden" name="f_longitud" id="f_longitud" value="">';
            $formu.='</div>';
        $formularioModulos=$this->moduloFormularioApp->ListarFormularioModuloUsuario($BD,$formularioPrincipal["ID_Formulario"]);
        foreach ($formularioModulos as $fm) {
          $formu.='<div class="card card-body card-accent-theme" >';
          $formu.='<a data-toggle="collapse" style="text-decoration:none;color:#f13e46 " class="text-default" href="#'.$fm["ID_FormularioModulo"].'" aria-expanded="true" aria-controls="collapseOne"><h5 class="text-theme">'.$fm["NombreModulo"].'</h5></a>';
          $formularioPregunta=$this->moduloFormularioApp->ListarFormularioPreguntaUsuario($BD,$fm["ID_FormularioModulo"]);
          foreach ($formularioPregunta as $fp) {
            $dependecias="";
            $tempoDep=$this->moduloFormularioApp->ListarFormularioDependenciasPorPadre($BD,$fp["ID_FormularioPregunta"]);
            if($tempoDep==""){
              $onchange="";
              $onradio="";
            }else{
              $onchangeCRa='onchange="depCR'.$contador.'('.$contador.');dep'.$contador.'('.$contador.')"';
              $onchangeCCb='onchange="depCC'.$contador.'('.$contador.')"';
              $onchange='onchange="dep'.$contador.'('.$contador.')"';
              $onchange5='onchange="dep'.$contador.'('.$contador.');subOp'.$contador.'('.$contador .')"';
              $onchangeLL='onchange="depLL'.$contador.'('.$contador.')"';
              $onchangeSL='onchange="dep'.$contador;
              $onchangeL='onchange="depL'.$contador.'('.$contador.')"';
              $onchangeLC='onchange="depLC'.$contador.'('.$contador.');dep'.$contador.'('.$contador.')"';
              $onradioS='onchange="dep'.$contador.'(1)"';
              $onradioN='onchange="dep'.$contador.'(0)"';
                  
            }
            if($fp["esObligatorio"]==1){
              if(isset($_SESSION["Cliente"])){
                if($_SESSION["Cliente"]=="28"){
                  $simbolo="<label style='color:red'>&nbsp;Obligatorio</label>";
                }else{
                  $simbolo="<label style='color:red'>&nbsp;*</label>";
                }
              }else{
                $simbolo="<label style='color:red'>&nbsp;*</label>";
              }
              $formu.="<input type='hidden' name='O".$contador."' id='O".$contador."' value='1'>";
            }else{
              $formu.="<input type='hidden' name='O".$contador."' id='O".$contador."' value='0'>";
                          $simbolo="";
              $simbolo="";
            }
            $esHijo=$this->moduloFormularioApp->ValidaFormularioDependenciasPorHijo($BD,$fp["ID_FormularioPregunta"])->Cantidad;
            if($esHijo==0){
                  $Hijo="";                                    
                  $responde=1;
            }else{
                  $Hijo=';display:none; !important';                                    
                  $responde=0;
            }
            $formu.='<input type="hidden" name="pr'.$contador.'" id="pr'.$contador.'" value="'.$fp["ID_FormularioPregunta"].'">';
            $formu.='<input type="hidden" name="tp'.$contador.'" id="tp'.$fp["ID_FormularioPregunta"].'" value="'.$fp["Tipo"].'">';
            $formu.='<input type="hidden" name="esRes'.$contador.'" id="esRes'.$fp["ID_FormularioPregunta"].'" value="'.$responde.'">';
            $formu.='<div class="card card-body border-danger mb-3" style="text-align:center; border-bottom-right-radius: 10px 10px; border-bottom-left-radius: 10px 10px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px; !important '.$Hijo.'" id="m'.$fp["ID_FormularioPregunta"].'">';
            $formu.='<div class="form-group">';
            $formu.='<h6 class="text-theme">'.$fp["NombrePregunta"].' '.$simbolo.'</h6>';
            if(isset($fp["subPregunta"])){
              $formu.='<label>'.$fp["subPregunta"].'</label>';
            }            
            $formu.='<div class="input-group">';
            if($fp["Tipo"]=="1"){ // Texto Corto                
              $formu.='<input type="text" class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.'>';
            }
            if($fp["Tipo"]=="2"){ // Comentarios                  
              $formu.='<textarea type="textarea" class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.'></textarea>';
            }
            if($fp["Tipo"]=="3"){ // Numeros                  
              $formu.='<input type="number" class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" onkeypress="return SoloNumeros(event)" '.$onchange.'>';
            }
            if($fp["Tipo"]=="4"){  // Fecha                 
              $formu.='<input type="time" class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.'>';
            }
            if($fp["Tipo"]=="16"){  // Fecha                 
              $formu.='<input type="date" class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.'>';
            }
            if($fp["Tipo"]=="5"){ // Opción Multiple(Una Selección)         
              $pOpcion1=$this->moduloFormularioApp->ListarFormularioOpcionUsuario($BD,$fp["ID_FormularioPregunta"]);
              $formu.='<select class="form-control " id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange5.' >';
              $formu.='<option value="">Elegir una opcion</option>';
              foreach($pOpcion1 as $p){                                   
                $formu.='<option value="'.$p["ID_FormularioOpcion"].'">'.$p["NombreOpcion"].'</option>';
              }   
              $formu.='</select>';
            }
            if($fp["Tipo"]=="6"){ // Opción Multiple(Muchas Elecciones)             
              $pOpcion2=$this->moduloFormularioApp->ListarFormularioOpcionUsuario($BD,$fp["ID_FormularioPregunta"]);
              $chkb = 1;
              $CantPreg=0;
              if ($responde==1) {
                $preguntaDepHijo='';
                $dependencia=$this->moduloFormularioApp->FormularioDependenciasPorHijo($BD,$fp["ID_FormularioPregunta"]);
              }
              $formu.='</div>
                       <div class="input-group-vertical" style="text-align: left;">';
              foreach($pOpcion2 as $p){
                $formu.='<div class="checkbox abc-checkbox-danger abc-checkbox ">
                          <input type="checkbox" id="cb-'.$chkb.$contador.'" name="cb-'.$contador.'-'.$chkb.'" value="'.$p["ID_FormularioOpcion"].'" onclick="dep'.$contador.'('.$chkb.$contador.')">
                            <label class="check" for="cb-'.$chkb.$contador.'">'.$p["NombreOpcion"].'</label>';
                if(isset($p["subOpciones"])){
                  $formu.='<p style="color:red;background-color:white;font-style: oblique;">'.$p["subOpciones"].'</p>';
                }                
                $formu.='
                         </div>';                  
                if($responde==1) {
                  $formu.='<div style="display:none; padding-left: 8%;" id="div-'.$chkb.$contador.'" ><br>';
                  $formu.='<input type="hidden" id="depResp-'.$chkb.$contador.'" value="0">';
                  $CantPreg=1;
                  foreach ($dependencia as $c) { 
                    if($c["esObligatorio"]==1){
                      if(isset($_SESSION["Cliente"])){
                        if($_SESSION["Cliente"]=="28"){
                          $simbolo2="<span style='color:red'>&nbsp;Obligatorio</span>";
                        }else{
                          $simbolo2="<span style='color:red'>&nbsp;*</span>";
                        }
                      }else{
                        $simbolo2="<span style='color:red'>&nbsp;*</span>";
                      }
                    }else{
                      $simbolo2="";
                    } 
                    $preguntaDepHijo.='<input type="hidden" id="deptipo'.$contador.'-'.$chkb.'-'.$CantPreg.'" name="deptipo'.$contador.'-'.$chkb.'-'.$CantPreg.'" value="'.$c["Tipo"].'">';  
                    $preguntaDepHijo.='<input type="hidden" id="depOb'.$contador.'-'.$chkb.'-'.$CantPreg.'" value="'.$c["esObligatorio"].'">';    
                    $preguntaDepHijo.='<input type="hidden" id="depreg'.$contador.'-'.$chkb.'-'.$CantPreg.'" name="depreg'.$contador.'-'.$chkb.'-'.$CantPreg.'" value="'.$c["ID_FormularioPregunta"].'">';   
                    if($c["Tipo"]=="1"){ // Texto Corto                
                      $preguntaDepHijo.=''.$c["NombrePregunta"].' '.$simbolo2.' 
                            <input type="text" style="width: 100%;" class="form-control" id="itc'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'" '.$onchange.'><hr>';
                    }                            
                    if($c["Tipo"]=="3"){ // Numeros                  
                      $preguntaDepHijo.=''.$c["NombrePregunta"].' '.$simbolo2.' 
                            <input type="number" style="width: 100%;" class="form-control" id="in'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'" onkeypress="return SoloNumeros(event)" '.$onchange.'><hr>';
                    }
                    if($c["Tipo"]=="6"){  //Opciones multiples(muchas selecciones)
                      $pOpcion1=$this->moduloFormularioApp->ListarFormularioOpcionUsuario($BD,$c["ID_FormularioPregunta"]);
                      $preguntaDepHijo.=''.$c["NombrePregunta"].' '.$simbolo2.' ';
                      $contOpciones=1;
                      foreach($pOpcion1 as $p){                        
                        $preguntaDepHijo.='<div class="input-group-vertical" style="text-align: left;">';
                        $preguntaDepHijo.='<div class="checkbox abc-checkbox-danger abc-checkbox ">
                            <input type="checkbox" id="cb-'.$contador.'-'.$chkb.'-'.$CantPreg.'-'.$contOpciones.'" name="cb-'.$contador.'-'.$chkb.'-'.$CantPreg.'-'.$contOpciones.'" value="'.$p["ID_FormularioOpcion"].'">
                              <label class="check" for="cb-'.$contador.'-'.$chkb.'-'.$CantPreg.'-'.$contOpciones.'">'.$p["NombreOpcion"].'</label>
                           </div>';
                        $preguntaDepHijo.='</div>';
                        $contOpciones++;
                      }
                      $preguntaDepHijo.='<hr>';
                      $preguntaDepHijo.='<input type="hidden" name="txt_contadorOpcionesDep'.$contador.'-'.$chkb.'-'.$CantPreg.'" value="'.$contOpciones.'">';
                    }
                    if($c["Tipo"]=="8"){ // Foto               
                      $preguntaDepHijo.=''.$c["NombrePregunta"].' '.$simbolo2.' 
                            <input type="file" style="width: 100%;"  class="btn btn-outline-theme dropify dropdep'.$c["ID_FormularioPregunta"].'" id="if'.$c["ID_FormularioPregunta"].'-'.$chkb.$contador.'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'"  onchange="foto'.$contador.'('.$fp["ID_FormularioPregunta"].','.$c["ID_FormularioPregunta"].','.$chkb.$contador.');"><hr>';
                      $preguntaDepHijo.='<input id="Tidfoto'.$c["ID_FormularioPregunta"].'-'.$chkb.$contador.'" name="Tidfoto'.$contador.'-'.$chkb.'-'.$CantPreg.'" value="" type="hidden" >';
                      $preguntaDepHijo.='<input id="Ttxt_foto'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'" value="'.base64_encode($contador).'" type="hidden" > ';
                    }     
                    $CantPreg++;                         
                  }  
                  if($preguntaDepHijo!=""){ // Texto Corto                
                    $formu.=$preguntaDepHijo;
                    $preguntaDepHijo='';
                  } 
                  $formu.='</div>';
                } 
                $chkb++;
              }
              $formu.='<input type="hidden" name="cantOpcion_'.$contador.'" id="cantOpcion_'.$contador.'" value="'.$chkb.'">';
              $formu.='<input type="hidden" name="cantPreg_'.$contador.'" id="cantPreg_'.$contador.'" value="'.$CantPreg.'">';
              $formu.='</div>
                        <div>';                                                    
        		}
            if($fp["Tipo"]=="7"){ // Lista Maestra(Una Selección)                 
              $pCluster=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementos($BD,$fp["ID_FormularioPregunta"],$local);
              $pClusterc=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementosCategoria($BD,$fp["ID_FormularioPregunta"],$local);
              $rbtn=0;
              $formu.='<div class="col-md-12"><h6 class="text-theme"><small>Categoria</small></h6>';
              $formu.='<select class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" style="width: 100%;" '.$onchangeCRa.' >';
              $formu.='<option value="">Elegir una Categoria</option>';
              foreach($pClusterc as $p){                                   
                    $formu.='<option value="'.str_replace(' ', '', $p["Categoria"]).'">'.$p["Categoria"].'</option>';
              }   
              $formu.='</select>';
              $formu.='<div class="input-group-vertical"><br>';
              foreach($pCluster as $c){
                $formu.=' <div class="radio abc-radio abc-radio-danger radio-inline" id="r'.$rbtn.$contador.'-'.str_replace(' ', '', $c["Categoria"]).'" style="display:none;" >
                            <input type="radio" name="p'.$contador.'" id="radio-'.$rbtn.$contador.'" '.$onchange.' value="'.$c["ID_Elemento"].'" >
                            <label class="check" style="font-size: 9px; text-align:left;" for="radio-'.$rbtn.$contador.'">'.$c["Nombre"].'</label>
                        </div>';
                $rbtn++;
              }                 
              $formu.='</div></div>';
            }
            if($fp["Tipo"]=="8"){ // Foto               
              $formu.='<input type="file" class="btn btn-outline-theme dropify dropdep'.$fp["ID_FormularioPregunta"].'" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" onchange="foto'.$contador.'('.$fp["ID_FormularioPregunta"].',00,00);" >';
              $formu.='<input id="idfoto'.$fp["ID_FormularioPregunta"].'" name="idfoto'.$contador.'" value="" type="hidden" >';
              if($onchange==""){
                $formu.='<input id="txt_foto'.$fp["ID_FormularioPregunta"].'" value="'.base64_encode(-1).'" type="hidden" >';
              } else {
                $formu.='<input id="txt_foto'.$fp["ID_FormularioPregunta"].'" value="'.base64_encode($contador).'" type="hidden" > ';
              }
            }
            if($fp["Tipo"]=="9"){ // si/no                
              $formu.='<div class="radio abc-radio abc-radio-danger radio-inline">
                              <input type="radio" id="'.$fp["ID_FormularioPregunta"].'1" value="1" name="p'.$contador.'" '.$onradioS.'>
                              <label class="check" for="'.$fp["ID_FormularioPregunta"].'1">Si </label>
                          </div>
                          <div class="radio abc-radio abc-radio-danger radio-inline">
                              <input type="radio" id="'.$fp["ID_FormularioPregunta"].'0" value="0" name="p'.$contador.'" '.$onradioN.'">
                              <label class="check" for="'.$fp["ID_FormularioPregunta"].'0"> No </label>
                           </div>';
            }
            if($fp["Tipo"]=="10"){ // RUT                 
              $formu.='<input type="text" class="form-control" placeholder="12.345.567-9" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" onfocus="return validaRut(event)" '.$onchange.' >';
            }
            if($fp["Tipo"]=="11"){  //codigo QR  
              $formu.=' 
                <button type="button" class="btn btn-danger" accept="image/*" id="btn-startReadVideo" disabled capture>Escanear</button>
                <button type="button" class="btn btn-danger" id="btn-stopReadVideo" style="display:none;">Detener</button>
                <div id="divVideoContainer" style="width:100%;height:50%;position:center;padding-top:18px;">
                  <video id="theVideo" style="width:100%;height:50%;" playsinline="true"></video>
                  <div id="divVideoRegion" ></div>
                  <input type="text" class="form-control" id="cod-'.$contador.'" style="width:100%;height:50%;" placeholder="Acerque el codigo de barra">
                  <button onclick="buscarElemento()" class="btn btn-danger" type="button" id="btn-buscar" style="display:none;">Buscar</button>
                  <div id="divInfo"></div>
                  <hr>
                  <div id="divLoading">Cargando...</div>
                <div id="divReading" style="display:none">Leyendo...</div>
                <br>';
              $formu.='<script src="'.site_url().'Dist/dbr-6.4.1.1.min.js"></script>';
              $formu.='<script>
                        dynamsoft.dbrEnv.resourcesPath = "https://demo.dynamsoft.com/dbr_wasm/js";               
                        dynamsoft.dbrEnv.licenseKey = "t0068NQAAACjLEw80kxeKo+tjt6kKGsUGvW861Kj5embmi4/j95GPD/XfvzNPd6l7bjulXSRpv5qYq9s9zDNbyc48J/dddpY=";
              
                        dynamsoft.dbrEnv.onAutoLoadWasmSuccess = function(){
                            playvideo();
                            $("#divLoading").text("Listo para escanear");
                        };
                        dynamsoft.dbrEnv.onAutoLoadWasmError = function(ex){
                            
                            $("#divLoading").text("Ocurrió un error al cargar : "+(ex.message || ex));
                        };
                        var playvideo = ()=>{                                     
                          navigator.mediaDevices.getUserMedia({ video: { width: { ideal: 1280 }, height: { ideal: 720 }, facingMode: { ideal: "environment" } } }).then((stream)=>{
                            var video = $("#theVideo")[0];
                            video.srcObject = stream;
                            video.onloadedmetadata = ()=>{
                              video.play();
                              $("#btn-startReadVideo").removeAttr("disabled");
                            };
                          }).catch((ex)=>{
                            alert("Please make sure the camera is connected and the site is deployed in https: "+(ex.message || ex));
                          });
                        };
                        $("#btn-startReadVideo").click(()=>{
                            $("#divReading").show();
                            $("#btn-startReadVideo").hide();
                            $("#divLoading").hide();
                            $("#btn-buscar").show();
                            $("#btn-stopReadVideo").show();
                            isLooping = true;
                           
                            loopReadVideo();
                        });
                        $("#btn-stopReadVideo").click(()=>{
                          $("#btn-stopReadVideo").hide();
                          $("#btn-startReadVideo").show();
                          isLooping = false;
                          $("#divReading").hide();
                        });
                        var isLooping = false;
                        var loopReadVideo = function(){
                        if(!isLooping){
                          return;
                        }
                        var timestart = (new Date()).getTime();
                        var reader = new dynamsoft.BarcodeReader();
                        reader.decodeFileInMemory($("#theVideo")[0]).then(results=>{
                          for(var i=0;i<results.length;++i){
                            var result = results[i];
                            $("#cod-'.$contador.'").val(result.BarcodeText);
                          }
                          setTimeout(loopReadVideo, 0);
                        }).catch(ex=>{
                          setTimeout(loopReadVideo, 0);
                        });
                      };
                      function buscarElemento(){
                        var sku = $("#cod-0").val();
                        $.ajax({
                          url: "buscarSKU",
                          type: "POST",
                          data: "sku="+sku,
                          success: function(data) {
                              $("#divInfo").html("");                            
                              $("#divInfo").html(data);                            
                            }
                        });
                      }
                    </script>';
            }
            if($fp["Tipo"]=="12"){ // Email                 
              $formu.='<input type="text" class="form-control" placeholder="correo@dominio.com" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" onfocus="return validarEmail(event)" '.$onchange.'>';
            }
            if($fp["Tipo"]=="13"){ // Pregunta Dependiente                        
              $pOpcion1=$this->moduloFormularioApp->ListarFormularioOpcionUsuario($BD,$fp["ID_FormularioPregunta"]);
              $formu.='<select class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.' >';
              $formu.='<option value="">Elegir una opcion</option>';
              foreach($pOpcion1 as $p){                                   
                $formu.='<option value="'.$p["ID_FormularioOpcion"].'">'.$p["NombreOpcion"].'</option>';    
              }   
              $formu.='</select>';
            }    
            if($fp["Tipo"]=="14"){ // Lista Maestra(Muchas Elecciones)                   
              $pClusterc=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementosCategoria($BD,$fp["ID_FormularioPregunta"],$local);
              $CantPreg=1;
               $formu.='<div class="col-md-12"><h6 class="text-theme"><i id="iCT" class=""></i><small>Categor&iacute;a</small></h6>';
              $formu.='<input type="hidden" name="idp" id="idpp" value="'.$fp["ID_FormularioPregunta"].'">';
              $formu.='<input type="hidden" name="icont" id="icont" value="'.$contador.'">';
              $formu.='<select class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" style="width: 100%;" '.$onchangeCCb.' >';
              $formu.='<option value="">Elegir una Categor&iacute;a</option>';
              foreach($pClusterc as $p){                                   
                $formu.='<option value="'.str_replace(' ', '', $p["Categoria"]).'">'.$p["Categoria"].'</option>';
              }   
              $formu.='</select>';
              $formu.='<div class="col-md-12 pad0" id="CheckML-'.$fp["ID_FormularioPregunta"].'">';  
              $chkb = 1; 
              if($responde==1) {
                $preguntaDepHijo='';
                $dependencia=$this->moduloFormularioApp->FormularioDependenciasPorHijo($BD,$fp["ID_FormularioPregunta"],$local);                                                   
              }
              $formu.='<div id="actLoc">';
              $pOpcion1=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementos($BD,$fp["ID_FormularioPregunta"],$local);                        
              foreach($pOpcion1 as $p){ 
                $formu.='<div class="checkbox abc-checkbox-danger abc-checkbox " id="divElement-'.$contador.'-'.$chkb.'" style="display:none;" >
                        <input type="hidden" id="element-'.$contador.'-'.$chkb.'" value="'.str_replace(' ', '', $p["Categoria"]).'">
                        <input type="checkbox" name="cb-'.$contador.'-'.$chkb.'" id="cb-'.$chkb.$contador.'" value="'.$p["ID_Elemento"].'" '.$onchangeSL.'('.$chkb.$contador.')" >
                        <label class="check" for="cb-'.$chkb.$contador.'" style="width: 100%; font-size: 9px; text-align:left;" ><strong>'.$p["Nombre"].'</strong></label>';
                if($responde==1) {
                  $formu.='<div style="display:none; padding-left: 8%;" id="div-'.$chkb.$contador.'" >';
                  $formu.='<input type="hidden" id="depResp-'.$chkb.$contador.'" value="0">';
                  $CantPreg=1;
                  foreach ($dependencia as $c) {  
                    if($c["esObligatorio"]==1){
                      if(isset($_SESSION["Cliente"])){
                        if($_SESSION["Cliente"]=="28"){
                          $simbolo2="<span style='color:red'>&nbsp;Obligatorio</span>";
                        }else{
                          $simbolo2="<span style='color:red'>&nbsp;*</span>";
                        }
                      }else{
                        $simbolo2="<span style='color:red'>&nbsp;*</span>";
                      }
                    }else{
                      $simbolo2="";
                    }                     
                    $preguntaDepHijo.='<input type="hidden" id="deptipo'.$contador.'-'.$chkb.'-'.$CantPreg.'" name="deptipo'.$contador.'-'.$chkb.'-'.$CantPreg.'" value="'.$c["Tipo"].'">';  
                    $preguntaDepHijo.='<input type="hidden" id="depOb'.$contador.'-'.$chkb.'-'.$CantPreg.'" value="'.$c["esObligatorio"].'">';    
                    $preguntaDepHijo.='<input type="hidden" id="depreg'.$contador.'-'.$chkb.'-'.$CantPreg.'" name="depreg'.$contador.'-'.$chkb.'-'.$CantPreg.'" value="'.$c["ID_FormularioPregunta"].'">';   
                    if($c["Tipo"]=="1"){ // Texto Corto                
                     $preguntaDepHijo.='<div class="input-prepend input-group">
                            '.$c["NombrePregunta"]. ' '.$simbolo2.'                               
                              <input type="text" class="form-control" id="itc'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'" '.$onchange.'>
                          </div>';
                    }                            
                    if($c["Tipo"]=="3"){ // Numeros                  
                      $preguntaDepHijo.=''.$c["NombrePregunta"].' '.$simbolo2.'
                    <input type="number" style="width: 100%;" class="form-control" id="in'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'"  onkeypress="return SoloNumeros(event)" '.$onchange.'>';
                    }
                    if($c["Tipo"]=="5"){
                      $pOpcion1=$this->moduloFormularioApp->ListarFormularioOpcionUsuario($BD,$c["ID_FormularioPregunta"]);
                      $preguntaDepHijo.=''.$c["NombrePregunta"].' '.$simbolo2.'<select class="form-control " id="i'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'" '.$onchange.' style="width: 100%;padding-left: 0% !important;">';
                      $preguntaDepHijo.='<option value="">Escoger un valor</option>';
                      foreach($pOpcion1 as $p){                                   
                        $preguntaDepHijo.='<option value="'.$p["ID_FormularioOpcion"].'">'.$p["NombreOpcion"].'</option>';
                      }   
                      $preguntaDepHijo.='</select>';
                    }
                    if($c["Tipo"]=="8"){ // Foto               
                       $preguntaDepHijo.=''.$c["NombrePregunta"].' '.$simbolo2.' 
                            <input type="file" style="width: 100%;"  class="btn btn-outline-theme dropify dropdep'.$c["ID_FormularioPregunta"].'" id="if'.$c["ID_FormularioPregunta"].'-'.$chkb.$contador.'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'"  onchange="foto'.$contador.'('.$fp["ID_FormularioPregunta"].','.$c["ID_FormularioPregunta"].','.$chkb.$contador.');"><hr>';
                      $preguntaDepHijo.='<input id="Tidfoto'.$c["ID_FormularioPregunta"].'-'.$chkb.$contador.'" name="Tidfoto'.$contador.'-'.$chkb.'-'.$CantPreg.'" value="" type="hidden" >';
                      $preguntaDepHijo.='<input id="Ttxt_foto'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'" value="'.base64_encode($contador).'" type="hidden" > ';
                    }     
                    $CantPreg++;                         
                  }  
                  if($preguntaDepHijo!=""){               
                    $formu.=$preguntaDepHijo;
                    $preguntaDepHijo='';
                  }  
                  $formu.='</div>';
                }      
                $chkb++;        
                $formu.='</div>';
              }    
              $formu.='<input type="hidden" name="cantOpcion_'.$contador.'" id="cantOpcion_'.$contador.'" value="'.$chkb.'">';
              $formu.='<input type="hidden" name="cantPreg_'.$contador.'" id="cantPreg_'.$contador.'" value="'.$CantPreg.'">';
              $formu.='</div>';
              $formu.='</div>';        
              $formu.='</div>';
            }
            if($pais=="1"){
              if($fp["Tipo"]=="15"){ // Lista Maestra(Locales)
                // $pOpcion1=$this->moduloFormularioApp->ListarFormularioPreguntaClousterLocales($BD,$fp["ID_FormularioPregunta"]);
                // if (!isset($pOpcion1["Region"])) {
                  $pOpcionR=$this->moduloFormularioApp->ListarFormularioPreguntaClousterLocalesRegion($BD,$fp["ID_FormularioPregunta"]);
                  $formu.='<div class="col-md-12">';
                  $formu.='<input type="hidden" name="idp" id="idp" value="'.$fp["ID_FormularioPregunta"].'">';
                  $formu.='<select class="form-control" id="iclR'.$fp["ID_FormularioPregunta"].'" style="width: 100%;" name="p'.$contador.'" '.$onchangeLL.' >';
                  $formu.='<option value="">Elegir una Region</option>';
                  if (isset($pOpcionR)) {
                    foreach($pOpcionR as $p){                                   
                        $formu.='<option value="'.$p["ID_Region"].'">'.$p["Region"].'</option>';                    
                    }
                  }else{
                    $formu.='<option value="">No existe Categoria por Region</option>';
                  }
                     
                  $formu.='</select><br>';
                  $formu.='<select class="" id="iclC'.$fp["ID_FormularioPregunta"].'" style="display:none;" name="p'.$contador.'" '.$onchangeL.'>';
                  $formu.='<option value="">Elegir una opcion</option>';   
                  $formu.='</select><br>';
                  $formu.='<select class="" id="iclL'.$fp["ID_FormularioPregunta"].'" style="display:none;" name="p'.$contador.'" '.$onchangeLC.'>';
                  $formu.='<option value="">Elegir una opcion</option>';   
                  $formu.='</select>';
                // }else if(!isset($pOpcion1["Zona"])){
                //   $formu.='<h6 class="text-theme"> zona con datos pero region y/o cadena vacio</h6>';
                // }else if(!isset($pOpcion1["NombreCadena"])){
                //   $formu.='<h6 class="text-theme"> Cadenas con datos pero region y/o zona vacios</h6>';
                // }
                $formu.='</div>';
              }
            }else{
              if($fp["Tipo"]=="15"){ // Lista Maestra(Locales)
              //   $pOpcion1=$this->moduloFormularioApp->ListarFormularioPreguntaClousterLocales($BD,$fp["ID_FormularioPregunta"]);
              //   if (!isset($pOpcion1["Region"])) {
                  $pOpcionR=$this->moduloFormularioApp->ListarFormularioPreguntaClousterLocalesRegion($BD,$fp["ID_FormularioPregunta"]);
                  $formu.='<div class="col-md-12">';
                  $formu.='<input type="hidden" name="idp" id="idp" value="'.$fp["ID_FormularioPregunta"].'">';
                  $formu.='<select class="form-control" id="iclR'.$fp["ID_FormularioPregunta"].'" style="width: 100%;" name="p'.$contador.'" onchange="depPeDep'.$contador.'('.$contador.')" >';
                  $formu.='<option value="">Elegir un Departamento</option>';
                  if (isset($pOpcionR)) {
                    foreach($pOpcionR as $p){                                   
                        $formu.='<option value="'.$p["ID_Region"].'">'.$p["Region"].'</option>';                    
                    }
                  }else{
                    $formu.='<option value="">No existe Categoria por Departamento</option>';
                  }
                     
                  $formu.='</select><br>';
                  $formu.='<select class="" id="iclPP'.$fp["ID_FormularioPregunta"].'" style="display:none;" name="p'.$contador.'" onchange="depPePr'.$contador.'('.$contador.')">';
                  $formu.='<option value="">Elegir una opcion</option>'; 
                  $formu.='</select><br>';
                  $formu.='<select class="" id="iclPDi'.$fp["ID_FormularioPregunta"].'" style="display:none;" name="p'.$contador.'" '.$onchangeL.' ">';
                  $formu.='<option value="">Elegir una opcion</option>';   
                  $formu.='</select><br>';
                  $formu.='<select class="" id="iclL'.$fp["ID_FormularioPregunta"].'" style="display:none;" name="p'.$contador.'" '.$onchangeLC.'>';
                  $formu.='<option value="">Elegir una opcion</option>';   
                  $formu.='</select>';
                // }else if(!isset($pOpcion1["Zona"])){
                //   $formu.='<h6 class="text-theme"> zona con datos pero region y/o cadena vacio</h6>';
                // }else if(!isset($pOpcion1["NombreCadena"])){
                //   $formu.='<h6 class="text-theme"> Cadenas con datos pero Departamentos y/o zona vacios</h6>';
                // }
                $formu.='</div>';
              }
            }
          $formu.='<script type="text/javascript">';
          if($fp["Tipo"]=='6' || $fp["Tipo"]=='8' || $fp["Tipo"]=='14')
          $formu.=' function foto'.$contador.'(id,pregunta,elemento){
              var data=new FormData();
              data.append("asignacion",'.$asignacion.');
              data.append("local",$("#txt_local").val());
              data.append("latitud",$("#f_latitud").val());
              data.append("longitud",$("#f_longitud").val());
              data.append("formulario",'.$formularioPrincipal["ID_Formulario"].');    
              $("#bt_agregar").attr("disabled",true);   
              $(".dropify-wrapper").addClass("disabled");
              $(".dropify-wrapper input").attr("disabled",true);   
              if(pregunta==00){
                $("#i'.$fp["ID_FormularioPregunta"].'").parent().find(".dropify-wrapper").removeClass("disabled");
                $("#i'.$fp["ID_FormularioPregunta"].'").removeAttr("disabled");
                data.append("id_pregunta",'.$fp["ID_FormularioPregunta"].');
                if($("#idfoto'.$fp["ID_FormularioPregunta"].'").val()!=""){
                 data.append("nombre_foto",$("#idfoto'.$fp["ID_FormularioPregunta"].'").val());
                }
                data.append("file",$("#i'.$fp["ID_FormularioPregunta"].'")[0].files[0]);
                data.append("elemento","000");
                data.append("pregElemento","000");
              }else{
                $("#if"+pregunta+"-"+elemento).parent().find(".dropify-wrapper").removeClass("disabled");
                $("#if"+pregunta+"-"+elemento).removeAttr("disabled");
 				         data.append("pregElemento",'.$fp["ID_FormularioPregunta"].');
                if($("#Tidfoto"+pregunta+elemento).val()!=""){
                  data.append("nombre_foto",$("#Tidfoto"+pregunta+"-"+elemento).val());
                }
                data.append("file",$("#if"+pregunta+"-"+elemento)[0].files[0]);
                data.append("elemento",$("#cb-"+elemento).val());
                data.append("id_pregunta",pregunta);
              }
              $.ajax({
                url:"'.base_url('App_ModuloFormularios/AddFoto').'",
                type:"POST",
                contentType:false,
                processData:false,
                data:data,
                success: function(data){
                  if(data!=="ERROR"){
                    if(pregunta==00){
                      $("#idfoto'.$fp["ID_FormularioPregunta"].'").val(data);
                    }else{
                      $("#Tidfoto"+pregunta+"-"+elemento).val(data);
                    }
                    $("#bt_agregar").removeAttr("disabled"); 
                    $(".dropify-wrapper").removeClass("disabled");
                    $(".dropify-wrapper input").removeAttr("disabled");
                  }
                }
              });
              if($("#txt_foto"+id).length>0){
                var foto=atob($("#txt_foto"+id).val());
                if(foto!==-1){
                  dep'.$contador.'('.$contador.');
                }
              }
            }';
        if($fp["Tipo"]=="5"){
          $formu.=' function subOp'.$contador.'(){
              var opcion= $("#i'.$fp["ID_FormularioPregunta"].'").val();
              $.ajax({
                url: "'; $formu.= site_url(); $formu.='App_ModuloFormularios/verSubOpciones",
                type: "POST",
                data: "opcion="+opcion,
                success: function(data) {
                  if(data!=""){
                    $("#div_subOp_'.$contador.'").html("");                            
                    $("#div_subOp_'.$contador.'").html(data);
                  }else{
                   $("#div_subOp_'.$contador.'").html("");    
                  }    
                }
              });   
            }';
        }
        if($onchange!=""){
          $formu.='
            $(".select-'.$contador.'").select2({});
            function depLC'.$contador.'(num){';
            if($fp["Tipo"]=="15"){
              $formu.=' var lc = $("#iclL'.$fp["ID_FormularioPregunta"].'").val();
              var cont = $("#icont").val();
              var idp = $("#idpp").val();
              $("#iCT").attr("class","fa fa-spin fa-circle-o-notch");
              $("#txt_local").val(lc);
              $.ajax({
                url: "'; $formu.= site_url(); $formu.='App_ModuloFormularios/CambiarElementoLocal",
                type: "POST",
                data: "lc="+lc+"&cont="+cont+"&idp="+idp,
                success: function(data) {
                  $("#actLoc").html("");                            
                  $("#actLoc").html(data);
                  $("#iCT").attr("class","");                            
                }
              });';                            
            }
            $formu.='} // fin funcion deplc
            function depPeDep'.$contador.'(num){';
            if($fp["Tipo"]=="15"){
              $formu.=' var formu = $("#iclR'.$fp["ID_FormularioPregunta"].'").val();';
              $formu.=' var idp = $("#idp").val();';
              $formu.='$("#iclPP'.$fp["ID_FormularioPregunta"].'").attr("style", "width: 100%;");';
              $formu.='$("#iclPP'.$fp["ID_FormularioPregunta"].'").attr("class", "form-control");';
              $formu.='$.ajax({
                        url: "'; $formu.= site_url(); $formu.= 'App_ModuloFormularios/elegirDepartamento",
                        type: "POST",
                        data: "formu="+formu+"&idp="+idp,
                        success: function(data) {
                         $("#iclPP'.$fp["ID_FormularioPregunta"].'").html(data);                            
                        }
                      });';                                          
            }
            $formu.='} // fin funcion depll
            function depLL'.$contador.'(num){';
            if($fp["Tipo"]=="15"){
              $formu.=' var formu = $("#iclR'.$fp["ID_FormularioPregunta"].'").val();';
              $formu.=' var idp = $("#idp").val();';
              $formu.='$("#iclC'.$fp["ID_FormularioPregunta"].'").attr("style", "width: 100%;");';
              $formu.='$("#iclC'.$fp["ID_FormularioPregunta"].'").attr("class", "form-control");';
              $formu.='$.ajax({
                        url: "'; $formu.= site_url(); $formu.= 'App_ModuloFormularios/elegirRegion",
                        type: "POST",
                        data: "formu="+formu+"&idp="+idp,
                        success: function(data) {
                         $("#iclC'.$fp["ID_FormularioPregunta"].'").html(data);                            
                        }
                      });';                                          
            }
            $formu.='} // fin funcion depll
            function depPePr'.$contador.'(num){';
            if($fp["Tipo"]=="15"){
              $formu.=' var formu = $("#iclPP'.$fp["ID_FormularioPregunta"].'").val();';
              $formu.=' var idp = $("#idp").val();';
              $formu.='$("#iclPDi'.$fp["ID_FormularioPregunta"].'").attr("style", "width: 100%;");';
              $formu.='$("#iclPDi'.$fp["ID_FormularioPregunta"].'").attr("class", "form-control");';
              $formu.='$.ajax({
                        url: "'; $formu.= site_url(); $formu.= 'App_ModuloFormularios/elegirProvincia",
                        type: "POST",
                        data: "formu="+formu+"&idp="+idp,
                        success: function(data) {
                         $("#iclPDi'.$fp["ID_FormularioPregunta"].'").html(data);                            
                        }
                      });';                                          
            }
            $formu.='} // fin funcion depll
             function depCC'.$contador.'(num){';
            if($fp["Tipo"]=="14"){
              $formu.='var formu = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
              $formu.='var cantidad= $("#cantOpcion_"+'.$contador.').val();';
              $formu.='for (var i = 1; i < cantidad; i++) {';
              $formu.='if(formu==$("#element-'.$contador.'-"+i).val()){
                        $("#divElement-'.$contador.'-"+i).removeAttr("style");
                      }else{
                        $("#divElement-'.$contador.'-"+i).attr("style","display:none;");
                      }';
              $formu.='}';                                                                      
            }
            $formu.='} // fin funcion depll
            function depCR'.$contador.'(num){';
            if($fp["Tipo"]=="7"){
              $formu.=' var formu = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
              $pOpcion1=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementos($BD,$fp["ID_FormularioPregunta"],$local);
              $chkbc=0;
              foreach($pOpcion1 as $p){
                $formu.=' $("#r'.$chkbc.$contador.'-"+formu).removeAttr("style");';
                $chkbc++;                                      
              }                                                                     
            }
            $formu.='} // fin funcion depll
            function depL'.$contador.'(num){';
            if($fp["Tipo"]=="15"){
              $formu.=' ;var reg = $("#iclR'.$fp["ID_FormularioPregunta"].'").val();';
              if($pais=="1"){
                $formu.=' var com = $("#iclC'.$fp["ID_FormularioPregunta"].'").val();';
              }else{
                $formu.=' var com = $("#iclPDi'.$fp["ID_FormularioPregunta"].'").val();';
              }
              $formu.=' var idp = $("#idp").val();
                        $("#iclL'.$fp["ID_FormularioPregunta"].'").attr("style", "width: 100%;");
                        $("#iclL'.$fp["ID_FormularioPregunta"].'").attr("class", "form-control");
                        $.ajax({
                          url: "'; $formu.= site_url(); $formu.= 'App_ModuloFormularios/elegirLocal",
                          type: "POST",
                          data: "reg="+reg+"&com="+com+"&idp="+idp,
                          success: function(data) {
                            $("#iclL'.$fp["ID_FormularioPregunta"].'").html(data);                                          
                          }
                        });';
            }
            $formu.='} // fin de funcion depl
                  function dep'.$contador.'(num){
                    var validarDep'.$contador.'="FALSE";';
            if($fp["Tipo"]=="15"){
              $formu.=' var formu'.$contador.' = $("#iclR'.$fp["ID_FormularioPregunta"].'").val();';
            }else if($fp["Tipo"]=="9"){
              $formu.=' var formu'.$contador.' = $("#'.$fp["ID_FormularioPregunta"].'"+num).val();';            
            }else if($fp["Tipo"]=="14"){
              $formu.=' if($("#div-"+num).is(":visible")){ 
                          $("#div-"+num).hide(); 
                          $("#div-"+num).find("input[type!=hidden]").val("");  
                          $("#depResp-"+num).val("0");
                        } else { 
                          $("#div-"+num).show();
                          $("#depResp-"+num).val("1");
                        }';                           
            }else if($fp["Tipo"]=="13"){
              $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
            }else if($fp["Tipo"]=="12"){
              $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
            }else if($fp["Tipo"]=="11"){
              $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
            }else if($fp["Tipo"]=="10"){
              $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
            }else if($fp["Tipo"]=="8"){
              $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
            }else if($fp["Tipo"]=="7"){
              $formu.=' var formu'.$contador.' = $("#radio-'.$fp["ID_FormularioPregunta"].'").val();';
            }else if($fp["Tipo"]=="6"){
              $formu.=' if($("#div-"+num).is(":visible")){
                          var arrfoto= new Array();
                          var i=0; 
                          $("#div-"+num).hide(); 
                          $("#depResp-"+num).val("0");
                          $("#div-"+num).find("[id*=Tidfoto]").each(function(){
                            if($(this).val()!=""){
                              arrfoto[i]=$(this).val();
                              i+=1;
                            }
                          });
                          if(arrfoto.length>0){
                            $.ajax({
                              type: "POST",
                              url: "'.base_url('App_ModuloFormularios/DelFoto').'",
                              data: {"array": JSON.stringify(arrfoto)},     
                              success: function(data){
                                $("#div-"+num).find(".dropify-clear").click();
                              }
                            });
                          }
                          $("#div-"+num).find("input[type!=hidden]").val("");                
                          $("#div-"+num).find("input").prop("checked", false);
                        } else { 
                          $("#div-"+num).show();
                          $("#depResp-"+num).val("1");
                        }';   
            }else if($fp["Tipo"]=="5"){
              $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].' option:selected").text();';
            }else if($fp["Tipo"]=="4"){
              $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
            }else if($fp["Tipo"]=="3"){
              $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
            }else if($fp["Tipo"]=="2"){
              $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
            }else if($fp["Tipo"]=="1"){
              $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
            }    
            foreach ($tempoDep as $t){
              if($fp["Tipo"]=="9"){
                if(strtolower($t["RespuestaEsperada"])=='si'){
                  $esperada="1";
                }elseif(strtolower($t["RespuestaEsperada"])=='no'){
                  $esperada="0";
                }elseif(isset($t["RespuestaEsperada"])){
                  $esperada='formu'.$contador;
                }else{
                  $esperada=$t["RespuestaEsperada"];
                }
              }elseif($fp["Tipo"]!="14"){
                if(isset($t["RespuestaEsperada"])){
                  if($t["RespuestaEsperada"]!=""){          
                    $esperada=$t["RespuestaEsperada"];                           
                  }else{
                    $formu.=' validarDep'.$contador.'="TRUE";';
                  }             
                }
              }
              if(isset($esperada) && $esperada!=""){
                $formu.=' if("'.$esperada.'"==formu'.$contador.' ||  validarDep'.$contador.'==="TRUE"){
                      $("#esRes'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").val("1");
                      document.getElementById("m'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").style.display = "inline";
                      document.getElementById("br'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").style.display = "inline";
                      $("#m'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").attr("style", "text-align:center; border-bottom-right-radius: 10px 10px; border-bottom-left-radius: 10px 10px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px; !important"); 
                    }else{
                      $("#esRes'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").val("0");
                      document.getElementById("m'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").style.display = "none";
                      document.getElementById("br'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").style.display = "none";
                      if($("#tp'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").val()=="9"){
                        $("#'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'0").prop("checked", false);
                        $("#'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'1").prop("checked", false);
                      }else if($("#tp'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").val()=="8"){
                        $("#idfoto'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").val(""); 
                        $("#txtx_foto'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").val(""); 
                        $("#i'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").val("");  
                      }else{
                        $("#i'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").val("");  
                      }';
                  $info="";
                  $info=$this->moduloFormularioApp->OcultarPreguntasHijas($_SESSION["BDSecundaria"],$t["FK_FormulariosPreguntas_ID_PreguntaHijo"]);
                  if(isset($info)){
                    if($info!=""){
                      foreach ($info as $in) {
                        $formu.='
                        $("#esRes'.$in["Hijo"].'").val("0");
                        document.getElementById("m'.$in["Hijo"].'").style.display = "none";
                        document.getElementById("br'.$in["Hijo"].'").style.display = "none";
                        if($("#tp'.$in["Hijo"].'").val()=="9"){
                          $("#'.$in["Hijo"].'0").prop("checked", false);
                          $("#'.$in["Hijo"].'1").prop("checked", false);
                        }else if($("#tp'.$in["Hijo"].'").val()=="8"){
                          $("#idfoto'.$in["Hijo"].'").val(""); 
                          $("#txtx_foto'.$in["Hijo"].'").val(""); 
                          $("#i'.$in["Hijo"].'").val("");  
                        }else{
                          $("#i'.$in["Hijo"].'").val("");  
                        }';
                      }
                    }
                  }
                  $formu.='}';
              }
            }
            $formu.='}';
          }else{
            $formu.=' var formu'.$contador.' = $("#'.$fp["ID_FormularioPregunta"].'"+num).val();';
          } 
          $formu.='</script>';                                                        
          $formu.='</div>';
          $formu.='
                <div id="div_subOp_'.$contador.'">                  
                </div>';
          $formu.='</div>';          
          $formu.='</div>';
          $formu.='<br id="br'.$fp["ID_FormularioPregunta"].'" style="'.$Hijo.'">';
          $contador++;
          }                        
          $formu.='</div>';
        }
        $formu.='</div>';
        $formu.='</div>';
        $formu.='</div>';
        $formu.='<input type="hidden" name="txt_contador" id="txt_contador" value="'.$contador.'">';       
  			$formu.='</form>';		
  	    $data["formu"]=$formu;
  			$this->load->view('contenido');
  			$this->load->view('layout/headerApp',$data);
        $this->load->view('layout/sidebarApp',$data);
  		  $this->load->view('App/FormularioApp',$data);
  		  $this->load->view('layout/footerApp',$data);	
  		}else{
  			redirect(site_url("login/inicio"));	
  		}
    }else{
      redirect(site_url("login/inicio")); 
    }
	}


  public function DelFoto(){
    $data = json_decode($_POST['array']);
    foreach ($data as $foto) {
      $id=explode("///", $foto);
      $BD=$_SESSION["BDSecundaria"];
      $this->moduloFormularioApp->EliminarFormularioRespuestaFoto($BD,$id[1]);
      $ruta='archivos/fotosFormulario/'.$BD.'/';
      $ubicacion=$ruta.$id[0];
      unlink($ubicacion);
    }
  }

  public function AddFoto(){
    $vacios=0;
    if((!isset($_POST["id_pregunta"])) || $_POST["id_pregunta"]==""){
      $vacios+=1;
    }
    if((!isset($_POST["asignacion"])) || $_POST["asignacion"]==""){
      $vacios+=1;
    }
    if((!isset($_POST["formulario"])) || $_POST["formulario"]==""){
      $vacios+=1;
    }
    if((!isset($_POST["local"])) || $_POST["local"]==""){
      $vacios+=1;
    }
    // if((!isset($_POST["latitud"])) || $_POST["latitud"]==""){
      $latitud=0;
    // } else {
    //   $latitud=$_POST["latitud"];
    // }
    // if((!isset($_POST["longitud"])) || $_POST["longitud"]==""){
      $longitud=0;
    // } else {
    //   $longitud=$_POST["longitud"];
    // }
    if(!isset($_POST["nombre_foto"])){
      if(!isset($_FILES["file"]) || $_FILES["file"]["size"]=0){
        $vacios+=1;
      }
    }
    if((!isset($_POST["elemento"])) || $_POST["elemento"]==""){
      $elemento=0;
    } else {
      $elemento=$_POST["elemento"];
    }
    if((!isset($_POST["pregElemento"])) || $_POST["pregElemento"]==""){
      $pregElemento=0;
    } else {
      $pregElemento=$_POST["pregElemento"];
    }
    if($vacios!=0){
      echo "ERROR";
    } else {
      $BD=$_SESSION["BDSecundaria"];
      $usuario=$_SESSION["Usuario"]; 
      $formulario=$_POST["formulario"];
      $pregunta=$_POST["id_pregunta"];
      $asignacion=$_POST["asignacion"];
      $local=$_POST["local"];
      $ruta='archivos/fotosFormulario/'.$BD.'/';
      if (!file_exists($ruta)) {
        mkdir($ruta, 0777, true); 
      }
      $clave=$usuario.'/'.$formulario.'/'.date("Y-m-d H:i:s");  
      if(isset($_POST["nombre_foto"]) && $_POST["nombre_foto"]!=""){
        if(isset($_FILES["file"]) && $_FILES["file"]["name"]!=''){
          $tipo=str_replace('image/', '.', $_FILES["file"]["type"]);
          if($tipo=='.jpg' ||  $tipo=='.jpeg' ||  $tipo=='.png'){
            $nom=explode("///", $_POST["nombre_foto"]);
            $nomfile=$_POST["nombre_foto"];
            $nombre=$this->subir_Foto($ruta,$nom[0]);
          }else{
            $nomfile="";
          }
        }else{
          $nomfile="";
        }
      } else { 
        if(isset($_FILES["file"]) && $_FILES["file"]["name"]!=''){
          $tipo=str_replace('image/', '.', $_FILES["file"]["type"]);
          if($tipo=='.jpg' ||  $tipo=='.jpeg' ||  $tipo=='.png'){
            $tmp = explode(".", $_FILES["file"]['name']);
            $extension = end($tmp);
            $filename ='formulario_'.$formulario.'_usuario_'.$usuario.'_pregunta_'.$pregunta.'_'.str_replace(':','',str_replace(' ','',date("Y-m-d H:i:s"))).'.'.$extension; 
            $nombre=$this->subir_Foto($ruta,$filename);       

            $add=$this->moduloFormularioApp->IngresarFormularioRespuesta($BD,$formulario,$usuario,$pregunta,$asignacion,$local,$pregElemento,$elemento,$nombre,$latitud,$longitud,$clave);
            $nomfile=$filename."///".$add->ID;
          }else{
            $nomfile="";  
          }
        } else {
          $nomfile="";
        }
      } 
      echo $nomfile;   
    }
    // if(isset($_FILES['p'.$i]) && $_FILES['p'.$i]!=""){
    //   ini_set ('gd.jpeg_ignore_warning', 1);
    //   $tmp = explode(".", $_FILES['p'.$i]['name']);
    //   $extension = end($tmp); 
    //   $ruta='archivos/fotosFormulario/'.$BD.'/';
    //   $filename ='formulario_'.$formulario.'_usuario_'.$usuario.'_pregunta_'.$_POST["pr".$i].'_'.str_replace(':','',str_replace(' ','',date("Y-m-d H:i:s"))).'.'.$extension;     
    //   $preg=$_POST["pr".$i];
                 
    // }
  }

  function IngresarFormularioUsuario(){
    if(isset($_SESSION["BDSecundaria"])){
      if(isset($_POST["tx_formulario"])){
        $BD=$_SESSION["BDSecundaria"];
        $usuario=$_SESSION["Usuario"];    
        $formulario=$_POST["tx_formulario"];
        if(isset($_POST["txt_contador"])){
          $contadorPregunta=$_POST["txt_contador"]; 
        }else{
          $contadorPregunta=$this->moduloFormularioApp->ListarCantidadPreguntaFormulario($BD,$formulario)->Cantidad;
        }       
        $asignacion=$_POST["txt_id_asignacion"];  
        $local=$_POST["txt_local"];
        $clave=$usuario.'/'.$formulario.'/'.date("Y-m-d H:i:s");
        for ($i=0; $i <$contadorPregunta ; $i++) {         
          if(isset($_POST["esRes".$i])){
            if($_POST["esRes".$i]==1){ 
              if($_POST["tp".$i]=="6" || $_POST["tp".$i]=="14"){
                $preg=$_POST["pr".$i];
                $latitud=$_POST["f_latitud"];
                $longitud=$_POST["f_longitud"];
                $cant=$_POST["cantOpcion_".$i]; 
                for ($x=0; $x <$cant ; $x++) {  
                  if(isset($_POST["cb-".$i.'-'.$x])){
                    $resp=$_POST["cb-".$i.'-'.$x];  
                    $this->moduloFormularioApp->IngresarFormularioRespuesta($BD,$formulario,$usuario,$preg,$asignacion,$local,"000","000",$resp,$latitud,$longitud,$clave);
                    if($_POST["cantPreg_".$i]>0){
                      $cantidad2=$_POST["cantPreg_".$i];
                      for ($y=1; $y <$cantidad2 ; $y++){
                        if($_POST["deptipo".$i.'-'.$x.'-'.$y]=="6"){
                          if($_POST["txt_contadorOpcionesDep".$i.'-'.$x.'-'.$y]>0){
                            $cantidad3=$_POST["txt_contadorOpcionesDep".$i.'-'.$x.'-'.$y];
                            for ($w=0; $w <$cantidad3 ; $w++){
                              if(isset($_POST["cb-".$i.'-'.$x.'-'.$y.'-'.$w])){
                                $this->moduloFormularioApp->IngresarFormularioRespuesta($BD,$formulario,$usuario,$_POST["depreg".$i.'-'.$x.'-'.$y],$asignacion,$local,$preg,$resp,$_POST["cb-".$i.'-'.$x.'-'.$y.'-'.$w],$latitud,$longitud,$clave);
                              }
                            }
                          }
                        }else{
                          if(isset($_POST["p".$i.'-'.$x.'-'.$y])){
                            if($_POST["deptipo".$i.'-'.$x.'-'.$y]!="8"){
                               $this->moduloFormularioApp->IngresarFormularioRespuesta($BD,$formulario,$usuario,$_POST["depreg".$i.'-'.$x.'-'.$y],$asignacion,$local,$preg,$resp,$_POST["p".$i.'-'.$x.'-'.$y],$latitud,$longitud,$clave);
                            } else if($_POST["deptipo".$i.'-'.$x.'-'.$y]=="8"){
                              if(isset($_POST["Tidfoto".$i.'-'.$x.'-'.$y]) && $_POST["Tidfoto".$i.'-'.$x.'-'.$y]!=""){
                                $id=explode("///", $_POST["Tidfoto".$i.'-'.$x.'-'.$y]);
                                $this->moduloFormularioApp->UpdateClaveFormularioRespuesta($BD,$latitud,$longitud,$clave,$id[1]);
                              }
                            }                        
                          }
                        }
                      }
                    }
                  }
                }
              }else if($_POST["tp".$i]!="15" && $_POST["tp".$i]!="8"){
                $preg=$_POST["pr".$i];
                $resp=$_POST["p".$i];   
                $latitud=$_POST["f_latitud"];
                $longitud=$_POST["f_longitud"];
                $this->moduloFormularioApp->IngresarFormularioRespuesta($BD,$formulario,$usuario,$preg,$asignacion,$local,"000","000",$resp,$latitud,$longitud,$clave);
              } else if($_POST["tp".$i]=="8"){
                if(isset($_POST["idfoto".$i]) && $_POST["idfoto".$i]!=""){
                  $id=explode("///", $_POST["idfoto".$i]);
                  $this->moduloFormularioApp->UpdateClaveFormularioRespuesta($BD,$latitud,$longitud,$clave,$id[1]);
                }
              }
            }
          }
        }
        if($local!='0'){
          $this->moduloFormularioApp->IngresarFormulariosCompletados($BD,$asignacion,$formulario,$usuario,$local);
        }        
      }else{
        redirect(site_url("App_ModuloTareas/elegirTareasAsignadas"));
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  function elegirRegion(){
    if(isset($_SESSION["BDSecundaria"])){
      $BD=$_SESSION["BDSecundaria"];
      $region = $_POST["formu"];    
      $idp = $_POST["idp"]; 
      $datos=$this->moduloFormularioApp->ListarFormularioPreguntaClousterLocalesComuna($BD,$idp,$region);
      echo "<option value='' >Selecione Comuna</option>";
      if ( $datos[0]!='') {          
        foreach ($datos as $da) {
          echo "<option value='".$da["Comuna"]."' >".$da["Comuna"]."</option>";
        }
      }else{
          echo "<option value='' >No esta categorizado por Comuna</option>";
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  function elegirDepartamento(){
    if(isset($_SESSION["BDSecundaria"])){
      $BD=$_SESSION["BDSecundaria"];
      $departamento = $_POST["formu"];    
      $idp = $_POST["idp"]; 
      $datos=$this->moduloFormularioApp->ListarFormularioPreguntaClousterLocalesProvincia($BD,$idp,$departamento);
      echo "<option value='' >Selecione Provincia</option>";
      if ( $datos[0]!='') {          
        foreach ($datos as $da) {
          echo "<option value='".$da["ID_Ciudad"]."' >".$da["Ciudad"]."</option>";
        }
      }else{
          echo "<option value='' >No esta categorizado por Provincia</option>";
      }
    }
  }

  function elegirProvincia(){
    if(isset($_SESSION["BDSecundaria"])){
      $BD=$_SESSION["BDSecundaria"];
      $provincia = $_POST["formu"];    
      $idp = $_POST["idp"]; 
      $datos=$this->moduloFormularioApp->ListarFormularioPreguntaClousterLocalesDistrito($BD,$idp,$provincia);
      echo "<option value='' >Selecione Distrito</option>";
      if ( $datos[0]!='') {          
        foreach ($datos as $da) {
          echo "<option value='".$da["Comuna"]."' >".$da["Comuna"]."</option>";
        }
      }else{
          echo "<option value='' >No esta categorizado por Provincia</option>";
      }
    }
  }

  function elegirCategoriaMS(){
    if(isset($_SESSION["BDSecundaria"])){
      $BD=$_SESSION["BDSecundaria"];
      $categoria = $_POST["formu"];
      $idp = $_POST["idp"]; 
      $contador = $_POST["con"];
      $local = $_POST["lc"];
      $onchange='onchange="dep'.$contador.'('.$contador.')"'; 
      echo $categoria;
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  function elegirCategoriaUS(){
    if(isset($_SESSION["BDSecundaria"])){
      $BD=$_SESSION["BDSecundaria"];
      $categoria = $_POST["formu"];
      $idp = $_POST["idp"]; 
      $contador = $_POST["con"];
      $onchange='onchange="dep'.$contador.'('.$contador.')"'; 
      $pOpcion1=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementosPorCategoria($BD,$idp,$categoria);
      $chkb = 0;
      foreach($pOpcion1 as $p){
        echo'<div class="checkbox abc-checkbox-danger abc-checkbox " >
              <input type="checkbox" name="p'.$contador.'" id="cb-'.$chkb.'" '.$onchange.' >
              <label for="cb-'.$chkb.'" style="width: 100%; font-size: 9px; text-align:left;" ><strong>'.$p["Nombre"].'</strong></label>
            </div>';
            $chkb++;
      }
      echo '</div>';
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  function elegirLocal(){
    if(isset($_SESSION["BDSecundaria"])){
      $BD=$_SESSION["BDSecundaria"];
      $region = $_POST["reg"];    
      $comuna = $_POST["com"];    
      $idp = $_POST["idp"]; 
      echo "<option value='' >Selecione Local</option>";
      $datos=$this->moduloFormularioApp->ListarFormularioPreguntaClousterLocalesComunaLocales($BD,$idp,$region,$comuna);
      if (isset($datos)) {
        foreach ($datos as $da) {
          echo "<option value='".$da["ID_Local"]."' >".$da["NombreLocal"]."</option>";
        }
      }else{
          echo "<option value='' >No exite Local</option>";
      }    
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  function CambiarElementoLocal(){
    if(isset($_SESSION["BDSecundaria"])){
      $BD=$_SESSION["BDSecundaria"];
      $idPregun = intval($_POST["idp"]);    
      $localfp = intval($_POST["lc"]);    
      $contador = intval($_POST["cont"]);
      $preguntaDepHijo='';
      $chkbb = 1;
      $CantPreg=0;
      $onchange='onchange="dep'.$contador.'('.$contador.')"';
      $onchangeSL='onchange="dep'.$contador; 
      $dependencia=$this->moduloFormularioApp->FormularioDependenciasPorHijo($BD,$idPregun,$localfp);             
      $pOpcion4=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementos($BD,$idPregun,$localfp);
      foreach($pOpcion4 as $p){                          
        echo  '<div class="checkbox abc-checkbox-danger abc-checkbox " id="divElement-'.$contador.'-'.$chkbb.'" style="display:none;" >
                <input type="hidden" id="element-'.$contador.'-'.$chkbb.'" value="'.str_replace(' ', '', $p["Categoria"]).'">
                <input type="checkbox" name="cb-'.$contador.'-'.$chkbb.'" id="cb-'.$chkbb.$contador.'" value="'.$p["ID_Elemento"].'" '.$onchangeSL.'('.$chkbb.$contador.')" >
                <label class="check" for="cb-'.$chkbb.$contador.'" style="width: 100%; font-size: 9px; text-align:left;" ><strong>'.$p["Nombre"].'</strong></label>';
        echo '<div style="display:none; padding-left: 8%;" id="div-'.$chkbb.$contador.'" >';
        echo '<input type="hidden" id="depResp-'.$chkbb.$contador.'" value="0">';
        $CantPreg=1;
        foreach ($dependencia as $c) {  
          if($c["esObligatorio"]==1){
            if(isset($_SESSION["Cliente"])){
              if($_SESSION["Cliente"]=="28"){
                $simbolo3="<span style='color:red'>&nbsp;Obligatorio</span>";
              }else{
                $simbolo3="<span style='color:red'>&nbsp;*</span>";
              }
            }else{
              $simbolo3="<span style='color:red'>&nbsp;*</span>";
            }
          }else{
            $simbolo3="";
          }                        
          $preguntaDepHijo.='<input type="hidden" id="deptipo'.$contador.'-'.$chkbb.'-'.$CantPreg.'" name="deptipo'.$contador.'-'.$chkbb.'-'.$CantPreg.'" value="'.$c["Tipo"].'">';  
          $preguntaDepHijo.='<input type="hidden" id="depOb'.$contador.'-'.$chkbb.'-'.$CantPreg.'" value="'.$c["esObligatorio"].'">';    
          $preguntaDepHijo.='<input type="hidden" id="depreg'.$contador.'-'.$chkbb.'-'.$CantPreg.'" name="depreg'.$contador.'-'.$chkbb.'-'.$CantPreg.'" value="'.$c["ID_FormularioPregunta"].'">';             
          if($c["Tipo"]=="1"){ // Texto Corto                
           $preguntaDepHijo.='<div class="input-prepend input-group">
                                  '.$c["NombrePregunta"].'  '.$simbolo3.' 
                                    <input type="text" class="form-control" id="itc'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkbb.'-'.$CantPreg.'" '.$onchange.'>
                                </div><hr>';
          }                            
          if($c["Tipo"]=="3"){ // Numeros                  
            $preguntaDepHijo.='
                                '.$c["NombrePregunta"].'  '.$simbolo3.'
                                  <input type="number" style="width: 100%;"  class="form-control" id="in'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkbb.'-'.$CantPreg.'" onkeypress="return SoloNumeros(event)" '.$onchange.'><hr>
                                ';
          }
	        if($c["Tipo"]=="5"){
                    $pOpcion1=$this->moduloFormularioApp->ListarFormularioOpcionUsuario($BD,$c["ID_FormularioPregunta"]);
                    $preguntaDepHijo.=''.$c["NombrePregunta"].'  '.$simbolo3.' <select class="form-control " id="i'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkbb.'-'.$CantPreg.'" '.$onchange.' style="width: 100%;">';
                    $preguntaDepHijo.='<option value="">Escoger un valor</option>';
                    foreach($pOpcion1 as $p){                                   
                      $preguntaDepHijo.='<option value="'.$p["ID_FormularioOpcion"].'">'.$p["NombreOpcion"].'</option>';
                    }   
                    $preguntaDepHijo.='</select>';
                  }
                  $preguntaDepHijo.='<hr>';
          if($c["Tipo"]=="8"){ // Foto               
            $preguntaDepHijo.=''.$c["NombrePregunta"].' '.$simbolo3.' 
                            <input type="file" style="width: 100%;"  class="btn btn-outline-theme dropify dropdep'.$c["ID_FormularioPregunta"].'" id="if'.$c["ID_FormularioPregunta"].'-'.$chkbb.$contador.'" name="p'.$contador.'-'.$chkbb.'-'.$CantPreg.'"  onchange="foto'.$contador.'('.$idPregun.','.$c["ID_FormularioPregunta"].','.$chkbb.$contador.');"><hr>';
                      $preguntaDepHijo.='<input id="Tidfoto'.$c["ID_FormularioPregunta"].'-'.$chkbb.$contador.'" name="Tidfoto'.$contador.'-'.$chkbb.'-'.$CantPreg.'" value="" type="hidden" >';
                      $preguntaDepHijo.='<input id="Ttxt_foto'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkbb.'-'.$CantPreg.'" value="'.base64_encode($contador).'" type="hidden" > ';
          }     
          $CantPreg++;                         
        }  
        if($preguntaDepHijo!=""){ // Texto Corto                
          echo $preguntaDepHijo;
          $preguntaDepHijo='';
        } 
        echo '</div>';
        $chkbb++;        
        echo '</div>';
      }
      echo'<script type="text/javascript">
      $(document).ready(function() { var a = $("#i'.$idPregun.'").val();';
      echo ' $("#div-"+num).removeAttr("style");';
                        echo ' var formu = $("#cb-"+num).val();';
      echo'});';
     
      echo'</script>' ;                        
      echo '<input type="hidden" name="cantOpcion_'.$contador.'" id="cantOpcion_'.$contador.'" value="'.$chkbb.'">';
      echo '<input type="hidden" name="cantPreg_'.$contador.'" id="cantPreg_'.$contador.'" value="'.$CantPreg.'">';
      echo '</div>';        
    }else{
      redirect(site_url("login/inicio"));
    }
  }

  function buscarSKU(){
    // var_dump($_POST);exit();
    $this->load->model("ModuloElemento");
    $sku=$_POST["sku"];
    $BD=$_SESSION["BDSecundaria"];
    $e=$this->ModuloElemento->buscarSKU($sku,$BD);
    echo "<ul class='list-group'>
            <li class='list-group-item'>Nombre: ".$e["Nombre"]."</li>
            <li class='list-group-item'>Categoria: ".$e["Categoria"]."</li>
            <li class='list-group-item'>Marca: ".$e["Marca"]."</li>
            <div class='img'>
              <img style='width:160px;height:120px' alt='img' src='".site_url()."".$e["Foto"]."'>
            </div>
          </ul>
    ";
  }

  public function subir_Foto($ruta,$filename){
    $foto1 = 'file';
    $config['upload_path'] = $ruta;
    $config['file_name'] =$filename;
    $config['allowed_types'] = "jpeg|jpg|png";
    $config['max_width'] = "9500";
    $config['max_height'] = "9500";
    $config['overwrite'] = TRUE;

    $this->upload->initialize($config);

    if (!$this->upload->do_upload($foto1)) {
      $data['uploadError'] = $this->upload->display_errors();
      echo $this->upload->display_errors();
      return;
    }
    $data = $this->upload->data();
    $tamano = $data['file_size'];
    $ancho = $data['image_width'];
    $alto = $data['image_height'];
    // if($tamano >= 200000 || $ancho >= 9500 || $alto >= 9500){
    //   $var = "2";
    //   return $var;
    // }
    $config['image_library'] = 'gd2';  
    $config['source_image'] = $ruta.$data["file_name"];  
    $config['create_thumb'] = FALSE;  
    $config['maintain_ratio'] = FALSE;  
    $config['quality'] = '60%';  
    $config['width'] = 800;  
    $config['height'] = 600;  
    $config['new_image'] = $ruta.$data["file_name"];  
    $this->load->library('image_lib', $config); 
    $this->image_lib->clear();
    $this->image_lib->initialize($config);
    $this->image_lib->resize();  


    $nombre= $data['file_name'];
    return $ruta.$nombre;
  }

  function verFormularioEspecial(){
    if(isset($_SESSION["BDSecundaria"])){
      if($_SESSION['Perfil']==3){ 
        $this->load->model("ModuloUsuarioApp");
        $data["Usuario"]=$_SESSION["Usuario"];          
        $data["Nombre"]=$_SESSION["Nombre"];
        $data["Perfil"] = $_SESSION["Perfil"];
        $data["Cargo"] = $_SESSION["Cargo"];
        if(isset($_POST["tx_form"])){
          $formulario=$_POST["tx_form"];
        }else{
          redirect(site_url("App_ModuloTareas/elegirTareasAsignadas")); 
        }
        $BD=$_SESSION["BDSecundaria"];
        $idUser=$_SESSION["Usuario"];
        $asignacion=$_POST["txt_id_asignacion"];
        $local=$_POST["txt_local"];
        $msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
        $data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
        $data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
        $data["cantidadMsj"]=count($data["mensaje"]);
        $data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
        $data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
        $info=$this->ModuloUsuarioApp->InfoUsuario($idUser);  
        $data["info"]=$info;
        $data["asignacion"]=$asignacion;
        $data["usuario"]=$idUser;
        $data["formulario"]=$formulario;
        $data["Region"]=$this->moduloFormularioApp->ListarRegionesFormEsp($_SESSION["BDSecundaria"],$formulario);
        $this->load->view('contenido');
        $this->load->view('layout/headerApp',$data);
        $this->load->view('layout/sidebarApp',$data);
        $this->load->view('App/FormularioEspecialApp',$data);
        $this->load->view('layout/footerApp',$data);      
      }else{
        redirect(site_url("login/inicio")); 
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  function cambiarRegionFormEsp(){
    $ciudad=$this->moduloFormularioApp->buscarCiudadPorRegionFormEsp($_SESSION["BDSecundaria"],$_POST["formulario"],$_POST["region"]);
    if($ciudad[0]!='') {          
        foreach ($ciudad as $ci) {
          echo "<option value='".$ci["ID_Ciudad"]."' >".$ci["Ciudad"]."</option>";
        }
      }else{
        echo "";
      }
  }

  function cambiarCiudadFormEsp(){
    $comuna=$this->moduloFormularioApp->buscarComunaPorCiudadFormEsp($_SESSION["BDSecundaria"],$_POST["formulario"],$_POST["ciudad"]);
    if($comuna[0]!='') {          
        foreach ($comuna as $c) {
          echo "<option value='".$c["ID_Comuna"]."' >".$c["Comuna"]."</option>";
        }
      }else{
        echo "";
      }
  }

  function cambiarComunaFormEsp(){
    $local=$this->moduloFormularioApp->buscarLocalPorComunaFormEsp($_SESSION["BDSecundaria"],$_POST["formulario"],$_POST["comuna"]);
    if($local[0]!='') {          
        foreach ($local as $l) {
          echo "<option value='".$l["ID_Local"]."' >".$l["NombreLocal"]."</option>";
        }
      }else{
        echo "";
      }
  }

  function validarDireccionLocal(){
    $direccion=$this->moduloFormularioApp->buscarDireccionPorLocal($_SESSION["BDSecundaria"],$_POST["local"]);
    if($direccion->Direccion!='0') {          
        echo $direccion->Direccion;
      }else{
        echo "";
      }
  }

  function verSubOpciones(){
    if(isset($_POST["opcion"])){
      $subtitulo=$this->moduloFormularioApp->buscarSubOpcion($_SESSION["BDSecundaria"],$_POST["opcion"])->subOpciones;
      if($subtitulo!=''){
        echo '<br><label style="color:red;font-style:oblique;">'.$subtitulo.'</label>';
      }else{
        echo '';
      }
    }else{
      echo '';
    }   
  }

  function IngresarFormularioEspecialUsuario(){
    if(isset($_SESSION["BDSecundaria"])){
      if($_SESSION['Perfil']==3){ 
        if(isset($_POST["txt_formulario"])){
          $usuario=$_POST["txt_usuario"];
          $local=$_POST["txt_local"];
          $direccion=$_POST["txt_direccion"];
          $latitud=$_POST["f_latitud"];
          $longitud=$_POST["f_longitud"];
          $this->moduloFormularioApp->IngresarFormularioEspecial($_SESSION["BDSecundaria"],$usuario,$local,$direccion,$latitud,$longitud);
        }else{
          redirect(site_url("App_ModuloTareas/elegirTareasAsignadas"));
        }
      }else{
        redirect(site_url("login/inicio")); 
      }
    }else{
      redirect(site_url("login/inicio")); 
    }
  }

  function ConfirmarUbicacion(){
    $la=$_POST["f_latitud"];
    $lo=$_POST["f_longitud"];;
    echo"<div class='chart tab-pane active' id='revenue-chart' style='position: relative; height: 300px;'><div style='width: 100%; height: 100%;' id='map'><h6 class='theme'><small>Error: debe compartir su ubicación</small></h6></div></div>
    </div>
    <div id='mapita'>
   <script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyC4Zt12Kgpaar2fMBofnlnslSF9cvG6F5M&callback=initMap'></script>
   </div>";
    echo'<script type="text/javascript">
    $( document ).ready(
      function findMe(){
          
       //Obtenemos latitud y longitud actual
        function localizacion(posicion){
          var latitude = posicion.coords.latitude;
          var longitude = posicion.coords.longitude;
          $("#f_latitud").val(latitude.toFixed(8));
          $("#f_longitud").val(longitude.toFixed(8));
                                       
        }
        navigator.geolocation.getCurrentPosition(localizacion);
      }); 
        </script>';
        echo"
      <script type='text/javascript'>      
                var map, infoWindow;

    // First, create an object containing LatLng and population for each city.
    //fijamos algunos puntos en el mapa con un circulo

   
    
    //dibujar la posicion donde nos encontramos en el mapa
    function initMap() {
   
      map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: ".$la.", lng: ".$lo."},
        zoom: 15,
        mapTypeControl: false,
        disableDefaultUI: false, // le dejamos solo el mapa por default
        styles: [
          {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
          {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
          {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
          {
            featureType: 'administrative.locality',
            elementType: 'labels.text.fill',
            stylers: [{color: '#d59563'}]
          },
          {
            featureType: 'poi',
            elementType: 'labels.text.fill',
            stylers: [{color: '#d59563'}]
          },
          {
            featureType: 'poi.park',
            elementType: 'geometry',
            stylers: [{color: '#263c3f'}]
          },
          {
            featureType: 'poi.park',
            elementType: 'labels.text.fill',
            stylers: [{color: '#6b9a76'}]
          },
          {
            featureType: 'road',
            elementType: 'geometry',
            stylers: [{color: '#38414e'}]
          },
          {
            featureType: 'road',
            elementType: 'geometry.stroke',
            stylers: [{color: '#212a37'}]
          },
          {
            featureType: 'road',
            elementType: 'labels.text.fill',
            stylers: [{color: '#9ca5b3'}]
          },
          {
            featureType: 'road.highway',
            elementType: 'geometry',
            stylers: [{color: '#746855'}]
          },
          {
            featureType: 'road.highway',
            elementType: 'geometry.stroke',
            stylers: [{color: '#1f2835'}]
          },
          {
            featureType: 'road.highway',
            elementType: 'labels.text.fill',
            stylers: [{color: '#f3d19c'}]
          },
          {
            featureType: 'transit',
            elementType: 'geometry',
            stylers: [{color: '#2f3948'}]
          },
          {
            featureType: 'transit.station',
            elementType: 'labels.text.fill',
            stylers: [{color: '#d59563'}]
          },
          {
            featureType: 'water',
            elementType: 'geometry',
            stylers: [{color: '#17263c'}]
          },
          {
            featureType: 'water',
            elementType: 'labels.text.fill',
            stylers: [{color: '#515c6d'}]
          },
          {
            featureType: 'water',
            elementType: 'labels.text.stroke',
            stylers: [{color: '#17263c'}]
          }
        ]
      });

      var iconBase = 'http://maps.google.com/mapfiles/kml/paddle/';
      var icons = {
        parking: {
          name: 'Parking',
          icon: iconBase + 'blu-circle.png'
        }
      };

      var features = [
        {
          position: new google.maps.LatLng(".$la.",".$lo."),
          type: 'parking',
          title: 'Punto de Venta'
        }
        ];

      features.forEach(function(feature) {
        var marker = new google.maps.Marker({
          position: feature.position,
          icon: icons[feature.type].icon,
          map: map
        });
      });
      
       
      infoWindow = new google.maps.InfoWindow;

    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
      infoWindow.setPosition(pos);
      infoWindow.setContent(browserHasGeolocation ?
                            'Error: El servicio de Geolocalización no esta disponible.' :
                            'Error: Puede que no este Activado el GPS o no ha comportido su Localización');
      infoWindow.open(map);
    }    
    </script>
    

    ";
    }
  }  
?>
