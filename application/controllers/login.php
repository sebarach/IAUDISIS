
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	
	public function index()
	{
		$this->load->view('login/login');	
		
	}
		
	function inicio()
	{
		$this->session->sess_destroy();
		$this->load->view('login/login');
	}

	function recuperarClave(){
		$this->load->library('phpmailer_lib');
		if(isset($_POST["txt_rut"])){
			$rut=$this->limpiarRut($_POST["txt_rut"]);
			$validador=$this->validaRut($rut);
			if($validador==true){					
				$this->load->model("funcion_login");
				$resp=$this->funcion_login->recuperarClave($rut);
				if(isset($resp["Email"])){	
					$email=$resp["Email"];	
					$random= rand(1, 10000);
					$link=openssl_encrypt($resp["Rut"],"AES-128-ECB","12314")."//-*".openssl_encrypt($random,"AES-128-ECB","12314");
					$link= str_replace("+","-", $link);
					$link= str_replace("&","-", $link);
					$this->funcion_login->enviarparametrorecup($resp['ID_Usuario'],$link);
					$asunto='Notificación de recuperación constraseña - I-Audisis';				
					$mnsj="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
							<html xmlns='http://www.w3.org/1999/xhtml'>
							<head>
							    <meta charset='utf-8'>
							    <meta http-equiv='x-ua-compatible' content='ie=edge'>
							    <meta name='description' content='Admin, Dashboard, Bootstrap' />
							    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
								<meta name='theme-color' content='#ffffff'>
							</head> 
							<body> 
								<section class='container-pages'> 			
									<div class='card pages-card col-lg-4 col-md-6 col-sm-6'> 
										<div class='card-body '> 
											<div class='user-img text-center'> 
												<div class='h4 text-center text-theme'><strong>Recuperación de Contraseña</strong></div></div>
								                <div class='h4 text-center text-dark'> Sr(a). </div>
								                <div class='small text-center text-dark'>Se ha solicitado la recuperación de la contraseña de la aplicación.</div>  
								                <div class='small text-center text-dark'>Haga click en el siguiente enlaze para generar una nueva contraseña: </div>
								                <div class='small text-center text-dark'>".site_url()."login/recuperacion?dat=".$link."</div>  
								                <div class='small text-center text-dark'>Saludos.</div>  
								                 <div class='small text-center text-dark'>Atte. Equipo I-Audisis</div>              
								            </div>
								        </div>
								        <br>
								    </section>
								    <div class='half-circle'></div>
								    <div class='small-circle'></div>
								    <div id='copyright'><a href='#' >I-Audisis</a> &copy; 2018. </div>							    
								</body>
							</html>";
					$this->enviaremail($email,$mnsj,$asunto);				
					echo "OP4";
				}else{
					echo "OP3";
				}			
			}else{
				echo "OP2";
			}
		}else{
			echo 'OP1';
		}
	}

	function success(){
		$mens['tipo'] = 20;					
		$this->load->view('login/login');
		$this->load->view('layout/mensajes',$mens);
	}

	function change(){
		$mens['tipo'] = 40;					
		$this->load->view('login/login');
		$this->load->view('layout/mensajes',$mens);
	}

	function recuperacion(){
		$datos=$_GET["dat"];
		$this->load->model("funcion_login");
		$respuesta=$this->funcion_login->validarSolicitudCambioClave($datos);
		if(isset($respuesta)){
			$data["ID_Usuario"]=$respuesta->ID_Usuario;
			$data["Correo"]=$respuesta->Email;
			$this->load->view('login/linkCorrecto',$data);
		}else{
			$this->load->view('login/linkIncorrecto');
		}
	}

	function limpiarRut($rut){
    	$patron = "/[^-k0-9]/i";    
        $cadena_nueva = preg_replace($patron, "", $rut);
        return $cadena_nueva; 
    }

    function validaRut($rut){
		$resultado =preg_replace("/[^0-9]/","", $rut);
		$suma = 0;
		if(strlen($resultado)>0){
	    if(strpos($rut,"-")==false){
	        $RUT[0] = substr($rut, 0, -1);
	        $RUT[1] = substr($rut, -1);
	    }else{
	        $RUT = explode("-", trim($rut));
	    }
	    $elRut = str_replace(".", "", trim($RUT[0]));
	    $factor = 2;
	    for($i = strlen($elRut)-1; $i >= 0; $i--):
	        $factor = $factor > 7 ? 2 : $factor;
	        $suma += $elRut{$i}*$factor++;
	    endfor;
	    $resto = $suma % 11;
	    $dv = 11 - $resto;
	    if($dv == 11){
	        $dv=0;
	    }else if($dv == 10){
	        $dv="k";
	    }else{
	        $dv=$dv;
	    }
	   if($dv == trim(strtolower($RUT[1]))){
	       return true;
	   }else{
	       return false;
	   }
	   }else{
			return false;
		}
	}

	// function enviaremail($EmailUser,$msjEmail,$titulo){
	// 	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	// 	$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	// 	$cabeceras .= 'Cc: notificaciones-audisis@audisischile.com '."\r\n";
	// 	$enviado = mail($EmailUser,$titulo,$msjEmail,$cabeceras);
	// 	// $enviado = null;
	// 	return $enviado;
	// }

	function enviaremail($EmailUser,$msjEmail,$titulo){
       
        
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        
       // SMTP configuration
       $mail->isSMTP();
       $mail->Host     ='smtp.tie.cl';
       $mail->SMTPAuth = true;
       $mail->Username = 'no-contestar@audisischile.com';
       $mail->Password = 'Audisis2015';
       $mail->SMTPSecure = 'tls';
       $mail->Port     = 25;
        
        $mail->setFrom('no-contestar@audisischile.com','Equipo Audisis');
        $mail->addReplyTo('','');
        
        // Add a recipient
        $mail->addAddress($EmailUser);
        
        // Add cc or bcc 
        $mail->addCC('');
        $mail->addBCC('');
        
        // Email subject
        $mail->Subject = $titulo;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = $msjEmail;
        $mail->Body = $mailContent;
        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
			Return False;
        }else{
           return True;
        }

    }
}

?>