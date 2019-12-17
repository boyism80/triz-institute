$.fn.extmenu = function (data) {

    console.log(data);

    var $self 				= $(this).addClass('menutab-ext');
    var $ul					= $('<ul class="menutab-list"></ul>').appendTo($self);

    $(data).each(function () {

        var $item 			= $('<li class="navitem highlight-color"></li>').appendTo($ul);
        var $link 			= $('<a></a>').text(this['@attributes']['name']).attr('href', this['@attributes']['link']).appendTo($item);
        var $subitemList 	= $('<ul class="sub-menu-list"></ul>').appendTo($item);

        $(this.subitem).each(function () {
        
            var $subitem 	= $('<li class="sub-menu-item"></li>').appendTo($subitemList);
            var $sublink 	= $('<a></a>').attr('href', this['@attributes']['link']).text(this['@attributes']['name']).appendTo($subitem);
        } );

        $item.hover(function () {
        
            $subitemList.attr('hover', '');
            $self.find('.sub-menu-list').css('visibility', 'visible');
        }, function () {
            
            $subitemList.removeAttr('hover');
            
            if($self.find('.sub-menu-list[hover]').length == 0)
                $self.find('.sub-menu-list').css('visibility', 'hidden');
        }).trigger('mouseleave');
    } );

    var maxHeight 			= 0;
    $ul.children('.navitem').each(function () {
    
        var $item 			= $(this);
        var $subitemList 	= $item.children('.sub-menu-list');
        
        // Update max width
        var maxWidth 		= Math.max($item.outerWidth(), $subitemList.outerWidth()) + 2;
        $item.outerWidth(maxWidth);
        $subitemList.outerWidth(maxWidth);

        // Update max height
        maxHeight 			= Math.max(maxHeight, $subitemList.height());
    } );


    $self.find('.sub-menu-list').height(maxHeight);
    return $self;
}

$.fn.previewBox = function (data) {

    var $self               = $(this).addClass('preview-box');

    $self.add               = function (name, board) {

        var $item           = $('<div class="preview-box-item"></div>').appendTo($self);
        var $name           = $('<div class="preview-box-name highlight-color"></div>').appendTo($item);
        var $link           = $('<a></a>').text(name.toUpperCase()).attr('href', board.link).appendTo($name);

        var $ul             = $('<ul></ul>').appendTo($item);
        $(board.data).each(function () {

            var $li         = $('<li class="preview-board-item"></li>').appendTo($ul);
            var $link       = $('<a class="preview-board-title"></a>').text(this.title).attr('href', board.link + '/' + this.idx).appendTo($li);
            var $date       = $('<span class="preview-board-date"></span>').text(this.date.split(' ')[0]).appendTo($li);
        } );
        return $self;
    }

    $.each(data, function (key, value) {

        $self.add(key, value);
    } );

    return $self;
}