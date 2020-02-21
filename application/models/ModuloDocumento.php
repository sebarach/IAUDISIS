<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class moduloDocumento extends CI_model {
	function __construct()
    {
        parent::__construct();
    }

    function insertarEnlaceExterno($BD,$creador,$nombreCarpeta,$file,$enlace,$nombreDoc,$descripcion,$tipo,$formato){
    	$this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_IngresarDocumentos ".$creador.",'".$nombreCarpeta."','".$file."','".$enlace."','".$nombreDoc."','".$descripcion."','".$tipo."',".$formato;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function cargarCarpetas($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarCarpetas");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function crearCarpeta($BD,$nombreCarpeta,$creador){
    	$this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_CrearCarpeta '".$nombreCarpeta."',".$creador;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function validarCarpeta($BD,$carpeta){
    	// echo $carpeta;exit();
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ValidarCarpeta '".$carpeta."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function buscarCarpetaPorID($BD,$carpeta){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarCarpetaPorID ".$carpeta);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function cargarArchivos($BD,$id_carpeta){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CargarArchivos ".$id_carpeta);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function eliminarDocumento($BD,$id_archivo){
    	$this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_DesactivarArchivo ".$id_archivo;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function asignarCarpetas($u,$id_carpetas,$creador,$BD){
    	$this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_AsignarCarpetas ".$u.",".$id_carpetas.",".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function cargarCarpetasporUsuarioAsignado($id_user,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_AsignarCarpetasporUsuarios ".$id_user);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function buscarUsuariosporGrupoUsuarios($ug,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarUsuariosPorGrupodeUsuarios ".$ug);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function validarAsignacionCarpeta($user,$carpeta,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarCarpetasAsignadas ".$user.",".$carpeta);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarDescargaCarpeta($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CantidadDescargaCarpeta");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarDescargaUsuario($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CantidadDescargaUsuario");
        $resultado = $consulta->result_array();
        return $resultado;
    }
}