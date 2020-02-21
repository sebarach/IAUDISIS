<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class App_ModuloMetas extends CI_Controller {
	public function __construct(){

		parent::__construct();
		$this->load->helper("url","form");	
		$this->load->library('form_validation'); 
		$this->load->model("funcion_login");
		$this->load->model("ModuloMetas");
		$this->load->model("ModuloJornadas");
		$this->load->model("ModuloDocumento");
		
	}

	function metasUsuarioApp(){
		if(isset($_SESSION["sesion"])){
		      if($_SESSION['Perfil']==3){
		        $BD=$_SESSION["BDSecundaria"];
		        $data["Nombre"]=$_SESSION["Nombre"];
		        $data["Perfil"] = $_SESSION["Perfil"];
		        $data["Cargo"] = $_SESSION["Cargo"];
		        $idUser=$_SESSION["Usuario"];
				$data["Fechas"]=$this->ModuloMetas->listarFechasMetasMovil($_SESSION["BDSecundaria"],$_SESSION["Usuario"]);
			    $msj=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
		        $data["mensaje"]=$this->ModuloJornadas->CapturarMensaje($BD,$idUser);
		        $data["cantidadMsj"]=count($data["mensaje"]);
		        $data["mensajeNuevo"]=$this->ModuloJornadas->CapturarMensajeNuevo($BD,$idUser);
		        $data["cantidadMsjNuevos"]=count($data["mensajeNuevo"]);
		        $data["Carpetas"]=$this->ModuloDocumento->cargarCarpetasporUsuarioAsignado($idUser,$BD);
		        $this->load->view('contenido');
		        $this->load->view('layout/headerApp',$data);
		        $this->load->view('layout/sidebarApp',$data);
		        $this->load->view('App/MetasApp',$data);
		        $this->load->view('layout/footerApp',$data);
		    } else {
		   		redirect(site_url("login"));
			}
		} else {
		   redirect(site_url("login"));
		}
	}

	function CbuscarLocalesMetasMovil(){
		if(isset($_POST["fechas"]) && $_POST["fechas"]!=''){
			$BD=$_SESSION["BDSecundaria"];
			$fechas = $_POST["fechas"];	
			$op = explode("/", $fechas);	
			$mes=$op[0];
		 	$anio=$op[1];
			$datos=$this->ModuloMetas->MbuscarLocalesMetasMovil($BD,$_SESSION["Usuario"],$mes,$anio);    
	        if(count($datos)==0){
	            echo '';
	        } else {
	            foreach ($datos as $da) {
	                echo "<option value='".$da["ID_Local"]."' >".$da["NombreLocal"]."</option>";
	            }
	        }
	    }else{
	        echo '';
		}
	}

	function CListarDashMetas(){
		if(isset($_POST["local"]) && $_POST["local"]!=''){		
			$BDB2B=$this->ModuloMetas->buscarClienteB2B($_SESSION["Cliente"])->NombreBDB2B;			
			$BD=$_SESSION["BDSecundaria"];
			$fechas = $_POST["fechas"];	
			$local = $_POST["local"];	
			$op = explode("/", $fechas);	
			$mes=$op[0];
		 	$anio=$op[1];  
			$metas=$this->ModuloMetas->MetasB2B($BD,$local,$mes,$anio);
			$sumametas=0;
			$sumaventas=0;
			$cont=1;
			$dash="";
			echo '<script src="'.site_url().'assets/libs/raphael/raphael.min.js"></script>
					 <script src="'.site_url().'assets/libs/charts-morris-chart/morris.min.js"></script>';
			foreach ($metas as $m) {
				if(isset($BDB2B) && $BDB2B!=''){
					$ventas=$this->ModuloMetas->VentasB2B($BDB2B,$local,$mes,$anio,$m["elemento"]);	
				}else{
					$ventas["VentaMetas"]='0';
				}
				if(!isset($ventas) || $ventas==''){
					$ventas["VentaMetas"]='0';
				}
				if($ventas["VentaMetas"]<$m["meta"]){  
					$claseI='fa fa-arrow-down';
					$claseC='text-danger';
				}else{
					$claseI='fa fa-arrow-up';
					$claseC='text-success';
				}
				$porcentaje=round((($ventas["VentaMetas"]*100)/$m["meta"]),0);
				$dash.= '
                    <div class="col-md-4">
                        <div class="card card-accent-theme">
                            <div class="card-body">
                                <div class="h5 text-dark">
                                    <strong>'.$m["elemento"].'</strong>
                                </div>
                                <div class="h5 text-theme">'.$porcentaje.'% de Avance</div>
                                <div id="pie-chart-'.$cont.'"></div>

                                <div class="h6">
                                    <span class="fa fa-circle text-danger"></span> -Metas
                                    <span class="">'.str_replace('.',',',$m["meta"]).'
                                        <i class=""></i>
                                    </span>
                                </div>
                                <div class="h6">
                                    <span class="fa fa-circle text-success"></span> -Ventas
                                    <span class="'.$claseC.'">'.str_replace('.',',',$ventas["VentaMetas"]).'
                                        <i class="'.$claseI.'"></i>
                                    </span>
                                </div>


                            </div>
                        </div>
                    </div>
                <script type="text/javascript">
                	setTimeout ( function () {
						Morris.Donut({
						    element: "pie-chart-'.$cont.'",
						    data: [
						      {label: "Metas'; if($_SESSION=='26') { $dash.='(Kg)'; } $dash.='", value: parseInt('.round($m["meta"],0).'), color:"#E53D37"},
						      {label: "Ventas'; if($_SESSION=='26') { $dash.='(Kg)'; } $dash.='", value: parseInt('.round($ventas["VentaMetas"],0).'), color:"#4BE339"}
						     
						    ]
						});
					}, 500);
				 </script>';
				$sumametas=$sumametas+$m["meta"];
				$sumaventas=$sumaventas+$ventas["VentaMetas"];
				$cont++;
			}
			if($sumaventas<$sumametas){  
				$claseI='fa fa-arrow-down';
				$claseC='text-danger';
			}else{
				$claseI='fa fa-arrow-up';
				$claseC='text-success';
			}
			$porcentaje=round((($sumaventas*100)/$sumametas),0);
			echo '<div class="col-md-4">
                        <div class="card card-accent-theme">
                            <div class="card-body">
                                <div class="h5 text-dark">
                                    <strong> General </strong>
                                </div>
                                <div class="h5 text-theme">'.$porcentaje.'% de Avance</div>
                                <div id="pie-chart-'.$cont.'"></div>

                                <div class="h6">
                                    <span class="fa fa-circle text-danger"></span> -Metas
                                    <span class="">'.str_replace('.',',',$sumametas).'
                                        <i class=""></i>
                                    </span>
                                </div>
                                <div class="h6">
                                    <span class="fa fa-circle text-success"></span> -Ventas
                                    <span class="'.$claseC.'">'.str_replace('.',',',$sumaventas).'
                                        <i class="'.$claseI.'"></i>
                                    </span>
                                </div>


                            </div>
                        </div>
                    </div>
                <script type="text/javascript">
                	setTimeout ( function () {
						Morris.Donut({							
						    element: "pie-chart-'.$cont.'",
						    data: [
						      {label: "Metas'; if($_SESSION=='26') {echo '(Kg)'; } echo '", value: parseInt('.round($sumametas,0).'), color:"#E53D37"},
						      {label: "Ventas'; if($_SESSION=='26') {echo '(Kg)'; } echo '", value: parseInt('.round($sumaventas,0).'), color:"#4BE339"}
						     
						    ]
						});
					}, 500);						
				 </script>';
				echo $dash;
	    }else{
	        echo '';
		}
	}


}

?>