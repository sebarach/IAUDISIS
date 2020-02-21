<style type="text/css">
    th { font-size: 12px; }
    td { font-size: 11px; }

#loader {
  position: absolute;
  left: 50%;
  top: 60%;
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

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}

</style>
<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        
        <li class="breadcrumb-item active">Historial de Jornadas Asignadas</li>
    </ol>
    <div class="container-fluid">
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-accent-theme" >
                <div class="card-body">
                    <h4 class="text-theme">Jornadas Asignadas</h4> 
                    <p>Este modulo fue diseñado para visualizar y descargar las jornadas ya asignadas anteriormente. El formato de descarga del excel es el mismo que se usa para asignar las jornadas.</p>                     
                    <hr>
                    <p><strong>Filtros</strong></p>
                    <div class="btn-group" role="group">                                            
                            
                            <div class='input-group'>
                            <span class='input-group-addon'><i class='mdi mdi-calendar'></i></span>
                                <select class="form-control select2" id='txt_MEsAn' name='txt_MEsAn' style="width: 100%;" onchange="filtrarMesAnio();">
                                    <option value="">Elija Fecha</option>
                                    <?php foreach ($Fechas as $F) {
                                        echo "<option value='".$F["ID_Fecha"]."'>".$F["Fecha"]."</option>";
                                    }?>
                                </select>
                                <span class="input-group-btn">
                                    <form method="POST" action="generarExcelHistoricoJornadas">
                                        <input type="hidden" name="MA" id="MA" value="<?php echo date("d/m/Y") ?>">
                                        <button class="btn btn-theme" type="submit" title='Descargar Plantilla'><i class="mdi mdi-file-excel"></i> Descargar Plantilla</button> </form>
                                   <!--  <form method="POST" action="generarExcelHistoricoJornadas">
                                      
                                        <button type="button" class="btn btn-theme" type="submit"><i id="refsh" class='mdi mdi-file-excel'></i> Descargar Jornadas</button>
                                    </form> -->
                                </span>
                                
                            </div>
                        </div>
                </div>

                <div onload="myFunction()" id='tabla' >
                 <div id="loader" style="display: none;"></div>    
                <table id="example" class="table color-bordered-table  danger-bordered-table"  width="100%" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Nombre Local</th>
                            <th style="text-align: center;"> Día 1</th>
                            <th style="text-align: center;"> Día 2</th>
                            <th style="text-align: center;"> Día 3</th>
                            <th style="text-align: center;"> Día 4</th>
                            <th style="text-align: center;"> Día 5</th>
                            <th style="text-align: center;"> Día 6</th>
                            <th style="text-align: center;"> Día 7</th>
                            <th style="text-align: center;"> Día 8</th>
                            <th style="text-align: center;"> Día 9</th>
                            <th style="text-align: center;"> Día 10</th>
                            <th style="text-align: center;"> Día 11</th>
                            <th style="text-align: center;"> Día 12</th>
                            <th style="text-align: center;"> Día 13</th>
                            <th style="text-align: center;"> Día 14</th>
                            <th style="text-align: center;"> Día 15</th>
                            <th style="text-align: center;"> Día 16</th>
                            <th style="text-align: center;"> Día 17</th>
                            <th style="text-align: center;"> Día 18</th>
                            <th style="text-align: center;"> Día 19</th>
                            <th style="text-align: center;"> Día 20</th>
                            <th style="text-align: center;"> Día 21</th>
                            <th style="text-align: center;"> Día 22</th>
                            <th style="text-align: center;"> Día 23</th>                              
                            <th style="text-align: center;"> Día 24</th>
                            <th style="text-align: center;"> Día 25</th>
                            <th style="text-align: center;"> Día 26</th>
                            <th style="text-align: center;"> Día 27</th>
                            <th style="text-align: center;"> Día 28</th>
                            <th style="text-align: center;"> Día 29</th>
                            <th style="text-align: center;"> Día 30</th>
                            <?php if (cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"))>=31) {
                            echo'  
                            <th style="text-align: center;"> Día 31</th>
                             ';}?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $b=':' ;// variable den dias Libres
                        $ndias=cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));    
                        foreach ($horarios as $c) {                            
                echo"       <tr>                                                                        
                                <td>".$c['Nombres']."<br><small>".$c['Rut']."</small></td>                            
                                <td style='width: 1000px;'>".$c['NombreLocal']."</td>"; 
                                    for ($i=1; $i <= $ndias ; $i++) {
                                echo"<td>"; 
                                        if ((strpos($c['Entrada'.$i],$b)===false)) { 
                                            echo " ";
                                        }else{
                                            $he = date_create($c['Entrada'.$i]); 
                                            echo"<i class='mdi mdi-clock-in'></i>".date_format($he, 'G:i');   
                                        }
                                        if ((strpos($c['Salida'.$i],$b)===false)) {                                    
                                    echo $c['PermisoSalida'.$i];
                                        }else{
                                            $hs = date_create($c['Salida'.$i]);  
                                     echo"<br<i class='mdi mdi-clock-out'></i>".date_format($hs, 'G:i');
                                        }
                                echo"</td>";
                                    } 
                      echo "</tr>";}?>  
                        </tbody>
                    </table> 
                    <hr> 
                </div>
            </div>
        </div>
    </div>
</main>

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/timepicker/dist/jquery.timepicker.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/multiselect/js/jquery.multi-select.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/form-masks/dist/formatter.min.js"></script>
<script type="text/javascript">


    function filtrarMesAnio(idjor){
        $("#loader").removeAttr("style","table-loading-overlay");
        var MEsAnio =$("#txt_MEsAn").val(); 
        $.ajax({
            url: "http://checkroom.cl/audisis/Adm_ModuloJornadas/FiltroMesAnioHistoricoJornadas",
            type: "POST",
            data: "MEsAnio="+MEsAnio,
            success: function(data) {
                // alertify.success("Cambiooo!");
                // $("#loader").attr("style","display:none;");
                $("#MA").val('01/'+MEsAnio);
                $("#tabla").html('');
                $("#tabla").html(data);                  
               

            }
        });
    }

     function generarExcel(){
        var MEsAnio =$("#txt_MEsAn").val(); 
        $.ajax({
            url: "http://checkroom.cl/audisis/Adm_ModuloJornadas/generarExcelHistoricoJornadas",
            type: "POST",
            data: "MEsAnio="+MEsAnio,
            success: function(data) {
                alertify.success("Excel Descargado");
            }
        });
    }

   
    $(document).ready(function() {
    var table = $('#example').removeAttr('width').DataTable( {
        scrollY:        "450px",
        scrollX:        true,
        searching: true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 1,
        },
            "language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
        "sInfo":          "",
        "sInfoEmpty":     "",
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
} );

    </script>
<script type="text/javascript"></script>   