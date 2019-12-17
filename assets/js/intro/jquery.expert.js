$.fn.experts = function (data) {

	var $self				= $(this);
	var $ul					= $('<ul class="border-list"></ul>').appendTo($self);

	$self.add 				= function (item) {

		var $li 			= $('<li class="content-group"></li>').appendTo($ul);
		var $title			= $('<div class="content-group-title"></div>').text(item['@attributes']['name']).appendTo($li);

		var $abouts			= $('<ul class="about-list"></ul>').appendTo($li);
		$(item.item).each(function () {

			var $about 		= $('<li class="about"></li>').attr({name: this['@attributes']['name'], image: this['@attributes']['img']}).appendTo($abouts);
			var $image		= $('<div class="about-image"></div>').appendTo($about);
			$('<img>').attr('src', this['@attributes']['img']).appendTo($image);
			$('<div class="about-name"></div>').text(this['@attributes']['name']).appendTo($image);

			var $intros		= $('<ul class="about-intro hypen-list"></ul>').appendTo($about);
			for(var i = 0; i < this.p.length; i++) {

				$('<li></li>').text(this.p[i]).appendTo($intros);
			}
		} );
		return $self;
	}

	$(data).each(function () {

		$self.add(this);
	} );

	return $self;
}