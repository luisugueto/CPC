/* ---------------------------------------------------- */
/* --------------- VARIABLES GLOBALES ----------------- */
/* ---------------------------------------------------- */

	var Loader = $("#fullscreenloading");

/* ---------------------------------------------------- */
/* --------------- VARIABLES GLOBALES ----------------- */
/* ---------------------------------------------------- */




/* ---------------------------------------------------- */
/* ---------------- INICIAR SESIÓN -------------------- */
/* ---------------------------------------------------- */

	$('#loginForm').on('submit', function(e) {
		Loader.fadeIn(500);
		var frm = e.target;
		var remember = "0";

		if ($("#login_remember").is(':checked')) {
			remember = "1";
		}

		var formData = new FormData(frm);
		formData.append("remember", remember);

		$.ajax({
			url: "controllers/Login.php",
			type: "POST",
			data: formData,
			contentType: false,
			cache: false,
			processData:false,
			success: function(data)
			{
				if (data == "exito") {
					Loader.fadeOut(500);
					window.location.href = "index.php"
				} else if (data == "error") {
					Loader.fadeOut(500);
					$('#login-alert').fadeIn(500);
					$('#login-alert').text("Su contraseña o correo es incorrecto");
				} else {
					Loader.fadeOut(500);
					$('#login-alert').fadeIn(500);
					$('#login-alert').text("Ha ocurrido un error, por favor intentelo nuevamente o contacte a soporte.");
				}
			}
		});

		return false;
	});

	$('#recoveryForm').on('submit', function(e) {
		$("#fullscreenloading").fadeIn(500);
		$('#success-alert').fadeOut(500);
		$('#login-alert').fadeOut(500);
		var frm = e.target;
		var formData = new FormData(frm);
		var email = e.target[0].value;

		$.ajax({
			url: "controllers/RecoverPassword.php",
			type: "POST",
			data: formData,
			contentType: false,
			cache: false,
			processData:false,
			success: function(data)
			{
				if (data == "exito") {
					$("#fullscreenloading").fadeOut(500);
					$('#success-alert').fadeIn(500);
					$('#strong-email').text(email);
				} else {
					$("#fullscreenloading").fadeOut(500);
					$('#login-alert').fadeIn(500);
					$('#login-alert').text("No existe ninguna cuenta asociada a este correo electrónico.");
				}
			}
		});

		return false;
	});

/* ---------------------------------------------------- */
/* ---------------- INICIAR SESIÓN -------------------- */
/* ---------------------------------------------------- */


/* ---------------------------------------------------- */
/* ---------------- CREAR ARTÍCULO -------------------- */
/* ---------------------------------------------------- */

	function CreateArticle(frm) {
		var Title = $("#txtTitle").val();
		var Author = $("#hdAuthor").val();
		var ErrorMsg = $("#errorMsg");
		var MetaDescription = $("#txtMetaDescription").val();
		var Contenido = "";
		var Slug = $("#slug-article").val();
		var MetaTitle = $("#txtMetaTitle").val();
		var PublishDate = $("#txtPublishDate").val();
		var ImageFile = $("#imgSlide").val();

		if (Title == "") {
			ErrorMsg.fadeIn(500);
			ErrorMsg.html("<i class='fa fa-exclamation-triangle'></i> Debe ingresar un título.");
			return false;
		}
		if (CKEDITOR.instances["txtContent"].getData() == "") {
			ErrorMsg.fadeIn(500);
			ErrorMsg.html("<i class='fa fa-exclamation-triangle'></i> Debe ingresar el contenido de su noticia/artículo.");
			return false;
		}
		else {
			Contenido = CKEDITOR.instances["txtContent"].getData();
		}
		if (MetaDescription == "") {
			ErrorMsg.fadeIn(500);
			ErrorMsg.html("<i class='fa fa-exclamation-triangle'></i> Debe ingresar un texto introductorio.");
			return false;
		}
		if (MetaTitle == "") {
			MetaTitle = Title;
		}

		var checkboxes = $("input:checked[name=categoryCheck]");
		var categories = [];

		for (var i = 0; i < checkboxes.length; i++) {
			categories.push(checkboxes[i].value);
		};

		if (categories.length == 0) {
			ErrorMsg.fadeIn(500);
			ErrorMsg.html("<i class='fa fa-exclamation-triangle'></i> Debe seleccionar al menos una categoría.");
			return false;
		}

		var status = "0";

		if ($("#chkStatus").is(":checked")) {
			status = "1";
		} else {
			status = "2";
		}

		var cat_array = JSON.stringify(categories);

		if (ImageFile == "") {
			ErrorMsg.fadeIn(500);
			ErrorMsg.html("<i class='fa fa-exclamation-triangle'></i> Debe seleccionar una foto principal para el artículo.");
			return false;
		}

		ErrorMsg.fadeOut(500);
		$('#fullscreenloading').show();

		if (ImageFile != "") {
			$('#previewImage').cropper('getCroppedCanvas').toBlob(function (blob) {
				var formData = new FormData(frm);
				formData.append('croppedImage', blob);
				formData.append("categories", cat_array);
				formData.append("status", status);
				formData.append("content", Contenido);

				$.ajax('controllers/CreateArticle.php', {
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
								window.location.href='articulos.php';
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
			var formData = new FormData(frm);
			formData.append("categories", cat_array);
			formData.append("status", status);
			formData.append("content", Contenido);

			$.ajax('controllers/CreateArticle.php', {
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
							window.location.href='articulos.php';
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

	function UpdateArticle(frm) {
		var ErrorMsg = $("#errorMsg");
		var Title = $("#txtTitle").val();
		var MetaDescription = $("#txtMetaDescription").val();
		var ArticleId = $("#hdArticleId").val();
		var ActualImage = $("#hdActualImage").val();
		var Slug = $("#slug-article").val();
		var MetaTitle = $("#txtMetaTitle").val();
		var Contenido = "";
		var PublishDate = $("#txtPublishDate").val();

		if (Title == "") {
			ErrorMsg.fadeIn(500);
			ErrorMsg.html("<i class='fa fa-exclamation-triangle'></i> Debe ingresar un título.");
			return false;
		}
		if (CKEDITOR.instances["txtContent"].getData() == "") {
			ErrorMsg.fadeIn(500);
			ErrorMsg.html("<i class='fa fa-exclamation-triangle'></i> Debe ingresar el contenido de su noticia/artículo.");
			return false;
		}
		else {
			Contenido = CKEDITOR.instances["txtContent"].getData();
		}
		if (MetaDescription == "") {
			ErrorMsg.fadeIn(500);
			ErrorMsg.html("<i class='fa fa-exclamation-triangle'></i> Debe ingresar un texto introductorio.");
			return false;
		}
		if (MetaTitle == "") {
			MetaTitle = Title;
		}

		var checkboxes = $("input:checked[name=categoryCheck]");
		var categories = [];

		for (var i = 0; i < checkboxes.length; i++) {
			categories.push(checkboxes[i].value);
		};

		if (categories.length == 0) {
			ErrorMsg.fadeIn(500);
			ErrorMsg.html("<i class='fa fa-exclamation-triangle'></i> Debe seleccionar al menos una categoría.");
			return false;
		}

		ErrorMsg.fadeOut(500);

		var status = "0";

		if ($("#chkStatus").is(":checked")) {
			status = "1";
		} else {
			status = "2";
		}

		var cat_array = JSON.stringify(categories);

		ErrorMsg.fadeOut(500);

		var ImageFile = $("#imgSlide").val();

		$('#fullscreenloading').show();

		if (ImageFile != "") {
			$('#previewImage').cropper('getCroppedCanvas').toBlob(function (blob) {
				var formData = new FormData(frm);
				formData.append('croppedImage', blob);
				formData.append("categories", cat_array);
				formData.append("status", status);
				formData.append("content", Contenido);

				$.ajax('controllers/UpdateArticle.php', {
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
		}
		else {
			var formData = new FormData(frm);
			formData.append("categories", cat_array);
			formData.append("status", status);
			formData.append("content", Contenido);

			$.ajax('controllers/UpdateArticle.php', {
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

/* ---------------------------------------------------- */
/* ---------------- CREAR ARTÍCULO -------------------- */
/* ---------------------------------------------------- */