$(document).on("pageshow", function(event,data) {

	$('#fqa-list').children('li').each(function () {

		let $item			= $(this);

		$item.bind('click', function () {

			$(this).children('.bot').slideToggle('fast');

			if($(this).attr('hidden') != undefined)
				$(this).removeAttr('hidden');
			else
				$(this).attr('hidden', '');
		} );
	} );
});