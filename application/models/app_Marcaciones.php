<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class app_Marcaciones extends CI_model {
	function __construct()
    {
        parent::__construct();
    }


    function localesasignados($usuario, $token){
    	$consulta=$this->db->query(" exec SP_APP_LocalesAsignados ".$usuario.",'".$token."'");
    	$resultado = $consulta->result_array();
        return $resultado;
    }

     function marcaciones($usuario, $token,$mes){
    	$consulta=$this->db->query(" exec SP_APP_Marcaciones ".$usuario.",'".$token."','".$mes."'");
    	$resultado = $consulta->result_array();
        return $resultado;
    }


}