<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class moduloUsuarioApp extends CI_model {
	function __construct()
    {
        parent::__construct();
    }

    function InfoUsuario($usuario){
        $query = "EXEC SP_AUD_InfoPorUsuario ".$usuario;
        $consulta = $this->db->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function ListarEmpresa(){
      $query = "EXEC SP_AUD_ListarEmpresa";
      $consulta = $this->db->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function ListarLibroMarcacion($usuario,$mes,$anio,$BD){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_ListarLibroMarcacion ".$usuario.",'".$mes."','".$anio."'";
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function EditarDireccionUsuario($idUser,$direccion){
      $query = "EXEC SP_AUD_EditarDireccionUsuario ".$idUser.",'".$direccion."'";
      $consulta = $this->db->query($query);
      return $consulta->num_rows();
    }

    function EditarEmailUsuario($idUser,$email){
      $query = "EXEC SP_AUD_EditarEmailUsuario ".$idUser.",'".$email."'";
      $consulta = $this->db->query($query);
      return $consulta->num_rows();
    }

    function EditarFonoUsuario($idUser,$fono){
      $query = "EXEC SP_AUD_EditarFonoUsuario ".$idUser.",".$fono;
      $consulta = $this->db->query($query);
      return $consulta->num_rows();
    }

    function EditarFotoUsuario($idUser,$foto){
      $query = "EXEC SP_AUD_EditarFotoUsuario ".$idUser.",'".$foto."'";
      $consulta = $this->db->query($query);
      return $consulta->num_rows();
    }

    function EditarPassUsuario($idUser,$pass){
      $query = "EXEC SP_AUD_EditarPassUsuario ".$idUser.",'".$pass."'";
      $consulta = $this->db->query($query);
      return $consulta->num_rows();
    }

    function ingresarContador($BD,$id_usuario,$id_archivo,$id_carpeta,$contador){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_IngresarContadordeDescarga ".$id_usuario.",".$id_archivo.",".$id_carpeta.",".$contador;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->num_rows();
      return $resultado;
    }

    function ListarLocalesAsignados($usuario,$BD){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_BuscarLocalAsignado ".$usuario;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function ListarDiasAsignados($usuario,$BD){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_BuscarDiaAsignadoHorarioHistorico ".$usuario;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function ListarLibroMarcacionFiltrado($local,$idUser,$fecha,$mes,$anio,$BD){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_FiltrarHorarioHistoricoUser ".$local.",".$idUser.",'".$fecha."','".$mes."','".$anio."'";
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function buscarQuizID($BD,$idQuiz){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_BuscarQuizID ".$idQuiz;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function IngresarRequerimiento($BD,$mensaje,$latitud,$longitud,$idUser){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_IngresarRequerimiento '".$mensaje."',".$latitud.",".$latitud.",".$idUser;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->num_rows();
      return $resultado;
    }

    function buscarQuizIDEstatico($BD,$idQuiz){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_BuscarQuizIDEstatico ".$idQuiz;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function buscarQuizIDEstaticoModulo($BD,$idQuiz){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_BuscarQuizIDEstaticoEditarModulo ".$idQuiz;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function buscarDatosQuiz($idQuiz,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_BuscarDatosQuiz ".$idQuiz;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function GuardarFotoConfirmacionTrivia($id_trivia,$fotoGeneral,$id_user,$BD,$id_local,$id_asignacion){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_GuardarFotoConfirmacionTrivia ".$id_trivia.",'".$fotoGeneral."',".$id_user.",".$id_local.",".$id_asignacion;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->num_rows();
        return $resultado;
    }

    function QuiebresProductosUsuario($usuario,$condicion,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_QuiebreProductoUsuarios] ".$usuario.",'".$condicion."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function BuscarPaisCliente($Cliente){
        $query = "EXEC [SP_AUD_BuscarPaisPorCliente] ".$Cliente;
        $consulta = $this->db->query($query);
        $resultado = $consulta ->row();
        return $resultado;
    }
}

	
?>