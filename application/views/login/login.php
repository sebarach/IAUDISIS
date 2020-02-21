<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Admin, Dashboard, Bootstrap" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="Content-Security-Policy" content="frame-ancestors 'none';">
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
                <div class="h4 text-center text-theme"><img alt="user" src="<?php echo  site_url(); ?>/PNG/logo-iaudisis.png"></div>
                <hr>
                <div class="small text-center text-dark"> Inicie Sesión </div>               
                <form class="login100-form validate-form" id="login" method="post" action="<?php echo site_url() ?>menu">
                    <div class="form-group">
                        <div class="input-group">
                             <span class="input-group-addon text-theme"><i class="fa fa-user"></i> 
                            </span>
                            <input type="text" id="txt_usuario" name="txt_usuario" placeholder="Usuario" class="form-control" >
                        </div>
                    </div>                        
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon text-theme"><i class="fa fa-asterisk"></i></span>
                            <input class="form-control" type="password" id="txt_contra" name="txt_contra" placeholder="Contraseña" >

                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <button id="btn-login" name="btn-login" class="btn  btn-theme login-btn">   Iniciar Sesión </button>
                    </div>
                </form>
                <div class="text-center">
                    <small> Olvido su contraseña ? Recuperar 
                        <a href="#" class="text-theme" data-target='#modal-recuperar' data-toggle='modal'>Aquí</a>
                    </small>
                </div>
            </div>
        </div>
    </section>

    <div class="half-circle"></div>
    <div class="small-circle"></div>
    <div class="modal fade" id="modal-recuperar" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Recuperar Contraseña</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_recuperar" method="POST">
                        <h7>¿Esta seguro que desea recuperar su contraseña?</h7>
                        <br>
                        <h7>Ingrese su Rut, con el guión y digito verificador.</h7>
                        <br>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon text-theme"><i class="fa fa-user"></i> 
                            </span>
                            <input type="text" id="txt_rut" name="txt_rut" placeholder="12.345.678-9" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" onclick="recuperarClave();">Recuperar</button>
                </div>
            </div>
        </div>
    </div>
    <div id="copyright"><a href="#" >Audisis</a> &copy; 2018 Progestion. </div>
   
    <script src="<?php echo  site_url(); ?>/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo  site_url(); ?>/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo  site_url(); ?>/assets/libs/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
    <script src="<?php echo  site_url(); ?>assets/js/jsLogin.js"></script>
</body>

</html>