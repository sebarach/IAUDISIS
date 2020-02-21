<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class moduloFormularioApp extends CI_model {
	function __construct()
    {
        parent::__construct();
    }

    function ListadoFormulariosActivos($BD,$usuario){
      	$this->db2 = $this->load->database($BD, TRUE); 
      	$query = "EXEC SP_AUD_ListarFormulariosUsuarios ".$usuario;
      	$consulta = $this->db2->query($query);
      	$resultado = $consulta ->result_array();
      	return $resultado;
    }

    function ListarFormularioUsuario($BD,$usuario){
      	$this->db2 = $this->load->database($BD, TRUE); 
      	$query = "EXEC [SP_AUD_ListarFormularioPorFormulario] ".$usuario;
      	$consulta = $this->db2->query($query);
      	$resultado = $consulta ->row_array();
      	return $resultado;
    }

    function ListarFormularioModuloUsuario($BD,$formulario){
      	$this->db2 = $this->load->database($BD, TRUE); 
      	$query = "EXEC [SP_AUD_ListarFormularioModuloPorFormulario] ".$formulario;
      	$consulta = $this->db2->query($query);
      	$resultado = $consulta ->result_array();
      	return $resultado;
    }

    function ListarFormularioPreguntaUsuario($BD,$modulo){
      	$this->db2 = $this->load->database($BD, TRUE); 
      	$query = "EXEC [SP_AUD_ListarFormularioPreguntaPorModulo] ".$modulo;
      	$consulta = $this->db2->query($query);
      	$resultado = $consulta ->result_array();
      	return $resultado;
    }

    function ListarFormularioClusterUsuario($BD,$pregunta){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarFormularioClusterPorFormulario] ".$pregunta;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarFormularioOpcionUsuario($BD,$pregunta){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarFormularioOpcionesPorFormulario] ".$pregunta;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarFormularioDependenciasPorPadre($BD,$padre){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarDependeciasPorPreguntaPadre] ".$padre;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ValidaFormularioDependenciasPorHijo($BD,$hijo){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ValidarDependeciasPorPreguntaHijo] ".$hijo;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row();
        return $resultado;
    }

     function FormularioDependenciasPorHijo($BD,$hijo){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_DependeciasPorPreguntaHijo] ".$hijo;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }


    function UpdateClaveFormularioRespuesta($BD,$latitud,$longitud,$clave,$id){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_UpdateClaveFormularioPrueba] '".$clave."', '".$latitud."','".$longitud."', ".$id;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }


    function EliminarFormularioRespuestaFoto($BD,$id){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_EliminarFormularioRespuestaFoto]  ".$id;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }
    
    function IngresarFormularioRespuesta($BD,$formulario,$usuario,$pregunta,$asignacion,$local,$pregElemento,$elemento,$respuesta,$latitud,$longitud,$clave){
      $this->db2 = $this->load->database($BD, TRUE);
      $query = "EXEC [SP_AUD_IngresarFormularioRespuesta] ".$formulario.",".$usuario.",".$pregunta.",".$asignacion.",".$local.",".$pregElemento.",".$elemento.",'".$respuesta."','".$latitud."','".$longitud."','".$clave."'";
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->row();
      return $resultado;
    }

    function IngresarFormulariosCompletados($BD,$asignacion,$formulario,$usuario,$local){
      $this->db2 = $this->load->database($BD, TRUE);
      $query = "EXEC [SP_AUD_IngresarFormulariosCompletados] ".$asignacion.",".$formulario.",".$usuario.",".$local;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->row();
      return $resultado;
    }

    function ListarFormularioPreguntaClousterElementos($BD,$idPregunta,$local){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarFormularioPreguntaClousterElementos] ".$idPregunta.",".$local;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }


    function ListarClousterLocalesRegionComunaporPregunta($BD,$idPregunta){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_listarClusterLocalesRegionComunaporPregunta] ".$idPregunta;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }


    function ListarFormularioPreguntaClousterElementosPorCategoria($BD,$idPregunta,$categoria,$local){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarFormularioPreguntaClousterElementosPorCategoria] ".$idPregunta.",'".$categoria."',".$local;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarFormularioPreguntaClousterElementosCategoria($BD,$idPregunta,$local){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarFormularioPreguntaClousterElementosCategorias] ".$idPregunta.",".$local;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function CantidadPreguntaFormularioClousterElementos($BD,$idPregunta){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_CantidadPreguntaFormularioClousterElementos] ".$idPregunta;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

     function ListarFormularioPreguntaClousterLocalesZona($BD,$idPregunta){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarFormularioPreguntaClousterLocalesZona] ".$idPregunta;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

     function ListarFormularioPreguntaClousterLocalesRegion($BD,$idPregunta){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarFormularioPreguntaClousterLocalesRegion] ".$idPregunta;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarFormularioPreguntaClousterLocalesProvincia($BD,$idPregunta,$dep){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarFormularioPreguntaClousterLocalesProvincia] ".$idPregunta.",".$dep;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarFormularioPreguntaClousterLocalesDistrito($BD,$idPregunta,$prov){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarFormularioPreguntaClousterLocalesDistrito] ".$idPregunta.",".$prov;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

     function ListarFormularioPreguntaClousterLocalesComuna($BD,$idPregunta,$region){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarFormularioPreguntaClousterLocalesComunas] ".$idPregunta.",".$region;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarFormularioPreguntaClousterLocalesComunaLocales($BD,$idPregunta,$region,$comuna){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarFormularioPreguntaClousterLocalesLocales] ".$idPregunta.",".$region.",'".$comuna."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarCantidadPreguntaFormulario($BD,$formu){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ListarCantidadPregunta] ".$formu;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row();
        return $resultado;
    }

    function ValidarExistePreguntaLocales($BD,$formu){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_ValidarExistePreguntaLocales] ".$formu;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function OcultarPreguntasHijas($BD,$preg){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC [SP_AUD_OcultarPreguntasHijasFormulario] ".$preg;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarRegionesFormEsp($BD,$formu){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_ListarRegionesFormEsp ".$formu;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function buscarCiudadPorRegionFormEsp($BD,$formulario,$region){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_ListarCiudadPorRegionFormEsp ".$formulario.",".$region;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function buscarComunaPorCiudadFormEsp($BD,$formulario,$ciudad){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_ListarComunaPorCiudadFormEsp ".$formulario.",".$ciudad;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function buscarLocalPorComunaFormEsp($BD,$formulario,$comuna){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_ListarLocalPorComunaFormEsp ".$formulario.",".$comuna;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function buscarDireccionPorLocal($BD,$local){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC SP_AUD_BuscarDireccionPorLocal ".$local;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->row();
      return $resultado;
    }

    function IngresarFormularioEspecial($BD,$usuario,$local,$direccion,$latitud,$longitud){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_IngresarFormuarioEspecial ".$usuario.",".$local.",'".$direccion."',".$latitud.",".$longitud;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row();
        return $resultado;
    }

    function buscarSubOpcion($BD,$opcion){
      $this->db2 = $this->load->database($BD, TRUE); 
      $query = "EXEC [SP_AUD_BuscarSubtituloOpciones] ".$opcion;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->row();
      return $resultado;
    }
}
?>
