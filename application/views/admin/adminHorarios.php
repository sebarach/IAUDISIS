<style type="text/css">
    th { font-size: 12px; }
    td { font-size: 11px; }

    #loader {
  position: absolute;
  left: 50%;
  top: 72.5%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #f03434;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

.btn-table{
    margin-top: 0 !important;
    font-size: 11px;
    padding: 0.375rem 0.75rem;

}
.h6 {
   font-size: 0.6rem;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Rutas</a>
        </li>
        <li class="breadcrumb-item active">Jornadas Asignadas</li>
    </ol>
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-accent-theme">
                <div class="card-body">
                    <h4 class="text-theme">Jornadas Asignadas</h4> 
                    <p>Este modulo fue diseñado para administrar los días en que uno tienen que entrar a su PDV y a la hora. Aquí podemos visualizar todo el horario del mes actual, ademas podemos modificar el horario de entrada o salida de un día especifico o cambiar el PDV asignado al Usuario.</p>                     
                </div>
                <hr>
                <div class="col-md-12">
                    <div class="card-body">
                        <h4 class="text-theme">Actualizar Horario</h4> 
                        <p>Descarge el horario del mes actual para poder editar. Solo se puede editar la entrada y salida de cada día del mes contando del día actual y futuros.</p> 
                        <div class="btn-group">
                            <button data-toggle="modal" data-target=".bs-example-modal-Horario" id="actualizarHorarioBtn" type="button" class="btn btn-danger" onclick="actualizarHorario()"><i class="mdi mdi-table-edit"></i>Actualizar Horario</button>&nbsp;
                        </div> 
                        <div class="btn-group">
                            <button data-toggle="modal" data-target=".bs-example-modal-HorarioJornada" id="jornadaHorarioBtn" type="button" class="btn btn-danger" onclick="ingresarJornadaNueva()"><i class="mdi mdi-calendar-clock"></i>Ingresar Jornadas</button>
                        </div>                   
                    </div>
                </div>
                <hr>
                <div class="col-md-12">              
                    <div class="card-body">
                <?php   
                    date_default_timezone_set("Chile/Continental");
                        $day=date("d");
                        // $day=25;
                        $mes=date("m");
                        $anio=date("Y");
                        $numerosDias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); 
                        if ($Perfil==1 || $Perfil==2 && $AsignadoBoton["Activo"]==1) {
                             ?>
                            <h4 class="text-theme">Asignar Permisos</h4> 
                            <p>En este módulo asignaremos permisos laborales remunerados o no remunerados a un usuario o a un gurpo de ellos.</p>
                            <div class="btn-group">
                                <button data-toggle="modal" data-target=".bs-example-modal-Permisos" id="asignarPermiso" type="button" class="btn btn-danger" onclick="asignarPermiso()">Asignar Permiso a Usuarios</button>&nbsp;&nbsp;
                                <button data-toggle="modal" data-target=".bs-example-modal-PermisosGrupo" id="asignarPermisoGrupo" type="button" class="btn btn-danger" onclick="asignarPermisoGrupo()">Asignar Permiso a Grupo de Usuarios</button>
                        </div> 
                        <hr>
                    <?php 
                    } ?>
                    <?php if($Perfil==1 || $Perfil==2){ ?>                     
                    <div class="btn-group">            
                        <p><i id="refsh" class='mdi mdi-filter-outline'></i><strong> Filtros</strong><br><button  type="button" class="btn btn-outline-theme btn-sm" onclick="refrescar()"><i id="refsh" class='mdi mdi-filter-remove-outline'></i>Limpiar Filtros</button>
                        <button  type="button" class="btn btn-outline-theme btn-sm" onclick="Filtrar()"><i id="refsh" class='mdi mdi-search-web'></i>Filtrar Horario</button></p>
                    </div>
                    </div>  
                        <div class="input-group">
                            <span class='input-group-addon'><i class='fa fa-user'></i></span>
                                <select class='form-control select2' id='usuario' data-plugin='select2' name='usuario'>
                                    <option value=''>Buscar por usuario</option>
                                    <?php foreach ($ListarUsuario as $e) { 
                            echo "  <option value='".$e['id_usuario']."'>".$e['Nombres']."<br> <small>(Rut: ".$e['Rut'].")</small></option>";}?>
                            </select>                                       
                        &nbsp;&nbsp;&nbsp;&nbsp;
                            <span class='input-group-addon'><i class='mdi mdi-factory'></i></span>
                            <select class='form-control select3' id='id_local' name='id_local' data-plugin='select3' >
                                    <option value=''>Buscar por Local</option>
                                    <?php foreach ($Locales as $e) { 
                            echo "  <option value='".$e['ID_Local']."'>".$e['NombreLocal']."</option>";}?>
                            </select>  
                        &nbsp;&nbsp;&nbsp;&nbsp;
                            <span class='input-group-addon'><i class='mdi mdi-calendar-text'></i></span>
                            <select class='form-control select3' id='id_fecha' name='id_fecha' data-plugin='select3' >
                                    <option value=''>Buscar por Mes</option>
                                    <?php foreach ($ListarFechaFuturo as $f) { 
                            echo "  <option value='".$f['ID_Fecha']."'>".$f['Fecha']."</option>";}?>
                            </select>                                      
                        </div>
                    </div>                      
                    <?php } ?>
                    <hr>
                    <?php if ($day!=$numerosDias) { ?>
                    <div class="col-md-12">              
                        <div class="card-body">                      
                            <div class="btn-group">
                                <button data-toggle="modal" data-target=".bs-example-modal-IngresarJor" id="actualizarHorarioBtn" type="button" class="btn btn-danger" onclick="agregarJornada()"><i class="mdi mdi-calendar-plus"></i>Agregar Jornada</button>
                            </div> 
                        </div>              
                    </div>  
                    <?php } ?>

                    <div id="tablaAdmJornadas">
                        <div id="loader" style="display: none;" ></div>
                    <table id="example" class="table color-bordered-table danger-bordered-table"  width="100%" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <?php if ($Perfil==1 || $Perfil==2 && $AsignadoEditar["Activo"]==1) { ?>
                                <th></th> 
                                <?php } ?>                                               
                                <th>Nombre Local</th>
                                <?php
                                    $ndias=cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); 
                                    for ($i=date("j"); $i < $ndias+1; $i++) { 
                                            echo '<th style="text-align: center;">Entrada Día '.$i.'</th>
                                            <th style="text-align: center;">&nbsp;Salida &nbsp;Día '.$i.'</th>';
                                    }
                                    for ($i=1; $i < date("j"); $i++) { 
                                            echo '<th style="text-align: center;">Entrada Día '.$i.'</th>
                                            <th style="text-align: center;">&nbsp;Salida &nbsp;Día '.$i.'</th>';
                                    }
                                ?>
                                
                               
                            </tr>
                        </thead>
                        <tbody >
                            <?php
                                $b=':' ;                                 
                                foreach ($horarios as $c) {    
                                    echo "<tr>"; 
                                    echo "<form  class='form-horizontal' id='horario-".$c['ID_Jornada']."'  method='POST' enctype='multipart/form-data'>
                                            <input type='hidden' id='idjornada' name='idjornada' value='".$c['ID_Jornada']."'>
                                            <input type='hidden' name='idUser' value='".$c['ID_Usuario']."' >";
                                    echo "<td>".$c["Nombres"]."<br><small>".$c['Rut']."</small></td>";
                                    if ($Perfil==1 || $Perfil==2 && $AsignadoEditar["Activo"]==1) {
                                        echo "<td><div class='btn-group btn-group-sm' role='group' aria-label='Basic example'>
                                                <button type='button' class='btn btn-outline-danger btn-table' id='EHbtn-".$c['ID_Jornada']."' onclick='EditHorario(".$c['ID_Jornada'].");' title='Editar Jornada' ><i class='fa fa-edit ' id='EHicn-".$c['ID_Jornada']."' ></i></button>"; 
                                        $h=0;
                                        for ($i=1; $i < $ndias+1; $i++) { 
                                            if ((strpos($c['Entrada'.$i],$b)===false)) { 
                                                $h++;
                                            }
                                            if ((strpos($c['Salida'.$i],$b)===false)) {
                                                $h++;
                                            }
                                        }
                                        if($h>0){
                                            echo "<button class='btn btn-outline-danger btn-table' title='Revocar Permisos' type='button' data-toggle='modal' data-target='.bs-example-modal-VerPermiso' onclick='verPermisoU(".$c["ID_Jornada"].",".$c["ID_Usuario"].")'><i class='fa fa-calendar'></i></button>";
                                        }
                                        if($c["Activo"]==0){ 
                                            echo "<button type='button' class='btn btn-outline-danger btn-table'   onclick='cambiarEstadoJornada(".$c["ID_Jornada"].",".$c["Activo"].",".$c["ID_Usuario"].")' title='Activar Jornada' ><i class='fa fa-times' ></i></button>";
                                        } else {
                                            echo "<button type='button' class='btn btn-outline-success btn-table'  onclick='cambiarEstadoJornada(".$c["ID_Jornada"].",".$c["Activo"].",".$c["ID_Usuario"].")' title='Desactivar Jornada' ><i class='fa fa-check' ></i></button>";
                                        }
                                        echo "</div></td>";

                                    }
                                    echo "<td><div class='btn-group btn-group-sm' role='group' >
                                        <button type='button' class='btn btn-info btn-table' style='width:16rem; font-size:0.75rem; white-space: pre-line;' data-toggle='modal' data-target='#mapLocal'  title='mapa de Local'  onclick='mapaLocal(".$c['ID_Local'].")' ><i class='fa fa-map-marker'></i>".$c['NombreLocal']."</button></div></td>"; 
                                    for ($i=date("j"); $i < $ndias+1; $i++) { 
                                        $dia= ($i<10) ? "0".$i : $i;
                                        if ((strpos($c['Entrada'.$i],$b)===false)) { 
                                            echo "<td><span class='badge badge-boxed badge-danger btn-table'>".$c["Entrada".$i]."</span></td>";
                                        } else {
                                            echo "<td><input  style='font-size: 11px; min-height: 20px; '  type='text' class='form-control' id='Edia-".$i."-".$c['ID_Jornada']."' name='Edia-".$i."-".$c['ID_Jornada']."' value='".$c['Entrada'.$i]."' data-plugin='timepicker' disabled />
                                                <input  style='font-size: 12px;' type='hidden' name='IDEdia-".$i."-".$c['ID_Jornada']."' value='".$c['ID_Local']."-".date("Y").date("m").$dia."'>
                                                </td>";
                                        }
                                        if ((strpos($c['Salida'.$i],$b)===false)) {
                                             echo "<td><span class='badge badge-boxed badge-danger btn-table'>".$c["Salida".$i]."</span></td>";
                                        } else {
                                            echo"<td><input  style='font-size: 11px; min-height: 20px;' type='text' class='form-control'  id='Sdia-".$i."-".$c['ID_Jornada']."' name='Sdia-".$i."-".$c['ID_Jornada']."' value='".$c['Salida'.$i]."' data-plugin='timepicker' disabled />
                                            <input  style='font-size: 12px;' type='hidden' name='IDSdia-".$i."-".$c['ID_Jornada']."' value='".$c['ID_Local']."-".date("Y").date("m").$dia."'></td>";
                                        }
                                    }
                                    for ($i=1; $i < date("j"); $i++) {
                                        $dia= ($i<10) ? "0".$i : $i;
                                        if ((strpos($c['Entrada'.$i],$b)===false)) { 
                                            echo "<td><span class='badge badge-boxed badge-danger btn-table'>".$c["Entrada".$i]."</span></td>";
                                        } else {
                                            echo "<td><input  style='font-size: 11px; min-height: 20px; '  type='text' class='form-control' id='Edia-".$i."-".$c['ID_Jornada']."' name='Edia-".$i."-".$c['ID_Jornada']."' value='".$c['Entrada'.$i]."' data-plugin='timepicker' disabled />
                                                <input  style='font-size: 12px;' type='hidden' name='IDEdia-".$i."-".$c['ID_Jornada']."' value='".$c['ID_Local']."-".date("Y").date("m").$dia."'>
                                                </td>";
                                        }
                                        if ((strpos($c['Salida'.$i],$b)===false)) {
                                             echo "<td><span class='badge badge-boxed badge-danger btn-table'>".$c["Salida".$i]."</span></td>";
                                        } else {
                                            echo"<td><input  style='font-size: 11px; min-height: 20px;' type='text' class='form-control'  id='Sdia-".$i."-".$c['ID_Jornada']."' name='Sdia-".$i."-".$c['ID_Jornada']."' value='".$c['Salida'.$i]."' data-plugin='timepicker' disabled />
                                            <input  style='font-size: 12px;' type='hidden' name='IDSdia-".$i."-".$c['ID_Jornada']."' value='".$c['ID_Local']."-".date("Y").date("m").$dia."'></td>";
                                        }
                                    }

                                    echo "</form>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>

                    
               
        <?php 
                if(isset($opcion) && $mesActual==$mes){                   
                    echo "<div class='col-md-4'>
                    <nav aria-label='Page navigation example'>
                        <ul class='pagination'>";
                    if($opcion!=1){
                       
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion-1)."' ><i class='mdi mdi-arrow-left-bold'></i> Anterior</a></li>";
                    }
                    if(($opcion-2)>0){
                      
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion-2)."' >".($opcion-2)."</a></li>";
                    }
                    if(($opcion-1)>0){
                        
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion-1)."' >".($opcion-1)."</a></li>";
                    }   

                    echo "<li class='page-item active'><a class='page-link text-red' style='border-color: #e01111; background-color: #fff; color: #e01111;' href=''  ><span class='badge badge-danger hertbit'>$opcion</span></a></li>";

                    if(($opcion+1)<=$cantidad){
                        
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion+1)."' >".($opcion+1)."</a></li>";
                    }
                    if(($opcion+2)<=$cantidad){
                       
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion+2)."' >".($opcion+2)."</a></li>";
                    }
                    if(($opcion+3)<=$cantidad){
                         echo "<li class='page-item'><a class='page-link bg-danger text-white'>...</a></li>";
                       
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=$cantidad'>$cantidad</a></li>";
                    }
                    if($opcion!=$cantidad){
                      
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/adminHorario?opcion=".($opcion+1)."'>Siguiente <i class='mdi mdi-arrow-right-bold'></i></a></li>
                        </ul>
                    </nav>";
                    }
                    echo "</div>";  
                         
                if(isset($opcion) && $mesActual!=$mes){                
                    echo "<div class='col-md-4'>
                    <nav aria-label='Page navigation example pull-right'>
                        <ul class='pagination'>";
                         if($opcion!=1){
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion-1)."' ><i class='mdi mdi-arrow-left-bold'></i> Anterior</a></li>";
                    }
                    if(($opcion-2)>0){
                      
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion-2)."' >".($opcion-2)."</a></li>";
                    }
                    if(($opcion-1)>0){
                        
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion-1)."' >".($opcion-1)."</a></li>";
                    }   

                    echo "<li class='page-item active'><a class='page-link text-red' style='border-color: #e01111; background-color: #fff; color: #e01111;' href=''  ><span class='badge badge-danger hertbit'>$opcion</span></a></li>";

                    if(($opcion+1)<=$opcion){
                        
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion+1)."' >".($opcion+1)."</a></li>";
                    }
                    if(($opcion+2)<=$cantidad){
                       
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion+2)."' >".($opcion+2)."</a></li>";
                    }
                    if(($opcion+3)<=$cantidad){
                         echo "<li class='page-item'><a class='page-link bg-danger text-white'>...</a></li>";
                       
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=$cantidad'>$cantidad</a></li>";
                    }
                    if($opcion!=$cantidad){
                      
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloJornadas/buscarMesAnio?opcion=".($opcion+1)."'>Siguiente <i class='mdi mdi-arrow-right-bold'></i></a></li>
                        </ul>
                    </nav>";
                    }
                }   
                    echo"                    
                   
                    
                </div>";
            }?>
        </div>        
    </div>            
                <!-- end container-fluid -->
                <!-- Modal Desactivar -->
    <div class="modal fade" id="modal-desactivar" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Desactivar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado1"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarEstado').submit();">Desactivar Horario</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activar" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Activar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarEstado').submit();">Activar Horario</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-Permisos" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="AsignarPermisos">
        <div class="modal-dialog ">
            <div class="modal-content" id="AsignarPermiso">
             
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-PermisosGrupo" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="AsignarPermisoGrupos">
        <div class="modal-dialog ">
            <div class="modal-content" id="AsignarPermisoGrupo">
             
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-VerPermiso" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" >
        <div class="modal-dialog ">
            <div class="modal-content" id="VerPermiso">
             
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="mapLocal">
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class="modal-header bg-info">
                    <h6 class="modal-title text-white">Ubicación del Local</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- <div class="modal-body"> -->
                    <div class="row">
                        <div class="col-md-12" id='modalmapa'>
                                    
                        </div>
                    </div>
                <!-- </div> -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-Horario" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="actualizarHorarios">
        <div class="modal-dialog ">
            <div class="modal-content" id="actualizarHorario">
             
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-HorarioJornada" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="ingresarJornadaNuevas">
        <div class="modal-dialog ">
            <div class="modal-content" id="ingresarJornadaNueva">
             
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-IngresarJor" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="ingresarJornadas">
        <div class="modal-dialog ">
            <div class="modal-content" id="ingresarJornada">
             
            </div>
        </div>
    </div>

    </main>

    <!-- <script src="<?php echo  site_url(); ?>/assets/js/form-plugins-example.js"></script> -->
    <script src="<?php echo  site_url(); ?>/assets/libs/typeahead/typeahead.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/timepicker/dist/jquery.timepicker.min.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/multiselect/js/jquery.multi-select.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/form-masks/dist/formatter.min.js"></script>
    

<script type="text/javascript">

    function Filtrar(){
        $("#loader").removeAttr("style","table-loading-overlay");
        var id_fecha =$("#id_fecha").val(); 
        var id_local =$("#id_local").val(); 
        var usuario =$("#usuario").val(); 
        $.ajax({
            url: "<?php echo site_url();?>Adm_ModuloJornadas/filtrarHorario",
            type: "POST",
            data: 'id_fecha='+id_fecha+"&id_local="+id_local+"&usuario="+usuario,
            success: function(data){
                $("#loader").attr("style","display:none;");
                // $("#tablaAdmJornadas").html('');
                $("#tablaAdmJornadas").html(data);
            }
        });
    }




    function refrescar(){
        $("#refsh").attr('class','fa-spin fa fa-refresh');
        setTimeout(function(){
            window.location = "adminHorario";
        }, 1000); 
    }

    

    function asignarPermiso(){
        $.ajax({
            url: "<?php echo site_url();?>Adm_ModuloJornadas/AsignarPermisoUsuario",
            type: "POST",    
            success: function(data) {
              $("#AsignarPermiso").html(data);
             }
        });
    }

    function asignarPermisoGrupo(){
        $.ajax({
            url: "<?php echo site_url();?>Adm_ModuloJornadas/AsignarPermisoUsuarioGrupo",
            type: "POST",
            success: function(data){
                $("#AsignarPermisoGrupo").html(data);
            }
        });
    }

    function verPermisoU(idJornada,idUser){
        $.ajax({
            url: "<?php echo site_url();?>Adm_ModuloJornadas/VerPermiso",
            type: "POST",
            data: "idUser="+idUser+"&idJornada="+idJornada,
            success: function(data){
                $("#VerPermiso").html(data);
            }
        });
    }

   


        //Estado Usuario
        function cambiarEstadoJornada(idjor,Estado,iduser){
            $.ajax({
                url: "<?php echo site_url();?>Adm_ModuloJornadas/EditarEstadoJornada",
                type: "POST",
                data: "idjor="+idjor+"&estado="+Estado+"&iduser="+iduser,
                success: function(data) {                
                    if(Estado==1){
                        $("#estado1").html("");
                        $("#estado1").html(data);
                        $("#modal-activar").modal('hide');
                        $("#modal-desactivar").modal('show');
                    }else{
                        $("#estado2").html("");
                        $("#estado2").html(data);
                        $("#modal-desactivar").modal('hide');
                        $("#modal-activar").modal('show');
                    }                
                }
            });
        }


        function mapaLocal(ID_Local){      
            $.ajax({
                    url: "<?php echo site_url();?>Adm_ModuloJornadas/mapaLocal",
                    type: "POST",
                    data: "ID_Local="+ID_Local,
                    success: function(data) {
                      // $("#modalmapa").html('');
                      $("#modalmapa").html('');
                      $("#modalmapa").html(data);
                     }
                });
              }



        $('.select2').select2({});
        $('.select3').select2({});
        

        
        
    
    

    function EditHorario(idjor){
        $("#EHicn-"+idjor).attr('class', 'fa fa-save'); 
        $("#EHbtn-"+idjor).attr('class', 'btn btn-outline-danger btn-table');
        $("#EHbtn-"+idjor).attr('title', 'Guardar Jornada');
        $("#EHbtn-"+idjor).attr('onclick', 'GuardarHorario('+idjor+');');
        // $("#NLoc-"+idjor).attr('onchange', 'autocompeteLoc('+idjor+');');
        $("#NLoc-"+idjor).removeAttr("disabled");
        var dias = '<?php echo $numeros = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); ?>';
        for (var i = <?php echo $numero = date("j"); ?>; i <= dias; i++) {
            $("#Edia-"+i+"-"+idjor).removeAttr("disabled");
            $("#Sdia-"+i+"-"+idjor).removeAttr("disabled");
        }
        
      }


    function verrevoc(){ 
        $("[id*=divperm]").hide();
        $("[id*=divhora]").hide();
        var id=$("#idHor").val(); 
        if(id!='0'){
            if($("#divperm"+id).is(':hidden')){
                $("#divperm"+id).show(); 
            } else { 
                $("#divperm"+id).hide(); 
            } 
        }
    }


    function veraddhora(id){
        if($("#divhora"+id).is(':hidden')){
            $("#divhora"+id).show(); 
        } else { 
            $("#divhora"+id).hide(); 
        }
    }


    function revocarPermiso(){
        var id=$("#idHor").val();
       if(id!='0'){
            if($("#Edia-"+id).val()!="" && $("#Sdia-"+id).val()!=""){
                $.ajax({
                    type: 'POST',                 
                    url:'RevocarPermisoF',                     
                    data: $('#mCerrarPermiso').serialize(), 
                    dataType:'json',
                    success: function(data)             
                    {  
                        alertify.success('Permiso Revocado');
                        $("[id*=divperm]").hide();
                        $("[id*=divhora]").hide();
                        setTimeout(function(){
                            window.location = 'adminHorario';
                        }, 1000); 
                    }
                });
            } else {
                alertify.danger('Debe ingresar horario de entrada y salida');
            }
        } else {
            alertify.dagner('Debe seleccionar una fecha.');
        }      

    }


    function GuardarHorario(idjor){
        $("#EHicn-"+idjor).attr("class","fa fa-spin fa-circle-o-notch"); 
        $.ajax({
            url: "<?php echo site_url();?>Adm_ModuloJornadas/EditarHorarioUser",
            type: "POST",
            data: $("#horario-"+idjor).serialize(),
            dataType:"json",
            success: function(data) {
                alertify.success("Horario Editado con Exito");                  
                $("#EHicn-"+idjor).attr("class","fa fa-edit");
                $("#EHbtn-"+idjor).attr('class', 'btn btn-outline-danger btn-table');
                $("#EHbtn-"+idjor).attr('onclick',"EditHorario("+idjor+")");
                var dias = '<?php echo $numeros = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); ?>';
                for (var i = <?php echo $numero = date("j"); ?>; i <= dias; i++) {
                    $("#Edia-"+i+"-"+idjor).prop("disabled",true);
                    $("#Sdia-"+i+"-"+idjor).prop("disabled",true);
                }
                // setTimeout(function(){window.location.reload();}, 1000);

            }
        });
    }


  $(document).ready(function() {
    var table = $('#example').removeAttr('width').DataTable( {
        scrollY:        "450px",
        scrollX:        true,
        searching: false,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            leftColumns: 1,
        },
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
    } );

    <?php 
        $numeros = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $b=':' ; 
        foreach ($horarios as $c) { 
            for ($i=1; $i < $numeros+1; $i++) { 
                if ((strpos($c['Entrada'.$i],$b)!== false)) { 
                    echo '$("#Edia-'.$i.'-'.$c['ID_Jornada'].'").timepicker();';
                }
                if ((strpos($c['Salida'.$i],$b)!== false)) { 
                    echo ' $("#Sdia-'.$i.'-'.$c['ID_Jornada'].'").timepicker();';
                }
            }
        }?>
} );

    function ingresarJornadaNueva(){
        $.ajax({
            url: "ingresarJornadaNueva",
            type: "POST",   
            success: function(data) {
              $("#ingresarJornadaNueva").html(data);
             }
        });
    }

    function actualizarHorario(){
      $.ajax({
            url: "actualizarHorario",
            type: "POST",   
            success: function(data) {
              $("#actualizarHorario").html(data);
             }
        });
    }

    function agregarJornada(){
        $.ajax({
            url: "ingresarJornada",
            type: "POST",   
            success: function(data) {
              $("#ingresarJornada").html(data);
             }
        });
    }

    </script>


   