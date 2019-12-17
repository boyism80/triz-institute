$.fn.listform = function (data, option) {

	if(option == undefined)
		option					= {};
	if(option.privilege == undefined)
		option.privilege		= {read: true, write: true};
	if(option.maxTabs == undefined)
		option.maxTabs			= 10;
	if(option.maxViews == undefined)
		option.maxViews			= 10;
	if(option.image == undefined)
		option.image			= {};
	if(option.customTable == undefined)
		option.customTable		= 'table';
	
	var $self               = $(this);
    // attach top view
    var $top                = $('<div class="board-top"></div>').appendTo($self);
    var $boardcount         = $('<span></span>').appendTo($top);

    $self.set               = function (page, count, boards) {

    	$self.pagetab.update(page, count);

    	var length          = boards != null ? boards.length : 0;
    	$self.table.clear();
    	$.each(boards, function (idx, value) {
    		// this.order      = count - (($self.pagetab.current - 1) * option.maxViews) - idx;
    		$self.table.add(this, option.baselink + '/' + this.idx);
    	} );
    	$boardcount.text('총 ' + count + '건');
    }

    $self.searchBox         = $('<span style="float:right;"></span>').appendTo($top).searchbox(option.searchopt, function (type, keyword) {
    	if(keyword.length == 0) {
    		$self.keyword		= undefined;
    		$self.searchType	= undefined;
    	} else {
    		$self.keyword		= keyword;
    		$self.searchType	= type;
    	}

    	$self.pagetab.current = 1;

    	var href            = '?page=1';
    	if($self.keyword != undefined)
    		href            += '&keyword=' + $self.keyword;

    	if($self.searchType != undefined)
			href            += '&searchType=' + $self.searchType;

		location.href       = href;
    });
    
    $self.table				= $('<div></div>').appendTo($self);
    eval('$self.table = $self.table.' + option.customTable + '(option);');
    $self.pagetab			= $('<div></div>').appendTo($self).pagetab({maxTabs: option.maxTabs, maxViews: option.maxViews, image: option.image, callback: function (page) {

    	var href            = '?page=' + page;
    	if($self.keyword != undefined)
    		href            += '&keyword=' + $self.keyword;

    	if($self.searchType != undefined)
    		href            += '&searchType' + $self.searchType;

    	location.href       = href;
    }});

    var $buttonBox			= $('<div class="button-box"></div>').appendTo($self);
    if(option.privilege.write) {
    	var $buttonWrite	= $('<div class="default-button"></div>').text('글쓰기').bind('click', function () {
    		location.href	= '?mode=write';
    	} ).appendTo($buttonBox);
    }

    $self.set(data.page, data.count, data.boards);

    return $self;
}

$.fn.table = function (option) {

	if(option == undefined)
		option              = {};

	var $self               = $(this);
	var $table              = $('<table></table>').addClass('btable').attr({ width: '100%', border: '0', cellspacing: '0', cellpadding: '0', align: 'center' }).appendTo($self);
    // append head
    var $head               = $('<thead></thead>').appendTo($table);
    var $headrow            = $('<tr></tr>').appendTo($head);
    $('<th scope="col" width="50"></th>').text('번호').appendTo($headrow);
    $('<th scope="col" width="400"></th>').text('제목').appendTo($headrow);
    $('<th scope="col" width="50"></th>').text('첨부').appendTo($headrow);
    $('<th scope="col" width="70"></th>').text('작성자').appendTo($headrow);
    $('<th scope="col" width="60"></th>').text('작성일').appendTo($headrow);
    $('<th scope="col" width="50" style="background: none"></th>').text('조회수').appendTo($headrow);
    // append body
    $body                   = $('<tbody></tbody>').appendTo($table);
    // add methods
    $self.add = function (data) {

    	var count           = $self.count();
    	var $bodyrow        = $('<tr class="table-item"></tr>').appendTo($body);
        // append idx
        $('<td></td>').text(data.idx).appendTo($bodyrow);
        
        // append title
        var $title          = $('<td class="no-align"></td>').appendTo($bodyrow);
        var $link           = $('<a></a>').attr('href', '?mode=read&index=' + data.idx).text(data.title).appendTo($title);
        if(data.fix)
            $link.css('font-weight', 'bold');
        // var $comments		= $('<span class="comments-count"></span>').text('[' + data.comments + ']').appendTo($title);
        
        //append comments count
        if(data.comments > 0)
        	$('<span class="comment-count"></span>').text('[' + data.comments + ']').appendTo($link);
        // append new icon
        if(differenceDateBetweenNow(new Date(data.date)) < 1)
        	$('<img />').attr('src', option.image.newicon).appendTo($title);
        // append reference data
        var $reference = $('<td></td>').appendTo($bodyrow);
        if(data.files)
        	$('<img />').attr('src', option.image.diskicon).appendTo($reference);
        // append name
        $('<td></td>').text(data.uname).appendTo($bodyrow);
        // append date
        $('<td></td>').text(data.date).appendTo($bodyrow);
        // append read count
        $('<td></td>').text(data.hit).appendTo($bodyrow);
        return $self;
    }

    $self.clear = function () {
    	$table.children('tbody').children('*').remove();
    }

    $self.count = function () {
    	return $body.find('.table-item').length;
    }
    return $self;
}