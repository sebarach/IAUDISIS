<main class="main">
            <!-- Breadcrumb -->
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>                
        <li class="breadcrumb-item active">Libro Asistencia</li>
    </ol>

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
                                        <p class="card-text">Elegir fecha para imprimir el libro de asistencia correspondiente.</p>
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
                                        <br>
                                        <div class="row" id="div_libroAsis">  
                                            <div class='input-group'>              
                                                <div class="col-sm-3" id="div_fechas" style="margin-top: 13px !important;">
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
                                                <div class="col-sm-3">
                                                    <div id="dv_descargarexcel" style="display: none;">              
                                                        <button class="btn btn-theme" type="submit" title='Descargar Libro Asistencia' id="bt_libroAsistencia" onclick="elegirTipoDescarga(6);"><i class="mdi mdi-file-excel" id="listAsistencia"></i> Descargar Excel</button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div id="dv_descargarpdf" style="display: none;">              
                                                        <button class="btn btn-theme" type="submit" title='Descargar Libro Asistencia' id="bt_libroAsistencia" onclick="elegirTipoDescarga(7);"><i class="mdi mdi-file-pdf" id="listAsistencia" ></i> Descargar PDF</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="card-footer text-muted"></div>
                                </div>    
                                <input type="hidden" name="txt_eleccion" id="txt_eleccion" value="6">          
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript">
    //select multiple 1
    $('#lb_usuarios').select2({});
    $('#lb_local').select2({});
    $('#lb_cadena').select2({});
</script>