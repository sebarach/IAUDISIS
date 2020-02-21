<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModuloMetas extends CI_model {

	function __construct()
    {
        parent::__construct();
    }

    function ingresarMetas($BD,$local,$elemento,$ponderado,$anio,$mes,$meta){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_IngresarMetas] ".$local.",'".$elemento."',".$ponderado.",".$anio.",".$mes.",".$meta);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function listarFechasMetas($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query(" [SP_AUD_ListarFechasMetas] ");
        $resultado = $consulta->result_array();
        return $resultado;        
    }   

    function listarFechasMetasMovil($BD,$usuario){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query(" [SP_AUD_ListarFechasMetasMovil] ".$usuario);
        $resultado = $consulta->result_array();
        return $resultado;        
    }  

    function buscarClienteB2B($cliente){
        $consulta = $this->db->query("[SP_AUD_BuscarNombreBDB2B] ".$cliente);
        $resultado = $consulta->row();
        return $resultado;
    } 

    function MbuscarLocalesMetas($BD,$mes,$anio){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query(" [SP_AUD_ListarLocalesMetasMes] ".$mes.",".$anio);
        $resultado = $consulta->result_array();
        return $resultado;        
    }

    function MbuscarLocalesMetasMovil($BD,$usuario,$mes,$anio){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query(" [SP_AUD_ListarLocalesMetasMesMovil] ".$usuario.",".$mes.",".$anio);
        $resultado = $consulta->result_array();
        return $resultado;        
    }

    function VentasB2B($BD,$local,$mes,$anio,$elemento){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query(" [SP_Listar_MetasIaudisis] ".$local.",".$mes.",".$anio.",'".$elemento."'");
        $resultado = $consulta->row_array();
        return $resultado;        
    }

    function MetasB2B($BD,$local,$mes,$anio){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query(" [SP_AUD_ListarMetasLocales] ".$local.",".$mes.",".$anio);
        $resultado = $consulta->result_array();
        return $resultado;        
    }
}
