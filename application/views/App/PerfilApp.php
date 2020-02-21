<main class="main">
  <hr>
  <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
      <li class='breadcrumb-item '>
        <a href="<?php echo base_url("menu");?>">Menú</a>
    </li>
      <li class="breadcrumb-item active">
          <a href="">Perfil de Usuario</a>
  </ol>
  <div class="container">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card border-danger mb-3 ">                                            
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h5 class="text-center text-theme" >Información Personal</h5>
                </div>                
                <div class="col-md-12">
                  <div class="card border-danger mb-3 ecom-widget-sales">
                    <div class="card-body">
                        <ul>
                           <li>RUT <span ><?php echo $info["rut"]; ?></span></li> 
                           <li>NOMBRE COMPLETO <span><?php echo $info["nombre"]; ?></span></li>
                           <li>USUARIO<span><?php echo $info["Usuario"]; ?></span></li>
                           <li><button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal-danger-header" ><i class="fa fa-key"></i>Cambiar Contraseña</button></li>
                        </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 pad6">
                  <div class="form-group">
                      <label for="control-demo-1" >N&Uacute;MERO TEL&Eacute;FONO</label>
                      <div class="input-group">
                          <span class="input-group-addon bg-theme"><i class="mdi mdi-cellphone-iphone"></i></span>
                          <input type="text" id="txt_telefono" name="txt_telefono" class="form-control" value='<?php echo $info["Telefono"]; ?>' placeholder='901020304' disabled>
                          <span id="spanFono" class="input-group-addon" onclick="btnFono()"><i id="editFono" class="mdi mdi-account-edit"></i></span>
                      </div>  
                      <div  id="val_telefono" style="color:red;"></div>          
                  </div>
                </div>
                <div class="col-md-12 pad6">
                  <div class="form-group">
                      <label for="control-demo-1" >EMAIL </label>
                      <div class="input-group">
                          <span class="input-group-addon bg-theme"><i class="mdi mdi-email-outline"></i></span>
                          <input type="email" id="txt_email" name="txt_email" class="form-control" value='<?php echo $info["Email"]; ?>' placeholder='correo@dominio.com' disabled>
                          <span id="spanEmail" class="input-group-addon" onclick="btnEmail()"><i id="editEmail" class="mdi mdi-account-edit"></i></span>
                      </div>  
                      <div  id="val_email" style="color:red;"></div>   
                  </div>
                </div>
                <div class="col-md-12 pad6">
                  <div class="form-group">
                    <form id="FrmDirecUsuario" method="post">
                      <label for="control-demo-1" >DIRECCI&Oacute;N</label>
                      <div class="input-group">
                          <span class="input-group-addon bg-theme"><i class="mdi mdi-home"></i></span>
                         
                          <input type="text" id="txt_direccion" name="txt_direccion" class="form-control" placeholder='Dirección' value='<?php echo $info["Direccion"]; ?>' disabled>
                          
                          <span id="btnUserDirec" class="input-group-addon" onclick="btnDirec()"><i id="editDirec" class="mdi mdi-account-edit"></i></span>
                      </div>  
                      <div  id="val_direccion" style="color:red;"></div> 
                    </form>  
                  </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="control-demo-1" >FOTOGRAFÍA</label>
                      <form id="formFoto" method="post" enctype="multipart/form-data" >
                        <div class="input-group">
                          <!-- <span class="input-group-addon"><i class="fa fa-camera"></i></span> -->
                          <div class="col-sm-2" >
                            <input type="file" id="tx_foto" name="tx_foto" class="dropify">
                          </div>
                         <!--  <?php   
                              if(isset($info['FotoPerfil']))
                              {
                                echo '<span class="input-group-addon">';
                                echo "<div class='dropify-preview' style='display;block;'>";
                                echo "<span class='dropify-render'>";
                                echo "<img src='";echo site_url().$info['FotoPerfil'];echo "'>";
                                echo "</span>";
                                echo "</div>";
                                echo "</span>";
                              }
                          ?>         -->             
                        </div>
                        <button class="btn btn-sm btn-theme" onclick="btnFoto()"><i class="fa fa-upload"></i>AGREGAR FOTOGRAFÍA</button>                        
                      </form>
                    </div>
                </div>
            </div>                                  
          </div>
          <!-- <div class="card-body">
            <div class="row">
              <div class="col-md-12 pad6">
                  <div class="card">
                    <div class="row button-group">
                      <div class="col-lg-12">
                        
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div> -->

                                <!-- end card -->
        </div>
                        <!-- end col -->
      </div>

    </div>
                <!-- end animated fadeIn -->
  </div>

 <!-- end container-fluid -->

</main>
<div class="modal fade" id="exampleModal-danger-header" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Cambiar Contraseña</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Contraseña Actual:</label>
                            <input type="password" class="form-control" id="passActual">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nueva Contraseña:</label>
                            <input type="password" class="form-control" id="newPass1">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Repertir Nueva Contraseña</label>
                            <input type="password" class="form-control" id="newPass2">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" onclick="cambiarPass();" >Guardar Contraseña</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
        <!-- end main -->
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyC4Zt12Kgpaar2fMBofnlnslSF9cvG6F5M&language=es&libraries=places"></script>
<script src="<?php echo  site_url(); ?>assets/js/coordenadas.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/dropify/dist/js/dropify.min.js"></script>

<script type="text/javascript">

  $(function () {
    $(".dropify-message span").removeAttr("class").html('<div class="ecom-widget-sales"><div class="ecom-sales-icon text-center"><i class="mdi mdi-camera-party-mode"></i></div></div>');
  });

  function btnDirec() {
    $("#editDirec").attr("class","mdi mdi-account-check");
    $("#txt_direccion").removeAttr("disabled");
    $("#btnUserDirec").attr("class","input-group-addon bg-success");
    $("#editDirec").attr("style","color: white");
    $("#btnUserDirec").removeAttr("onclick","btnDirec()");
    $("#btnUserDirec").attr("onclick","mdDirecc()");
  }

  function btnEmail() {
    $("#editEmail").attr("class","mdi mdi-account-check");
    $("#txt_email").removeAttr("disabled");
    $("#spanEmail").attr("class","input-group-addon bg-success");
    $("#editEmail").attr("style","color: white");
    $("#spanEmail").removeAttr("onclick","btnEmail()");
    $("#spanEmail").attr("onclick","mdEmail()");
  }

  function btnFono() {
    $("#editFono").attr("class","mdi mdi-account-check");
    $("#txt_telefono").removeAttr("disabled");
    $("#spanFono").attr("class","input-group-addon bg-success");
    $("#editFono").attr("style","color: white");
    $("#spanFono").removeAttr("onclick","btnEmail()");
    $("#spanFono").attr("onclick","mdFono()");
  }
   
  function mdDirecc() {
    var dir = $("#txt_direccion").val();
    var mail = $("#txt_email").val();
    if (dir!='') {
      $.ajax({                        
         type: "POST",                 
         url:"http://test.grupoprogestion.com/audisis/App_ModuloPerfilUsuario/ModificarDireccion",                     
         data: "dir="+dir+"&mail="+mail,
         success: function(data)             
         {            
           if (data==1) {
           $("#editDirec").attr("class","");
           alertify.success("Dirección modificada");
           // $("#btnUserDirec").attr("onclick","btnDirec()");
           $("#editDirec").attr("class","mdi mdi-account-edit");
           setTimeout(function(){window.location.reload();},1000); 
           }
          }         
      });
    }else{
      alertify.error("La Direccion esta Vacia");  
    }
    
  }

   function mdEmail() {
    var email = $("#txt_email").val();
    if (email!='') {
      if (validarEmail($("#txt_email").val())) {
        if ($("#txt_email").val().length<200) {
          $.ajax({                        
           type: "POST",                 
           url:"http://test.grupoprogestion.com/audisis/App_ModuloPerfilUsuario/ModificarEmail",                     
           data: "email="+email,
           success: function(data){            
             if (data==1) {
             $("#editDirec").attr("class","");
             alertify.success("Email Modificado");
             // $("#btnUserDirec").attr("onclick","btnDirec()");
             $("#editDirec").attr("class","mdi mdi-account-edit");
             setTimeout(function(){window.location.reload();},1000); 
             }
            }         
          });
        }else{
          alertify.error("El Email debe tener menos de 200 caracteres");              
        }
          
      }else{
        alertify.error("Formato de Email no valido");              
      }
      
    }else{
      alertify.error("El Email esta vacio");      
    }
      
  }

  function validarEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
  }

   function mdFono() {
    var fono = $("#txt_telefono").val();
    var mail = $("#txt_email").val();
    if (fono !='') {
      
      if ($("#txt_telefono").val().length>6 && $("#txt_telefono").val().length<=11) {

        $.ajax({                        
           type: "POST",                 
           url:"http://test.grupoprogestion.com/audisis/App_ModuloPerfilUsuario/ModificarFono",                     
           data: "fono="+fono+"&mail="+mail,
           success: function(data){            
             if (data==1) {
               $("#editDirec").attr("class","");
               alertify.success("Telefono Modificado");
               // $("#btnUserDirec").attr("onclick","btnDirec()");
               $("#editDirec").attr("class","mdi mdi-account-edit");
               setTimeout(function(){window.location.reload();},1000); 
               }
            }         
        });
      }else{     
        alertify.error("El N° de Telefono tiene que tener un minimo de 8 caracteres y maximo de 11");
      }
    }else{
      alertify.error("El N° de Telefono esta vacio");
    }
  }

function btnFoto() {
  var fot = $("#tx_foto").val();
  if (fot!='') {
      var formData = new FormData(document.getElementById("formFoto"));
      $.ajax({
          url: "ModificarFoto",
          type: "post",
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
       processData: false
      })
      .done(function(res){
        if (res==1) {
        alertify.success("Foto Ingresada");
        setTimeout(function(){window.location.reload();},1000); 
      }
      });
  }else{
    alertify.error("La Foto esta Vacia");  
  }
}

function cambiarPass() {
  var mail = $("#txt_email").val();
  var passActual = '<?php echo $clave; ?>';
  var passAct = $("#passActual").val();
  var passnew1 = $("#newPass1").val();
  var passnew2 = $("#newPass2").val();
  if (passActual==passAct) {
    if ($("#newPass1").val().length>6) {
       if (passnew1==passnew2) {
           $.ajax({                        
           type: "POST",                 
           url:"http://test.grupoprogestion.com/audisis/App_ModuloPerfilUsuario/ModificarContrasenia",                     
           data: "pass="+passnew2+"&mail="+mail,
           success: function(data){            
             if (data==1) {
             alertify.success("Contraseña modificada Modificado");
             setTimeout(function(){window.location.reload();},1000); 
             }
            }         
          });
        }else{
          alertify.error("La nueva contraseña no concuerda");
        } 
    }else{
      alertify.error("La contraseña tiene que tener un minimo de 6 caracteres");
    }
  }else{
    alertify.error("La Actual contraseña no concuerda");
  }
}
        
        // Translated
    $('.dropify').dropify({
        messages: {
            default: 'Subir Fotografía',
            replace: 'Nueva Fotografía',
            remove:  'X',
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
        imgFileExtensions: ['png', 'jpg', 'jpeg'],
        maxFileSizePreview: "5M",
        allowedFormats: ['portrait', 'square', 'landscape'],
        allowedFileExtensions: ['png', 'jpg', 'jpeg'],
         error: {
            'fileSize': 'The file size is too big ({{ value }} max).',
            'minWidth': 'The image width is too small ({{ value }}}px min).',
            'maxWidth': 'The image width is too big ({{ value }}}px max).',
            'minHeight': 'The image height is too small ({{ value }}}px min).',
            'maxHeight': 'The image height is too big ({{ value }}px max).',
            'imageFormat': 'The image format is not allowed ({{ value }} only).',
            'fileExtension': 'Formato Incorrecto, ingresar fotos con formato ({{ value }}).'
        },
        tpl: {
            wrap:            '<div class="dropify-wrapper"></div>',
            loader:          '<div class="dropify-loader"></div>',
            message:         '<div class="dropify-message"><span class="file-icon" /> <p>{{ default }}</p></div>',
            preview:         '<div class="dropify-preview" style="width: 100px; height:100px" ><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-infos-message">{{ replace }}</p></div></div></div>',
            filename:        '<p class="dropify-filename"><span class="dropify-filename-inner"></span></p>',
            clearButton:     '<button type="button" class="btn btn-theme dropify-clear"><i class="fa fa-remove"></i></button>',
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
<style type="text/css">
  .pad6{
    padding-right: 6px;
    padding-left: 6px;
  }

  .ecom-widget-sales ul li span{
    color:#F03434 !important;
    display:block;
      width:60%;
      word-wrap:break-word;
  }

 

  @media (max-width: 576px) { .ecom-widget-sales ul li span{  width:100%; color:#F03434 !important; } }

  
</style>