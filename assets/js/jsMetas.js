 //Buscar locales metas
function buscarLocalesMetas(){
    var fechas = $("#txt_fechas").val();
    if($("#txt_fechas").val()!=''){   
        $.ajax({
	        url: "CbuscarLocalesMetas",
	        type: "POST",
	        data: "fechas="+fechas,
	        success: function(data){
	        	if(data!=""){
	        		$("#metas").html('');
	    			$("#metas").hide("slow");
	        		$("#txt_local").html('');
                    $("#txt_local").html("<option value=''>Elegir Local</option>");  
                    $("#txt_local").append(data);
	        		$("#div_local").show("slow");
	        	}else{
	        		$("#metas").html('');
	    			$("#metas").hide("slow");
	        		$("#txt_local").html('');
	        		$("#txt_local").html("<option value=''>Sin Local</option>");  
	        		$("#div_local").hide("slow");
	        	}
	        }
        }); 
    }else{
    	$("#metas").html('');
	    $("#metas").hide("slow");
        $("#txt_local").html('');
		$("#txt_local").html("<option value=''>Sin Local</option>");  
		$("#div_local").hide("slow");   
    }
}

 //Buscar locales metas
function buscarLocalesMetasMovil(){
    var fechas = $("#txt_fechas").val();
    if($("#txt_fechas").val()!=''){   
        $.ajax({
	        url: "CbuscarLocalesMetasMovil",
	        type: "POST",
	        data: "fechas="+fechas,
	        success: function(data){
	        	if(data!=""){
	    			$("#metas").hide("slow");
	        		$("#txt_local").html('');
                    $("#txt_local").html("<option value=''>Elegir Local</option>");  
                    $("#txt_local").append(data);
	        		$("#div_local").show("slow");
	        	}else{
	        		$("#metas").html('');
	    			$("#metas").hide("slow");
	        		$("#txt_local").html('');
	        		$("#txt_local").html("<option value=''>Sin Local</option>");  
	        		$("#div_local").hide("slow");
	        	}
	        }
        }); 
    }else{
	    $("#metas").hide("slow");
        $("#txt_local").html('');
		$("#txt_local").html("<option value=''>Sin Local</option>");  
		$("#div_local").hide("slow");   
    }
}

 //Mostrar Dash
function mostrarDashMetas(){
    var fechas = $("#txt_fechas").val();
    var local = $("#txt_local").val();
    if($("#txt_local").val()!=''){   
        $.ajax({
	        url: "CListarDashMetas",
	        type: "POST",
	        data: "fechas="+fechas+"&local="+local,
	        success: function(data){
	        	if(data!=""){
	        		$("#metas").html(''); 
                    $("#metas").append(data);
	        		$("#metas").show("slow");
	        	}else{
	        		$("#metas").html('');
	        		$("#metas").hide("slow");
	        	}
	        }
        }); 
    }else{
        $("#metas").html('');
	    $("#metas").hide("slow");  
    }
}