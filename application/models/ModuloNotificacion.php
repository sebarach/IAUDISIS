<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class moduloNotificacion extends CI_model {
	function __construct()
    {
        parent::__construct();
    }

    function NotificacionAtrazoEntrada($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_NotificacionPorAtrasoEntrada");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ActualizarNotificacionAtrazoEntrada($BD,$idHor){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ActualizarNotificacionPorAtrasoEntrada ".$idHor);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarNotificacionSalida($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarNotificacionSalida");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ActualizarNotificacionSalida($BD,$idHor,$idJor,$latitud,$longitud,$Salida){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CierreAutomaticoAsistenciaSalida ".$idHor.",".$idJor.",".$latitud.",".$longitud.",'".$Salida."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }
    
    function ReporteAtraso($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ReporteAtraso");
        $resultado = $consulta->result_array();
        return $resultado;
    }
	
}

	
?>