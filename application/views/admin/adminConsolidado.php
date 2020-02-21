<main class="main">
<div class="card card-accent-theme">  
    <div class="card-body"> 
        <div class="row">
          <div class="col-10">
                <h4 class="text-theme">Indicadores</h4><small class="text-darck"><?php 
                setlocale(LC_ALL, 'es_ES');
                $monthNum  = date('m');
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = strftime('%B', $dateObj->getTimestamp());
                echo ucfirst($monthName." ");
                echo date('j, Y');?></small>
          </div>
          <div class="col-2">   
              <img src='<?php echo site_url().'archivos/foto_Cliente/'.$foto;?>'>
          </div>
        </div>
        <br>        
        <hr>             
        <div class="row">
            <div class="col-6 col-lg-3">
                <div class="card card-accent-right-danger">
                    <div class="card-body p-3 clearfix">
                        <i class="fa fa-road bg-danger p-3 font-2xl mr-3 float-left text-white"></i>
                        <div class="h5 text-danger mb-0 mt-2"><?php echo $Rutas['Rutas']; ?></div>
                        <div class="text-muted text-uppercase font-weight-bold font-xs">Rutas Programadas para hoy</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card card-accent-right-danger">
                    <div class="card-body p-3 clearfix">
                        <i class="fa fa-user-circle-o bg-danger p-3 font-2xl mr-3 float-left text-white"></i>
                        <div class="h5 text-danger mb-0 mt-2"><?php echo $NUsuarios['Usuarios']-$Marcas['Asistencias']; ?> (<?php if($NUsuarios['Usuarios']!=0) {echo intval((($NUsuarios['Usuarios']-$Marcas['Asistencias'])/$Rutas['Rutas'])*100);}?>%)</div>
                        <div class="text-muted text-uppercase font-weight-bold font-xs">Rutas en ejecución</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card card-accent-right-danger">
                    <div class="card-body p-3 clearfix">
                        <i class="fa fa-trophy bg-danger p-3 font-2xl mr-3 float-left text-white"></i>
                        <div class="h5 text-danger mb-0 mt-2"><?php echo $Marcas['Asistencias']; ?> (<?php if($NUsuarios['Usuarios']!=0) {echo intval(($Marcas['Asistencias']/$Rutas['Rutas'])*100);}?>%)</div>
                        <div class="text-muted text-uppercase font-weight-bold font-xs">Rutas completadas</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card card-accent-right-danger">
                    <div class="card-body p-3 clearfix">
                        <i class="fa fa-globe bg-danger p-3 font-2xl mr-3 float-left text-white"></i>
                        <div class="h5 text-danger mb-0 mt-2"><?php $faltante=($Rutas['Rutas']-$Marcas['Asistencias'])-($NUsuarios['Usuarios']-$Marcas['Asistencias']); echo ($Rutas['Rutas']-$Marcas['Asistencias'])-($NUsuarios['Usuarios']-$Marcas['Asistencias']) ?> (<?php if($NUsuarios['Usuarios']!=0) {echo intval(($faltante/$Rutas['Rutas'])*100);}?>%)</div>
                        <div class="text-muted text-uppercase font-weight-bold font-xs">Rutas Faltantes</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card text-center w-100 card-accent-right-danger">
            <div class="card-body">
                <h3 class="card-title text-danger">Tiempo promedio en PDO</h3>
                <h4><?php if ($Promedio==null) { ?>
                  <h4> -- </h4>
                <?php }else{ ?>
                  <h4><?php echo $Promedio; ?></h4>
                <?php  } ?>
            </div>
        </div>
        <div class="card text-center w-100 card-accent-right-danger">
            <div class="card-body">
                <h2 class="text-center text-theme">Registro Marcación</h2>
                <div class="table-responsive">
                    <table id="tabla1" class="table color-bordered-table danger-bordered-table">
                        <thead>
                            <tr>
                                <th>Nombres (Rut)</th>
                                <th>Cargo</th>
                                <th>Local</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Marca Entrada</th>
                                <th>Marca Salida</th>
                                <th>Tiempo en PDO</th>
                                <th>Permiso</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($TablaUser as $Tu) { ?>
                            <tr>
                                <td><?php echo $Tu["Nombres"]; ?> (<?php echo $Tu["Rut"]; ?>)</td>
                                <td><?php echo $Tu["Cargo"]; ?></td>
                                <td><?php echo $Tu["NombreLocal"]; ?></td>
                                <td><?php echo $Tu["Entrada"]; ?></td>
                                <td><?php echo $Tu["Salida"]; ?></td>
                                <td><?php if ($Tu["HoraEntrada"]==null) { ?>
                                    -
                                <?php }else{
                                    echo $Tu["HoraEntrada"]; ?></td>
                                <?php } ?>
                                <td><?php if ($Tu["HoraSalida"]==null) { ?>
                                    -
                                <?php }else{
                                    echo $Tu["HoraSalida"]; ?></td>
                                <?php } ?>
                                <td><?php if ($Tu["TiempoPDO"]==null) { ?>
                                    -
                                <?php }else{ 
                                    echo $Tu["TiempoPDO"]; ?></td>
                                <?php } ?>
                                <td><?php echo $Tu["NombrePermiso"]; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card text-center w-100 card-accent-right-danger">
            <div class="card-body">
                <h2 class="text-center text-theme">Registro de Rutas</h2>
                <div class="table-responsive">
                    <table id="tabla2" class="table color-bordered-table danger-bordered-table">
                        <thead>
                            <tr>
                                <th>Nombres (Rut)</th>
                                <th>Número de Rutas</th>
                                <th>Rutas Completadas</th>
                                <th>Rutas en Ejecución</th>
                                <th>Rutas Faltantes</th>
                                <th>Requerimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Requerimiento as $re) { ?>
                            <tr>
                                <td><?php echo $re["Nombres"]; ?> (<?php echo $re["Rut"]; ?>)</td>
                                <td><?php echo $re["NRutas"]; ?></td>
                                <td><?php echo $re["NCompletadas"]; ?></td>
                                <td><?php echo $re["NEjecucion"]; ?></td>
                                <td><?php echo $re["NRutasFaltantes"]; ?></td>
                                <td><?php echo $re["Requerimiento"]; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card text-center w-100 card-accent-right-danger">
            <div class="card-body">
                <h2 class="text-center text-theme">Requerimientos Especiales</h2>
                <div class="table-responsive">
                    <table id="tabla3" class="table color-bordered-table danger-bordered-table">
                        <thead>
                            <tr>
                                <th>Nombres (Rut)</th>
                                <th>Requerimiento</th>
                                <th>Fecha</th>
                                <th>Latitud</th>
                                <th>Longitud</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Req as $r) { ?>
                            <tr>
                                <td><?php echo $r["Nombres"]; ?> (<?php echo $re["Rut"]; ?>)</td>
                                <td><?php echo $r["Requerimiento"]; ?></td>
                                <td><?php echo $r["Fecha"]; ?></td>
                                <td><?php echo $r["Latitud"]; ?></td>
                                <td><?php echo $r["Longitud"]; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card text-center w-100 card-accent-right-danger">
            <div class="card-body">
        <div id="cont_1581c16a1cb192d757b6983e3e9c91dc"><script type="text/javascript" async src="https://www.meteored.cl/wid_loader/1581c16a1cb192d757b6983e3e9c91dc"></script></div>
          </div>
        </div>
  </div>
</div>
</main>

<script src="<?php echo  site_url(); ?>assets/libs/raphael/raphael.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/chart.js/dist/Chart.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/raphael/raphael.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/charts-morris-chart/morris.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/charts-chartist/chartist.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/charts-chartist/chartist-plugin-tooltip.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/tables-datatables/dist/datatables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#tabla1').DataTable( {       
        paging: true,
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
    });
});

$(document).ready(function() {
    var table = $('#tabla2').DataTable( {       
        paging: true,
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
    });
});

$(document).ready(function() {
    var table = $('#tabla3').DataTable( {       
        paging: true,
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
    });
});


</script>
