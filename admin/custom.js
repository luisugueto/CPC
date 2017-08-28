// JavaScript Custom Template
/*jQuery(document).ready(function($) {
	jQuery('.counter').counterUp({
		delay: 100,
		time: 1200
	});

	jQuery(".knob").knob();

});*/


//PICKERS
/*jQuery(document).ready(function() {
	//colorpicker start
	jQuery('.colorpicker-default').colorpicker({
		format: 'hex'
	});
	jQuery('.colorpicker-rgba').colorpicker();

	// Date Picker
	jQuery('#datepicker').datepicker();
	jQuery('#datepicker-autoclose').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
	jQuery('.datepicker-autoclose').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
});*/
//$('#editableTable').editableTableWidget().numericInputExample().find('td:first').focus();
//PICKERS

//Parsleyjs
$(document).ready(function() {
	$('form').parsley();
});
//Parsleyjs
        
		
		
//tinymce
$(document).ready(function () {
	if($("#TextEditorA").length > 0){
		tinymce.init({
			selector: "textarea#TextEditorA",
			theme: "modern",
			height:300,
			plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"save table contextmenu directionality emoticons template paste textcolor"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
			style_formats: [
				{title: 'Parrafo', block: 'p'},
				{title: 'Header 1 (H1)', block: 'h1'},
				{title: 'Header 2 (H2)', block: 'h2'},
				{title: 'Header 3 (H3)', block: 'h3'},
				{title: 'Header 4 (H4)', block: 'h4'},
				{title: 'Header 5 (H5)', block: 'h5'}
			]
		});
	}
});
//tinymce
