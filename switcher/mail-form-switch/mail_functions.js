/*CONTACTAR SWITCH*/
$(function() {
	$("button#SwitchContactSubmit").click(function(){
		var hasErrors = $('#SwitchForm').validator('validate').has('.has-error').length
		if (hasErrors){
			
		}else{
			var Form = $('#SwitchForm');
			var FormParams = {};
			$.each(Form[0].elements, function(index, elem){			
				FormParams[elem.name] = {};
				FormParams[elem.name]['showtitle'] = $(elem).attr('showtitle');
				FormParams[elem.name]['value'] = elem.value;
			});
			$('#ajaxResult-ContactForm').html('<div class="loading">Enviando mensaje...</div>');
			
			$.ajax({
				type: "POST",
				url: "switcher/mail-form-switch/mail_send.php",
				data: FormParams,
				success: function(msg){
					$("#ajaxResult-ContactForm").html(msg);
				},
				error: function(){
					alert("Error: #45SDEF234SDF");
				}
			});
		}
	});
});