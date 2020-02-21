<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>An uncaught Exception was encountered</h4>

<p>Type: <?php echo get_class($exception); ?></p>
<p>Message: <?php echo $message; ?></p>
<p>Filename: <?php echo $exception->getFile(); ?></p>
<p>Line Number: <?php echo $exception->getLine(); ?></p>

<?Php
//mensaje de Error
    $mensaje = "<div style='border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;'>
				<h4>An uncaught Exception was encountered</h4>
				<p>Type: ".get_class($exception)."</p>
				<p>Message: ".$message."</p><p>Filename: ".$exception->getFile()."</p>
				<p>Line Number: ".$exception->getLine()."</p></div>";
	$titulo="Error Sistema de ID-Audisis";
	$email ="mario.bustos@audisischile.com";
	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	//$cabeceras .= 'Cc: diego.luengo@audisischile.com' . "\r\n";
	$enviado = mail($email,$titulo,$mensaje,$cabeceras);
?>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Backtrace:</p>
	<?php foreach ($exception->getTrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p style="margin-left:10px">
			File: <?php echo $error['file']; ?><br />
			Line: <?php echo $error['line']; ?><br />
			Function: <?php echo $error['function']; ?>
			</p>
		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>