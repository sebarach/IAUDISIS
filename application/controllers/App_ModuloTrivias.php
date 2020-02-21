<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class App_ModuloTrivias extends CI_Controller {

	public function __construct(){
		parent::__construct(); 	
		$this->load->model("ModuloJornadas");
		$this->load->model("ModuloDocumento");
		$this->load->model("ModuloUsuarioApp");
		$this->load->model("ModuloTrivia");
	    $this->load->library('upload');
	}

	function verQuiz(){
		if(isset($_SESSION["BDSecundaria"])){
  			if($_SESSION['Perfil']==3){ 
  				$resp="";
				$data["Usuario"]=$_SESSION["Usuario"];					
  				$data["Nombre"]=$_SESSION["Nombre"];
  				$data["Perfil"]=$_SESSION["Perfil"];
  				$data["Cargo"]=$_SESSION["Cargo"];
  				$idAsignacion=$_POST["txt_id_asignacion"];
  				$idLocal=$_POST["txt_local"];
  				$idQuiz=$_POST["txt_id_quiz"];
  				$idUser=$_SESSION["Usuario"];
  				$BD=$_SESSION["BDSecundaria"];
  				$msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);		
	  			$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
	  			$data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
	  			$data["cantidadMsj"]=count($data["mensaje"]);
	  			$data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
	  			$data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
	  			$datosQuiz=$this->ModuloUsuarioApp->buscarQuizID($BD,$idQuiz);
	  			$nModulos=count($datosQuiz);
	  			for ($i=0; $i < $nModulos; $i++) {
	  				$faciles[$i]=$this->ModuloTrivia->listarPreguntasAleatorias($datosQuiz[$i]["Baja"],0,$BD);
	  				$medias[$i]=$this->ModuloTrivia->listarPreguntasAleatorias($datosQuiz[$i]["Media"],1,$BD);
	  				$dificiles[$i]=$this->ModuloTrivia->listarPreguntasAleatorias($datosQuiz[$i]["Alta"],2,$BD);
	  			}
  				$contador=1;
				$contadorModulo=1;
				$contadorPreguntas=1;
  				
  					$quiz= '<form id="frmQuiz" method="POST">';
						for ($i=0; $i < $nModulos; $i++) {
							$quiz.='<div class="col-md-12">
  									<div class="card border-danger text-danger mb-3"> 									
  										<div class="card-header">
				                            <h1>'.$datosQuiz[$i]["Nombre_Modulo_Trivia"].'</h1>
				                        </div>
				                        <div class="card-body">
				                            <div class="row">
				                                <div class="col-md-12">
				                                	<p class="margin"><i class="fa fa-dot-circle-o"></i> Respuestas</p>';
				                                	for ($j=0; $j < $datosQuiz[$i]["Baja"]; $j++) { 
				                                		$quiz.='<h6 class="modal-title">'.$contadorPreguntas.'.- '.$faciles[$i][$j]["TituloPregunta"].'</h6>';
				                                		if ($faciles[$i][$j]["Archivo"]!=null) {
				                                			$quiz.='<audio controls>
																	  <source src="'.site_url();$quiz.='archivos/audio/'.$faciles[$i][$j]["Archivo"].'';$quiz.='"> type="audio/mp3">
																	Your browser does not support the audio element.
																	</audio>';
				                                		}
				                                		$opciones=$this->ModuloTrivia->listarOpcionesTrivia($faciles[$i][$j]["ID_TriviaPregunta"],$BD);
					                                	foreach ($opciones as $op) {
					                                		$quiz.='<div class="col-md-2">
				                                                        <div class="radio abc-radio abc-radio-danger radio-inline">
			                                                            <input type="radio" id="inlineRadio'.$contador.'" name="radioInline'.$contadorModulo.'" value="'.$op["ID_TriviaOpciones"].'" required>
			                                                            <label for="inlineRadio'.$contador.'"> '.$op["NombreOpcion"].' </label>
			                                                            <input type="hidden" id="txt_id_pregunta'.$contadorPreguntas.'" name="txt_id_pregunta'.$contadorPreguntas.'" value="'.$faciles[$i][$j]["ID_TriviaPregunta"].'">			 
			                                                        </div>
			                                                    </div>';
			                                                $contador++;
					                                	}
					                                	$quiz.='<input type="hidden" id="txt_id_modulo'.$contadorPreguntas.'" name="txt_id_modulo'.$contadorPreguntas.'" value="'.$datosQuiz[$i]["ID_Modulo_Trivia"].'">';
					                                	$contadorModulo++;
					                                	$contadorPreguntas++;
					                                }
					                                for ($k=0; $k < $datosQuiz[$i]["Media"]; $k++) { 
				                                		$quiz.='<h6 class="modal-title">'.$contadorPreguntas.'.- '.$medias[$i][$k]["TituloPregunta"].'</h6>';
				                                		if ($medias[$i][$k]["Archivo"]!=null) {
				                                			$quiz.='<audio controls>
																	  <source src="'.site_url();$quiz.='archivos/audio/'.$medias[$i][$k]["Archivo"].'';$quiz.='"> type="audio/mp3">
																	Your browser does not support the audio element.
																	</audio>';
				                                		}
				                                		$opciones=$this->ModuloTrivia->listarOpcionesTrivia($medias[$i][$k]["ID_TriviaPregunta"],$BD);
				                                	foreach ($opciones as $op) {
				                                		$quiz.='<div class="col-md-2">
			                                                        <div class="radio abc-radio abc-radio-danger radio-inline">
			                                                            <input type="radio" id="inlineRadio'.$contador.'" name="radioInline'.$contadorModulo.'" value="'.$op["ID_TriviaOpciones"].'" required>
			                                                            <label for="inlineRadio'.$contador.'"> '.$op["NombreOpcion"].' </label>
			                                                            <input type="hidden" id="txt_id_pregunta'.$contadorPreguntas.'" name="txt_id_pregunta'.$contadorPreguntas.'" value="'.$medias[$i][$k]["ID_TriviaPregunta"].'">
			                                                        </div>
			                                                    </div>';
			                                                $contador++;
					                                	}
					                                	$quiz.='<input type="hidden" id="txt_id_modulo'.$contadorPreguntas.'" name="txt_id_modulo'.$contadorPreguntas.'" value="'.$datosQuiz[$i]["ID_Modulo_Trivia"].'">';
					                                	$contadorModulo++;
					                                	$contadorPreguntas++;
					                                }
					                                for ($l=0; $l < $datosQuiz[$i]["Alta"]; $l++) { 
				                                		$quiz.='<h6 class="modal-title">'.$contadorPreguntas.'.- '.$dificiles[$i][$l]["TituloPregunta"].'</h6>';
				                                		if ($dificiles[$i][$l]["Archivo"]!=null) {
				                                			$quiz.='<audio controls>
																	  <source src="'.site_url();$quiz.='archivos/audio/'.$dificiles[$i][$l]["Archivo"].'';$quiz.='"> type="audio/mp3">
																	Your browser does not support the audio element.
																	</audio>';
				                                		}
				                                		$opciones=$this->ModuloTrivia->listarOpcionesTrivia($dificiles[$i][$l]["ID_TriviaPregunta"],$BD);
				                                	foreach ($opciones as $op) {
				                                		$quiz.='<div class="col-md-2">
			                                                        <div class="radio abc-radio abc-radio-danger radio-inline">
			                                                            <input type="radio" id="inlineRadio'.$contador.'" name="radioInline'.$contadorModulo.'" value="'.$op["ID_TriviaOpciones"].'" required>
			                                                            <label for="inlineRadio'.$contador.'"> '.$op["NombreOpcion"].' </label>
			                                                            <input type="hidden" id="txt_id_pregunta'.$contadorPreguntas.'" name="txt_id_pregunta'.$contadorPreguntas.'" value="'.$dificiles[$i][$l]["ID_TriviaPregunta"].'">
			                                                        </div>
			                                                    </div>';
			                                                $contador++;
					                                	}				
					                                	$quiz.='<input type="hidden" id="txt_id_modulo'.$contadorPreguntas.'" name="txt_id_modulo'.$contadorPreguntas.'" value="'.$datosQuiz[$i]["ID_Modulo_Trivia"].'">';	                                	
					                                	$contadorModulo++;
					                                	$contadorPreguntas++;
					                                }
				                                $quiz.='</div>				                              
				                            </div>
				                        </div>
  									</div>
  								</div>';
  							}
  						$quiz.='<input type="hidden" id="txt_id_trivia" name="txt_id_trivia" value="'.$idQuiz.'">
                            	<input type="hidden" id="txt_id_user" name="txt_id_user" value="'.$idUser.'">
                            	<input type="hidden" id="txt_id_local" name="txt_id_local" value="'.$idLocal.'">
                            	<input type="hidden" id="txt_id_asignacion" name="txt_id_asignacion" value="'.$idAsignacion.'">
                            	<input type="hidden" id="txt_contador" name="txt_contador" value="'.$contadorPreguntas.'">';
						$quiz.='</form>';
				$data["resp"]=$resp;
	  			$data["quiz"]=$quiz;
				$this->load->view('contenido');
				$this->load->view('layout/headerApp',$data);
		        $this->load->view('layout/sidebarApp',$data);
			    $this->load->view('App/QuizApp',$data);
				$this->load->view('layout/footerApp',$data);	
			}
		}
	}

	function IngresarTriviaUsuario(){
		$this->load->model("ModuloTrivia");
		$id_trivia=$_POST["txt_id_trivia"];
		$id_usuario=$_POST["txt_id_user"];
		$id_asignacion=$_POST["txt_id_asignacion"];
		$id_local=$_POST["txt_id_local"];
		$contador=$_POST["txt_contador"];
		$BD=$_SESSION["BDSecundaria"];
		$correctas=array();
		$incorrectas=array();
		$contadorCorrecta=0;
		$contadorIncorrecta=0;
		for ($i=1; $i < $contador; $i++) {
			$respCorrectas[$i]=$this->ModuloTrivia->respuestasCorrectas($_POST["txt_id_pregunta".$i.""],$BD);
			$respUsuario[$i]=$_POST["radioInline".$i.""];
			if ($respCorrectas[$i]["FK_ID_Opcion_Correcta"]==$respUsuario[$i]) {
				$correctas[$contadorCorrecta]=1;
				$contadorCorrecta++;
			}else{
				$incorrectas[$contadorIncorrecta]=1;
				$contadorIncorrecta++;
			}
		}
		$cantidadRespCorrectas=array_sum($correctas);
		$cantidadRespIncorrectas=array_sum($incorrectas);
		$respTotales=($cantidadRespIncorrectas+$cantidadRespCorrectas);

		for ($i=1; $i < $contador; $i++) { 
			$this->ModuloTrivia->guardarRespuestas($_POST["txt_id_modulo".$i],$id_trivia,$id_usuario,$id_asignacion,$id_local,$_POST["txt_id_pregunta".$i],$_POST["radioInline".$i],0,$BD);
		}
		echo "<div class='card-body'>
                    <div class='row'>
                        <div class='col-md-12'>
							<div class='col-lg-3 col-md-4'>
				                <div class='card text-white bg-success mb-3' style='max-width: 20rem;'>
				                    <div class='card-header'>Respuestas Correctas</div>
				                    <div class='card-body'>
				                        <h5 class='card-title text-white'>Número de respuestas correctas: ".$cantidadRespCorrectas."</h5>
				                    </div>
				                </div>
				            </div>

				            <div class='col-lg-3 col-md-4'>
				                <div class='card text-white bg-danger mb-3' style='max-width: 20rem;'>
				                    <div class='card-header'>Respuestas Incorrectas</div>
				                    <div class='card-body'>
				                        <h5 class='card-title text-white'>Número de respuestas incorrectas: ".$cantidadRespIncorrectas."</h5>
				                    </div>
				                </div>
				            </div>

				            <div class='col-lg-3 col-md-4'>
				                <div class='card text-white bg-secondary mb-3' style='max-width: 20rem;'>
				                    <div class='card-header'>Respuestas Totales</div>
				                    <div class='card-body'>
				                        <h5 class='card-title text-white'>Número de respuestas totales: ".$respTotales."</h5>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
				<form action="; echo base_url("menu"); echo">
	            	<button style='margin-left:70px;' type='submit' class='btn btn-outline-theme'><i class='mdi mdi-home-variant'></i>Volver al Menú Principal</button>
	            </form>";
	}

	function verQuizEstatico(){
		if(isset($_SESSION["BDSecundaria"])){
  			if($_SESSION['Perfil']==3){ 			
  				$resp="";
				$data["Usuario"]=$_SESSION["Usuario"];					
  				$data["Nombre"]=$_SESSION["Nombre"];
  				$data["Perfil"]=$_SESSION["Perfil"];
  				$data["Cargo"]=$_SESSION["Cargo"];
  				$data["NombreCliente"]=$_SESSION["NombreCliente"];
  				$idAsignacion=$_POST["txt_id_asignacion"];
  				$idLocal=$_POST["txt_local"];
  				$idQuiz=$_POST["txt_id_quiz"];
  				$idUser=$_SESSION["Usuario"];
  				$BD=$_SESSION["BDSecundaria"];
  				$msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);		
	  			$data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
	  			$data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
	  			$data["cantidadMsj"]=count($data["mensaje"]);
	  			$data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
	  			$data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
	  			$trivia=$this->ModuloUsuarioApp->buscarDatosQuiz($idQuiz,$BD);
	  			// var_dump($trivia);exit();
	  			$datosModulo=$this->ModuloUsuarioApp->buscarQuizIDEstaticoModulo($BD,$idQuiz);
	  			$nModulos=count($datosModulo);
	  			$contadorPreguntas=1;
	  			$contMod=1;
	  			$contadorOpcion=1;
	  			$contAux=0;
	  			$contador=1;
	  			$contModu=0;
	  			$cuentaPreg=0;
	  			$quiz='<h3>'.$trivia[0]["Nombre"].'</h3>
	  			<form id="frmQuizStatic" method="POST" enctype="multipart/form-data">';
	  			if ($trivia[0]["Lista_Maestra"]=="") {
	  				$quiz.='<input type="hidden" name="validador_maestra" id="validador_maestra" value="0">';
	  			}else{
	  				$regiones=$this->ModuloTrivia->cargarListaMaestra($trivia[0]["Lista_Maestra"],$BD);
	  				$quiz.='<input type="hidden" name="validador_maestra" id="validador_maestra" value="1">
	  				<input type="hidden" name="id_maestra" id="id_maestra" value="'.$trivia[0]["Lista_Maestra"].'">
	  				<div class="col-md-12">
	  					<div class="card border-danger mb-3">
	  						<div class="card-header text-center">
                            	<h4>Departamento Y Distrito</h4>
                        	</div>
                        	<div class="card-body">
                        		<div class="row">
                        			<div class="col-md-12">
                        				<select class="form-control" id="lb_region" name="lb_region" onchange="ciudad()">
                        				<option value="-1">Elegir una opcion</option>';
                        				if (isset($regiones)) {
                        					foreach($regiones as $r){                                   
						                        $quiz.='<option value="'.$r["ID_Region"].'">'.$r["Region"].'</option>';   
						                    }
                        				}else{
						                   $quiz.='<option value="">No existe Categoria por Departamento</option>';
						                }
                        				$quiz.='</select>
                        				<input type="hidden" name="val_region" id="val_region">
                        			</div>	
                        			<div class="col-md-12" id="ciudad" style="display:none;">
                        				<hr>
                        				<select class="form-control" id="lb_ciudad" name="lb_ciudad" onchange="comuna()">
                        				</select>
                        				<input type="hidden" name="val_ciudad" id="val_ciudad">
                        			</div>
                        			<div class="col-md-12" id="comuna" style="display:none;">
                        				<hr>
                        				<select class="form-control" id="lb_comuna" name="lb_comuna" onchange="local()">
                        				</select>
                        				<input type="hidden" name="val_comuna" id="val_comuna">
                        			</div>
                        			<div class="col-md-12" id="local" style="display:none;">
                        				<hr>
                        				<select class="form-control" id="lb_local" name="lb_local" onchange="final_cluster()">
                        				</select>
                        				<input type="hidden" name="val_local" id="val_local">
                        			</div>
                        			<input type="hidden" id="txt_local_cluster" name="txt_local_cluster">
                        		</div>
                        	</div>
	  					</div>
	  				</div>';
	  			}
	  			for ($i=0; $i < $nModulos; $i++) {
	  				$quiz.='<div class="col-md-12">
	  					<div class="card border-danger text-danger mb-3">
	  						<div class="card-header">
                            	<h4>'.$datosModulo[$i]["Nombre_Modulo_Estatica"].'</h4>
                        	</div>
                        	<div class="card-body">
                        		<div class="row">
                        			<div class="col-md-12">';
                        				$preguntas[$i]=$this->ModuloTrivia->listarPreguntasTriviaEstatica($datosModulo[$i]["ID_Modulo_Trivia_Estatica"],$BD);
                        				foreach ($preguntas[$i] as $pr) {
                        					$quiz.='<div class="card border-dark text-dark mb-3">
                        						<div class="card-header">
                        							<div class="row">
                    									<p>&nbsp;&nbsp;'.$contadorPreguntas.' .-&nbsp;&nbsp; </p><h6 style="color: #536c79 font-size:160%;">'.$pr["TituloPreguntaEstatica"].'</h6>
                        							</div>
                        						</div>                        					
                        						<input type="hidden" id="id_pregunta'.$contMod.'-'.$contadorPreguntas.'" name="id_pregunta'.$contMod.'-'.$contadorPreguntas.'" value="'.$pr["ID_TriviaPreguntaEstatica"].'">
                        						<input type="hidden" id="nom_pregunta'.$contMod.'-'.$contadorPreguntas.'" name="nom_pregunta'.$contMod.'-'.$contadorPreguntas.'" value="'.$pr["TituloPreguntaEstatica"].'">
                        						<div class="card-body">
                        							<div class="row">
                        								<div class="col-md-12">
                        									<p class="margin"><i class="fa fa-dot-circle-o"></i> Opciones</p>';
                        									$opciones[$contMod][$contAux]=$this->ModuloTrivia->listarOpcionesTriviaEstaticax($preguntas[$i][$contAux]["ID_TriviaPreguntaEstatica"],$BD);
                        									foreach ($opciones[$contMod][$contAux] as $op){
                        										if ($op["Foto"]==1) {
                        										 	$onchangeFoto='onchange="foto_opcion('.$contMod.','.$contadorPreguntas.')"';
                        										}else{
                        											$onchangeFoto='onchange="ocultar_foto('.$contMod.','.$contadorPreguntas.')"';
                        										} 
                        										$quiz.='<div class="radio abc-radio abc-radio-danger radio-inline">
                        										<input type="radio" id="inlineRadio'.$contador.'" name="radioInline'.$contMod.'-'.$contadorPreguntas.'" value="'.$op["ID_TriviaOpciones"].'" '.$onchangeFoto.'>
			                                                            <label for="inlineRadio'.$contador.'"> '.$op["NombreOpcion"].' </label>
			                                                           </div>';
                        										$contador++;
                        										$contadorOpcion++;
                        									}
                        									if ($pr["No_aplica"]==1) {
                    											$quiz.='<div class="radio abc-radio abc-radio-danger radio-inline">
                    											<input type="radio" id="inlineRadio'.$contador.'" name="radioInline'.$contMod.'-'.$contadorPreguntas.'" value="666SATAN">
		                                                            <label for="inlineRadio'.$contador.'"> NO APLICA </label>
		                                                            </div>';
		                                                            $contador++;
                    										}
                        									// $contadorPreguntas=1;
                        								$quiz.='<div class="card border-dark text-dark mb-3" id="id_foto_opcion'.$contMod.'-'.$contadorPreguntas.'" style="display:none">
										  						<div class="card-header">
										  							<h6>Foto Opción </h6>
										  						</div>
									  							<input type="file" class="btn btn-outline-theme dropify dropdep" id="file_foto_opcion'.$contMod.'-'.$contadorPreguntas.'" name="file_foto_opcion'.$contMod.'-'.$contadorPreguntas.'" onchange="foto('.$contMod.','.$contadorPreguntas.')">
									  							<input type="hidden" id="foto_opcion_validador'.$contMod.'-'.$contadorPreguntas.'" name="foto_opcion_validador'.$contMod.'-'.$contadorPreguntas.'" value="0">
									  							<input type="hidden" name="txt_nombre_foto_op'.$contMod.'-'.$contadorPreguntas.'" id="txt_nombre_foto_op'.$contMod.'-'.$contadorPreguntas.'">
									  						</div>
									  					</div>
                        							</div>
                        						</div>';
                        					
                        					$quiz.='</div>'; 
                        					
                        					$contadorPreguntas++;
                        					$contAux++;
                        					$cuentaPreg++;
                        				}
                        				$quiz.='<input type="hidden" id="txt_contador_preg'.$contMod.'" name="txt_contador_preg'.$contMod.'" value="'.$cuentaPreg.'">';
                        				$cuentaPreg=0;
                        				if ($datosModulo[$i]["Foto"]) {
					  						$quiz.='<div class="card border-dark text-dark mb-3">
						  						<div class="card-header">
						  							<h6>Foto de Presentación </h6>
						  						</div>
					  							<input type="file" class="btn btn-outline-theme dropify dropdep" id="file_foto'.$contMod.'" name="file_foto'.$contMod.'">
					  						</div>';
					  					}
					  					if ($datosModulo[$i]["Observacion"]) {
					  						$quiz.='<div class="card border-dark text-danger mb-3">
		  									<div class="card-header">
                								<h6>Observaciones de la Foto de Presentación </h6>
            								</div>
		  								<textarea type="textarea" class="form-control" id="txt_obs'.$contMod.'" name="txt_obs'.$contMod.'"></textarea>
		  								</div>';
		  								}
                        			$quiz.='</div>
                        		</div>
                        	</div>';
                        	$contAux=0;
                        	$contadorPreguntas=1;
	  					$quiz.='</div>
	  				</div>
	  				';
	  				$contMod++;
	  				$contModu++;
	  			}
	  			$quiz.='<input type="hidden" id="txt_id_trivia" name="txt_id_trivia" value="'.$idQuiz.'">
				<input type="hidden" id="txt_id_user" name="txt_id_user" value="'.$idUser.'">
				<input type="hidden" id="txt_id_local" name="txt_id_local" value="'.$idLocal.'">
				<input type="hidden" id="txt_id_asignacion" name="txt_id_asignacion" value="'.$idAsignacion.'">
	  			<input type="hidden" id="txt_contador_mod" name="txt_contador_mod" value="'.$contModu.'">';		
	  			$quiz.='<script src="'.site_url().'assets/libs/dropify/dist/js/dropify.min.js"></script>
	  				<script type="text/javascript">

	  					function foto(contMod,contPreg){
	  						var data=new FormData();
				            data.append("asignacion",$("#txt_id_asignacion").val());
				            data.append("local",$("#txt_id_local").val());
				            data.append("id_trivia",$("#txt_id_trivia").val());
				            data.append("id_user",$("#txt_id_user").val()); 
				           	data.append("file",$("#file_foto_opcion"+contMod+"-"+contPreg)[0].files[0]);
				            $.ajax({
				            	url:"'.base_url('App_ModuloTrivias/AddFoto').'",
				                type:"POST",
				                contentType:false,
				                processData:false,
				                data:data,
				                success: function(data){
				                	console.log(data);
				                	if(data!=="ERROR"){
				                		$("#txt_nombre_foto_op"+contMod+"-"+contPreg).val(data);
				                	}
				                }
			            	});
	  					}

		  				function foto_opcion(contMod,contPreg){
	  						$("#id_foto_opcion"+contMod+"-"+contPreg).show("slow");
	  						$("#foto_opcion_validador"+contMod+"-"+contPreg).val(1);
		  				}

		  				function ocultar_foto(contMod,contPreg){
		  					$("#id_foto_opcion"+contMod+"-"+contPreg).hide("slow");
		  					$("#foto_opcion_validador"+contMod+"-"+contPreg).val(0);
		  					$("#txt_nombre_foto_op"+contMod+"-"+contPreg).val(0);
		  				}

		  				function ciudad(){
		  					if($("#val_region").val()==1){
		  						$("#lb_ciudad").val(-1);
		  						$("#lb_comuna").val(-1);
		  						$("#lb_local").val(-1);
		  						$("#ciudad").hide("slow");
		  						$("#comuna").hide("slow");
		  						$("#local").hide("slow");
		  						$("#val_region").val("");
		  						ciudad_2dn();
		  					}else{
		  						$("#val_region").val(1);
			  					$("#ciudad").show("slow");
			  					var ciudad=$("#lb_region").val();
		  						var id_maestra=$("#id_maestra").val();
		  						$.ajax({
		  							url: "elegirnCiudad",
			                        type: "POST",
			                        data: "ciudad="+ciudad+"&id_maestra="+id_maestra,
			                        success: function(data) {
			                            $("#lb_ciudad").html(data);                          
			                        }
	  							});
		  					}
		  				}

		  				function ciudad_2dn(){
		  					if($("#val_region").val()==1){
		  						$("#lb_ciudad").val(-1);
		  						$("#lb_comuna").val(-1);
		  						$("#lb_local").val(-1);
		  						$("#ciudad").hide("slow");
		  						$("#comuna").hide("slow");
		  						$("#local").hide("slow");
		  						$("#val_region").val("");
		  						ciudad();
		  					}else{
		  						$("#val_region").val(1);
			  					$("#ciudad").show("slow");
			  					var ciudad=$("#lb_region").val();
		  						var id_maestra=$("#id_maestra").val();
		  						$.ajax({
		  							url: "elegirnCiudad",
			                        type: "POST",
			                        data: "ciudad="+ciudad+"&id_maestra="+id_maestra,
			                        success: function(data) {
			                            $("#lb_ciudad").html(data);                          
			                        }
	  							});
		  					}
		  				}

	  					function comuna(){
	  						if($("#val_ciudad").val()==1){
	  							$("#lb_ciudad").val(-1);
		  						$("#lb_comuna").val(-1);
		  						$("#lb_local").val(-1);
		  						$("#ciudad").hide("slow");
		  						$("#comuna").hide("slow");
		  						$("#local").hide("slow");
		  						$("#val_ciudad").val("");
		  						$("#val_comuna").val("");
	  						}else{
	  							$("#val_ciudad").val(1);
	  							$("#comuna").show("slow");
		  						var comuna=$("#lb_region").val();
		  						var id_maestra=$("#id_maestra").val();
		  						$.ajax({
		  							url: "elegirRegion",
			                        type: "POST",
			                        data: "comuna="+comuna+"&id_maestra="+id_maestra,
			                        success: function(data) {
			                            $("#lb_comuna").html(data);                          
			                        }
	  							});
	  						}
	  					}

	  					function local(){
	  						if($("#val_comuna").val()==1){
	  							$("#lb_ciudad").val(-1);
		  						$("#lb_comuna").val(-1);
		  						$("#lb_local").val(-1);
		  						$("#ciudad").hide("slow");
		  						$("#comuna").hide("slow");
		  						$("#local").hide("slow");
		  						$("#val_comuna").val("");
		  						$("#val_ciudad").val("");
  							}else{
  								$("#val_comuna").val(1);
  								$("#local").show("slow");
		  						var comuna=$("#lb_comuna").val();
		  						var id_maestra=$("#id_maestra").val();
		  						$.ajax({
		  							url: "elegirComuna",
			                        type: "POST",
			                        data: "comuna="+comuna+"&id_maestra="+id_maestra,
			                        success: function(data) {
			                            $("#lb_local").html(data);                      
			                        }
	  							});
  							}
	  						
	  					}

	  					function final_cluster(){
	  						var id_local=$("#lb_local").val();
	  						$("#txt_local_cluster").val(id_local);
	  					}

	  					$(".dropify").dropify({
		  						messages: {
					            default: "Subir Imagen",
					            replace: "Nueva Fotografía",
					            remove:  "Eliminar",
					            error:   "-vacio-"
					        },
					        showRemove: true,
					        showLoader: true,
					        showErrors: true,
					        errorTimeout: 1000,
					        errorsPosition: "overlay",
					        imgFileExtensions: ["png", "jpg", "jpeg"],
					        maxFileSizePreview: "5M",
					        allowedFileExtensions: ["png", "jpg", "jpeg"],
  						});

  						Dropify.prototype.isImage = function()
					    {
					      if (this.settings.imgFileExtensions.indexOf(this.getFileType()) != "-1") {
					          return true;
					      }
					      return false;
			  			};
	  				</script>';
	  			$quiz.='</form>';
	  			$data["quiz"]=$quiz;
	  			$this->load->view('contenido');
				$this->load->view('layout/headerApp',$data);
		        $this->load->view('layout/sidebarApp',$data);
			    $this->load->view('App/QuizAppEstatica',$data);
				$this->load->view('layout/footerApp',$data);
  			}
  		}
	}

	function IngresarTriviaUsuarioEstatica(){
			$this->load->model("ModuloTrivia");
			$id_trivia=intval($_POST["txt_id_trivia"]);
			$id_usuario=$_POST["txt_id_user"];
			$id_asignacion=$_POST["txt_id_asignacion"];
			if (!isset($_POST["id_maestra"])) {
				$id_local=$_POST["txt_id_local"];
			}else{
				$id_local=$_POST["lb_local"];
			}
			$nModulos=$_POST["txt_contador_mod"];
			$BD=$_SESSION["BDSecundaria"];
			$quiz=$this->ModuloUsuarioApp->buscarDatosQuiz($id_trivia,$BD);
			$foto=$quiz[0]["Foto"];
			$contadorModulo=1;
			$contadorPregunta=1;
			$contadorCorrecta=0;
			$contadorIncorrecta=0;
			$correctas=array();
			$incorrectas=array();
			$datosModulo=$this->ModuloUsuarioApp->buscarQuizIDEstaticoModulo($BD,$id_trivia);
			$nModulos=count($datosModulo);
			$contadorModulo=1;
			$contMod=1;
			$respC=0;
			$respI=0;
			echo "<form action='confimarRespuestas' id='frmQuizFoto' method='POST' enctype='multipart/form-data' >
			<input type='hidden' id='txt_user' name='txt_user' value='".$id_usuario."'>";
			if ($foto==1) {
  				echo '<div class="col-md-12">
  					<div class="card border-danger text-danger mb-3">
  						<div class="card-header">
                        	<h4>RECUERDE QUE DEBE SUBIR SU FOTOGRAFÍA DE CONFIRMACIÓN PARA PODER GUARDAR LAS RESPUESTAS.</h4>
                    	</div>
                    	<div class="card-body">
                    		<div class="row">
                    			<div class="col-md-12">
                    				<input type="file" class="btn btn-outline-theme dropify dropdep" id="file_foto_general" name="file_foto_general" onchange="foto_general()">
                    				<input type="hidden" id="input_foto_general" name="input_foto_general">
                    			</div>
                    		</div>
                    	</div>
  					</div>
  				</div>';
  				
  			}
  			echo '<input type="hidden" id="id_trivia" name="id_trivia" value="'.$id_trivia.'">';
  			echo '<input type="hidden" id="id_asignacion" name="id_asignacion" value="'.$id_asignacion.'">';
  			echo '<input type="hidden" id="id_local" name="id_local" value="'.$id_local.'">';
			for ($i=0; $i < $nModulos; $i++) {
				echo "<div class='card-body'>
				<div class='row'>
					<div class='col-md-12'>
						<div class='col-lg-3 col-md-4'>
							<div class='card text-white bg-primary mb-3' style='max-width: 20rem;'>
								<div class='card-header'>Módulo ".$datosModulo[$i]["Nombre_Modulo_Estatica"]."</div>
				                    <div class='card-body'>";
				                    for ($j=0; $j < intval($_POST["txt_contador_preg".$contadorModulo]); $j++) { 
				                    	$respCorrectas[$contadorModulo][$contadorPregunta]=$this->ModuloTrivia->respuestasCorrectasEstatico($_POST["id_pregunta".$contadorModulo."-".$contadorPregunta],$BD);
				                    	$respUsuario[$contadorModulo][$contadorPregunta]=$_POST["radioInline".$contadorModulo."-".$contadorPregunta];
				                    	if($datosModulo[$i]["Descuento"]!=1){
					                    	if ($respCorrectas[$contadorModulo][$contadorPregunta]["FK_ID_Opcion_Correcta"]==$respUsuario[$contadorModulo][$contadorPregunta] || $_POST["radioInline".$contadorModulo."-".$contadorPregunta]=="666SATAN") {
					                    		$respC++;
					                    	}else{
					                    		$respI++;
					                    	}
					                    	$contadorPregunta++;
					                    }
					                    if($datosModulo[$i]["Descuento"]==1){
					                    	if ($respCorrectas[$contadorModulo][$contadorPregunta]["FK_ID_Opcion_Correcta"]==$respUsuario[$contadorModulo][$contadorPregunta] || $_POST["radioInline".$contadorModulo."-".$contadorPregunta]=="666SATAN") {
					                    		$respC++;
					                    	}else{
					                    		$respI++;
					                    		$respC--;
					                    	}
					                    	$contadorPregunta++;
					                    }
				                    }
				                    echo "<h5 class='card-title text-white'>Peso Módulo: ".$datosModulo[$i]["Porcentaje"]." %</h5>
				                    <h5 class='card-title text-white'>Resultado: ".$respC."</h5>
				                    <h5 class='card-title text-white'>Total Preguntas: ".($contadorPregunta-1)."</h5>
				                    <h5 class='card-title text-white'>Cumplimiento Total: ".number_format(((((100/($contadorPregunta-1))*$respC)*$datosModulo[$i]["Porcentaje"])/100),2,',','')."%</h5>";
			                    	$total[$contadorModulo]=((((100/($contadorPregunta-1))*$respC)*$datosModulo[$i]["Porcentaje"])/100);
			                    	$resp_modulo[$i]=number_format(((((100/($contadorPregunta-1))*$respC)*$datosModulo[$i]["Porcentaje"])/100),2,',','');
				                    $respC=0;
									$respI=0;
				                    $contMod=1;
				                    $contadorPregunta=1;
				                    echo "</div>
								</div>
							</div>
						</div>
					</div>
				</div>";
				$contadorModulo++;
			}
			echo "<div class='card-body'>
				<div class='row'>
					<div class='col-md-12'>
						<div class='col-lg-3 col-md-4'>
							<div class='card text-white bg-dark mb-3' style='max-width: 20rem;'>
								<div class='card-header'>Porcentaje Total obtenido</div>
									<div class='card-body'>
										<h5 class='card-title text-white'>Total obtenido de la encuesta ".number_format(array_sum($total),2,',','')."%</h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>";
			if($foto==1){
				echo "<div id='confirmar' style='display:none;'>
	        		<button style='margin-left:70px;' type='submit' class='btn btn-outline-theme' onclick='return validarFoto();'><i class='mdi mdi-home-variant'></i>Confirmar Respuestas</button>
	        	</div>";
	        }else{
	        	echo "<button style='margin-left:70px;' type='submit' class='btn btn-outline-theme'><i class='mdi mdi-home-variant'></i>Confirmar Respuestas</button>";
	        }
	        echo "</form>
	        <script src='".site_url()."assets/libs/dropify/dist/js/dropify.min.js'></script>
	        <script src='".site_url()."assets/libs/Alertify/js/alertify.js'></script>
			<script type='text/javascript'>
				$('.dropify').dropify({
						messages: {
			            default: 'Subir Imagen',
			            replace: 'Nueva Fotografía',
			            remove:  'Eliminar',
			            error:   '-vacio-'
			        },
			        showRemove: true,
			        showLoader: true,
			        showErrors: true,
			        errorTimeout: 1000,
			        errorsPosition: 'overlay',
			        imgFileExtensions: ['png', 'jpg', 'jpeg'],
			        maxFileSizePreview: '5M',
			        allowedFileExtensions: ['png', 'jpg', 'jpeg'],
				});

				Dropify.prototype.isImage = function()
			    {
			      if (this.settings.imgFileExtensions.indexOf(this.getFileType()) != '-1') {
			          return true;
			      }
			      $('#file_foto_general').val('');
			      return false;
			    };

				function foto_general(){
					if($('#file_foto_general').val()!=''){
						$('#confirmar').show('slow');
						alertify.log('Debe guardar las respuestas más abajo!');
					}else{
						$('#confirmar').hide('slow');
						alertify.error('debe tomar foto de confirmación');
					}
				}

				function validarFoto(){
					if($('#file_foto_general').val()!=''){
						return true;
					}else{
						$('#confirmar').hide('slow');
						alertify.error('debe tomar foto de confirmación');
						return false;
					}
				}
			</script>";

			$contadorModulo=1;
			$contadorPregunta=1;
			$contadorPregAux=1;
			$respC=0;
			$respI=0;
			$fotoGeneral="";
			$nota=str_replace(',','.',number_format(array_sum($total),2,',',''));
			for ($i=0; $i < $nModulos; $i++) {
				if (isset($_FILES['file_foto'.$contadorModulo])) {
					$tipo=str_replace('image/', '.',$_FILES['file_foto'.$contadorModulo]['type']);
					if($tipo=='.jpg' ||  $tipo=='.jpeg' ||  $tipo=='.png'){
						$random=rand(1, 10000);
						$foto='l_'.$id_local.'_r_'.$random.'_u_'.$id_usuario.'_f_'.str_replace(' ','',str_replace('-','',str_replace(':','',date("Y-m-d H:i:s")))).$tipo;					
						$R=$this->subirArchivos($foto,$contadorModulo,0,0);
					}else{
						$foto="";
					}
				}else{
					$foto="";
				}
				if (isset($_POST["txt_obs".$contadorModulo])) {
					$obs=$_POST["txt_obs".$contadorModulo];
				}else{
					$obs="";
				}
				for ($j=0; $j < intval($_POST["txt_contador_preg".$contadorModulo]); $j++) {
					$respCorrectas[$contadorModulo][$contadorPregunta]=$this->ModuloTrivia->respuestasCorrectasEstatico($_POST["id_pregunta".$contadorModulo."-".$contadorPregunta],$BD);
	            	$respUsuario[$contadorModulo][$contadorPregunta]=$_POST["radioInline".$contadorModulo."-".$contadorPregunta];
	            	if($datosModulo[$i]["Descuento"]!=1){
                    	if ($respCorrectas[$contadorModulo][$contadorPregunta]["FK_ID_Opcion_Correcta"]==$respUsuario[$contadorModulo][$contadorPregunta] || $_POST["radioInline".$contadorModulo."-".$contadorPregunta]=="666SATAN") {
                    		$respC++;
                    	}else{
                    		$respI++;
                    	}
                    	$contadorPregunta++;
                    }
                    if($datosModulo[$i]["Descuento"]==1){
                    	if ($respCorrectas[$contadorModulo][$contadorPregunta]["FK_ID_Opcion_Correcta"]==$respUsuario[$contadorModulo][$contadorPregunta] || $_POST["radioInline".$contadorModulo."-".$contadorPregunta]=="666SATAN") {
                    		$respC++;
                    	}else{
                    		$respI++;
                    		$respC--;
                    	}
                    	$contadorPregunta++;
                    }
					$this->ModuloTrivia->guardarRespuestasEstatica(1,$id_trivia,$datosModulo[$i]["ID_Modulo_Trivia_Estatica"],$id_usuario,$id_asignacion,$id_local,$_POST["id_pregunta".$contadorModulo."-".$contadorPregAux],$_POST["nom_pregunta".$contadorModulo."-".$contadorPregAux],$respUsuario[$contadorModulo][$contadorPregAux],$nota,str_replace(",",".",$resp_modulo[$i]),$obs,$foto,$fotoGeneral,$_POST["txt_nombre_foto_op".$contadorModulo."-".$contadorPregAux],$BD);
					$contadorPregAux++;					
				}
				$respC=0;
				$respI=0;
				$contadorPregAux=1;
				$contadorPregunta=1;
				$contadorModulo++;
			}
			$this->ModuloTrivia->guardarTriviaCompletada($id_asignacion,$id_usuario,$id_local,1,$id_trivia,$nota,$BD);
	}

	function confimarRespuestas(){
		if (isset($_POST["id_trivia"])) {
			$BD=$_SESSION["BDSecundaria"];
			$id_trivia=$_POST["id_trivia"];
			$id_user=$_POST["txt_user"];
			$id_local=$_POST["id_local"];
			$id_asignacion=$_POST["id_asignacion"];
			if (isset($_FILES["file_foto_general"])) {
				$tipo=str_replace('image/', '.',$_FILES['file_foto_general']['type']);
				if($tipo=='.jpg' ||  $tipo=='.jpeg' ||  $tipo=='.png'){
					$random=rand(1, 10000);
					$fotoGeneral='l_'.$id_local.'_r_'.$random.'_u_'.$id_user.'_f_'.str_replace(' ','',str_replace('-','',str_replace(':','',date("Y-m-d H:i:s")))).$tipo;
					$R=$this->subirArchivosFotoGeneral($fotoGeneral,0,0);
					$this->ModuloUsuarioApp->GuardarFotoConfirmacionTrivia($id_trivia,$fotoGeneral,$id_user,$BD,$id_local,$id_asignacion);		
				}	
			}
		 redirect(site_url("App_ModuloTareas/elegirTareasAsignadas"));
		}else{
			redirect(site_url("App_ModuloTareas/elegirTareasAsignadas"));
		}
		
	}

	function limpiaEspacio($var){
    	$patron = "/[' ']/i";
		$cadena_nueva = preg_replace($patron,"",$var);
		return $cadena_nueva; 
 	}

 	function subirArchivosFotoGeneral($filename){
 		$archivo ='file_foto_general';
		$config['upload_path'] = "archivos/respuesta_encuesta/";	
		$config['file_name'] =$filename;
		$config['allowed_types'] = "jpeg|jpg|png";
		$config['overwrite'] = TRUE;	
		$this->upload->initialize($config);
		if (!$this->upload->do_upload($archivo)) {
			$data['uploadError'] = $this->upload->display_errors();
			echo $this->upload->display_errors();
			return;
		}
		$data = $this->upload->data();
		$arc=explode('.', strtolower($filename));
		$tamano = $data['file_size'];
	    $ancho = $data['image_width'];
	    $alto = $data['image_height'];
	    $config['image_library'] = 'gd2';  
	    $config['source_image'] = "archivos/respuesta_encuesta/".$data["file_name"];  
	    $config['create_thumb'] = FALSE;  
	    $config['maintain_ratio'] = FALSE;  
	    $config['quality'] = '60%';  
	    $config['width'] = 1280;  
	    $config['height'] = 1024;  
	    $config['new_image'] = "archivos/respuesta_encuesta/".$data["file_name"];  
	    $this->load->library('image_lib', $config); 
	    $this->image_lib->clear();
	    $this->image_lib->initialize($config);
	    $this->image_lib->resize();  
		$nombre= $data['file_name'];
		return $nombre;
 	}

 	public function subirArchivos($filename,$count){
		$archivo ='file_foto'.$count;
		$config['upload_path'] = "archivos/respuesta_encuesta/";	
		$config['file_name'] =$filename;
		$config['allowed_types'] = "jpeg|jpg|png";
		$config['overwrite'] = TRUE;	
		$this->upload->initialize($config);
		if (!$this->upload->do_upload($archivo)) {
			$data['uploadError'] = $this->upload->display_errors();
			echo $this->upload->display_errors();
			return;
		}
		$data = $this->upload->data();
		$arc=explode('.', strtolower($filename));
		$tamano = $data['file_size'];
	    $ancho = $data['image_width'];
	    $alto = $data['image_height'];
	    $config['image_library'] = 'gd2';  
	    $config['source_image'] = "archivos/respuesta_encuesta/".$data["file_name"];  
	    $config['create_thumb'] = FALSE;  
	    $config['maintain_ratio'] = FALSE;  
	    $config['quality'] = '60%';  
	    $config['width'] = 1280;  
	    $config['height'] = 1024;  
	    $config['new_image'] = "archivos/respuesta_encuesta/".$data["file_name"];  
	    $this->load->library('image_lib', $config); 
	    $this->image_lib->clear();
	    $this->image_lib->initialize($config);
	    $this->image_lib->resize();  
		$nombre= $data['file_name'];
		return $nombre;
	}

	function elegirRegion(){
	    if(isset($_SESSION["BDSecundaria"])){
	        $BD=$_SESSION["BDSecundaria"];
	        $region = $_POST["comuna"];    
	        $id_maestra = $_POST["id_maestra"]; 
	        $comunas=$this->ModuloTrivia->ListarClusterComunasActivosTrivia($BD,$id_maestra,$region);
	        echo "<option value='-1'>Selecione</option>";
	        if ($comunas[0]!='') {          
	        	foreach ($comunas as $co) {
	            echo "<option value='".$co["ID_Comuna"]."' >".$co["Comuna"]."</option>";
	        	}
	    	}else{
	        	echo "<option value=''>No esta categorizado</option>";
	      	}
	    }else{
	      redirect(site_url("login/inicio")); 
	    }
	}

	function elegirComuna(){
		if(isset($_SESSION["BDSecundaria"])){
	        $BD=$_SESSION["BDSecundaria"];
	        $comuna = $_POST["comuna"];    
	        $id_maestra = $_POST["id_maestra"]; 
	        $locales=$this->ModuloTrivia->ListarClusterLocalesActivosTrivia($BD,$id_maestra,$comuna);
	        echo "<option value='-1'>Selecione Local</option>";
	        if ($locales[0]!='') {          
	        	foreach ($locales as $lo) {
	            echo "<option value='".$lo["ID_Local"]."' >".$lo["NombreLocal"]."</option>";
	        	}
	    	}else{
	        	echo "<option value=''>No esta categorizado</option>";
	      	}
	    }else{
	      redirect(site_url("login/inicio")); 
	    }
	}

	function elegirnCiudad(){
		if(isset($_SESSION["BDSecundaria"])){
	        $BD=$_SESSION["BDSecundaria"];
	        $ciudad = $_POST["ciudad"];    
	        $id_maestra = $_POST["id_maestra"]; 
	        $ciudades=$this->ModuloTrivia->ListarClusterCiudadesActivosTrivia($BD,$id_maestra,$ciudad);
	        echo "<option value='-1'>Selecione</option>";
	        if ($ciudades[0]!='') {          
	        	foreach ($ciudades as $ci) {
	            echo "<option value='".$ci["ID_Ciudad"]."' >".$ci["Ciudad"]."</option>";
	        	}
	    	}else{
	        	echo "<option value=''>No esta categorizado</option>";
	      	}
	    }else{
	      redirect(site_url("login/inicio")); 
	    }
	}

	function AddFoto(){
		$vacios=0;
		if((!isset($_POST["asignacion"])) || $_POST["asignacion"]==""){
	        $vacios+=1;
	    }
	    if((!isset($_POST["id_trivia"])) || $_POST["id_trivia"]==""){
	        $vacios+=1;
	    }
	    if((!isset($_POST["id_user"])) || $_POST["id_user"]==""){
	        $vacios+=1;
	    }
	    if(!isset($_FILES["file"]) || $_FILES["file"]["size"]==0){
	        $vacios+=1;
	    }
	    if ($vacios!=0) {
	    	echo "ERROR";
	    }else{
	    	$asignacion=$_POST["asignacion"];
	    	$local=$_POST["local"];
	    	$trivia=$_POST["id_trivia"];
	    	$usuario=$_POST["id_user"];
	    	$tipo=str_replace('image/', '.',$_FILES['file']['type']);
	    	if($tipo=='.jpg' ||  $tipo=='.jpeg' ||  $tipo=='.png'){
		    	$random=rand(1, 10000);
		    	$clave=$foto='l_'.$local.'_r_'.$random.'_u_'.$usuario.'_f_'.str_replace(' ','',str_replace('-','',str_replace(':','',date("Y-m-d H:i:s")))).$tipo;			
		    	$ruta='archivos/respuesta_encuesta/opciones/';
		    	if(isset($_FILES["file"]) && $_FILES["file"]["name"]!=''){
		    		$tipo=explode('.', $_FILES["file"]["name"]);
		    		$this->subir_Foto($ruta,$clave);
		    		echo $clave;
		    	}
		    }
	    }		
	}

	public function subir_Foto($ruta,$filename){
		$foto1 = 'file';
	    $config['upload_path'] = $ruta;
	    $config['file_name'] =$filename;
	    $config['allowed_types'] = "jpeg|jpg|png";
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
	    $config['image_library'] = 'gd2';  
	    $config['source_image'] = $ruta.$data["file_name"];  
	    $config['create_thumb'] = FALSE;  
	    $config['maintain_ratio'] = FALSE;  
	    $config['quality'] = '60%';  
	    $config['width'] = 1280;  
	    $config['height'] = 1024;  
	    $config['new_image'] = $ruta.$data["file_name"];  
	    $this->load->library('image_lib', $config); 
	    $this->image_lib->clear();
	    $this->image_lib->initialize($config);
	    $this->image_lib->resize();  
	    $nombre= $data['file_name'];
	    return $ruta.$nombre;
	}
}
