$.fn.iconBanner = function () {

	var $self			= $(this).addClass('icon-banner');

	// methods
	$self.items = function () {

		return $self.children('.item');
	}


	// Initialize
	var amount		= 0;
	$self.items().each(function () {

		$(this).css('left', amount);
		amount			+= $(this).width();
	} );

	return $self;
}