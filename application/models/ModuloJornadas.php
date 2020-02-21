<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModuloJornadas extends CI_model {

	function __construct()
    {
        parent::__construct();
    }

 
    function ingresarJornada($Rut,$PDV,$id_creador,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_CrearJornadaUsuariosPDV '".$Rut."','".$PDV."',".$id_creador;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function ingresarHorario($idJ,$dia,$FechaInicio,$Entradatime,$Salidatime,$id_creador,$idPermiso,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_CrearHorarioIDJornada ".$idJ.",'".$dia."','".$FechaInicio."','".$Entradatime."','".$Salidatime."',".$id_creador.",".$idPermiso."";
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function ingresarFeriado($NombreFeriado,$FechaFeriado){
        $query = "EXEC SP_AUD_CrearFeriado '".$NombreFeriado."','".$FechaFeriado."'";
        $consulta = $this->db->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function editarFeriado($NombreFeriado,$FechaFeriado,$idFeriado){
        $consulta = $this->db->query("SP_AUD_EditarFeriado '".$NombreFeriado."','".$FechaFeriado."',".$idFeriado);
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function  buscarFeriadoID($id){
        $consulta = $this->db->query("SP_AUD_BuscarFeriadoPorID ".$id);
        $resultado = $consulta->row_array();
        return $resultado;
    }  

    function cambiarEstadoFeriado($Feriado,$vigencia){
        $consulta = $this->db->query("SP_AUD_CambiarActivoFeriado ".$Feriado.",".$vigencia);
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function ValidarLocal($BD,$PDV){
      $this->db2 = $this->load->database($BD, TRUE);
      $query = "EXEC SP_AUD_ValidarPDVLocal '".$PDV."'";
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->row_array();
      return $resultado['exisite'];
    }

    function ValidarLocalEditar($BD,$PDV,$id){
      $this->db2 = $this->load->database($BD, TRUE);
      $query = "EXEC SP_AUD_ValidarPDVLocalEditar '".$PDV."',".$id;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->row_array();
      return $resultado['exisite'];
    }

     function ListarHorario($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHorario");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarHorarioPaginador($BD,$opcion,$id_usuario,$id_local,$mes){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHorarioPaginador ".$opcion.",".$id_usuario.",".$id_local.",'".$mes."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarJornada($BD,$idUser){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarIDjorPorUser ".$idUser);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarHorarioXJornada($BD,$idjor){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarHorarioPorIDjor ".$idjor);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarFeriados(){
        $consulta = $this->db->query("SP_AUD_ListarFeriados");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function UpdateHorario($BD,$IDhor,$idUser,$dia,$mes,$anio,$diaE,$diaS,$id_creador,$idjor){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_EditarHorario '".$IDhor."',".$idUser.",'".$dia."','".$mes."','".$anio."','".$diaE."','".$diaS."',".$id_creador.",".$idjor);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarHorario($BD,$idUser,$dia,$mes,$anio){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarHorarioPorIDDiaMesAnio ".$idUser.",".$dia.",".$mes.",".$anio);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarInfoHorario($BD,$idUser,$dia,$mes,$anio){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarHorarioPorIDDiaMesAnio ".$idUser.",".$dia.",".$mes.",".$anio);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function BuscarHorarioIDjor($BD,$idJor,$idUser,$dia,$mes,$anio){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarHorarioPorIDJorDiaMesAnio ".$idJor.",".$idUser.",".$dia.",".$mes.",".$anio);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function CantidaIDjor($BD,$idUser,$dia,$mes,$anio){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ContarIdJorPorIDDiaMesAnio ".$idUser.",".$dia.",".$mes.",".$anio);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarJornadas($BD,$idUser,$dia,$mes,$anio){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarIdJorPorIDDiaMesAnio ".$idUser.",".$dia.",".$mes.",".$anio);
        $resultado = $consulta->result_array();
        return $resultado;
    }


    function UpdateJornada($BD,$idjor,$idLocal,$idCadena,$id_creador){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_EditarJornada ".$idjor.",".$idLocal.",".$idCadena.",".$id_creador);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cambiarEstadoJornada($idjor,$vigencia,$creador,$BD){
      $this->db2 = $this->load->database($BD, TRUE); 
      $consulta = $this->db2->query("SP_AUD_cambiarActivoJornada ".$idjor.",".$vigencia.",".$creador);
      $resultado = $consulta->row_array();
      return $resultado;
    }

    function ValidarRut($RutEmpresa){
      $query = "EXEC SP_AUD_ValidarRutEmpresa '".$RutEmpresa."'";
      $consulta = $this->db->query($query);
      $resultado = $consulta ->row_array();
      return $resultado['exisite'];
    }

    function AsignarPermiso($idAsigUser,$idPermiso,$fechaDesde){
        $consulta = $this->db->query("SP_AUD_AsignarPermisosUser ".$idAsigUser.",".$idPermiso.",".$fechaDesde);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarFechas($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarFechasAsignadas");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarMesesAsignados($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarMesesAsignados");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarUsuariosAsiganadosHorario($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarUsuariosAsignadosHorario");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function AsignarPermisoGrupo($idGrupo,$idPermiso,$fechaDesde,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_AsignarPermisosUserGrupo ".$idGrupo.",".$idPermiso.",".$fechaDesde);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function AsignarPermisoRango($idUser,$idPermiso,$fechaDesde,$fechaHasta,$mes,$hora_inicio,$hora_fin,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_AsignarPermisosUserPorRangoFecha ".$idUser.",".$idPermiso.",".$fechaDesde.",".$fechaHasta.",".$mes.",'".$hora_inicio."','".$hora_fin."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarAnio($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarAnioHorario");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarUsuario($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarUsuariosMoviles '".$BD."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarMesHorario($BD,$anio){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarMesHorario '".$anio."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarHorarioFecha($BD,$mes,$anio,$opcion){
        // echo ($BD,$mes,$anio,$opcion);exit();
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHorarioPorFecha ".$mes.",".$anio.",".$opcion);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarHorarioUsuario($BD,$id_usuario,$opcion){
        // echo ($BD,$mes,$anio,$opcion);exit();
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHorarioPorUsuario ".$id_usuario.",".$opcion);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarHorarioLocal($BD,$id_local,$opcion){
        // echo ($BD,$mes,$anio,$opcion);exit();
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHorarioPorLocal ".$id_local.",".$opcion);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cantidadJornadas($BD,$thismonth){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_CantidadJornadas ".$thismonth);
        $resultado = $consulta->num_rows();
        return $resultado;
    }

    function CantidadJ($BD,$mes){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_CantidadJornadasCount ".$mes);
        $resultado = $consulta->num_rows();
        return $resultado;
    }

    function CapturarMensaje($BD,$idUser){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_CapturarMensaje ".$idUser);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function MarcarLeido($BD,$idmsj){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_MarcarLeido ".$idmsj);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function CapturarMensajeNuevo($BD,$idUser){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_CantidadMsjNuevos ".$idUser);
        $resultado = $consulta->result_array();
        return $resultado;
    }

     function ListarHorariohistorico($BD,$opcion){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHorarioPorMesAnio '".$opcion."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }


    function ListarHorariohistoricoCode($BD,$opcion){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHorarioPorMesAnioCode '".$opcion."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function buscarFechaFuturo($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarFechaFuturo ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarHorarioFechaFuturo($BD,$id_fecha){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHorarioPorMesAnio '".$id_fecha."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarHorarioFiltrado($BD,$usuario,$local,$fecha){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHorarioFiltrador ".$usuario.",".$local.",'".$fecha."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarHorarioEditar($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHorarioActualizar");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function DesactivarJornada($jor,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_DesactivarJornada ".$jor);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    // function UpdateHorarioMasivo($rut,$entrada,$salida,$idjor,$local,$fecha,$idper,$BD){
    //     $this->db2 = $this->load->database($BD, TRUE); 
    //     $consulta = $this->db2->query("SP_AUD_EditarHorarioMasivo '".$rut."','".$entrada."','".$salida."',".$idjor.",'".$local."','".$fecha."',".$idper);
    //     $resultado = $consulta->result_array();
    //     return $resultado;
    // }

    function UpdateHorarioMasivo($id_jor,$entrada,$salida,$idper,$dia,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_EditarHorarioMasivo ".$id_jor.",'".$entrada."','".$salida."',".$idper.",".$dia);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function BuscarHorarioFecha($mes,$anio,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarHorarioPorFecha ".$mes.",".$anio);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function listarLocales($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarLocales");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ingresarJornadaUnitaria($User,$PDV,$id_creador,$BD){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_CrearJornadaUsuariosPDVUnitaria ".$User.",".$PDV.",".$id_creador;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function AsignarPermisoGrupoUser($u,$idPermiso,$hora_inicio,$hora_fin,$mes,$fechaDesde,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_AsignarPermisoGrupoUser ".$u.",".$idPermiso.",'".$hora_inicio."','".$hora_fin."',".$mes.",".$fechaDesde);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function AsignarPermisoGrupoRango($u,$permiso,$desde,$hasta,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_AsignarPermisoRango ".$u.",".$permiso.",".$desde.",".$hasta);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function AsignarPermisoGrupoRangoHora($u,$permiso,$desde,$hasta,$fecha_inicio,$fecha_fin,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_AsignarPermisoRangoHora ".$u.",".$permiso.",".$desde.",".$hasta.",'".$fecha_inicio."','".$fecha_fin."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarHorarioEditarFiltrado($us,$diaInicio,$diaFin,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHorarioActualizarFiltrado ".$us.",".$diaInicio.",".$diaFin);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarHoraEntradaSalidaPorJornada($jornada,$diaInicio,$diaFin,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarHoraEntradaSalidaPorJornada ".$jornada.",".$diaInicio.",".$diaFin);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function guardarKeyActHorario($key,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_GuardarKeyActHorario '".$key."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarKeyHorario($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_BuscarKeyActHorario");
        $resultado = $consulta->row_array();
        return $resultado;
    }
}
