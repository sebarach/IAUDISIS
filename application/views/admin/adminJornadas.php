<main class="main">
	<ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
		<li class="breadcrumb-item ">
			<a href="<?php echo site_url(); ?>menu">Menú</a>
		</li>
		<li class="breadcrumb-item">
			<a href="#">Rutas</a>
		</li>
		<li class="breadcrumb-item active">Jornadas</li>
	</ol>
	<div class="container-fluid">
		<div class="animated fadeIn">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-accent-theme ">
						<div class="card-body">
							<h4 class="text-theme">Asignación masiva de horario y PDV</h4>
							<p>Este modulo esta dirigido a la asignación de horarios a un Usuario asignado a un Local (PDV)</p>
							<div class="row">
								<div class="col-md-12">
									<div class="car">
										<div class="card-header">
											<i class="mdi mdi-arrow-right-drop-circle"></i> Paso 1 
										</div>
										<div class="card-body">
											<h5 class="card-title">Plantilla de carga masiva de Horarios</h5>
											<p class="card-text">Antes de ingresar la plantilla con los horarios, debemos saber como son las columnas y/o campos requeridos con su formato de hora. Si usted no tiene conocimiento de ellos, favor de descargar la plantilla para luego llenarla</p>
											 <form method="POST" action="generarExcel">
											<button class="btn btn-theme" type="submit" title='Descargar Plantilla'><i class="mdi mdi-file-excel"></i> Descargar Plantilla</button>	</form>									
										</div>
										<div class="card-footer text-muted"></div>
										<hr>
									</div>
								</div>
								<div class="col-md-12">
									<div class="car">
										<div class="card-header">
											<i class="mdi mdi-arrow-right-drop-circle"></i> Paso 2 
										</div>
										<div class="card-body">
											<h5 class="card-title">Validar de Excel</h5>
											<p class="card-text">Para poder ingresar una jornada con un grupo de horarios se tiene que ingresar de manera masiva a través de un Excel. Para ello tenemos que tener la plantilla con las columnas bien definidas para la plataforma valide e ingrese sin problemas. </p>
											<h5 class="card-title">Tipos de Errores </h5>
												<p class="card-text">
													<span class="badge badge-pill" style="width: 200px; background-color: #8e24aa; color: white;">Usuario no existe</span>
													<span class="badge badge-pill" style="width: 200px; background-color: #F6BB42; color: white;">Nombre Local/PDV no existe</span>
													<span class="badge badge-pill" style="width: 200px; background-color: #20bf6b; color: white;">La Entrada Mayor a la Salida</span>
													<span class="badge badge-pill" style="width: 200px; background-color: #20c997; color: white;">La Entrada Igual a la Salida</span>
													<span class="badge badge-pill" style="width: 200px; background-color: #e91e63; color: white;">Formato Hora Incorrecto</span>
													<span class="badge badge-pill" style="width: 200px; background-color: #3867d6; color: white;">Fecha inicio esta vacía</span>
													<span class="badge badge-pill" style="width: 200px; background-color: #ffb90f ; color: white;">Horarios Iguales en Distintos PDV</span>
												</p>					
												<div class="btn btn-theme">
													<i class="mdi mdi-alarm-check"></i> Seleccione Excel para Validar <i id="validarExcelSpin" class=""></i> <form action="ValidarEx" method='POST' id="ValidarExcel" name="ValidarExcel" enctype="multipart/form-data" >                    
				   	                				  <input type='file' class="btn btn-xs btn-dark" id="excel" name="excel" onchange="formatoVal('#excel');">
														</form>
												</div>
										</div>
										<div class="card-footer text-muted"></div>
									</div>
									
								</div>
								<div class="col-md-12">
									<div class="card">
										<div class="card-header">
											<i class="mdi mdi-arrow-right-drop-circle"></i> Paso 3
										</div>
										<div class="row">
                							<div class="col-md-6">
												<div class="card-body">
													<h5 class="card-title">Ingresar Excel Validado </h5>
													<p class="card-text">Aquí uno solo tiene que ingresar el excel ya validado, si uno ingresa el excel con un rut o un local que no exista en la base de datos, no ingresara la fila entera.</p>
													<div  class="btn btn-theme">
															<i class="mdi mdi-alarm-plus"></i> 
															Seleccione Excel validado para ingresar<i id="ingresarExcelSpin" class=""></i> <form action="IngExcel" method='POST' id="IngresarExcel" name="IngresarExcel" enctype="multipart/form-data" >                    
															  <input type='file' class="btn btn-xs btn-dark" id="excelv" name="excelv" onchange="formatoValIngreso('#excelv');">
														</form>
													</div>
												</div>
											</div>
											<div class="col-md-6">
                            					<div class="card card-body ">
                            						<h5 class="card-title"> Codigos de Permisos</h5>
                                <div class="todo-widget">
                                    
                                    <ul id="scrollList">
                                    	             <?php
                                        foreach ($listaPermisos as $p){
                                        echo '<li>
                                                <i class="mdi mdi-alarm-check"></i> '.$p["NombrePermiso"].'
                                            <code>'.$p["Codigo"].'</code>
                                        </li>';
                                        }?>                                        
                                    </ul>
                                </div>
                                
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <!-- end col -->


                    </div>
										
									</div>
									</div>
									</div>

								</div>
							</div>
						</div>
						
					</div>


				</div>
				<!-- end animated fadeIn -->
			</div>
			<!-- end container-fluid -->

		</main>
		<!-- end main -->

	<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
	<script src="<?php echo  site_url(); ?>assets/libs/nicescroll/jquery.nicescroll.min.js"></script>
	<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
	<!-- <script src="<?php echo  site_url(); ?>assets/js/widget-data-examples.js"></script> -->


<script type="text/javascript">

$(function () { 
    "use strict";

   // scroll bars

    $("#scrollList").niceScroll({
        cursorcolor: "#AEC6D2",
        //cursorborder:"1px solid #F3F7F9"
    });


});


			
			


	function formatoVal(excel){
	  if($(excel).val()!=''){
		  var f=($(excel).val().substring($(excel).val().lastIndexOf("."))).toLowerCase();
		  var validar=true;
		  if(f==".xls" || f==".xlsx"){ validar=true;} else {validar=false;}
		  if(validar==false){
			  alertify.error("El Formato del archivo es invalido");
			  document.getElementById("excel").value="";
		  }else if(validar==true){
			$("#validarExcelSpin").attr("class","fa fa-spin fa-circle-o-notch");
			var form = $(this);
			var file = document.getElementById("ValidarExcel").submit();
			// var ValidarExcel = file.files[0];
			// var promise = formatoVal();
			$.ajax({
				url:"http://checkroom.cl/audisis/Adm_ModuloJornadas/ValidarEx",                     
				type : form.attr('method'),
				data : new FormData(form[0]), // <-- usamos `FormData`
				dataType : 'json',
				processData: false,  // <-- le indicamos a jQuery que no procese el `data`
				contentType: false,
				success: function(data){

				},
				error:function(data){
					console.log("success");
					console.log(data);
					// alert(data);
					$("#validarExcelSpin").attr("class","");
					$("#excel").val('');
					// alertify.success("Excel Validado");
				}
			});
		  }
	  }
  }


  function formatoValIngreso(excelv){
	  if($(excelv).val()!=''){
		  var f=($(excelv).val().substring($(excelv).val().lastIndexOf("."))).toLowerCase();
		  var validar=true;
		  if(f==".xls" || f==".xlsx"){ validar=true;} else {validar=false;}
		  if(validar==false){
			  alertify.error("El Formato del archivo es invalido");
			  document.getElementById("excelv").value="";
		  }else if(validar==true){
			$("#ingresarExcelSpin").attr("class","fa fa-spin fa-circle-o-notch");
			var form = $(this);
			var file = document.getElementById("IngresarExcel").submit();
			// var ValidarExcel = file.files[0];
			// var promise = formatoVal();
			$.ajax({
				url:"http://checkroom.cl/audisis/Adm_ModuloJornadas/IngExcel",                     
				type : form.attr('method'),
				data : new FormData(form[0]), // <-- usamos `FormData`
				dataType : 'json',
				processData: false,  // <-- le indicamos a jQuery que no procese el `data`
				contentType: false,
				success: function(data){
					// alertify.error("Excel Ingresado");

				},error:function(data){
					// alertify.error("Error desconosido");
					$("#ingresarExcelSpin").attr("class","");
					$("#excelv").val('');
					// alertify.success("Jornadas Ingresadas con Exito");
					
				}
			});
		  }
	  }
  }

		</script>