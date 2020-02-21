<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModuloPermisos extends CI_model {

	function __construct()
    {
        parent::__construct();
    }  


    function validarPermiso($nombrePermiso,$codigo){
	     $query = "EXEC SP_AUD_ValidarPermiso '".$nombrePermiso."',".$codigo;
	     $consulta = $this->db->query($query);
	     $resultado = $consulta ->row_array();
	     return $resultado['existe'];
    }

    function ingresarPermiso($nombrePermiso,$tipoPermiso,$remuneracion,$id_creador,$codigoPermiso,$BD){
    	$query = "EXEC SP_AUD_CrearPermiso '".$nombrePermiso."','".$tipoPermiso."','".$remuneracion."',".$id_creador.",'".$codigoPermiso."'";
        $consulta = $this->db->query($query);
        return $consulta->num_rows();
    }

    function listarPermisos(){
        $consulta = $this->db->query("SP_AUD_ListarPermisos");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarPermisosPorId($idUser,$idJornada,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("EXEC SP_AUD_BuscarPermisoPorID ".$idUser.",".$idJornada);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function EditarPermiso($idPermiso,$NombrePermiso,$TipoPermiso,$Remuneracion,$codigoPermiso){
        $query = "EXEC SP_AUD_EditarPermiso ".$idPermiso.",'".$NombrePermiso."','".$TipoPermiso."','".$Remuneracion."','".$codigoPermiso."'";
        $consulta = $this->db->query($query);
        return $consulta->num_rows();
    }
    
    function CambiarVigenciaPermiso($idPer,$vigencia){
        $query = "EXEC SP_AUD_CambiarActivoPermiso ".$idPer.",".$vigencia;
        $consulta = $this->db->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function buscarVigenciaPermisos($vig){
        $query = "EXEC SP_AUD_ListarPermisosVigencia ".$vig;
        $consulta = $this->db->query($query);
        $resultado = $consulta -> result_array();
        return $resultado;
    }

    function buscarIdPermiso($permiso){
        $query = "EXEC SP_AUD_BuscarIdPermiso '".$permiso."'";
        $consulta = $this->db->query($query);
        $resultado = $consulta -> row_array();
        return $resultado;
    }

    function revocarPermiso($idUser,$idJor,$idHor,$entrada,$salida,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("EXEC SP_AUD_RevocarPermiso ".$idUser.",".$idJor.",".$idHor.",'".$entrada."','".$salida."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarPermisosTotales(){
        $consulta = $this->db->query("SP_AUD_ListarPermisosTotales");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarIdPermiso($idPer){
        $consulta = $this->db->query("EXEC SP_AUD_IDPermiso ".$idPer);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

}