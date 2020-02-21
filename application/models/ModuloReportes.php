<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModuloReportes extends CI_model {
	function __construct()
    {
        parent::__construct();
    }

    function LibroAsistenciaMes($BD,$mes,$anio,$mesAnterior,$anioAnterior,$nombre,$apellidoP,$rut,$cadena,$local,$usuarios){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarLibroAsistenciaMes '".$mes."','".$anio."','".$mesAnterior."','".$anioAnterior."','".$nombre."','".$apellidoP."','".$rut."',".$cadena.",".$local.",'".$usuarios."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function LibroAsistenciaDF($BD,$mes,$anio,$mesAnterior,$anioAnterior,$nombre,$apellidoP,$rut,$cadena,$local,$usuarios){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarLibroAsistenciaDomigoFeriados '".$mes."','".$anio."','".$mesAnterior."','".$anioAnterior."','".$nombre."','".$apellidoP."','".$rut."',".$cadena.",".$local.",'".$usuarios."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function LibroModificacionHorarios($BD,$mes,$anio,$mesAnterior,$anioAnterior,$nombre,$apellidoP,$rut,$cadena,$local,$usuarios){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarLibroModificacionesHorarios '".$mes."','".$anio."','".$mesAnterior."','".$anioAnterior."','".$nombre."','".$apellidoP."','".$rut."',".$cadena.",".$local.",'".$usuarios."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function LibroAsistenciaMarcaPromedio($BD,$mes,$anio,$nombre,$apellidoP,$rut,$cadena,$local,$usuarios){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarLibroAsistenciaMarcacionesPromedio '".$mes."','".$anio."','".$nombre."','".$apellidoP."','".$rut."',".$cadena.",".$local.",'".$usuarios."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function FechasLibroAsistenciaMes($BD,$usuario){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarFechasLibroAsistenciaMes ".$usuario);
        $resultado = $consulta->result_array();
        return $resultado;
    }
	
}

	
?>