<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Admin, Dashboard, Bootstrap" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Audisis</title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo  site_url(); ?>/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo  site_url(); ?>/PNG/icono.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo  site_url(); ?>/PNG/icono.png">
    <link rel="manifest" href="<?php echo  site_url(); ?>/assets/img/favicon/manifest.json">
    <link rel="mask-icon" href="<?php echo  site_url(); ?>/assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/fonts/md-fonts/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/libs/animate.css/animate.min.css">
    <link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/libs/jquery-loading/dist/jquery.loading.min.css">
    <link id="pageStyle" rel="stylesheet" href="<?php echo  site_url(); ?>/assets/css/style-red.css">
</head>

<body>
    <section class="container-pages">
        <div class="brand-logo float-left"><a class="" href="#">I-Audisis</a></div>
        <div class="pages-tag-line text-white">  
            <div class="h4">Bienvenidos a I - Audisis</div>
            <small> Una nueva experiencia en asistencia y formularios en Ruta.</small>
        </div>
        <div class="card pages-card col-lg-4 col-md-6 col-sm-6">
            <div class="card-body ">
                <div class="h4 text-center text-theme"><strong>I-Audisis</strong></div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Nueva Actual:</label>
                    <div class="input-group">
                         <span class="input-group-addon text-theme"><i class="fa fa-asterisk"></i> 
                        </span>
                        <input type="password" id="txt_usuario1" name="txt_usuario1" class="form-control" >
                    </div>
                </div>                        
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Repertir Nueva Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-addon text-theme"><i class="fa fa-asterisk"></i></span>
                        <input type="password" id="txt_usuario2" name="txt_usuario2" class="form-control" >

                    </div>
                </div>
                <input type="hidden" id="txt_usu" value="<?php echo $ID_Usuario; ?>">
                <input type="hidden" id="txt_em" value="<?php echo $Correo; ?>">
                <div class="form-group form-actions">
                    <button type="button" id="btn-login" name="btn-login" class="btn  btn-theme login-btn" onclick="nuevaClave()">   Cambiar Contraseña </button>
                </div>    
            </div>
        </div>
    </section>

    <div class="half-circle"></div>
    <div class="small-circle"></div>
    <div id="copyright"><a href="#" >Audisis</a> &copy; 2018 Progestion. </div>
   
    <script src="<?php echo  site_url(); ?>/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo  site_url(); ?>/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo  site_url(); ?>/assets/libs/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
    <script src="<?php echo  site_url(); ?>assets/js/jsLogin.js"></script>
</body>

</html>