<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/e-class/jquery.content.js'); ?>"></script>
<script type="text/javascript">

	$.fn.EClassElementForm =function (title, name, boards) {

		var $self           = $(this).addClass('element-form');

		var $headLink       = $('<a></a>').attr('href', '<?php echo base_url(); ?>eclass/board/<?php echo $name; ?>/' + name).text(title);
		var $head           = $('<div class="element-head"></div>').append($headLink).appendTo($self);
		var $content        = $('<div class="element-content"></div>').appendTo($self);
		var $elementList    = $('<ul class="default-list element-list"></div>').appendTo($content);


		$self.add = function (data) {

			var $element    = $('<li class="element-list-item"></li>').appendTo($elementList);
			var $title      = $('<span class="element-title"></span>').appendTo($element);
			var $link       = $('<a></a>').attr('href', '<?php echo base_url(); ?>eclass/board/<?php echo $name; ?>/' + name + '?mode=read&index=' + data.idx).text(data.title).appendTo($title);
			var $date       = $('<span class="element-date"></span>').text(data.date.split(' ')[0]).appendTo($element);

			return $self;
		}

		if(boards.length == 0) {

			$('<div class="empty">게시글이 없습니다.</div>').appendTo($content);
		} else {

			$(boards).each(function () {
		
				$self.add(this);
			} );
		}

		return $self;
	}
	
	$(document).ready(function () {

		var board 			= <?php echo $board; ?>;

		$('#notice').EClassElementForm('공지사항', 'notice', board['notice']);
		$('#lecture').EClassElementForm('과제', 'lecture', board['lecture']);
		$('#reference').EClassElementForm('자료실', 'reference', board['reference']);
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/e-class/style.content.css'); ?>">
</head>
<div id="eclass-table">
	<div id="notice"></div>
	<div id="lecture"></div>
	<div id="reference"></div>
</div>