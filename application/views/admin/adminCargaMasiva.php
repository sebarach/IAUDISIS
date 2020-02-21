<script src="<?php echo  site_url(); ?>assets/libs/dropify/dist/js/dropify.min.js"></script>
<main class="main" style="height: 100%;">
	<ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
             <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Metas y Ventas</a>
        </li>
        <li class="breadcrumb-item active">Carga Masiva Metas y Ventas</li>
    </ol>
     <div class="container-fluid">
     	<div class="animated fadeIn">
     		<h4 class="text-theme">Carga Masiva Metas y Ventas</h4>  		
            <div class="row">
            	<div class="col-md-6">
            		<form  id="formmetas" method="POST" action="<?php echo site_url(); ?>Adm_ModuloMetas/addmetas" enctype="multipart/form-data">
	            		<div class="card border-danger" >            			
	            			<div class="card-body" >
		            			<div class="row">
	            					<div class="col-md-10">
	            						<h5 class="text-danger">Carga Metas </h5>
	            					</div>		            				
	            				</div>
		            			<div class="row">
		            				<div class="col-md-6">
		            					<a href="<?php echo base_url("Adm_ModuloMetas/listmetas");?>" >
		            						<div class="dropify-wrapper" >
		            							<div class="dropify-message">
		            								<div class="ecom-widget-sales">
		            									<div class="ecom-sales-icon text-center">
		            										<i class="mdi mdi-cloud-download"></i>
		            									</div>	
		            									<h6 class="text-danger">Descargar Formato</h6>
		            								</div>								
		            							</div>
		            						</div>
		            					</a>
		            				</div>
		            				<div class="col-md-6">
		            					<input type='file' id="ex_metas"  name="ex_metas" class="dropify" data-default-file=""  onchange="cargarmetas();">
		            				</div>
		            				<div class="col-md-12">
		            					<div class="card-body">
		            						<strong>Progreso</strong>	
			            					<div class="progress">
			            						<div class="progress-bar" role="progressbar" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" style="width: 0%;">0%</div>
			            					</div>   
		            					</div>
		            					<div class="card-header bg-secondary mb-3 text-white" id="div_metas">   
		            						<strong>Estado: Espera de archivo </strong><i id="ingresarExcelSpin" class=""></i> 
		            					</div>       					
		            				</div>
		            			</div>
	            			</div>
	            		</div>
	            	</form>
            	</div>
            	<!-- <div class="col-md-6">
            		<form  id="formventas" method="POST" action="<?php echo site_url(); ?>Adm_ModuloMetas/addventas" enctype="multipart/form-data">
	            		<div class="card border-danger">            			
	            			<div class="card-body">
	            				<div class="row">
	            					<div class="col-md-10">
	            						<h5 class="text-danger">Carga Ventas </h5>
	            					</div>	            				
	            				</div>
		            			<div class="row">
		            				<div class="col-md-6">
		            					<a href="<?php //echo base_url("Adm_ModuloMetas/listventas");?>" >
		            						<div class="dropify-wrapper" >
		            							<div class="dropify-message">
		            								<div class="ecom-widget-sales">
		            									<div class="ecom-sales-icon text-center">
		            										<i class="mdi mdi-cloud-download"></i>
		            									</div>	
		            									<h6 class="text-danger">Descargar Formato</h6>
		            								</div>								
		            							</div>
		            						</div>
		            					</a>
		            				</div>
		            				<div class="col-md-6">
		            					<input type='file' id="ex_ventas"  name="ex_ventas" class="dropify" data-default-file="" >
		            				</div> -->
		            				<!-- <div class="col-md-12">
		            					<div class="card-body">
		            						<strong>Progreso</strong>	
			            					<div class="progress">
			            						<div class="progress-bar" role="progressbar" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" style="width: 0%;">0%</div>
			            					</div>   
		            					</div> 
		            					<div class="card-header bg-secondary mb-3 text-white">   
		            						<strong>Estado: Espera de archivo</strong>
		            					</div>   
		            				</div> -->
		            			</div>
	            			</div>
	            		</div>
	            	</form>
            	</div>
            </div>
     	</div>
     </div>
</main>


<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script type="text/javascript">

	$(function(){
		$(".dropify-message span").removeAttr("class").html('<div class="ecom-widget-sales"><div class="ecom-sales-icon text-center"><i class="mdi mdi-cloud-upload"></i></div></div>');
		$(".dropify-message p").html('<h6 class="text-danger">Subir Archivo<br><small>extensiones xls o xlsx<small></h6>');
	});

	$('.dropify').dropify();
	
</script>
<style type="text/css">
	h6{
		font-size: 0.7rem;
		margin-top: 1rem;
	}

	.ecom-widget-sales .ecom-sales-icon {
		font-size: 4.7rem;
	}

	h5{
		font-size: 1.1rem;
	}

	a{
		text-decoration: none !important;
	}

	.card-body{
		padding: 1rem;
	}

	.card{
		margin-bottom: 0.5rem;
	}
</style>