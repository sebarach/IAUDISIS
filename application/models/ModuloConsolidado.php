<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class moduloConsolidado extends CI_model {
	function __construct()
    {
        parent::__construct();
    }

    function ContarRutasActivas($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ContarRutasActivas");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ContarMarcaUsuarios($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CantidadUsuariosMarca");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ContarRutasEjecucion($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ContarRutasEjecucion");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ContarUsuariosRutas($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_UsuariosEnRuta");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function PromedioTiempoRutas($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_PromedioTiempoRuta");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function LocalesPorUsuarios($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_LocalesPorUsuario");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function CargarTablaUsuarios($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_TablaConsolidado");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function CargarTablaUsuariosTop10($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_TablaConsolidadoTop10");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function TablaConReq($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarTablaRutasReq");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function TablaConReqTop10($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarTablaRutasReqTop10");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function TablaUsuarioRequerimiento($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_TablaUsuarioRequerimiento");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function TablaUsuarioRequerimientoTop10($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_TablaUsuarioRequerimientoTop10");
        $resultado = $consulta->result_array();
        return $resultado;
    }
}