<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
             <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Crear Preguntas</a>
        </li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <h3 class="text-theme">Mantenedor de Preguntas</h3>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" id="FormNuevaTrivia">
                        <div class="card card-accent-theme">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8" style="margin-top: 21px;">
                                        <h5 class="text-theme">Elaborar Pregunta</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-danger float-md-right" onclick="desplegarMaker();">Crear Pregunta</button>
                                    </div>
                                </div>
                                <hr>
                                <div id="pregunta" class="row" style="display: none; margin-top: 20px;">         
                                    <div class="col-md-6" id="categoria">
                                        <div class="form-group">
                                            <label for="company">Categoría de la Pregunta</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                        <i class="fa fa-leaf"></i>
                                                </span>
                                                <input type="text" class="form-control" id="txtTipoPregunta" name="txtTipoPregunta" placeholder="Categoría de la Pregunta">
                                            </div>
                                            <div id="errortxtTipoPregunta" style="color: red; display: none;">
                                                   Debe Escribir la categoría de la pregunta...
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="Buscarcategoria" style="display: none;">
                                        <div class="form-group">
                                            <label for="company">Seleccione la Categoría de la Pregunta</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-sitemap"></i></span><select id="mstlCategoria" name="mstlCategoria" class="form-control"><option value="" id="defaultC">Seleccione tipo de respuesta</option>
                                                  <?php
                                                      foreach ($ListarCategoria as $lc) {
                                                      echo "<option value='".$lc['Categoria']."'>".strtoupper($lc['Categoria'])."</option>";
                                                  }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2" style="margin-top: 40px;">
                                        <div class="form-group">
                                            <div class="checkbox abc-checkbox abc-checkbox-danger abc-checkbox-circle">
                                                <input id="chckCategoria" name="chckCategoria" class="styled" type="checkbox">
                                                <label for="chckCategoria">
                                                    Seleccionar Categoría
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4" style="padding-left:30px;">
                                        <div class="form-group">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-2" style="margin-top: 20px;">
                                                        <label>Dificultad: </label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="radio abc-radio abc-radio-danger radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="0" name="radioInline">
                                                            <label for="inlineRadio1"> Baja </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="radio abc-radio abc-radio-danger radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="1" name="radioInline" checked>
                                                            <label for="inlineRadio2"> Media </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="radio abc-radio abc-radio-danger radio-inline">
                                                            <input type="radio" id="inlineRadio3" value="2" name="radioInline">
                                                            <label for="inlineRadio3"> Alta </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="txt_IDOpcion" name="txt_IDOpcion" value="0">
                                    <div class="col-md-12">
                                        <div class="card border-danger text-danger mb-3">
                                            <div class="card-header">
                                                <input type="text" class="form-control" id="txtTituloPregunta" name="txtTituloPregunta" placeholder="Título de la Pregunta">
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="margin"><i class="fa fa-dot-circle-o"></i> Tipo de respuesta esperada</p>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-sitemap"></i></span><select id="typePregunta" name="typePregunta" class="form-control" onchange="elegirPregunta();"><option value="" id="default">Seleccione tipo de respuesta</option>
                                                              <?php
                                                                  foreach ($Opciones as $o) {
                                                                  echo "<option value='".$o['ID_TriviaOpcion']."'>".$o['NombreOpcion']."</option>";
                                                              }?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div style="padding-top: 10px;" id="div_eleccion">
                                                        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-theme btn-sm" onclick="IngresarFormulario();"><i class="fa fa-floppy-o"></i> Guardar Pregunta</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nombre Pregunta</th>
                                            <th>Categoría</th>
                                            <th>Dificultad</th>
                                            <th>Tipo</th>
                                            <th>Archivo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                          <?php foreach ($Preguntas as $pr) { ?>          
                                              <td><?php echo $pr["TituloPregunta"];?></td>
                                              <td><?php echo $pr["Categoria"];?></td>
                                              <td><?php echo $pr["NivelDificultad"];?></td>
                                              <td><?php echo $pr["NombreOpcion"];?></td>
                                              <td><button onclick="subirAudio(<?php echo $pr['ID_TriviaPregunta'];?>);" class="btn btn-block btn-danger" style="width: 140px;">Subir Audio <i class="mdi mdi-audiobook"></i></button></td>
                                              </tr>
                                          <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>

    <div class="modal fade" id="modal-subirAudio" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Cargar Archivo de Audio</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sa-icon sa-danger animate"></div>
                    <div id="subirAudio"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('IngresarAudioPregunta').submit();">Subir Audio</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> 

</main>

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script type="text/javascript">

    $('#chckCategoria').click( function(){
        if($(this).is(':checked')){
            $('#categoria').hide('slow');
            $('#Buscarcategoria').show('slow');
            $('#txtTipoPregunta').val('');
        }else{           
            $('#categoria').show('slow');
            $('#Buscarcategoria').hide('slow');
            document.getElementById('defaultC').selected = 'true';
        };
    });

    function desplegarMaker(){
        $("#pregunta").slideToggle("slow");  
    }

    function elegirPregunta(){
        $("#div_eleccion").html("");
        $("#typePregunta").val();  
        var contOp = parseInt($("#txt_IDOpcion").val()); 
        var opcion = $("#typePregunta").val();
        var contador=1;
        if(opcion==1){
            $("#div_eleccion").append('<div class="input-group"><span class="input-group-addon"><i>'+contador+' .- </i></span><input type="hidden" id="txt_IDOpcion" name="txt_IDOpcion" value="'+contOp+'"><input type="text" class="form-control" name="txt_elemento'+contOp+'" id="txt_elemento'+contOp+'" placeholder="Ingresar Nombre Elección"></div><div id="div_elementos"></div><br><div class="input-group"><span class="input-group-addon"><i class="mdi mdi-checkbox-marked-circle-outline"></i></span><input type="number" class="form-control" name="txt_resp" id="txt_resp" placeholder="Ingresar el número de la Respuesta Correcta"></div><div class="form__box"><button type="button" class="btn btn-theme btn-sm" onclick="addElemento()"><i class="fa fa-plus"></i> Agregar Opción</button></div><br>');         
        }
    }

    function addElemento(){ 
      var contOp = parseInt($("#txt_IDOpcion").val())+1;   
      var cont = parseInt($("#txt_IDOpcion").val())+2;
        $("#div_elementos").append('<input type="hidden" id="txt_IDOpcion" name="txt_IDOpcion" value="'+contOp+'"><div class="input-group"><span class="input-group-addon"><i>'+cont+' .-</i></span><input type="text" class="form-control" name="txt_elemento'+contOp+'" id="txt_elemento'+contOp+'" placeholder="Ingresar Nombre Elección"></div>');
        $("#txt_IDOpcion").val(contOp);  
    }

    function IngresarFormulario(){
        var respMAxima=parseInt($("#txt_IDOpcion").val())+1;
        var val=0;
        if ($("#txt_resp").val()<=0) {
            alertify.error("La respuesta correcta no puede ser menor o igual a 0");
            val=1;
        }
        if ($("#txt_resp").val()>respMAxima) {
            alertify.error("La respuesta correcta no puede ser mayor que el máximo de opciones");
            val=1;
        }
        if ($("#txt_elemento0").val()=="") {
            alertify.error("Debe ingresar a lo menos una opción");
            val=1;
        }
        if ($("#txtTipoPregunta").val()=="" && !$('#chckCategoria').is(':checked')) {
            alertify.error("Debe escribir la categoría de la pregunta");
            val=1;
        }
        if ($('#chckCategoria').is(':checked') && $("#mstlCategoria").val()=="") {
            alertify.error("Debe seleccionar la categoría de la pregunta");
            val=1;
        }
        if ($("#txtTituloPregunta").val()=="") {
            alertify.error("Debe escribir el título de la pregunta");
            val=1;
        }
        if ($("#typePregunta").val()=="") {
            alertify.error("Debe elegir un tipo de opción");
            val=1;
        }
        if(val==0){
        $.ajax({
            url: "nuevaPregunta",
            method: "POST",
            data: $("#FormNuevaTrivia").serialize(), 
            success: function(data) {
                    if(data==0){
                        alertify.error("La categoría ya existe");
                    }
                    if (data==1) {
                        alertify.success("Pregunta creada con éxito");   
                        $("#pregunta").hide("slow");
                        $("#txtTipoPregunta").val("");
                        $("#txtTituloPregunta").val("");
                        document.getElementById('default').selected = 'true';
                        $("#div_eleccion").empty();
                        setTimeout(function(){
                          window.location = "crearPregunta";
                        }, 2000);
                    }      
                }                    
            });
        }
    }

     function subirAudio(id){
        $.ajax({
                url: "subirAudio",
                type: "POST",
                data: "id="+id,
                success: function(data){
                    $("#subirAudio").html("");
                    $("#subirAudio").html(data);
                    $("#modal-subirAudio").modal('show');
                }
        });
    }


</script>