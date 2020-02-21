<!-- set up the modal to start hidden and fade in and out -->
<?php if (isset($tipo)){ 
 if ($tipo == 1){
   $class = 'modal-header bg-danger';
   $mensaje = 'Error con el Nombre del local N°:'.$cantidad;
 }
 if ($tipo == 2){
   $class = 'modal-header bg-danger';
   $mensaje = 'Error con la Dirección del local N°:'.$cantidad;
 }
 if ($tipo == 3){
   $class = 'modal-header bg-danger';
   $mensaje = 'Error con la Cadena del local N°:'.$cantidad;
 }
  if ($tipo == 4){
   $class = 'modal-header bg-danger';
   $mensaje = 'Error con la Latitud del local N°:'.$cantidad;
 }
 if ($tipo == 5){
   $class = 'modal-header bg-danger';
   $mensaje = 'Error con la Longitud del local N°:'.$cantidad;
 }
 if ($tipo == 6){
   $class = 'modal-header bg-danger';
   $mensaje = 'Error con el radio del local N°:'.$cantidad;
 }
 if ($tipo == 7){
   $class = 'modal-header bg-success';
   $mensaje = $cantidad.' Locales ingresados correctamente';
 }
 if ($tipo == 8){
   $class = 'modal-header bg-success';
   $mensaje = $cantidad.' Jornadas ingresadas correctamente';
 }
 if ($tipo == 9){
   $class = 'modal-header bg-danger';
   $mensaje = ' El Rut en la línea N°: '.$cantidad.' no existe';
 }
 if ($tipo == 10){
   $class = 'modal-header bg-danger';
   $mensaje = ' El Local en la línea N°:'.$cantidad.' no existe';
 }
 if ($tipo == 11){
   $class = 'modal-header bg-danger';
   $mensaje = ' El Local en la línea N°:'.$cantidad.' no puede quedar vacío';
 }
 if ($tipo == 12){
   $class = 'modal-header bg-danger';
   $mensaje = ' El Producto en la línea N°:'.$cantidad.' no puede quedar vacío';
 }
 if ($tipo == 13){
   $class = 'modal-header bg-danger';
   $mensaje = 'El Local en la línea N°: '.$cantidad.' ya existe';
 }
 if ($tipo == 14){
   $class = 'modal-header bg-danger';
   $mensaje = 'El nombre del cluster ingresado ya se encuentra registrado en el sistema.';
 }
 if ($tipo == 15){
   $class = 'modal-header bg-danger';
   $mensaje = 'El elemento ya se encuentra registrado en el sistema.';
 }
 if ($tipo == 16){
   $class = 'modal-header bg-success';
   $mensaje = 'Elemento ingresado exitosamente.';
 }
 if ($tipo == 17){
   $class = 'modal-header bg-success';
   $mensaje = 'Elementos ingresados exitosamente.';
 }
 if ($tipo == 18){
   $class = 'modal-header bg-danger';
   $mensaje = 'El nombre del elemento en línea '.$cantidad.' ya se encuentra registrado en el sistema.';
 }
 if ($tipo == 19){
   $class = 'modal-header bg-danger';
   $mensaje ='El Producto en la línea N°:'.$cantidad.' no existe;';
 }
 if ($tipo == 20){
   $class = 'modal-header bg-success';
   $mensaje = 'Contraseña enviada al correo electronico.';
 }
 if ($tipo == 21){
   $class = 'modal-header bg-danger';
   $mensaje ='La Carpeta ya existe, por favor, intente con otro nombre.';
 }
 if ($tipo == 22){
   $class = 'modal-header bg-success';
   $mensaje ='Enlace guardado correctamente.';
 }
 if ($tipo == 23){
   $class = 'modal-header bg-success';
   $mensaje ='Archivo guardado correctamente.';
 }
 if ($tipo == 24){
   $class = 'modal-header bg-success';
   $mensaje ='Cluster modificado correctamente.';
 }
 if ($tipo == 25){
   $class = 'modal-header bg-success';
   $mensaje ='Carpeta asignada a los usuarios correctamente.';
 }
 if ($tipo == 26){
   $class = 'modal-header bg-success';
   $mensaje ='Carpeta asignada a los grupos de usuarios correctamente.';
 }
  if ($tipo == 27){
   $class = 'modal-header bg-danger';
   $mensaje ='La Carpeta ya ha sido asignada al o los usuarios.';
 }
 if ($tipo == 28){
   $class = 'modal-header bg-success';
   $mensaje ='Tarea creada correctamente.';
 }
 if ($tipo == 29){
   $class = 'modal-header bg-success';
   $mensaje ='Se ha asignado la tarea correctamente.';
 }
 if ($tipo == 30){
   $class = 'modal-header bg-danger';
   $mensaje ='No se ha ingresado ningún archivo.';
 }
 if ($tipo == 31){
   $class = 'modal-header bg-danger';
   $mensaje ='Debe ingresar un archivo Excel.';
 }
 if ($tipo == 32){
   $class = 'modal-header bg-success';
   $mensaje ='Tarea modificada correctamente.';
 }
 if ($tipo == 33){
   $class = 'modal-header bg-success';
   $mensaje ='Se ingresaron '.$cantidad.' usuarios.';
 }
 if ($tipo == 34){
   $class = 'modal-header bg-danger';
   $mensaje ='El rut en la línea '.$cantidad.' ya se encuentra registrado.';
 }
 if ($tipo == 35){
   $class = 'modal-header bg-danger';
   $mensaje ='El genero de la línea '.$cantidad.' debe ser masculino o femenino.';
 }
 if ($tipo == 36){
   $class = 'modal-header bg-danger';
   $mensaje ='El teléfono en la línea '.$cantidad.' no puede tener más de 12 números.';
 }
 if ($tipo == 37){
   $class = 'modal-header bg-danger';
   $mensaje ='El nombre del perfil en la línea '.$cantidad.' no existe.';
 }
 if ($tipo == 38){
   $class = 'modal-header bg-danger';
   $mensaje ='Falta la fecha de inicio.';
 }
 if ($tipo == 39){
   $class = 'modal-header bg-success';
   $mensaje ='Cluster agregado correctamente.';
 }
 if ($tipo == 40){
   $class = 'modal-header bg-success';
   $mensaje = 'Constraseña modificada con éxito.';
 }
  if ($tipo == 41){
   $class = 'modal-header bg-danger';
   $mensaje ='Formato de archivo no válido.';
 }
 if ($tipo == 42){
   $class = 'modal-header bg-danger';
   $mensaje ='La cantidad de días ingresada en el horario no coincide con el mes ingresado.';
 }
 if ($tipo == 43){
   $class = 'modal-header bg-danger';
   $mensaje ='El local de la línea '.$cantidad.' no puede ser modificado.';
 }
 if ($tipo == 44){
   $class = 'modal-header bg-danger';
   $mensaje ='El usuario de la línea '.$cantidadU.' no puede ser modificado.';
 }
 if ($tipo == 45){
   $class = 'modal-header bg-danger';
   $mensaje ='La entrada del día '.$dia.' de la línea '.$lineaDia.' no puede ser modificada.';
 }
 if ($tipo == 46){
   $class = 'modal-header bg-danger';
   $mensaje ='La salida del día '.$dia.' de la línea '.$lineaDia.' no puede ser modificada.';
 }
 if ($tipo == 47){
   $class = 'modal-header bg-success';
   $mensaje = 'Horario editado correctamente';
 }
 if ($tipo == 48){
   $class = 'modal-header bg-danger';
   $mensaje = 'Ya existe horario asignado para el mes de '.$mes.'. Si desea modificar el horario diríjase a Jornadas, Administración de Jornadas, Actualizar Horario.';
 }
 if ($tipo == 49){
   $class = 'modal-header bg-danger';
   $mensaje = 'El formato del caracter "'.strtoupper($char).'"" de la línea '.$lineaDia.' no coincide con el formato de hora';
 }
 if ($tipo == 50) {
   $class = 'modal-header bg-danger';
   $mensaje = 'No existe horario para este mes o es un mes antiguo.';
 }
 if ($tipo == 51){
   $class = 'modal-header bg-success';
   $mensaje = 'Audio cargado con éxito';
 }
 if ($tipo == 52){
   $class = 'modal-header bg-danger';
   $mensaje = 'Error con la Region/Departamento del local N°:'.$cantidad;
 }
 if ($tipo == 53){
   $class = 'modal-header bg-danger';
   $mensaje = 'Error con la Ciudad/Provincia del local N°:'.$cantidad;
 }
 if ($tipo == 54){
   $class = 'modal-header bg-danger';
   $mensaje = 'Error con la Comuna/Distrito del local N°:'.$cantidad;
 }
 if ($tipo == 55){
   $class = 'modal-header bg-danger';
   $mensaje = 'El grupo no esta ingresado en la fila N°:'.$cantidad;
 }
 if ($tipo == 56){
   $class = 'modal-header bg-danger';
   $mensaje = 'El usuario no esta ingresado en la fila N°:'.$cantidad;
 }
 if ($tipo == 57){
   $class = 'modal-header bg-danger';
   $mensaje = 'El grupo no existe en la fila N°:'.$cantidad;
 }
 if ($tipo == 58){
   $class = 'modal-header bg-danger';
   $mensaje = 'El usuario no existe en la fila N°:'.$cantidad;
 }
 if ($tipo == 59){
   $class = 'modal-header bg-success';
   $mensaje = $cantidad.' Asignaciones ingresadas correctamente';
 }
 if ($tipo == 60){
   $class = 'modal-header bg-danger';
   $mensaje = 'El grupo no esta ingresado en la fila N°:'.$cantidad;
 }
 if ($tipo == 61){
   $class = 'modal-header bg-danger';
   $mensaje = 'El local no esta ingresado en la fila N°:'.$cantidad;
 }
 if ($tipo == 62){
   $class = 'modal-header bg-danger';
   $mensaje = 'El grupo no existe en la fila N°:'.$cantidad;
 }
 if ($tipo == 63){
   $class = 'modal-header bg-danger';
   $mensaje = 'El local no existe en la fila N°:'.$cantidad;
 }
 if ($tipo == 64){
   $class = 'modal-header bg-success';
   $mensaje = $cantidad.' Asignaciones ingresadas correctamente';
 }
 if ($tipo == 65){
   $class = 'modal-header bg-success';
   $mensaje = $cantidad.' Formulario replicado con éxito';
 }
 if ($tipo == 66){
   $class = 'modal-header bg-danger';
   $mensaje = 'El Elemento no esta ingresado en la fila N°:'.$cantidad;
 }
 if ($tipo == 67){
   $class = 'modal-header bg-danger';
   $mensaje = 'El Año no esta ingresado en la fila N°:'.$cantidad;
 }
 if ($tipo == 68){
   $class = 'modal-header bg-danger';
   $mensaje = 'El Mes no esta ingresado en la fila N°:'.$cantidad;
 }
 if ($tipo == 69){
   $class = 'modal-header bg-danger';
   $mensaje = 'La Meta no esta ingresado en la fila N°:'.$cantidad;
 }
 if ($tipo == 70){
   $class = 'modal-header bg-danger';
   $mensaje = 'Error, la extensión del archivo adjunto no corresponde.';
 }
 if ($tipo == 71){
   $class = 'modal-header bg-danger';
   $mensaje = 'Error, no existe el archivo adjunto.';
 }
 if ($tipo == 72){
   $class = 'modal-header bg-success';
   $mensaje = $cantidad.' Metas ingresadas correctamente';
 }
 if ($tipo == 73){
   $class = 'modal-header bg-danger';
   $mensaje = 'El horario a actualizar debe ser el mismo que el horario descargado!';
 }

?>
 <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="<?php echo $class; ?>">
                    <h6 class="modal-title text-white">Mensaje del Sistema</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $mensaje; ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- sometime later, probably inside your on load event callback -->
<script>
    $("#myModal").on("show", function() {    // wire up the OK button to dismiss the modal when shown
        $("#myModal a.btn").on("click", function(e) {
            console.log("button pressed");   // just as an example...
            $("#myModal").modal('hide');     // dismiss the dialog
        });
    });
    $("#myModal").on("hide", function() {    // remove the event listeners when the dialog is dismissed
        $("#myModal a.btn").off("click");
    });
    
    $("#myModal").on("hidden", function() {  // remove the actual elements from the DOM when fully hidden
        $("#myModal").remove();
    });
    
    $("#myModal").modal({                    // wire up the actual modal functionality and show the dialog
      "backdrop"  : "static",
      "keyboard"  : true,
      "show"      : true                     // ensure the modal is shown immediately
    });
</script>
