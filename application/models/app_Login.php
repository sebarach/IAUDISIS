 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class app_Login extends CI_model {
	function __construct()
    {
        parent::__construct();
    }


    function Login($usuario, $clave){
    	$consulta=$this->db->query(" exec SP_APP_Login '".$usuario."','".$clave."'");
    	$resultado = $consulta->row_array();
        return $resultado;
    }

    function InfoUsuario($usuario, $token){
    	$consulta=$this->db->query(" exec SP_APP_InfoUsuario '".$usuario."', '".$token."'");
    	$resultado = $consulta->row_array();
        return $resultado;
    }

    function actualizarperfil($usuario,$token,$email,$direccion,$telefono,$nomfoto){
        $consulta=$this->db->query(" exec SP_APP_ActualizarPerfil ".$usuario.", '".$token."','".$email."','".$direccion."',".$telefono.",'".$nomfoto."' ");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function actualizarPassword($usuario, $token,$pass_old,$pass_new){
        $consulta=$this->db->query(" exec SP_APP_ActualizarPassword ".$usuario.", '".$token."','".$pass_old."','".$pass_new."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

}
