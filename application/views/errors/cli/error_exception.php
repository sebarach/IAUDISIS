<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

An uncaught Exception was encountered

Type:        <?php echo get_class($exception), "\n"; ?>
Message:     <?php echo $message, "\n"; ?>
Filename:    <?php echo $exception->getFile(), "\n"; ?>
Line Number: <?php echo $exception->getLine(); ?>
<?Php
//mensaje de Error
    $mensaje = "\n error: ".$message."\n\n";
	$mensaje.= " Archivo:".$exception->getFile()."\n\n";
	$mensaje.= " Linea Número:".$exception->getLine()."\n\n";
	$mensaje.= " EQUIPO AUDISIS CHILE";
	$titulo="Error Sistema de CheckRoom";
	$email ="cristopher.ojeda@audisischile.com";
	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	//$cabeceras .= 'Cc: diego.luengo@audisischile.com' . "\r\n";
	$enviado = mail($email,$titulo,$mensaje,$cabeceras);
	// var_dump($enviado);
	// exit;
?>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

Backtrace:
<?php	foreach ($exception->getTrace() as $error): ?>
<?php		if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
	File: <?php echo $error['file'], "\n"; ?>
	Line: <?php echo $error['line'], "\n"; ?>
	Function: <?php echo $error['function'], "\n\n"; ?>
<?php		endif ?>
<?php	endforeach ?>

<?php endif ?>
