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
				            <a href="'.site_url().'Adm_ModuloFormulario/crearFormulario">Creación de Formularios</a>
				        </li>
				        <li class="breadcrumb-item">
				        	<a href="'.site_url().'Adm_ModuloFormulario/adminFormulario">Administración de Formularios</a>
				        </li>
				        <li class="breadcrumb-item active">Galería Fotográfica</li>
				    </ol>';
				} else {
					echo '<br>';
				}
			?>
			
		    <div class="container-fluid">
		        <div class="animated fadeIn">
		        	<h4 class="text-theme">Galería Fotográfica - <?php echo $filtros[0]["NombreFormulario"];?> </h4>
		        	<div class="row" >
		        		<div class="col-md-12" style=' padding-right: 5px; padding-left: 5px;' >
		        			<div class="card card-pm-summary bg-theme" style="margin-bottom: 0.5rem;">
		        				<div class="card-body" style="padding: 0.8rem;">
		        					<div class="row">
		        						<div class="col-md-12">
		        							<div class="row">
		        								<div class="col-md-11">
		        									<div class="card-body" style="padding: 0.3rem;">
			        									<div class="h3 text-white">
			        										<i class="mdi mdi-image-filter"></i>
			        										<?php if (isset($fotos) && count($fotos)>0){ echo $fotos[0]["total"]; } else { echo "0";}?>
			        										<small style=" text-transform: uppercase; font-size: 60%;">Total de Imágenes</small>
			        									</div>
			        								</div>
		        								</div>
		        								<div class="col-md-1">
				        							<div class="card-body"  style="padding: 0.3rem;">
				        								<?php if (isset($fotos) && count($fotos)>0){ 
				        									if(isset($Cliente)){
				        									if($NombreCliente=="JSC"){
				        								?>
				        									<button data-toggle='modal' data-target='#modalppt'  style="margin-top: 0;" class="btn btn-dark pull-right"><i class="fa fa-download"></i></button>
				        								<?php

				        									} else {
				        								?>
				        									<a href="<?php echo site_url(); ?>Adm_ModuloFormulario/powerpoint/<?php echo $link;?>" style="margin-top: 0;" class="btn btn-dark pull-right"><i class="fa fa-download"></i></a>
				        								<?php   
				        									}
				        									}
				        									} ?>
				        							</div>
				        						</div>		        								
		        							</div>
		        						</div>
		        						<div class="col-md-12">
		        							<div class="row">
		        								<div class="card-body" style="padding-bottom: 0.6rem;">
		        									<div class="property-list-details">
		        										<div class="h6 text-white" style='text-transform: uppercase;'>
		        											Total de Imágenes por Cadena
		        										</div>
		        										<div class="card-body clearfix" style="padding: 0.3rem;">
			        										<div class="h6 text-white">		
			        											<div class="row">
			        												<?php 
			        												foreach ($cantcadena as $c) {
			        													echo "<div class='col-md-2' style='    padding-right: 0px;' ><i class='mdi mdi-image-filter-none'></i>  <small style='text-transform: uppercase;' >".$c['cantidad']."  ".$c['NombreCadena']." </small>  </div>";									

			        												}

			        												?>
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
		        		</div>
		        	</div>
		        	<form id="formfoto" method="POST" action="<?php echo site_url(); ?>Adm_ModuloFormulario/galeria/<?php echo $link;?>" >
		        		<div class="row card-body" style="padding: 0.5rem;">
		        			<div class="col-md-2" style="padding-right: 5px;">
			        			<div class="card" style="margin-bottom: 0.7rem;">
			        				<div class="clearfix">
			        					<select class="form-control"  id="lbl_cadena" name="lbl_cadena" >
			        						<?php
			        							if($cadena!=0){
			        								echo '<option value="'.$cadena.'" >'.$nom_cadena.'</option>';
			        							} else {
			        								echo '<option value="" >Cadena</option>';
			        							}

			        						?>
			        					</select>
			        				</div>
			        			</div>
			        		</div>		        		
			        		<div class="col-md-2" style="padding-right: 5px;">
			        			<div class="card" style="margin-bottom: 0.7rem;">
			        				<div class="clearfix">
			        					<select class="form-control"  id="lbl_pdv" name="lbl_pdv" >
			        						<?php
			        							if($local!=0){
			        								echo '<option value="'.$local.'" >'.$nom_local.'</option>';
			        							} else {
			        								echo '<option value="" >Local</option>';
			        							}
			        						?> 
			        					</select>
			        				</div>
			        			</div>
			        		</div>
			        		<div class="col-md-2" style="padding-right: 5px;">
			        			<div class="card" style="margin-bottom: 0.7rem;">
			        				<div class="clearfix">
			        					<select class="form-control"  id="lbl_region" name="lbl_region" >
			        						<?php
			        							if($region!=0){
			        								echo '<option value="'.$region.'" >'.$nom_region.'</option>';
			        							} else {
			        								echo '<option value="" >Región</option>';
			        							}
			        						?> 
			        					</select>
			        				</div>
			        			</div>
			        			<input type="hidden" name="opcion"  id="opcion" value="<?php echo $opcion; ?>">
			        		</div>
			        		<div class="col-md-2" style="padding-right: 5px;">
			        			<div class="card" style="margin-bottom: 0.7rem;">
			        				<div class="clearfix">
			        					<select class="form-control"  id="lbl_comuna" name="lbl_comuna" >
			        						<?php
			        							if($comuna!=0){
			        								echo '<option value="'.$comuna.'" >'.$nom_comuna.'</option>';
			        							} else {
			        								echo '<option value="" >Comuna</option>';
			        							}
			        						?> 
			        					</select>
			        				</div>
			        			</div>
			        		</div>
			        		<div class="col-md-3-2" style="padding-right: 5px;">
			        			<div class="card" style="margin-bottom: 0.7rem;">
			        				<div class="clearfix">
			        					<input type="text"  class="form-control"  id="txt_fecha" name="txt_fecha" style="background-color: white;" readonly >
			        				</div>
			        			</div>
			        		</div>
			        		<div class="col-md-1">
			        			<div class="btn-group mr-2">
			        				<button type="submit" class="btn btn-sm btn-theme pull-left"><i class="fa fa-search"></i></button>
				        			<a href="<?php echo site_url(); ?>Adm_ModuloFormulario/galeria/<?php echo $link;?>" title="Borrar Búsqueda" class="btn btn-sm btn-theme pull-left"><i class="fa fa-refresh"></i></a>
				        		</div>
			        		</div>
				        </div>
				    </form>	
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
				       					echo "<li class='page-item'><a class='page-link bg-theme text-white' onclick='page(".($opcion+1).")'>Siguiente </a></li>
				       					</ul>
				       					</nav>";
				       				}
				       			}   
				       			echo"                   
				       			</div>"; ?>
		     				</div>
		     			</div>
		     		</div>
		       		<div class="row">
		       			<div class="col-md-12">
		       				 <ul class="popup-gallery" style="padding-left:0.2rem;">
			       				<div class="row">
			       					<?php 
					       				foreach ($fotos as $f) {
					       					echo "<div class='col-md-3'>
					       						<div class='card ecom-widget-sales border-danger mb-3'>
					       							<div class='card-body' style='padding: 1rem;'>
					       								<a href='".$f["respuesta"]."' title='".$f["NombreLocal"]." - ".$f["NombrePregunta"]."' detfoto='Usuario: ".$f["Nombres"]."    -    Fecha Registro: ".date("d-m-Y",strtotime($f["Fecha_Registro"]))."    -    Local: ".$f["NombreLocal"]."    -    Pregunta: ".$f["NombrePregunta"]."'>
					       									<img src='".$f["respuesta"]."' width='150' height='150' class='card-img-top' >	
					       								</a>	
					       								<div class='row'>
					       									<div class='col-md-6'>
					       										<ul>
							       									<li><br>Usuario <span>".$f["Nombres"]."</span></li>";
							       									if(strlen($f["NombreLocal"])<26){
							       										echo "<li><br>Local <span style='margin-bottom:0.75rem;'>".$f["NombreLocal"]."</span></li>";
							       									} else {
							       										echo "<li><br>Local <span>".$f["NombreLocal"]."</span></li>";
							       									}		       									
							       									
							       					echo"		</ul>
					       									</div>
					       									<div class='col-md-6'  >
						       									<ul>
							       									<li><br>Fecha Registro <span>".date("d-m-Y",strtotime($f["Fecha_Registro"]))."</span> </li>
							       									<li><br>Pregunta <span>".$f["NombrePregunta"]."</span> </li>
							       									
							       								</ul>
					       									</div>
					       								</div>       							
					       							</div>
					       						</div>
					       					</div>";
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
		       					echo "<li class='page-item'><a class='page-link bg-theme text-white' onclick='page(".($opcion+1).")'>Siguiente </a></li>
		       					</ul>
		       					</nav>";
		       				}
		       			}   
		       			echo"                   
		       		</div>"; ?>
		     		</div>
		        </div>
		    </div>
		</main>
	</div>
	<div class="modal fade" id="modalppt"  role="dialog"  aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form class="modal-content" method="post" action="<?php echo site_url(); ?>Adm_ModuloFormulario/powerpoint/<?php echo $link;?>">
				<div class="modal-header">
					<h6 class="modal-title">Reporte Fotografias</h6>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">×</span>
	               </button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Seleccione fecha para generar el reporte de fotografias</label>
							</div>
						</div>
						<div class="col-md-7">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon bg-theme">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" name="txt_fechappt" id="txt_fechappt" class="form-control" style="background-color: white;" readonly>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-theme"><i class='fa fa-download'></i>Descargar</button>
				</div>
			</form>
		</div>
	</div>
</body>

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
	.ecom-widget-sales ul li span{
	    color:#536c79 !important;
	    display:block;
	    width:100%;
	    word-wrap:break-word;
	    font-size: 0.6rem;
  	}

  	.ecom-widget-sales ul li {
  		font-size: 0.6rem;
  		 color:#F03434 !important;
  		 font-weight: 800;
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

	@media (min-width: 768px){
		.col-md-3-2 {
		    flex: 0 0 20%;
		    max-width: 20%;
		}
	}

	
</style>
<script type="text/javascript">

	$(function() {
	  $('#txt_fecha').daterangepicker({
	    "opens": "left",
    	"applyButtonClasses": "btn-danger",
    	<?php 
    	if (isset($fotos) && count($fotos)>0){ 
    		if($fecha!="0"){
    			$date=explode(' - ', $fecha);
    			echo '"startDate": "'.date("d-m-Y",strtotime($date[0])).'", "endDate": "'.date("d-m-Y",strtotime($date[1])).'", '; 
    		} else {
				echo '"startDate": "'.date("d-m-Y",strtotime($filtros[0]["fecha_min"])).'", "endDate": "'.date("d-m-Y",strtotime($filtros[0]["fecha_max"])).'", '; 
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

    $('#lbl_pdv').select2({
    	ajax:{
			url:"<?php echo base_url("Adm_ModuloFormulario/listarlocales"); ?>",
			type: "POST",
			data:"local=<?php echo $link; ?>",
			dataType:"json",
			delay: 350,
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						var id=<?php echo $local; ?>;
						if(id!=obj.id_local){
							return { id: obj.id_local, text: obj.nombrelocal };
						}							
					})
				};
			},
			cache: true
		}

	});

	$('#lbl_cadena').select2({
		ajax:{
			url:"<?php echo base_url("Adm_ModuloFormulario/listarcadenas"); ?>",
			type: "POST",
			data:"cadena=<?php echo $link; ?>",
			dataType:"json",
			delay: 350,
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						var id=<?php echo $cadena; ?>;
						if(id!=obj.id_cadena){
							return { id: obj.id_cadena, text: obj.nombrecadena};
						}							
					})
				};
			},
			cache: true
		}

	});

	$('#lbl_comuna').select2({
		ajax:{
			url:"<?php echo base_url("Adm_ModuloFormulario/listarcomunas"); ?>",
			type: "POST",
			data:"comuna=<?php echo $link; ?>",
			dataType:"json",
			delay: 350,
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						var id=<?php echo $comuna; ?>;
						if(id!=obj.id_comuna){
							return { id: obj.id_comuna, text: obj.comuna };
						}							
					})
				};
			},
			cache: true
		}

	});

	$('#lbl_region').select2({
		ajax:{
			url:"<?php echo base_url("Adm_ModuloFormulario/listarregiones"); ?>",
			type: "POST",
			data:"region=<?php echo $link; ?>",
			dataType:"json",
			delay: 350,
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						var id=<?php echo $region; ?>;
						if(id!=obj.id_region){
							return { id: obj.id_region, text: obj.region };
						}							
					})
				};
			},
			cache: true
		}
	});

     <?php if (isset($fotos) && count($fotos)>0){ 
			if(isset($Cliente)){
				if($NombreCliente=="JSC"){
			?>
			$('#txt_fechappt').daterangepicker({
			    "singleDatePicker": true,
			    "applyButtonClasses": "btn-warning",
			    "autoUpdateInput": false,
			    "locale": {
			        "format": "DD-MM-YYYY",
			        "separator": " - ",
			        "applyLabel": "Seleccionar",
			        "cancelLabel": "Cancelar",
			        "fromLabel": "From",
			        "toLabel": "To",
			        "customRangeLabel": "Custom",
			        "weekLabel": "W",
			       	"daysOfWeek": [  "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá" ],
			        "monthNames": [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
			        "firstDay": 1
			    }
			}, function(chosen_date) {
			  	$('#txt_fechappt').val(chosen_date.format('DD-MM-YYYY'));
			});

			<?php
				}
			}
		}
	?>

	});

	// $('#lbl_pdv').change(function(){
	// 	$('#formfoto').submit();
	// });

	// $('#lbl_cadena').change(function(){
	// 	$('#formfoto').submit();
	// });

	// $('#lbl_comuna').change(function(){
	// 	$('#formfoto').submit();
	// });

	// $('#lbl_region').change(function(){
	// 	$('#formfoto').submit();
	// });

	// $('#txt_fecha').change(function(){
	// 	$('#formfoto').submit();
	// });

	function page(num){
		if(num==0){
			$('#opcion').val(1);
		} else {
			$('#opcion').val(num);
		}
		$('#formfoto').submit();
	}
	
</script>