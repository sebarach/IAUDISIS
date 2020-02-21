<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>Adm_ModuloElementos/administrarLocales">Administración de Locales</a><?= " ( Total de registros ".$total . ")"; ?>
        </li>
    </ol>

    <div class="col-md-12">
        <div class="card card-accent-theme">
            <div class="card-body">
                <div class='table-responsive'>
                     <table class='table full-color-table full-danger-table hover-table'>
                        <h5><?php //echo $ListaLocales[0]["Nombre_Cluster_Local"];?></h5>
                       <thead>                           
                        <tr>      
                            <th>Nro</th>   |  
                            <th>Nombre Local</th>
                            <th>Dirección</th>
                            <th>Latitud</th>
                            <th>Longitud</th>
                        </tr>
                        </thead>
                       <tbody>
                            <tr>
                        <?php foreach ($ListaLocales as $ll) { ?>  
                            <td><?php echo $ll["Filas"];?></td>
                            <td><?php echo $ll["NombreLocal"];?></td>
                            <td><?php echo $ll["Direccion"];?></td>
                            <td><?php echo $ll["Latitud"];?></td>
                            <td><?php echo $ll["Longitud"];?></td>
                            </tr>
                        <?php } ?>
                       </tbody>
                    </table>   
                    <?php

if(isset($opcion))
{                
echo "                   
<div class='col-md-4' >
<nav aria-label='Page navigation example'>
<ul class='pagination'>";
echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verClusterLocal?opcion=0&amp;idClus=".$var_clus."' >Inicio</a></li>";
if(!$opcion==0){                     
echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verClusterLocal?opcion=".($opcion-1)."&amp;idClus=".$var_clus."' > Anterior</a></li>";
}
if(($opcion-2)>0){

echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verClusterLocal?opcion=".($opcion-2)."&amp;idClus=".$var_clus."' >".($opcion-2)."</a></li>";
}
if(($opcion-1)>0){

echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verClusterLocal?opcion=".($opcion-1)."&amp;idClus=".$var_clus."' >".($opcion-1)."</a></li>";
}   

echo "<li class='page-item active'><a class='page-link text-red' style='border-color: #e01111; background-color: #fff; color: #e01111; href=''  ><span class='badge badge-danger hertbit'>$opcion</span></a></li>";

if(($opcion+1)<=$cantidad){

echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verClusterLocal?opcion=".($opcion+1)."&amp;idClus=".$var_clus."' >".($opcion+1)."</a></li>";
}
if(($opcion+2)<=$cantidad){

echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verClusterLocal?opcion=".($opcion+2)."&amp;idClus=".$var_clus."' >".($opcion+2)."</a></li>";
}
if(($opcion+3)<=$cantidad){
echo "<li class='page-item'><a class='page-link bg-danger text-white'>...</a></li>";

echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verClusterLocal?opcion=$cantidad&amp;idClus=".$var_clus."'>$cantidad</a></li>";
}
if($opcion!=$cantidad){

echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloElementos/verClusterLocal?opcion=".($opcion+1)."&amp;idClus=".$var_clus."'>Siguiente</a></li>
</ul>
</nav>";
}



echo "</form></div>";  
}
?>                         
                </div>      
            </div>
        </div>
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