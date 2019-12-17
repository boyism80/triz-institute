$(document).on("pageshow",function(event,data){

	$('#submit').bind('click', function () {

		$('form[name="form-login"]').submit();
	} );
});