$.fn.thumbnailList = function (option) {

	var $self               = $(this);
	var $ul                 = $('<ul class="thumbnail-list"></ul>').appendTo($self);

	$self.add = function (url) {

		var $li = $('<li class="thumbnail-item"></li>').bind('click', function () {

			$self.select($(this));
		} ).appendTo($ul);
		var $image = $('<img />').attr('src', url).css({width: 50, height: 50}).appendTo($li);

		return $li;
	}

	$self.remove = function (url) {

		$self.find('.thumbnail-item > img[src="' + url + '"]').parent().remove();
	}

	$self.unselect = function () {

		$ul.children('.thumbnail-item').removeAttr('selected');
	}

	$self.select = function ($item) {

		if(typeof($item) == 'string')
			$item 			= $ul.find('img[src="' + $item + '"]').parent();

		$self.unselect();
		$item.attr('selected', '');
	}

	$self.selected = function () {

		return $self.find('.thumbnail-item[selected] img').attr('src');
	}

	return $self;
}