<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class moduloTarea extends CI_model {
	function __construct()
    {
        parent::__construct();
    }

    function cargarTipoTareas($BD){
        $consulta = $this->db->query("SP_AUD_ListarTipoTareas");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarFormularios($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarFormulariosActivo");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarUsuarios($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarUsuariosMoviles '".$BD."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarLocales($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarLocales");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ingresarTarea($BD,$tipo,$id_creador,$nombre){
    	$this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_CrearTarea ".$tipo.",".$id_creador.",'".$nombre."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ingresarTareaFormulario($BD,$idT,$formulario){
    	$this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_CrearTareaFormulario ".$idT.",".$formulario;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function AsignarTarea($usuario,$idTarea,$fecha_inicio,$local,$fecha_fin,$BD){
    	$this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_AsignarTareas ".$usuario.",".$idTarea.",'".$fecha_inicio."',".$local.",'".$fecha_fin."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

     function buscarUsuariosporGrupoUsuarios($ug,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarUsuariosPorGrupodeUsuarios ".$ug);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ValidarTipoTarea($tipo_tarea,$BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ValidarTipoTarea '".$tipo_tarea."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function AgregarTipoTarea($tipo_tarea,$creador,$BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_AgregarTipoTarea '".$tipo_tarea."',".$creador;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarTareaPorUsuario($BD,$idUser,$local){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarTareasPorUsuario ".$idUser.",".$local);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarTareaFormularioHorarioPorUsuario($BD,$idUser,$local){        
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_ListarTareasHorarioPorUsuario] ".$idUser.",".$local);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarLocalesPorUsuario($BD,$idUser){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_BuscarLocalPorUsuario] ".$idUser);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarLocalesHorariosPorUsuario($BD,$idUser){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_BuscarLocalEspecialPorUsuario] ".$idUser);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarFormularioPorTarea($BD,$id_tarea){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarFormPorTarea ".$id_tarea);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarFormularioEspecialPorTarea($BD,$id_tarea){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_ListarFormEspPorTarea] ".$id_tarea);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarFormularioPorTareaActivas($BD,$id_tarea,$asignacion,$local,$usuario){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_ListarFormPorTareaActivas] ".$id_tarea.",".$asignacion.",".$local.",".$usuario);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarFormularioEspPorTareaActivas($BD,$id_tarea){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_ListarFormEspPorTareaActivas] ".$id_tarea);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarTareaAsignacion($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarTareasAsignacion");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function buscarIdUsuario($user){
        $consulta = $this->db->query("SP_AUD_BuscarIdUsuario '".$user."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarAsignacionUsuarioLocal($BD,$id_tarea){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarAsignacionUsuarioLocal ".$id_tarea);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarUsuarios($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarUsuariosMoviles '".$BD."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarTareasID($BD,$id){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarTareasID ".$id);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function CambiarVigenciaTarea($idtarea,$vigencia,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_CambiarActivoTarea ".$idtarea.",".$vigencia;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function listarTareaAsignacionNoAsignada($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarTareasNoAsignadas");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function desactivarTarea($id_tarea,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_DesactivarTarea ".$id_tarea;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function EditarTarea($usuario,$idTarea,$fecha_inicio,$local,$fecha_fin,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_EditarTareas ".$usuario.",".$idTarea.",'".$fecha_inicio."',".$local.",'".$fecha_fin."'");
        $resultado = $consulta->row();
        return $resultado;
    }

    function EditarFormularioAsignado($BD,$id_tarea,$formulario,$nombre_tarea){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_EditarFormulariosAsignados ".$id_tarea.",".$formulario.",'".$nombre_tarea."'");
        $resultado = $consulta->row();
        return $resultado;
    }

    function DesactivarFormularioAsignado($BD,$id_tarea){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_DesactivarFormularioAsignado ".$id_tarea;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function listarGrupoUsuariosActivos($cliente){
        $consulta = $this->db->query("SP_AUD_ListarGrupoUsuariosPorClienteActivos ".$cliente);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarTrivias($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarTrivias");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ingresarTareaQuiz($BD,$idT,$quiz){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_CrearTareaQuiz ".$idT.",".$quiz;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarTipoTarea($tarea,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarTipoTarea ".$tarea);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarTriviaPorTareaActivas($BD,$id_tarea,$asignacion,$local,$usuario){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_ListarTriviaPorTareaActivas] ".$id_tarea.",".$asignacion.",".$local.",".$usuario);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarQuizPorTarea($BD,$id_tarea){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarQuizPorTarea ".$id_tarea);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarTrivias($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarTriviasActivo");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function DesactivarTriviaAsignada($BD,$id_tarea){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_DesactivarTriviaAsignada ".$id_tarea;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function EditarTriviaAsignada($BD,$id_tarea,$trivia,$nombre_tarea){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_EditarTriviasAsignados ".$id_tarea.",".$trivia.",'".$nombre_tarea."'");
        $resultado = $consulta->row();
        return $resultado;
    }

    function listarFormulariosEspecialesActivos($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC [SP_AUD_ListarFormulariosEspecialesActivos]";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function asignarTareaGrupoLocal($BD,$tarea,$glocal){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_AsignarTareaGrupoLocal ".$tarea.",".$glocal);
        $resultado = $consulta->result_array();
        return $resultado;
    }
 }