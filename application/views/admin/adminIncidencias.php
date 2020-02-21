<main class="main">
            <!-- Breadcrumb -->
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Layouts</a>
        </li>
        <li class="breadcrumb-item active">Blank Page</li>
    </ol>

        <div class="container">

            <div class="animated fadeIn">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-theme">
                            <div class="card-body">                                  
                                <h3>Administración de Incidencias</h3>
                                <small>
                                    <a>El modulo  esta destinado a crear tipos incidencias pueden estar designadas a un tipo de marcaje.</a>
                                </small>
                                <hr>
                                <div class="row">               
                                    <div class="col-md-12">
                                        <div class="card card-accent-theme ">
                                            <div class="todo-widget">
                                        <h1> Incidencias
                                            <i id="addInc" class="fa fa-plus-square-o pull-right" onclick="agregarIncidencia();"></i>
                                        </h1>
                                        <form id="FormIncidencia" method="post" onsubmit="agregarIncidencia();" >
                                        <input type="text" placeholder="Agregar nueva Incidencia" name="NewIncidencia" id="NewIncidencia" required >
                                        </form>
                                       <ul id="scrollList">
                                           <?php  foreach ($ListarIncidencia as $c) {
                                             echo "  
                                          <li >
                                            <span onclick='EliminarIncidencia(".$c['ID_Incidencias'].");'>
                                                <i class='fa fa-trash'  ></i>
                                            </span>

                                            <i class='fa fa-calendar'></i> ".$c['NombreIncidencia']."
                                            
                                          </li>
                                          ";}?>                                         
                                    </ul>
                                </div>
                                <!-- end card-body -->

                                <div class="card-footer text-center ">
                                    

                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                   
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

        </main>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/dropify/dist/js/dropify.min.js"></script>
<script type="text/javascript">
    function agregarIncidencia(){
        if ($("#NewIncidencia").val()=='') {
         alertify.error("El nombre de la Incidencia esta vacia ");
        }else{
         if ($("#NewIncidencia").val().length>50) {
            alertify.error("El nombre tiene que tener un maximo de 50 caracteres");
         }else{
            $("#addInc").attr("class","fa fa-spin fa-circle-o-notch");
            $.ajax({                        
               type: "POST",                 
               url:"http://checkroom.cl/audisis/Adm_ModuloJornadas/CrearIncidencias",                     
               data: $("#FormIncidencia").serialize(), 
               success: function(data)             
               {            
                 if (data==1) {
                 $("#addInc").attr("class","fa fa-pencil-square-o");
                 alertify.success("Nueva incidencia agregada");
                 setTimeout(function(){window.location.reload();},1000);                 
                 }
                }         
            });
         }
        }
    }

     function agregarMarcaje(){
        if ($("#NewMarcaje").val()=='') {
         alertify.error("El nombre del Marcaje esta vacio ");
        }else{
         if ($("#NewMarcaje").val().length>50) {
            alertify.error("El nombre tiene que tener un maximo de 50 caracteres");
         }else{
            $("#addMar").attr("class","fa fa-spin fa-circle-o-notch");
            $.ajax({                        
               type: "POST",                 
               url:"http://checkroom.cl/audisis/Adm_ModuloJornadas/CrearMarcaje",                     
               data: $("#FormMarcaje").serialize(), 
               success: function(data)             
               {            
                 if (data==1) {
                 $("#addMar").attr("class","fa fa-pencil-square-o");
                 alertify.success("Nuevo Marcaje agregado");
                 setTimeout(function(){window.location.reload();},1000);
                 }else{
                  alertify.success("Ocurrio un error");
                 }
                }         
            });
         }
        }
    }

    function EliminarIncidencia(id){
      $.ajax({                        
         type: "POST",                 
         url:"http://checkroom.cl/audisis/Adm_ModuloJornadas/EliminarIncidencias",                     
         data: "id="+id, 
         success: function(data)             
         {            
           if (data==1) {
           $("#addInc").attr("class","fa fa-pencil-square-o");
           alertify.success("Incidencia Eliminada");
           setTimeout(function(){window.location.reload();},1000);                 
           }
          }         
      });
    }

     function EliminarMarcaje(id){
      $.ajax({                        
         type: "POST",                 
         url:"http://checkroom.cl/audisis/Adm_ModuloJornadas/EliminarMarcaje",                     
         data: "id="+id, 
         success: function(data)             
         {            
           if (data==1) {
           $("#addInc").attr("class","fa fa-pencil-square-o");
           alertify.success("Marcaje Eliminado");
           setTimeout(function(){window.location.reload();},1000);                 
           }
          }         
      });
    }
</script>