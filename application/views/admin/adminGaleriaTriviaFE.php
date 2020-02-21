<link rel="stylesheet" href="<?php echo base_url("assets/libs/lightbox/magnific-popup.css"); ?>">
<script src="<?php echo base_url("assets/libs/lightbox/jquery.magnific-popup.js"); ?>"></script>
<script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo  site_url(); ?>assets/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo  site_url(); ?>assets/js/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo  site_url(); ?>assets/css/daterangepicker.css" />
<body class="app sidebar-fixed aside-menu-off-canvas aside-menu-hidden header-fixed  pace-done"> 
	<div class="app-body" <?php if(isset($_SESSION["sesion"])){ echo 'style="margin: 0;"'; } ?>>
		<main class="main" style="height: 100%">
			<?php 
				if(isset($_SESSION["sesion"])){
					echo '
					<ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
				        <li class="breadcrumb-item ">
				            <a href="'.site_url().'menu">Menú</a>
				        </li>
				        <li class="breadcrumb-item">
				            <a href="">Trivia</a>
				        </li>
				        <li class="breadcrumb-item active">Galería Fotográfica- '.$tr.'</li>
				    </ol>';
				} else {
					echo '<br>';
				}
			?>
			<div class="container-fluid">
		        <div class="animated fadeIn">
		        	<h4 class="text-theme">Galería Fotográfica Trivias - <?php echo $tr; ?></h4>
		        	<div class="row" >
		        		<div class="col-md-12" style=' padding-right: 5px; padding-left: 5px;' >
		        			<div class="card card-pm-summary bg-theme" style="margin-bottom: 0.5rem;">
		        				<div class="card-body" style="padding: 0.8rem;">
		        					<div class="row">
		        						 <div class="col-md-12">
		        							<div class="row">
		        								<div class="col-md-10">
		        									<div class="card-body" style="padding: 0.3rem;">
			        									<div class="h3 text-white" id="">
			        										<i class="mdi mdi-image-filter"></i>
			        										<?php if (isset($fotos) && count($fotos)>0){ echo $fotos[0]["total"]; } else { echo "0";}?>
			        										<small style=" text-transform: uppercase; font-size: 60%;">Total de Imágenes</small>
			        									</div>
			        									<div class="h3 text-white" id="">
			        										<i class="mdi mdi-book-multiple-variant"></i>
			        										<?php if (isset($fotos) && count($fotos)>0){ echo $fotos[0]["trivias"]; } else { echo "0";}?>
			        										<small style=" text-transform: uppercase; font-size: 60%;">Total de Trivias</small>
			        									</div>
			        								</div>
		        								</div>
		        								<div class="col-md-2">
				        							<div class="card-body"  style="padding: 0.3rem;">
				        								<div class="btn-group-vertical btn-group-sm">
				        									<a href="<?php echo site_url(); ?>Adm_ModuloTrivia/galeria/<?php echo $link;?>?view=<?php echo $view; ?>"  class="btn btn-sm btn-dark" style="margin-top: 0; margin-bottom: 0.3rem;"   ><i class="fa fa-calendar"></i>Cambiar Mes&nbsp;&nbsp;</a>
					        							<?php if (isset($fotos) && count($fotos)>0){ ?>
					        								<button class="btn btn-sm btn-dark" style="margin-top: 0;"  data-toggle='modal' data-target='#modalppt' onclick="limpiarreport()" ><i class="fa fa-download"></i>Reporte Fotos&nbsp;&nbsp;</button>
					        							<?php   } ?>
					        							<?php if (isset($fotos) && count($fotos)>0){ ?>
					        								<!-- <button class="btn btn-sm btn-dark" style="margin-top: 0;"  data-toggle='modal' data-target='#modalmail' onclick="limpiarreport()" ><i class="fa fa-send"></i>Enviar Reporte</button>-->
					        							<?php   } ?>
					        							</div>
				        							</div>
				        						</div>
		        							</div>
		        						</div> 
		        					</div>
		        				</div>
		        			</div>
		        		</div>
		        	</div>
		        	<div class="row" >
		        		<form class="col-md-11" id="formfoto" method="POST" action="<?php echo site_url(); ?>Adm_ModuloTrivia/galeria/<?php echo $link;?>?view=<?php echo $view; ?>" >
		        			<input type="hidden" name="opcion"  id="opcion" value="<?php echo $opcion; ?>">
		        			<input type="hidden" name="lb_anio"  id="lb_anio" value="<?php echo $mes; ?>">
		        			<div class="row">
		        				<div class="col-md-2 column-3">
				        			<select class="form-control select" id="trivia" name="trivia" style="width: 100%">
				        				<?php
					        				if($trivia==0){ echo '<option value="" >Ficha</option>'; }
				        				?>
				        			</select>
				        		</div>
				        		<div class="col-md-2 column-3">
				        			<select class="form-control select" id="zona" name="zona" style="width: 100%">
				        				<?php
					        				if($zona==0){ echo '<option value="" >Zona</option>'; }
				        				?>
				        			</select>
				        		</div>
				        		<div class="col-md-2 column-3">
				        			<select class="form-control select" id="territorio" name="territorio" style="width: 100%">
				        				<?php
					        				if($territorio==0){ echo '<option value="" >Territorio</option>'; }
				        				?>
				        			</select>
				        		</div>
				        		<div class="col-md-2 column-3">
				        			<select class="form-control select" id="depto" name="depto" style="width: 100%">
				        				<?php
					        				if($depto==0){ echo '<option value="" >Departamento</option>'; }
				        				?>
				        			</select>
				        		</div>
				        		<div class="col-md-2 column-3">
				        			<select class="form-control select" id="provincia" name="provincia" style="width: 100%">
				        				<?php
					        				if($provincia==0){ echo '<option value="" >Provincia</option>'; }
				        				?>
				        			</select>
				        		</div>
				        		<div class="col-md-2 column-3">
				        			<select class="form-control select" id="distrito" name="distrito" style="width: 100%">
				        				<?php
					        				if($distrito==0){ echo '<option value="" >Distrito</option>'; }
				        				?>
				        			</select>
				        		</div>
				        		<div class="col-md-2 column-3">
				        			<select class="form-control select" id="cadena" name="cadena" style="width: 100%">
				        				<?php
					        				if($cadena==0){ echo '<option value="" >Cadena</option>'; }
				        				?>
				        			</select>
				        		</div>
				        		<?php
				        			if(isset($canal)){
				        				echo '<div class="col-md-2 column-3" style="width: 100%">
				        					<select class="form-control select" id="canal" name="canal">';
				        					if($canal==0){ echo '<option value="" >Canal</option>'; }
				        				echo'</select>
				        				</div>';
				        			}
				        		?>
				        		<div class="col-md-2 column-3">
				        			<select class="form-control select" id="local" name="local" style="width: 100%">
				        				<?php
					        				if($local==0){ echo '<option value="" >Local</option>'; }
				        				?>
				        			</select>
				        		</div>
				        		<div class="col-md-3 column-3">
				        			<input type="text" class="form-control select" id="fecha_registro" name="fecha_registro" style="background-color: white;" readonly>
				        		</div>
		        			</div>
		        		</form>
		        		<form class="col-md-1"  method="POST" action="<?php echo site_url(); ?>Adm_ModuloTrivia/galeria/<?php echo $link;?>?view=<?php echo $view; ?>" style="padding-left: 0px;">
		        			<input type="hidden" name="lb_anio"  id="lb_anio" value="<?php echo $mes; ?>">
		        			<div class="btn-group mr-2">
		        				<!-- <button type="submit" class="btn btn-sm btn-theme pull-left"><i class="fa fa-search"></i></button> -->
			        			<button type="submit" title="Borrar Búsqueda" class="btn btn-sm btn-theme pull-left"><i class="fa fa-refresh"></i></button>
			        		</div>
		        		</form>
		        	</div>
		        	<div class="row " >
		     			<div class="col-md-12">
		     				<div class="row pull-right">
		     					<?php	if(isset($opcion) && count($fotos)>0){             
				       				echo "<div class='col-md-12'>
				       				<nav >
				       				<ul class='pagination'>";
				       				if($opcion!=1){
				       					echo "<li class='page-item'><a class='page-link bg-danger text-white' onclick='page(".($opcion-1).")'  > Anterior</a></li>";
				       				}
				       				if(($opcion-2)>0){
				       					echo "<li class='page-item'><a class='page-link bg-theme text-white' onclick='page(".($opcion-2).")' >".($opcion-2)."</a></li>";
				       				}
				       				if(($opcion-1)>0){
				       					echo "<li class='page-item'><a class='page-link bg-theme text-white' onclick='page(".($opcion-2).")' >".($opcion-1)."</a></li>";
				       				}   

				       				echo "<li class='page-item active'><a class='page-link text-theme'  onclick='page(".($opcion).")'  ><span class='text-danger'>$opcion</span></a></li>";


				       				if(($opcion+1)<=$cantidad){
				       					echo "<li class='page-item'><a class='page-link bg-theme text-white'onclick='page(".($opcion+1).")' >".($opcion+1)."</a></li>";
				       				}
				       				if(($opcion+2)<=$cantidad){
				       					echo "<li class='page-item'><a class='page-link bg-theme text-white' onclick='page(".($opcion+1).")'>Siguiente </a></li>";
				       				}
				       				echo "</ul>
		       					</nav></div>";
				       			}   
				       			 ?>
		     				</div>
		     			</div>
		     		</div>
					<div class="row">
		     			<div class="col-md-12">
		     				<ul class="popup-gallery" style="padding-left:0.2rem;">
		     					<div class="row">
		     						<?php
		     							foreach ($fotos as $f) {
		     								echo '<div class="col-md-3">
		     									<div class="card ecom-widget-sales border-danger mb-3">
		     										<div class="card-body" style="padding: 1rem;">
		     											<a href="'.$f["foto"].'" >
		     												<img src="'.$f["foto"].'" width="150" height="150" class="card-img-top" title="Pregunta: '.$f["titulopreguntaestatica"].'" 
		     													detfoto="Usuario: '.$f["usuario"].'    -    Fecha Registro: '.$f["fecha_registro"].'    -    Local: '.$f["nombrelocal"].'    -    Pregunta: '.$f["titulopreguntaestatica"].'">
		     											</a>
		     											<table class=" products-widget table">
		     												<tr >
		     													<td class="document" style="padding-top: 0.7rem;">
		     														<div class="heading">Trivia <span>'.$f["nombre"].'</span></div>
		     													</td>
		     													<td class="document" style="padding-top: 0.7rem;">
		     														<div class="heading">Fecha Registro <span>'.$f["fecha_registro"].'</span></div>
		     													</td>
		     												</tr>
		     												<tr>
		     													<td class="document">
		     														<div class="heading">Usuario <span>';
		     														if(strlen($f["usuario"])<20){
		     															echo $f["usuario"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		     														} else {
		     															echo $f["usuario"].'&nbsp;&nbsp;';
		     														}		     														
		     														echo '</span></div>
		     													</td>
		     													<td class="document">
		     														<div class="heading">Local <span>';
		     														if(strlen($f["nombrelocal"])<20){
		     															echo $f["nombrelocal"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		     														} else {
		     															echo $f["nombrelocal"].'&nbsp;&nbsp;';
		     														}
		     														echo '</span></div>
		     													</td>
		     												</tr>
		     												<tr>
		     													<td colspan="2" class="document">
		     														<div class="heading">Pregunta <span>'.$f["titulopreguntaestatica"].'</span></div>
		     													</td>
		     												</tr>
		     											</table>
		     										</div>
		     									</div>
		     								</div>';
		     							}
		     						?>
		     					</div>
		     				</ul>
		     			</div>
		     		</div>
		     		<div class="row pull-right" >
		       			<?php	if(isset($opcion) && count($fotos)>0){             
		       				echo "<div class='col-md-12'>
		       				<nav >
		       				<ul class='pagination'>";
		       				if($opcion!=1){
		       					echo "<li class='page-item'><a class='page-link bg-danger text-white' onclick='page(".($opcion-1).")'  > Anterior</a></li>";
		       				}
		       				if(($opcion-2)>0){
		       					echo "<li class='page-item'><a class='page-link bg-theme text-white' onclick='page(".($opcion-2).")' >".($opcion-2)."</a></li>";
		       				}
		       				if(($opcion-1)>0){
		       					echo "<li class='page-item'><a class='page-link bg-theme text-white' onclick='page(".($opcion-2).")' >".($opcion-1)."</a></li>";
		       				}   

		       				echo "<li class='page-item active'><a class='page-link text-theme'  onclick='page(".($opcion).")'  ><span class='text-danger'>$opcion</span></a></li>";


		       				if(($opcion+1)<=$cantidad){
		       					echo "<li class='page-item'><a class='page-link bg-theme text-white'onclick='page(".($opcion+1).")' >".($opcion+1)."</a></li>";
		       				}
		       				if(($opcion+2)<=$cantidad){
		       					echo "<li class='page-item'><a class='page-link bg-theme text-white' onclick='page(".($opcion+1).")'>Siguiente </a></li>";
		       				}
		       				echo "</ul>
		       					</nav></div>";
		       			}  
		       			?>
		     		</div> 
		        </div>
		    </div>
		</main>
	</div>
	<div class="modal fade" id="modalppt"  role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" id="formreport" method="post" action="">
                <div class="modal-header">
                    <h6 class="modal-title">Reporte Fotografias</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                   </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-12">Seleccione trivia, tipo de reporte y presione descargar.</label>
                                <div class="col-md-12">
                                	<span class="help-block">Los reportes disponibles sólo muestran las últimas 50 fotos de la trivia seleccionada.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" id="lb_trivia" name="lb_trivia" style="width: 100%">
                            	<option value="">Seleccione Trivia</option>
                            </select>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group row">
	            				<div class="col-md-12 custom-controls-stacked d-block my-3">
	            					<label class="custom-control custom-radio"><input type="radio" class="custom-control-input" id="rad_reporte1" name="rad_reporte" value="1">
		            					<span class="custom-control-indicator"></span>
	                                    <span class="custom-control-description">Reporte PDF</span>
	                                </label>
	            					<label class="custom-control custom-radio"><input type="radio" class="custom-control-input" id="rad_reporte2" name="rad_reporte" value="0">
	            						<span class="custom-control-indicator"></span>
	                                    <span class="custom-control-description">Presentación Power Point</span>
	            					</label>
	            				</div>
	            			</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                	<div class="btn-group">
                		<button type="button" onclick="reporte();" class="btn btn-sm btn-theme"><i class='fa fa-download'></i>Descargar</button>
                	</div>
                </div>
            </form>
        </div>
    </div>
</body>
<script type="text/javascript">

	$(function(){

		

		$('#fecha_registro').daterangepicker({
		    "opens": "left",
	    	"applyButtonClasses": "btn-danger",
	    	<?php 
	    	if (isset($fotos) && count($fotos)>0){ 
	    		if($fecha!=0){
	    			$date=explode(' - ', $fecha);
	    			echo '"startDate": "'.date("d-m-Y",strtotime($date[0])).'", "endDate": "'.date("d-m-Y",strtotime($date[1])).'", '; 
	    		} else {
					echo '"startDate": "'.date("d-m-Y",strtotime($fotos[0]["fecha_min"])).'", "endDate": "'.date("d-m-Y",strtotime($fotos[0]["fecha_max"])).'", '; 
	    		}    		
	    	} else { 
	    		if($fecha!=0){
	    			$date=explode(' - ', $fecha);
	    			echo '"startDate": "'.date("d-m-Y",strtotime($date[0])).'", "endDate": "'.date("d-m-Y",strtotime($date[1])).'", '; 
	    		} else {
					echo '"startDate": "'.date("d-m-Y").'", "endDate": "'.date("d-m-Y").'",';
	    		}     		
	    	} 
	    	?>
	    	"locale": {
		        "format": "DD/MM/YYYY",
		        "separator": " - ",
		        "applyLabel": "Seleccionar",
		        "cancelLabel": "Cancelar",
		        "fromLabel": "From",
		        "toLabel": "To",
		        "customRangeLabel": "Custom",
		        "weekLabel": "W",
		        "daysOfWeek": [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá" ],
		        "monthNames": [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
		        "firstDay": 1
		    }
		 }, function(start, end, label) {
		   //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});

		$('#fecha_registro').on('apply.daterangepicker', function(ev, picker) {
		  $('#formfoto').submit();
		});


		$('.popup-gallery').magnificPopup({
	        delegate: 'a',
	        type: 'image',
	        tLoading: 'Loading image #%curr%...',
	        mainClass: 'mfp-img-mobile',
	        gallery: {
	            enabled: true,
	            navigateByImgClick: true,
	            preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
	        },
	        image: {
	            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
	            titleSrc: function (item) {
	                return item.el.attr('detfoto');
	            }
	        }
	    });

	    <?php
	    	if(isset($canal)){
				$filtros=array("trivia","zona","territorio","depto","provincia","distrito","cadena","canal","local");
				echo 'var fil="&trivia='.$trivia.'&zona='.$zona.'&territorio='.$territorio.'&depto='.$depto.'&provincia='.$provincia.'&distrito='.$distrito.'&cadena='.$cadena.'&local='.$local.'&fecha_registro='.$fecha.'&canal='.$canal.'&lb_anio='.$mes.'";';
			} else {
				$filtros=array("trivia","zona","territorio","depto","provincia","distrito","cadena","local");
				echo 'var fil="&trivia='.$trivia.'&zona='.$zona.'&territorio='.$territorio.'&depto='.$depto.'&provincia='.$provincia.'&distrito='.$distrito.'&cadena='.$cadena.'&local='.$local.'&fecha_registro='.$fecha.'&lb_anio='.$mes.'";';
			}
			foreach ($filtros as $f) {
				echo '$.post("'.site_url().'Adm_ModuloTrivia/listar'.$f.'","tr='.$link.'&v='.$view.'"+fil,function (data){';
				echo'for(var i in data){';
				switch ($f) {
					case 'trivia':
						$append=' $("#'.$f.'").append(\'<option value="\'+data[i].id_trivia+\'"   >\'+data[i].nombre+\'</option>\'); ';
						$index= ($trivia!=0) ? '$("#'.$f.'").val("'.$trivia.'"); ' : '';				
						break;
					case 'zona':
						$append='  $("#'.$f.'").append(\'<option value="\'+data[i].id+\'"  >\'+data[i].nombre+\'</option>\');  ';
						$index= ($zona!=0) ? '$("#'.$f.'").val("'.$zona.'"); ' : '';
						break;
					case 'territorio':
						$append='   $("#'.$f.'").append(\'<option value="\'+data[i].id+\'"  >\'+data[i].nombre+\'</option>\');  ';
						$index= ($territorio!=0) ? '$("#'.$f.'").val("'.$territorio.'"); ' : '';
						break;
					case 'depto':
						$append='   $("#'.$f.'").append(\'<option value="\'+data[i].id+\'"   >\'+data[i].nombre+\'</option>\');  ';
						$index= ($depto!=0) ? '$("#'.$f.'").val("'.$depto.'"); ' : '';
						break;
					case 'provincia':
						$append='    $("#'.$f.'").append(\'<option value="\'+data[i].id+\'" >\'+data[i].nombre+\'</option>\');  ';
						$index= ($provincia!=0) ? '$("#'.$f.'").val("'.$provincia.'"); ' : '';
						break;
					case 'distrito':
						$append='  $("#'.$f.'").append(\'<option value="\'+data[i].id+\'"   >\'+data[i].nombre+\'</option>\');  ';
						$index= ($distrito!=0) ? '$("#'.$f.'").val("'.$distrito.'"); ' : '';
						break;
					case 'cadena':
						$append='   $("#'.$f.'").append(\'<option value="\'+data[i].id+\'"   >\'+data[i].nombre+\'</option>\');  ';
						$index= ($cadena!=0) ? '$("#'.$f.'").val("'.$cadena.'"); ' : '';
						break;
					case 'canal':
						$append='   $("#'.$f.'").append(\'<option value="\'+data[i].id+\'"   >\'+data[i].nombre+\'</option>\');  ';
						$index= ($canal!=0) ? '$("#'.$f.'").val("'.$canal.'"); ' : '';
						break;
					case 'local':
						$append='    $("#'.$f.'").append(\'<option value="\'+data[i].id+\'"   >\'+data[i].nombre+\'</option>\');  ';
						$index= ($local!=0) ? '$("#'.$f.'").val('.$local.'); ' : '';
						break;
				}
				echo $append.' '.$index.' }
				$("#'.$f.'").select2(); },"json");';
			}	   

	    ?>

	    		        			


	    $("#rad_reporte1").click(function(){
	    	if($('#rad_reporte1').is(':checked')){
				$("#formreport").attr('action','<?php echo site_url(); ?>Adm_ModuloTrivia/pdf/<?php echo $link;?>');
			} 	    	
	    });

	    $("#rad_reporte2").click(function(){
	    	if($('#rad_reporte2').is(':checked')){
				$("#formreport").attr('action','<?php echo site_url(); ?>Adm_ModuloTrivia/powerpoint/<?php echo $link;?>');
			} 	    	
	    });

	    $('#lb_trivia').select2({
	     	ajax:{
				url:"<?php echo base_url("Adm_ModuloTrivia/listartriviasestaticas"); ?>",
				type: "POST",
				data:"tr=<?php echo $link; ?>&v=<?php echo $view; ?>&lb_anio=<?php echo $mes; ?>",
				dataType:"json",
				delay: 350,
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id: obj.id_trivia, text: obj.nombre };						
						})
					};
				},
				cache: true
			}
		});

	 });

	function page(num){
		if(num==0){
			$('#opcion').val(1);
		} else {
			$('#opcion').val(num);
		}		
		$('#formfoto').submit();
	}

	function reporte(){
		if(document.getElementById("lb_trivia").value==""){
			alert("Debes seleccionar una trivia para continuar");
			document.getElementById("lb_trivia").focus();
		} else if(document.getElementById("rad_reporte1").checked==false && document.getElementById("rad_reporte2").checked==false){
			alert("Debes seleccionar un tipo de reporte para continuar");
			document.getElementById("rad_reporte1").focus();
		} else {
			$("#formreport").submit();
		}
	}

	function limpiarreport(){
		$("#lb_trivia").val('').trigger("change");
		document.getElementById("rad_reporte1").checked=false;
		document.getElementById("rad_reporte2").checked=false;
	}

	<?php
		foreach ($filtros as $f) {
			echo '$("#'.$f.'").change(function(){ $("#formfoto").submit(); });
			';
		}
	?>

	


</script>
<style type="text/css">

	<?php
		if(!isset($_SESSION["sesion"])){
			echo '.sidebar-fixed .main, .sidebar-fixed .app-footer {
			    margin-left: 0px;
			}';
		} else {
			echo '.sidebar-fixed .main, .sidebar-fixed .app-footer {
			    margin-left: 250px;
			}';
		}

	?>

	.products-widget .document .heading span {
	    color:#536c79 !important;
	    display:block;
	    width:100%;
	    word-wrap:break-word;
	    font-size: 0.55rem;
	    margin-bottom: 0px;
  	}

  	.products-widget .document .heading {
  		font-size: 0.55rem;
  		 color:#F03434 !important;
  		 font-weight: 800;
  	}

  	.products-widget .document {
    	padding-top: 0.2rem
    }

  	.table{
  		margin-bottom: 0px;
  	}

  	.table td{
  		padding: 0.2rem;
  		border-top-color: transparent;
  		border-top-width: 0px;
  	}

  	.form-control{
  		font-size: 0.8rem;
  	}

  	.page-item.active .page-link{
		background-color: white;
		border-color: #F03434;
	}

	li{
		cursor: pointer;
	}


	.page-link span{
		font-size: 0.75rem;
		font-weight: 800;
	}


	.property-list-details ul {
	    list-style: none;
	    padding-left: 0;
	}

	.property-list-details ul li {
	    display: inline-block;
	    padding-right: 1.25rem;
	}

	.custom-control-input:checked ~ .custom-control-indicator {
    	color: #fff;
	    background-color: #F03434;
	}

	.column-3{
		padding-right: 10px;
		padding-left: 10px;
	}

	.select {
		font-size: 0.8rem !important;
		max-height: 30px !important;
		min-height: 30px !important;
		margin-bottom: 0.5em !important;
	}

	.select2-selection__rendered{
		font-size: 0.8rem !important;
	}

	.select2-container--default .select2-selection--single{
		max-height: 30px !important;
		min-height: 30px !important;
		padding: 2px;
		font-size: 0.8rem!important;
	}

	.select2-results__options{
		font-size: 0.8rem!important;
	}

	.select2{
		margin-bottom: 0.5em !important;
	}
	
</style>