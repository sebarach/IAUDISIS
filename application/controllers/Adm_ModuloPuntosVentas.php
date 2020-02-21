<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Adm_ModuloPuntosVentas extends CI_Controller {
	public function __construct(){

		parent::__construct();
		$this->load->model("funcion_login");
		$this->load->model("ModuloPuntosVentas");
		$this->load->library('phpexcel');
		$this->load->library('upload');
	}

	function listarCadenas(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$BD=$_SESSION["BDSecundaria"];
				$data["Cadenas"]= $this->ModuloPuntosVentas->listarCadenas($BD);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Cargo"] = $_SESSION["Cargo"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCadenas',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function listarZona(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$BD=$_SESSION["BDSecundaria"];
				$data["zonas"]= $this->ModuloPuntosVentas->listarZona($BD);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Cargo"] = $_SESSION["Cargo"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminZona',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function listarLocales(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 

				if(isset($_GET['opcion']))
				{
					if(is_numeric($_GET['opcion']))
					{
						$buscasana = $_GET['opcion'];
					}
					else
					{
						$buscasana=0;
					}
				}
				else
				{
					$buscasana=0;
				}


				if(isset($_POST['txtLocal'])) 
				{
					//die($_POST['txtLocal']);
					$data['buscador'] = true;
					$local =$this->limpiarComilla($_POST["txtLocal"]);
					$data['opcion'] = $buscasana;
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$BD=$_SESSION["BDSecundaria"];
					$totalFilas = $this->ModuloPuntosVentas->listarLocalesTodos($BD);
					$data["Locales"]=$this->ModuloPuntosVentas->buscarLocalNombre($local,$BD);
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data['cantidad'] = ceil(($totalFilas['filas'])/20)-1;
					$data['totalFilas'] = $totalFilas;
					$data["Cargo"] = $_SESSION["Cargo"];
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
					$this->load->view('layout/sidebar',$data);
					$this->load->view('admin/adminLocales',$data);
					$this->load->view('layout/footer',$data);
					return;
				}

				$data['opcion'] = $buscasana;
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$BD=$_SESSION["BDSecundaria"];
				$totalFilas = $this->ModuloPuntosVentas->listarLocalesTodos($BD);
				$data["Locales"]= $this->ModuloPuntosVentas->listarLocalesTodosSeba($buscasana,$BD);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data['cantidad'] = ceil(($totalFilas['filas'])/20)-1;
				$data['totalFilas'] = $totalFilas;
				$data["Cargo"] = $_SESSION["Cargo"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminLocales',$data);
			    $this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	public function mapaLocal(){
		// $iduser=$_SESSION["id_usuario"];
		$la=$_POST["lat"];
		$lo=$_POST["long"];
		$ra=$_POST["rang"];
		
		echo"

		<div class='chart tab-pane active' id='revenue-chart' style='position: relative; height: 300px;'><div style='width: 100%; height: 100%;' id='map'></div></div>
        <script type='text/javascript'>      
      		var map, infoWindow;

      // First, create an object containing LatLng and population for each city.
      //fijamos algunos puntos en el mapa con un circulo
      var citymap = {
          losangeles: {
          center: {lat: ".$la.", lng: ".$lo."},
          population: 1
        }
      };
      
      //dibujar la posicion donde nos encontramos en el mapa
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: ".$la.", lng: ".$lo."},
          zoom: 15,
          mapTypeControl: false,
          disableDefaultUI: false, // le dejamos solo el mapa por default
          styles: [
            {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{color: '#263c3f'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'labels.text.fill',
              stylers: [{color: '#6b9a76'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{color: '#38414e'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{color: '#212a37'}]
            },
            {
              featureType: 'road',
              elementType: 'labels.text.fill',
              stylers: [{color: '#9ca5b3'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{color: '#746855'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{color: '#1f2835'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'labels.text.fill',
              stylers: [{color: '#f3d19c'}]
            },
            {
              featureType: 'transit',
              elementType: 'geometry',
              stylers: [{color: '#2f3948'}]
            },
            {
              featureType: 'transit.station',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#17263c'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#515c6d'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#17263c'}]
            }
          ]
        });

        var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
        var icons = {
          parking: {
            name: 'Parking',
            icon: iconBase + 'parking_lot_maps.png'
          },
          library: {
            name: 'Library',
            icon: iconBase + 'library_maps.png'
          },
          info: {
            name: 'Info',
            icon: iconBase + 'info-i_maps.png'
          }
        };

        var features = [
          {
            position: new google.maps.LatLng(".$la.",".$lo."),
            type: 'info',
            title: 'Punto de Venta'
          }
          ];

        features.forEach(function(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.type].icon,
            map: map
          });
        });
        
         for (var city in citymap) {
          // Add the circle for this city to the map.
          var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: citymap[city].center,
            radius: Math.sqrt(citymap[city].population) * ".$ra."
          });
        }

        infoWindow = new google.maps.InfoWindow;

      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: El servicio de Geolocalización no esta disponible.' :
                              'Error: Puede que no este Activado el GPS o no ha comportido su Localización');
        infoWindow.open(map);
      }    
    	</script>
    	<script type='text/javascript' src='//maps.googleapis.com/maps/api/js?key=AIzaSyB3412Cmx6-Q9TR0Zqad70sXtCUhb3505A&language=es&libraries=places'></script>
    	";

	}

	function listarGrupoLocales(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$BD=$_SESSION["BDSecundaria"];
				$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
				$data["LocalesA"]= $this->ModuloPuntosVentas->listarLocales($_SESSION["BDSecundaria"]);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Cargo"] = $_SESSION["Cargo"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminGrupoLocales',$data);
			   	$this->load->view('layout/footer',$data);
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function creacionPuntosVentas(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$data["Usuario"]=$_SESSION["Usuario"];					
				$data["Nombre"]=$_SESSION["Nombre"];
				$data["Perfil"] = $_SESSION["Perfil"];
				$data["Cliente"] = $_SESSION["Cliente"];
				$data["NombreCliente"]=$_SESSION["NombreCliente"];
				$BD=$_SESSION["BDSecundaria"];
				$data["Zonas"]=$this->ModuloPuntosVentas->listarZonas($BD);
				$data["Cadenas"]= $this->ModuloPuntosVentas->listarCadenasActivos($BD);
				$data["Regiones"]= $this->ModuloPuntosVentas->listarRegiones($_SESSION["Cliente"]);
				$data["Clientes"]= $this->funcion_login->elegirCliente();
				$data["Paises"]= $this->ModuloPuntosVentas->listarPaisPorCliente($_SESSION["Cliente"]);
				$data["Cargo"] = $_SESSION["Cargo"];
				$this->load->view('contenido');
				$this->load->view('layout/header',$data);
	   			$this->load->view('layout/sidebar',$data);
	   			$this->load->view('admin/adminCrearPuntosDeVentas',$data);
			   	$this->load->view('layout/footer',$data);			   	
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function validarCreacionCadena(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				// OP1 = Ingresado Correcto
				// OP2 = No se Insertaron las filas
				// OP3 = Editado Correctamente
				$var=0;

				//Rellenar Variables				
				$cadena=$this->limpiarComilla($_POST["txt_cadena"]);
				$creador=$_SESSION["Usuario"];	
				$BD=$_SESSION["BDSecundaria"];
				$validar=$this->ModuloPuntosVentas->validarCadena($cadena,$BD)->existe;
				if($validar>0){
					$var=1;
				}

				if($var==0){
					if(isset($_POST["txt_idCadena"])){
						//Modificar Cadena
						$idCadena=$_POST["txt_idCadena"];
						$filas=$this->ModuloPuntosVentas->editarCadena($cadena,$creador,$BD,$idCadena);
						if($filas["CantidadInsertadas"]==0){
							echo "OP2";
						}else{
							echo "OP3";
						}
					}else{
						//Insertar y retonar Cantidad de Registros
						$filas=$this->ModuloPuntosVentas->ingresarCadena($cadena,$creador,$BD);
						if($filas["CantidadInsertadas"]==0){
							echo "OP2";
						}else{
							echo "OP1".$filas["CantidadInsertadas"];
						}
					}					
				}else{
					echo "OP5";
				}		
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function validarCreacionZona()
	{
		if(isset($_SESSION["sesion"]))
		{
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				// OP1 = Ingresado Correcto
				// OP2 = No se Insertaron las filas
				// OP3 = Editado Correctamente
				$var=0;
				//Rellenar Variables				
				$Zona=$this->limpiarComilla($_POST["txt_Zona"]);
				$creador=$_SESSION["Usuario"];
				$BD=$_SESSION["BDSecundaria"];
				$validar=$this->ModuloPuntosVentas->validarZona($Zona,$BD)->existe;
				//Existe
				$validarZona=$this->ModuloPuntosVentas->buscarIdZona($Zona,$BD);
				if($validar>0)
				{
					$var=1;
				}
				if($var==0)
				{
					if(isset($_POST["txt_idZona"]))
					{
						if($validarZona==0) 
						{
							$idZona=$_POST["txt_idZona"];
							$filas=$this->ModuloPuntosVentas->editarZona($Zona,$BD,$idZona);
							if($filas["CantidadInsertadas"]==0)
							{
								echo "OP2";
							}
							else
							{
								echo "OP1".$filas["CantidadInsertadas"];
							}
						}
						else
						{
							echo "OP4";
						}	
					}
					else
					{
						//Insertar y retonar Cantidad de Registros
						if($validarZona==0) 
						{
							$filas=$this->ModuloPuntosVentas->ingresarZona($Zona,$BD);

							if($filas["CantidadInsertadas"]==0)
							{
								echo "OP2";
							}
							else
							{
								echo "OP1".$filas["CantidadInsertadas"];
							}
						}
						else
						{
							echo "OP4";
						}					
					}
				}
				else
				{
					echo "OP5";
				}		
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}
	function validarCreacionLocal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				$this->load->model("ModuloJornadas");
				// OP1 = Ingresado Correcto
				// OP2 = No se Insertaron las filas
				// OP3 = Editado Correctamente
				$var=0;
				//Rellenar Variables
				$local=$this->limpiarComilla($_POST["txt_local"]);
				$direccion=$this->limpiarComilla($_POST["txt_direccion"]);
				$cadena=$this->limpiarComilla($_POST["lb_cadena"]);
				$zona=$this->limpiarComilla($_POST["lb_zona"]);				
				if($_POST["lb_comuna"]!=""){
					$comuna=$this->limpiarComilla($_POST["lb_comuna"]);
				}else{
					$comuna=00;
				}
				if($_POST["lb_region"]!=""){
					$region=$this->limpiarComilla($_POST["lb_region"]);
				}else{
					$region=00;
				}	
				if($_POST["lb_zona"]!=""){
					$zona=$this->limpiarComilla($_POST["lb_zona"]);
				}else{
					$zona=00;
				}			
				$latitud=$this->limpiarComilla(round($_POST["txt_latitud"], 8));
				$longitud=$this->limpiarComilla(round($_POST["txt_longitud"], 8));
				$rango=$this->limpiarComilla($_POST["txt_rango"]);
				$creador=$_SESSION["Usuario"];	
				$BD=$_SESSION["BDSecundaria"];
				if(isset($_POST["txt_idLocal"])){
					$validar=$this->ModuloJornadas->ValidarLocalEditar($BD,$local,$_POST["txt_idLocal"]);	
				}else{
					$validar=$this->ModuloJornadas->ValidarLocal($BD,$local);	
				}				
				if($validar>0){
					$var=1;
				}
				if($var==0){
					if(isset($_POST["txt_idLocal"])){
						$idLocal=$_POST["txt_idLocal"];
						$filas=$this->ModuloPuntosVentas->editarLocal($local,$direccion,$cadena,$region,$comuna,$latitud,$longitud,$rango,$creador,$zona,$BD,$idLocal);
						if($filas["CantidadInsertadas"]==0){
							echo "OP2";
						}else{
							echo "OP3".$filas["CantidadInsertadas"];
						}
					}else{
						//Insertar y retonar Cantidad de Registros
						$filas=$this->ModuloPuntosVentas->ingresarLocal($local,$direccion,$cadena,$region,$comuna,$latitud,$longitud,$rango,$creador,$zona,$BD)->CantidadInsertadas;
						if($filas==0)
						{
							echo "OP2";
						}else{
							echo "OP1".$filas;
						}
					}

				}else{
					echo "OP5";
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function ValidarCreacionGrupoLocal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				// OP1 = Ingresado Correcto
				// OP2 = No se Insertaron las filas
				// OP3 = Editado Correctamente
				$var=0;
				$exito=0;
				$correctos=0;
				$incorrectos=0;

				//Rellenar Variables
				$grupoL=$this->limpiarComilla($_POST["txt_grupoLocal"]);
				$creador=$_SESSION["Usuario"];	
				$BD=$_SESSION["BDSecundaria"];

				if($var==0){
					if(isset($_POST["txt_idGrupoLocal"])){
						//Modificar Cadena
						$idGrupoL=$_POST["txt_idGrupoLocal"];
						$filas=$this->ModuloPuntosVentas->editarGrupoLocal($grupoL,$creador,$BD,$idGrupoL);
						if($filas["CantidadInsertadas"]==0){
							echo "OP2";
						}else{
							$this->ModuloPuntosVentas->desactivarGrupoL($_SESSION["BDSecundaria"],$idGrupoL);
							if(isset($_POST['txt_locales'])){			
								$locales=$_POST['txt_locales'];
								foreach ($locales as $l) {
									$ingresos=$this->ModuloPuntosVentas->editarITGrupoL($_SESSION["BDSecundaria"],$l,$idGrupoL);	
									if($ingresos["CantidadInsertadas"]==0){
										$incorrectos++;
									}else{
										$correctos++;
									}
								}
								echo "OP5".$correctos;
							}else{
								echo "OP3".$filas["CantidadInsertadas"];
							}
						}
					}else{
						//Insertar y retonar Cantidad de Registros
						$filas=$this->ModuloPuntosVentas->ingresarGrupoLocal($grupoL,$creador,$BD);
						if($filas["CantidadInsertadas"]==0){
							echo "OP2";
						}else{
							if(isset($_POST['txt_locales'])){			
								$locales=$_POST['txt_locales'];
								$gru=$this->ModuloPuntosVentas->buscarIdGrupoLocales($_SESSION["BDSecundaria"],$grupoL);
								foreach ($locales as $l) {
									$ingresos=$this->ModuloPuntosVentas->ingresarITGrupoL($_SESSION["BDSecundaria"],$l,$gru->ID_Grupolocal);	
									if($ingresos["CantidadInsertadas"]==0){
										$incorrectos++;
									}else{
										$correctos++;
									}
								}
								echo "OP4".$correctos;
							}else{
								echo "OP1".$filas["CantidadInsertadas"];
							}
						}
					}					
				}			
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function editarCadena(){
		$cadena=$_POST["cadena"];
		$BD=$_SESSION["BDSecundaria"];
		$datosCadena= $this->ModuloPuntosVentas->buscarCadenaID($cadena,$BD);
		echo "<form method='post' id='FormNuevoCadena' action='#'>";
		echo '<div class="form-group">
                   <label for="control-demo-1" class="col-sm-6">Nombre Cadena <label style="color:red">* &nbsp;</label></label>
                   <div class="input-group">
                       <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                       <input type="text" id="txt_cadena" name="txt_cadena" class="form-control" placeholder="Nombre de la Cadena" value="';
                       	if(isset($datosCadena["NombreCadena"])){ echo $datosCadena["NombreCadena"]; }
               		   	echo '" required>
                   </div>
                   <div  id="val_cadena" style="color:red;"></div>                               
               </div>';		
        echo "<input type='hidden' name='txt_idCadena' value='". $datosCadena["ID_Cadena"]."'>";
		echo "</form>";
	}

	function editarZona(){
		$Zona=$_POST["Zona"];
		$BD=$_SESSION["BDSecundaria"];
		$datosZona= $this->ModuloPuntosVentas->buscarZonaID($Zona,$BD);
		//var_dump($datosZona);
		echo "<form method='post' id='FormNuevoZona' action='#'>";
		echo '<div class="form-group">
                   <label for="control-demo-1" class="col-sm-6">Nombre Zona <label style="color:red">* &nbsp;</label></label>
                   <div class="input-group">
                       <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                       <input type="text" id="txt_Zona" name="txt_Zona" class="form-control" placeholder="Nombre de la Zona" value="';
												 if(isset($datosZona["Zona"]))
												 { 
													 echo $datosZona["Zona"];
												 }
               		   	echo '" required>
                   </div>
                   <div  id="val_Zona" style="color:red;"></div>                               
               </div>';		
        echo "<input type='hidden' name='txt_idZona' value='". $datosZona["ID_Zona"]."'>";
		echo "</form>";
	}

	function editarLocal(){
		$local=$_POST["local"];
		$BD=$_SESSION["BDSecundaria"];
		$datosCadena= $this->ModuloPuntosVentas->buscarLocalID($local,$BD);		
		$Cadenas = $this->ModuloPuntosVentas->listarCadenasActivos($BD);
		$Regiones = $this->ModuloPuntosVentas->listarRegiones($_SESSION["Cliente"]);
		$Zonas=$this->ModuloPuntosVentas->listarZonas($BD);
		if(isset($datosCadena["ID_Region"])){
			$Comunas= $this->ModuloPuntosVentas->listarComunas($datosCadena["ID_Region"]);
		}			
		echo "<form method='post' id='FormNuevoLocal' action='#'>";
		echo '<div class="form-group">
                <label for="control-demo-1" class="col-sm-6">Nombre de Local <label style="color:red">* &nbsp;</label></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-pencil"></i></span>
                    <input type="text" id="txt_local" name="txt_local" class="form-control" placeholder="Nombre del Local" value="';
                    if(isset($datosCadena["NombreLocal"])){ echo $datosCadena["NombreLocal"]; }
                    echo '" required>
                </div>       
                <div  id="val_local" style="color:red;"></div>       
            </div>
            <div class="form-group">
                <label for="control-demo-1" class="col-sm-6">Dirección <label style="color:red">* &nbsp;</label></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                    <input type="text" id="txt_direccion" name="txt_direccion" class="form-control" placeholder="Dirección de la Cadena" value="';
                    if(isset($datosCadena["Direccion"])){ echo $datosCadena["Direccion"]; }
                    echo '" required>
                </div> 
                <div  id="val_direccion" style="color:red;"></div>   
            </div>
            <div class="form-group">
                <label for="control-demo-1" class="col-sm-6">Cadena <label style="color:red">* &nbsp;</label></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                    <select name="lb_cadena" id="lb_cadena" class="form-control form-control-sm">
                        <option value="">Elija una Cadena</option>';
                            foreach ($Cadenas as $c) {
                            	if(isset($datosCadena["ID_Cadena"])){
                            		echo "<option value='".$c['ID_Cadena']."'";
                                    if($datosCadena["ID_Cadena"]==$c["ID_Cadena"]){ 
                                        echo " selected ";
                                    }
                                    echo ">".$c['NombreCadena']."</option>";
                            	}else{
                            		echo "<option value='".$c['ID_Cadena']."'>".$c['NombreCadena']."</option>";   
                            	}                                
                            }
                    echo '</select>                                           
                </div>
                <div  id="val_eleCadena" style="color:red;"></div>
            </div>
            <div class="form-group">
                <label for="control-demo-1" class="col-sm-6">Región <label style="color:red">* &nbsp;</label></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-google-maps"></i></span>
                    <select name="lb_region" id="lb_region" class="form-control form-control-sm" onchange="Region()">
                        <option value="">Elija una Región</option>';
                            foreach ($Regiones as $r) {
                            	if(isset($datosCadena["ID_Region"])){
                            		echo "<option value='".$r['ID_Region']."'";
                                    if($datosCadena["ID_Region"]==$r["ID_Region"]){ 
                                        echo " selected ";
                                    }
                                    echo ">".$r['Region']."</option>";
                            	}else{
                            		echo "<option value='".$r['ID_Region']."'>".$r['Region']."</option>"; 
                            	} 
                            }
                    echo '</select> 
                </div> 
                <div  id="val_region" style="color:red;"></div>              
            </div>
            <div class="form-group">
                <label for="control-demo-1" class="col-sm-6">Comuna <label style="color:red">* &nbsp;</label></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-google-maps"></i></span>
                    <select name="lb_comuna" id="lb_comuna" class="form-control form-control-sm">
                        <option value="">Elija una Comuna</option>';
                        if(isset($Comunas)){
                        	foreach ($Comunas as $c) {
                            	if(isset($datosCadena["ID_Comuna"])){
                            		echo "<option value='".$c['ID_Comuna']."'";
                                    if($datosCadena["ID_Comuna"]==$c["ID_Comuna"]){ 
                                        echo " selected ";
                                    }
                                    echo ">".$c['Comuna']."</option>";
                            	}else{
                            		echo "<option value='".$c['ID_Comuna']."'>".$c['Comuna']."</option>"; 
                            	} 
                            }
                        }
                    echo '</select> 
                </div> 
                <div  id="val_comuna" style="color:red;"></div>                                          
            </div>
            <div class="form-group">
                <label for="control-demo-1" class="col-sm-6">Latitud <label style="color:red">* &nbsp;</label></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-compass-outline"></i></span>
                    <input type="text" id="txt_latitud" name="txt_latitud" class="form-control" placeholder="-33.4583432" value="'; 
                    if(isset($datosCadena["Latitud"])){ echo $datosCadena["Latitud"]; }
                    echo '" required>
                </div>    
                <div  id="val_latitud" style="color:red;"></div>                                    
            </div>
            <div class="form-group">
                <label for="control-demo-1" class="col-sm-6">Longitud <label style="color:red">* &nbsp;</label></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-compass"></i></span>
                    <input type="text" id="txt_longitud" name="txt_longitud" class="form-control" placeholder="-70.6116514" value="';
					if(isset($datosCadena["Longitud"])){ echo $datosCadena["Longitud"]; }
                    echo '" required>
                </div> 
                <div  id="val_longitud" style="color:red;"></div>                                          
            </div>    
            <div class="form-group">
                <label for="control-demo-1" class="col-sm-6">Rango <label style="color:red">* &nbsp;</label></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="ti-signal"></i></span>
                    <input type="text" id="txt_rango" name="txt_rango" class="form-control" placeholder="Rango en metros" onkeypress="return SoloNumeros(event)" value="'; 
                    if(isset($datosCadena["Rango"])){ echo $datosCadena["Rango"]; }
                    echo'" required>
                </div> 
                <div  id="val_rango" style="color:red;"></div>                                          
            </div> 
            <div class="form-group">
                <label for="control-demo-1" class="col-sm-6">Zona <label style="color:red">* &nbsp;</label></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-home-map-marker"></i></span>
                    <select name="lb_zona" id="lb_zona" class="form-control form-control-sm">
                        <option value="">Elija una Zona</option>';
                            foreach ($Zonas as $z) {
                            	if(isset($datosCadena["ID_Zona"])){
                            		echo "<option value='".$z['id_zona']."'";
                                    if($datosCadena["ID_Zona"]==$z["id_zona"]){ 
                                        echo " selected ";
                                    }
                                    echo ">".$z['zona']."</option>";
                            	}else{
                            		echo "<option value='".$z['id_zona']."'>".$z['zona']."</option>";   
                            	}                                
                            }
                    echo '</select>                                           
                </div>     ';		
        echo "<input type='hidden' name='txt_idLocal' value='".$local."'>";
		echo "</form>";	
	}

	function editarGrupoL(){
		$NombreGrupo=$_POST["NombreGrupo"];
		$opcion=$_POST["Opcion"];
		$BD=$_SESSION["BDSecundaria"];
		$LocalesA= $this->ModuloPuntosVentas->listarLocales($_SESSION["BDSecundaria"]);
		$activos = $this->ModuloPuntosVentas->listarUsuariosActivosGrupoLocales($_SESSION["BDSecundaria"],$NombreGrupo);
		$datosGrupoL= $this->ModuloPuntosVentas->buscarGrupoLocalID($NombreGrupo,$BD);
		echo "<form method='post' id='FormNuevoGrupoL' action='#'>";
		echo '<div class="form-group">';
			if($opcion==1){
                echo '<label for="control-demo-1" class="col-sm-6">Nombre Grupo Local <label style="color:red">* &nbsp;</label></label>
                   <div class="input-group">
                       <span class="input-group-addon"><i class="fa fa-group"></i></span>
                       <input type="text" id="txt_grupoLocal" name="txt_grupoLocal" class="form-control" placeholder="Nombre del Grupo Local" value="';
                       	if(isset($datosGrupoL["NombreGL"])){ echo $datosGrupoL["NombreGL"]; }
               		   	echo '" required>
                   </div>
                   <div  id="val_grupoLocal" style="color:red;"></div>';   
            }else{       
            	echo '<h4 align="center">'.$datosGrupoL["NombreGL"].'</h4>
            	<br>
            	<label for="control-demo-1" class="col-sm-6">Agregar Locales</label>
               	<div class="input-group">
                   	<span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                   	<select id="select2" class="form-control select2" data-plugin="select2" multiple  id="txt_locales[]" name="txt_locales[]" style="width: 100%;">';
                            foreach ($LocalesA as $L) {                            	
                                echo "<option value='".$L["ID_Local"]."' ";
                                foreach ($activos as $a) {
                            		if($a["ID_Local"]==$L["ID_Local"]){
                            			echo " selected ";
                            		}
                            	}
                                echo ">".$L["NombreLocal"]."</option>";                                
                            }
                    echo '</select> 
               	</div>';   
               	echo '<input type="hidden" name="txt_grupoLocal" id="txt_grupoLocal" value="'; echo $datosGrupoL["NombreGL"]; echo '">';
            }                     
        echo'</div>';		
        echo "<input type='hidden' name='txt_idGrupoLocal' value='". $datosGrupoL["ID_Grupolocal"]."'>";
		echo "</form>";
		echo '<script src="';echo  site_url(); echo'assets/libs/select2/dist/js/select2.min.js"></script>
				<script src="';echo  site_url(); echo'assets/libs/multiselect/js/jquery.multi-select.js"></script>

				<script type="text/javascript">
					$("#select2").select2({});
				</script>';
	}

	function cambiarEstadoCadena(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["cadena"])){
					$cadena=$_POST["cadena"];
					$vigencia=$_POST["estado"];
					echo "<form method='post' id='cambiarEstadoCadena' action='cambiarEstadoCadenaFinal'>";
					if($vigencia==1){
						echo "<p>¿Esta Seguro que desea Desactivar la Cadena?</p>";						
					}else{
						echo "<p>¿Esta Seguro que desea Activar la Cadena?</p>";
					}
					echo "<input type='hidden' name='txt_cadena' value='".$cadena."'>";
					echo "<input type='hidden' name='txt_estado' value='".$vigencia."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloPuntosVentas/listarCadenas"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function cambiarEstadoZona(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["Zona"])){
					$Zona=$_POST["Zona"];
					$vigencia=$_POST["estado"];
					echo "<form method='post' id='cambiarEstadoZona' action='cambiarEstadoZonaFinal'>";
					if($vigencia==1){
						echo "<p>¿Esta Seguro que desea Desactivar la Zona?</p>";						
					}else{
						echo "<p>¿Esta Seguro que desea Activar la Zona?</p>";
					}
					echo "<input type='hidden' name='txt_Zona' value='".$Zona."'>";
					echo "<input type='hidden' name='txt_estado' value='".$vigencia."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloPuntosVentas/listarZona"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function cambiarEstadoZonaFinal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_Zona"])){				
					$Zona=$_POST["txt_Zona"];
					$vigencia=$_POST["txt_estado"];
					$BD=$_SESSION["BDSecundaria"];
					$filas=$this->ModuloPuntosVentas->cambiarEstadoZona($Zona,$vigencia,$BD);
					if($vigencia=1){
						$var="desactivado";
					}else{
						$var="activado";
					}
					if($filas["CantidadInsertadas"]==0){
						$data['mensaje']='alertify.success("No se pudo realizar la operacion")';
					}else{
						$data['mensaje']='alertify.success("Se ha "'.$var.'" correctamente")';
					}
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$BD=$_SESSION["BDSecundaria"];
					$data["zonas"]= $this->ModuloPuntosVentas->listarZona($BD);
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Cargo"] = $_SESSION["Cargo"];
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminZona',$data);
				   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloPuntosVentas/listarZona"));
				}
			}
		}
	}

	function cambiarEstadoCadenaFinal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_cadena"])){				
					$cadena=$_POST["txt_cadena"];
					$vigencia=$_POST["txt_estado"];
					$BD=$_SESSION["BDSecundaria"];
					$filas=$this->ModuloPuntosVentas->cambiarEstadoCadena($cadena,$vigencia,$_SESSION["Usuario"],$BD);
					if($vigencia=1){
						$var="desactivado";
					}else{
						$var="activado";
					}
					if($filas["CantidadInsertadas"]==0){
						$data['mensaje']='alertify.success("No se pudo realizar la operacion")';
					}else{
						$data['mensaje']='alertify.success("Se ha "'.$var.'" correctamente")';
					}
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$BD=$_SESSION["BDSecundaria"];
					$data["Cadenas"]= $this->ModuloPuntosVentas->listarCadenas($BD);
					$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Cargo"] = $_SESSION["Cargo"];
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminCadenas',$data);
				   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloPuntosVentas/listarCadenas"));
				}
			}
		}
	}

	function cambiarEstadoLocal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["local"])){
					$local=$_POST["local"];
					$vigencia=$_POST["estado"];
					echo "<form method='post' id='cambiarEstadoLocal' action='cambiarEstadoLocalFinal'>";
					if($vigencia==1){
						echo "<p>¿Esta Seguro que desea Desactivar el Local?</p>";						
					}else{
						echo "<p>¿Esta Seguro que desea Activar el Local?</p>";
					}
					echo "<input type='hidden' name='txt_local' value='".$local."'>";
					echo "<input type='hidden' name='txt_estado' value='".$vigencia."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloPuntosVentas/listarLocales"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function cambiarEstadoLocalFinal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_local"])){		
					$local=$_POST["txt_local"];
					$vigencia=$_POST["txt_estado"];
					$BD=$_SESSION["BDSecundaria"];
					$filas=$this->ModuloPuntosVentas->cambiarEstadoLocal($local,$vigencia,$_SESSION["Usuario"],$BD);
					if($vigencia=1){
						$var="desactivado";
					}else{
						$var="activado";
					}
					if($filas["CantidadInsertadas"]==0){
						$data['mensaje']='alertify.success("No se pudo realizar la operacion")';
					}else{
						$data['mensaje']='alertify.success("Se ha "'.$var.'" correctamente")';
					}					
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$BD=$_SESSION["BDSecundaria"];
					$data["Cadenas"]= $this->ModuloPuntosVentas->listarCadenas($BD);
					$data["Locales"]= $this->ModuloPuntosVentas->listarLocales($BD);
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Cargo"] = $_SESSION["Cargo"];
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminLocales',$data);
				   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloPuntosVentas/listarLocales"));
				}
			}
			 redirect(site_url("Adm_ModuloPuntosVentas/listarLocales"));
		}
	}

	function cambiarEstadoGrupoLocal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["GrupoL"])){
					$GrupoL=$_POST["GrupoL"];
					$vigencia=$_POST["estado"];
					echo "<form method='post' id='cambiarEstadoGrupoLocal' action='cambiarEstadoGrupoLocalFinal'>";
					if($vigencia==1){
						echo "<p>¿Esta Seguro que desea Desactivar el Grupo Local?</p>";						
					}else{
						echo "<p>¿Esta Seguro que desea Activar el Grupo Local?</p>";
					}
					echo "<input type='hidden' name='txt_grupoLocal' value='".$GrupoL."'>";
					echo "<input type='hidden' name='txt_estado' value='".$vigencia."'>";
					echo "</form>";
				}else{
					redirect(site_url("Adm_ModuloPuntosVentas/listarGrupoLocales"));
				}
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function cambiarEstadoGrupoLocalFinal(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_POST["txt_grupoLocal"])){				
					$GrupoL=$_POST["txt_grupoLocal"];
					$vigencia=$_POST["txt_estado"];
					$BD=$_SESSION["BDSecundaria"];
					$filas=$this->ModuloPuntosVentas->cambiarEstadoGrupoLocal($GrupoL,$vigencia,$_SESSION["Usuario"],$BD);
					if($vigencia=1){
						$var="desactivado";
					}else{
						$var="activado";
					}
					if($filas["CantidadInsertadas"]==0){
						$data['mensaje']='alertify.success("No se pudo realizar la operacion")';
					}else{
						$data['mensaje']='alertify.success("Se ha "'.$var.'" correctamente")';
					}					
					$data["Usuario"]=$_SESSION["Usuario"];					
					$data["Nombre"]=$_SESSION["Nombre"];
					$data["Perfil"] = $_SESSION["Perfil"];
					$data["Cliente"] = $_SESSION["Cliente"];
					$data["NombreCliente"]=$_SESSION["NombreCliente"];
					$BD=$_SESSION["BDSecundaria"];
					$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
					$data["LocalesA"]= $this->ModuloPuntosVentas->listarLocales($_SESSION["BDSecundaria"]);
					$data["Clientes"]= $this->funcion_login->elegirCliente();
					$data["Cargo"] = $_SESSION["Cargo"];
					$this->load->view('contenido');
					$this->load->view('layout/header',$data);
		   			$this->load->view('layout/sidebar',$data);
		   			$this->load->view('admin/adminGrupoLocales',$data);
				   	$this->load->view('layout/footer',$data);
				}else{
					redirect(site_url("Adm_ModuloPuntosVentas/listarGrupoLocales"));
				}
			}
		}
	}

	function elegirRegion(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
		        if(isset($_POST["reg"]) && $_POST["reg"]!=''){
		    		$region = $_POST["reg"];		
		    		$datos=$this->ModuloPuntosVentas->listarComunas($region);    
	                if(count($datos)==0){
	                    echo '';
	                } else {
	                    foreach ($datos as $da) {
	                        echo "<option value='".$da["ID_Comuna"]."' >".$da["Comuna"]."</option>";
	                    }
	                }
		        }else{
		            echo '';
		        }
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function elegirCiudad(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){
		        if(isset($_POST["reg"]) && $_POST["reg"]!=''){
		    		$region = $_POST["reg"];		
		    		$datos=$this->ModuloPuntosVentas->listarCiudadesPorRegion($region);    
	                if(count($datos)==0){
	                    echo '';
	                } else {
	                    foreach ($datos as $da) {
	                        echo "<option value='".$da["ID_Ciudad"]."' >".$da["Ciudad"]."</option>";
	                    }
	                }
		        }else{
		            echo '';
		        }
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function elegirComunaCiudad(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
		        if(isset($_POST["ciudad"]) && $_POST["ciudad"]!=''){
		    		$ciudad = $_POST["ciudad"];		
		    		$datos=$this->ModuloPuntosVentas->listarComunasPorCiudad($ciudad);    
	                if(count($datos)==0){
	                    echo '';
	                }else {
	                    foreach ($datos as $da) {
	                        echo "<option value='".$da["ID_Comuna"]."' >".$da["Comuna"]."</option>";
	                    }
	                }
		        }else{
		            echo '';
		        }
			}else{
				redirect(site_url("login/inicio"));	
			}
		}else{
		   redirect(site_url("login/inicio"));
		}
	}

	function mostrarMapaLocal(){
		$lo = $_POST["longitud"];
		$la = $_POST["latitud"];
		echo"
		<div class='chart tab-pane active' id='revenue-chart' style='position: relative; height: 300px;'>
                <div id='map'></div>         
    	<script type='text/javascript'>
      	function initMap() {


        var Miubiccion = new google.maps.LatLng(".$la.",".$lo.");
        var map = new google.maps.Map(document.getElementById('map'), {
          center: Miubiccion,
          zoom: 16
        });

        var coordInfoWindow = new google.maps.InfoWindow();
        coordInfoWindow.setContent(createInfoWindowContent(Miubiccion, map.getZoom()));
        coordInfoWindow.setPosition(Miubiccion);
        coordInfoWindow.open(map);

        map.addListener('zoom_changed', function() {
          coordInfoWindow.setContent(createInfoWindowContent(Miubiccion, map.getZoom()));
          coordInfoWindow.open(map);
        });
      }

      var TILE_SIZE = 256;

      function createInfoWindowContent(latLng, zoom) {
        var scale = 1 << zoom;

        var worldCoordinate = project(latLng);

        var pixelCoordinate = new google.maps.Point(
            Math.floor(worldCoordinate.x * scale),
            Math.floor(worldCoordinate.y * scale));

        var tileCoordinate = new google.maps.Point(
            Math.floor(worldCoordinate.x * scale / TILE_SIZE),
            Math.floor(worldCoordinate.y * scale / TILE_SIZE));

        return [
        	'Información del Local',
          'Latitud: ".$la." ',
          'Longitud: ".$lo." ',
        ].join('<br>');
      }

      function project(latLng) {
        var siny = Math.sin(latLng.lat() * Math.PI / 180);

        siny = Math.min(Math.max(siny, -0.9999), 0.9999);

        return new google.maps.Point(
            TILE_SIZE * (0.5 + latLng.lng() / 360),
            TILE_SIZE * (0.5 - Math.log((1 + siny) / (1 - siny)) / (4 * Math.PI)));
      }
    </script>   

    <script async defer
    <script type='text/javascript' src='//maps.googleapis.com/maps/api/js?key=AIzaSyB3412Cmx6-Q9TR0Zqad70sXtCUhb3505A&language=es&libraries=places'></script>
	";

	}    

    function IngresarLocalesMasivo(){
    	if(isset($_SESSION["sesion"])){
    		if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
    			if(isset($_FILES['excelv']['name'])){
    				$error=0;
    				$contador=0;
    				$excel = $this->limpiaEspacio($_FILES['excelv']['name']);
    				if (pathinfo($excel, PATHINFO_EXTENSION)=='xlssss') {
    					$error=41;
    					$mens['tipo'] = $error;
	    				$mens['cantidad']=($contador+1);
						$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$BD=$_SESSION["BDSecundaria"];
						$data["Cadenas"]= $this->ModuloPuntosVentas->listarCadenasActivos($BD);
						$data["Regiones"]= $this->ModuloPuntosVentas->listarRegiones($_SESSION["Cliente"]);
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$data["Cargo"] = $_SESSION["Cargo"];
						$data["Paises"]= $this->ModuloPuntosVentas->listarPaisPorCliente($_SESSION["Cliente"]);
						$this->load->view('contenido');			
						$this->load->view('layout/header',$data);						
			   			$this->load->view('layout/sidebar',$data);	   			
			   			$this->load->view('admin/adminCrearPuntosDeVentas',$data);
					   	$this->load->view('layout/footer',$data);
					   	$this->load->view('layout/mensajes',$mens);
	    			}else{
	    				$creador=$_SESSION["Usuario"];
						$BD=$_SESSION["BDSecundaria"];  				
						$this->load->model("ModuloJornadas");
						$excel = $this->limpiaEspacio($_FILES['excelv']['name']);	
					 	$R=$this->subirArchivos($excel,0,0);
					 	$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
						$objReader = PHPExcel_IOFactory::createReader($tipo);
						$object = $objReader->load("archivos/archivos_Temp/".$excel);
						$object->setActiveSheetIndex(0);
						$defaultPrecision = ini_get('precision');
						ini_set('precision', $defaultPrecision);
						$fila =2;	
						$parametro=0;
					 	set_time_limit(600);			 	
					 	while($parametro==0){	
					 		if($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue()==NULL)
					 		{
					 			$parametro=1;
					 		}else{				 			
					 			$local[$contador]=$this->limpiarComilla($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue());
					 			$validar=$this->ModuloJornadas->ValidarLocal($BD,$local[$contador]);
					 			if($validar>0){
					 				$parametro=1;
					 				$error=13;
					 				break;
					 			}
					 			if($local[$contador]==null){
					 				$parametro=1;
					 				$error=1;
					 				break;
					 			}					
					 			$direccion[$contador]=$this->limpiarComilla($object->getActiveSheet()->getCell('B'.$fila)->getCalculatedValue());
					 			if($direccion[$contador]==null){
					 				$direccion[$contador]=00;					 					
					 			}
					 			$reg=$this->limpiarComilla($object->getActiveSheet()->getCell('C'.$fila)->getCalculatedValue());					 			
					 			if($reg==null || $reg == '') {		
					 				$region[$contador]=00;	
						 		}else{
						 			$region[$contador]=$this->ModuloPuntosVentas->buscarIdRegion($reg);
						 			if($region[$contador]['ID_Region']==null) {	
						 				$parametro=1;
					 					$error=52;	
						 				break;					 				
						 			}else{
						 				$region[$contador]=$region[$contador]['ID_Region'];
						 			}
						 		}
						 		$ciu=$this->limpiarComilla($object->getActiveSheet()->getCell('D'.$fila)->getCalculatedValue());
					 			if($ciu==null || $ciu == '') {		
					 				$ciudad[$contador]=00;	
						 		}else{
						 			$ciudad[$contador]=$this->ModuloPuntosVentas->buscarIdCiudadPorRegion($region[$contador],$ciu);
						 			if($ciudad[$contador]['ID_Ciudad']==null) {		
						 				$parametro=1;
					 					$error=53;	
						 				break;						 				
						 			}else{
						 				$ciudad[$contador]=$ciudad[$contador]['ID_Ciudad'];
						 			}
						 		}
					 			$com=$this->limpiarComilla($object->getActiveSheet()->getCell('E'.$fila)->getCalculatedValue());
					 			if($com==null || $com=='') {
					 				$comuna[$contador]=00;								 			
						 		}else{
						 			$comuna[$contador]=$this->ModuloPuntosVentas->buscarIdComunaPorCiudad($region[$contador],$ciudad[$contador],$com);	 			
						 			if($comuna[$contador]['ID_Comuna']==null) {		
					 					$parametro=1;
					 					$error=54;	
						 				break;						 					
						 			}else{
						 				$comuna[$contador]=$comuna[$contador]['ID_Comuna'];
						 			}
						 		}
					 			$zon=$object->getActiveSheet()->getCell('F'.$fila)->getCalculatedValue();
					 			if($zon==null || $zon=='') {
					 				$zona[$contador]=00;
						 		}else{
						 			$zona[$contador]=$this->ModuloPuntosVentas->buscarIdZona($zon,$BD);	 			
						 			if($zona[$contador]['id_zona']==null) {		
					 					$zona[$contador]=00;	
						 			}else{
						 				$zona[$contador]=$zona[$contador]['id_zona'];	
						 			}
						 		}
					 			$cad=$object->getActiveSheet()->getCell('G'.$fila)->getCalculatedValue();
					 			$cadena[$contador]=$this->ModuloPuntosVentas->buscarIdCadena($cad,$BD);	 			
					 			if($cadena[$contador]['id_cadena']==null) {		
				 					$parametro=1;
					 				$error=3;
					 				break;					 					
					 			}
					 			$latitud[$contador]=$object->getActiveSheet()->getCell('H'.$fila)->getCalculatedValue();
					 			if ($latitud[$contador]=="" || $latitud[$contador]==null) {
					 				$parametro=1;
					 				$error=4;
					 				break;		
					 			}
					 			$longitud[$contador]=$object->getActiveSheet()->getCell('I'.$fila)->getCalculatedValue();
					 			if ($longitud[$contador]=="" || $longitud[$contador]==null) {
					 				$parametro=1;
					 				$error=5;
					 				break;	
					 			}
					 			$rango[$contador]=$object->getActiveSheet()->getCell('J'.$fila)->getCalculatedValue();
					 			if ($rango[$contador]==null) {
					 				$parametro=1;
					 				$error=6;
					 				break;		
					 			}
					 			$fila++;
					 			$contador++;
					 		}
		    			}		
		    			$suma=0;
		    			if($error==0){	
			    			for ($i=0; $i <$contador; $i++) { 
		    					$cant=$this->ModuloPuntosVentas->ingresarLocal($this->limpiarComilla($local[$i]),$this->limpiarComilla($direccion[$i]),$cadena[$i]['id_cadena'],$this->limpiarComilla($region[$i]),$this->limpiarComilla($comuna[$i]),str_replace(',','.',$latitud[$i]),str_replace(',','.',$longitud[$i]),$rango[$i],$creador,$zona[$i],$BD)->CantidadInsertadas;
		    					$suma=($suma+$cant);
		    				}    				 					
		    				$mens['tipo'] = 7;
		    				$mens['cantidad']=$suma;					
							$data["Usuario"]=$_SESSION["Usuario"];					
							$data["Nombre"]=$_SESSION["Nombre"];
							$data["Perfil"] = $_SESSION["Perfil"];
							$data["Cliente"] = $_SESSION["Cliente"];
							$data["NombreCliente"]=$_SESSION["NombreCliente"];
							$BD=$_SESSION["BDSecundaria"];
							$data["Cadenas"]= $this->ModuloPuntosVentas->listarCadenasActivos($BD);
							$data["Regiones"]= $this->ModuloPuntosVentas->listarRegiones($_SESSION["Cliente"]);
							$data["Clientes"]= $this->funcion_login->elegirCliente();
							$data["Cargo"] = $_SESSION["Cargo"];
							$data["Paises"]= $this->ModuloPuntosVentas->listarPaisPorCliente($_SESSION["Cliente"]);
							$this->load->view('contenido');						
							$this->load->view('layout/header',$data);
				   			$this->load->view('layout/sidebar',$data);
				   			$this->load->view('admin/adminCrearPuntosDeVentas',$data);
						   	$this->load->view('layout/footer',$data);
						   	$this->load->view('layout/mensajes',$mens);
		 				}else{
		 					$mens['tipo'] = $error;
		    				$mens['cantidad']=($contador+1);
							$data["Usuario"]=$_SESSION["Usuario"];					
							$data["Nombre"]=$_SESSION["Nombre"];
							$data["Perfil"] = $_SESSION["Perfil"];
							$data["Cliente"] = $_SESSION["Cliente"];
							$data["NombreCliente"]=$_SESSION["NombreCliente"];
							$BD=$_SESSION["BDSecundaria"];
							$data["Cadenas"]= $this->ModuloPuntosVentas->listarCadenasActivos($BD);
							$data["Regiones"]= $this->ModuloPuntosVentas->listarRegiones($_SESSION["Cliente"]);
							$data["Clientes"]= $this->funcion_login->elegirCliente();
							$data["Paises"]= $this->ModuloPuntosVentas->listarPaisPorCliente($_SESSION["Cliente"]);
							$data["Cargo"] = $_SESSION["Cargo"];
							$this->load->view('contenido');			
							$this->load->view('layout/header',$data);						
				   			$this->load->view('layout/sidebar',$data);	   			
				   			$this->load->view('admin/adminCrearPuntosDeVentas',$data);
						   	$this->load->view('layout/footer',$data);
						   	$this->load->view('layout/mensajes',$mens);
		 					}	
		 				}	    		
		    		}else{
		    			redirect(site_url("Adm_ModuloPuntosVentas/creacionPuntosVentas"));	
	    		}	    			    		
	    	}
	    }
	}

	function limpiarComilla($rut){
    	$patron = "/['’]/i";    
        $cadena_nueva = preg_replace($patron, "", $rut);
        return $cadena_nueva; 
    }

    function limpiaEspacio($var){
    	$patron = "/[' ']/i";
		$cadena_nueva = preg_replace($patron,"",$var);
		return $cadena_nueva; 
 	}

 	function generarExcelLocales(){
    	$BD=$_SESSION["BDSecundaria"];
    	$this->load->library('phpexcel');
		$objReader =  PHPExcel_IOFactory::createReader('Excel2007');		
		$object = $objReader->load("doc/plantilla/PlantillaListaLocales.xlsx");
		$dataLocal = $this->ModuloPuntosVentas->listarLocales($BD);
		$object->setActiveSheetIndex(0); 
		$column_row=2;
	 	foreach($dataLocal as $row)
	 	{	 
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['NombreLocal']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(1 , $column_row, $row['Direccion']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(2 , $column_row, $row['NombreCadena']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(3 , $column_row, $row['Region']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(4 , $column_row, $row['Comuna']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(5 , $column_row, $row['Zona']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(6 , $column_row, $row['Latitud']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(7 , $column_row, $row['Longitud']);
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(8 , $column_row, $row['Rango']);	 		
	 		$column_row++;	 		
	 	}
	 	header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="ListaLocales.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
    }

    function generarPlantillaExcelLocales(){
    	$BD=$_SESSION["BDSecundaria"];
    	$this->load->library('phpexcel');
		$objReader =  PHPExcel_IOFactory::createReader('Excel2007');		
		$object = $objReader->load("doc/plantilla/PlantillaPDOEjemplo.xlsx");
		$dataLocal = $this->ModuloPuntosVentas->listarLocales($BD);
		$column_row=2;
	 	$object->setActiveSheetIndex(1);
	 	$dataCadenas = $this->ModuloPuntosVentas->listarCadenasActivos($BD);
	 	foreach($dataCadenas as $row)
	 	{	 
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['NombreCadena']);
	 		$column_row++;	 		
	 	}
	 	$column_row=2;
	 	$object->setActiveSheetIndex(2);
	 	$dataZonas = $this->ModuloPuntosVentas->listarZonas($BD);
	 	foreach($dataZonas as $row)
	 	{	 
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['zona']);
	 		$column_row++;	 		
	 	}
	 	$column_row=2;
	 	$object->setActiveSheetIndex(3);
	 	$dataRegion = $this->ModuloPuntosVentas->listarRegiones($_SESSION["Cliente"]);
	 	foreach($dataRegion as $row)
	 	{	 
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['Region']);
	 		$column_row++;	 		
	 	}
	 	$column_row=2;
	 	$object->setActiveSheetIndex(4);
	 	$dataComunas = $this->ModuloPuntosVentas->listarCiudades($_SESSION["Cliente"]);
	 	foreach($dataComunas as $row)
	 	{	 
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['Ciudad']);
	 		$column_row++;	 		
	 	}
	 	$column_row=2;
	 	$object->setActiveSheetIndex(5);
	 	$dataComunas = $this->ModuloPuntosVentas->listarComunasTotales($_SESSION["Cliente"]);
	 	foreach($dataComunas as $row)
	 	{	 
	 		$object->getActiveSheet()->setCellValueByColumnAndRow(0 , $column_row, $row['comuna']);
	 		$column_row++;	 		
	 	}
	 	$object->setActiveSheetIndex(0);
	 	header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="PlantillaLocales.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
    }

    public function subirArchivos($filename){
		$archivo ='excelv';
		$config['upload_path'] = "archivos/archivos_Temp/";	
		$config['file_name'] =$filename;
		$config['max_size'] = "2097152";
		$config['max_width'] = "2000";
		$config['max_height'] = "2000";
		$config['allowed_types'] = "*";
		$config['overwrite'] = TRUE;	
		$this->upload->initialize($config);
		if (!$this->upload->do_upload($archivo)) {
			$data['uploadError'] = $this->upload->display_errors();
			echo $this->upload->display_errors();
			return;
		}
		$data = $this->upload->data();
		$nombre= $data['file_name'];
		return $nombre;
	}

	function IngresarLocalesMasivos(){
		if(isset($_SESSION["sesion"])){
			if($_SESSION['Perfil']==1 || $_SESSION['Perfil']==2){ 
				if(isset($_FILES['excelvg']['name'])){
					$excel = $this->limpiaEspacio($_FILES['excelvg']['name']);	
					$R=$this->subirArchivosG($excel,0,0);
					$this->load->library('phpexcel');
					$tipo = PHPExcel_IOFactory::identify("archivos/archivos_Temp/".$excel);
					$objReader = PHPExcel_IOFactory::createReader($tipo);
					$object = $objReader->load("archivos/archivos_Temp/".$excel);
					$object->setActiveSheetIndex(0);
					$defaultPrecision = ini_get('precision');
					ini_set('precision', $defaultPrecision);
					$fila=2;
					$var=0;
				 	set_time_limit(600);
				 	$parametro =0;	 
				 	$error=0;
				 	$contador=0;	
			 		while($parametro==0){	
				 		if($object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue()==NULL)
				 		{
				 			$parametro=1;
				 		}else{
				 			$TGrupo=$object->getActiveSheet()->getCell('A'.$fila)->getCalculatedValue();		 			
			 				if($TGrupo==null || $TGrupo==''){
			 					$parametro=1;
			 					$error=60;	
				 				break;
				 			}else{
				 				$gru=$this->ModuloPuntosVentas->buscarIdGrupoLocales($_SESSION["BDSecundaria"],$TGrupo);
				 				if($gru==null || $gru==''){
				 					$parametro=1;
				 					$error=62;	
					 				break;
				 				}else{
				 					$Grupo[$contador]=$gru->ID_Grupolocal;
				 				}
				 			}
				 			$TLocales=$object->getActiveSheet()->getCell('B'.$fila)->getCalculatedValue();
				 			if ($TLocales==null || $TLocales=='') {
				 				$parametro=1;
			 					$error=61;	
				 				break;
				 			}else{	
				 				$loc=$this->ModuloPuntosVentas->BuscarIdLocal($_SESSION["BDSecundaria"],$TLocales);
				 				if($loc==null || $loc==''){
				 					$parametro=1;
				 					$error=63;	
					 				break;
				 				}else{
				 					$Locales[$contador]=$loc->ID_Local;
				 				}
				 			}
			 				$fila++;
			 				$contador++;
				 		}
					}
					$suma=0;
	    			if($error==0){	
		    			for($i=0; $i <$contador; $i++){ 
	    					$cant=$this->ModuloPuntosVentas->ingresarITGrupoL($_SESSION["BDSecundaria"],$Locales[$i],$Grupo[$i]);
	    					$suma=($suma+$cant["CantidadInsertadas"]);
	    				}    				 					
	    				$mens['tipo'] = 64;
	    				$mens['cantidad']=$suma;					
						$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$BD=$_SESSION["BDSecundaria"];
						$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
						$data["LocalesA"]= $this->ModuloPuntosVentas->listarLocales($_SESSION["BDSecundaria"]);
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$data["Cargo"] = $_SESSION["Cargo"];
						$this->load->view('contenido');						
						$this->load->view('layout/header',$data);
			   			$this->load->view('layout/sidebar',$data);
			   			$this->load->view('admin/adminGrupoLocales',$data);
					   	$this->load->view('layout/footer',$data);
					   	$this->load->view('layout/mensajes',$mens);
	 				}else{
	 					$mens['tipo'] = $error;
	    				$mens['cantidad']=($contador+1);
						$data["Usuario"]=$_SESSION["Usuario"];					
						$data["Nombre"]=$_SESSION["Nombre"];
						$data["Perfil"] = $_SESSION["Perfil"];
						$data["Cliente"] = $_SESSION["Cliente"];
						$data["NombreCliente"]=$_SESSION["NombreCliente"];
						$BD=$_SESSION["BDSecundaria"];
						$data["GrupoL"] = $this->ModuloPuntosVentas->listarGrupoLocales($BD);
						$data["LocalesA"]= $this->ModuloPuntosVentas->listarLocales($_SESSION["BDSecundaria"]);
						$data["Clientes"]= $this->funcion_login->elegirCliente();
						$data["Cargo"] = $_SESSION["Cargo"];
						$this->load->view('contenido');						
						$this->load->view('layout/header',$data);
			   			$this->load->view('layout/sidebar',$data);
			   			$this->load->view('admin/adminGrupoLocales',$data);
					   	$this->load->view('layout/footer',$data);
					   	$this->load->view('layout/mensajes',$mens);
	 				}	
				}else{
					redirect(site_url("Adm_ModuloUsuario/listarGrupoLocales"));
				}	    		
			}else{
				redirect(site_url("login/inicio"));
			}
		}else{
			redirect(site_url("login/inicio"));
		}
	}


	public function subirArchivosG($filename){
		$archivo ='excelvg';
		$config['upload_path'] = "archivos/archivos_Temp/";	
		$config['file_name'] =$filename;
		$config['max_size'] = "2097152";
		$config['max_width'] = "2000";
		$config['max_height'] = "2000";
		$config['allowed_types'] = "*";
		$config['overwrite'] = TRUE;	
		$this->upload->initialize($config);
		if (!$this->upload->do_upload($archivo)) {
			$data['uploadError'] = $this->upload->display_errors();
			echo $this->upload->display_errors();
			return;
		}
		$data = $this->upload->data();
		$nombre= $data['file_name'];
		return $nombre;
	}



}

