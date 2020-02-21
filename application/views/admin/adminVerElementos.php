<main class="main" style="height: 100%;">
            <!-- Breadcrumb -->
            <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="<?php echo site_url(); ?>menu">Menú</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo site_url(); ?>Adm_ModuloElementos/administrarElementos">Administración de Elementos</a><strong> ( <?php echo $cantidadRegistrosCluster; ?> ) Registros</strong>
                </li>
            </ol>

            <div class="col-md-12">
                <div class="card card-accent-theme">
                    <div class="card-body">
                        <div class='table-responsive'>
                             <table class='table full-color-table full-danger-table hover-table'>
                               <thead>                           
                                <tr>
                                     <th>Nro.</th>
                                     <th>Nombre Elemento</th>
                                     <th>Foto</th>
                                     <th>Categoría</th>
                                     <th>Marca</th>
                                     <th>Código SKU</th>
                                     <th>Nombre Local</th>
                                </tr>
                                </thead>
                               <tbody>
                                <?php foreach ($clus as $c) { ?>
                                    <tr>
                                        <td><?php echo $c["RowNum"]?></td>
                                        <td><?php echo $c["Nombre"]?></td>
                                            <?php if ($c["Foto"]=="") {
                                            ?>
                                            <td><div class='u-img'><img src="<?php echo site_url(); ?>archivos/foto_elemento/ej.png"></div></td>
                                            <?php
                                            }else{
                                            ?>
                                            <td><div class='u-img'><img src="<?php echo site_url().$c["Foto"] ?>"></div></td>    
                                            <?php
                                            } 
                                            ?>                                          
                                        <td><?php echo $c["Categoria"]?></td>
                                        <td><?php echo $c["Marca"]?></td>
                                        <td><?php echo $c["Cod_SKU"]?></td>
                                        <td><?php echo $c["NombreLocal"]?></td>
                                    </tr>
                                <?php } ?>
                               </tbody>
                            </table>
                            <?php

                            if(isset($opcion)){                
                    echo "                   
                    <div class='col-md-4' >
                    <nav aria-label='Page navigation example'>
                        <ul class='pagination'>";
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verCluster?opcion=1&amp;idClus=".$var_clus."' >Inicio</a></li>";
                    if($opcion!=1){                     
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verCluster?opcion=".($opcion-1)."&amp;idClus=".$var_clus."' > Anterior</a></li>";
                    }
                    if(($opcion-2)>0){
                      
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verCluster?opcion=".($opcion-2)."&amp;idClus=".$var_clus."' >".($opcion-2)."</a></li>";
                    }
                    if(($opcion-1)>0){
                        
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verCluster?opcion=".($opcion-1)."&amp;idClus=".$var_clus."' >".($opcion-1)."</a></li>";
                    }   

                    echo "<li class='page-item active'><a class='page-link text-red' style='border-color: #e01111; background-color: #fff; color: #e01111; href=''  ><span class='badge badge-danger hertbit'>$opcion</span></a></li>";

                    if(($opcion+1)<=$cantidad){
                        
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verCluster?opcion=".($opcion+1)."&amp;idClus=".$var_clus."' >".($opcion+1)."</a></li>";
                    }
                    if(($opcion+2)<=$cantidad){
                       
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verCluster?opcion=".($opcion+2)."&amp;idClus=".$var_clus."' >".($opcion+2)."</a></li>";
                    }
                    if(($opcion+3)<=$cantidad){
                         echo "<li class='page-item'><a class='page-link bg-danger text-white'>...</a></li>";
                       
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verCluster?opcion=$cantidad&amp;idClus=".$var_clus."'>$cantidad</a></li>";
                    }
                    if($opcion!=$cantidad){
                      
                        echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verCluster?opcion=".($opcion+1)."&amp;idClus=".$var_clus."'>Siguiente</a></li>
                        </ul>
                    </nav>";
                    }

                    
            
                    echo "</form></div>";  
                }
                ?>
                        </div>      

                    </div>
                                <!-- end card-body -->
                </div>
                            <!-- end card -->
            </div>

        </main>

        


<script src="<?php echo  site_url(); ?>assets/libs/bootstrap-switch/bootstrap-switch.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/bootbox/bootbox.min.js"></script>
    <!--sweetalert -->
<script src="<?php echo  site_url(); ?>assets/libs/sweetalert/sweetalert.js"></script>

<script type="text/javascript">


</script>