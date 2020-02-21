 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class app_Tareas extends CI_model {
	function __construct()
    {
        parent::__construct();
    }


    function tareas($usuario, $token){
    	$consulta=$this->db->query(" exec SP_APP_Tareas ".$usuario.",'".$token."'");
    	$resultado = $consulta->result_array();
        return $resultado;

    }

    function formularios($usuario, $token){
    	$consulta=$this->db->query(" exec SP_APP_Formularios ".$usuario.",'".$token."'");
    	$resultado = $consulta->result_array();
        return $resultado;

    }

    function modulos($usuario, $token){
    	$consulta=$this->db->query(" exec SP_APP_FormulariosModulos ".$usuario.",'".$token."'");
    	$resultado = $consulta->result_array();
        return $resultado;

    }

    function preguntas($usuario, $token){
    	$consulta=$this->db->query(" exec SP_APP_FormulariosPreguntas ".$usuario.",'".$token."'");
    	$resultado = $consulta->result_array();
        return $resultado;

    }

    function clusterlocales($usuario, $token){
    	$consulta=$this->db->query(" exec SP_APP_FormulariosListaLocales ".$usuario.",'".$token."'");
    	$resultado = $consulta->result_array();
        return $resultado;

    }

    function listaopciones($usuario, $token){
    	$consulta=$this->db->query(" exec SP_APP_FormulariosListaOpciones ".$usuario.",'".$token."'");
    	$resultado = $consulta->result_array();
        return $resultado;

    }

    function clusterelementos($usuario, $token){
    	$consulta=$this->db->query(" exec SP_APP_FormulariosClusterElementos ".$usuario.",'".$token."'");
    	$resultado = $consulta->result_array();
        return $resultado;

    }


    function agregarRespuestaFormulario($usuario,$token,$id_formulario,$id_asignacion,$id_local,$id_pregunta,$id_elemento,$respuesta,$fechaRegistro,$claveunica,$idPreguntaElemento,$tipopregunta,$latitud,$longitud){
        $consulta=$this->db->query(" exec SP_APP_RespuestasFormularios ".$usuario.",'".$token."',".$id_formulario.",".$id_asignacion.",".$id_local.",".$id_pregunta.",'".$id_elemento."','".$respuesta."','".$fechaRegistro."','".$claveunica."','".$idPreguntaElemento."',".$tipopregunta.",".$latitud.",".$longitud);
        $resultado = $consulta->row_array();
        return $resultado;
    }


}