<main class="main" style="height: 100%;">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
             <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Crear Trivias</a>
        </li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <h4 class=" text-theme text-center" style="padding-right: 80px;">Crear Nueva Trivia</h4>
                            <section class="cd-horizontal-timeline loaded">
                                <div class="timeline">
                                    <div class="events-wrapper">
                                        <div class="events" style="width: 1800px;">
                                            <ol>
                                                <li>
                                                    <a class="selected" style="left: 120px;">Paso 1</a>
                                                </li>
                                                <li>
                                                    <a style="left: 300px;" id="paso2">Paso 2</a>
                                                </li>
                                                <li>
                                                    <a style="left: 480px;" id="paso3">Paso 3 <i class="fa fa-floppy-o"></i></a>
                                                </li>
                                            </ol>
                                            <span class="filling-line" aria-hidden="true" style="transform: scaleX(0.0822439);" id="linea"></span>
                                        </div>
                                    </div>

                                    <ul class="cd-timeline-navigation">
                                        <li>
                                            <a class="prev">Prev</a>
                                        </li>
                                        <li>
                                            <a class="next">Next</a>
                                        </li>
                                    </ul>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <form id='frmQuiz'>
                <div class="row" id="div_paso1">
                    <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="company">Nombre de la Trivia</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                    <i class="mdi mdi-cat"></i>
                                            </span>
                                            <input type="text" class="form-control" id="txtNombreQuiz" name="txtNombreQuiz" placeholder="Nombre Trivia">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company">Número de Módulos</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                    <i class="mdi mdi-format-list-numbers"></i>
                                            </span>
                                            <input type="number" class="form-control" id="txtNumeroModulos" name="txtNumeroModulos" placeholder="Cantidad">
                                        </div>
                                        <div id="div_porcentaje" style="display: none;"></div>
                                    </div>
                                    <button type="button" class="btn btn-theme btn-sm float-md-left" onclick="generarInput();"><i class="mdi mdi-percent"></i> Asignar Porcentajes</button>
                                    <button id="btnLimpiar" style="display: none;" type="button" class="btn btn-theme btn-sm float-md-left" onclick="limpiar();"><i class="fa fa-refresh"></i> Reiniciar Campos</button>
                                    <button type="button" class="btn btn-theme btn-sm float-md-right" onclick="paso2();"><i class="mdi mdi-arrow-right-box"></i> Ir al Paso 2</button>
                                </div>
                            </div>   
                        </div>    
                    </div>
                    <div class="row" id="div_paso2" style="display: none;">
                    </form> 

                    <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <div id="asignarPreguntas"></div>           
                                    <button type="button" class="btn btn-theme btn-sm float-md-left" onclick="paso1();"><i class="mdi mdi-arrow-left-box"></i> Ir al Paso 1</button>
                                    <button type="button" class="btn btn-theme btn-sm float-md-right" onclick="guardar();"><i class="fa fa-floppy-o"></i> Guardar</button>
                                </div>
                            </div>   
                        </div> 
                    </div>

            <div class="row" id="div_paso3" style="display: none;">
                <div class="col-md-12">
                    <form>
                        <div class="card card-accent-theme">
                            <div class="card-body">
                                <div class="row" id="div_generar" style="display: none;"></div>   
                                
                            </div>
                        </div> 
                    </form>   
                </div> 
            </div>
        </div>
    </div>
</main>

<link rel="stylesheet" href="<?php echo  site_url(); ?>assets/libs/sliderrange/dist/css/asRange.css">
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/sliderrange/dist/jquery-asRange.min.js"></script>
<script type="text/javascript">

    $('.range-example-input-1').asRange({
        range: true,
        limit: false,
        tip: {
            active: 'onMove'
        }
    });

    function paso2(){ 
        var nModulos = $('#txtNumeroModulos').val();
        var coordenada = $("#linea").css("transform");
        var contador = 1;
        var total = new Array();
        var totals = 0;
        var contadorVacio = 1;
        var contadorSelect = 1;
        var error = 0;
        var nombreModulos =  new Array();
        var contadorModulos = 1;
        var contadorInput = 1;
        for (var i = 0; i < nModulos; i++) {
            nombreModulos[i] = $("#txtNombreModulo"+contadorModulos).val();  
            contadorModulos++;
        } 

        for (var i = 0; i < nModulos; i++) {
            total[i] = $("#txtPorcentaje"+contador).val();      
            contador++;
        } 
        for (var i = 0; i < total.length; i++) {
            totals += total[i] << 0;
        }
        for (var j = 0; j < nModulos; j++) {
            if ($("#txtNombreModulo"+contadorVacio).val()=="") {
                alertify.error("El nombre del módulo número "+contadorVacio+" no puede quedar vacío");
                error=1;
                break;
            }    
            contadorVacio++;
        }
        for (var f = 0; f < nModulos; f++) {
            if ($("#txt_categoria"+contadorSelect).val()=="") {
                alertify.error("Debe elegir la categoría para el módulo número "+contadorSelect);
                error=1;
                break;
            }    
            contadorSelect++;
        }
        if (totals!=100) {
            alertify.error("Los valores deben sumar 100%");
            error=1;
            nModulos=0;
        }
        if (error==0) {
            $("#paso2").addClass("selected");
            $("#linea").css("transform","scaleX(0.184188)");
            $("#div_paso1").hide("slow");
            $("#div_paso2").show("slow"); 
        }
        // $("#asignarPreguntas").html("");
        for (var i = 0; i < nModulos; i++) {
            $("#asignarPreguntas").append('<div class="card"><div class="card-header text-danger" role="tab" id="heading'+contador+'"><h6 class="mb-0"><a class="collapsed  text-danger" data-toggle="collapse" href="#collapse'+contador+'" aria-expanded="false" aria-controls="collapse'+contador+'">'+nombreModulos[i]+'</a></h6></div><div id="collapse'+contador+'" class="collapse" role="tabpanel" aria-labelledby="heading'+contador+'" data-parent="#accordion"><div class="card-body"><div class="form-group"><h6 class="text-theme">Cantidad de Preguntas por Módulo según Dificultad</h6><div class="col-sm-2"><br><label>Baja</label></div><div class="col-sm-12"><input type="number" class="form-control" id="txt_baja'+contadorInput+'" name="txt_baja'+contadorInput+'" value="0"></div><div class="col-sm-2"><br><label>Media</label></div><div class="col-sm-12"><input type="number" class="form-control" name="txt_media'+contadorInput+'" id="txt_media'+contadorInput+'" value="0"></div><div class="col-sm-2"><br><label>Alta</label></div><div class="col-sm-12"><input type="number" class="form-control" name="txt_alta'+contadorInput+'" id="txt_alta'+contadorInput+'" value="0"></div></div></div></div></div>');
            contador++;
            contadorInput++;
        }  
    }

    function paso1(){
        $("#paso2").removeClass("selected");
        var coordenada=$("#linea").css("transform");
        $("#linea").css("transform","scaleX(0.0822439)");
        $("#div_paso1").show("slow");
        $("#div_paso2").hide("slow");
    }

    function generarInput(){
        var nModulos = $('#txtNumeroModulos').val();
        var contador = 1;
        $("#div_porcentaje").html("");
        for (var i = 0; i < nModulos; i++) {
            $("#div_porcentaje").append('<br><div class="row"><div class="col-md-2"><div class="input-group"><span class="input-group-addon"><i class="mdi mdi-percent"></i></span><input type="number" class="form-control" id="txtPorcentaje'+contador+'" name="txtPorcentaje'+contador+'" placeholder="Porcentaje '+contador+'"></div></div><div class="col-md-8"><div class="input-group"><input type="text" class="form-control" id="txtNombreModulo'+contador+'" name="txtNombreModulo'+contador+'" placeholder="Nombre Módulo '+contador+'"><span class="input-group-addon"><i class="mdi mdi-radiobox-marked"></i></span></div></div><div class="col-md-2"><select class="form-control" name="txt_categoria'+contador+'" id="txt_categoria'+contador+'"><option value="">Elija una Categoría</option><?php foreach ($ListarCategoria as $c): ?><option value="<?php echo  $c["Categoria"] ?>"><?php echo $c["Categoria"] ?></option><?php endforeach; ?></select></div></div>'); 
            contador++;
        }         
        if ($("#txtNumeroModulos").val()!="") {
        $("#btnLimpiar").show("slow"); 
        } 
        $("#div_porcentaje").show("slow");
    }

    function guardar(){
        $("#linea").css("transform","scaleX(0.353516)");
        $("#paso3").addClass("selected");
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>Adm_ModuloTrivia/guardarTrivia",
            data: $('#frmQuiz').serialize(), 
            cache: false,
                success: function(data){
                    alertify.success("Trivia generada satisfactoriamente");
                    setTimeout(function(){
                      window.location = "crearTrivia";
                    }, 2000); 
                }
        });
    }

    function paso3(){
        $("#div_generar").show("slow");
        // // $.get("<?php echo site_url(); ?>Adm_ModuloTrivia/obtenerPreguntaRandom", function(data, status){
        // //    alert("Data: " + data + "\nStatus: " + status);
        // // });
        
        // alert($("#txt_baja1").val());
        var NombreTrivia = $("#txtNombreQuiz").val();
        var nModulos = $('#txtNumeroModulos').val();
        var contador = 1;
        var nombreModulos = new Array();
        var contadorModulos = 1;
        var contadorDif = 1;
        var faciles = new Array();
        var medias = new Array();
        var dificiles = new Array();
        for (var i = 0; i < nModulos; i++) {
            nombreModulos[i] = $("#txtNombreModulo"+contadorModulos).val();  
            contadorModulos++;
        } 
        // alert($("#txt_baja1").val());
        for (var i = 0; i < nModulos; i++) {
            faciles[i] = $("#txt_baja"+contadorDif).val(); 
            medias[i] = $("#txt_media"+contadorDif).val(); 
            dificiles[i] = $("#txt_alta"+contadorDif).val();  
            contadorDif++;
        } 
        // alert(faciles);
        $("#paso3").addClass("selected");
        $("#linea").css("transform","scaleX(0.286168)");
        $("#asignarPreguntas").hide("slow");
        $("#div_paso2").hide("slow");
        $("#div_paso3").show("slow");
        
        // for (var i = 0; i < nModulos; i++) {
        //     $("#div_generar").append('<div class="col-md-12"><div class="card border-danger text-danger mb-3"><div class="card-header"><h5 class="text-theme">'+nombreModulos[i]+'</h5></div><div class="card-body"><div class="row"><div class="col-md-12"><p class="margin"><i class="fa fa-dot-circle-o"></i> Tipo de respuesta esperada</p></div></div><div style="padding-top: 10px;" id="div_eleccion"></div></div><?php foreach ($Categorias as $c) echo $c["TituloPregunta"] ?></div></div>');
        //         contador++;
        // }
        // var nombreModuleArray = JSON.stringfy(nombreModulos);
        // +{ tuArrJson: nombreModuleArray}
        $.ajax({
            url: "<?php echo site_url(); ?>Adm_ModuloTrivia/obtenerPreguntaRandom",
            type: "POST",
            // dataType: 'json',
            dataType: "html",
            data: "nModulos="+nModulos+"&nombreModulos="+nombreModulos+"&faciles="+faciles+"&medias="+medias+"&dificiles="+dificiles+"&NombreTrivia="+NombreTrivia,
            success: function(data) {
                $("#div_generar").html(data); 
                // for (var i = 0; i < data.length; i++) {
                //     console.log(data[i].TituloPregunta);          
                // }
            }                    
        });
    }

    function limpiar(){
        $("#txtNumeroModulos").val("");
        $("#div_porcentaje").hide("slow");      
    }

    

</script>