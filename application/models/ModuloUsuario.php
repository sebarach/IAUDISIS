<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModuloUsuario extends CI_model {

	function __construct()
    {
        parent::__construct();
    }

    function listarPerfilesActivos(){
    	$consulta = $this->db->query("SP_AUD_ListarPerfilesActivos");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarUsuarios($cliente){
    	$consulta = $this->db->query("SP_AUD_ListarUsuariosPorCliente ".$cliente);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarUsuariosEstado($cliente,$estado){
        $consulta = $this->db->query("[SP_AUD_ListarUsuariosPorEstado] ".$cliente.','.$estado);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarUsuariosActivos($cliente){
        $consulta = $this->db->query("SP_AUD_ListarUsuariosPorClienteActivos ".$cliente);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarGrupoUsuarios($cliente){
        $consulta = $this->db->query("SP_AUD_ListarGrupoUsuariosPorCliente ".$cliente);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarGrupoUsuariosActivos($cliente){
        $consulta = $this->db->query("SP_AUD_ListarGrupoUsuariosPorClienteActivos ".$cliente);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarUsuariosActivosGrupoUsuarios($grupo){
        $consulta = $this->db->query("SP_AUD_ListarUsuariosActivosEnGrupo ".$grupo);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarGruposActivosGrupoUsuarios($usuario){
        $consulta = $this->db->query("SP_AUD_ListarGruposActivosEnGrupo ".$usuario);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function buscarUsuarioID($id){
    	$consulta = $this->db->query("SP_AUD_BuscarUsuarioPorID ".$id);
        $resultado = $consulta->row_array();
        return $resultado;
    }  

    function buscarGrupoUsuarioID($id){
        $consulta = $this->db->query("SP_AUD_BuscarGrupoUsuarioPorID ".$id);
        $resultado = $consulta->row_array();
        return $resultado;
    }  

    function ingresarUsuario($rut,$nombre,$paterno,$materno,$genero,$telefono,$email,$direccion,$cargo,$creador,$cliente,$perfil,$usuario,$clave){
    	$consulta = $this->db->query("SP_AUD_CrearUsuario '".$rut."','".$nombre."','".$paterno."','".$materno."',".$genero.",".$telefono.",'".$email."','".$direccion."','".$cargo."',".$creador.",".$cliente.",".$perfil.",'".$usuario."','".$clave."'");
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function ingresarGrupoU($grupoU,$cliente,$creador){
        $consulta = $this->db->query("SP_AUD_CrearGrupoUsuario '".$grupoU."',".$cliente.",".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ingresarITGrupoU($u,$grupoU,$cliente,$creador){
        $consulta = $this->db->query("SP_AUD_CrearITGrupoUsuario ".$u.",'".$grupoU."',".$cliente.",".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ingresarITUsuarioG($u,$grupoU,$cliente,$creador){
        $consulta = $this->db->query("SP_AUD_CrearITUsuarioGrupo '".$u."',".$grupoU.",".$cliente.",".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function editarUsuario($nombre,$paterno,$materno,$genero,$telefono,$email,$direccion,$cargo,$creador,$cliente,$perfil,$esEditar){
    	$consulta = $this->db->query("SP_AUD_EditarUsuario '".$nombre."','".$paterno."','".$materno."',".$genero.",".$telefono.",'".$email."','".$direccion."','".$cargo."',".$creador.",".$cliente.",".$perfil.",".$esEditar);
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function editarGrupoU($grupoU,$creador,$idGrupoU){
        $consulta = $this->db->query("SP_AUD_EditarGrupoUsuario '".$grupoU."',".$creador.",".$idGrupoU);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function editarITGrupoU($u,$idGrupoU,$cliente,$creador){
        $consulta = $this->db->query("SP_AUD_EditarITGrupoUsuario ".$u.",".$idGrupoU.",".$cliente.",".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function desactivarGrupoU($grupo){
        $consulta = $this->db->query("SP_AUD_DesactivarITGrupoUsuarioPorGrupo ".$grupo);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function desactivarUsuarioG($usuario){
        $consulta = $this->db->query("SP_AUD_DesactivarITGrupoUsuarioPorUsuario ".$usuario);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function cambiarEstadoUsuario($usuario,$vigencia,$creador){
        $consulta = $this->db->query("SP_AUD_cambiarActivoUsuario ".$usuario.",".$vigencia.",".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function cambiarEstadoGrupoUsuario($usuario,$vigencia,$creador){
        $consulta = $this->db->query("SP_AUD_cambiarActivoGrupoUsuario ".$usuario.",".$vigencia.",".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function  validarRutUsuario($rut){
    	$consulta = $this->db->query("SP_AUD_ValidarRutUsuarioActivo '".$rut."'" );
        $resultado = $consulta->row_array();
        return $resultado;
    }  

    function  validarUserUsuario($usuario){
    	$consulta = $this->db->query("SP_AUD_ValidarUserUsuarioActivo '".$usuario."'" );
        $resultado = $consulta->row_array();
        return $resultado;
    }   

	function  validarRutUsuarioCliente($rut,$idcliente){
    	$consulta = $this->db->query("SP_AUD_ValidarRutUsuarioActivoCliente '".$rut."',".$idcliente );
        $resultado = $consulta->row_array();
        return $resultado;
    }  

    function BuscarIdPerfil($perfil){
        $consulta = $this->db->query("SP_AUD_BuscarIdPerfil '".$perfil."'");
        $resultado = $consulta->row();
        return $resultado;
    }

    function buscarIdUser($u){
        $consulta = $this->db->query("SP_AUD_BuscarIdUsuario '".$u."'");
        $resultado = $consulta->row();
        return $resultado;
    }

    function validarITGrupoU($grupoU){
        $consulta = $this->db->query("[SP_AUD_BuscarIdGrupoUsuario] '".$grupoU."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarUsuariosMoviles($BD,$cli){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarUsuariosMovilesMensajeria ".$cli);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ingresarMensaje($u,$mensaje,$creador,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_IngresarMensaje '".$u."','".$mensaje."',".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarIdPerfilMasivo($perfil){
        $consulta = $this->db->query("SP_AUD_BuscarIdPerfil '".$perfil."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function listarUsuariosCoordinador($cliente){
        $consulta = $this->db->query("SP_AUD_ListarUsuariosCoordinadorPorCliente ".$cliente);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarModuloUsuario(){
        $consulta = $this->db->query("SP_AUD_ListarModulos");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function asignarModulo($id_cliente,$id_usuario,$modulo){
        $consulta = $this->db->query("SP_AUD_AsignarModulo ".$id_cliente.",".$id_usuario.",".$modulo);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function DesactivarModuloAsignado($id_usuario){
        $consulta = $this->db->query("SP_AUD_DesactivarModuloAsignado ".$id_usuario);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function cargarModuloAsignado($id_usuario){
        $consulta = $this->db->query("SP_AUD_ListarModulosAsignados ".$id_usuario);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarBotonAsignado($id_usuario,$id_modulo,$id_cliente){
        $consulta = $this->db->query("SP_AUD_BuscarBotonAsignado ".$id_usuario.",".$id_modulo.",".$id_cliente);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function cambiarEstadoHorarioUsuario($BD,$usuario,$permiso){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CambiarEstadoHorarioUsuario ".$usuario.",".$permiso);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarUsuarioHorarioFechaActual($BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_ListarUsuarioHorarioFechaActual");
        $resultado = $consulta->result_array();
        return $resultado;
    }
	function ingresarTokenUsuario($rut,$token){
		$consulta = $this->db->query("SP_AUD_CrearTokenUsuario '".$rut."', '".$token."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }
}
