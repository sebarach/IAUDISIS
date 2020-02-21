function recuperarClave() {
	if($("#txt_rut").val()!=''){
		var rut=$("#txt_rut").val();
		var validar=0;
		if(rut.match("-")){
			if(rut.length<=12){
				$.ajax({
		            url: "http://checkroom.cl/audisis/login/recuperarClave",
		            method: "POST",
		            data: $("#form_recuperar").serialize(), 
		            success: function(data) {
		            	if(data.match("OP1")){
		            		alertify.error("No se Ingreso el Rut");
		            	}else if(data.match("OP2")){
		        			alertify.error("Rut No Valido");			
		            	}else if(data.match("OP3")){
		            		alertify.error("Usuario no ingresado en la plataforma");	
		            	}else if(data.match("OP4")){
		            		window.location = "http://checkroom.cl/audisis/login/success";
		            	}else{	
		            		alertify.error("Error Desconocido");	
		            	}
		            }
		        });
		        if(validar==1){
		        	alertify.succes("Bien");	
		        }
			}else{
				alertify.error("Formato Incorrecto");		
			}
		}else{
			alertify.error("No se Ingreso el guión verificador");	
		}
	}else{
		alertify.error("No se Ingreso el Rut");
	}
}

function nuevaClave(){
	if($("#txt_usuario1").val()!="" && $("#txt_usuario2").val()!=""){
		var pass1=$("#txt_usuario1").val();
		var pass2=$("#txt_usuario2").val();
		if(pass1==pass2){
			if (pass1.length>=6) {
				var idUsu=$("#txt_usu").val();
				var email=$("#txt_em").val();
				$.ajax({
		            url:"http://checkroom.cl/audisis/App_ModuloPerfilUsuario/ModificarContrasenia", 
		            method: "POST",
		            data: "pass="+pass2+"&mail="+email+"&usuario="+idUsu,
		            success: function(data) {
		            	if(data.match("1")){
		            		window.location = "http://checkroom.cl/audisis/login/change";
		            	}else{	
		            		alertify.error("Error Desconocido");
		            	}
		            }
		        });
			}else{
				alertify.error("La contraseña tiene que tener un minimo de 6 caracteres");
			}
		}else{
			alertify.error("La nueva contraseña no concuerda");
		}
	}else{
		alertify.error("No estan escritas las contraseñas");
	}

}