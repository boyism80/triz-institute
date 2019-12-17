$.fn.enumerateProducts = function (data, option, callback) {

	var $self 					= $(this).addClass('enumerate-list');

	$(data).each(function () {

		var $li 				= $('<li class="item"></li>').appendTo($self);
		var $link 				= $('<a></a>').attr('href', option.baseurl + option.link + '?index=' + this.idx).appendTo($li);
		
		var $thumb 				= $('<div class="thumb"></div>').appendTo($link);
		var $thumbImage 		= $('<img>').attr({src: this.thumb}).appendTo($thumb);

		var $custom				= $('<div class="custom"></div>').appendTo($link);
		var $nameLink 			= $('<div class="name"></div>').text(this.name).appendTo($custom);

		if(option.size != undefined && option.size.thumb != undefined)
			$thumb.css(option.size.thumb);

		if(option.size != undefined && option.size.custom != undefined)
			$custom.css(option.size.custom);

		if(callback != undefined)
			callback(this, $custom);
	} );

	return $self;
}