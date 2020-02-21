<main class="main" style="height: 100%;">
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
            <h3 class="text-theme">Crear Tarea</h3>
                <small>Modulo de tareas. Este módulo esta hecho para crear tareas</small>
                <br><br/>
                <form method="POST" action="crearTareaTipo">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="company">Nombre Tarea</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                        <i class="mdi mdi-etsy"></i>
                                                </span>
                                                <input type="text" class="form-control" id="txtNombreTarea" name="txtNombreTarea" placeholder="Nombre de la Tarea" >
                                            </div>
                                            <div id="errortxtNombreTarea" style="color: red; display: none;"  >
                                                   Debe Escribir el nombre de la tarea...
                                            </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="company">Tipo de Tarea</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                            <i class="mdi mdi-format-list-bulleted-type"></i>
                                                    </span>
                                                        <select id="msltTipoTarea" name="msltTipoTarea" class="form-control form-control-sm">
                                                            <option value="">Seleccione tipo de tarea</option>
                                                            <?php
                                                                foreach ($TipoTareas as $t) {
                                                                echo "<option value='".$t['ID_Tipo_Tarea']."'>".$t['Tipo_Tarea']."</option>";
                                                            }?>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row"  id="formulario" style="display: none;">
                                        <div class="col-md-12">
                                        <label for="company">Formularios</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-pencil"></i></span>
                                                <select id="msltForm" class="form-control select2" data-plugin="select2" multiple  id="txt_formu[]" name="txt_formu[]" style="width: 100%;">
                                                    <?php
                                                        foreach ($ListaFormularios as $lf) {
                                                                echo "<option value='".$lf['ID_Formulario']."'>".$lf['NombreFormulario']."</option>";
                                                        }
                                                    ?>
                                                </select> 
                                        </div>

                                        <div id="errortxtForm" style="color: red; display: none;"  >
                                           Debe Elegir a lo menos un formulario...
                                        </div>
                                    </div>
                                    </div>

                                    <div class="row"  id="encuesta" style="display: none;">
                                        <div class="col-md-12">
                                            <label for="company">Encuestas</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="mdi mdi-book"></i></span>
                                                    <select id="msltEnc" class="form-control select2" data-plugin="select2" multiple  id="txt_enc[]" name="txt_enc[]" style="width: 100%;">
                                                        <option>1</option>
                                                        <option>2</option>
                                                    </select> 
                                            </div>

                                            <div id="errortxtEncuesta" style="color: red; display: none;"  >
                                               Debe Elegir a lo menos una encuesta...
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row"  id="prueba" style="display: none;">
                                        <div class="col-md-12">
                                            <label for="company">Pruebas</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="mdi mdi-clipboard-text"></i></span>
                                                    <select id="msltPrueba" class="form-control select2" data-plugin="select2" multiple  id="txt_quiz[]" name="txt_quiz[]" style="width: 100%;">
                                                        <?php
                                                            if(isset($ListaTrivias)){
                                                                foreach ($ListaTrivias as $lt) {
                                                                    echo "<option value='".$lt['ID_Trivia']."'>".$lt['Nombre']."</option>";
                                                                }
                                                            }else{
                                                                echo "<option value=''>Sin Trivias Creadas</option>";
                                                            }
                                                        ?>
                                                    </select> 
                                            </div>

                                            <div id="errortxtPrueba" style="color: red; display: none;"  >
                                               Debe Elegir a lo menos una trivia...
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row"  id="horario" style="display: none;">
                                        <div class="col-md-12">
                                            <label for="company">Formularios Horarios</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                                    <select id="msltHorario" class="form-control select2" data-plugin="select2" multiple  id="txt_horario[]" name="txt_horario[]" style="width: 100%;">
                                                        <?php
                                                            if(isset($ListaFormularios)){
                                                                foreach ($ListaFormularios as $lf) {
                                                                    echo "<option value='".$lf['ID_Formulario']."'>".$lf['NombreFormulario']."</option>";
                                                                }
                                                            }else{
                                                                echo "<option value=''>Sin Formularios Creados</option>";
                                                            }
                                                        ?>
                                                    </select> 
                                            </div>

                                            <div id="errortxtHorario" style="color: red; display: none;"  >
                                               Debe Elegir a lo menos un Formulario...
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row"  id="formularioEspecial" style="display: none;">
                                        <div class="col-md-12">
                                            <label for="company">Formularios Especiales</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-columns"></i></span>
                                                    <select id="msltFormuEsp" class="form-control select2" data-plugin="select2" multiple  id="msltFormuEsp[]" name="txt_formuEspecial[]" style="width: 100%;">
                                                        <?php
                                                            if(isset($ListaFormulariosEspeciales)){
                                                                foreach ($ListaFormulariosEspeciales as $lf) {
                                                                    echo "<option value='".$lf['ID_FormularioEspecial']."'>".$lf['NombreFormulario']."</option>";
                                                                }
                                                            }else{
                                                                echo "<option value=''>Sin Formularios Especiales Activos</option>";
                                                            }
                                                        ?>
                                                    </select> 
                                            </div>

                                            <div id="errortxtFormuEsp" style="color: red; display: none;"  >
                                               Debe Elegir a lo menos un Formulario Especial...
                                            </div>
                                        </div>
                                    </div>

                                    <button style="margin-top: 30px;" type="submit" class="btn btn-danger btn-sm" title="Agregar" id="botonCarpeta" onclick="return validarCrearTarea();"><i class="mdi mdi-account-edit"></i>&nbsp;&nbsp;Crear Tarea</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        </div>    
    </div>
</main>

<!-- <div class="modal fade bs-example-modal-CrearTipoTarea" tabindex="-1" role="dialog"  aria-hidden="true"
    style="display: none;" id="CrearTipoTareas">
    <div class="modal-dialog ">
        <div class="modal-content" id="CrearTipoTarea">
         
        </div>
    </div>
</div> -->

<script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?php echo  site_url(); ?>/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script type="text/javascript">



    $('#msltTipoTarea').on('change', function() {
      if ($('#msltTipoTarea').val()==0) {
        $("#formulario").hide("slow");
        $("#encuesta").hide("slow");
        $("#prueba").hide("slow");
        $("#horario").hide("slow");
        $("#formularioEspecial").hide("slow");
        //limpiar select multiples, buscar como
      }
      if ($('#msltTipoTarea').val()==1) {
        $("#formulario").show("slow");
        $("#encuesta").hide("slow");
        $("#prueba").hide("slow");
        $("#horario").hide("slow");
        $("#formularioEspecial").hide("slow");
      }
      if ($('#msltTipoTarea').val()==2) {
        $("#encuesta").show("slow");
        $("#formulario").hide("slow");
        $("#prueba").hide("slow");
        $("#horario").hide("slow");
        $("#formularioEspecial").hide("slow");
      }
      if ($('#msltTipoTarea').val()==3) {
        $("#prueba").show("slow");
        $("#encuesta").hide("slow");
        $("#formulario").hide("slow");
        $("#horario").hide("slow");
        $("#formularioEspecial").hide("slow");
      }
      if ($('#msltTipoTarea').val()==4) {
        $("#horario").show("slow");
        $("#encuesta").hide("slow");
        $("#formulario").hide("slow");
        $("#prueba").hide("slow");
        $("#formularioEspecial").hide("slow");
      }
      if ($('#msltTipoTarea').val()==5) {
        $("#formularioEspecial").show("slow");
        $("#encuesta").hide("slow");
        $("#formulario").hide("slow");
        $("#prueba").hide("slow");
        $("#horario").hide("slow");
      }
    });

    $('#msltForm').select2({});

    $('#msltEnc').select2({});

     $('#msltPrueba').select2({});

     $('#msltHorario').select2({});

     $('#msltFormuEsp').select2({});

    $('#cb-5').click( function(){
        if($(this).is(':checked')){
            $('#msltUserGrupo').prop('disabled','disabled');
            $("#div_user").slideToggle("slow");
            $('#txt_userGrupo').val('');
        }else{
            $('#msltUserGrupo').prop('disabled',false);
            $("#div_user").slideToggle("slow");
            $('#msltUsuario').val('');
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

    $('#checkLocal').click( function(){
        if($(this).is(':checked')){
            $('#msltLocales').prop('disabled',false);
        }else{
            $('#msltLocales').prop('disabled','disabled');
            $('#msltLocales').val('');
        };
    });

    function validarFecha(sel){
        if ($('#txt_fecha_inicio').val() > $('#txt_fecha_fin').val()) {
            alertify.error('La fecha de inicio no puede ser mayor a la fecha final');
            $('#txt_fecha_inicio').val('');
            $('#txt_fecha_fin').val('');
        }   
    }

    function validarCrearTarea(){
        var vacios=0;
        var valido=true;
    if($("#txtNombreTarea").val()==''){  
        $("#txtNombreTarea").attr('class', 'form-control is-invalid');
        $('#errortxtNombreTarea').show();
        alertify.error('El nombre de la tarea no puede quedar vacío'); 
        vacios+=1;
    } else { 
        $("#txtNombreTarea").attr('class', 'form-control is-valid');  
        $('#errortxtNombreTarea').hide(); 
    }
    if ($("#msltTipoTarea").val()==1) {
        if ($("#msltForm").val()=='') {
            $('#errortxtForm').show();
            alertify.error('Debe elegir al menos un formulario'); 
            vacios+=1;
        }
    }else{
        $("#msltForm").attr('class', 'form-control is-valid');  
        $('#errortxtForm').hide(); 
    }  

    if ($("#msltTipoTarea").val()==3) {
        if ($("#msltPrueba").val()=='') {
            $('#errortxtPrueba').show();
            alertify.error('Debe elegir al menos una trivia'); 
            vacios+=1;
        }
    }else{
        $("#msltPrueba").attr('class', 'form-control is-valid');  
        $('#errortxtPrueba').hide(); 
    }  

    if ($("#msltTipoTarea").val()==4) {
        if ($("#msltHorario").val()=='') {
            $('#errortxtHorario').show();
            alertify.error('Debe elegir al menos un formulario'); 
            vacios+=1;
        }
    }else{
        $("#msltHorario").attr('class', 'form-control is-valid');  
        $('#errortxtHorario').hide(); 
    } 

    if ($("#msltTipoTarea").val()==5) {
        if ($("#msltFormuEsp").val()=='') {
            $('#errortxtFormuEsp').show();
            alertify.error('Debe elegir al menos un formulario Especial'); 
            vacios+=1;
        }
    }else{
        $("#msltFormuEsp").attr('class', 'form-control is-valid');  
        $('#errortxtFormuEsp').hide(); 
    }   

    if ($("#msltUserGrupo").val()=='' && $("#msltUsuario").val()=='') {
        $('#errortxtGrupoUser').show();
        $('#errortxtUser').show();
        $("#msltUsuario").attr('class', 'form-control is-invalid');
        alertify.error('Debe elegir un usuario o un grupo de usuario'); 
        vacios+=1;
    }else{
        $("#msltUserGrupo").attr('class', 'form-control is-valid'); 
        $("#msltUsuario").attr('class', 'form-control is-valid'); 
        $('#errortxtGrupoUser').hide();
        $('#errortxtUser').hide();
    }

    if ($("#txt_fecha_inicio").val()=='') {
        $("#txt_fecha_inicio").attr('class', 'form-control is-invalid'); 
        $('#errortxt_fecha_inicio').show();
        alertify.error('Debe escoger la fecha de inicio'); 
        vacios+=1;
    }else{
        $("#txt_fecha_inicio").attr('class', 'form-control is-valid');  
        $('#errortxt_fecha_inicio').hide(); 
    }   
    if(vacios>0){ valido=false; }
    return valido;
    }

    function crearTipoTarea(){
        $.ajax({
            url: "crearTipoTarea",
            type: "POST",    
            success: function(data) {
              $("#CrearTipoTarea").html(data);
             }
        });
    }

    

</script>