 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class app_Asistencia extends CI_model {
	function __construct()
    {
        parent::__construct();
    }

    function incidencias($id_usuario,$token){
    	$consulta=$this->db->query(" exec SP_APP_Incidencias ".$id_usuario.",'".$token."'");
    	$resultado = $consulta->result_array();
        return $resultado;
    }

    function horarios($id_usuario,$token){
    	$consulta=$this->db->query(" exec SP_APP_Horarios ".$id_usuario.",'".$token."'");
    	$resultado = $consulta->result_array();
        return $resultado;

    }

    function MarcarAsistenciaEntrada($id_usuario,$token,$id_horario,$fecha_entrada,$latitud,$longitud,$distanciapdo,$checksum,$FK_Jornada_ID_Jornada){
        $consulta=$this->db->query(" exec SP_APP_MarcarAsistEntrada ".$id_usuario.",'".$token."',".$id_horario.",'".$fecha_entrada."','".$latitud."','".$longitud."',".$distanciapdo.",'".$checksum."',".$FK_Jornada_ID_Jornada);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function MarcarAsistenciaEntradaColacion($id_usuario,$token,$id_horario,$fecha_entrada,$latitud,$longitud,$FK_Jornada_ID_Jornada){
        $consulta=$this->db->query(" exec SP_APP_MarcarAsistEntradaColacion ".$id_usuario.",'".$token."',".$id_horario.",'".$fecha_entrada."','".$latitud."','".$longitud."',".$FK_Jornada_ID_Jornada);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function MarcarAsistenciaSalidaColacion($id_usuario,$token,$id_horario,$fecha_salida,$latitud,$longitud,$FK_Jornada_ID_Jornada){
        $consulta=$this->db->query(" exec SP_APP_MarcarAsistSalidaColacion ".$id_usuario.",'".$token."',".$id_horario.",'".$fecha_salida."','".$latitud."','".$longitud."',".$FK_Jornada_ID_Jornada);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function MarcarAsistenciaSalida($id_usuario,$token,$id_horario,$fecha_salida,$latitud,$longitud,$distanciapdo,$checksum,$FK_Jornada_ID_Jornada){
        $consulta=$this->db->query(" exec SP_APP_MarcarAsistSalida ".$id_usuario.",'".$token."',".$id_horario.",'".$fecha_salida."','".$latitud."','".$longitud."',".$distanciapdo.",'".$checksum."',".$FK_Jornada_ID_Jornada);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function error($id_usuario,$token,$id_horario,$latitud,$longitud,$jornada){
        $consulta=$this->db->query(" exec SP_APP_LogError ".$id_usuario.",'".$token."',".$id_horario.",'".$latitud."','".$longitud."',".$jornada);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function MarcarIncidencia($id_usuario,$token,$id_incidencia,$id_horario,$jornada,$comentario,$fecha_marcada){
        $consulta=$this->db->query(" exec SP_APP_MarcarIncidencia ".$id_usuario.",'".$token."',".$id_incidencia.",".$id_horario.",".$jornada.",'".$comentario."','".$fecha_marcada."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }


}
