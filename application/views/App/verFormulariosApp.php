<main class="main">
	<hr>
	<ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
	    <li class='breadcrumb-item '>
        <a href="<?php echo base_url("menu");?>">Menú</a>
    	</li>
    	<li class="breadcrumb-item ">
	        <a href="<?php echo base_url("App_ModuloTareas/elegirTareasAsignadas");?>">Tareas</a>
	    </li>
	    <li class="breadcrumb-item active">
	        Tarea <?php echo $Nombre_tarea; ?>
	    </li>
	</ol>
	<div class="row">
	<div class="col-md-12">
        <div class="card leaderboard">
            <div class="card-header bg-theme ">
                <div class="prefix header">
                    <div class="float-left header-icon">
                        <i class="mdi mdi-pencil-box-outline"></i>
                    </div>
                    <div class="float-right">
                        <div class="header-text">
                            <h4 class="text-white">Formularios</h4>
                            <h6 class="text-white"></h6>
                        </div>

                    </div>
                </div>
            </div>
            <?php if($tipo==1 || $tipo==4){
            foreach ($listaFormulario as $lf) { ?>
            <?php if($lf["EstadoCompletado"]==0){ ?>
            <form method="POST" action="<?php echo site_url();?>App_ModuloFormularios/verFormulario">
            <?php } ?>
            	<input type="hidden" name="tx_form" id="tx_form" value="<?php echo $lf["FK_ID_Formulario"]?>">
            	<div class="row card margin">
            	<?php
				    if($lf["EstadoCompletado"]==1){
				        $button=' <button class="col-md-12 stats-widget-2 bg-white" type="button" >';
				        $icon='<i class="fa fa-check-circle-o" ></i>';
				        $span='<span class="big-icon watermark pull-left text-success">';
				    } else {
				        $button='<button class="col-md-12 stats-widget-2 bg-white" type="submit" >';
				        $icon='<i class="fa fa-pencil-square" ></i>';
				        $span='<span class="big-icon watermark pull-left text-theme">';
				    }
				    echo $button;
				?>
				    	<div class="widget-body  clearfix">	
				    		<?php echo $span; ?>
				    			<?php echo $icon; ?>
				    		</span>
				    		<div class="widget-text col-md-12">
				    			<h5 class="widget-title"><?php echo $lf["NombreFormulario"];?></h5>
				    		</div>           	
				        </div>
				    </button>
            	</div>
	            <input type="hidden" name="txt_id_asignacion" value="<?php echo $asignacion; ?>">
	            <input type="hidden" name="txt_local" value="<?php echo $local; ?>">
			<?php if($lf["EstadoCompletado"]==0){ ?>	            
	        </form>
	    	<?php } ?>
        	<?php } 
	        }

	        if($tipo==5){
            foreach ($listaFormularioEsp as $lf) { ?>
            <?php if($lf["EstadoCompletado"]==0){ ?>
            	<form method="POST" action="<?php echo site_url();?>App_ModuloFormularios/verFormularioEspecial">
            <?php } ?>
            	<input type="hidden" name="tx_form" id="tx_form" value="<?php echo $lf["FK_ID_Formulario"]?>">
            	<div class="row card margin">
            	<?php
				    if($lf["EstadoCompletado"]==1){
				        $button=' <button class="col-md-12 stats-widget-2 bg-white" type="button" >';
				        $icon='<i class="fa fa-check-circle-o" ></i>';
				        $span='<span class="big-icon watermark pull-left text-success">';
				    } else {
				        $button='<button class="col-md-12 stats-widget-2 bg-white" type="submit" >';
				        $icon='<i class="fa fa-pencil-square" ></i>';
				        $span='<span class="big-icon watermark pull-left text-theme">';
				    }
				    echo $button;
				?>
				    	<div class="widget-body  clearfix">	
				    		<?php echo $span; ?>
				    			<?php echo $icon; ?>
				    		</span>
				    		<div class="widget-text col-md-12">
				    			<h5 class="widget-title"><?php echo $lf["NombreFormulario"];?></h5>
				    		</div>           	
				        </div>
				    </button>
            	</div>
	            <input type="hidden" name="txt_id_asignacion" value="<?php echo $asignacion; ?>">
	            <input type="hidden" name="txt_local" value="<?php echo $local; ?>">
			<?php if($lf["EstadoCompletado"]==0){ ?>	            
	        </form>
	    	<?php } ?>
        	<?php } 
	        }
			if ($tipo==3) {
				foreach ($listaTrivia as $lt) { 
					if($lt["Aleatoria"]==1){ ?>
				<form method="POST" action="<?php echo site_url();?>App_ModuloTrivias/verQuiz">
					<input type="hidden" name="txt_id_quiz" id="txt_id_quiz" value="<?php echo $lt["FK_ID_Trivia"]?>">
					<div class="row card margin">
					<?php
			            if($lt["EstadoCompletado"]==1){
			            	$button=' <button class="col-md-12 stats-widget-2 bg-white" type="button" >';
				        	$icon='<i class="fa fa-check-circle-o" ></i>';     		
				        	$span='<span class="big-icon watermark pull-left text-success">';
			            }else{
			            	$button='<button class="col-md-12 stats-widget-2 bg-white" type="submit" >';
				        	$icon='<i class="fa fa-pencil-square" ></i>';
				        	$span='<span class="big-icon watermark pull-left text-theme">';
			            }	
			            echo $button                            
		            ?>
			            	<div class="widget-body  clearfix">	
			            		<?php echo $span; ?>
					    			<?php echo $icon; ?>
					    		</span>
					    		<div class="widget-text col-md-12">
					    			<h4 class="widget-title"><?php  echo $lt["Nombre"]; ?></h4>
					    		</div>           	
					        </div>	
		            	</button>
					</div>
					<input type="hidden" name="txt_id_asignacion" value="<?php echo $asignacion; ?>">
	            	<input type="hidden" name="txt_local" value="<?php echo $local; ?>">
				</form>
				<?php 
					}else{
						?>
							<form method="POST" action="<?php echo site_url();?>App_ModuloTrivias/verQuizEstatico">
								<input type="hidden" name="txt_id_quiz" id="txt_id_quiz" value="<?php echo $lt["FK_ID_Trivia"]?>">
								<div class="row card margin">
								<?php
								// Descomentar para que no se puedan rellenar las trivias mas de una vez
						            if($lt["EstadoCompletado"]==1){
						            	$button=' <button class="col-md-12 stats-widget-2 bg-white" type="button" >';
							        	$icon='<i class="fa fa-check-circle-o" ></i>';     		
							        	$span='<span class="big-icon watermark pull-left text-success">';
						            }else{
						            	$button='<button class="col-md-12 stats-widget-2 bg-white" type="submit" >';
							        	$icon='<i class="fa fa-pencil-square" ></i>';
							        	$span='<span class="big-icon watermark pull-left text-theme">';
						            }	
						            echo $button                            
					            ?>
						            	<div class="widget-body  clearfix">	
						            		<?php echo $span; ?>
								    			<?php echo $icon; ?>
								    		</span>
								    		<div class="widget-text col-md-12">
								    			<h4 class="widget-title"><?php  echo $lt["Nombre"]; ?></h4>
								    		</div>           	
								        </div>	
					            	</button>
								</div>
								<input type="hidden" name="txt_id_asignacion" value="<?php echo $asignacion; ?>">
				            	<input type="hidden" name="txt_local" value="<?php echo $local; ?>">
							</form> 
						<?php
					}
				}
			}

	        ?>            
        </div>
    </div>
</div>

<style type="text/css">
	.stats-widget-2 .big-icon {
		font-size: 3.6rem;
	}

	.stats-widget-2 .widget-body{
		width: 100%;
	}

	.widget-text{
		padding-top:1rem;
	}

	.stats-widget-2{
		    border: 1px solid #c2cfd6;
	}

	.margin{
		margin-bottom: 0rem;
	}

	.widget-title{
		font-size: 1.1rem;
	}

	.text-theme{
		color: #F03434 !important;
	}

	.text-success{
		color: #20bf6b !important;
	}
</style>
                        