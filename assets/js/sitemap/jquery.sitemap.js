$.fn.sitemap = function (menu) {

	var $self			= $(this);
	$self.mlist			= $('<ul class="category-list"></ul>').appendTo($self);

	$(menu).each(function () {

		var $mitem 		= $('<li class="category-item"></li>').appendTo($self.mlist);
		for(var key in this['@attributes'])
			$mitem.attr(key, this['@attributes'][key]);

		$('<a></a>').attr('href', this['@attributes']['link']).text(this['@attributes']['name']).appendTo($mitem);

		var subitems	= this.subitem;
		var $sublist 	= $('<ul class="submenu-list"></ul>').appendTo($mitem);
		$(subitems).each(function () {

			var $subitem 	= $('<li class="submenu-item"></li>').appendTo($sublist);
            $('<a></a>').attr('href', this['@attributes']['link']).text(this['@attributes']['name']).appendTo($subitem);
		} );
	} );

	return $self;
}