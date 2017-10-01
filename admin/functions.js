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

function deleteItemType(content,id,name,type){
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
		var thisAction = type;

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
				location.reload();
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
	var modal = $('#modal-001');
	modal.html('Cargando');
	modal.modal('toggle')
	modal.modal('show');

	$.post(file, {action:action,id:id,args:args}, function( returned ) {
		modal.html( returned );
	});
};

/*MODAL FORMS*/
$('#modalForm').on('keyup change', 'input, select, textarea', function(){
	$("#submitButton").addClass('btn-danger');
	$("#submitButton").html('<i class="fa fa-save m-r-5"></i> <span>Guardar</span>');
	$("#submitButton").attr("disabled", false);
});

$('#uploadimage').on('keyup change', 'input, select, textarea', function(){
	$("#uploads").addClass('btn-danger');
	$("#uploads").html('<i class="fa fa-save m-r-5"></i> <span>Guardar</span>');
	$("#uploads").attr("disabled", false);
});

$('#comentarioForm').on('keyup change', 'input, select, textarea', function(){
	$("#submitComentario").addClass('btn-danger');
	$("#submitComentario").html('<i class="fa fa-save m-r-5"></i> <span>Guardar</span>');
	$("#submitComentario").attr("disabled", false);
});

$('#modalSubCategorias').on('keyup change', 'input, select, textarea', function(){
	$("#submitSubCategorias").addClass('btn-danger');
	$("#submitSubCategorias").html('<i class="fa fa-save m-r-5"></i> <span>Guardar</span>');
	$("#submitSubCategorias").attr("disabled", false);
});

function submitVideoModalForm(content) {
	$('#modalForm').parsley().validate();

	if ($('#modalForm').parsley().isValid()){
		$('#fullscreenloading').show();
		$("#submitButton").html('<i class="fa fa-check m-r-5"></i> <span>Guardando...</span>');

		var formElement = document.getElementById("modalForm");
		formData = new FormData(formElement);

		$.ajax({
			url: 'ajax_'+content+'.php',
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(data){
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
				console.log($('#modalForm').serialize());
				$("#submitButton").html('<i class="fa fa-check m-r-5"></i> <span>Guardar</span>');
				alert("Error #EJS3432");
			}
		});
	}
};

function submitModalForm(content) {
	$('#modalForm').parsley().validate();

	if ($('#modalForm').parsley().isValid()){
		$('#fullscreenloading').show();
		$("#submitButton").html('<i class="fa fa-check m-r-5"></i> <span>Guardando...</span>');

		$.ajax({
			type: "POST",
			url: 'ajax_'+content+'.php',
			data: $("#modalForm").serialize(),
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
				console.log($('#modalForm').serialize());
				$("#submitButton").html('<i class="fa fa-check m-r-5"></i> <span>Guardar</span>');
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

$("#uploads").on("click", function(){
		var formData = new FormData($("#uploadimage")[0]);
		var ruta = "ajax_gallery.php";
		$('#fullscreenloading').show();
		$("#uploads").html('<i class="fa fa-check m-r-5"></i> <span>Guardando...</span>');
		$.ajax({
				url: ruta,
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(data)
				{
					$('#fullscreenloading').hide();
					if(data === "exito"){
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
					alert("Error #EJDESD$23432");
				}
		});
});

$("#submitComentario").on("click", function(){
	$('#comentarioForm').parsley().validate();

	if ($('#comentarioForm').parsley().isValid()){
		var formData = new FormData($("#comentarioForm")[0]);
		var ruta = "ajax_comentario.php";
		$('#fullscreenloading').show();
		$("#submitComentario").html('<i class="fa fa-check m-r-5"></i> <span>Guardando...</span>');
		$.ajax({
				url: ruta,
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(data)
				{
					$('#fullscreenloading').hide();
					if(data === "exito"){
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
					alert("Error #EJDESD$23432");
				}
		});
	}
});

$("#submitSubCategorias").on("click", function(){
	$('#modalSubCategorias').parsley().validate();

	if ($('#modalSubCategorias').parsley().isValid()){
		var formData = new FormData($("#modalSubCategorias")[0]);
		var ruta = "ajax_subcategorias.php";
		$('#fullscreenloading').show();
		$("#submitSubCategorias").html('<i class="fa fa-check m-r-5"></i> <span>Guardando...</span>');

		var contentSubCategory = CKEDITOR.instances["ckEditorText"].getData();
		formData.append('txtContent', contentSubCategory);

		if ($("#imgSlide").val() != "") {

			$('#previewImage').cropper('getCroppedCanvas').toBlob(function (blob) {
				formData.append('croppedImage', blob);
				$.ajax(ruta, {
					method: "POST",
					data: formData,
					processData: false,
					contentType: false,
					success: function(data)
					{
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
					}
				});
			});
		} else {
			$.ajax(ruta, {
				method: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: function(data)
				{
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
				}
			});
		}
	}
});

$("#submitDoctorDescription").on("click", function(){
	$('#modalDescriptionDoctor').parsley().validate();

	if ($('#modalDescriptionDoctor').parsley().isValid()){
		var formData = new FormData($("#modalDescriptionDoctor")[0]);
		var ruta = "ajax_medicos.php";
		$('#fullscreenloading').show();
		$("#submitDoctorDescription").html('<i class="fa fa-check m-r-5"></i> <span>Guardando...</span>');

		var contentDoctor = CKEDITOR.instances["ckEditorText"].getData();
		formData.append('txtDescription', contentDoctor);

		$.ajax(ruta, {
			method: "POST",
			data: formData,
			processData: false,
			contentType: false,
			success: function(data)
			{
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
			}
		});
	}
});