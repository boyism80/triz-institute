$.fn.historyList = function () {
	
	function divnum(year) {
		
		var ret = {};
		ret.first = '' + parseInt(year / 100);
		ret.second = '' + parseInt(year % 100);
		if(parseInt(ret.second / 10) == 0)
			ret.second = '0' + ret.second;
		return ret;
	}
	
	var $historyItems = $(this).children('li');
	$historyItems.each(function () {
		
		var $historyItem = $(this).addClass('history-item');
		var $yearbox = $('<div class="year-box"></div>').prependTo($historyItem);
		$('<div class="circle highlight-background"></div>').appendTo($yearbox);
		
		
		var $achievementList = $historyItem.children('ul').addClass('achievement-list default-box hypen-list');
		var divideYear = divnum(parseInt($achievementList.attr('year')));
		$('<span class="year">' + divideYear.first + '<font class="highlight-color">' + divideYear.second + '</font></span>').appendTo($yearbox);
		
		
		var $achievements = $achievementList.children('li').addClass('achevement-item');
		$achievements.each(function () {
			
		} );
	} );
}

$.fn.historyList = function (data) {

	function divnum(year) {
		
		var ret 			= {};
		ret.first 			= '' + parseInt(year / 100);
		ret.second 			= '' + parseInt(year % 100);
		if(parseInt(ret.second / 10) == 0)
			ret.second 		= '0' + ret.second;
		return ret;
	}

	var $self				= $(this);
	var $ul					= $('<ul class="history-list"></ul>').appendTo($self);

	$self.add 				= function (year, item) {

		var $li 			= $('<li class="history-item"></li>').appendTo($ul);
		var $yearBox 		= $('<div class="year-box"></div>').appendTo($li);
		var $circle			= $('<div class="circle highlight-background"></div>').appendTo($yearBox);

		var splitedYear		= divnum(year);
		var $yearText		= $('<span class="year"></span>').text(splitedYear.first).appendTo($yearBox);
		$('<font class="highlight-color"></font>').text(splitedYear.second).appendTo($yearText);

		var $achievements 	= $('<ul class="achievement-list default-box hypen-list"><ul>').appendTo($li);
		
		if(typeof item === 'object') {

			for(var i = 0; i < item.length; i++)
				$('<li class="achievement-item"></li>').text(item[i]).appendTo($achievements);
		} else {

			$('<li class="achievement-item"></li>').text(item).appendTo($achievements);
		}
	}

	$(data).each(function () {

		$self.add(this['@attributes']['year'], this['p']);
	} );

	return $self;
}