$.fn.productTab = function () {

	var $self				= $(this).addClass('product-tab');
	var $ul					= $self.find('.product-tab-list');
	var $li 				= $ul.children('li');


	$self.hideContent		= function () {

		$self.find('.product-tab-content').children('*').css('display', 'none');
		return $self;
	}

	$self.showContent		= function (target) {

		$self.find('.product-tab-content').children(target).css('display', '');
		return $self;
	}

	$self.unselect			= function () {

		$li.removeAttr('selected');
		$self.hideContent();
		return $self;
	}

	$self.select 			= function (target) {

		$self.unselect();
		$self.showContent(target);
		$li.filter('li[target="' + target + '"]').attr('selected', '');

		return $self;
	}


	// Register event handler of 'li' tag
	$li.bind('click', function () {

		var target			= $(this).attr('target');
		if(target == undefined)
			return;
			
		$self.select(target);
	} );

	$self.hideContent().select($li.first().attr('target'));

	return $self;
}