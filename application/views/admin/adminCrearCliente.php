<main class="main" style="height: 100%;">
        <!-- Breadcrumb -->
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
             <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Cliente</a>
        </li>
        <li class="breadcrumb-item active">Crear Cliente</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <h3>Creación de Clientes</h3>
            <small>Modulo de Administrador para crear Cliente/Empresa</small>
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header text-theme">
                            <strong>Crear Empresa</strong>                                            
                        </div>
                        <div class="card-body">
                            <form id="FrmCreaEmpresa" method="POST">
                                <div class="form-group">
                                    <label for="company">Nombre Empresa</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="mdi mdi-factory"></i>
                                        </span>
                                        <input type="text" class="form-control" id="txtNombreEmpresa" name="txtNombreEmpresa" placeholder="Nombre de la Empresa" >
                                    </div>
                                    <div id="errorNombreEmpres" style="color: red; display: none;"  >
                                        Debe escribir el Nombre de la Empresa...
                                    </div>
                                    <div id="errorNombreEmpresML" style="color: red; display: none;"  >
                                        El nombre de la Empresa tiene un máximo de 150 caracteres
                                    </div>         
                                </div>  

                                <div class="form-group">
                                    <label for="vat">Rut Empresa</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="mdi mdi-barcode"></i>
                                        </span>
                                    <input type="text" class="form-control" id="txtRutEmpresa" name="txtRutEmpresa" placeholder="12345678-9" onchange="formateaRut();">
                                    </div>
                                   
                                    <div id="errorRutEmpresa" style="color: red; display: none;"  >
                                                Debe escribir el Rut de la Empresa...
                                    </div>
                                    <div id="errorRutEmpresaV" style="color: red; display: none;"  >
                                                El rut de la Empresa ya existe...
                                    </div>
                                    <div id="errorRutEmpresaVV" style="color: red; display: none;"  >
                                                El rut de la Empresa no es valido...
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="street">Razón Social</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="mdi mdi-content-paste"></i>
                                        </span>
                                    <input type="text" class="form-control" id="txtRazonSocial" name="txtRazonSocial" placeholder="Razon social">
                                    </div>
                                
                                    <div id="errorRazonSocial" style="color: red; display: none;"  >
                                                Debe escribir la Razón Social de la Empresa...
                                    </div>
                                    <div id="errorRazonSocialML" style="color: red; display: none;"  >
                                            La Razón Social de la Empresa tiene un máximo  de 200 caracteres
                                    </div>
                                </div>
                                <div class="form-group form-actions">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="return validarCrearEmpresa();" ><i id="icCreaEmpresa" class=""></i>Crear Empresa</button>
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header text-theme">
                            <strong>Crear Cliente</strong>                                
                        </div>

                        <div class="card-body">
                            <form id="FrmCreaCliente" method="POST">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <label for="company">Seleccione Empresa</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="mdi mdi-factory"></i>
                                                </span>
                                                <select id="sltEmpresa" name="sltEmpresa" class="form-control form-control-sm">
                                                    <option value="">Seleccione Empresa</option>
                                                    <?php
                                                        foreach ($ListarEmpresa as $c) {
                                                            echo "<option value='".$c['ID_Empresa']."'>".$c['NombreEmpresa']."</option>";
                                                        }?>
                                                </select>
                                            </div>
                                            <div id="errorsltEmpresa" style="color: red; display: none;"  >
                                                       Debe selecionar la Empresa...
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="company">Nombre Cliente</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="mdi mdi-castle"></i>
                                                </span>
                                                <input type="text" class="form-control" id="txtNombreCliente" name="txtNombreCliente" placeholder="Nombre del Cliente">
                                            </div>
                                            <div id="errortxtNombreCliente" style="color: red; display: none;"  >
                                                       Debe Escribir el nombre del Cliente...
                                            </div>

                                            <div id="errorClienteEmpresaV" style="color: red; display: none;"  >
                                                        El Nombre del Cliente ya existe para esta Empresa
                                            </div>
                                            <div id="errorClienteEmpresaML" style="color: red; display: none;"  >
                                                        El Nombre del Cliente tiene un máximo de 100 caracteres
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="vat">Email de Cliente</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="mdi mdi-mail-ru"></i>
                                                </span>
                                                <input type="text" class="form-control" id="txtMailEmpresa" name="txtMailEmpresa" placeholder="nombrecliente@email.com">
                                            </div>
                                            <div id="errortxtMailEmpresa" style="color: red; display: none;"  >
                                                       Debe ecribir el correo del Cliente... 
                                            </div>
                                            <div id="errortxtMailEmpresaV" style="color: red; display: none;"  >
                                                       El correo del Cliente no es Valido... 
                                            </div>
                                            <div id="errortxtMailEmpresaML" style="color: red; display: none;"  >
                                                        El correo del Cliente tiene un máximo de 100 caracteres
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            <label for="vat">Seleccione su pais</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="mdi mdi-flag"></i>
                                                </span>
                                                <select id="sltPaises" name="sltPaises" class="form-control form-control-sm">
                                                    <option value="">Seleccione Su Pais</option>
                                                    <?php
                                                        foreach ($ListarPaises as $c) {
                                                            echo "<option value='".$c['ID_Pais']."'>".$c['Pais']."</option>";
                                                        }?>
                                                </select>
                                            </div>
                                        </div>  
                                        <div id="errorsltPaises" style="color: red; display: none;"  >
                                                       Debe selecionar su pais
                                            </div>
                                        
                                        <div class="form-group form-actions">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return validarCrearCliente();" ><i id="icCreaCliente"  class="fa "></i>Crear Cliente</button>
                                        </div> 
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="card-body">
                                            <label for="street">Logo Cliente</label>
                                            <input type="file" id="tx_foto" name="tx_foto" class="dropify"  />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
    </main>

    <script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/dropify/dist/js/dropify.min.js"></script>
    <!-- <script src="<?php echo  site_url(); ?>assets/js/dropify-examples.js"></script> -->


<script type="text/javascript">

   

    // Translated
    $('.dropify').dropify({
        messages: {
            default: 'Subir Logo Cliente',
            replace: 'Nuevo Logo del Cliente',
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



    function validarCrearEmpresa(){
        if(validarIngresarEmpresa()==false){
        alertify.error("Existen Campos Vacios");
        return false;
     }else{
        if(validarlargoCaracterEmpresa()==false){
        alertify.error("Maximo de caracteres Excedido ");
        return false;
        }else{
        $("#icCreaEmpresa").attr("class","fa fa-spin fa-circle-o-notch");
        var formData = new FormData(document.getElementById("FrmCreaEmpresa"));
        $.ajax({                        
           type: "POST",                 
           url:"<?php echo site_url();?>Adm_ModuloCliente/CrearEmpresa",                     
           dataType: "html",
           data: formData,
           cache: false,
           contentType: false,
           processData: false,
           success: function(data)             
           {            
             if (data==1) {
                 $("#icCreaEmpresa").attr("class","");
                 $("#txtRutEmpresa").attr('class', 'form-control is-invalid')
                 $('#errorRutEmpresaV').show(); 
                 alertify.error("El Rut de la empresa ya Existe");
            } else if (data==2) {
                $("#txtRutEmpresa").attr('class', 'form-control is-invalid')
                alertify.error("El Rut ingresado no es valido");
                $('#errorRutEmpresaVV').show();

             }else if (data==0){
                $("#icCreaEmpresa").attr("class","");
                alertify.success("Empresa Creada");
                $("#txtNombreEmpresa").val('');
                $("#txtRutEmpresa").val('');
                $("#txtRazonSocial").val('');

             }
           }         
       });
    }
    }
  };



  function validarCrearCliente(){

        if (validarIngresarCliente()==false) 
        {
            alertify.error("Existen Campos Vacios");
            return false;
        }
        else
        {
            if (validarlargoCaracterCliente()==false) 
            {
                alertify.error("Maximo de caracteres Exedido ");
                return false;
            }
            else
            {
                $("#icCreaCliente").attr("class","fa fa-spin fa-circle-o-notch");
                var formData = new FormData(document.getElementById("FrmCreaCliente"));
                $.ajax({
                    type:"POST",                 
                    url:"<?php echo site_url();?>Adm_ModuloCliente/CrearCliente",                     
                    dataType:"html",
                    data: formData,
                    cache: false,
                    async : false,
                    contentType: false,
                    processData: false,
                    success: function(data)
                    {
                        
                        if (data.match('OP1'))
                        {
                            $("#icCreaCliente").attr("class","");
                            alertify.error("El Nombre del Cliente ya existe para esta Empresa");
                            $("#txtNombreCliente").attr('class','form-control is-invalid');
                            $('#errorClienteEmpresaV').show();
                            formData.preventDefault();
                          
                        }
                        else if(data.match("OP0"))
                        {
                            $("#icCreaCliente").attr("class","");
                            alertify.success("Cliente Ingresado");
                            $("#sltEmpresa").val('');
                            $("#txtNombreCliente").val('');
                            $("#txtMailEmpresa").val('');
                            $("#sltPaises").val('');
                        }
                        else if(data.match("OP2"))
                        {
                            $("#icCreaCliente").attr("class","");
                            alertify.error("El correo ingresado no es valido");
                            $("#txtMailEmpresa").attr('class', 'form-control is-invalid');
                            $('#errortxtMailEmpresaV').show();                         }                        
                    }
                    
                });
                return false;
            }
        }
    }

  function validarIngresarEmpresa()
  {
    var vacios=0;
    var valido=true;
    if($("#txtNombreEmpresa").val()==''){  
        $("#txtNombreEmpresa").attr('class', 'form-control is-invalid');
        $('#errorNombreEmpres').show(); 
        vacios+=1;
    } else { 
        $("#txtNombreEmpresa").attr('class', 'form-control is-valid');  
        $('#errorNombreEmpres').hide(); 
    }
    if($("#txtRutEmpresa").val()==''){  
        $("#txtRutEmpresa").attr('class', 'form-control is-invalid'); 
        $('#errorRutEmpresa').show();         
        vacios+=1;
    } else { 
        $("#txtRutEmpresa").attr('class', 'form-control is-valid');
        $('#errorRutEmpresa').hide();
        $('#errorRutEmpresaV').hide();    
        $('#errorRutEmpresaVV').hide();    
    }
    if($("#txtRazonSocial").val()==''){  
        $("#txtRazonSocial").attr('class', 'form-control is-invalid'); 
        $('#errorRazonSocial').show();    
        vacios+=1;
    } else { 
        $("#txtRazonSocial").attr('class', 'form-control is-valid');  
        $('#errorRazonSocial').hide();    
    }
    if(vacios>0){ valido=false; }
    return valido;
  }


  function validarIngresarCliente()
  {
    var vacios=0;
    var valido=true;

    if($("#sltEmpresa").val()=='')
    {  
        $("#sltEmpresa").attr('class','form-control is-invalid');
        $('#errorsltEmpresa').show(); 
        vacios+=1;
    } 
    else 
    { 
        $("#sltEmpresa").attr('class','form-control is-valid');  
        $('#errorsltEmpresa').hide(); 
    }

    if($("#sltPaises").val()=='')
    {  
        $("#sltPaises").attr('class','form-control is-invalid');
        $('#errorsltPaises').show(); 
        vacios+=1;
    } 
    else 
    { 
        $("#sltPaises").attr('class','form-control is-valid');  
        $('#errorsltPaises').hide(); 
    }

    if($("#txtNombreCliente").val()=='')
    {  
        $("#txtNombreCliente").attr('class', 'form-control is-invalid');
        $('#errortxtNombreCliente').show(); 
        vacios+=1;
    }
    else 
    { 
        $("#txtNombreCliente").attr('class', 'form-control is-valid');  
        $('#errortxtNombreCliente').hide();
        $('#errorClienteEmpresaV').hide();  
    }

    if($("#txtMailEmpresa").val()=='')
    {  
        $("#txtMailEmpresa").attr('class','form-control is-invalid');
        $('#errortxtMailEmpresa').show(); 
        vacios+=1;
    } 
    else 
    { 
        $("#txtMailEmpresa").attr('class','form-control is-valid');  
        $('#errortxtMailEmpresa').hide();
        $('#errortxtMailEmpresaV').hide();
    }

    // if($("#tx_foto").val()==''){  
    //     $("#tx_foto").attr('class', 'form-control is-invalid');
    //     // $('#errortxtNombreCliente').show(); 
    //     vacios+=1;
    // } else { 
    //     $("#tx_foto").attr('class', 'form-control is-valid');  
          
    // }
    
    if(vacios>0)
    { 
        valido=false; 
    }

    return valido;
  }


  function validarlargoCaracterCliente(){
    var vacios=0;
    var valido=true;
    var NombreCliente = $("#txtNombreCliente").val();
    var MailEmpresa = $("#txtMailEmpresa").val();

    if(NombreCliente.length>100){  
        $("#txtNombreCliente").attr('class', 'form-control is-invalid');
        $('#errorClienteEmpresaML').show(); 
        vacios+=1;
    } else { 
        $("#txtNombreCliente").attr('class', 'form-control is-valid');  
        $('#errortxtNombreCliente').hide();
        $('#errorClienteEmpresaV').hide();
        $('#errorClienteEmpresaML').hide();  
    }

    if(MailEmpresa.length>100){  
        $("#txtMailEmpresa").attr('class', 'form-control is-invalid');
        $('#errortxtMailEmpresaML').show(); 
        vacios+=1;
    } else { 
        $("#txtMailEmpresa").attr('class', 'form-control is-valid');  
        $('#errortxtMailEmpresa').hide();
        $('#errortxtMailEmpresaV').hide();
        $('#errortxtMailEmpresaML').hide();
    }
    
    if(vacios>0){ valido=false; }
    return valido;
  }

   function validarlargoCaracterEmpresa(){
    var vacios=0;
    var valido=true;
    var NombreEmpresa = $("#txtNombreEmpresa").val();
    var rutEmpresa = $("#txtRutEmpresa").val();
    var RazonSocial = $("#txtRazonSocial").val();

    if(NombreEmpresa.length>150){  
        $("#txtNombreEmpresa").attr('class', 'form-control is-invalid');
        $('#errorNombreEmpresML').show(); 
        vacios+=1;
    } else { 
        $("#txtNombreEmpresa").attr('class', 'form-control is-valid');  
        $('#errorNombreEmpres').hide();
        $('#errorNombreEmpresML').hide(); 
    }
    if(rutEmpresa.length>12){  
        $("#txtRutEmpresa").attr('class', 'form-control is-invalid'); 
        $('#errorRutEmpresaVV').show();         
        vacios+=1;
    } else { 
        $("#txtRutEmpresa").attr('class', 'form-control is-valid');
        $('#errorRutEmpresa').hide();
        $('#errorRutEmpresaV').hide();    
        $('#errorRutEmpresaVV').hide();
          
    }
    if(RazonSocial.length>200){  
        $("#txtRazonSocial").attr('class', 'form-control is-invalid'); 
        $('#errorRazonSocialML').show();    
        vacios+=1;
    } else { 
        $("#txtRazonSocial").attr('class', 'form-control is-valid');  
        $('#errorRazonSocial').hide();
        $('#errorRazonSocialML').hide();    
    }
    if(vacios>0){ valido=false; }
    return valido;
  }



    </script>
    <!-- end main -->