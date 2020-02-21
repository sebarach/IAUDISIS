<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
             <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Tareas</a>
        </li>
    </ol>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="mdi mdi-arrow-right-drop-circle"></i> Paso 1 
            </div>
            <div class="card-body">
                <h5 class="card-title">Plantilla para asignación masiva de tareas</h5>
                <p class="card-text">Para poder ingresar tareas de manera masiva a través de un Excel. Debemos tener la plantilla con las columnas bien definidas para que la plataforma valide e ingrese sin problemas.</p>
                <br>   
                <form method="POST" action="generarExcel">                 
            <button type="submit" class="btn btn-theme" title='Descargar Plantilla'><i class="mdi mdi-file-excel"></i> Descargar Plantilla</button>
            </form>
        	</div>
	        <div class="card-footer text-muted">
	           
	        </div>
		</div>
	</div>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <h3 class="text-theme">Asignar Tarea</h3>
                <small>Módulo de tareas. Este módulo está hecho para asignar tareas</small>
                <br><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-theme">
                            <div class="card-body">
                                <div class="form-group">
                                	<div class="table-responsive">
                                        <table id="example" class="table color-bordered-table danger-bordered-table"  width="100%">
                                            <thead>
                                                <tr>
                                                    <th><i class="mdi mdi-clipboard-text"></i>&nbsp;&nbsp;Tarea</th>
                                                    <th><i class="mdi mdi-file-document-box"></i>&nbsp;&nbsp;Tipo</th>
                                                    <th><i class="mdi mdi-layers"></i>&nbsp;&nbsp;Estado</th>
                                                    <th><i class="mdi mdi-note-multiple"></i>&nbsp;&nbsp;Formularios</th>
                                                    <th><i class="mdi mdi-playlist-check"></i>&nbsp;&nbsp;Asignación</th>
                                                </tr>
                                            </thead>
                                            <?php 
                                            $contador=1;
                                            foreach ($ListaTarea as $l) { ?>
                                            <tbody>
                                                <tr>
                                                    <td><strong><?php echo $l["NombreTarea"];?></strong></td>
                                                    <td><strong><?php echo $l["Tipo_Tarea"];?></strong></td>
                                                    <td><strong><?php if ($l["EstadoT"]=='NO ASIGNADO') {
                                                    	echo $l["EstadoT"]; ?>&nbsp;<i class="fa fa-close text-danger"></i> 
                                                    <?php }else{ 
                                                    	echo $l["EstadoT"]; ?>&nbsp;<i class="mdi mdi-check text-success"></i>
                                                    <?php } ?>
                                                	</strong></td>
                                                    <td class="text-nowrap" style="padding-top:0px; padding-left: 0px;">
                                                    	<?php if ($l["Estado"]==0) { ?>
                                                       <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-Ver-Form" onclick='verFormularios("<?php echo $l["ID_Tarea"];?>");' disabled><i class="mdi mdi-eye"></i></button>
                                                    <?php }else{ ?>
                                                    	<button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-Ver-Form" onclick='verFormularios("<?php echo $l["ID_Tarea"];?>");'><i class="mdi mdi-eye"></i></button>
                                                    <?php if($l["Tipo_Tarea"]!='Formulario Especial') {?>
                                                    	<button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-Editar-Form" onclick='editarFormularios("<?php echo $l["ID_Tarea"];?>");'><i class="mdi mdi-pencil-box-outline"></i></button>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    </td>
                                                    <td class="text-nowrap" style="padding-top:0px; padding-left: 0px;">
                                                    	<?php if ($l["Estado"]==0) { ?>
	                                                    	<form action="IngExcelTarea" method='POST' id="IngresarExcel" name="IngresarExcel" enctype="multipart/form-data">
	                                                    		<input type="hidden" name="txt_contador" id="txt_contador" value="<?php echo $contador;?>">
	                                                    		<input type="hidden" name="txt_id_tarea" id="txt_id_tarea" value="<?php echo $l["ID_Tarea"];?>">
	                                                        	<input type="file" class="btn btn-xs btn-danger" name="excelv-<?php echo $contador;?>" id="excelv-<?php echo $contador;?>">
	                                                        	<button type="submit" class="btn btn-round btn-danger">
	                                        					<i class="fa fa-upload"></i></button>
	                                                        </form>
	                                                    <?php }else{ ?>
		                                                    	<button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-Ver-User-Local" onclick='verUserLocal("<?php echo $l["ID_Tarea"];?>");'>
		                                        					<i class="mdi mdi-account-check"></i>&nbsp;Ver Usuarios y Locales Asignados</button>
		                                        					<?php if ($l["Activo"]==1) { ?>
		                                        						<button type="button" class="btn btn-success" onclick='activarForm("<?php echo $l["ID_Tarea"]?>","<?php echo $l["Activo"];?>");'><i class="mdi mdi-check"></i></button>
		                                        						<button type="button" class="btn btn-danger"  data-toggle="modal" data-target=".bs-example-modal-Editar-Tarea" onclick='editarTarea("<?php echo $l["ID_Tarea"]?>");'>
		                                        						<i class="mdi mdi-pencil-box-outline"></i>Editar</button>
		                                        					<?php }else{ ?>
		                                        						<button type="button" class="btn btn-danger" onclick='activarForm("<?php echo $l["ID_Tarea"]?>","<?php echo $l["Activo"];?>");'><i class="mdi mdi-block-helper"></i></button>
		                                        					<?php } ?>				
                                                    </td>
                                                </tr>
                                            </tbody>
                                        <?php $contador++; } }?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

<div class="container-fluid">
	<div class="animated fadeIn">
		<h3 class="text-theme">Asignación de Tarea a Usuario Unitario</h3>
			<form method="POST" action="asignarTareaUnitario">
		    <div class="row">
		        <div class="col-md-12">
		            <div class="card card-accent-theme">
		                <div class="card-body">
		                	<div class="row">
		                        <div class="col-md-12">
		                            <div class="form-group">
		                                <label for="company">Tarea</label>
		                                <div class="input-group">
		                                    <span class="input-group-addon">
		                                            <i class="mdi mdi-format-list-bulleted-type"></i>
		                                    </span>
		                                        <select id="msltTarea" name="msltTarea" class="form-control form-control-sm" onchange="elegirTarea();">
		                                            <option value="">Seleccione tarea</option>
		                                            <?php
		                                                foreach ($ListaTareaNoAsignada as $l) {
		                                                echo "<option value='".$l['ID_Tarea']."'>".$l['NombreTarea']."</option>";
		                                            }?>
		                                        </select>
		                                </div>

		                                <div id="errormsltTarea" style="color: red; display: none;">
	                                           Debe elegir la tarea...
	                                    </div>
		                            </div>
		                        </div>
		                    </div>
		                    <input type="hidden" name="txt_tipoTarea" id="txt_tipoTarea">
		                    <div class="row">
		                        <div class="col-md-10">
		                            <div class="form-group">
		                            	<input type="hidden" name="txt_validador" id="txt_validador" value="1">
		                                <label for="company">Usuario</label>
		                                <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-o"></i></span>
                                                <select id="msltUsuario" class="form-control select2" data-plugin="select2" multiple  id="txt_user[]" name="txt_user[]" style="width: 100%;">
                                                    <?php
	                                                foreach ($Usuarios as $u) {
	                                                echo "<option value='".$u['id_usuario']."'>".$u['Nombres']."</option>";
	                                            }?>
                                                </select> 
                                        </div>

		                                <div id="errormsltUsuario" style="color: red; display: none;"  >
	                                           Debe elegir a lo menos un usuario...
	                                    </div>
		                            </div>
		                        </div>

		                        <div class="col-md-2" style="padding-top: 35px;">
		                        	<label for="control-demo-1">
	                                    <div class="checkbox abc-checkbox-danger abc-checkbox">
	                                        <input type="checkbox" id="checkGrupoU">
	                                        <label class="check" for="checkGrupoU">Grupo de Usuarios</label>
	                                    </div> 
	                                </label>
		                        </div>

		                        <div class="col-md-10" style="display: none" id="div_grupoU">
		                            <div class="form-group">
		                                <label for="company">Grupo de Usuarios</label>
		                                <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-account-multiple-outline"></i></span>
                                                <select id="msltUsuarioG" class="form-control select2" data-plugin="select2" multiple  id="txt_userGrupo[]" name="txt_userGrupo[]" style="width: 100%;">
                                                <?php
                                                    if(isset($GrupoU)){
		                                                foreach ($GrupoU as $gu) {
		                                                	echo "<option value='".$gu['ID_GrupoUsuario']."'>".$gu['NombreGrupoUsuario']."</option>";
		                                            	}
		                                            }
	                                            ?>
                                                </select> 
                                        </div>

		                                <div id="errormsltUsuarioG" style="color: red; display: none;"  >
	                                        Debe elegir a lo menos un grupo de usuario...
	                                    </div>
		                            </div>
		                        </div>

		                    </div>

		                    <div class="row">
		                        <div class="col-md-10">
		                            <div class="form-group">
		                                <label for="company">Local</label>
		                                <div class="input-group">
		                                    <span class="input-group-addon">
		                                            <i class="mdi mdi-factory"></i>
		                                    </span>
	                                        <select id="msltLocales" class="form-control form-control-sm select2" data-plugin="select2" multiple  id="txt_local[]" name="txt_local[]" disabled>
	                                            <?php
	                                                foreach ($Locales as $l) {
	                                                echo "<option value='".$l['ID_Local']."'>".$l['NombreLocal']."</option>";
	                                            }?>
	                                        </select>
		                                </div>

		                                <div id="errormsltLocales" style="color: red; display: none;"  >
	                                           Debe elegir el local...
	                                    </div>
		                            </div>
		                        </div>

		                        <div class="col-md-2" style="padding-top: 35px;">
		                        	<label for="control-demo-1">
	                                    <div class="checkbox abc-checkbox-danger abc-checkbox">
	                                        <input type="checkbox" id="checkLocal">
	                                        <label for="checkLocal">Local</label>
	                                    </div> 
	                                </label>
		                        </div>
		                    </div>

		                    <div class="col-md-10" style="display: none" id="div_grupoL">
	                            <div class="form-group">
	                                <label for="company">Grupo de Locales</label>
	                                <div class="input-group">
                                        <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                                        <select class="form-control select2" data-plugin="select2" multiple  name="txt_GrupoL[]" id="msltGrupoL" style="width: 100%;">
                                            <?php
                                                if(isset($GrupoL)){
	                                                foreach ($GrupoL as $gu) {
	                                                	echo "<option value='".$gu['ID_Grupolocal']."'>".$gu['NombreGL']."</option>";
	                                            	}
	                                            }
                                            ?>
                                        </select> 
                                    </div>
	                            </div>
	                        </div>

		                    <div class="row">
		                        <div class="col-md-5">
		                        	<label for="company">Fecha Inicio</label>
		                            <div class="input-group date" data-provide="datepicker">
		                            	<div class="input-group-addon">
		                                    <span class="mdi mdi-calendar"></span>
		                                </div>
		                                <input type="text" class="form-control" name="txt_fecha_inicio" id="txt_fecha_inicio">  
		                            </div>
		                        </div>

		                        <div class="col-md-2" style="padding-top: 35px;">
		                        	<label for="control-demo-1">
	                                    <div class="checkbox abc-checkbox-danger abc-checkbox">
	                                        <input type="checkbox" id="checkFecha">
	                                        <label class="check" for="checkFecha">Fecha Fin</label>
	                                    </div> 
	                                </label>
		                        </div>

		                        <div class="col-md-5">
		                        	<label for="company">Fecha Fin</label>
		                            <div class="input-group date" data-provide="datepicker">
		                            	<div class="input-group-addon">
		                                    <span class="mdi mdi-calendar"></span>
		                                </div>
		                                <input type="text" class="form-control" name="txt_fecha_fin" id="txt_fecha_fin" onchange="validarFecha();" disabled>
		                            </div>
		                        </div>
		                    </div>

		                    <div id="errortxt_fecha_inicio" style="color: red; display: none;"  >
	                                   Debe elegir la fecha incial...
	                            </div>

		                    <button type="submit" class="btn btn-danger btn-sm" title="Agregar" onclick="return validarAsignarTarea();"><i class="mdi mdi-account-check"></i>&nbsp;Asignar Tarea</button>  
		                </div>
		            </div>
		        </div>
		    </div>
		</form>
	</div>
</div>

</main>
	<div class="modal fade" id="modal-desactivarTarea" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar Tarea</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado1Tarea"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarTarea').submit();">Desactivar Tarea</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activarTarea" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar Tarea</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sa-icon sa-success animate"></div>
                    <div id="estado2Tarea"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarTarea').submit();">Activar Tarea</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-Ver-Form" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="VerFormularios">
        <div class="modal-dialog ">
            <div class="modal-content" id="VerFormulario">
             
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-Ver-User-Local" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="VerUserLocals">
        <div class="modal-dialog ">
            <div class="modal-content" id="VerUserLocal">
             
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-Editar-Tarea" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="EditarTareas">
        <div class="modal-dialog ">
            <div class="modal-content" id="EditarTarea">
             
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-Editar-Form" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="EditarForms">
        <div class="modal-dialog ">
            <div class="modal-content" id="EditarForm">
             
            </div>
        </div>
    </div>

    <script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
    <script src="<?php echo  site_url(); ?>/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">

    	$('#msltUsuario').select2({});

    	$('#msltLocales').select2({});

    	$('#msltUsuarioG').select2({});

    	$('#msltGrupoL').select2({});

    	function elegirTarea(){
    		var tarea = $("#msltTarea").val();
    		if(tarea!=''){
	    		$.ajax({
		            url: "elegirtarea",
		            type: "POST",
		            data: "tarea="+tarea,
		            success: function(data) {
						if(data==4 || data==5){
							$('#txt_fecha_inicio').prop('disabled','disabled');
							$('#checkLocal').prop('disabled','disabled');
							$('#checkFecha').prop('disabled','disabled');
							$("#div_grupoL").show("slow");
						}else{
							$('#txt_fecha_inicio').prop('disabled',false);
							$('#checkLocal').prop('disabled',false);
							$('#checkFecha').prop('disabled',false);
							$("#div_grupoL").hide("slow");
						}
						$("#txt_tipoTarea").val(data);
		            }
		        })
    		}else{
    			$('#txt_fecha_inicio').prop('disabled',false);
    			$('#checkLocal').prop('disabled',false);
				$('#checkFecha').prop('disabled',false);
				$("#txt_tipoTarea").val("");
				$("#div_grupoL").hide("slow");
    		}
    	}

    	function editarFormularios(idtarea){
    		$.ajax({
	            url: "editarForm",
	            type: "POST",
	            data: "idtarea="+idtarea,
	            success: function(data) {
	              $("#EditarForm").html(data);
	             }
	        })
    	}

    	function editarTarea(idtarea){
    			$.ajax({
	            url: "editarTarea",
	            type: "POST",
	            data: "idtarea="+idtarea,
	            success: function(data) {
	              $("#EditarTarea").html(data);
	             }
	        })
    	}

    	function verFormularios(idform){
	    		$.ajax({
	            url: "VerFormulariosAsignados",
	            type: "POST",
	            data: "idform="+idform,
	            success: function(data) {
	              $("#VerFormulario").html(data);
	             }
	        })
    	}

    	function verUserLocal(idtarea){
    			$.ajax({
	            url: "VerUsuariosLocales",
	            type: "POST",
	            data: "idtarea="+idtarea,
	            success: function(data) {
	              $("#VerUserLocal").html(data);
	             }
	        })
    	}

    	function activarForm(idtarea,estado){
    		$.ajax({
	            url: "ActivarTarea",
	            type: "POST",
	            data: "idtarea="+idtarea+"&estado="+estado,
	            success: function(data) {
	            	if(estado==1){
	            		$("#estado1Tarea").html("");
	                    $("#estado1Tarea").html(data);
	                    $("#modal-activarTarea").modal('hide');
	                    $("#modal-desactivarTarea").modal('show');
	            	}else{
	            		$("#estado2Tarea").html("");
	                    $("#estado2Tarea").html(data);
	                    $("#modal-desactivarTarea").modal('hide');
	                    $("#modal-activarTarea").modal('show');
	            	}
	            }
	        });
    	}

	    	$('#checkLocal').click( function(){
	        if($(this).is(':checked')){
	            $('#msltLocales').prop('disabled',false);
	        }else{
	            $('#msltLocales').prop('disabled','disabled');
	            $('#msltLocales').val('');
	        };
	    });
	    	$('#checkFecha').click( function(){
	        if($(this).is(':checked')){
	            $('#txt_fecha_fin').prop('disabled',false);
	        }else{
	            $('#txt_fecha_fin').prop('disabled','disabled');
	            $('#txt_fecha_fin').val('');
	        };
	    });

	   	function validarFecha(sel){
        if ($('#txt_fecha_inicio').val() > $('#txt_fecha_fin').val()) {
            alertify.error('La fecha de inicio no puede ser mayor a la fecha final');
            $('#txt_fecha_inicio').val('');
            $('#txt_fecha_fin').val('');
        }   
    }

    function validarAsignarTarea(){
			var vacios=0;
		    var valido=true;
		    if($("#msltTarea").val()==''){  
		    $("#msltTarea").attr('class', 'form-control is-invalid');
		    $('#errormsltTarea').show();
		    alertify.error('Debe elegir una tarea'); 
		    vacios+=1;
		} else { 
		    $("#msltTarea").attr('class', 'form-control is-valid');  
		    $('#errormsltTarea').hide(); 
		}

		if($("#msltUsuario").val()=='' && !$("#checkGrupoU").is(':checked')){  
		    $("#msltUsuario").attr('class', 'form-control is-invalid');
		    $('#errormsltUsuario').show();
		    alertify.error('Debe elegir un usuario'); 
		    vacios+=1;
		} else { 
		    $("#msltUsuario").attr('class', 'form-control is-valid');  
		    $('#errormsltUsuario').hide(); 
		}

		$('#checkLocal').click( function(){
		if($(this).is(':checked')){
			if($("#msltLocales").val()==''){  
			    $("#msltLocales").attr('class', 'form-control is-invalid');
			    $('#errormsltLocales').show();
			    alertify.error('Debe elegir un local'); 
			    vacios+=1;
			} else { 
			    $("#msltLocales").attr('class', 'form-control is-valid');  
			    $('#errormsltLocales').hide(); 
				}
			}
		});
		if($("#txt_tipoTarea").val()!=4 && $("#txt_tipoTarea").val()!=5){
			if($("#txt_fecha_inicio").val()==''){  
			    $("#txt_fecha_inicio").attr('class', 'form-control is-invalid');
			    $('#errortxt_fecha_inicio').show();
			    alertify.error('Debe elegir una fecha de inicio'); 
			    vacios+=1;
			} else { 
			    $("#txt_fecha_inicio").attr('class', 'form-control is-valid');  
			    $('#errortxt_fecha_inicio').hide(); 
			}
		}			

		if(vacios>0){ valido=false; }
    	return valido;
    }

    $('#checkGrupoU').click( function(){
        if($(this).is(':checked')){
            $('#msltUsuario').prop('disabled','disabled');
            $("#div_grupoU").slideToggle("slow");
            $('#txt_validador').val(0);
        }else{
            $('#msltUsuario').prop('disabled',false);
            $("#div_grupoU").slideToggle("slow");
            $('#txt_validador').val(1);
        };
    });

    </script>