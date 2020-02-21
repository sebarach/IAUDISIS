<body onload="IniciarCoordenadas();">
<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>Adm_ModuloPuntosVentas/listarLocales">Administración Locales</a>
        </li>
        <li class="breadcrumb-item active">Creación Locales</li>
    </ol>
    <div class="container-fluid">
        <h4 class="text-theme">Inserción Masiva de Puntos de Ventas</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="car">
                    <div class="card-header">
                        <i class="mdi mdi-arrow-right-drop-circle"></i> Paso 1 
                    </div>
                    <div class="card-body" style="height:300px;">
                        <h5 class="card-title">Plantilla de carga masiva de Puntos de Venta</h5>
                        <p class="card-text">Para poder ingresar usuarios de manera masiva a través de un Excel. Paro ello debemos tener la plantilla con las columnas bien definidas para que la plataforma valide e ingrese sin problemas.</p>
                        <br>                    
                         <form method="POST" action="generarPlantillaExcelLocales">
                                <button class="btn btn-outline-theme" type="submit" title='Descargar Plantilla'><i class="mdi mdi-file-excel"></i> Descargar Plantilla de Locales</button> 
                            </form> 
                    </div>
                    <div class="card-footer text-muted"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="car">
                    <div class="card-header">
                        <i class="mdi mdi-arrow-right-drop-circle"></i> Paso 2 
                    </div>
                    <div class="card-body" style="height:300px;">
                        <h5 class="card-title">Ingresar Excel</h5>
                        <p class="card-text">Antes de ingresar la plantilla con los puntos de ventas, debemos saber cómo son las columnas y/o campos requeridos. Si usted no tiene conocimiento al respecto, descargue la plantilla. Si hay algún rut existente, los datos no se ingresaran.</p>             
                        <div class="btn btn-theme"><i class="mdi mdi-alarm-plus"></i> Seleccione Excel para Ingresar <i id="ingresarExcelSpin" class=""></i> 
                            <form action="IngresarLocalesMasivo" method='POST' id="IngresarExcel" name="IngresarExcel" enctype="multipart/form-data" >                    
                                <input type='file' class="btn btn-xs btn-dark" id="excelv" name="excelv" onchange="formatoValIngresoPDO('#excelv');">
                            </form>
                        </div>
                    </div>
                    <div class="card-footer text-muted"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <h4 class="text-theme">Crear Locales</h4>
            <p>Ingresar un nuevo local al sistema, todos los campos con <code>*</code> son obligatorios.</p>
            <br>
            <div class="row">       
                <div class="col-sm-12">
                    <form action="#" class="form-horizontal" id="FormNuevoLocal">
                        <div class="card">
                             <div class="card-header text-theme">
                                <strong>Crear Local</strong>                                                
                            </div>
                            <br>
                            <div class="row card-body">
                            <div class="col-sm-4">
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Nombre de Local <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">&nbsp;
                                    <span class="input-group-addon"><i class="mdi mdi-pencil"></i></span>
                                    <input type="text" id="txt_local" name="txt_local" class="form-control" placeholder='Nombre del Local' required>
                                </div>       
                                <div  id="val_local" style="color:red;"></div>       
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Cadena <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                                    <select name="lb_cadena" id="lb_cadena" class="form-control form-control-sm">
                                        <option value="">Elija una Cadena</option>
                                        <?php
                                            foreach ($Cadenas as $c) {
                                                echo "<option value='".$c['ID_Cadena']."'>".$c['NombreCadena']."</option>";   
                                            }
                                        ?>
                                    </select>                                           
                                </div>
                                <div  id="val_eleCadena" style="color:red;"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Región </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="mdi mdi-google-maps"></i></span>
                                    <select name="lb_region" id="lb_region" class="form-control form-control-sm" onchange="Region('#lb_region');RegionCiudad('#lb_region')">
                                        <option value="">Elija una Región</option>
                                        <?php
                                            foreach ($Regiones as $r) {
                                                echo "<option value='".$r['ID_Region']."'>".$r['Region']."</option>";       
                                            }
                                        ?>
                                    </select> 
                                </div> 
                                <div  id="val_region" style="color:red;"></div>              
                            </div>
                        </div>

        
                        <div class="col-sm-4" <?php if($Paises['FK_ID_Pais']==1){echo "style='display:none'";} ?>>
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Ciudad</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="mdi mdi-google-maps"></i></span>
                                    <select name="lb_ciudad" id="lb_ciudad" class="form-control form-control-sm"  onchange="CiudadComuna()">
                                        <option value="">Elija una Ciudad</option>
                                    </select> 
                                </div> 
                                <div  id="val_comuna" style="color:red;"></div>                                          
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Comuna </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="mdi mdi-google-maps"></i></span>
                                    <select name="lb_comuna" id="lb_comuna" class="form-control form-control-sm">
                                        <option value="">Elija una Comuna</option>
                                    </select> 
                                </div> 
                                <div  id="val_comuna" style="color:red;"></div>                                          
                            </div>
                        </div>
                        <div class="col-sm-4">
                             <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Dirección</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                    <input type="text" id="txt_direccion" name="txt_direccion" class="form-control" placeholder='Dirección de la Local' required onblur="BuscarCoordenadasDirecion()" onchange="BuscarCoordenadasDirecion()" >
                                </div> 
                                <div  id="val_direccion" style="color:red;"></div>   
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Latitud <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="mdi mdi-compass-outline"></i></span>
                                    <input type="text" id="txt_latitud" name="txt_latitud" class="form-control" placeholder='-33.4583432' required onblur="BuscarCoordenadasLatLon()">
                                </div>    
                                <div  id="val_latitud" style="color:red;"></div>                                    
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Longitud <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="mdi mdi-compass"></i></span>
                                    <input type="text" id="txt_longitud" name="txt_longitud" class="form-control" placeholder='-70.6116514' required onblur="BuscarCoordenadasLatLon()">
                                </div> 
                                <div  id="val_longitud" style="color:red;"></div>                                          
                            </div>
                        </div>      
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Rango <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="ti-signal"></i></span>
                                    <input type="text" id="txt_rango" name="txt_rango" class="form-control" placeholder='Rango en metros' onkeypress="return SoloNumeros(event)" value="500" required>
                                </div> 
                                <div  id="val_rango" style="color:red;"></div>                                          
                            </div>
                        </div>
                        <div class="col-sm-4">      
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Zona</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="ti-map-alt"></i></span>
                                    <select name="lb_zona" id="lb_zona" class="form-control form-control-sm">
                                        <option value="">Elija una Zona</option>
                                        <?php
                                        if(isset($Zonas)){
                                            foreach ($Zonas as $z) {
                                                echo "<option value='".$z['id_zona']."'>".$z['zona']."</option>";       
                                            }
                                        }else{
                                             echo "<option value=''>No Hay Zonas Creadas</option>"; 
                                        }                                            
                                        ?>
                                    </select> 
                                </div> 
                                <div  id="val_zona" style="color:red;"></div>
                            </div>
                        </div>
                        <div class="col-sm-8" style="padding-bottom: 15px;">      
                            <div class="form-group">
                            <br>
                            <button type="submit" class="btn btn-theme btn-md pull-right" onclick="return ValidarCreacionLocal();"><i class="fa fa-check-square-o"  id="botonLocal"></i> Agregar Local</button>  
                            </div>
                        </div> 
                        </div>
                        <input type="hidden" name="txt_editar" value="<?php if(isset($datosUsuario['ID_Usuario'])){ echo $datosUsuario['ID_Usuario']; }else{ echo 0;} ?>">
                    </form>
                </div>
                </div>  

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header text-theme">
                                <strong>Ubicación Geográfica</strong>                                    
                        </div>
                        <div class='chart tab-pane active' id='revenue-chart' style='position: relative; height: 300px;'><div style='width: 100%; height: 100%;' id='map_canvas'></div>
                                        </div>
                                        
                           <!--  <br><br><br><br><br><br>
                    <div id="map_canvas"></div>
                    <br><br><br><br><br><br> -->
                </div>        
            </div>
            </div>             
        </div>
    </div>
    <div id="directionsPanel"></div>
</main>
</body>

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyB3412Cmx6-Q9TR0Zqad70sXtCUhb3505A&language=es&libraries=places"></script>
<script src="<?php echo  site_url(); ?>assets/js/coordenadas.js"></script>


