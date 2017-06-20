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