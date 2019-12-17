$.fn.readform = function (board, comments, option) {

	function replaceJPlayer() {

        var $jplayer 	= $('.jp-video');

        $jplayer.each(function () {
        
            var keycode 	= $(this).attr('key');
            var name 		= $(this).attr('name');
            var path 		= $(this).attr('path');
            
            var videolist = [];
            videolist.push({title: name, artist: 'triz-institute', free: true, m4v: path});

            new jPlayerPlaylist({
                jPlayer: "#jquery_jplayer_" + keycode,
                cssSelectorAncestor: "#jp_container_" + keycode}, 
                videolist, { swfPath: "js/jplayer/dist/jplayer", supplied: "webmv, ogv, m4v", useStateClassSkin: true, autoBlur: false, smoothPlayBar: true, keyEnabled: false });
            $(this).remove();
        } );
    }

	if(option == undefined)
		option					= {};

	if(option.requireComment == undefined)
		option.requireComment	= function ($self, bindex) {}

	if(option.submit == undefined)
		option.submit 			= function ($self, bindex, content, parent) {}

	if(option.delete == undefined)
		option.delete 			= function ($self, index) {}

	if(option.deleteComment == undefined)
		option.deleteComment	= function ($self, index) {}

	if(option.modifyComment == undefined)
		option.modifyComment	= function ($self, index, content) {}


	var $self			= $(this).addClass('readview');

	var $title 			= $('<div name="title"></div>').text(board.title).appendTo($self);
	$info 				= $('<div class="readform-column" name="info"></div>').appendTo($self);
	$('<span name="member"></span>').text('작성자 : ' + board.uname).appendTo($info);
	$('<span name="date"></span>').text('작성일시 : ' + board.date).appendTo($info);
	$('<span name="read"></span>').text('조회 : ' + board.hit).appendTo($info);
	var $attachFiles	= $('<div class="attach-files readform-column"></div>').appendTo($self);
	$('<span class="title"></span>').text('첨부 파일').appendTo($attachFiles);

	$(board.files['attach-files']).each(function () {

		var $anchor		= $('<a class="file"></a>').attr({href: this.url, download: this.title}).text(this.title).appendTo($attachFiles);
	} );

	var $bcontent 		= $('<div name="board-content"></div>').appendTo($self);
    $bcontent.html(board.content);
    $bcontent.find('img').bind('load', function () {

    	var $image		= $(this);
    	if($image.width() > $bcontent.width())
    		$image.css('width', '100%');
    } );

    replaceJPlayer();

	var $buttonBox 	= $('<div class="button-box"></div>').appendTo($self);
    var $listBtn	= $('<div class="default-button"></div>').text('목록').bind('click', function () {

    	location.href		= '?mode=list';
    } ).appendTo($buttonBox);
    if(board.own) {

    	var $modifyBtn	= $('<div class="default-button"></div>').text('수정').bind('click', function () {

    		location.href		= '?mode=modify&index=' + board.idx;
    	} ).appendTo($buttonBox);
    	var $deleteBtn	= $('<div class="default-button"></div>').text('삭제').bind('click', function () {

    		option.delete($self, board.idx);
    	} ).appendTo($buttonBox);
    }

    if(option.hideComments != true) {

	    $self.comments 		= $('<div></div>').appendTo($self).commentBox(comments, {submit: function (content, parent) {

																				    	option.submit($self, board.idx, content, parent);
																				    	option.requireComment($self, board.idx);
																				    }, 
																				    delete: function (index) {
																				    	
																				    	option.deleteComment($self, index);
																				    	option.requireComment($self, board.idx);
																				    },
																					modify: function (index, content) {

																						option.modifyComment($self, index, content);
																						option.requireComment($self, board.idx);
																					}});
    }

	return $self;
}

$.fn.commentBox = function (data, option) {

	if(option == undefined)
		option			= {}

	if(option.submit == undefined)
		option.submit 	= function (content, parent) {

			console.log(content, parent);
		}

	if(option.delete == undefined)
		option.delete	= function (index) {

			console.log(index);
		}

	if(option.modify == undefined)
		option.modify	= function (index, content) {

			console.log(index, content);
		}

	var $self			= $(this);
	var $contentBox		= $('<div class="comment-box"></div>').appendTo($self);
	var $head			= $('<div class="comment-head"></div>').appendTo($contentBox);
	var $contents		= $('<div class="comment-contents"></div>').appendTo($contentBox);
	var $ul				= $('<ul class="comment-list"></ul>').appendTo($contents);

	var $inputBox 		= $('<div></div>').appendTo($self).inputBox({user: '관리자', callback: function (val) {

		option.submit(val);
	} });

	$self.add 			= function (item) {

		function findLastChildren($parent) {

			var $child 	= $self.find('.comment-item[parent=' + $parent.attr('idx') + ']').last();
			if($child.length == 0)
				return $self.find('.comment-item[idx=' + $parent.attr('idx') + ']');

			return findLastChildren($child);
		}


		var $inbox 		= null;

		var $li 		= $('<li class="comment-item"></li>').attr('idx', item.idx);
		var $box 		= $('<div class="comment-item-box"></div>').appendTo($li);
		var $chead		= $('<div class="comment-item-info"></div>').appendTo($box);
		$('<span class="chead-name"></span>').text(item.user).appendTo($chead);
		$('<span class="chead-date"></span>').text(item.date).appendTo($chead);
		$('<div class="comment-item-content"></div>').html(item.content).appendTo($box);

		if(item.parent != null) {

			$li.attr('parent', item.parent);
			var $parent	= $self.find('.comment-item[idx=' + item.parent + ']');
			var $prev	= findLastChildren($parent);
			$li.insertAfter($prev);

			$box.css('padding-left', parseInt($parent.children('.comment-item-box').css('padding-left')) + 30);
		} else {

			$li.appendTo($ul);
		}

		var $buttonBox	= $('<div class="button-box"></div>').appendTo($box);
		if(item.deleted == false) {

			$('<span class="comment-button"></span>').text('댓글').bind('click', function () {

				if($inbox != null)
					$inbox.remove();

				$inbox 		= $('<div></div>').appendTo($li).inputBox({user: '관리자', callback: function (val) {

					option.submit(val, item.idx);
				}});
			}).appendTo($buttonBox);
		}

		if(item.own && item.deleted == false) {

			$('<span class="comment-button"></span>').text('수정').bind('click', function () {

				if($inbox != null)
					$inbox.remove();

				$inbox 		= $('<div></div>').appendTo($li).inputBox({user: '관리자', val: item.content, callback: function (val) {

					option.modify(item.idx, val);
				}});
			} ).appendTo($buttonBox);

			$('<span class="comment-button"></span>').text('삭제').bind('click', function () {

				option.delete(item.idx);

			} ).appendTo($buttonBox);
		}
		
		return $self;
	}

	$self.update		= function (items) {

		$inputBox.init();
		$self.clear();

		$head.text('댓글 ' + items.length + '개');

		items.sort(function (val1, val2) {

			return parseInt(val1.idx) - parseInt(val2.idx);
		} );

		$(items).each(function () {

			$self.add(this);
		} );
		return $self;
	}

	$self.clear			= function () {

		$ul.children('*').remove();
		return $self;
	}

	$self.update(data);

	return $self;
}

$.fn.inputBox = function (data) {

	if(data == undefined)
		data				= {};

	if(data.callback == undefined)
		data.callback		= function (contents) {
			console.log(contents);
		}

	var $self				= $(this).addClass('input-box');
	var $head 				= $('<div class="input-head"></div>').appendTo($self);
	var $mname				= $('<span class="ihead-name"></span>').text(data.user).appendTo($head)

	var $content 			= $('<div class="input-contents"></div>').appendTo($self);
	var $textbox			= $('<textarea name="ibox-content"></textarea>').val(data.val).appendTo($content);


	var $buttonBox 			= $('<div class="button-box"></div>').appendTo($self);
	var $submitButton		= $('<div class="default-button"></div>').text('확인').bind('click', function () {

		var contents 		= $textbox.val();
		data.callback(contents);
	} ).appendTo($buttonBox);

	$self.init				= function () {

		$textbox.val('');
		return $self;
	}

	return $self;
}