
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>                
        <li class="breadcrumb-item active">Libro Asistencia</li>
    </ol>
    <br><br>
    <div class="container">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <h4 class="text-theme">Libro de Asistencia</h4>
                            <br>
                            <form action="ExportarLibroAsistenciaPorMes" method="POST" class="form-horizontal" id="libroMes" target="_blank" >
                                <div class="car">
                                    <div class="card-header">
                                        <i class="mdi mdi-arrow-right-drop-circle"></i> Descargar Libro Asistencia
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Elegir una fecha para imprimir el libro de asistencia correspondiente a ese mes, se puede escoger entre 30 o 60 días, en caso de elegir 60 días, se imprime la asistencia del mes escogido y el anterior a este.</p>
                                        <p class="card-text"> Reporte G: Reporte General</p>
                                        <p class="card-text"> Reporte H.E: Reporte de Horas Extras</p>
                                        <p class="card-text"> Reporte D.F: Reporte de Domingos y Feriados</p>
                                        <p class="card-text"> Reporte M: Reporte de Modificaciones</p>
                                        <p class="card-text"> Reporte E: Reporte de Excesos</p>
                                        <br>
                                        <h5 class="text-theme">Filtros</h5>
                                        <br>
                                        <div class="row">
                                            <div class='col-md-4'>
                                                <label for='company'>Nombre del Usuario</label>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'>
                                                        <i class='fa fa-user'></i>
                                                    </span>
                                                    <input type="text" name="txt_nombre" class="form-control">
                                                </div>
                                            </div>
                                            <div class='col-md-4'>
                                                <label for='company'>Apellido Paterno del Usuario</label>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'>
                                                        <i class='fa fa-user-o'></i>
                                                    </span>
                                                    <input type="text" name="txt_apellidoP" class="form-control">
                                                </div>
                                            </div>
                                            <div class='col-md-4'>
                                                <label for='company'>Rut del Usuario</label>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'>
                                                        <i class='fa fa-user-circle'></i>
                                                    </span>
                                                    <input type="text" name="txt_rut" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class='col-md-4'>
                                                <label for='company'>Usuarios</label>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'>
                                                        <i class='fa fa-group'></i>
                                                    </span>
                                                        <select name="lb_usuarios[]" id="lb_usuarios" class="form-control form-control-sm" data-plugin="select2" multiple place-holher="Escoger Usuarios">
                                                        <?php
                                                            foreach ($Usuarios as $u) {
                                                                echo "<option value='".$u['ID_Usuario']."'>".$u['NombreRut']."</option>";   
                                                            }
                                                        ?>
                                                    </select>     
                                                </div>
                                            </div>
                                            <div class='col-md-4'>
                                                <label for='company'>Nombre de Cadena</label>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'>
                                                        <i class='mdi mdi-factory'></i>
                                                    </span>
                                                   <select name="lb_cadena" id="lb_cadena" class="form-control form-control-sm" onchange="ElegirLocalPorCadena()">
                                                        <option value="-1">Escoger una Cadena</option>
                                                        <?php
                                                            foreach ($Cadenas as $c) {
                                                                echo "<option value='".$c['ID_Cadena']."'>".$c['NombreCadena']."</option>";   
                                                            }
                                                        ?>
                                                    </select>     
                                                </div>
                                            </div>
                                            <div class='col-md-4'>
                                                <label for='company'>Nombre de Local</label>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'>
                                                        <i class='mdi mdi-factory'></i>
                                                    </span>
                                                    <select name="lb_local" id="lb_local" class="form-control form-control-sm">
                                                        <option value="-1">Escoger un Local</option>
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <hr>
                                        <button class="btn btn-theme" type="button" title='Libro General' id="btn-rg" onclick="return elegirLibro(1);">
                                            <i class="mdi mdi-file-pdf" id="listAsistencia"></i> Reporte G 
                                        </button>
                                        <button class="btn btn-theme" type="button" title='Libro Horas Extras' id="btn-rhe" onclick="return elegirLibro(2);">
                                            <i class="mdi mdi-file-pdf" id="listAsistencia"></i> Reporte H.E
                                        </button>
                                        <button class="btn btn-theme" type="button" title='Libro Domingos y Feriados' id="btn-rdf" onclick="return elegirLibro(3);">
                                            <i class="mdi mdi-file-pdf" id="listAsistencia"></i> Reporte D.F 
                                        </button>
                                        <button class="btn btn-theme" type="button" title='Libro Modificaciones' id="btn-rm" onclick="return elegirLibro(4);">
                                            <i class="mdi mdi-file-pdf" id="listAsistencia"></i> Reporte M
                                        </button>
                                        <button class="btn btn-theme" type="button" title='Libro Excesos' id="btn-re" onclick="return elegirLibro(5);">
                                            <i class="mdi mdi-file-pdf" id="listAsistencia"></i> Reporte E
                                        </button>
                                        <br>
                                        <br>
                                        <div class="row" id="div_libroAsis" style="display: none;">  
                                            <div class='input-group'>              
                                                <div class="col-sm-3" id="div_fechas" style="margin-top: 13px !important;" style="display: none;" >
                                                    <select class="form-control select2" id='txt_libro' name='txt_libro' style="width: 100%;" onchange="validarFechaLibroAsistencia();">
                                                        <option value="">Elegir Fechas</option>
                                                        <?php 
                                                            foreach ($Fechas as $F) {
                                                                echo "<option value='".$F["ID_Fecha"]."'>".$F["Fecha"]."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    <div  id="val_libro" style="color:red;"></div>   
                                                    <br>     
                                                </div>
                                                <div class="col-sm-3" id="div_rango30" style="margin-top: 13px !important;" style="display: none;">
                                                    <select class="form-control select2" id ="txt_rango30" name='txt_rango30' style="width: 100%;" onchange="validarFechaLibroAsistencia();">
                                                        <option value="">Escoger Rango</option>
                                                        <option value="1">Reporte de 30 Días</option>
                                                        <option value="2">Reporte de 60 Días</option>
                                                    </select>
                                                    <div  id="val_rango30" style="color:red;"></div>   
                                                    <br>     
                                                </div>
                                                <div class="col-sm-3" id="div_rangoMulti" style="margin-top: 13px !important;" style="display: none;">
                                                    <select class="form-control select2" id ="txt_rangomulti" name='txt_rangomulti' style="width: 100%;" onchange="validarFechaLibroAsistencia();">
                                                        <option value="">Escoger Rango</option>
                                                        <option value="1">Reporte Semanal</option>
                                                        <option value="2">Reporte Quincenal</option>
                                                        <option value="2">Reporte Mensual</option>
                                                    </select>
                                                    <div  id="val_rango30" style="color:red;"></div>   
                                                    <br>     
                                                </div>
                                                <div class="col-sm-3">
                                                    <div id="dv_descargar" style="display: none;">              
                                                        <button class="btn btn-theme" type="submit" title='Descargar Libro Asistencia' id="bt_libroAsistencia"><i class="mdi mdi-file-pdf" id="listAsistencia"></i> Descargar Libro</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="card-footer text-muted"></div>
                                </div>    
                                <input type="hidden" name="txt_eleccion" id="txt_eleccion">                         
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript">
    //select multiple 1
    $('#lb_usuarios').select2({});
    $('#lb_local').select2({});
    $('#lb_cadena').select2({});

    $('#btn-re').click(function(){ 
        $("#btn-rg").attr("class","btn btn-theme");
        $("#btn-rhe").attr("class","btn btn-theme");
        $("#btn-rdf").attr("class","btn btn-theme");
        $("#btn-rm").attr("class","btn btn-theme");
        $("#btn-re").attr("class","btn btn-outline-theme");
    });
    $('#btn-rg').click(function(){ 
        $("#btn-rg").attr("class","btn btn-outline-theme");
        $("#btn-rhe").attr("class","btn btn-theme");
        $("#btn-rdf").attr("class","btn btn-theme");
        $("#btn-rm").attr("class","btn btn-theme");
        $("#btn-re").attr("class","btn btn-theme");
    });
    $('#btn-rhe').click(function(){ 
        $("#btn-rg").attr("class","btn btn-theme");
        $("#btn-rhe").attr("class","btn btn-outline-theme");
        $("#btn-rdf").attr("class","btn btn-theme");
        $("#btn-rm").attr("class","btn btn-theme");
        $("#btn-re").attr("class","btn btn-theme");
    });
    $('#btn-rdf').click(function(){ 
        $("#btn-rg").attr("class","btn btn-theme");
        $("#btn-rhe").attr("class","btn btn-theme");
        $("#btn-rdf").attr("class","btn btn-outline-theme");
        $("#btn-rm").attr("class","btn btn-theme");
        $("#btn-re").attr("class","btn btn-theme");
    });
    $('#btn-rm').click(function(){ 
        $("#btn-rg").attr("class","btn btn-theme");
        $("#btn-rhe").attr("class","btn btn-theme");
        $("#btn-rdf").attr("class","btn btn-theme");
        $("#btn-rm").attr("class","btn btn-outline-theme");
        $("#btn-re").attr("class","btn btn-theme");
    });
</script>