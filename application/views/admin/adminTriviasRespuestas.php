<style type="text/css">
	::-webkit-scrollbar {
	    width: 5px;
	}
	::-webkit-scrollbar-track {
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
	    border-radius: 10px;
	}
	::-webkit-scrollbar-thumb {
	    border-radius: 10px;
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
	}
</style>
<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
             <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Tareas</a>
        </li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <h3 class="text-theme">Datos Respuestas</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                        	<div class="col-md-12">
			            		<div class="card-body">
			            			<div class="input-group">
		                                <select style="width: 100%;" class="form-control" id="lbl_usuario" name="lbl_usuario" onchange="buscar();">
		                                    <option value="">Usuario</option>
		                                    <?php foreach ($DatosFiltroU as $U) { 
		                            	echo "  <option value='".$U['ID_Usuario']."'>".$U['Nombres']."</option>";}?>
		                            	</select>                                       
		                        	&nbsp;&nbsp;&nbsp;&nbsp;
		                            	<select style="width: 100%;" class='form-control' id='grupo_usuario' name='grupo_usuario' data-plugin='select2' onchange="buscar();">
		                                    <option value=''>Grupo de Usuario</option>
		                                    <?php foreach ($DatosFiltroGrupoU as $GU) { 
		                            	echo "  <option value='".$GU['ID_GrupoUsuario']."'>".$GU['NombreGrupoUsuario']."</option>";}?>
		                           		</select>  
		                        	&nbsp;&nbsp;&nbsp;&nbsp;
		                            	<select style="width: 100%;" class='form-control select2' id='local' name='local' data-plugin='select2' onchange="buscar();">
		                                    <option value=''>Local</option>
		                                    <?php foreach ($DatosFiltroLocal as $L) { 
		                            	echo "  <option value='".$L['ID_Local']."'>".$L['NombreLocal']."</option>";}?>
		                            	</select> 
		                            &nbsp;&nbsp;&nbsp;&nbsp;
		                            	<select style="width: 100%;" class='form-control select2' id='zona' name='zona' data-plugin='select2' onchange="buscar();">
		                                    <option value=''>Zona</option>
		                                    <?php foreach ($DatosFiltroLocal as $L) { 
		                            	echo "  <option value='".$L['ID_Zona']."'>".$L['Zona']."</option>";}?>
		                           		</select> 
		                           	 &nbsp;&nbsp;&nbsp;&nbsp;
		                            	<select style="width: 100%;" class='form-control select2' id='fecha' name='fecha' data-plugin='select2' onchange="buscar();">
		                                    <option value=''>Fecha Respuesta</option>
		                                    <?php foreach ($DatosFiltroFecha as $FE) { 
		                            	echo "  <option value='".$FE['Fecha']."'>".date("d-m-Y",strtotime($FE['Fecha']))."</option>";}?>
		                           		</select> 
		                           	 &nbsp;&nbsp;&nbsp;&nbsp;
		                            	<select style="width: 100%;" class='form-control select2' id='trivia' name='trivia' data-plugin='select2' onchange="buscar();">
		                                    <option value=''>Encuesta</option>
		                                    <?php foreach ($DatosFiltroTrivia as $TT) { 
		                            	echo "  <option value='".$TT['ID_Trivia']."'>".$TT['Nombre']."</option>";}?>
		                           		</select>  
		                           	 &nbsp;&nbsp;&nbsp;&nbsp;                                   
			                        </div>
			            		</div>
			            	</div>
			            	<hr>
			            	<hr>
                        	<div class="col-md-12">
                        		<form id="frmTabla" method="POST" action="generarExcelResultados">
                        		<table class="table color-bordered-table danger-bordered-table order-column" id="t1">
                        			<thead>
                        				<tr>
            								<th class="text-center">NOMBRES</th>
											<th class="text-center">GRUPO<br>DE USUARIO</th>
											<th class="text-center">LOCAL</th>
											<th class="text-center">ZONA</th>
											<th class="text-center">FECHA<br>RESPUESTA</th>
											<th class="text-center">NOMBRE<br>DE LA ENCUESTA</th>
											<th class="text-center">NOTA</th>
											<th class="text-center"><div class='checkbox abc-checkbox-danger abc-checkbox' style='margin-bottom: 25%;margin-left: 30%;'><input type='checkbox' id='chk_todo' onchange='calcularTodo();'><label for='chk_todo'></label></div></th>
											<th class="text-center"><div class="input-group input-group-sm"><input class="input-group-addon" type="number" name="txt_resultado" id="txt_resultado" disabled="" value="0">&nbsp;&nbsp;%</div></th>
                        				</tr>
                        			</thead>
                        			<tbody>
                        				<?php
                        					$contador=1;
                        					$cont=1;
                        					foreach ($Tabla as $ta) {	
                        						echo "<tr style='font-size:0.6rem;'>";
												echo "<td class='text-center'>".$ta["Nombres"]."</td><input type='hidden' name='txt_cont' id='txt_cont' value='".$cont."'>
												<input type='hidden' name='txt_nombre_user".$contador."' id='txt_nombre_user".$contador."' value='".$ta["Nombres"]."'>";
												echo "<td class='text-center'>".$ta["GrupoUser"]."</td>
												<input type='hidden' name='txt_grupo_user".$contador."' id='txt_grupo_user".$contador."' value='".$ta["GrupoUser"]."'>";
												echo "<td class='text-center'>".$ta["NombreLocal"]."</td>
												<input type='hidden' name='txt_local".$contador."' id='txt_local".$contador."' value='".$ta["NombreLocal"]."'>";
												echo "<td class='text-center'>".$ta["Zona"]."</td>
												<input type='hidden' name='txt_zona".$contador."' id='txt_zona".$contador."' value='".$ta["Zona"]."'>";
												echo "<td class='text-center'>".date("d-m-Y",strtotime($ta["Fecha"]))."</td>
												<input type='hidden' name='txt_fecha".$contador."' id='txt_fecha".$contador."' value='".date("d-m-Y",strtotime($ta["Fecha"]))."'>";
												echo "<td class='text-center'>".$ta["Nombre"]."</td>
												<input type='hidden' name='txt_nombre".$contador."' id='txt_nombre".$contador."' value='".$ta["Nombre"]."'>";
												echo "<td class='text-center'>".$ta["Promedio"]."</td>
												<input type='hidden' name='txt_contador_prom".$contador."' id='txt_contador_prom".$contador."' value='".$ta["Promedio"]."'>";
												echo "<td class='text-center'>
														<div class='checkbox abc-checkbox-danger abc-checkbox' style='margin-bottom: 10%;'>
                                                    		<input type='checkbox' id='cb-".$contador."'  onchange='calcular();'>
                                                    		<label for='cb-".$contador."'></label>
                                                		</div>
                                                		</td>";
                                                echo "<td><div class='progress'>";if($ta["Promedio"]>90){echo"<div class='progress-bar-striped bg-success' style='width: "; echo str_replace("%","",$ta["Promedio"]);echo"%;'><span class='sr-only'>35% Complete (success)</span></div>";}elseif ($ta["Promedio"]<90 && $ta["Promedio"]>70) { echo"<div class='progress-bar-striped bg-warning' style='width: "; echo str_replace("%","",$ta["Promedio"]);echo"%;'><span class='sr-only'>35% Complete (success)</span></div>";
                                                }else{ echo"<div class='progress-bar-striped bg-danger' style='width: "; echo str_replace("%","",$ta["Promedio"]);echo"%;'><span class='sr-only'>35% Complete (success)</span></div>"; } echo"</div></td>";
												echo "</tr>";
												$contador++;
												$cont++;
                        					}
                        					
                        				?>
                        			</tbody>
                        		</table>
                        		<button style="margin-left: 1%;" type="submit" class="btn btn-md btn-danger" onclick="generarExcel();"><i class="mdi mdi-file-excel"></i>Descargar Excel</button> 
                        		<input type="hidden" name="txt_contador" id="txt_contador" value="<?php echo $contador;?>">
                        		<input type="hidden" name="txt_resultado_aux" id="txt_resultado_aux" value="0">
                        	</form>
                        		
                        	</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-accent-theme">
                        <div class="card-body">
							<h4 class="text-theme">Encuestas</h4>
                            <br/>
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-pie-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-accent-theme">
                        <div class="card-body">
							<h4 class="text-theme">Grupo de Usuarios</h4>
                            <br/>
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-pie-chart2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo  site_url(); ?>/assets/libs/typeahead/typeahead.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/multiselect/js/jquery.multi-select.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/form-masks/dist/formatter.min.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/charts-flot/jquery.flot.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/charts-flot/jquery.flot.pie.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/charts-flot/jquery.flot.time.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/charts-flot/jquery.flot.stack.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/charts-flot/jquery.flot.crosshair.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/charts-flot/jquery.flot.tooltip.min.js"></script>
    <script type="text/javascript">

    	$(document).ready(function() {
		    var table = $('#t1').DataTable( {
		        scrollY:        "350px",
		        scrollX:        false,
		        searching: true,
		        scrollCollapse: true,
		        paging:         false,
		        bSort: false,
		        "language": {
		            "sProcessing":    "Procesando...",
		            "sLengthMenu":    "Mostrar _MENU_ registros",
		            "sZeroRecords":   "No se encontraron resultados",
		            "sEmptyTable":    "Ningún dato disponible en esta tabla",
		            "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
		            "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
		            "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
		            "sInfoPostFix":   "",
		            "sSearch":        "Buscar:",
		            "sUrl":           "",
		            "sInfoThousands":  ",",
		            "sLoadingRecords": "Cargando...",
		            "oPaginate": {
		                "sFirst":    "Primero",
		                "sLast":    "Último",
		                "sNext":    "Siguiente",
		                "sPrevious": "Anterior"
		            },
		            "oAria": {
		                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
		            }
		        }
		    });
		});

		$('#lbl_usuario').select2({});
		$('#grupo_usuario').select2({});
		$('#local').select2({});
		$('#zona').select2({});
		$('#fecha').select2({});
		$('#trivia').select2({});

		function clearinfo(){
			$("#lbl_usuario").val('').trigger('change');
			$("#grupo_usuario").val('').trigger('change');
			$("#local").val('').trigger('change');
			$("#zona").val('').trigger('change');
			$("#fecha").val('').trigger('change');
			$("#trivia").val('').trigger('change');
			buscar();
		}

		function buscar(){
			var usuario="0";
			var grupo_usuario="0";
			var local="0";
			var zona="0";
			var fecha="01-01-1900";
			var trivia="0";
			var triv="";
			$("#txt_resultado").val(0);

			if($("#lbl_usuario").val()==""){
				usuario="0";
			} else {
				usuario=$("#lbl_usuario").val();
			}

			if($("#grupo_usuario").val()==""){
				grupo_usuario="0";
			} else {
				grupo_usuario=$("#grupo_usuario").val();
			}

			if($("#local").val()==""){
				local="0";
			} else {
				local=$("#local").val();
			}

			if($("#zona").val()==""){
				zona="0";
			} else {
				zona=$("#zona").val();
			}

			if($("#fecha").val()==""){
				fecha="01-01-1900";
			} else {
				fecha=$("#fecha").val();
			}

			if($("#trivia").val()==""){
				trivia="0";
			} else {
				trivia=$("#trivia").val();
			}

			var data = "usuario="+usuario+"&grupo_usuario="+grupo_usuario+"&local="+local+"&zona="+zona+"&fecha="+fecha+"&trivia="+trivia;
			$.ajax({
				url:"<?php echo base_url("Adm_ModuloTrivia/filtro");?>",
				type: "POST",
				data: data,
				dataType:"json",
				
				success: function (data) {
					var n=new Array();
					var g=new Array();
					var l=new Array();
					var z=new Array();
					var f=new Array();
					var ne=new Array();
					var pr=new Array();
					var contador=1;
					var cont=1;

					for(i in data.tf){
						n[i]=data.tf[i].Nombres;
						g[i]=data.tf[i].GrupoUser;
						l[i]=data.tf[i].NombreLocal;
						z[i]=data.tf[i].Zona;
						f[i]=data.tf[i].Fecha;
						ne[i]=data.tf[i].Nombre;
						pr[i]=data.tf[i].Promedio;
					}

					var usuarios="<option value=''>Usuario</option>";
					for(i in data.tf){
						triv+="<tr>";
						triv+="<td class='text-center'>"+data.tf[i].Nombres+"</td>";
						triv+="<td class='text-center'>"+data.tf[i].GrupoUser+"</td>";
						triv+="<td class='text-center'>"+data.tf[i].NombreLocal+"</td>";
						triv+="<td class='text-center'>"+data.tf[i].Zona+"</td>";
						triv+="<td class='text-center'>"+data.tf[i].Fecha+"</td>";
						triv+="<td class='text-center'>"+data.tf[i].Nombre+"</td>";
						triv+="<td class='text-center'>"+data.tf[i].Promedio+"</td><input type='hidden' name='txt_nombre_user"+contador+"' id='txt_nombre_user"+contador+"' value='"+data.tf[i].Nombres+"'><input type='hidden' name='txt_contador_prom"+contador+"' id='txt_contador_prom"+contador+"' value='"+data.tf[i].Promedio+"'><input type='hidden' name='txt_grupo_user"+contador+"' id='txt_grupo_user"+contador+"' value='"+data.tf[i].GrupoUser+"'><input type='hidden' name='txt_local"+contador+"' id='txt_local"+contador+"' value='"+data.tf[i].NombreLocal+"'><input type='hidden' name='txt_zona"+contador+"' id='txt_zona"+contador+"' value='"+data.tf[i].Zona+"'><input type='hidden' name='txt_fecha"+contador+"' id='txt_fecha"+contador+"' value='"+data.tf[i].Fecha+"'><input type='hidden' name='txt_nombre"+contador+"' id='txt_nombre"+contador+"' value='"+data.tf[i].Nombre+"'><input type='hidden' name='txt_contador_prom"+contador+"' id='txt_contador_prom"+contador+"' value='"+data.tf[i].Promedio+"'><input type='hidden' name='txt_cont' id='txt_cont' value='"+cont+"'>";
						triv+="<td class='text-center'><div class='checkbox abc-checkbox-danger abc-checkbox' style='margin-bottom: 10%;'><input type='checkbox' id='cb-"+contador+"'  onchange='calcular();'><label for='cb-"+contador+"'></label></div></td>";
						triv+="<td><div class='progress'>";
							if(data.tf[i].Promedio.replace("%","")>90){ 
								triv+="<div class='progress-bar-striped bg-success' style='width: "+data.tf[i].Promedio+";'><span class='sr-only'>35% Complete (success)</span></div>"; 
							} 
							if(data.tf[i].Promedio.replace("%","")<90 && data.tf[i].Promedio.replace("%","")>70){ 
								triv+="<div class='progress-bar-striped bg-warning' style='width: "+data.tf[i].Promedio+";'><span class='sr-only'>35% Complete (success)</span></div>"; 
							}
							if(data.tf[i].Promedio.replace("%","")<70){
								triv+="<div class='progress-bar-striped bg-danger' style='width: "+data.tf[i].Promedio+";'><span class='sr-only'>35% Complete (success)</span></div>";
								} 
							triv+= "</div></td>";
						triv+="</tr>";
						contador++;
						cont++;
					}

					$("#txt_contador").val(contador);
					$("#t1 tbody").html(triv);
				}
			});
		}

		function calcularTodo(){
			var contador=$("#txt_contador").val()-1;
			var contTodo=1;
			var aux=0;
			if ($('#chk_todo').is(':checked')) {
				for (var i = 0; i < contador; i++) {
					$('#cb-'+contTodo).prop('checked', true);
					porcentajes=$("#txt_contador_prom"+contTodo).val();
					var aux = (parseInt(aux)+parseInt(porcentajes));
					var au = i+1;
					contTodo++;
				}
				$("#txt_resultado").val(Math.round(aux/au));
				$("#txt_resultado_aux").val(Math.round(aux/au));
				contTodo=1;
				aux=0;
			}else{
				for (var i = 0; i < contador; i++) {
					$('#cb-'+contTodo).prop('checked', false);
					contTodo++;
				}
				$("#txt_resultado").val(0);
				$("#txt_resultado_aux").val(0);
			}

		}

		function calcular(){			
			var contador=$("#txt_contador").val()-1;
			var cont=1;
			var porcentajes= new Array();
			var aux=0;
			var count=1;
			var contTodo=1;
			var conta=0;

			for (var i = 0; i < contador; i++) {
				if($('#cb-'+cont).is(':checked')){
					// var conta=$("#txt_contador_prom3").val();
					
					porcentajes=$("#txt_contador_prom"+cont).val();
					var aux = (parseInt(aux)+parseInt(porcentajes));
					var au = i+1;
					conta++;
					if (cont==1) {
						count=1;
						}else{
							count=0;
						}
					}
				cont++;
			}
			$("#txt_resultado").val(Math.round(aux/conta));
			$("#txt_resultado_aux").val(Math.round(aux/conta));
		}

		$(function () {
			var colorR = ["#46affa", "#ff3636", "#33f550", "#f5b833", "#33f5a1"];
		    var data = [{
		    	<?php 
		    	$contador=1;
		    	foreach ($GraficoTrivia as $gt) { ?>
		        label: "<?php echo $gt["Nombre"];?> (Nota: <?php echo $gt["Promedio"];?>)",
		        data: <?php echo $gt["Promedio"];?>},{
		        color: colorR[<?php echo $contador; ?>],
		    <?php
		    $contador++;
		     } ?>
		    
		    }];
		    
		    var plotObj = $.plot($("#flot-pie-chart"), data, {
		        series: {
		            pie: {
		                innerRadius: 0.5,
		                show: true
		            }
		        },
		        grid: {
		            hoverable: true
		        },
		        color: null,
		        tooltip: true,
		        tooltipOpts: {
		            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
		            shifts: {
		                x: 20,
		                y: 0
		            },
		            defaultTheme: false
		        }
		    });

		});

		$(function () {
		    var colorR = ["#46affa", "#ff3636", "#33f550", "#f5b833", "#33f5a1"];

		    var data = [{
		    	<?php 
		    	$contador=1;
		    	foreach ($GraficoGrupoU as $GU) { ?>
		        label: "<?php echo $GU["GrupoUser"];?> (Nota: <?php echo $GU["Promedio"];?>)",
		        data: <?php echo $GU["Promedio"];?>},{
		        color: colorR[<?php echo $contador; ?>],
		    <?php
		    $contador++;
		     } ?>
		    
		    }];

		    var plotObj = $.plot($("#flot-pie-chart2"), data, {
		        series: {
		            pie: {
		                innerRadius: 0.5,
		                show: true
		            }
		        },
		        grid: {
		            hoverable: true
		        },
		        color: null,
		        tooltip: true,
		        tooltipOpts: {
		            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
		            shifts: {
		                x: 20,
		                y: 0
		            },
		            defaultTheme: false
		        }
		    });

		});

		function generarExcel(){
			var resultado=$("#txt_resultado").val();
			$.ajax({
	            url: "generarExcelResultados",
	            method: "POST",
	            data: $("#frmTabla").serialize()+"&resultado="+resultado, 
	            success: function(data) {
	                alertify.success("Resultados descargados.");
	        	}
			});
		}

    </script>