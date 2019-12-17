$(document).on('pageinit', function(){       
	
	$('.member-list > li .visible-area').bind('click', function () {

		$(this).siblings('.hidden-area').slideToggle('slow');
	} );
});