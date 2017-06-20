function deleteItem(content,id,name){
	var message = 'Estas seguro que deseas eliminar el registro:<br/><strong>"'+name+'"</strong>';

	swal({   
		html:true,
		title: '¿Deseas eliminar?',   
		text: message,   
		type: "warning",   
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Eliminar",
		closeOnConfirm: false 
	}, function(){   
		$('#fullscreenloading').show();
		var file = 'ajax_'+content+'.php';
		var thisAction = "delete";

		if (content == "restaurantUsers") {
			thisAction = "deleteUser";
			file = 'ajax_restaurante.php';
		}

		$.post(file, {action: thisAction,id:id}, function( returned ) {
			$('#fullscreenloading').hide();
			if(returned == 'success'){
				$('table tr#'+id).remove();
				swal({   
					html:true,
					title: 'Eliminado!',   
					text: 'El registro <br/><strong>"'+name+'"</strong><br/> ha sido eliminado correctamente.',   
					type: 'success',
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "Cerrar",
					closeOnConfirm: false 
				});
			}else{
				swal({   
					html:true,
					title: "Error",   
					text: "Ha ocurrido un error al guardar en la base de datos:<br/>"+returned,   
					type: "error",
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "Cerrar",
					closeOnConfirm: false 
				});
			}
		}, "json");
	});
}

function UpdateArticleStatus(art, stat) {
	$.ajax({
		data: { articleId : art, statusId : stat },
		type: 'GET',
		url: 'controllers/UpdateArticleStatus.php',
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function (data) {
			swal({
				html:true,
				title: 'Guardado!',   
				text: 'El status del artículo ha sido modificado correctamente.',   
				type: 'success',
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Cerrar",
				closeOnConfirm: false 
			}, function(){   
				$('.sweet-alert').hide();
				$('.sweet-overlay').hide();
				$('#fullscreenloading').show();
				location.reload();
			});
		},
		error: function (xhr, status){
			var err = eval("(" + xhr.responseText + ")");
			alert("Error" + err.Message);
		}
	});

}

/*MODAL CALL*/
function modalCall(content,action,id,args){
	if (typeof args == 'undefined') { 
		args = '';
	}
	var file = 'ajax_'+content+'.php';
	$('#modal-001').html('Cargando');
	$("#modal-001").modal('toggle')
	$('#modal-001').modal('show');
		
	$.post(file, {action:action,id:id,args:args}, function( returned ) {
		$('#modal-001').html( returned );
	});
};

/*MODAL FORMS*/
$('#modalForm').on('keyup change', 'input, select, textarea', function(){
	$("#submitButton").addClass('btn-danger');
	$("#submitButton").html('<i class="fa fa-save m-r-5"></i> <span>Guardar</span>');
	$("#submitButton").attr("disabled", false);
});

function submitModalForm(content) {
	$('#modalForm').parsley().validate();

	if (content == "menudeldia") {
		var restaurantId = $('#modalForm #RestaurantId').val();
	}

	if ($('#modalForm').parsley().isValid()){
		$('#fullscreenloading').show();
		$("#submitButton").html('<i class="fa fa-check m-r-5"></i> <span>Guardando...</span>');
		$.ajax({
			type: "POST",
			url: 'ajax_'+content+'.php',
			data: $('#modalForm').serialize(),
			dataType: "json",
			success: function (data) {
				$('#fullscreenloading').hide();
				if(data == "exito"){
					$('#modal-001').modal('hide');
					$('#fullscreenloading').hide();
					swal({   
						title: "Guardado",   
						text: "Tus cambios han sido guardados correctamente.",   
						type: "success",
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "Cerrar",
						closeOnConfirm: false 
					}, function(){   
						$('.sweet-alert').hide();
						$('.sweet-overlay').hide();
						$('#fullscreenloading').show();
						location.reload();
					});
				}else{
					$('#modal-001').modal('hide');
					$('#fullscreenloading').hide();
					swal({   
						html:true,
						title: "Error",   
						text: "Ha ocurrido un error al guardar en la base de datos:<br/>"+data,   
						type: "error",
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "Cerrar",
						closeOnConfirm: false 
					});
				}
			},
			error: function(){
				$('#fullscreenloading').hide();
				alert("Error #EJS3432");
			}
		});
	}
};


/*PAGE FORMS*/
$('#pageForm').on('keyup change', 'input, select, textarea', function(){
    $("#submitButton").addClass('btn-danger');
	$("#submitButton").html('<i class="fa fa-save m-r-5"></i> <span>Guardar</span>');
	$("#submitButton").attr("disabled", false);
});

function submitPageForm(content){
	$('#pageForm').parsley().validate();
	if ($('#pageForm').parsley().isValid()){
		$('#fullscreenloading').show();
		$("#submitButton").html('<i class="fa fa-check m-r-5"></i> <span>Guardando...</span>');
		$.ajax({
			type: "POST",
			url: 'ajax_'+content+'.php',
			data: $('#pageForm').serialize(),
			dataType: "json",
			success: function (data) {
				$('#fullscreenloading').hide();
				if(data == 'exito'){
					$('#fullscreenloading').hide();
					swal({   
						title: "Guardado",   
						text: "Tus cambios han sido guardados correctamente.",   
						type: "success",
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "Cerrar",
						closeOnConfirm: false 
					}, function(){   
						$('.sweet-alert').hide();
						$('.sweet-overlay').hide();
						$('#fullscreenloading').show();
						location.reload();
					});
				}else{
					$('#fullscreenloading').hide();
					swal({   
						html:true,
						title: "Error",   
						text: "Ha ocurrido un error al guardar en la base de datos:<br/>"+data,   
						type: "error",
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "Cerrar",
						closeOnConfirm: false 
					});
				}
			},
			error: function(){
				$('#fullscreenloading').hide();
				alert("Error #EJDESD$23432");
			}
		});
	}
};