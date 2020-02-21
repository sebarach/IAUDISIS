<main class="main">
	<hr>
	<ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url("menu");?>">Menú</a>
        </li>
        
	    <li class="breadcrumb-item ">
	        <a href="<?php echo base_url("App_ModuloPerfilUsuario/verDocumentos");?>">Biblioteca</a>
	    </li>
	    <li class="breadcrumb-item active">
	        Carpeta <?php echo $Nombre_Carpeta ?>
	    </li>
	</ol>
	

	<div class="container">
		<div class="animated fadeIn">
          <br>
           <div class="row">
                <div class="col-md-3" style="padding-left: 90px;">
                    <?php                  
                        foreach ($Archivos as $a) { 
                            if ($a["Formato"]==0){   
                                if ($a["Tipo"]=="jpeg" || $a["Tipo"]=="jpg" || $a["Tipo"]=="png") { ?>
                                    <a href="<?Php echo  site_url('archivos/'.$NombreCliente.'/'.$a["Nombre_Carpeta"].'/'.$a["Archivo"]); ?>" target="_blank" download><i class="mdi mdi-file-image text-primary" style="font-size: 150px;"><h6 style="padding-left: 35px;padding-top: 0px;"><?php echo $a["Nombre_Archivo"] ?></h6></i></a>
                            <?php }elseif($a["Tipo"]=="pdf"){ ?>
                                    <a href="<?Php echo  site_url('archivos/'.$NombreCliente.'/'.$a["Nombre_Carpeta"].'/'.$a["Archivo"]); ?>" target="_blank" download onclick='contarDescarga("<?php echo $Usuario?>","<?php echo $a["ID_Archivo"];?>","<?php echo $a["FK_ID_Carpeta"];?>");'><i class="mdi mdi-file-pdf text-danger" style="font-size: 150px;"><h6 style="padding-left: 35px;padding-top: 0px;"><?php echo $a["Nombre_Archivo"] ?></h6></i></a>
                                    <?php
                                } 
                            }else{ ?>
                                    <a href="<?php echo $a["Enlace"]?>" target="_blank"><i class="mdi mdi-link-variant text-dark" style="font-size: 150px;"><h6 style="padding-left: 35px;padding-top: 0px;"><?php echo $a["Nombre_Archivo"] ?></h6></i></a>
                                <?php
                            }
                        } 
                            ?>
                            
                   <!--  <div class="card card-property-single">
                    	<?php                  
                            foreach ($Archivos as $a) { 
                                if ($a["Formato"]==0){                  
                            ?>
                            <div class="col-md-3 w-50">
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
                                            <a href="<?Php echo  site_url('archivos/'.$NombreCliente.'/'.$a["Nombre_Carpeta"].'/'.$a["Archivo"]); ?>" target="_blank">Descargar</a>
                                        </small>
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
                                    <span class="small-chart " style="display: none;">4,3,5,2,1</span><svg class="peity" height="16" width="32"><rect fill="white" x="0.64" y="3.1999999999999993" width="5.12" height="12.8"></rect><rect fill="white" x="7.040000000000001" y="6.4" width="5.119999999999999" height="9.6"></rect><rect fill="white" x="13.440000000000001" y="0" width="5.119999999999997" height="16"></rect><rect fill="white" x="19.84" y="9.6" width="5.120000000000001" height="6.4"></rect><rect fill="white" x="26.24" y="12.8" width="5.1200000000000045" height="3.1999999999999993"></rect></svg>
                                </footer>
                            </div>
                        </div>
                        <?php
                            } 
                        }
                    ?> 
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">

    function contarDescarga(usuario,archivo,carpeta){
        var contador=1;
        $.ajax({
            url: "contarDescargado",
            type: "POST",
            data: "usuario="+usuario+"&contador="+contador+"&archivo="+archivo+"&carpeta="+carpeta,            
        });
    }

</script>