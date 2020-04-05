function accionModal(id, c, entidad){
	$('#modalContent').html(
	'<div class="modal-header">'+
		'<h5 class="modal-title" id="exampleModalLongTitle">Operación en Curso</h5>'+
		'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
			'<span aria-hidden="true">&times;</span>'+
		'</button>'+
	'</div>'+
	'<div class="modal-body">'+
		'<div class="col-sm-10 offset-md-1">'+
			'<div class="loading" style="width:242px;margin:auto;"><img src="../Assets/images/loader.gif" alt="loading" /><br/>Construyendo. Por favor, espere.</div>'+
		'</div>'+
	'</div>'+
	'<div class="modal-footer">'+
		'<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancelar</button>'+
	'</div>');
	$.ajax({
		type: 'POST',
		data: {"id": id,
			"c": c,
		},
		url: "../ct/"+entidad+"Controller.php",
		success: function(result){
			if(c=='cs'){
				window.location.replace("../index.php");
			} else {
				$("#modalContent").html(result);
			}
	    }

	});

}

function actionNavigate(id, entidad){
	$.ajax({
		type: 'POST',
		data: {
			"id": id,
			"c": 'ie'
		},
		url: "../ct/"+entidad+"Controller.php",
		success: function(result){
			
			window.location.replace("../ct/"+entidad+"Controller.php");
			
        }
	});

}

function ajaxEntidades(){
	if($("#Tipo").val()=="8"){
	    $.ajax({
			type: 'POST',
			data: { 
				"c":'em'
			},
			url: "../ct/EntidadController.php", 
			success: function(result){
		        $("#inputEntidades").html(result);
				ajaxCampos($('#inputEntidades').val())
		    }
		});
		$("#inputEntidades").prop('disabled', false);
	} else {
		$("#inputEntidades").prop('disabled', 'disabled');
		$("#inputEntidades").html('');
		$("#inputCampoMostrar").prop('disabled', 'disabled');
		$("#inputCampoMostrar").html('');
	}
	if($("#Tipo").val()=="1" || $("#Tipo").val()=="4" || $("#Tipo").val()=="6"){
		$("#longInput").prop('disabled', false);
		$("#longInput").prop('required', false);
	} else {
		$("#longInput").prop('disabled', 'disabled');
		$("#longInput").prop('required', 'required');
	}
} 

function ajaxCampos(Entidad){
            
    $.ajax({
		type: 'POST',
		data: { 
			"idEntidad": Entidad,
			"c":'cm'
		},
		url: "../ct/CampoController.php", 
		success: function(result){
        	$("#inputCampoMostrar").html(result);
    	}
	});
	$("#inputCampoMostrar").prop('disabled', false);
	

}
