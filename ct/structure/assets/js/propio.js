function accionModal(id, c, entidad){
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
