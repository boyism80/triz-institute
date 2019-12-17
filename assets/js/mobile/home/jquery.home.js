let $activated = null;

function updateCurrentTab() {

	let $current = null;
	let top = $(document).scrollTop();
	$('.menu-items').each(function () {

		$current = $(this);
		if(top < $(this).offset().top)
			return false;
	} );

	if($activated == $current.prev().text())
		return;

	$activated = $current.prev().text();

	$('.menu-state-items > li').removeAttr('focus');
	$('.menu-state-items > li[name="' + $activated + '"]').attr('focus', '');

}
$(document).on("pageshow",function(event,data){

	setInterval(function() {
		updateCurrentTab();
	}, 20);

	$('.menu-state-items > li').each(function () {

		$(this).bind('click', function () {

			let name = $(this).children('a').text();
			let offset = $('.menu-right > .menu-title[name="' + name + '"]').offset(); 

			$('html, body').animate({scrollTop : offset.top}, 'fast');
		} );
	} );
});