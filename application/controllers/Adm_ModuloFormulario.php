<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloFormulario extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("moduloFormulario");
		$this->load->model("funcion_login");
	}
	
	function crearFormulario(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1){ 		
				$BD=$_SESSION["BDSecundaria"];		
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["TiposPreguntas"]=$this->moduloFormulario->ListarTiposPreguntasFormulario();
				$data["ListaMaestra"]=$this->moduloFormulario->ListarListaMaestraFormulario($BD);
				$data["ListaMaestraLocales"]=$this->moduloFormulario->ListarListaMaestraLocales($BD);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Cargo"] = $_SESSION["Cargo"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearFormularios',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
			   redirect(site_url("login/inicio"));
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function editarFormulario(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1){ 		
				if(isset($_POST["txt_id"])){					
					$BD=$_SESSION["BDSecundaria"];		
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$TiposPreguntas=$this->moduloFormulario->ListarTiposPreguntasFormulario();
					$data["TiposPreguntas"]=$TiposPreguntas;
					$ListaMaestra=$this->moduloFormulario->ListarListaMaestraFormulario($BD);
					$data["ListaMaestra"]=$ListaMaestra;
					$ListaMaestraLocales=$this->moduloFormulario->ListarListaMaestraLocales($BD);
					$data["ListaMaestraLocales"]=$ListaMaestraLocales;
					$this->load->model("moduloFormularioApp");
					$formularioPrincipal=$this->moduloFormularioApp->ListarFormularioUsuario($BD,$_POST["txt_id"]);
					$formu='<div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Nombre del Formulario <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                    <label>'.$formularioPrincipal["NombreFormulario"].'</label>
                                    <input type="hidden" name="tx_formulario" value="'.$formularioPrincipal["ID_Formulario"].'">
                                </div>    
                            </div>
							<br>';	
                  	$formularioModulos=$this->moduloFormulario->ListarFormularioModuloEditar($BD,$formularioPrincipal["ID_Formulario"]);
                  	$modulo=0;
                  	$contadorModulo=0;
                  	foreach ($formularioModulos as $fm) {
                  		$modulo++;
                  		if($fm["Activo"]==1){$vigenciaModulo='checked value="1"';}else{$vigenciaModulo='value="0"';}
                  		$formu.='<div id="numeroModulo'.$modulo.'" class="border-modulo">
                  					<span class="pull-right" style="padding-bottom: 1.5%;" ><button type="button" class="btn btn-theme btn-sm"><i class="fa fa-eye-slash"></i></button></span>
                  					<p class="margin"><input id="ordenM-'.$modulo.'" min="1" max="'.$modulo.'" type="number" value="'.$fm["Orden"].'" onchange="ordenarM();" style="width: 2.5%;" name="ordenM-'.$modulo.'"> M&oacute;dulo </p>
                  					<input type="text" class="form-control" id="nombreModulo'.$modulo.'" name="nombreModulo'.$modulo.'" value="'.$fm["NombreModulo"].'" placeholder="Nombre del m&oacute;dulo">
                  					<input type="hidden" id="txt_IDModulo'.$modulo.'" name="txt_IDModulo'.$modulo.'" value="'.$fm["ID_FormularioModulo"].'">
                  					<br>
                  					<div class="input-group">
                  						<p class="margin"><i class="fa fa-dot-circle-o"></i> Activo</p>
                  						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  						<span class=""><label class="switch"><input type="checkbox" onclick="vigenciaModulo('.$modulo.');" id="vigModulo'.$modulo.'" name="vigModulo'.$modulo.'" '.$vigenciaModulo.' ><span class="slider round"></span></label></span>
                  					</div>                  					
                  					<br>';
              			$formularioPreguntas=$this->moduloFormulario->ListarFormularioPreguntaEditar($BD,$fm["ID_FormularioModulo"]);
              			$pregunta=0;
                  		$contadorPregunta=0;
              			foreach ($formularioPreguntas as $fp) {
              				$pregunta++;
              				if($fp["Activo"]==1){$vigenciaPregunta='checked value="1"';}else{$vigenciaPregunta='value="0"';}
                  			if($fp["esObligatorio"]==1){$obligatorioPregunta='checked value="1"';}else{$obligatorioPregunta='value="0"';}
              				$formu.='<div id="numeroPregunta'.$modulo.'_'.$pregunta.'" class="border-pregunta">
              							<p class="margin"><input id="ordenP-'.$modulo.'_'.$pregunta.'" min="1" max="'.$pregunta.'" type="number" value="'.$pregunta.'" style="width: 3.5%;" name="ordenP-'.$modulo.'_'.$pregunta.'"> Pregunta</p>
              							<input type="text" class="form-control" id="nombrePregunta'.$modulo.'_'.$pregunta.'" name="nombrePregunta'.$modulo.'_'.$pregunta.'" placeholder="Texto de la pregunta" value="'.$fp["NombrePregunta"].'">
              							<input type="hidden" id="txt_IDPregunta'.$modulo.'_'.$pregunta.'" name="txt_IDPregunta'.$modulo.'_'.$pregunta.'"value="'.$fp["ID_FormularioPregunta"].'">
              							<br>
          								<p class="margin"><i class="fa fa-dot-circle-o"></i> Tipo de respuesta esperada</p>
          								<div class="input-group">
          									<span class="input-group-addon"><i class="fa fa-toggle-right"></i></span>
          									<select id="typePregunta'.$modulo.'_'.$pregunta.'" name="typePregunta'.$modulo.'_'.$pregunta.'" class="form-control" onchange="elegirPregunta('.$modulo.','.$pregunta.');">
          										<option value="">Seleccione tipo de respuesta</option>';
          										foreach($TiposPreguntas as $t){ 
          											$formu.="<option value='".$t["ID_FormularioTipoPregunta"]."'";
          											if($t["ID_FormularioTipoPregunta"]==$fp["Tipo"]){
          												$formu.=" selected ";
          											}
          										$formu.=">".$t["Nombre"]."</option>";
          										} 
          							$formu.='</select>
          								</div>
              							<br>              							
              							<div id="div_eleccion'.$modulo.'_'.$pregunta.'">';
              							if($fp["Tipo"]==5 || $fp["Tipo"]==6){  
              								$opciones=0;
              								$formularioOpciones=$this->moduloFormulario->ListarFormularioOpcionEditar($BD,$fp["ID_FormularioPregunta"]);
              								foreach ($formularioOpciones as $fo){
              								$opciones++;
              								$formu.='<div class="input-group">
              											<span class="input-group-addon"><i class="fa fa-circle"></i></span>
              											<input type="text" class="form-control" name="txt_elemento'.$modulo.'_'.$pregunta.'_'.$opciones.'" id="txt_elemento'.$modulo.'_'.$pregunta.'_'.$opciones.'" placeholder="Ingresar Nombre Elecci&oacute;n" value="'.$fo["NombreOpcion"].'">
              										</div>
              										<input type="hidden" id="txt_IDOpcion'.$modulo.'_'.$pregunta.'_'.$opciones.'" name="txt_IDOpcion'.$modulo.'_'.$pregunta.'_'.$opciones.'" value="'.$fo["ID_FormularioOpcion"].'">';              										
              								}
              								$formu.='<div id="div_elementos'.$modulo.'_'.$pregunta.'"></div>
              										<div class="form__box"><button type="button" class="btn btn-theme btn-sm" onclick="addElemento('.$modulo.','.$pregunta.')"><i class="fa fa-plus"></i> Agregar Opci&oacute;n</button></div>
              										<input type="hidden" name="cuentaOpciones'.$modulo.'_'.$pregunta.'" id="cuentaOpciones'.$modulo.'_'.$pregunta.'" value="'.$opciones.'">
              										<br>';
              							}elseif($fp["Tipo"]==7 || $fp["Tipo"]==14){
              								$fme=$this->moduloFormulario->ListarFormularioClusterElementoEditar($BD,$fp["ID_FormularioPregunta"]);
              								$formu.='<div class="input-group">
              											<span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
              											<select class="form-control" name="txt_maestra'.$modulo.'_'.$pregunta.'" id="txt_maestra'.$modulo.'_'.$pregunta.'">
	              											<option value="">Elija una Maestra</option>';
	              											foreach ($ListaMaestra as $l){
	              												$formu.='<option value="'.$l["ID_Cluster"].'"';
	              												if($fme["FK_Cluster_ID_Cluster"]==$l["ID_Cluster"]){
			          												$formu.=" selected ";
			          											}
	              												$formu.='>'.$l["NombreCluster"].'</option>';
	              											}
              									$formu.='</select>
              										</div>
              										<input type="hidden" id="txt_IDElementos'.$modulo.'_'.$pregunta.'" name="txt_IDElementos'.$modulo.'_'.$pregunta.'" value="'.$fme["ID_FormulariosClusters"].'">
              										<br>';
              							}elseif ($fp["Tipo"]==15) {
              								$fml=$this->moduloFormulario->ListarFormularioClusterLocalEditar($BD,$fp["ID_FormularioPregunta"]);
              								$formu.='<div class="input-group">
              											<span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
              											<select class="form-control" name="txt_maestra'.$modulo.'_'.$pregunta.'" id="txt_maestra'.$modulo.'_'.$pregunta.'">
              												<option value="">Elija una Maestra</option>';
              											foreach ($ListaMaestraLocales as $l){
              												$formu.='<option value="'.$l["ID_Cluster"].'"';
              												if($fml["FK_Cluster_ID_Cluster"]==$l["ID_Cluster"]){
		          												$formu.=" selected ";
		          											}
              												$formu.='>'.$l["Nombre"].'</option>';
              											}
              									$formu.= '</select>
              										</div>
              										<input type="hidden" id="txt_IDElementos'.$modulo.'_'.$pregunta.'" name="txt_IDElementos'.$modulo.'_'.$pregunta.'" value="'.$fml["ID_FormulariosClusters"].'">
              										<br>';
              							}
              							$formu.='</div>
              							<div class="input-group">
              								<p class="margin"><i class="fa fa-dot-circle-o"></i> Activo</p>
              								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              								<span class=""><label class="switch"><input type="checkbox" onclick="vigenciaPregunta('.$modulo.','.$pregunta.');" id="vigPregunta'.$modulo.','.$pregunta.'" name="vigPregunta'.$modulo.'_'.$pregunta.'" '.$vigenciaPregunta.' ><span class="slider round"></span></label></span>
              								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              								<p class="margin"><i class="fa fa-dot-circle-o"></i> Obligatorio</p>
              								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              								<span class=""><label class="switch"><input type="checkbox" onclick="obligatorioPregunta('.$modulo.','.$pregunta.');" id="oblPregunta'.$modulo.'_'.$pregunta.'" name="oblPregunta'.$modulo.'_'.$pregunta.'" '.$obligatorioPregunta.' ><span class="slider round"></span></label></span>
              							</div>
              						</div>
              						<br id="brPregunta'.$modulo.'_'.$pregunta.'">';
              			}
              			$formu.='<div id="agregaPreguntas'.$modulo.'"></div>
              					<input id="cuentaPreguntas'.$modulo.'" name="cuentaPreguntas'.$modulo.'" type="hidden" value="'.$pregunta.'">
              					<div class="form__box">
              						<button onclick="addPregunta('.$modulo.');" type="button" class="btn btn-theme btn-sm"><i class="fa fa-plus"></i> Agregar Pregunta</button>
              						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              						
              					</div>
              				</div>
              				<br id="brModulo'.$modulo.'">';
              		}
              		$formu.='<input id="cuentaModulos" name="cuentaModulos" type="hidden" value="'.$modulo.'">';
					$data["Formulario"]=$formu;					
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Cargo"] = $_SESSION["Cargo"];
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminEditarFormularios',$data);
				   	$this->load->view('layout/footer',$data);
			   }else{
			   	redirect(site_url("Adm_ModuloFormulario/adminFormulario"));
			   }
			}else{
			   redirect(site_url("login/inicio"));
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function adminFormulario(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1){ 		
				$BD=$_SESSION["BDSecundaria"];		
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Formularios"]=$this->moduloFormulario->ListarFormulario($BD);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Cargo"] = $_SESSION["Cargo"];
				$data['mensaje']='';
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminFormularios',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
			   redirect(site_url("login/inicio"));
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function adminFormularioEspeciales(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1){ 	
				$this->load->model("ModuloPuntosVentas");
				$BD=$_SESSION["BDSecundaria"];		
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Formularios"] = $this->moduloFormulario->ListarFormulariosEspeciales($_SESSION["BDSecundaria"]);
				$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
				$data["Cargo"] = $_SESSION["Cargo"];
				$data['mensaje']='';
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminFormulariosEspeciales',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
			   redirect(site_url("login/inicio"));
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function galeriaform($id){
		$c=openssl_decrypt(str_replace('+','###',str_replace('@@', '/', $id)),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
		$cliente=$this->funcion_login->BuscarCliente($c);
      	$BD=$cliente["nombrebd"];
      	$data["cli"]=$c;
      	$data["link"]=$id;
      	$this->load->view('contenido');
      	$opcion=(isset($_POST["opcion"])) ? (is_numeric($_POST["opcion"])) ? $_POST["opcion"] : 1 : 1;
      	$fecha=(isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      	$local=(isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      	$form=isset($_POST["form"]) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;
      	$cadena=(isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      	$data["opcion"]=$opcion;
      	$data["form"]=$form;
      	$data["local"]=$local;
      	$data['fecha']=$fecha;
      	$data["cadena"]=$cadena;
      	$data["tipotarea"]=1;
      	if(!isset($_GET["view"])){
      		$this->load->view("layout/progress",$data);
      		$data["fotos"]=$this->moduloFormulario->ListarGaleriaForm($BD,$form,$local,$cadena,$fecha,$opcion);
      		$gallery="admin/adminGaleriaForm";      		
      	} else {
      		$data["view"]=$_GET["view"];
      		$this->load->view("layout/progress",$data);
      		$zona=(isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
          	$territorio=(isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
          	$depto=(isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
         	$distrito=(isset($_POST["distrito"])) ? (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
          	$provincia=(isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
          	$usuario=(isset($_POST["usuario"])) ? (empty($_POST["usuario"])) ? 0 : $_POST["usuario"] : 0;
          	$data["zona"]=$zona;
          	$data["territorio"]=$territorio;
          	$data["depto"]=$depto;
          	$data["distrito"]=$distrito;
          	$data["provincia"]=$provincia;
          	$data["usuario"]=$usuario;
          	$fe=openssl_decrypt($_GET["view"],"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
          	if($fe==1){
	            $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ? 0 : $_POST["canal"] : 0;
	            $data["canal"]=$canal;
	            $tr="Canal Personas";
	        }  else if($fe==2){
	            $tr="Canal Mayorista";
	            $canal=0;
	        }
	        $data["tr"]=$tr;
	        $data["fotos"]=$this->moduloFormulario->ListarGaleriaFE($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$fe,$opcion);
	        $gallery="admin/adminGaleriaFormFE";
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

	public function listarusuario(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $form=(isset($_POST["form"])) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $usuario=0;
      echo json_encode($this->moduloFormulario->ListarUsuariosFormActivos($cliente["nombrebd"],$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo));
	}

	public function listarform(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $form=0;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $usuario=(isset($_POST["usuario"])) ? (empty($_POST["usuario"])) ? 0 : $_POST["usuario"] : 0;
      echo json_encode($this->moduloFormulario->ListarFormulariosActivos($cliente["nombrebd"],$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo));
	}

	public function listarzona(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $form=(isset($_POST["form"])) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $usuario=(isset($_POST["usuario"])) ? (empty($_POST["usuario"])) ? 0 : $_POST["usuario"] : 0;
      echo json_encode($this->moduloFormulario->ListarZonasActivas($cliente["nombrebd"],$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo));
	}

	public function listarterritorio(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $form=(isset($_POST["form"])) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $usuario=(isset($_POST["usuario"])) ? (empty($_POST["usuario"])) ? 0 : $_POST["usuario"] : 0;
      echo json_encode($this->moduloFormulario->ListarTerritoriosActivos($cliente["nombrebd"],$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo));
	}

	public function listardepto(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $form=(isset($_POST["form"])) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $usuario=(isset($_POST["usuario"])) ? (empty($_POST["usuario"])) ? 0 : $_POST["usuario"] : 0;
      echo json_encode($this->moduloFormulario->ListarDeptosActivos($cliente["nombrebd"],$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo));
	}

	public function listarprovincia(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $form=(isset($_POST["form"])) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $usuario=(isset($_POST["usuario"])) ? (empty($_POST["usuario"])) ? 0 : $_POST["usuario"] : 0;
      echo json_encode($this->moduloFormulario->ListarProvinciasActivas($cliente["nombrebd"],$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo));
	}

	public function listardistrito(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $form=(isset($_POST["form"])) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $usuario=(isset($_POST["usuario"])) ? (empty($_POST["usuario"])) ? 0 : $_POST["usuario"] : 0;
      echo json_encode($this->moduloFormulario->ListarDistritosActivos($cliente["nombrebd"],$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo));
	}

	public function listarcadena(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $form=(isset($_POST["form"])) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $usuario=(isset($_POST["usuario"])) ? (empty($_POST["usuario"])) ? 0 : $_POST["usuario"] : 0;
      echo json_encode($this->moduloFormulario->ListarCadenasActivas($cliente["nombrebd"],$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo));
	}

	public function listarcanal(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $form=(isset($_POST["form"])) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;;
      $local= (isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= 0;
      $usuario=(isset($_POST["usuario"])) ? (empty($_POST["usuario"])) ? 0 : $_POST["usuario"] : 0;
      echo json_encode($this->moduloFormulario->ListarCanalActivos($cliente["nombrebd"],$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo));
	}

	public function listarlocal(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha = (isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $form=(isset($_POST["form"])) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;;
      $local= 0;
      $zona= (isset($_POST["zona"])) ? (empty($_POST["zona"])) ? 0 : $_POST["zona"] : 0;
      $territorio= (isset($_POST["territorio"])) ? (empty($_POST["territorio"])) ? 0 : $_POST["territorio"] : 0;
      $depto= (isset($_POST["depto"])) ? (empty($_POST["depto"])) ? 0 : $_POST["depto"] : 0;
      $distrito= (isset($_POST["distrito"])) ?  (empty($_POST["distrito"])) ? 0 : $_POST["distrito"] : 0;
      $provincia= (isset($_POST["provincia"])) ? (empty($_POST["provincia"])) ? 0 : $_POST["provincia"] : 0;
      $cadena= (isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      $canal= (isset($_POST["canal"])) ? (empty($_POST["canal"])) ?  0 : $_POST["canal"] : 0;
      $usuario=(isset($_POST["usuario"])) ? (empty($_POST["usuario"])) ? 0 : $_POST["usuario"] : 0;
      echo json_encode($this->moduloFormulario->ListarLocalesActivos($cliente["nombrebd"],$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo));
	}

	public function powerpointform($id){
      $c=openssl_decrypt(str_replace('+','###',str_replace('@@','/',$id)),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $this->load->model("ModuloCliente");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $this->load->library('Ppt_stuff');
      $formulario=$_POST["lb_formulario"];
      $BD=$cliente["nombrebd"];
      $foto["logo"]=$cliente["logo"];
      $foto["NombreFormulario"]=$this->moduloFormulario->ListarFiltros($BD,$formulario)[0]["NombreFormulario"];
      $arrayfotos=$this->moduloFormulario->ListarGaleriaPPT($BD,$formulario);
	  $this->ppt_stuff->make_ppt($foto,$arrayfotos);
    }

    public function pdf($id){
      $c=openssl_decrypt(str_replace('+','###',str_replace('@@','/',$id)),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $this->load->model("ModuloCliente");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $this->load->library('reportepdf');
      $formulario=$_POST["lb_formulario"];
      $BD=$cliente["nombrebd"];
      $data["logo"]=$cliente["logo"];
      $data["fotos"]=$this->moduloFormulario->ListarGaleriaPPT($BD,$formulario);
      $data["nombre"]=$this->moduloFormulario->ListarFiltros($BD,$formulario)[0]["NombreFormulario"];
      $this->reportepdf->load_view('admin/Reportepdfform',$data);
      $this->reportepdf->render();
      $this->reportepdf->setPaper('letter', 'portrait');
      $this->reportepdf->stream($data["nombre"].".pdf");
    }

    public function formularios(){
      $id=$_POST["tr"];
      $t=$_POST["v"];
      $c=openssl_decrypt(str_replace('@@','/',$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $tipo=openssl_decrypt($t,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->moduloFormulario->ListarFormulariosActivos($cliente["nombrebd"],0,0,0,0,0,0,0,0,0,0,$tipo));

    }

    public function galeriaformularios(){
      $id=$_POST["tr"];
      $rep=array('@@','###');
      $ori=array('/','+');
      $c=openssl_decrypt(str_replace($rep,$ori,$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");      
      $cliente=$this->funcion_login->BuscarCliente($c);
      echo json_encode($this->moduloFormulario->ListarFormformularios($cliente["nombrebd"],0,0,0,0));
    }

    public function listargaleriaform(){
      $id=$_POST["tr"];
      $rep=array('@@','###');
      $ori=array('/','+');
      $c=openssl_decrypt(str_replace($rep,$ori,$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha=(isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $local=(isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $form=isset($_POST["form"]) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;
      $cadena=(isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
       echo json_encode($this->moduloFormulario->ListarFormformularios($cliente["nombrebd"],$form,$cadena,$local,$fecha));

    }

    public function listargaleriacadena(){
      $id=$_POST["tr"];
      $rep=array('@@','###');
      $ori=array('/','+');
      $c=openssl_decrypt(str_replace($rep,$ori,$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha=(isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $local=(isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $form=isset($_POST["form"]) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;
      $cadena=(isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
      echo json_encode($this->moduloFormulario->ListarCadenaformularios($cliente["nombrebd"],$form,$cadena,$local,$fecha));

    	
    }

    public function listargalerialocal(){
      $id=$_POST["tr"];
     $rep=array('@@','###');
      $ori=array('/','+');
      $c=openssl_decrypt(str_replace($rep,$ori,$id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678");
      $cliente=$this->funcion_login->BuscarCliente($c);
      $fecha=(isset($_POST["fecha_registro"])) ? (empty($_POST["fecha_registro"])) ? 0 : str_replace('/', '-', $_POST["fecha_registro"]) : 0;
      $local=(isset($_POST["local"])) ? (empty($_POST["local"])) ? 0 : $_POST["local"] : 0;
      $form=isset($_POST["form"]) ? (empty($_POST["form"])) ? 0 : $_POST["form"] : 0;
      $cadena=(isset($_POST["cadena"])) ? (empty($_POST["cadena"])) ? 0 : $_POST["cadena"] : 0;
       echo json_encode($this->moduloFormulario->ListarLocalesformularios($cliente["nombrebd"],$form,$cadena,$local,$fecha));

    }


	function galeria($id){
		$c=explode('-',openssl_decrypt(str_replace('@@', '/', $id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678"));
		$cliente=$this->funcion_login->BuscarCliente($c[0]);
		$BD=$cliente["nombrebd"];
		$formulario=$c[1];
		if(isset($_POST['opcion'])){
			if(is_numeric($_POST['opcion'])){
				$busca = $_POST['opcion'];
			}else{
				$busca=1;
			}
		}else{
			$busca=1;
		}
		if(isset($_POST["lbl_pdv"])){
			if(!empty($_POST["lbl_pdv"])){
				$local=$_POST["lbl_pdv"];
				$data["nom_local"]=$this->findNameFromIDLocal($this->moduloFormulario->ListarLocales($BD,$formulario),$local)[0]["nombrelocal"];
			} else {
				$local=0;
			}
		} else {
			$local=0;
		}
		if(isset($_POST["lbl_cadena"])){
			if(!empty($_POST["lbl_cadena"])){
				$cadena=$_POST["lbl_cadena"];
				$data["nom_cadena"]=$this->findNameFromIDCadena($this->moduloFormulario->ListarCadenas($BD,$formulario),$cadena)[0]["nombrecadena"];
			} else {
				$cadena=0;
			}
		} else {
			$cadena=0;
		}
		if(isset($_POST["lbl_comuna"])){
			if(!empty($_POST["lbl_comuna"])){
				$comuna=$_POST["lbl_comuna"];
				$data["nom_comuna"]=$this->findNameFromIDComuna($this->moduloFormulario->ListarComunas($BD,$formulario),$comuna)[0]["comuna"];
			} else {
				$comuna=0;
			}
		} else {
			$comuna=0;
		}
		if(isset($_POST["lbl_region"])){
			if(!empty($_POST["lbl_region"])){
				$region=$_POST["lbl_region"];
				$data["nom_region"]=$this->findNameFromIDRegion($this->moduloFormulario->ListarRegiones($BD,$formulario),$region)[0]["region"];
			} else {
				$region=0;
			}
		} else {
			$region=0;
		}
		if(isset($_POST["txt_fecha"])){
			if(!empty($_POST["txt_fecha"])){
				$fecha=str_replace('/', '-', $_POST["txt_fecha"]);
			} else {
				$fecha=0;
			}
		} else {
			$fecha=0;
		}
		$data["link"]=$id;
		$data['opcion']=$busca;
		$data['local']=$local;
		$data['cadena']=$cadena;
		$data['comuna']=$comuna;
		$data['region']=$region;
		$data['fecha']=$fecha;
		$data["fotos"]=$this->moduloFormulario->ListarGaleria($BD,$formulario,$local,$cadena,$comuna,$region,$fecha,$busca);
		$data["cantcadena"]=$this->moduloFormulario->ListarGaleriaCadena($BD,$formulario,$local,$cadena,$comuna,$region,$fecha);
		if(count($data["fotos"])>0){
			$tempoCantidad = $data["fotos"][0]["total"];
			$data['cantidad'] = ceil(($tempoCantidad+1)/16);
		} else {
			$tempoCantidad = 0;
			$data['cantidad'] = 0;
		}
		$data["filtros"]=$this->moduloFormulario->ListarFiltros($BD,$formulario);
		if(isset($_SESSION["sesion"])){
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"] = $_SESSION["Perfil"];
			$data["Cliente"] = $_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Cargo"] = $_SESSION["Cargo"];
			$data["Clientes"]= $this->funcion_login->elegirCliente();
			$this->load->view('contenido');
			$this->load->view('layout/header',$data);
	   		$this->load->view('layout/sidebar',$data);	
		} else {
			$data["Cliente"] = $c[0];
			$data["NombreCliente"]=$cliente["nombre"];
			$this->load->view('contenido');
			$this->load->view('layout/headergaleria',$data);
		}
		if((count($data["filtros"])>0 && count($data["fotos"])>0 && count($data["cantcadena"])>0) || (count($data["filtros"])>0 || count($data["fotos"])>0 || count($data["cantcadena"])>0)){
			$this->load->view('admin/adminGaleria',$data);  
		} else {
		 	echo "<script>alert('No se encuentran fotos.'); window.location.href='".base_url("Adm_ModuloFormulario/adminFormulario")."'</script>";
		}		 			
	   	$this->load->view('layout/footer',$data);
	}

	function findNameFromIDLocal($array,$ID) {
       return array_values(array_filter($array, function($arrayValue) use($ID) { return $arrayValue['id_local'] == $ID; } ));
  	}

  	function findNameFromIDRegion($array,$ID) {
       return array_values(array_filter($array, function($arrayValue) use($ID) { return $arrayValue['id_region'] == $ID; } ));
  	}

  	function findNameFromIDCadena($array,$ID) {
       return array_values(array_filter($array, function($arrayValue) use($ID) { return $arrayValue['id_cadena'] == $ID; } ));
  	}

  	function findNameFromIDComuna($array,$ID) {
       return array_values(array_filter($array, function($arrayValue) use($ID) { return $arrayValue['id_comuna'] == $ID; } ));
  	}

	public function powerpoint($id){
		$this->load->library('Ppt_stuff');
		$this->load->model("ModuloCliente");
		$c=explode('-',openssl_decrypt(str_replace('@@', '/', $id),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678"));
		$cliente=$this->funcion_login->BuscarCliente($c[0]);
		$BD=$cliente["nombrebd"];
		$formulario=$c[1];
		$foto["logo"]=$cliente["logo"];
		$foto["NombreFormulario"]=$this->moduloFormulario->ListarFiltros($BD,$formulario)[0]["NombreFormulario"];
		if($cliente["nombre"]=="JSC"){
			$fecha=date("Ymd",strtotime($_POST["txt_fechappt"]));
			$arrayfotos=$this->moduloFormulario->pptjsc($BD,$formulario,$fecha);
			$this->ppt_stuff->pptjsc($foto,$arrayfotos);
		} else {
			$arrayfotos=$this->moduloFormulario->ListarGaleriaPPT($BD,$formulario);
			$this->ppt_stuff->make_ppt($foto,$arrayfotos);
		}
		return;
	}

	public function listarcomunas(){
		if(isset($_POST["comuna"])){
			$c=explode('-',openssl_decrypt(str_replace('@@', '/', $_POST["comuna"]),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678"));
			$cliente=$this->funcion_login->BuscarCliente($c[0]);
			$BD=$cliente["nombrebd"];
			$formulario=$c[1];
			echo json_encode($this->moduloFormulario->ListarComunas($BD,$formulario));
		}
	}

	public function listarregiones(){
		if(isset($_POST["region"])){
			$c=explode('-',openssl_decrypt(str_replace('@@', '/', $_POST["region"]),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678"));
			$cliente=$this->funcion_login->BuscarCliente($c[0]);
			$BD=$cliente["nombrebd"];
			$formulario=$c[1];
			echo json_encode($this->moduloFormulario->ListarRegiones($BD,$formulario));
		}
	}

	public function listarcadenas(){
		if(isset($_POST["cadena"])){
			$c=explode('-',openssl_decrypt(str_replace('@@', '/', $_POST["cadena"]),"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678"));
			$cliente=$this->funcion_login->BuscarCliente($c[0]);
			$BD=$cliente["nombrebd"];
			$formulario=$c[1];
			echo json_encode($this->moduloFormulario->ListarCadenas($BD,$formulario));
		}
	}

	public function listarlocales(){
		if(isset($_POST["local"])){
			$c=explode('-',openssl_decrypt($_POST["local"],"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678"));
			$cliente=$this->funcion_login->BuscarCliente($c[0]);
			$BD=$cliente["nombrebd"];
			$formulario=$c[1];
			echo json_encode($this->moduloFormulario->ListarLocales($BD,$formulario));
		}
	}

	function excelPreguntasDependientes(){
		if(isset($_FILES["fl_preguntasDep"])){
			$modulo=$_POST["txt_modulo"];
			$pregunta=$_POST["txt_pregunta"];
			$excel = $this->limpiaEspacio($_FILES['fl_preguntasDep']['name']);	
			move_uploaded_file($_FILES['fl_preguntasDep']['tmp_name'],'archivos/archivos_Temp/'.$excel);			
			$this->load->library('phpexcel');
			$objReader = new PHPExcel_Reader_Excel2007();
			$object = $objReader->load("archivos/archivos_Temp/".$excel);
			$parametro =0;
		 	set_time_limit(600);	
			$cantidad=0;
			$objWorksheet = $object->setActiveSheetIndex(0);
			$columnaFinal = $objWorksheet->getHighestColumn();
			$columnaFinal++;
			for ($columna='A'; $columna != $columnaFinal;$columna++){				
				$encabezado[$cantidad]=$object->getActiveSheet()->getCell($columna."1")->getCalculatedValue();
				$oculto = strpos($encabezado[$cantidad], '//');
				if($oculto===false){
					$tipoPregunta[$cantidad] = 0;
					if(strtolower($encabezado[$cantidad])=='usuario'){
						$tipoPregunta[$cantidad] = 1;
					}
				}else{
					$tipoPregunta[$cantidad] = 1;
					$encabezado[$cantidad]= str_replace("//", "", $encabezado[$cantidad]);
				}
				$cantidad++;
			}		
			$depencencias=0;	
			for($i=1;$i<$cantidad;$i++){
				$parametro=0;
				$opciones=1;				
				$fila=2;	
				if($tipoPregunta[$i] == 0){ $esVisible='visible';}else{ $esVisible='oculta';};		
				echo '<div id="numeroPregunta'.$modulo.'_'.$pregunta.'" class="border-pregunta"><p class="margin"><input id="ordenP-'.$modulo.'_'.$pregunta.'" min="1" max="'.$pregunta.'" type="number" value="'.$pregunta.'" style="width: 3.5%;" name="ordenP-'.$modulo.'_'.$pregunta.'"> Pregunta</p><input type="text" class="form-control" name="nombrePregunta'.$modulo.'_'.$pregunta.'" id="nombrePregunta'.$modulo.'_'.$pregunta.'" placeholder="Texto de la pregunta" value="'.$encabezado[$i].'"><br><div><p class="margin"><i class="fa fa-dot-circle-o"></i> Pregunta Dependiente, '.$esVisible.'</p><div class="input-group"><span class="input-group-addon"><i class="fa fa-toggle-right"></i></span><select class="form-control"><option>Listado de Objetos</option></select></div>';
				while($parametro==0){
					if($object->getActiveSheet()->getCellByColumnAndRow($i,$fila)->getCalculatedValue()==NULL){
				 		$parametro=1;
				 		echo '<input type="hidden" name="cuentaOpciones'.$modulo.'_'.$pregunta.'" id="cuentaOpciones'.$modulo.'_'.$pregunta.'" value="'.($opciones-1).'">';
				 	}else{
				 		$valor=$object->getActiveSheet()->getCellByColumnAndRow($i,$fila)->getCalculatedValue();				 	
				 		echo '<input type="hidden" name="txt_elemento'.$modulo.'_'.$pregunta.'_'.$opciones.'" id="txt_elemento'.$modulo.'_'.$pregunta.'_'.$opciones.'" value="'.$valor.'">';
				 		$fila++;
				 		$opciones++;
				 	}					
				}
				if($depencencias==1){
					echo '<input type="hidden" name="txt_dependencia'.$modulo.'_'.$pregunta.'" id="txt_dependencia'.$modulo.'_'.$pregunta.'" value="'.$modulo.'_'.$pregunta.'/'.$modulo.'_'.($pregunta-1).'">';
				}
				$depencencias=1;
				echo '<input type="hidden" name="typePregunta'.$modulo.'_'.$pregunta.'" id="typePregunta'.$modulo.'_'.$pregunta.'" value="13">';
				echo '<div class="input-group"><p class="margin"><i class="fa fa-dot-circle-o"></i> Activo</p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" onclick="vigenciaPregunta('.$modulo.','.$pregunta.');" id="vigPregunta'.$modulo.'_'.$pregunta.'" name="vigPregunta'.$modulo.'_'.$pregunta.'" value="1" checked><span class="slider round"></span></label></span>';				
				if($tipoPregunta[$i] == 0){
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class="margin"><i class="fa fa-dot-circle-o"></i> Obligatorio</p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" onclick="obligatorioPregunta('.$modulo.','.$pregunta.');" id="oblPregunta'.$modulo.'_'.$pregunta.'" name="oblPregunta'.$modulo.'_'.$pregunta.'" value="1" checked><span class="slider round"></span></label></span>';
				}
				echo '<input type="hidden" name="esVisible'.$modulo.'_'.$pregunta.'" id="esVisible'.$modulo.'_'.$pregunta.'" value="'.$tipoPregunta[$i].'"> </div></div></div><br id="brPregunta'.$modulo.'_'.$pregunta.'">';
				$pregunta++;	
			}	
			echo '<script type="text/javascript">
				 	$("#cuentaPreguntas"+'.$modulo.').val('.($pregunta-1).');
				 	</script>';	
		}else{
			redirect(site_url("Adm_ModuloFormulario/crearFormulario"));
		}
	}

	function nuevoFormulario(){
		if(isset($_POST["tx_formulario"])){
			$validar=0;
		}else{
			$validar=$this->moduloFormulario->ValidarNombreFormulario($_SESSION["BDSecundaria"],$_POST["nombre_formu"])->existe;
		}		
		if($validar<=0){
			$BD=$_SESSION["BDSecundaria"];	
			if(isset($_POST["tx_formulario"])){	
				$idFormulario=$_POST["tx_formulario"];
			}else{
				$idFormulario=$this->moduloFormulario->IngresarNombreFormulario($BD,$_POST["nombre_formu"])->ID_Formulario;
			}
			for ($contmodulo=1; $contmodulo <= $_POST["cuentaModulos"]; $contmodulo++) {
				if(isset($_POST["vigModulo".$contmodulo])){$vigenciaM="1";}else{ $vigenciaM="0";};
				$idModulo=$this->moduloFormulario->IngresarModuloFormulario($BD,$_POST["txt_IDModulo".$contmodulo],$idFormulario,$_POST["nombreModulo".$contmodulo],$_POST["ordenM-".$contmodulo],$vigenciaM)->ID_FormularioModulo;
				for($contPregunta=1;$contPregunta <= $_POST["cuentaPreguntas".$contmodulo];$contPregunta++){
					$tipo=$_POST["typePregunta".$contmodulo."_".$contPregunta];
					$nombre=$_POST["nombrePregunta".$contmodulo."_".$contPregunta];
					if($tipo==6 || $tipo==14){
						$oblitario="0";
					}else{
						if(isset($_POST["oblPregunta".$contmodulo."_".$contPregunta])){$oblitario="1";}else{ $oblitario="0";};
					}					
					$restriccion=0;
					$orden=$_POST["ordenP-".$contmodulo."_".$contPregunta];
					if(isset($_POST["vigPregunta".$contmodulo."_".$contPregunta])){$vigencia="1";}else{ $vigencia="0";};
					if(isset($_POST["esVisible".$contmodulo."_".$contPregunta])){ $visible=$_POST["esVisible".$contmodulo."_".$contPregunta];}else{ $visible="1";};
					$idPregunta=$this->moduloFormulario->IngresarPreguntaFormulario($BD,$_POST["txt_IDPregunta".$contmodulo.'_'.$contPregunta],$idModulo,$idFormulario,$tipo,$nombre,$oblitario,$restriccion,$visible,$orden,$vigencia)->ID_FormularioPregunta;
					if($tipo==5 || $tipo==6 || $tipo==13){
						for ($contOpcion=1; $contOpcion <= $_POST["cuentaOpciones".$contmodulo."_".$contPregunta]; $contOpcion++) {
							$this->moduloFormulario->IngresarOpcionFormulario($BD,$_POST["txt_IDOpcion".$contmodulo.'_'.$contPregunta."_".$contOpcion],$idPregunta,$_POST["txt_elemento".$contmodulo.'_'.$contPregunta."_".$contOpcion],'1','1');
						}
					}elseif($tipo==7 || $tipo==14 || $tipo==15){
						$this->moduloFormulario->IngresarClustersFormulario($BD,$_POST["txt_IDElementos".$contmodulo.'_'.$contPregunta],$idPregunta,$_POST["txt_maestra".$contmodulo.'_'.$contPregunta],'1');
					}
				}				
			}
			$this->ingresarCodigoFormulario($idFormulario);
			echo "OP1";	
		}else{
			echo "OP2";	
		}
	}

	function cambiarEstadoFormulario(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["Formulario"])){
					$formulario=$_POST["Formulario"];
					$vigencia=$_POST["Estado"];
					echo "<form method='post' id='cambiarEstadoFormulario' action='cambiarEstadoFormularioFinal'>";
					if($vigencia==1){
						echo "<p>&#191;Esta Seguro que desea Desactivar el Formulario?</p>";						
					}else{
						echo "<p>&#191;Esta Seguro que desea Activar el Formulario?</p>";
					}
					echo "<input type='hidden' name='txt_formulario' value='".$formulario."'>";
					echo "<input type='hidden' name='txt_estado' value='".$vigencia."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloFormulario/adminFormulario"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function cambiarEstadoFormularioFinal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_formulario"])){				
					$formulario=$_POST["txt_formulario"];
					$vigencia=$_POST["txt_estado"];
					$BD=$_SESSION["BDSecundaria"];	
					$filas=$this->moduloFormulario->cambiarEstadoFormulario($BD,$formulario,$vigencia);
					if($vigencia=1){
						$var="desactivado";
					}else{
						$var="activado";
					}
					if($filas["CantidadInsertadas"]==0){
						$data['mensaje']='No se pudo realizar la operacion';
					}else{
						$data['mensaje']='Se ha '.$var.' correctamente';
					}
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Formularios"]=$this->moduloFormulario->ListarFormulario($BD);
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Cargo"] = $_SESSION["Cargo"];
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminFormularios',$data);
				   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloFormulario/adminFormulario"));
				}
			}
		}
	}	

	function ConfigFormulario(){
		$datos=$this->moduloFormulario->CantidadIntentosFormularios($_SESSION["BDSecundaria"],$_POST["form"]);
		$cantidad=$datos->Cantidad;
		if(isset($datos->observacion)){
			$obs=$datos->observacion;		
		}else{
			$obs="";
		}		
		if($cantidad==0){
			$unaVez=" checked ";
			$muchasVeces="";
			$estilo=" style='display:none' ";
		}else{
			$unaVez="";
			$muchasVeces=" checked ";
			$estilo=" style='display:inline' ";
		}		
		echo "<h6 style='text-align:center !important;'>Cantidad de Veces a Responder</h6>";
		echo "<form method='POST' id='FrmConfig' action='"; echo site_url(); echo "Adm_ModuloFormulario/AgregarConfiguracionFormu'><br>";
		echo "<div class='form-group'>
				<label for='company'>Mas de una vez</label>
				<div class='radio abc-radio abc-radio-danger radio-inline'>
                    <input type='radio' id='txt_metodo1' value='1' name='txt_metodo' ".$muchasVeces." onclick='cambiarCantidadFormulario(1)'>
                    <label for='txt_metodo1'>Si </label>
                </div>
                <div class='radio abc-radio abc-radio-danger radio-inline'>
                    <input type='radio' id='txt_metodo0' value='0' name='txt_metodo' ".$unaVez." onclick='cambiarCantidadFormulario(0)'>
                    <label for='txt_metodo0'>No </label>
                 </div>
			  </div>";

	  	echo "<div class='form-group' id='div_cant' ".$estilo.">
			<label for='company'>Cantidad de Veces al Dia</label>
	        <div class='input-group'>
				<span class='input-group-addon'><i class='mdi mdi-numeric'></i></span>
				<input type='text' name='txt_cantidad' id='txt_cantidad' class='form-control' value='".$cantidad."'>
			</div>
			</div>";
		echo "<div class='form-group'>
			<label for='company'>Observaciones</label>
	        <div class='input-group'>
				<span class='input-group-addon'><i class='fa fa-pencil-square-o'></i></span>
				<input type='text' name='txt_observaciones' id='txt_observaciones' class='form-control' value='".$obs."'>
			</div>";
		echo "<input type='hidden' name='tx_formu' value='".$_POST["form"]."'>";
		echo "</form>";
	}

	function AgregarConfiguracionFormu(){
		if(isset($_POST["tx_formu"])){
			if(isset($_POST["txt_cantidad"])){
				$cantidad=$_POST["txt_cantidad"];
			}else{
				$cantidad="0";
			}
			$this->moduloFormulario->AgregarCantidadFormu($_SESSION["BDSecundaria"],$_POST["tx_formu"],$cantidad,$_POST["txt_observaciones"]);
			$BD=$_SESSION["BDSecundaria"];		
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"] = $_SESSION["Perfil"];
			$data["Cliente"] = $_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Formularios"]=$this->moduloFormulario->ListarFormulario($BD);
			$data["Clientes"]= $this->funcion_login->elegirCliente();
			$data["Cargo"] = $_SESSION["Cargo"];
			$data['mensaje']='Formulario Configurado Con Exito.';
			$this->load->view('contenido');
			$this->load->view('layout/header',$data);
			$this->load->view('layout/sidebar',$data);
			$this->load->view('admin/adminFormularios',$data);
		   	$this->load->view('layout/footer',$data);
		}else{
			redirect(site_url("Adm_ModuloFormulario/adminFormulario"));
		}
	}

	function DependeciaFormularioPadre(){
		if(isset($_POST["form"])){
			$BD=$_SESSION["BDSecundaria"];
			$formu=$_POST["form"];
			$preguntas=$this->moduloFormulario->ListarFormularioPreguntaUsuario($BD,$formu);			
			echo '<div class="form-group">Debe escoger una pregunta padre, dicha pregunta padre va a generar la pregunta hija cuando esta sea respondida por el usuario en el formulario. <hr>';    
			$moduloActual="";
           	foreach ($preguntas as $p) {     
           		if($p["CantidadDependenciaPadre"]>0){
           			if($p["CantidadDependenciaHijo"]>0){
           				$icono="<div class='row icon-list-demo clearfix'><div class='col-sm-6 col-md-4 col-lg-3'><i class='fa fa-chain text-warning' title='Pregunta Padre e Hijo'></i></div></div>";
           			}else{
	           			$icono="<div class='row icon-list-demo clearfix'><div class='col-sm-6 col-md-4 col-lg-3'><i class='fa fa-chain text-success' title='Pregunta Padre Solamente'></i></div></div>";
           			}
           		}else{
           			if($p["CantidadDependenciaHijo"]>0){
           				$icono="<div class='row icon-list-demo clearfix'><div class='col-sm-6 col-md-4 col-lg-3'><i class='fa fa-chain text-info' title='Pregunta Hijo Solamente'></i></div></div>";
           			}else{
           				$icono="";
           			}
           		}
           		if($p["NombreModulo"]!=$moduloActual){
           			echo '<h6 class="text-theme" align="center">Modulo: '.$p["NombreModulo"].'</h6><hr>';
           			$moduloActual=$p["NombreModulo"];
           		}
           		echo '<div class="container">
						<div class="row">
							<span class="input-group-addon"><i class="mdi mdi-plex"></i></span>
							<div class="col-md-8">		                   	
		                   		<button type="button" class="btn btn-outline-theme sweet-8" onclick="dependeciasFormulariosH('.$formu.','.$p["ID_FormularioPregunta"].');">Pregunta: '.$p["NombrePregunta"].'</button>
		                   	</div>
		                   	<div class="col-md-2">		
		                   		'.$icono.'
		                   	</div>
	                 	</div>
	                </div>
                 	<hr>';
           	}
           	echo '</div>';
		}else{
			echo'';
		}
	}

	function DependeciaFormularioHijo(){
		if(isset($_POST["form"])){
			$BD=$_SESSION["BDSecundaria"];
			$formu=$_POST["form"];
			$pregunta=$_POST["preg"];
			$preguntas=$this->moduloFormulario->ListarFormularioPreguntaDepHijo($BD,$formu,$pregunta);
			echo "<form method='POST' id='FrmDependencias' action='"; echo site_url(); echo "Adm_ModuloFormulario/AgregarDependenciaFormulario'>";
			echo '<div class="form-group">Seleccionar preguntas Hijas.<br>Debe escoger las preguntas que est&aacuten dependiente de la pregunta anterior. Dichas preguntas se mantendr&aacuten ocultas hasta que este sea respondida. La pregunta puede tener una "respuesta esperada" para que esta sea respondible, en caso de que esto ocurra, solo podr&aacute aparecer si la respuesta ingresada por el usuario corresponde a la que se encuentra ingresada en este m&oacutedulo.<hr>';    
			echo '<input type="hidden" name="txt_pregPadre" id="txt_pregPadre" value="'.$pregunta.'">';
			$contador=0;
			$moduloActual="";
			foreach ($preguntas as $p) {
				if($p["NombreModulo"]!=$moduloActual){
           			echo '<h6 class="text-theme" align="center">Modulo: '.$p["NombreModulo"].'</h6><hr>';
           			$moduloActual=$p["NombreModulo"];
           		}
				echo '<div class="input-group">';				
				echo '<input type="hidden" name="txt_pregHijo'.$contador.'" id="txt_pregHijo'.$contador.'" value="'.$p["ID_FormularioPregunta"].'">';
				if(isset($p["Respuesta"])){
					$existe='checked value="1"';
					$respuesta=$p["Respuesta"];
					$estilo="";
				}else{
					$existe='value="0"';
					$respuesta="";
					$estilo='style="display:none;"';
				}
				echo '
				<div class="container">
					<div class="row">					
						<span class="input-group-addon">
							<i class="mdi mdi-plex"></i>
						</span>
						<div class="col-md-7">
							&nbsp;&nbsp;Pregunta: '.$p["NombrePregunta"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<div id="div_'.$p["ID_FormularioPregunta"].'" '.$estilo.'>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="text" class="form-control" id="r'.$p["ID_FormularioPregunta"].'" name="rDependencia'.$contador.'" placeholder="Respuesta Esperada" value="'.$respuesta.'" style="width:80%">
							</div>
						</div>
						<div class="col-md-2">
							<label class="switch">
								<input type="checkbox" onclick="cambiarDependencia('.$p["ID_FormularioPregunta"].');" id="'.$p["ID_FormularioPregunta"].'" name="pDependencia'.$contador.'" '.$existe.'>
								<span class="slider round"></span>
							</label>
						</div>						
					</div>
				</div>';
				echo '</div>
					<hr>';
				$contador++;
			}
			echo '<input type="hidden" name="tx_cantidadHijas" id="tx_cantidadHijas" value="'.$contador.'">';
			echo "</div></form>";
		}else{
			echo'';
		}
	}

	function AgregarDependenciaFormulario(){
		if(isset($_POST["tx_cantidadHijas"])){
			$BD=$_SESSION["BDSecundaria"];
			$cantidad=$_POST["tx_cantidadHijas"];			
			$padre=$_POST["txt_pregPadre"];
			$this->moduloFormulario->DesactivarFormularioDependencia($BD,$padre);
			for($i=0; $i<$cantidad; $i++) { 
				if(isset($_POST["pDependencia".$i])){
					$hijo=$_POST["txt_pregHijo".$i];
					$resultado=$_POST["rDependencia".$i];
					$this->moduloFormulario->IngresarFormularioDependencias($BD,$padre,$hijo,$resultado);
				}
			}
			$BD=$_SESSION["BDSecundaria"];		
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"] = $_SESSION["Perfil"];
			$data["Cliente"] = $_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Formularios"]=$this->moduloFormulario->ListarFormulario($BD);
			$data["Clientes"]= $this->funcion_login->elegirCliente();
			$data["Cargo"] = $_SESSION["Cargo"];
			$data['mensaje']='Dependencias Agregadas Con &Eacutexito';
			$this->load->view('contenido');
			$this->load->view('layout/header',$data);
			$this->load->view('layout/sidebar',$data);
			$this->load->view('admin/adminFormularios',$data);
		   	$this->load->view('layout/footer',$data);
		}else{
			redirect(site_url("Adm_ModuloFormulario/adminFormulario"));
		}
	}

	function ingresarCodigoFormulario($form){				
		$BD=$_SESSION["BDSecundaria"];
    	$contador=0; 
		$formulario=$form;
		$this->load->model("moduloFormularioApp");
		$local=0;
		$formularioPrincipal=$this->moduloFormularioApp->ListarFormularioUsuario($BD,$formulario);
		$formu='<form class="form-horizontal" id="Formulario" enctype="multipart/form-data">
				<div class="box border-modulo collapsed"  style="background-image: url(../../assets/imgs/fondoFormulario.jpg); Mborder-bottom-right-radius: 25px 25px; border-bottom-left-radius: 25px 25px; text-align:center; border-top-left-radius: 40px 40px; border-top-right-radius: 40px 40px; !important;">
					<br>
					<div style="text-align:center; !important">
						<div class="header-icon" style="padding-left:5%" >
			              	<div class="u-img">
				                <img alt="user" src="../../';
				                  if(isset($info['logo'])){
				                    $formu.=$info['logo'];
				                  }else{
				                    $formu.='assets/archivos/foto_trabajador/default.png';
				                  }
				                   $formu.='">
			              	</div>
			              	<h4 class="text-theme">'.$formularioPrincipal["NombreFormulario"].'</h4>
			            </div>
						<input type="hidden" name="tx_formulario" value="'.$formularioPrincipal["ID_Formulario"].'"  [(ngModel)]="formu.tx_formulario">
				        <input type="hidden" name="txt_id_asignacion" value="" [(ngModel)]="formu.txt_id_asignacion">
				        <input type="hidden" name="txt_local" id="txt_local" value="" [(ngModel)]="formu.txt_local">
				        <input type="hidden" name="f_latitud" id="f_latitud" value="" [(ngModel)]="formu.latitud">
				        <input type="hidden" name="f_longitud" id="f_longitud" value="" [(ngModel)]="formu.longitud">
					</div>	
					<br>';	
    	$formularioModulos=$this->moduloFormularioApp->ListarFormularioModuloUsuario($BD,$formularioPrincipal["ID_Formulario"]);
    	foreach ($formularioModulos as $fm) {
	    	$formu.='<div class="card card-accent-theme" style=" background-color: #ffffffb5; text-align:center;border-bottom-right-radius: 5px 5px; border-bottom-left-radius: 5px 5px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px; !important">';
	    	$formu.='<br><h5 class="text-theme"><a data-toggle="collapse" style="text-decoration:none;color:#f13e46 " class="text-default" href="#'.$fm["ID_FormularioModulo"].'" aria-expanded="true" aria-controls="collapseOne">'.$fm["NombreModulo"].'</a></h5>
	    			<div id="'.$fm["ID_FormularioModulo"].'" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
	    			<br><br>';
	    	$formularioPregunta=$this->moduloFormularioApp->ListarFormularioPreguntaUsuario($BD,$fm["ID_FormularioModulo"]);
	    	foreach ($formularioPregunta as $fp) {
			    $dependecias="";
			    $tempoDep=$this->moduloFormularioApp->ListarFormularioDependenciasPorPadre($BD,$fp["ID_FormularioPregunta"]);
			    if($tempoDep==""){
			        $onchange="";
			        $onradio="";
			    }else{
		            $onchangeCRa='(change)="depCR'.$contador.'('.$contador.')'.$contador.'" ;dep'.$contador.'('.$contador.')"'.$contador.'"';
		            $onchangeCCb='(change)="depCC'.$contador.'('.$contador.')"'.$contador.'"';
		            $onchange='(change)="dep'.$contador.'('.$contador.')"'.$contador.'"';
		            $onchangeLL='(change)="depLL'.$contador.'('.$contador.')"'.$contador.'"';
		            $onchangeSL='(change)="dep'.$contador.''.$contador.'"';
		            $onchangeL='(change)="depL'.$contador.'('.$contador.')"'.$contador.'"';
		            $onchangeLC='(change)="depLC'.$contador.'('.$contador.')'.$contador.'" ;dep'.$contador.'('.$contador.')"'.$contador.'"';
		            $onradioS='(change)="dep'.$contador.'(1)"1"';
		            $onradioN='(change)="dep'.$contador.'(0)"0" ';
		        }
	    		if($fp["esObligatorio"]==1){
	    			$simbolo='<label style="color:red">&nbsp;*</label>';
	                      $formu.='<input type="hidden" name="O'.$contador.'" id="O'.$contador.'" value="1">';
	                $requerido=" required ";
	    		}else{
	    			$formu.='<input type="hidden" name="O'.$contador.'" id="O'.$contador.'" value="0">';
		                      $simbolo="";
		            $requerido="";
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
	    		$formu.='<div class="border-pregunta" style="text-align:center; border-bottom-right-radius: 10px 10px; border-bottom-left-radius: 10px 10px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px; !important '.$Hijo.'" id="m'.$fp["ID_FormularioPregunta"].'">';
	    		$formu.='<div class="form-group">';
	    		$formu.='<h6 class="text-theme">'.$fp["NombrePregunta"].' '.$simbolo.'</h6>';
	    		$formu.='<div class="input-group">';
	    		if($fp["Tipo"]=="1"){ // Texto Corto           			
	    			$formu.='<input type="text" class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.' '.$requerido.'>';
	    		}
	    		if($fp["Tipo"]=="2"){ // Comentarios            			
	    			$formu.='<textarea type="textarea" class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.' '.$requerido.'></textarea>';
	    		}
	    		if($fp["Tipo"]=="3"){ // Numeros            			
	    			$formu.='<input type="number" class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.' '.$requerido.'>';
	    		}
	    		if($fp["Tipo"]=="4"){  // Fecha           			
	    			$formu.='<input type="date" class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.' '.$requerido.'>';
	    		}
	    		if($fp["Tipo"]=="5"){ // Opción Multiple(Una Selección)    			
	    			$pOpcion1=$this->moduloFormularioApp->ListarFormularioOpcionUsuario($BD,$fp["ID_FormularioPregunta"]);
	          		$formu.='<select class="form-control " id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.' '.$requerido.'>';
	          		$formu.='<option value="">Elegir una opcion</option>';
		          	foreach($pOpcion1 as $p){                                   
		            	$formu.='<option value="'.$p["ID_FormularioOpcion"].'">'.$p["NombreOpcion"].'</option>';
		          	}   
		          	$formu.='</select>';
	    		}
    			if($fp["Tipo"]=="6"){ // Opción Multiple(Muchas Elecciones)        			
    				$pOpcion2=$this->moduloFormularioApp->ListarFormularioOpcionUsuario($BD,$fp["ID_FormularioPregunta"]);
			        $chkb = 0;
			        $formu.='</div>
                   <div class="input-group-vertical" style="padding-right: 50%;">';
		            foreach($pOpcion2 as $p){
		              	$formu.='<div class="checkbox abc-checkbox-danger abc-checkbox ">
		                        <input type="checkbox" id="cb-'.$chkb.$contador.'" name="cb-'.$contador.'-'.$chkb.'" '.$onchange.' value="'.$p["ID_FormularioOpcion"].'">
		                        <label for="cb-'.$chkb.$contador.'">'.$p["NombreOpcion"].'</label>
		                       </div>';
		              	$chkb++;
		            }
		            $formu.='<input type="hidden" name="cantOpcion_'.$contador.'" value="'.$chkb.'">';
		            $formu.='</div>
		                    <div>';                                                    
	    		}
    			if($fp["Tipo"]=="7"){ // Lista Maestra(Una Selección)           			
    				$pCluster=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementos($BD,$fp["ID_FormularioPregunta"],$local);
		          	$pClusterc=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementosCategoria($BD,$fp["ID_FormularioPregunta"],$local);
		          	$rbtn=0;
		          	$formu.='<div class="col-md-12"><h6 class="text-theme"><small>Categoria</small></h6>';
		          	$formu.='<select class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" style="width: 100%;" '.$onchangeCRa.' '.$requerido.'>';
            		$formu.='<option value="">Elegir una Categoria</option>';
		            foreach($pClusterc as $p){                                   
		                $formu.='<option value="'.str_replace(' ', '', $p["Categoria"]).'">'.$p["Categoria"].'</option>';
		            }   
		            $formu.='</select>';
		            $formu.='<div class="input-group-vertical"><br><hr>';
 			   		foreach($pCluster as $c){
 				  		$formu.=' <div class="radio abc-radio abc-radio-danger radio-inline pull-left" id="r'.$rbtn.$contador.'-'.str_replace(' ', '', $c["Categoria"]).'" style="display:none;" >
	                        <input type="radio" name="p'.$contador.'" id="radio-'.$rbtn.$contador.'" '.$onchange.' value="'.$c["ID_Elemento"].'" '.$requerido.'>
	                        <label style="font-size: 9px; text-align:left;" for="radio-'.$rbtn.$contador.'">'.$c["Nombre"].'</label>
                		</div>';
          				$rbtn++;
			    	}            			
          			$formu.='</div></div>';
    			}
	    		if($fp["Tipo"]=="8"){ // Foto          			
	    			$formu.='<input type="file" class="btn btn-outline-theme dropify" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.' '.$requerido.' >';
	    		}
	    		if($fp["Tipo"]=="9"){ // si/no          			
	    			$formu.='<div class="radio abc-radio abc-radio-danger radio-inline">
	                          <input type="radio" id="'.$fp["ID_FormularioPregunta"].'1" value="1" name="p'.$contador.'" '.$onradioS.' '.$requerido.'>
	                          <label for="'.$fp["ID_FormularioPregunta"].'1">Si </label>
	                      </div>
	                      <div class="radio abc-radio abc-radio-danger radio-inline">
	                          <input type="radio" id="'.$fp["ID_FormularioPregunta"].'0" value="0" name="p'.$contador.'" '.$onradioN.'">
	                          <label for="'.$fp["ID_FormularioPregunta"].'0"> No </label>
	                       </div>';
	    		}
	    		if($fp["Tipo"]=="10"){ // RUT           			
	    			$formu.='<input type="text" class="form-control" placeholder="12.345.567-9" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" onfocus="return validaRut(event)" '.$onchange.' '.$requerido.'>';
	    		}
	    		if($fp["Tipo"]=="11"){  //codigo QR          			
	    			$formu.='<input type="file" accept="image/*"  type="file" class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.' capture '.$requerido.'>';
	    		}
	    		if($fp["Tipo"]=="12"){ // Email           			
	    			$formu.='<input type="text" class="form-control" placeholder="correo@dominio.com" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" onfocus="return validarEmail(event)" '.$onchange.' '.$requerido.'>';
    			}
		        if($fp["Tipo"]=="13"){ // Pregunta Dependiente                        
	              	$pOpcion1=$this->moduloFormularioApp->ListarFormularioOpcionUsuario($BD,$fp["ID_FormularioPregunta"]);
	              	$formu.='<select class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" name="p'.$contador.'" '.$onchange.' '.$requerido.'>';
	              	$formu.='<option value="">Elegir una opcion</option>';
	              	foreach($pOpcion1 as $p){                                   
	                    $formu.='<option value="'.$p["ID_FormularioOpcion"].'">'.$p["NombreOpcion"].'</option>';                                    
	              	}	   
	              	$formu.='</select>';
		        }    
		        if($fp["Tipo"]=="14"){ // Lista Maestra(Muchas Elecciones)                   
		          	$pClusterc=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementosCategoria($BD,$fp["ID_FormularioPregunta"],$local);
		          	$CantPreg=0;
		          	$formu.='<div class="col-md-12"><h6 class="text-theme"><small>Categoria</small></h6>';
		          	$formu.='<input type="hidden" name="idp" id="idpp" value="'.$fp["ID_FormularioPregunta"].'">';
		          	$formu.='<input type="hidden" name="icont" id="icont" value="'.$contador.'">';
		          	$formu.='<select class="form-control" id="i'.$fp["ID_FormularioPregunta"].'" style="width: 100%;" '.$onchangeCCb.' >';
		          	$formu.='<option value="">Elegir una Categoria</option>';
		          	foreach($pClusterc as $p){                                   
		            	$formu.='<option value="'.str_replace(' ', '', $p["Categoria"]).'">'.$p["Categoria"].'</option>';                                    
		          	}   
          			$formu.='</select><br>';
          			$formu.='<div class="input-group-vertical" id="CheckML-'.$fp["ID_FormularioPregunta"].'"><hr>';
          			$chkb = 1;
          			if($responde==1){
            			$preguntaDepHijo1='';
            			$preguntaDepHijo3='';
            			$preguntaDepHijo8='';
            			$dependencia=$this->moduloFormularioApp->FormularioDependenciasPorHijo($BD,$fp["ID_FormularioPregunta"],$local);                                                   
          			}
          			$formu.='<div id="actLoc">';
          			$pOpcion1=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementos($BD,$fp["ID_FormularioPregunta"],$local);                        
          			foreach($pOpcion1 as $p){                          
            			$formu.='<div class="checkbox abc-checkbox-danger abc-checkbox " id="'.$chkb.$contador.'-'.str_replace(' ', '', $p["Categoria"]).'" style="display:none;" >
                     		<input type="checkbox" name="cb-'.$contador.'-'.$chkb.'" id="cbb-'.$chkb.$contador.'" value="'.$p["ID_Elemento"].'" '.$onchangeSL.'('.$chkb.$contador.')" >
                     		<label for="cbb-'.$chkb.$contador.'" style="width: 100%; font-size: 9px; text-align:left;" ><strong>'.$p["Nombre"].'</strong></label>';
            			if ($responde==1) {
              				$formu.='<div style="display:none;align:center;" id="div-'.$chkb.$contador.'" >';
              				$formu.='<input type="hidden" id="di-'.$chkb.'" value="div-'.$chkb.'">';
              				$CantPreg=0;
              				foreach ($dependencia as $c) {                              
				                if($c["Tipo"]=="1"){ // Texto Corto                
				                 	$preguntaDepHijo1.='<div class="input-prepend input-group">
				                        <span class="input-group-addon">'.$c["NombrePregunta"].'</span>
				                          <input type="text" class="form-control" id="itc'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'" '.$onchange.'>
				                      </div>';
				                }                            
				                if($c["Tipo"]=="3"){ // Numeros                  
				                  	$preguntaDepHijo3='<label>'.$c["NombrePregunta"].'</label>
				                		<input type="number" class="form-control" id="in'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'" style="width: 100%;" '.$onchange.'>';
				                }
				                if($c["Tipo"]=="5"){
				                  	$pOpcion1=$this->moduloFormularioApp->ListarFormularioOpcionUsuario($BD,$c["ID_FormularioPregunta"]);
				                  	$formu.='<select class="form-control " id="i'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'" '.$onchange.' style="width: 100%;">';
				                  	$formu.='<option value="">Elegir una opcion</option>';
				                  	foreach($pOpcion1 as $p){                                   
					                    $formu.='<option value="'.$p["ID_FormularioOpcion"].'">'.$p["NombreOpcion"].'</option>';
				                  	}   
				                  	$formu.='</select>';
				                }
				                if($c["Tipo"]=="8"){ // Foto               
				                  	$preguntaDepHijo8='<div class="input-prepend input-group">
				                        <span class="input-group-addon">'.$c["NombrePregunta"].'</span>
				                        <input type="file" style="width: 50%;" class="btn btn-outline-theme" id="if'.$c["ID_FormularioPregunta"].'" name="p'.$contador.'-'.$chkb.'-'.$CantPreg.'" '.$onchange.'>
				                    </div>';
				                }     
                  				$CantPreg++;                         
              				}  
              				if($preguntaDepHijo1!=""){ // Texto Corto                
                				$formu.=$preguntaDepHijo1.'<hr>';
              				}
              				if($preguntaDepHijo3!=""){ // Numeros                
				                $formu.=$preguntaDepHijo3.'<hr>';
			              	}
			              	if($preguntaDepHijo8!=""){ // Foto               
			                	$formu.=$preguntaDepHijo8.'<hr>';
			              	}    
			              	$formu.='</div>';
			            }      
				        $chkb++;        
				        $formu.='</div>';
				    }              
      				$formu.='<input type="hidden" name="cantOpcion_'.$contador.'" value="'.$chkb.'">';   
      				$formu.='<input type="hidden" name="cantPreg_'.$contador.'" value="'.$CantPreg.'">'; 
      				$formu.='</div>';
      				$formu.='</div>
           				 </div>';    
    			} 
				if($fp["Tipo"]=="15"){ // Lista Maestra(Muchas Elecciones)
		          	// fILTRO prO rEGIONES 
		          	$pOpcion1=$this->moduloFormularioApp->ListarFormularioPreguntaClousterLocales($BD,$fp["ID_FormularioPregunta"]);
		         	if (!isset($pOpcion1["Region"]) ) {
		            	$pOpcionR=$this->moduloFormularioApp->ListarFormularioPreguntaClousterLocalesRegion($BD,$fp["ID_FormularioPregunta"]);
		            	$formu.='<div class="row"><div class="col-md-12">';
			            $formu.='<input type="hidden" name="idp" id="idp" value="'.$fp["ID_FormularioPregunta"].'">	';
		            	$formu.='<select class="form-control" id="iclR'.$fp["ID_FormularioPregunta"].'" style="width: 100%;" name="p'.$contador.'" '.$onchangeLL.' >';
		            	$formu.='<option value="">Elegir una opcion</option>';
            			if (isset($pOpcionR)) {
              				foreach($pOpcionR as $p){                                   
                  				$formu.='<option value="'.$p["Region"].'">'.$p["Region"].'</option>';                    
              				}
            			}else{
              				$formu.='<option value="">No existe Categoria por Region</option>';
            			}
               			$formu.='</select><br>';
			          	// FILTRO POR Comuna
			            $formu.='<select class="" id="iclC'.$fp["ID_FormularioPregunta"].'" style="display:none;" name="p'.$contador.'" '.$onchangeL.'>';
			            $formu.='<option value="">Elegir una opcion</option>';   
			            $formu.='</select><br>';
			            // local
			            $formu.='<select class="" id="iclL'.$fp["ID_FormularioPregunta"].'" style="display:none;" name="p'.$contador.'" '.$onchangeLC.'>';
			            $formu.='<option value="">Elegir una opcion</option>';   
			            $formu.='</select>';
			        } else if(!isset($pOpcion1["Zona"])){
			            $formu.='<h6 class="text-theme"> zona con datos pero region y/o cadena vacio</h6>';
			        } else if(!isset($pOpcion1["NombreCadena"])){
			            $formu.='<h6 class="text-theme"> Cadenas con datos pero region y/o zona vacios</h6>';
			        }
	          		$formu.='</div></div>';
	        	}    
    			if($onchange!=""){
		          	$formu.='<script type="text/javascript">$(".select-'.$contador.'").select2({});
		            function depLC'.$contador.'(num){';
		            if($fp["Tipo"]=="15"){
		              $formu.=' var lc = $("#iclL'.$fp["ID_FormularioPregunta"].'").val();
		                        var cont = $("#icont").val();
		                        var idp = $("#idpp").val();
		                        $("#txt_local").val(lc);
		                        $.ajax({
		                            url: "'; $formu.= site_url(); $formu.='App_ModuloFormularios/CambiarElementoLocal",
		                            type: "POST",
		                            data: "lc="+lc+"&cont="+cont+"&idp="+idp,
		                            success: function(data) {
		                              $("1#actLoc").html("");                            
		                              $("1#actLoc").html(data);                            
		                            }
		                          });';                            
        			}
				    $formu.='} // fin funcion deplc
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
		             function depCC'.$contador.'(num){';
		            if($fp["Tipo"]=="14"){
		              	$formu.=' var formu = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
		              	$pOpcion1=$this->moduloFormularioApp->ListarFormularioPreguntaClousterElementos($BD,$fp["ID_FormularioPregunta"],$local);
		              	$chkbc=1;
		              	foreach($pOpcion1 as $p){
			                $formu.='$("#'.$chkbc.$contador.'-'.str_replace(' ', '', $p["Categoria"]).'").attr("style","display:none;");';
			                $formu.='$("#'.$chkbc.$contador.'-"+formu   ).removeAttr("style");';
			                $chkbc++;                                      
		              	}                                                                        
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
	                	$formu.=' var reg = $("#iclR'.$fp["ID_FormularioPregunta"].'").val();
	                          var com = $("#iclC'.$fp["ID_FormularioPregunta"].'").val();
	                          var idp = $("#idp").val();
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
	                  function dep'.$contador.'(num){';
	                if($fp["Tipo"]=="15"){
	                    $formu.=' var formu'.$contador.' = $("#iclR'.$fp["ID_FormularioPregunta"].'").val();';                                  
                  	}else if($fp["Tipo"]=="9"){
                    	$formu.=' var formu'.$contador.' = $("#'.$fp["ID_FormularioPregunta"].'"+num).val();';            
                  	}else if($fp["Tipo"]=="14"){
                    	$formu.=' $("#div-"+num).removeAttr("style");';
                    	$formu.=' var formu = $("#cbb-"+num).val();';                                  
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
                        $formu.=' var formu'.$contador.' = $("#cb-'.$fp["ID_FormularioPregunta"].'").val();';
                  	}else if($fp["Tipo"]=="5"){
                        $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
                  	}else if($fp["Tipo"]=="4"){
                        $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
                  	}else if($fp["Tipo"]=="3"){
                        $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
                  	}else if($fp["Tipo"]=="2"){
                        $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
                  	}else if($fp["Tipo"]=="1"){
                        $formu.=' var formu'.$contador.' = $("#i'.$fp["ID_FormularioPregunta"].'").val();';
                  	}    
	                foreach ($tempoDep as $t) {
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
	                    }else{
	                      $esperada=$t["RespuestaEsperada"];                                          
	                    }
	                    if(isset($esperada) && $esperada!=""){
	                      	$formu.=' if('.$esperada.'==formu'.$contador.'){
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
	                            }else{
	                              $("#i'.$t["FK_FormulariosPreguntas_ID_PreguntaHijo"].'").val("");  
	                            }
	                          }';
	                    }
	                }
              		$formu.='}
              		</script>';
              	}else{
                	$formu.=' var formu'.$contador.' = $("#'.$fp["ID_FormularioPregunta"].'"+num).val();';
              	}                                                         
	    		$formu.='</div>';
	    		$formu.='</div>';
	    		$formu.='</div>';
	    		$formu.='<br id="br'.$fp["ID_FormularioPregunta"].'" style="'.$Hijo.'">';
	            $contador++;
      		}                        
        	$formu.='</div>';
        	$formu.='</div>';   
    	}	                   
        $formu.='</div>';
        $formu.='<input type="hidden" name="txt_contador" id="txt_contador" value="'.$contador.'">';  
  		$formu.='</form>';		
  		$formularioFinal=str_replace('"', "'", $formulario);
  	    $this->moduloFormulario->GenerarCodigoFormulario($BD,$formularioFinal,$formu);
	}

	function cambiarEstadoFormularioEspecial(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["Formulario"])){
					$formulario=$_POST["Formulario"];
					$vigencia=$_POST["Estado"];
					echo "<form method='post' id='cambiarEstadoFormulario' action='cambiarEstadoFormularioEspecialFinal'>";
					if($vigencia==1){
						echo "<p>&#191;Esta Seguro que desea Desactivar el Formulario Especial?</p>";						
					}else{
						echo "<p>&#191;Esta Seguro que desea Activar el Formulario Especial?</p>";
					}
					echo "<input type='hidden' name='txt_formulario' value='".$formulario."'>";
					echo "<input type='hidden' name='txt_estado' value='".$vigencia."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloFormulario/adminFormularioEspeciales"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function cambiarEstadoFormularioEspecialFinal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_formulario"])){				
					$formulario=$_POST["txt_formulario"];
					$vigencia=$_POST["txt_estado"];
					$BD=$_SESSION["BDSecundaria"];	
					$filas=$this->moduloFormulario->cambiarEstadoFormularioEspecial($BD,$formulario,$vigencia);
					if($vigencia=1){
						$var="desactivado";
					}else{
						$var="activado";
					}
					if($filas["CantidadInsertadas"]==0){
						$data['mensaje']='No se pudo realizar la operacion';
					}else{
						$data['mensaje']='Se ha '.$var.' correctamente';
					}
					$this->load->model("ModuloPuntosVentas");
					$BD=$_SESSION["BDSecundaria"];		
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Formularios"] = $this->moduloFormulario->ListarFormulariosEspeciales($_SESSION["BDSecundaria"]);
					$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
					$data["Cargo"] = $_SESSION["Cargo"];
					$data['mensaje']='';
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminFormulariosEspeciales',$data);
			   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloFormulario/adminFormularioEspeciales"));
				}
			}
		}
	}	

	function asignarFormularioEspecialGrupoLocales(){		
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_grupo"])){	
					$this->moduloFormulario->asignarFormularioEspecialGrupoLocales($_SESSION["BDSecundaria"],$_POST["txt_formu"],$_POST["txt_grupo"]);
					redirect(site_url("Adm_ModuloFormulario/adminFormularioEspeciales"));
				}
			}
		}
	}

	function buscarFormulariosDuplicar(){
		$this->load->model("moduloTarea");
		$formularios=$this->moduloTarea->cargarFormularios($_POST["cliente"]);
	    if($formularios[0]!='') {          
	        foreach ($formularios as $f) {
	          echo "<option value='".$f["ID_Formulario"]."' >".$f["NombreFormulario"]."</option>";
	        }
      }else{
        echo "";
      }
	}

	function limpiaEspacio($var){
    	$patron = "/[' ']/i";
		$cadena_nueva = preg_replace($patron,"",$var);
		return $cadena_nueva; 
 	}

 	function DuplicarFormulario(){
		if(isset($_POST["lb_formulario"])){	
			$formularioAntiguo=$_POST["lb_formulario"];
			$nombre=$_POST["txt_nuevonombre"];
			$cliente=$_POST["lb_cliente"];
			$BD=$_SESSION["BDSecundaria"];				
			$formularioNuevo=$this->moduloFormulario->IngresarNombreFormulario($BD,$nombre)->ID_Formulario;
			$formularioModulosOriginal=$this->moduloFormulario->ListarFormularioModuloEditar($cliente,$formularioAntiguo);
			foreach ($formularioModulosOriginal as $fmo) {
				$idModuloNuevo=$this->moduloFormulario->IngresarModuloFormulario($BD,'000',$formularioNuevo,$fmo["NombreModulo"],$fmo["Orden"],$fmo["Activo"])->ID_FormularioModulo;
				$formularioPreguntasOriginal=$this->moduloFormulario->ListarFormularioPreguntaEditar($cliente,$fmo["ID_FormularioModulo"]);
				foreach ($formularioPreguntasOriginal as $fpo) {
					$idPreguntaNuevo=$this->moduloFormulario->IngresarPreguntaFormulario($BD,'000',$idModuloNuevo,$formularioNuevo,$fpo["Tipo"],$fpo["NombrePregunta"],$fpo["esObligatorio"],$fpo["esRestriccion"],"1",$fpo["Orden"],$fpo["Activo"])->ID_FormularioPregunta;
					if($fpo["Tipo"]==5 || $fpo["Tipo"]==6){  
						$formularioOpcionesOriginal=$this->moduloFormulario->ListarFormularioOpcionEditar($cliente,$fpo["ID_FormularioPregunta"]);
						foreach ($formularioOpcionesOriginal as $foo){
							$this->moduloFormulario->IngresarOpcionFormulario($BD,'000',$idPreguntaNuevo,$foo["NombreOpcion"],$foo["Activo"],$foo["Orden"]);
						}
					}
				}
			}
			$BD=$_SESSION["BDSecundaria"];		
			$data["Usuario"]=$_SESSION["Usuario"];					
			$data["Nombre"]=$_SESSION["Nombre"];
			$data["Perfil"] = $_SESSION["Perfil"];
			$data["Cliente"] = $_SESSION["Cliente"];
			$data["NombreCliente"]=$_SESSION["NombreCliente"];
			$data["Formularios"]=$this->moduloFormulario->ListarFormulario($BD);
			$data["Clientes"]= $this->funcion_login->elegirCliente();
			$data["Cargo"] = $_SESSION["Cargo"];
			$mens['tipo'] = 65;
			$this->load->view('contenido');
			$this->load->view('layout/header',$data);
   			$this->load->view('layout/sidebar',$data);
   			$this->load->view('admin/adminFormularios',$data);
		   	$this->load->view('layout/footer',$data);
		   	$this->load->view('layout/mensajes',$mens);
		}else{
			redirect(site_url("Adm_ModuloFormulario/adminFormulario"));
		}
	}
}