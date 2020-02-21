<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class moduloCliente extends CI_Model {

	public function __construct()
    {
        parent::__construct();
    }

	 function crearEmpresa($NombreEmpresa,$RazonSocial,$RutEmpresa,$id_creador){
      $query = "EXEC SP_AUD_CrearEmpresa '".$NombreEmpresa."','".$RazonSocial."','".$RutEmpresa."',".$id_creador;
      $consulta = $this->db->query($query);
      return $consulta->num_rows();
    } 

    function crearCliente($NombreCliente,$MailEmpresa,$idEmpresa,$id_creador,$direction,$idPais){
      $query = "EXEC SP_AUD_CrearCliente2 '".$NombreCliente."','".$MailEmpresa."',".$idEmpresa.",".$id_creador.",'".$direction."',".$idPais;
      $consulta = $this->db->query($query);
      return $consulta->num_rows();
    }

    function EditarCliente($NombreCliente,$MailEmpresa,$idEmpresa,$id_creador,$hidCliente,$direction,$idPais){
      $query = "EXEC SP_AUD_EditarCliente '".$NombreCliente."','".$MailEmpresa."',".$idEmpresa.",".$id_creador.",".$hidCliente.",'".$direction."',".$idPais;
      $consulta = $this->db->query($query);
      return $consulta->num_rows();
    } 

    function EditarEmpresa($NombreEmpresa,$RazonSocial,$RutEmpresa,$id_creador){
      $query = "EXEC SP_AUD_EditarEmpresa '".$NombreEmpresa."','".$RazonSocial."','".$RutEmpresa."',".$id_creador;
      $consulta = $this->db->query($query);
      return $consulta->num_rows();
    }   


    function ValidarEmpresa($RutEmpresa){
      $query = "EXEC SP_AUD_ValidarRutEmpresa '".$RutEmpresa."'";
      $consulta = $this->db->query($query);
      $resultado = $consulta ->row_array();
      return $resultado['exisite'];
    }

    function ValidarClienteEmpresa($idEmpresa,$NombreCliente){
      $query = "EXEC SP_AUD_ValidarClienteEmpresa ".$idEmpresa.",'".$NombreCliente."'";
      $consulta = $this->db->query($query);
      $resultado = $consulta ->row_array();
      return $resultado['exisite'];
    }

    function ListarEmpresa(){
      $query = "EXEC SP_AUD_ListarEmpresa";
      $consulta = $this->db->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function ListarPaises(){
      $query = "EXEC SP_AUD_ListarPaises";
      $consulta = $this->db->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function ListarEmpresaActivas(){
      $query = "EXEC SP_AUD_ListarEmpresaActivas";
      $consulta = $this->db->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

      function ListarCliente(){
      $query = "EXEC SP_AUD_ListarClientes";
      $consulta = $this->db->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

    function ListarClienteActivos(){
      $query = "EXEC SP_AUD_ListarClientesActivos";
      $consulta = $this->db->query($query);
      $resultado = $consulta ->result_array();
      return $resultado;
    }

     function ListarEmpresXid($idEmpresa){
      $query = "EXEC SP_AUD_BuscarEmpresaPorID ".$idEmpresa;
      $consulta = $this->db->query($query);
      $resultado = $consulta ->row_array();
      return $resultado;
    }

      function ListarClienteXid($idCliente){
      $query = "EXEC SP_AUD_BuscarClientePorID ".$idCliente;
      $consulta = $this->db->query($query);
      $resultado = $consulta ->row_array();
      return $resultado;
    }

    function cambiarEstadoEmpresa($idEmpresa,$vigencia,$idusercreador){
        $consulta = $this->db->query("SP_AUD_cambiarActivoEmpresa ".$idEmpresa.",".$vigencia.",".$idusercreador );
        $resultado = $consulta->row_array();
        return $resultado;
    } 


    function cambiarEstadoCliente($idCliente,$vigencia,$idusercreador){
        $consulta = $this->db->query("SP_AUD_cambiarActivoCliente ".$idCliente.",".$vigencia.",".$idusercreador );
        $resultado = $consulta->row_array();
        return $resultado;
    } 



}

?>