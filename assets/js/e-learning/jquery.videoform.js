$.fn.vtable = function (option) {

    console.log(option);

    var $self               = $(this).addClass('video-table');
    var $ul                 = $('<ul name="video-list"></ul>').appendTo($self);

    $self.add = function (data) {

        var $li             = $('<li></li>').appendTo($ul);
        var $thumb          = $('<img class="thumbnail" />').attr('src', data.thumbnail).appendTo($li);
        var $info           = $('<div class="item-info"></div>').appendTo($li);

        var $subject        = $('<a class="subject"></a>').attr('href', '?level=' + option.level + '&mode=read&index=' + data.idx).text(data.title).appendTo($info);
        if(data.comments > 0)
            $('<span class="comment-count"></span>').text('[' + data.comments + ']').appendTo($subject);

        var $urow           = $('<div></div>').appendTo($info); // user row
        var $member         = $('<span class="member"></span>').text('작성자 : ' + data.user).appendTo($urow);

        var $brow           = $('<div></div>').appendTo($info); // board row
        var $read           = $('<span class="read"></span>').text('조회수 : ' + data.hit).appendTo($brow);
        var $date           = $('<span class="date"></span>').text('게시일 : ' + data.date.split(' ')[0]).appendTo($brow);
    }

    $self.clear = function () {
        
        $ul.children('li').remove();
    }

    $self.count = function () {
        return $ul.children('li').length;
    } 

    return $self;
}