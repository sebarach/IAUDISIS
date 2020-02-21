
<link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/libs/lightbox/magnific-popup.css">
<link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/libs/animate.css/animate.min.css">


<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="<?php echo site_url(); ?>Adm_ModuloBiblioteca/adminDocumentos">Biblioteca</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">Documentos de <?php echo $Nombre_Carpeta ?></a>
        </li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card card-accent-theme">
                <div class="card-body">
                    <h4 class="text-theme">Documentos de <?php echo $Nombre_Carpeta ?></h4>
                    <div class="row">
                    	<?php                	
                    		foreach ($Archivos as $a) { 
                    			if ($a["Formato"]==0){                 	
                    		?>
	                    	<div class="col-md-3">
	                            <div class="card card-accent-danger stats-widget-1">
	                                <div class="widget-body clearfix">
	                                    <div class="pull-left">
	                                        <h3 class="widget-title text-danger">
	                                            <span class="numscroller roller-title-number-1 scrollzip isShown" data-min="1" data-max="66.136" data-delay="5" data-increment="10" data-slno="1"><?php echo $a["Nombre_Archivo"] ?></span></h3>
	                                        <span class="mytooltip tooltip-effect-5">
	                                            <span style="color: #F03434;background-color: white;" class="tooltip-item">Descripcion</span>
		                                            <span class="tooltip-content clearfix">
		                                                <span class="tooltip-text"><?php echo $a["Descripcion"]; ?>.</span>
		                                            </span>
                                        	</span>
	                                    </div>
	                                    <span class="pull-right big-icon watermark">
	                                    	<?php if ($a["Tipo"]=="jpeg" || $a["Tipo"]=="jpg" || $a["Tipo"]=="png") { ?>
	                                        	<i class="mdi mdi-file-image text-info"></i>
	                                    	<?php }else if($a["Tipo"]=="pptx"){ ?>
	                                    		<i class="mdi mdi-file-powerpoint text-danger"></i>
	                                    	<?php }elseif($a["Tipo"]=="xlsx"){ ?>
	                                    		<i class="mdi mdi-file-excel text-success"></i>
	                                    	<?php }elseif($a["Tipo"]=="pdf"){ ?>
	                                    		<i class="mdi mdi-file-pdf text-danger"></i>
	                                    	<?php }elseif($a["Tipo"]=="docx"){ ?>
	                                    		<i class="mdi mdi-file-word text-primary"></i>
	                                    	<?php }else{ ?>
	                                    		<i class="mdi mdi-file text-primary"></i>
	                                    <?php } ?>
	                                    </span>
	                                </div>
	                                <footer class="widget-footer bg-danger">
	                                    <small class="pull-right">
	                                        <a href="<?Php echo  site_url('archivos/'.$NombreCliente.'/'.$a["Nombre_Carpeta"].'/'.$a["Archivo"]); ?>" target="_blank" download>Descargar</a>
	                                    </small>
	                                    	<input type="hidden" id="txt_id_archivo" name="txt_id_archivo"><a href="#" onclick="eliminarDocumento('<?php echo $a["ID_Archivo"] ?>','<?php echo $a["Nombre_Archivo"] ?>');" data-toggle='modal' data-target=".bs-example-modal-Archivo">Eliminar <i class="fa fa-trash-o"></i></a>
	                                </footer>
	                            </div>
	                        </div>
	                    <?php 	                		
	                    }else{
	                   	?>
	                   	<div class="col-md-3">
	                        <div class="card card-accent-danger stats-widget-1">
                                <div class="widget-body clearfix">
                                    <div class="pull-left">
                                        <h3 class="widget-title text-danger">
                                            <span class="numscroller roller-title-number-1 scrollzip isShown" data-min="1" data-max="66.136" data-delay="5" data-increment="10" data-slno="1"><?php echo $a["Nombre_Archivo"] ?></span></h3>
                                        		<span class="mytooltip tooltip-effect-5">
	                                            <span style="color: #F03434;background-color: white;" class="tooltip-item">Descripcion</span>
		                                            <span class="tooltip-content clearfix">
		                                                <span class="tooltip-text"><?php echo $a["Descripcion"]; ?>.</span>
		                                            </span>
                                        		</span>
                                    </div>
                                    <span class="pull-right big-icon watermark">                	
                                        	<i class="mdi mdi-link-variant text-dark"></i>                                  	
                                    </span>
                                </div>
                                <footer class="widget-footer bg-danger">
                                    <small class="pull-right">
                                        	<a href="<?php echo $a["Enlace"]?>" target="_blank">Ver</a>
                                    </small>
                                    <input type="hidden" id="txt_id_archivo" name="txt_id_archivo"><a href="#" onclick="eliminarDocumento('<?php echo $a["ID_Archivo"] ?>','<?php echo $a["Nombre_Archivo"] ?>');" data-toggle='modal' data-target=".bs-example-modal-Archivo">Eliminar <i class="fa fa-trash-o"></i></a>
                                </footer>
	                        </div>
	                    </div>
	                   	<?php
	                    	} 
	                	}
	                ?>                  
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-Archivo" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="MEliminarArchivos">
        <div class="modal-dialog ">
            <div class="modal-content" id="MEliminarArchivo">
             
            </div>
        </div>
    </div>
</main>

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script type="text/javascript">
	function eliminarDocumento(id_archivo,nombre){
        $.ajax({
            url: "eliminarArchivo",
            type: "POST",
            data: "id_archivo="+id_archivo+"&nombre="+nombre,
            success: function(data) {
                $("#MEliminarArchivo").html(data);
            }
        });
	}
</script>