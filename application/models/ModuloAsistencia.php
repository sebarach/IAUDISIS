<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class moduloAsistencia extends CI_model {
	function __construct()
    {
        parent::__construct();
    }

    function MarcarAsisteniaEntrada($BD,$latitud1,$longitud1,$idUser,$comentario,$idInc,$idJor,$DistanciaPdo,$idHor,$idNotificacion,$idLog,$checksumEncriptado){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CrearAsistenciaEntrada '".$latitud1."','".$longitud1."',".$idUser.",'".$comentario."',".$idInc.",".$idJor.",".$DistanciaPdo.",".$idHor.",".$idNotificacion.",".$idLog.",'".$checksumEncriptado."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function MarcarAsisteniaSalida($BD,$latitud1,$longitud1,$idJor,$distancia,$idHor,$id_notificacion,$idLog,$checksumEncriptado){
        // echo $checksumEncriptado;exit();
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CrearAsistenciaSalida '".$latitud1."','".$longitud1."',".$idJor.",".$distancia.",".$idHor.",".$id_notificacion.",".$idLog.",'".$checksumEncriptado."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function MarcarAsisteniaEntradaPeru($BD,$latitud1,$longitud1,$idUser,$comentario,$idInc,$idJor,$DistanciaPdo,$idHor,$idNotificacion,$idLog,$checksumEncriptado,$hora){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CrearAsistenciaEntradaPeru '".$latitud1."','".$longitud1."',".$idUser.",'".$comentario."',".$idInc.",".$idJor.",".$DistanciaPdo.",".$idHor.",".$idNotificacion.",".$idLog.",'".$checksumEncriptado."','".$hora."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function MarcarAsisteniaSalidaPeru($BD,$latitud1,$longitud1,$idJor,$distancia,$idHor,$id_notificacion,$idLog,$checksumEncriptado,$hora){
        // echo $checksumEncriptado;exit();
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CrearAsistenciaSalidaPeru '".$latitud1."','".$longitud1."',".$idJor.",".$distancia.",".$idHor.",".$id_notificacion.",".$idLog.",'".$checksumEncriptado."','".$hora."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }


    function Distanciakm($BD,$latitud1,$longitud1,$latitud2,$longitud2){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_DistanciaEntre2PuntosEnKilometros ".$latitud1.",".$longitud1.",".$latitud2.",".$longitud2);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function CrearIncidencia($BD,$nombreIncidencia,$id_creador){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CrearIncidencia '".$nombreIncidencia."',".$id_creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function CrearMarcaje($BD,$nombreMarcaje,$id_creador){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CrearMarcaje '".$nombreMarcaje."',".$id_creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function EliminarIncidencia($BD,$id,$id_creador){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_EliminarIncidencia ".$id.",".$id_creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function EliminarMarcaje($BD,$id,$id_creador){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_EliminarMarcaje ".$id.",".$id_creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarIncidenciaActivas($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarIncidenciasActivos");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function BuscarAsistencia($BD,$idJor){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarAsistenciaPorIDJor ".$idJor);
        $resultado = $consulta->row_array();
        return $resultado;
    }

     function BuscarInfoUserEmpleador($BD,$idJor,$idHor){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarInfoUserEmpleador ".$idJor.",".$idHor);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarMarcajeActivas($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarMarcageActivos");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function LogMarcaciones($BD,$lat,$long,$idHor,$idUsuario,$idJor,$idPerfil,$error){
        $consulta = $this->db->query("SP_AUD_LogMarcaciones '".$BD."','".$lat."','".$long."',".$idHor.",".$idUsuario.",".$idJor.",".$idPerfil.",'".$error."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ActualizarLog($error,$idLog){ 
        $consulta = $this->db->query("SP_AUD_TryLogActualizar '".$error."',".$idLog);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarLogMarcaciones($BD,$idLog){
        $consulta = $this->db->query("SP_AUD_BuscarLogMarcaciones ".$idLog);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarColaciones($BD,$idUser){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarColacion ".$idUser);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarCol($BD,$idUser,$idJor){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarCol ".$idUser.",".$idJor);
        $resultado = $consulta->row_array();
        return $resultado;
    }
	
    function MarcarEntradaColacion($BD,$idAsistencia,$idUser,$latitud1,$longitud1,$idLog){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CreaColacionEntrada ".$idAsistencia.",".$idUser.",'".$latitud1."','".$longitud1."',".$idLog);
        $resultado = $consulta->row_array();
        return $resultado;
    }

     function MarcarSalidaColacion($BD,$idUser,$latitud1,$longitud1,$idLog){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CreaColacionSalida ".$idUser.",'".$latitud1."','".$longitud1."',".$idLog);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarHorariosDia($BD,$idUser,$dia,$mes,$anio){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarJornadasDiaAbierto ".$idUser.",".$dia.",".$mes.",".$anio);
        $resultado = $consulta->row_array();
        return $resultado;
    }
    
    function SoliActPDV($NombrePDV,$latAct,$lonAct,$idUser,$idcliente,$idHor,$idJor,$latNew,$lonNew,$DistanciaPDO){
        $query = "EXEC SP_AUD_SolicitudActualizacionPDV '".$NombrePDV."','".$latAct."','".$lonAct."',".$idUser.",".$idcliente.",".$idHor.",".$idJor.",'".$latNew."','".$lonNew."',".$DistanciaPDO;
        $consulta = $this->db->query($query);
        return $consulta->num_rows();
    }
    
}

	
?>