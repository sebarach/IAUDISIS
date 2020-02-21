<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="<?php echo site_url(); ?>menu">Menú</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo site_url(); ?>Adm_ModuloElementos/creacionElemento">Administración de Elementos</a>
                </li>
            </ol>

             <div class="container-fluid">
        <h4 class="text-theme">Inserción Masiva de Elementos</h4>
        <div class="row">
            <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <i class="mdi mdi-arrow-right-drop-circle"></i> Paso 1 
                                                </div>
                                                <div class="card-body" style="height:300px;">
                                                    <h5 class="card-title">Plantilla de carga masiva de Elementos</h5>
                                                    <p class="card-text">Para poder ingresar elementos de manera masiva a través de un Excel. Paro ello debemos tener la plantilla con las columnas bien definidas para que la plataforma valide e ingrese sin problemas.</p>
                                                    <br>                    
                                                <a href="<?php echo  site_url(); ?>doc/plantilla/PlantillaElementosSimplesEjemplo.xlsx" class="btn btn-theme" title='Descargar Plantilla'><i class="mdi mdi-file-excel"></i> Descargar Plantilla</a>
                                            </div>
                                            <div class="card-footer text-muted">
                                               
                                            </div>
                                    </div>
                                    <!-- <hr> -->
                                    </div>
                                    <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <i class="mdi mdi-arrow-right-drop-circle"></i> Paso 2 
                                                </div>
                                                <div class="card-body" style="height:300px;">
                                                    <h5 class="card-title">Ingresar Excel</h5>
                                                    <p class="card-text">Antes de ingresar la plantilla con los elementos, debemos saber cómo son las columnas y/o campos requeridos. Si usted no tiene conocimiento al respecto, descargue la plantilla. Si hay algún código SKU existente, los datos no se ingresaran.</p>             
                                                <div class="btn btn-theme"><i class="mdi mdi-alarm-plus"></i> Seleccione Excel para Ingresar <i id="ingresarExcelSpin" class=""></i> <form action="IngExcelElementosSimples" method='POST' id="IngresarExcel" name="IngresarExcel" enctype="multipart/form-data" >                    
                                                              <input type='file' class="btn btn-xs btn-dark" id="excelv" name="excelv" onchange="formatoValIngreso('#excelv');">
                                                        </form></div>
                                            </div>
                                            <div class="card-footer text-muted">
                                               
                                            </div>
                                    </div>
                                    <!-- <hr> -->
                                    </div>
        </div>
        </div>

            <div class="container-fluid">

                <div class="animated fadeIn">

                    <h3>Administración de Elementos</h3>
                <small>Módulo de Administrador de elementos. Este módulo esta creado para ver en detalle los elementos, editarlos, crearlos y desactivarlas.</small>
                <br><br/>

                </div>
            </div>
            <form action="<?php echo  site_url();?>Adm_ModuloElementos/validarCreacionElemento" class="form-horizontal" id="FormNuevoElemento" method="POST" enctype="multipart/form-data">
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                         <div class="col-md-6">
                            <div class="card card-accent-theme">
                                <div class="card-body col-md-8">
                                     
                                        <div class="form-group">
                                            <label for="control-demo-1" class="col-sm-6">Nombre Elemento <label style="color:red">* &nbsp;</label></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="mdi mdi-cube-outline"></i></span>
                                                    <input type="text" id="txt_elemento" name="txt_elemento" class="form-control" required>
                                                </div>
                                    <div  id="val_ele" style="color:red;"></div>                                 
                                        </div> 

                                        <div class="form-group">
                                            <label for="control-demo-1" class="col-sm-6">Categoría</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="mdi mdi-animation"></i></span>
                                                    <input type="text" id="txt_categoria" name="txt_categoria" class="form-control">
                                                </div>                            
                                        </div> 

                                        <div class="form-group">
                                            <label for="control-demo-1" class="col-sm-6">Marca</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="mdi mdi-basket"></i></span>
                                                    <input type="text" id="txt_marca" name="txt_marca" class="form-control">
                                                </div>                            
                                        </div> 

                                        <div class="form-group" style="padding-top: 5px;">
                                           <button type="submit" class="btn btn-sm btn-danger"><i id="icCreaElemento" class=""></i>Crear Elemento</button>                          
                                        </div> 
                                        
                                </div>
                            </div>
                        </div>

                            <div class="col-md-6">
                                <div class="card card-accent-theme">
                                    <div class="card-body col-md-10">
                                        <div class="form-group">
                                            <label for="control-demo-1" class="col-sm-6">Código SKU</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="mdi mdi-barcode-scan"></i></span>
                                                    <input type="text" id="txt_sku" name="txt_sku" class="form-control">
                                                </div>                             
                                        </div> 

                                        <div class="form-group">
                                            <label for="street">Foto Elemento</label>
                                                <div class="input-group">                                            
                                        <input type="file" id="txt_foto" name="txt_foto" class="dropify"  />
                                                </div>                            
                                        </div>       
                                    </div>

                                <!-- end card-body -->
                            </div>

                            <!-- end card -->
                        </div>
                         
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div>
                <!-- end animated fadeIn -->
            </div>
            <!-- end container-fluid -->
            </form>
        </main>


<script src="<?php echo  site_url(); ?>assets/libs/bootstrap-switch/bootstrap-switch.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/bootbox/bootbox.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/dropify/dist/js/dropify.min.js"></script>
    <!--sweetalert -->
<script src="<?php echo  site_url(); ?>assets/libs/sweetalert/sweetalert.js"></script>

<script type="text/javascript">

    $('.dropify').dropify({
        messages: {
            default: 'Subir Foto Elemento',
            replace: 'Nueva Foto del Elemento',
            remove:  'Elimnar',
            error:   '-vacio-'
        },

        defaultFile: '',
        maxFileSize: 0,
        minWidth: 0,
        maxWidth: 0,
        minHeight: 0,
        maxHeight: 0,
        showRemove: true,
        showLoader: true,
        showErrors: true,
        errorTimeout: 3000,
        errorsPosition: 'overlay',
        imgFileExtensions: ['png', 'jpg', 'jpeg', 'gif', 'bmp'],
        maxFileSizePreview: "5M",
        allowedFormats: ['portrait', 'square', 'landscape'],
        allowedFileExtensions: ['*'],
         error: {
            'fileSize': 'The file size is too big ({{ value }} max).',
            'minWidth': 'The image width is too small ({{ value }}}px min).',
            'maxWidth': 'The image width is too big ({{ value }}}px max).',
            'minHeight': 'The image height is too small ({{ value }}}px min).',
            'maxHeight': 'The image height is too big ({{ value }}px max).',
            'imageFormat': 'The image format is not allowed ({{ value }} only).',
            'fileExtension': 'The file is not allowed ({{ value }} only).'
        },
        tpl: {
            wrap:            '<div class="dropify-wrapper"></div>',
            loader:          '<div class="dropify-loader"></div>',
            message:         '<div class="dropify-message"><span class="file-icon" /> <p>{{ default }}</p></div>',
            preview:         '<div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-infos-message">{{ replace }}</p></div></div></div>',
            filename:        '<p class="dropify-filename"><span class="dropify-filename-inner"></span></p>',
            clearButton:     '<button type="button" class="dropify-clear">{{ remove }}</button>',
            errorLine:       '<p class="dropify-error">{{ error }}</p>',
            errorsContainer: '<div class="dropify-errors-container"><ul></ul></div>'
        }
    });

    Dropify.prototype.isImage = function()
    {
        if (this.settings.imgFileExtensions.indexOf(this.getFileType()) != "-1") {
            return true;
        }

        return false;
    };

</script>