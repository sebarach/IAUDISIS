<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class moduloFormulario extends CI_Model {

	public function __construct()
  {
      parent::__construct();
  }

  function ListarTiposPreguntasFormulario(){
    $query = "EXEC SP_AUD_ListarTiposPreguntasActivas";
    $consulta = $this->db->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarListaMaestraFormulario($BD){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_FormularioListaMaestra";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarListaMaestraLocales($BD){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarClusterLocalesActivos]";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarFormulario($BD){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarFormularios";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function FiltroGaleriaCadena($BD,$id_cadena,$id_form){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_FiltroGaleriaCadena ".$id_cadena.",".$id_form;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarGaleria($BD,$id_formulario,$local,$cadena,$comuna,$region,$fecha,$page){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_GaleriaFotografica ".$id_formulario.",".$local.",".$cadena.",".$comuna.",".$region.",'".$fecha."',".$page;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarComunas($BD,$id_formulario){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarComunaFormulario ".$id_formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarCadenas($BD,$id_formulario){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarCadenasFormulario ".$id_formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarRegiones($BD,$id_formulario){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarRegionFormulario ".$id_formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarLocales($BD,$id_formulario){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarLocalFormulario ".$id_formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarGaleriaPPT($BD,$id_formulario){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_GaleriaFotograficaPPT ".$id_formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function pptjsc($BD,$id_formulario,$fecha){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_JSCPPT ".$id_formulario.",'".$fecha."'";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarGaleriaCadena($BD,$id_formulario,$local,$cadena,$comuna,$region,$fecha){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_GaleriaFotograficaCadena ".$id_formulario.",".$local.",".$cadena.",".$comuna.",".$region.",'".$fecha."'";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarFiltros($BD,$id_formulario){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_FiltroGaleria ".$id_formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }


  function ListarRegionesGaleria($id_formulario){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarRegionFormulario ".$id_formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarComunasGaleria($id_formulario){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarComunaFormulario ".$id_formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarLocalesGaleria($id_formulario){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarLocalFormulario ".$id_formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarCadenasGaleria($id_formulario){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarCadenasFormulario ".$id_formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarFormularioPreguntaUsuario($BD,$preguntas){
    $this->db2 = $this->load->database($BD, TRUE); 
    $query = "EXEC [SP_AUD_ListarFormularioPreguntaPorFormulario] ".$preguntas;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarFormularioPreguntaDepHijo($BD,$preguntas,$hijo){
    $this->db2 = $this->load->database($BD, TRUE); 
    $query = "EXEC [SP_AUD_ListarFormularioPreguntaPorDependenciaHijo] ".$preguntas.','.$hijo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function IngresarNombreFormulario($BD,$nombre){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_IngresarFormulario] '".$nombre."'";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row();
    return $resultado;
  }

  function IngresarModuloFormulario($BD,$idModulo,$idForm,$nombre,$orden,$vigencia){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_IngresarFormularioModulo] ".$idModulo.",".$idForm.",'".$nombre."',".$orden.",".$vigencia;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row();
    return $resultado;
  }

  function IngresarPreguntaFormulario($BD,$preg,$idMod,$idForm,$tipo,$nombre,$oblitario,$restriccion,$visible,$orden,$vigencia){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_IngresarFormularioPregunta] ".$preg.",".$idMod.",".$idForm.",".$tipo.",'".$nombre."',".$oblitario.",".$restriccion.",".$visible.",".$orden.",".$vigencia;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row();
    return $resultado;
  }

  function IngresarOpcionFormulario($BD,$opci,$pregunta,$nombre,$orden,$vigencia){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_IngresarFormularioOpcion] ".$opci.",".$pregunta.",'".$nombre."',".$orden.",".$vigencia;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row();
    return $resultado;
  }

  function IngresarClustersFormulario($BD,$ele,$pregunta,$cluster,$vigencia){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_IngresarFormularioCluster] ".$ele.",".$pregunta.",".$cluster.",".$vigencia;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row();
    return $resultado;
  }

  function cambiarEstadoFormulario($BD,$formulario,$vigencia){
    $this->db2 = $this->load->database($BD, TRUE);
    $consulta = $this->db2->query("SP_AUD_cambiarActivoFormulario ".$formulario.",".$vigencia);
    $resultado = $consulta->row_array();
    return $resultado;
  }

  function cambiarEstadoFormularioEspecial($BD,$formulario,$vigencia){
    $this->db2 = $this->load->database($BD, TRUE);
    $consulta = $this->db2->query("[SP_AUD_cambiarActivoFormularioEspecial] ".$formulario.",".$vigencia);
    $resultado = $consulta->row_array();
    return $resultado;
  }

  function insertarFechaForm($BD,$fechaInicioCompleta,$fechaFinalCompleta,$id_form){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_AsignarFechaForm] '".$fechaInicioCompleta."','".$fechaFinalCompleta."',".$id_form;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row_array();
    return $resultado;
  }

  function DesactivarFormularioDependencia($BD,$padre){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_DesactivarFormularioDependencia] ".$padre;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row_array();
    return $resultado;
  }

  function IngresarFormularioDependencias($BD,$padre,$hijo,$respuesta){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_IngresarFormularioDependencias] ".$padre.",".$hijo.",'".$respuesta."'";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row();
    return $resultado;
  }

  function CantidadIntentosFormularios($BD,$formulario){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_BuscarCantidadIntentoFormulario] ".$formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row();
    return $resultado;
  }

  function AgregarCantidadFormu($BD,$formulario,$cantidad,$observacion){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_AgregarCantidadFormulario] ".$formulario.",".$cantidad.",'".$observacion."'";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row();
    return $resultado;
  }

  function ValidarNombreFormulario($BD,$nombre){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ValidarNombreFormulario] '".$nombre."'";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row();
    return $resultado;
  }

  function ListarFormularioModuloEditar($BD,$formulario){
    $this->db2 = $this->load->database($BD, TRUE); 
    $query = "EXEC [SP_AUD_ListarFormularioModuloPorFormularioTodos] ".$formulario;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarFormularioPreguntaEditar($BD,$modulo){
    $this->db2 = $this->load->database($BD, TRUE); 
    $query = "EXEC [SP_AUD_ListarFormularioPreguntaPorModuloTodos] ".$modulo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarFormularioOpcionEditar($BD,$pregunta){
    $this->db2 = $this->load->database($BD, TRUE); 
    $query = "EXEC [SP_AUD_ListarFormularioOpcionesPorFormularioTodos] ".$pregunta;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarFormularioClusterElementoEditar($BD,$pregunta){
    $this->db2 = $this->load->database($BD, TRUE); 
    $query = "EXEC [SP_AUD_ListarFormularioClusterPorFormularioTodos] ".$pregunta;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row_array();
    return $resultado;
  }

  function ListarFormularioClusterLocalEditar($BD,$pregunta){
    $this->db2 = $this->load->database($BD, TRUE); 
    $query = "EXEC [SP_AUD_ListarFormularioPreguntaClousterLocalesTodos] ".$pregunta;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->row_array();
    return $resultado;
  }

  function ListarFormulariosEspeciales($BD){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarFormulariosEspeciales] ";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function asignarFormularioEspecialGrupoLocales($BD,$formu,$grupo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_AsignarFormularioEspecialGrupoLocal] ".$formu.",".$grupo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }


  function ListarUsuariosActivos($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$tipo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarFormulariosGaleria] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$tipo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }


  function ListarFormulariosActivos($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarFormulariosGaleria] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$usuario.",".$tipo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarZonasActivas($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarZonasGaleria] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$usuario.",".$tipo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarTerritoriosActivos($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarTerritoriosGaleria] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$usuario.",".$tipo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarDeptosActivos($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarDeptosGaleria] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$usuario.",".$tipo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarProvinciasActivas($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarProvinciasGaleria] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$usuario.",".$tipo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarDistritosActivos($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarDistritosGaleria] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$usuario.",".$tipo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarCadenasActivas($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarCadenasGaleria] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$usuario.",".$tipo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarCanalActivos($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarCanalGaleria] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$usuario.",".$tipo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarLocalesActivos($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarLocalesGaleria] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$usuario.",".$tipo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function ListarUsuariosFormActivos($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC [SP_AUD_ListarUsuariosGaleria] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$usuario.",".$tipo;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }


  function ListarGaleriaFE($BD,$form,$local,$fecha,$zona,$territorio,$depto,$provincia,$distrito,$cadena,$canal,$usuario,$tipo,$page){
    $this->db2 = $this->load->database($BD, TRUE);
    $query="EXEC [SP_AUD_GaleriaFormularioVista] ".$form.",".$local.",'".$fecha."',".$zona.",".$territorio.",".$depto.",".$provincia.",".$distrito.",".$cadena.",".$canal.",".$usuario.",".$tipo.",".$page;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }


  function FormularioReporteActivos($BD){
      $this->db2 = $this->load->database($BD, TRUE);
      $query = "EXEC ListarFormulariosReporteActivos  ";
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;

  }

  function ListarCadenaformularios($BD,$id_formulario,$id_cadena,$id_local,$fecha){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarCadenasFormularios ".$id_formulario.",".$id_cadena.",".$id_local.",'".$fecha."'";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;
  }

  function  ListarLocalesformularios($BD,$id_formulario,$id_cadena,$id_local,$fecha){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarLocalesFormularios ".$id_formulario.",".$id_cadena.",".$id_local.",'".$fecha."'";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;

  }

  function ListarFormformularios($BD,$id_formulario,$id_cadena,$id_local,$fecha){
    $this->db2 = $this->load->database($BD, TRUE);
    $query = "EXEC SP_AUD_ListarFormulariosActivos ".$id_formulario.",".$id_cadena.",".$id_local.",'".$fecha."'";
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;

  }

  function ListarGaleriaForm($BD,$id_formulario,$id_local,$id_cadena,$fecha,$page){
    $this->db2 = $this->load->database($BD, TRUE);
    $query="EXEC SP_AUD_GaleriaFormularioVista ".$id_formulario.",".$id_cadena.",".$id_local.",'".$fecha."',".$page;
    $consulta = $this->db2->query($query);
    $resultado = $consulta ->result_array();
    return $resultado;

  }

}