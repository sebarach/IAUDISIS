<main class="main" style="height: 100%;">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
             <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Trivia</a>
        </li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <h3 class="text-theme">Administrar Trivias</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table color-bordered-table danger-bordered-table">
                                    <thead>
                                        <tr>
                                            <th>Nombre Trivia</th>
                                            <th>Fecha Creación</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($Trivias as $Tr) { 
                                            echo "<tr>"; 
                                            echo "<td>".$Tr["Nombre"]."</td>";
                                            echo "<td>".$Tr["Fecha_Registro"]."</td>";
                                            echo "<td><form method='POST' action ='".site_url()."Adm_ModuloTrivia/editarTrivia'><input type='hidden' name='txt_id' value='".$Tr['ID_Trivia']."'>
                                            <input type='hidden' id='txt_nombre' name='txt_nombre' value='".$Tr['Nombre']."'>
                                            <button type='submit' class='btn btn-danger' title='Editar Trivia'><i class='fa  fa-edit'></i> Editar</button>&nbsp;&nbsp;</form></td>";
                                            echo "</tr>"; 
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
    
    
    
</script>