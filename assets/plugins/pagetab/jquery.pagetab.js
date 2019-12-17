$.fn.pagetab = function (data) {
	if(data == undefined)
		data                = {};
	if(data.image == undefined)
		data.image 			= {};
	if(data.maxTabs == undefined)
		data.maxTabs        = 10;
	if(data.maxViews == undefined)
		data.maxViews       = 10;
	if(data.maxNums == undefined)
		data.maxNums		= 0;
	if(data.callback == undefined)
		data.callback       = function (page) {}

	var $self 				= $(this).attr({ current: 1 }).addClass('pagetab');
    // save data
    var $first              = $('<a class="icon first"></a>').appendTo($self);
    var $prev               = $('<a class="icon prev"></a>').appendTo($self);
    var $next               = $('<a class="icon next"></a>').appendTo($self);
    var $last               = $('<a class="icon last"></a>').appendTo($self);
    $('<img>').attr('src', data.image.first).appendTo($first);
    $('<img>').attr('src', data.image.prev).appendTo($prev);
    $('<img>').attr('src', data.image.next).appendTo($next);
    $('<img>').attr('src', data.image.last).appendTo($last);
    

    $self.update = function (page, maxNums) {



    	$self.pagenum		= Math.max(1, Math.ceil(maxNums / data.maxViews));
    	$self.setrange(1, data.maxTabs);
    	$self.mask(page);
    	return $self;
    }

    $self.setrange = function (begin, end) {
        // Reset end parameter
        end                 = Math.min(end, $self.pagenum);
        // Remove previous boards
        $self.children('.element').remove();
        // Reset range
        var count 			= end - begin + 1;
        $self.range			= {begin: begin, end: begin + count - 1};
        // Append page elements
        for(var i = 0; i < count; i++) {
        	var $element    = $('<a class="element"></a>').attr({page: i + begin }).text(i + begin).insertBefore($next);
        	$element.bind('click', function () {
        		var clickpage = parseInt($(this).attr('page'));
        		if (onclick != null)
        			onclick(clickpage);

        		$self.select(clickpage);
        	});
        }
        return $self;
    }
    $self.mask = function (page) {
    	page                = Math.max(1, page);
    	page                = Math.min($self.pagenum, page);
    	var range 			= $self.range;
    	if (page < range.begin || page > range.end) {
    		var newbegin    = Math.floor((page - 1) / (data.maxTabs)) * data.maxTabs + 1;
    		var newend      = newbegin + data.maxTabs - 1;

    		$self.setrange(newbegin, newend);
    	}
    	$self.children('.element').removeAttr('selected');
    	$self.children('.element[page=' + page + ']').attr('selected', '');
    	$self.current 		= page;
    	return $self;
    };
    // add method
    $self.select = function (page) {
    	page                = Math.max(1, page);
    	page                = Math.min($self.pagenum, page);
    	$self.mask(page);
    	data.callback(page);
    };
    $self.currentpage = function () {
    	return $self.current;
    };
    $self.maxViews = function () {
    	return data.maxViews;
    };
    $self.range = function () {
    	return $self.range;
    };
    // append event handler
    $first.bind('click', function () {
    	$self.select(1);
    });
    $last.bind('click', function () {
    	$self.select($self.pagenum);
    });
    $prev.bind('click', function () {
    	$self.select($self.range.begin - 1);
    });
    $next.bind('click', function () {
    	$self.select($self.range.end + 1);
    });

    return $self;
}