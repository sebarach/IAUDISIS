<div class="modal fade" id="modalanio"  role="dialog"  aria-hidden="true">
	<div class="modal-dialog" role="document">
            <form class="modal-content" id="formanios" method="post" 
            action="<?php echo site_url().'Adm_ModuloTrivia/galeria/'.$link.'?view='.$view.''; ?>">
                <div class="modal-header">
                    <h6 class="modal-title">Galeria Fotograficas Trivias</h6>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <select class="form-control" id="lb_anio" name="lb_anio" style="width: 100%">
                            	<option value="">Seleccione Mes</option>
                            </select>
                        </div>
                    </div>
                </div>
                 <div class="modal-footer">
                	<div class="btn-group">
                		<button type="button" id="btnAnios" class="btn btn-sm btn-theme"><i class='fa fa-arrow-circle-right'></i>Continuar</button>
                	</div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url("assets/libs/bootbox/bootbox.min.js"); ?>"></script>
<script type="text/javascript">
$(function(){
	<?php

		if($cli==20){
			if($tipotarea==3){
				echo '$.post("'.site_url().'Adm_ModuloTrivia/listartriviasanios","tr='.$link.'&view='.$view.'",function(data){
					for(var i in data){
						$("#lb_anio").append(\'<option value="\'+data[i].value+\'"   >\'+data[i].text+\'</option>\'); 
					}
				},"json");  ';

				echo '$("#modalanio").modal("show");  ';

				echo '$("#btnAnios").click(function(){
				 	if($("#lb_anio").val()==""){
				 		alert("Debe seleccionar un mes para continuar.");
				 	} else {
				 		var dialog = bootbox.dialog({
				 			message: \'<div class="card-body ecom-widget-sales"><div class="ecom-sales-icon text-center"><i class="fa fa-spin fa-spinner"></i><h5 class="text-center">Cargando Galería Fotográfica</h5></div></div>\',
				 			closeButton: false
				 		});
				 		$("#modalanio").modal("hide");
				 		setTimeout(function(){
				 			dialog.modal("hide");
				 			$("#formanios").submit();			 			
				 		 }, 3000);
				 		 
				 	}
				});  ';
			} else {
				echo ' var dialog = bootbox.dialog({
	            	message: \'<div class="card-body ecom-widget-sales"><div class="ecom-sales-icon text-center"><i class="fa fa-spin fa-spinner"></i><h5 class="text-center">Cargando Galería Fotográfica</h5></div></div>\',
	              	closeButton: false
	 	        });
	                    
		 	    dialog.init(function(){
		            setTimeout(function(){
		               	dialog.modal("hide");
		            }, 3100);
		        });';
			}

		} else {
			echo ' var dialog = bootbox.dialog({
            	message: \'<div class="card-body ecom-widget-sales"><div class="ecom-sales-icon text-center"><i class="fa fa-spin fa-spinner"></i><h5 class="text-center">Cargando Galería Fotográfica</h5></div></div>\',
              	closeButton: false
 	        });
                    
	 	    dialog.init(function(){
	            setTimeout(function(){
	               	dialog.modal("hide");
	            }, 3100);
	        });';
		}


	?>	
});

</script>