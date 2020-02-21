<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo "\nERROR: ",
	$heading,
	"\n\n",
	$message,
	"\n\n";

	//mensaje de Error
    $mensaje = "\n General error: ".$heading."\n\n".$message."\n\n";
	$titulo="Error Sistema de CheckRoom";
	$email ="cristopher.ojeda@audisischile.com";
	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	// //$cabeceras .= 'Cc: diego.luengo@audisischile.com' . "\r\n";
	$enviado = mail($email,$titulo,$mensaje,$cabeceras);