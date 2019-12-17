$.fn.basetab = function (data) {

	var $self				= $(this).addClass('basetab');
	var $ul					= $('<ul class="basetab-list"></ul>').appendTo($self);

	$self.add 				= function (item) {

		var $li				= $('<li class="basetab-item"></li>').appendTo($ul);
		var $link			= $('<a></a>').text(item['@attributes']['name']).attr('href', item['@attributes']['link']).appendTo($li);

		return $self;
	}

	$(data).each(function () {
		$self.add(this);
	} );

	return $self;
}

$.fn.defmenu = function (data) {

	var $self				= $(this).addClass('menutab-def');
	var $ul					= $('<ul></ul>').appendTo($self);
	
	$(data).each(function () {

		var $item 			= $('<li class="navitem highlight-color"></li>').appendTo($ul);
		for(var key in this['@attributes'])
			$item.attr(key, this['@attributes'][key]);
		
		var $link 			= $('<a></a>').text(this['@attributes']['name']).attr('href', this['@attributes']['link']).appendTo($item);

		var $subitemList 	= $('<ul class="highlight-background sublist"></ul>').appendTo($item);
		
		$(this.subitem).each(function () {
			
			var $subitem 	= $('<li class="subitem"></li>').appendTo($subitemList);
			var $link 		= $('<a></a>').attr('href', this['@attributes']['link']).text(this['@attributes']['name']).appendTo($subitem);
		} );

		$item.hover(function () {

			$item.attr('hover', '');
			$item.addClass('highlight-background');
			$item.removeClass('highlight-color');
			
			if ($item.position().left + $subitemList.width() > $ul.width()) {

				var prevWidth 		= $subitemList.width();
				$subitemList.css('right', 0);
				
				var currentWidth 	= $subitemList.width();
				$subitemList.css('margin-left', currentWidth - prevWidth);
			}
			else {
				$subitemList.css('left', 0);
			}
			
		}, function () {
			
			$item.removeAttr('hover');
			$item.removeClass('highlight-background');
			$item.addClass('highlight-color');
			$subitemList.removeAttr('style');
		} );
	});

	return $self;
}

$.fn.extmenu = function (data) {

	var $self           = $(this).addClass('menutab-ext');
	var $ul             = $('<ul class="navlist"></ul>').appendTo($self);


	$(data).each(function () {

		var $item       = $('<li class="navitem"></li>').appendTo($ul);
		for(var key in this['@attributes'])
			$item.attr(key, this['@attributes'][key]);

		
		var $tab        = $('<div class="tab"></div>').appendTo($item);
		$('<a></a>').attr('href', this['@attributes']['link']).text(this['@attributes']['name']).appendTo($tab);
		var $sublist    = $('<ul class="sublist"></ul>').appendTo($item);

		$(this['subitem']).each(function () {

			var $item   = $('<li class="subitem"></li>').appendTo($sublist);
			var $anchor = $('<a></a>').attr('href', this['@attributes']['link']).text(this['@attributes']['name']).appendTo($item);
		} );
	} );

    // Set maximum height
    var maxHeight       = 0;
    $ul.find('.sublist').each(function () {

    	var height      = $(this).height();
    	if(maxHeight < height)
    		maxHeight   = height;
    } );
    $ul.find('.sublist').height(maxHeight);


    // Set each width
    $ul.children('.navitem').each(function () {
    	
    	var $item           = $(this);
    	var $subitemList    = $item.children('.sub-menu-list');
    	
        // Update max width
        var maxWidth        = Math.max($item.outerWidth(), $subitemList.outerWidth()) + 2;
        $item.outerWidth(maxWidth);
        $subitemList.outerWidth(maxWidth);
        
        var $item           = $(this);
        var $subitemList    = $item.children('.sub-menu-list');
        
        // Update max width
        var maxWidth        = Math.max($item.outerWidth(), $subitemList.outerWidth()) + 2;
        $item.width(maxWidth);

        $(this).width($(this).width());
        // Update max height
        maxHeight           = Math.max(maxHeight, $subitemList.height());

        // Update max height
        maxHeight           = Math.max(maxHeight, $subitemList.height());
    } );


    // Mouse active event
    $ul.hover(function () {

    	$ul.find('.sublist').css('display', '');
    	console.log($ul.height());
    }, function () {

    	$ul.find('.sublist').css('display', 'none');
    	console.log($ul.height());
    } ).trigger('mouseleave');

    return $self;
}