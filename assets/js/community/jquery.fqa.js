$.fn.fqalist = function (option) {

	var $self				= $(this);
	var $ul					= $('<ul class="fqa-list"></ul>').appendTo($self);
	var duration 			= 300;

	// add methods
	$self.add 				= function (question, answer) {
		var $li = $('<li></li>').appendTo($ul);

		// add question
		var $qcontainer		= $('<div class="fqa-item"></div>').attr('hide', '').addClass('question').appendTo($li);
		var $qicon			= $('<img />').attr('src', option.qicon).appendTo($qcontainer);
		var $qtext			= $('<span></span>').text(question).bind('click', function () {

			if ($qcontainer.attr('hide') != undefined) {

				var prevHeight = $acontainer.height();
				$acontainer.css({ display: '', height: '0px' }).animate({ height: prevHeight }, duration);
				$qcontainer.removeAttr('hide');

			} else {

				$acontainer.animate({ height: 0 }, duration, function () {
					$acontainer.css({display: 'none', height: ''});
					$qcontainer.attr('hide', '');
				});
			}
		}).appendTo($qcontainer);

		var $acontainer		= $('<div class="fqa-item"></div>').addClass('answer').css('display', 'none').appendTo($li);
		var $aicon			= $('<img />').attr('src', option.aicon).appendTo($acontainer);
		var $atext			= $('<span></span>').html(answer).appendTo($acontainer);
	};

	$self.setlist = function (data) {

		$(data).each(function () {

			$self.add(this.question, this.answer);
		} );
	}

	$(option.data).each(function () {

		$self.add(this.question, this.answer);
	} );

	return $self;
}