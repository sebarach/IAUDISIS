<main class="main">
	<hr>
	<ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
	    <li class="breadcrumb-item ">
	        <a href="<?php echo base_url("menu");?>">Menú</a>
	    </li>
	    <li class="breadcrumb-item active">
	        <a href="">Biblioteca</a>
	    </li>
	</ol>
	

	<div class="container">
		<div class="animated fadeIn">
          <br>
           <div class="row">
                <div class="col-md-12">
                    <div class="card card-property-single">
                    	<?php
                      	foreach ($Carpetas as $c) { ?>
                    	<div class="col-lg-3 col-md-4">
                            <div class="card border-danger text-danger mb-3" style="max-width: 20rem;">
                                <div class="card-header">Fecha Creación: <?php echo $c["Fecha"] ?></div>
                                <div class="card-body">
                                    <form method="POST" action="documentosCarpeta">
                                    	<input type="hidden" value="<?php echo $c["FK_ID_Carpeta"]?>" name="txt_carpeta" id="txt_carpeta">
                                    	<input type="hidden" value="<?php echo $c["Nombre_Carpeta"]?>" name="txt_carpeta_nombre" id="txt_carpeta_nombre">
                                    	<button class="btn" style="background-color: white;"><h5 class="card-title text-danger"><?php echo $c["Nombre_Carpeta"] ?></h5></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                      	<?php
                      	}
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>