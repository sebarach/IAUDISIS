 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class funcion_login extends CI_model {
	function __construct()
    {
        parent::__construct();
    }

    function Login($usuario,$clave){
        $consulta = $this->db->query("SP_AUD_LoginWeb '".$usuario."','".$clave."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    //prueba seba
    function Login2($usuario,$clave){
        $consulta = $this->db->query("SP_AUD_LoginWeb '".$usuario."','".$clave."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function PermisoModulos($usuario){
        $consulta = $this->db->query("SP_AUD_ModulosUsuarios '".$usuario."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function elegirCliente(){
        $consulta = $this->db->query("SP_AUD_ListarInformacionElegirCliente");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    //PRUEBA SEBA
    function elegirCliente2(){
        $consulta = $this->db->query("SP_AUD_ListarInformacionElegirCliente2");
        $resultado = $consulta->result_array();
        return $resultado;
    }

      function BDUsuarioMovil($iduser){
        $consulta = $this->db->query("SP_AUD_BuscarInformacionElegirClientePorIDUsuario ".$iduser);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function recuperarClave($rut){
        $consulta = $this->db->query("SP_AUD_RecuperarClave '".$rut."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

	function enviarparametrorecup($usu,$par){
        $consulta = $this->db->query("SP_AUD_EnviarParametroRecuperar ".$usu.",'".$par."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function validarSolicitudCambioClave($dato){
        $consulta = $this->db->query("SP_AUD_validarSolicitudClave'".$dato."'");
        $resultado = $consulta->row();
        return $resultado;
    }

    function ContadorUsuarios($bd){
        $consulta = $this->db->query("SP_AUD_ContadorUsuarios '".$bd."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarCliente($id){
        $consulta = $this->db->query("SP_AUD_BuscarCliente ".$id."");
        $resultado = $consulta->row_array();
        return $resultado;
    }

}

	
?>