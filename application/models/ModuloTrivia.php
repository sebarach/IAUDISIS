<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class moduloTrivia extends CI_model {
	function __construct()
    {
        parent::__construct();
    }

    function cargarOpciones($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarOpcionesTrivia");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ingresarPregunta($tituloPregunta,$categoria,$dificultad,$tipoPregunta,$BD){
    	$this->db2 = $this->load->database($BD, TRUE);
	    $query = "EXEC [SP_AUD_IngresarTriviaOpcion] '".$tituloPregunta."','".$categoria."',".$dificultad.",".$tipoPregunta;
	    $consulta = $this->db2->query($query);
	    $resultado = $consulta ->row_array();
	    return $resultado;
    }

    function ingresarOpciones($pregunta,$nombreOpc,$activo,$BD){
    	$this->db2 = $this->load->database($BD, TRUE);
	    $query = "EXEC SP_AUD_IngresarOpcionTrivia ".$pregunta.",'".$nombreOpc."',".$activo;
	    $consulta = $this->db2->query($query);
	    $resultado = $consulta ->row_array();
	    return $resultado;
    }

    function listarPreguntas($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarPreguntas");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarPreguntasAleatorias($cantidad,$dificultad,$BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarPreguntasAleatorias ".$cantidad.",".$dificultad);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarOpcionesTrivia($pregunta,$BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarOpcionesTrivia ".$pregunta);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function guardarQuiz($creador,$nombre,$random,$BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_GuardarQuiz ".$creador.",'".$nombre."',".$random);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function GuardarModulos($nombreModulo,$idq,$porcentaje,$baja,$media,$alta,$categoria,$BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_GuardarModulosQuiz '".$nombreModulo."',".$idq.",".$porcentaje.",".$baja.",".$media.",".$alta.",'".$categoria."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function listarCategorias($BD){
    	$this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarCategoriasTrivia");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function guardarRespuestas($modulo,$id_trivia,$id_usuario,$id_asignacion,$id_local,$id_pregunta,$respuesta,$prom,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_GuardarRespuestasQuiz ".$modulo.",".$id_trivia.",".$id_usuario.",".$id_asignacion.",".$id_local.",".$id_pregunta.",'".$respuesta."',".$prom);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function obtenerOpcionCorrecta($pregunta,$correcta,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_RetornarRespCorrecta ".$pregunta.",'".$correcta."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function guardarRespCorrect($resp,$pregunta,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_GuardarRespuestaCorecta ".$resp.",".$pregunta);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function existeCategoria($categoria,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarCategoriaPregunta '".$categoria."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function guardarAudio($id_pregunta,$audio,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_GuardarAudioQuiz ".$id_pregunta.",'".$audio."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function respuestasCorrectas($pregunta,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_RetornarRespCorrectaQuiz ".$pregunta);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    //Funciones referente a las trivias estáticas

    function ingresarPreguntasEstaticas($quiz,$pregunta,$modulo,$chkApl,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_GuardarPreguntasTriviaEstatica ".$quiz.",'".$pregunta."',".$modulo.",".$chkApl);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ingresarOpcionesEstaticas($pregunta,$opcion,$igual,$checkFotoOpcion,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_GuardarOpcionesTriviaEstatica ".$pregunta.",'".$opcion."',".$igual.",".$checkFotoOpcion);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ingresarRespCorrecta($id_opcion,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_IngresarRespCorrectaTriviaEstatica ".$id_opcion);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function listarOpcionesTriviaEstatica($pregunta,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarOpcionesTriviaEstaticaEditar ".$pregunta);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarOpcionesTriviaEstaticaX($pregunta,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarOpcionesTriviaEstatica ".$pregunta);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function respuestasCorrectasEstatico($pregunta,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_RetornarRespCorrectaQuizEstatica ".$pregunta);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function guardarRespuestasEstatica($param,$id_trivia,$id_modulo,$id_usuario,$id_asignacion,$id_local,$id_pregunta,$nombre_pregunta,$respuesta,$promedio,$promModulo,$obs,$foto,$fotoGeneral,$foto_opcion,$BD){        
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_GuardarRespuestasQuiz ".$param.",".$id_trivia.",".$id_modulo.",".$id_usuario.",".$id_asignacion.",".$id_local.",".$id_pregunta.",'".$nombre_pregunta."','".$respuesta."',".$promedio.",".$promModulo.",'".$obs."','".$foto."','".$fotoGeneral."','".$foto_opcion."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function listarTriviasEstaticas($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarTriviasEstaticas ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function LocalesActivos($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("ListarLocalesActivos ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function buscarQuizIDEstatico($BD,$idQuiz){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_BuscarQuizIDEstaticoEditar ".$idQuiz;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function guardarArchivo($id_pregunta,$archivo,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_GuardarArchivoQuiz ".$id_pregunta.",'".$archivo."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function editarTrivia($id_trivia,$nombre_trivia,$id_modulo,$nombre_modulo,$porcentaje,$id_pregunta,$nombre_pregunta,$id_opcion,$nombre_opcion,$respuesta,$vigencia,$vigenciaF,$vigenciaDesc,$vigenciaFotoMod,$vigenciaObs,$vigenciaNoAplica,$vigenciaFotoOP,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_EditarTriviaEstatica ".$id_trivia.",'".$nombre_trivia."',".$id_modulo.",'".$nombre_modulo."',".$porcentaje.",".$id_pregunta.",'".$nombre_pregunta."',".$id_opcion.",'".$nombre_opcion."',".$respuesta.",".$vigencia.",".$vigenciaF.",".$vigenciaDesc.",".$vigenciaFotoMod.",".$vigenciaObs.",".$vigenciaNoAplica.",".$vigenciaFotoOP);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function preguntaArchivo($BD,$id_pregunta){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_PreguntarArchivo ".$id_pregunta;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function guardarTriviaCompletada($id_asignacion,$id_usuario,$id_local,$cantidad,$id_trivia,$nota,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CambiarEstadoTriviaEstatica ".$id_asignacion.",".$id_usuario.",".$id_local.",".$cantidad.",".$id_trivia.",".$nota);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function cargarTablaRespuestas($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarRespTriviaGeneral ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarDatosFiltroUsuario($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_DatosFiltroRespTriviaUsuarios ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarDatosFiltroGrupoU($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_DatosFiltroRespTriviaGrupoU ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarDatosFiltroLocal($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_DatosFiltroRespTriviaLocal ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarDatosFiltroTrivia($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_DatosFiltroRespTriviaTrivia ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarDatosFiltroTriviaFecha($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_DatosFiltroRespTriviaFecha ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function triviaRespFiltrada($usuario,$grupo_usuario,$local,$zona,$fecha,$trivia,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_BuscarTriviaRespFiltrada ".$usuario.",".$grupo_usuario.",".$local.",".$zona.",'".$fecha."',".$trivia;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function cargarDatosGraficoTrivia($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_PromedioTriviaTrivia ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarDatosGraficoGrupoU($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_PromedioTriviaGrupoUsuario ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarResultadoTriviaPorUsuario($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarResultadoTriviaPorUsuario ");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function validarExisteTriviaEstatica($nombre_trivia,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_ValidarExisteTriviaEstatica '".$nombre_trivia."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result();
        return $resultado;
    }

    function ingresarModuloTriviaEstatica($tituloModulo,$idQuiz,$porcentaje,$foto,$obs,$checkDesc,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_IngresarModuloTriviaEstatica '".$tituloModulo."',".$idQuiz.",".$porcentaje.",".$foto.",".$obs.",".$checkDesc);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function buscarQuizIDEstaticoModulo($BD,$idQuiz){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_BuscarQuizIDEstaticoEditarModulo ".$idQuiz;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function desactivarModuloPorId($id_modulo,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_DesactivarModuloEstatico ".$id_modulo);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function desactivarPreguntaId($id_pregunta,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_SP_AUD_DesactivarPreguntaEstatico ".$id_pregunta);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function listarPreguntasPorQuiz($BD,$idQuiz){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_listarPreguntasPorQuiz ".$idQuiz;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function listarPreguntasTriviaEstatica($idModulo,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_BuscarPreguntasIDEstaticoEditar ".$idModulo;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function asignarFotoTrivia($foto,$id_trivia,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_GuardarFotoTrivia ".$foto.",".$id_trivia);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function retornoDatosTrivia($id_trivia,$BD){
        $this->db2 = $this->load->database($BD, TRUE); 
        $query = "EXEC SP_AUD_RetornoDatosTrivia ".$id_trivia;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function ListarListaMaestraLocales($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC [SP_AUD_ListarClusterLocalesActivos]";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function guardarIdMaestra($idMaestra,$idq,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_GuardarIDMaestra ".$idMaestra.",".$idq);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function cargarListaMaestra($id_maestra,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC [SP_AUD_ListarClusterLocalesActivosTrivia] ".$id_maestra;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarClusterComunasActivosTrivia($BD,$id_maestra,$region){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_ListarClusterComunasActivosTrivia ".$id_maestra.",".$region;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarClusterLocalesActivosTrivia($BD,$id_maestra,$comuna){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_ListarClusterLocalesLocalesActivosTrivia ".$id_maestra.",".$comuna;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarClusterCiudadesActivosTrivia($BD,$id_maestra,$ciudad){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_ListarClusterCiudadesActivosTrivia ".$id_maestra.",".$ciudad;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }


    function ListarGaleriaFotograficaFE($BD,$id_trivia,$id_local,$fecha,$id_zona,$id_territorio,$id_depto,$id_provincia,$id_distrito,$id_cadena,$id_canal,$tipo,$mes,$page){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_GaleriaTriviaVista  ".$id_trivia.",".$id_local.",'".$fecha."',".$id_zona.",".$id_territorio.",".$id_depto.",".$id_provincia.",".$id_distrito.",".$id_cadena.",".$id_canal.",".$tipo.",'".$mes."',".$page;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarGaleriaFotografica($BD,$id_trivia,$id_cadena,$id_local,$fecha,$page){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_GaleriaTriviaVista  ".$id_trivia.",".$id_cadena.",".$id_local.",'".$fecha."',".$page;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarGaleriaFotograficaPPT($BD,$id_trivia){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_GaleriaTrivia  ".$id_trivia;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function TriviasReporteActivas($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_ListarTriviasReporteActivas  ";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;

    }

    function ListarCadenatrivias($BD,$id_trivia,$id_cadena,$id_local,$fecha){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_ListarCadenasTrivias  ".$id_trivia.",".$id_cadena.",".$id_local.",'".$fecha."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarLocalestrivias2($BD,$id_trivia,$id_cadena,$id_local,$fecha){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_ListarLocalesTrivias ".$id_trivia.",".$id_cadena.",".$id_local.",'".$fecha."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
        
    }

    function ListartriviasT($BD,$id_trivia,$id_cadena,$id_local,$fecha){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_ListarTriviasEstativasActivas ".$id_trivia.",".$id_cadena.",".$id_local.",'".$fecha."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
        
    }

    function TriviasEstaticasActivas($BD,$id_trivia,$id_local,$fecha,$id_zona,$id_territorio,$id_depto,$id_provincia,$id_distrito,$id_cadena,$id_canal,$tipo,$mes){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("ListarTriviasEstaticasActivas ".$id_trivia.",".$id_local.",'".$fecha."',".$id_zona.','.$id_territorio.','.$id_depto.','.$id_provincia.','.$id_distrito.','.$id_cadena.','.$id_canal.','.$tipo.",'".$mes."'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ListarTerritorio($BD,$id_trivia,$id_local,$fecha,$id_zona,$id_territorio,$id_depto,$id_provincia,$id_distrito,$id_cadena,$id_canal,$tipo,$mes){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC ListarTerritorio  ".$id_trivia.",".$id_local.",'".$fecha."',".$id_zona.','.$id_territorio.','.$id_depto.','.$id_provincia.','.$id_distrito.','.$id_cadena.','.$id_canal.','.$tipo.",'".$mes."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarDepto($BD,$id_trivia,$id_local,$fecha,$id_zona,$id_territorio,$id_depto,$id_provincia,$id_distrito,$id_cadena,$id_canal,$tipo,$mes){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC ListarDepto  ".$id_trivia.",".$id_local.",'".$fecha."',".$id_zona.','.$id_territorio.','.$id_depto.','.$id_provincia.','.$id_distrito.','.$id_cadena.','.$id_canal.','.$tipo.",'".$mes."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarProvincia($BD,$id_trivia,$id_local,$fecha,$id_zona,$id_territorio,$id_depto,$id_provincia,$id_distrito,$id_cadena,$id_canal,$tipo,$mes){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC ListarProvincia  ".$id_trivia.",".$id_local.",'".$fecha."',".$id_zona.','.$id_territorio.','.$id_depto.','.$id_provincia.','.$id_distrito.','.$id_cadena.','.$id_canal.','.$tipo.",'".$mes."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarDistrito($BD,$id_trivia,$id_local,$fecha,$id_zona,$id_territorio,$id_depto,$id_provincia,$id_distrito,$id_cadena,$id_canal,$tipo,$mes){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC ListarDistrito  ".$id_trivia.",".$id_local.",'".$fecha."',".$id_zona.','.$id_territorio.','.$id_depto.','.$id_provincia.','.$id_distrito.','.$id_cadena.','.$id_canal.','.$tipo.",'".$mes."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarCadena($BD,$id_trivia,$id_local,$fecha,$id_zona,$id_territorio,$id_depto,$id_provincia,$id_distrito,$id_cadena,$id_canal,$tipo,$mes){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC ListarCadena  ".$id_trivia.",".$id_local.",'".$fecha."',".$id_zona.','.$id_territorio.','.$id_depto.','.$id_provincia.','.$id_distrito.','.$id_cadena.','.$id_canal.','.$tipo.",'".$mes."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarLocalesTrivias($BD,$id_trivia,$id_local,$fecha,$id_zona,$id_territorio,$id_depto,$id_provincia,$id_distrito,$id_cadena,$id_canal,$tipo,$mes){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC ListarLocalesTrivias ".$id_trivia.",".$id_local.",'".$fecha."',".$id_zona.','.$id_territorio.','.$id_depto.','.$id_provincia.','.$id_distrito.','.$id_cadena.','.$id_canal.','.$tipo.",'".$mes."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarZonaTrivias($BD,$id_trivia,$id_local,$fecha,$id_zona,$id_territorio,$id_depto,$id_provincia,$id_distrito,$id_cadena,$id_canal,$tipo,$mes){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC ListarZonaTrivias ".$id_trivia.",".$id_local.",'".$fecha."',".$id_zona.','.$id_territorio.','.$id_depto.','.$id_provincia.','.$id_distrito.','.$id_cadena.','.$id_canal.','.$tipo.",'".$mes."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarCanal($BD,$id_trivia,$id_local,$fecha,$id_zona,$id_territorio,$id_depto,$id_provincia,$id_distrito,$id_cadena,$id_canal,$tipo,$mes){
         $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC ListarCanal ".$id_trivia.",".$id_local.",'".$fecha."',".$id_zona.','.$id_territorio.','.$id_depto.','.$id_provincia.','.$id_distrito.','.$id_cadena.','.$id_canal.','.$tipo.",'".$mes."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }


    function TriviasAnios($BD,$tipo){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "exec SP_AUD_ListarAnios ".$tipo;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    

}