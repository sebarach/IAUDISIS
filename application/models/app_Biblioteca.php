 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class app_Biblioteca extends CI_model {
	function __construct()
    {
        parent::__construct();
    }


    function carpetas($usuario, $token){
    	$consulta=$this->db->query(" exec SP_APP_Carpetas ".$usuario.",'".$token."'");
    	$resultado = $consulta->result_array();
        return $resultado;
    }


    function archivos($usuario,$token,$id_carpeta){
    	$consulta=$this->db->query(" exec SP_APP_Archivos ".$usuario.",'".$token."',".$id_carpeta);
    	$resultado = $consulta->result_array();
        return $resultado;
    }


}