<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModuloElemento extends CI_model {

	function __construct()
    {
        parent::__construct();
    }

    function ingresarCluster($nombreCluster,$id_creador,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_CrearCluster '".$nombreCluster."',".$id_creador;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    } 

    function ingresarElementoCluster($idC,$idLocal,$idProducto,$BD){ 
        $this->db2 = $this->load->database($BD, TRUE);  
        $consulta = $this->db2->query("SP_AUD_CrearElementoCluster ".$idC.",".$idLocal.",".$idProducto);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarNombreCluster($cluster,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_BuscarNombreCluster '".$cluster."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta -> row();
        return $resultado;
    }

    function listarCluster($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarCluster");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    // function listarElementosCluster($BD,$idCluster,$opcion){
    //     $this->db2 = $this->load->database($BD, TRUE);
    //     $consulta = $this->db2->query("SP_AUD_listarElementosCluster ".$idCluster.",".$opcion);
    //     $resultado = $consulta->result_array();
    //     return $resultado;
    // }

     function cantidadElementos($BD,$id_cluster){
        $this->db2 = $this->load->database($BD, TRUE); 
        $consulta = $this->db2->query("SP_AUD_CantidadElementos ".$id_cluster);
        $resultado = $consulta->num_rows();
        return $resultado;
    }

    function listarElementos($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarElementos");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function ingresarElemento($nombre,$categoria,$marca,$sku,$id_creador,$direction,$BD){ 
        $this->db2 = $this->load->database($BD, TRUE);  
        $consulta = $this->db2->query("SP_AUD_CrearElementos '".$nombre."','".$categoria."','".$marca."','".$sku."',
            ".$id_creador.",'".$direction."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ValidarElemento($nombreEle,$BD){
      $this->db2 = $this->load->database($BD, TRUE);
      $query = "EXEC SP_AUD_BuscarIdElemento '".$nombreEle."'";
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->row_array();
      return $resultado;
    }

    function listarElementosPorId($idEle,$BD){
      $this->db2 = $this->load->database($BD, TRUE);
      $query = "EXEC SP_AUD_BuscarElementoPorID ".$idEle;
      $consulta = $this->db2->query($query);
      $resultado = $consulta ->row_array();
      return $resultado;
    }

    function CambiarVigenciaElemento($idEle,$vigencia,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_CambiarActivoElemento ".$idEle.",".$vigencia;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    } 

    function EditarElementos($idEle,$vigencia,$nombreEle,$categoria,$marca,$SKU,$BD){
      $this->db2 = $this->load->database($BD, TRUE);
      $query = "EXEC SP_AUD_EditarElemento ".$idEle.",".$vigencia.",'".$nombreEle."','".$categoria."','".$marca."','".$SKU."'";
      $consulta = $this->db2->query($query);
      return $consulta->num_rows();
    }

    function BuscarIdLocal($nombreLocal,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_BuscarIdLocal '".$nombreLocal."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta -> row_array();
        return $resultado;
    }

    function BuscarIdProducto($producto,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_BuscarIdProducto '".$producto."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta -> row_array();
        return $resultado;
    }

    function ListarElementosClusterPorID($id_cluster,$opcion,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_ListarElementosIdCluster ".$id_cluster.",".$opcion;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function ListarElementosClusterPorID2($id_cluster,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_ListarElementosIdCluster2 ".$id_cluster;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }
 
    function listarClusterPorId($idCluster,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_ListarClusterPorId ".$idCluster;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function ListarTotalFilasClusterXid($id_cluster,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "SP_AUD_ListarTotalFilasClusterXid ".$id_cluster;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function CambiarVigenciaCluster($idCluster,$vigencia,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_CambiarActivoCluster ".$idCluster.",".$vigencia;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    } 

    function desactivarElementosCluster($id_cluster,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_DesactivarElementosCluster ".$id_cluster;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function listarClusterCantidadElemento($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_ContarElementosCluster";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->result_array();
        return $resultado;
    }

    function listarClusterCantidadLocales($opcion,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_listarClusterCantidadELocales '".$opcion."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function editarElementoCluster($idC,$idLocal,$idProducto,$BD){
        $this->db2 = $this->load->database($BD, TRUE);  
        $consulta = $this->db2->query("SP_AUD_EditarElementoCluster ".$idC.",".$idLocal.",".$idProducto);
        $resultado = $consulta->row();
        return $resultado;
    }

    function ingresarLocalesCluster($idc,$local,$BD){
        $this->db2 = $this->load->database($BD, TRUE);  
        $consulta = $this->db2->query("SP_AUD_CrearClusterLocal ".$idc.",".$local);
        $resultado = $consulta->row();
        return $resultado;
    }

    function ingresarClusterLocal($nombre,$creador,$BD){
        $this->db2 = $this->load->database($BD, TRUE);  
        $consulta = $this->db2->query("SP_AUD_CrearClusterLocalUnion '".$nombre."',".$creador);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function BuscarNombreClusterLocal($cluster,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_BuscarNombreClusterLocal '".$cluster."'";
        $consulta = $this->db2->query($query);
        $resultado = $consulta -> row_array();
        return $resultado;
    }

    function cargarClusterLocal($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarClusterLocal");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function listarClusterLocalID($BD,$idcluster){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_BuscarClusterLocalID ".$idcluster;
        $consulta = $this->db2->query($query);
        $resultado = $consulta -> row_array();
        return $resultado;
    }

    function CambiarVigenciaClusterLocal($idcluster,$vigencia,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_CambiarActivoClusterLocal ".$idcluster.",".$vigencia;
        $consulta = $this->db2->query($query);
        $resultado = $consulta ->row_array();
        return $resultado;
    }

    function cargarLocalClusterID($id_cluster,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarClusterLocalID ".$id_cluster);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarLocalClusterIDSeba($id_cluster,$opcion,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarClusterLocalID ".$id_cluster.",".$opcion);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarExcelClusterLocal($BD,$id_cluster){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CargarExcelClusterLocal ".$id_cluster);
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function cargarLocales($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_ListarLocales");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function actualizarLocalCluster($id_cluster,$id_local,$BD){
        $this->db2 = $this->load->database($BD, TRUE);  
        $consulta = $this->db2->query("SP_AUD_ActualizarLocalCluster ".$id_cluster.",".$id_local);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function desactivarClusterLocal($id_cluster,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $query = "EXEC SP_AUD_DesactivarClusterLocal ".$id_cluster;
        $consulta = $this->db2->query($query);
        $resultado = $consulta->row_array();
        return $resultado;
    }

    function ListarElementosCategoria($BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_CantidadElementosCategoria");
        $resultado = $consulta->result_array();
        return $resultado;
    }

    function buscarSKU($sku,$BD){
        $this->db2 = $this->load->database($BD, TRUE);
        $consulta = $this->db2->query("SP_AUD_BuscarElementoPorSKU '".$sku."'");
        $resultado = $consulta->row_array();
        return $resultado;
    }

}