$.fn.itable = function (option) {

    if(option == undefined)
        option              	= {};

	var $self 				= $(this).addClass('gallery');
    var $photoList 			= $('<ul name="photo-list"></ul>').appendTo($self);

    $self.add = function (item) {

        var $item			= $('<li></li>').appendTo($photoList);
        
        var $link 			= $('<a></a>').attr('href', '?mode=read&index=' + item.idx).appendTo($item);
        var $img 			= $('<img name="preview-img" />').attr('src', item.thumbnail).appendTo($link);
        var $title 			= $('<span name="preview-title"></span>').text(item.title).appendTo($link);

        if(item.comments > 0)
            $('<span class="comment-count"></span>').text('[' + item.comments + ']').appendTo($link);
    }

    $self.clear = function () {

        $photoList.children('li').remove();
        return $self;
    }

    return $self;
}