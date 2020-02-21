<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModuloPuntosVentas extends CI_model {

	function __construct()
    {
        parent::__construct();
    }    

    function listarRegiones($cliente){
        $consulta = $this->db->query("SP_AUD_ListarRegiones ".$cliente);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    //seba
    function listarPaisPorCliente($cliente){
        $consulta = $this->db->query("SP_AUD_ListarPaisPorCliente ".$cliente);
        $resultado = $consulta->row_array();
        return $resultado;
    }
    function listarCiudades($cliente){
        $consulta = $this->db->query("[SP_AUD_ListarCiudades] ".$cliente);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarCiudadesPorRegion($region){
        $consulta = $this->db->query("[SP_AUD_ListarCiudadesPorRegion] ".$region);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarComunas($region){
        $consulta = $this->db->query("SP_AUD_BuscarComunaPorRegion ".$region);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarComunasPorCiudad($ciudad){
        $consulta = $this->db->query("[SP_AUD_BuscarComunaPorCiudad] ".$ciudad);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarComunasTotales($cliente){
        $consulta = $this->db->query("SP_AUD_ListarComunas ".$cliente);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarCadenasActivos($BD){
        $this->db2 = $this->load->database($BD, TRUE); 

        $consulta = $this->db2->query("SP_AUD_ListarCadenasActivos");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarCadenas($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarCadenas");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarZona($BD){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_ListarZona");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarGrupoLocales($BD){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_ListarGrupoLocales");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarLocales($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarLocales");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarCantidadLocales($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarLocales");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarLocalesTodos($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_listarCantidadLocales]");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function listarLocalesTodosSeba($opcion,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_ListarLocalesTodosSeba]".$opcion);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ContadoresLocalesDash($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ContadoresLocalesDash");
        $resultado = $consulta->row_array();
        return $resultado;
    }

     function ContadoresFormularioDash($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ContadoresFormularioDash");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarJornadasporLocales($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarJornadasLocales");
        $resultado = $consulta->result_array();
        return $resultado;
    }

      function ListarAsistenciaporLocales($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarAsistenciaLocales");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ContadoresTareaDash($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ContadoresTareaDash");
        $resultado = $consulta->row_array();
        return $resultado;
    }


    function  buscarCadenaID($id,$BD){
        $this->db2 = $this->load->database($BD, TRUE);

    	$consulta = $this->db2->query("SP_AUD_BuscarCadenaPorID ".$id);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function  buscarZonaID($id,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarZonaPorID ".$id);
        $resultado = $consulta->row_array();
        return $resultado;
    }    

    function  buscarLocalID($id,$BD){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_BuscarLocalPorID ".$id);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function  buscarLocalNombre($local,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarLocales '$local'");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function  buscarLocalCadena($cadena,$BD){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_BuscarLocalActivoPorCadena ".$cadena);
        $resultado = $consulta->result_array();
        return $resultado;
    }  

    function  buscarGrupoLocalID($id,$BD){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_BuscarGrupoLocalPorID ".$id);
        $resultado = $consulta->row_array();
        return $resultado;
    }  

    function validarCadena($cadena,$BD){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_ValidarCadena '".$cadena."'");
        $resultado = $consulta->row();
        return $resultado;
    }

    function validarZona($zona,$BD){
        $this->db2 = $this->load->database($BD,TRUE);
        $consulta = $this->db2->query("SP_AUD_ValidarZona '".$zona."'");
        $resultado = $consulta->row();
        return $resultado;
    }

    function  ingresarCadena($cadena,$creador,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
    	$consulta = $this->db2->query("SP_AUD_CrearCadena '".$cadena."',".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function  ingresarZona($zona,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CrearZona '".$zona."'");
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function  ingresarLocal($local,$direccion,$cadena,$region,$comuna,$latitud,$longitud,$rango,$creador,$zona,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CrearLocal '".$local."','".$direccion."',".$cadena.",".$region.",".$comuna.",".$latitud.",".$longitud.",".$rango.",".$creador.",".$zona);
        $resultado = $consulta->row();
        return $resultado;
    }

    function  ingresarGrupoLocal($grupoL,$creador,$BD){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_CrearGrupoLocal '".$grupoL."',".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function  editarCadena($cadena,$creador,$BD,$idCadena){
        $this->db2 = $this->load->database($BD, TRUE);

    	$consulta = $this->db2->query("SP_AUD_EditarCadena '".$cadena."',".$creador.",".$idCadena);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function  editarZona($zona,$BD,$idZona){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_EditarZona '".$zona."',".$idZona);
        $resultado = $consulta->row_array();
        return $resultado;
    }  

    function  editarLocal($local,$direccion,$cadena,$region,$comuna,$latitud,$longitud,$rango,$creador,$zona,$BD,$idLocal){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_EditarLocal '".$local."','".$direccion."',".$cadena.",".$region.",".$comuna.",".$latitud.",".$longitud.",".$rango.",".$creador.",".$idLocal.",".$zona);
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function  editarGrupoLocal($grupoL,$creador,$BD,$idGrupoL){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_EditarGrupoLocal '".$grupoL."',".$creador.",".$idGrupoL);
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function cambiarEstadoCadena($cadena,$vigencia,$creador,$BD){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_CambiarActivoCadena ".$cadena.",".$vigencia.",".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function cambiarEstadoZona($Zona,$vigencia,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CambiarActivoZona ".$Zona.",".$vigencia);
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function cambiarEstadoLocal($usuario,$vigencia,$creador,$BD){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_CambiarActivoLocal ".$usuario.",".$vigencia.",".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function cambiarEstadoGrupoLocal($GrupoL,$vigencia,$creador,$BD){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_CambiarActivoGrupoLocal ".$GrupoL.",".$vigencia.",".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function buscarIdCadena($cadena,$BD){
        $this->db2 = $this->load->database($BD, TRUE);

        $consulta = $this->db2->query("SP_AUD_BuscarIdCadena '".$cadena."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function buscarIdComuna($comuna){
        $consulta = $this->db->query("SP_AUD_BuscarIdComuna '".$comuna."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function buscarIdComunaPorCiudad($region,$ciudad,$comuna){
        $consulta = $this->db->query("SP_AUD_BuscarIdComunaPorCiudad ".$region.",".$ciudad.",'".$comuna."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function buscarIdRegion($region){
        $consulta = $this->db->query("SP_AUD_BuscarIdRegion '".$region."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function buscarIdCiudadPorRegion($region,$ciudad){
        $consulta = $this->db->query("SP_AUD_BuscarIdCiudadPorRegion ".$region.",'".$ciudad."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function buscarIdZona($zona,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarIdZona '".$zona."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function listarZonas($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarZonaActivo");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ingresarITGrupoL($BD,$local,$grupo){ 
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_CrearITGrupoLocales] ".$local.",".$grupo);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function buscarIdGrupoLocales($BD,$TGrupo){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarIdGrupoLocal '".$TGrupo."'");
        $resultado = $consulta->row();
        return $resultado;
    }

    function BuscarIdLocal($BD,$nombreLocal){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_BuscarIdLocal '".$nombreLocal."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta -> row();
        return $resultado;
    }

    function listarUsuariosActivosGrupoLocales($BD,$grupo){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_ListarLocalesActivosEnGrupo] ".$grupo);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function editarITGrupoL($BD,$local,$idGrupoL){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("[SP_AUD_EditarITGrupoLocales] ".$local.",".$idGrupoL);
        $resultado = $consulta->row_array();
        return $resultado;
    }

     function desactivarGrupoL($BD,$grupo){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_DesactivarITGrupoLocalPorGrupo ".$grupo);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function buscarNombreGrupoLocalNombre($BD,$grupo){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_DesactivarITGrupoLocalPorGrupo ".$grupo);
        $resultado = $consulta->row_array();
        return $resultado;
    }
}
