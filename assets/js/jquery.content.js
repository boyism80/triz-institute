function extractCurrentCategory(menu) {

	var currentURL			= location.href.toLowerCase();
	var exists				= null;

	$(menu).each(function () {

		var current 		= this;
		$(this.subitem).each(function () {

			if(currentURL == this['@attributes']['link'].toLowerCase()) {

				exists		= {current: current, defitem: this};
				return false;
			}
		} );

		if(exists != null)
			return false;
	} );

	return exists;
}

$.fn.baseform = function (baseurl, menu) {

	function findActivatedCategoryByChild (menu) {

		var category 			= null;
		var current 			= null;

		$(menu).each(function () {

			var parent			= this;
			$(this.subitem).each(function () {

				if(location.href.toLowerCase().indexOf(this['@attributes']['link'].toLowerCase()) == -1)
					return true;

				category 		= parent;
				current 		= this;
			} );

			if(category != null)
				return false;
		} );

		return {category: category, current: current};
	}

	function findActivatedCategory (menu) {

		var parent 				= null;
		var category 			= null;
		var current 			= null;

		$(menu).each(function () {

			var superLink		= this['@attributes']['link'];
			if(location.href.indexOf(superLink) == -1)
				return true;

			category 			= this;
			$(this.subitem).each(function () {

				var link		= this['@attributes']['link'].toLowerCase();
				if(location.href.toLowerCase().indexOf(link) == -1)
					return true;

				current 		= this;
				return false;
			} );

			if(current == null)
				current 		= $(this.subitem).get(0);
		} );

		if(category == null)
			return findActivatedCategoryByChild(menu);

		return {category: category, current: current};
	}

	var $self				= $(this);
	var $customContent		= $(this).children('*').detach();

	var $section			= $('<div class="section"></div>').appendTo($self);
	var $left				= $('<div class="left-content"></div>').appendTo($section);
	var $right				= $('<div class="right-content"></div>').appendTo($section);

	var $sidetab			= $('<div id="side-menu"></div>').appendTo($left);
	var $contact			= $('<div class="contact"></div>').appendTo($left);
	var $contactimg			= $('<img>').attr('src', baseurl + 'assets/images/home/tap3.jpg').appendTo($contact);

	var $contentTitle		= $('<h1 id="content-title"></h1>').css('font-family', 'Malgun Gothic').appendTo($right);
	var $divisionLine		= $('<div class="division-line"></div>').appendTo($right);
	var $loadedContent		= $('<div id="loaded-content"></div>').appendTo($right).append($customContent);


	var activatedMenu		= findActivatedCategory(menu.navitab);
	$sidetab.currentTab(activatedMenu.category, activatedMenu.current);
	$contentTitle.text(activatedMenu.current['@attributes']['name']);

	$self.contentBox		= function () {

		return $loadedContent;
	}

	return $self;
};

$.fn.currentTab = function (menuitem, defitem) {


	var $self 				= $(this).addClass('menutab');
	var $ul 				= $('<ul></ul>').appendTo($self);

	$self.select 			= function (name) {

		var $selected 		= $self.find('li[name="' + name + '"]');
		if($selected.length == 0)
			return null;

		$self.unselect();
		$selected.attr('hover', '');
		$selected.addClass('highlight-background');
		return $self;
	};

	$self.unselect 			= function () {


		var $categories 	= $self.find('li');
		$categories.removeAttr('hover');
		$categories.removeClass('highlight-background');
		return $self;
	};

	$(menuitem.subitem).each(function () {

		var item			= this;
		var $category 		= $('<li></li>').attr('name', this['@attributes']['name']).hover(function () {

			$self.select(item['@attributes']['name']);
		}, function () {

			$self.select(defitem['@attributes']['name']);
		}).appendTo($ul);

		$('<a></a>').attr('href', this['@attributes']['link']).text(this['@attributes']['name']).appendTo($category);
		$self.select(defitem['@attributes']['name']);
	} );

	$self.select(defitem['@attributes']['name']);

	return $self;
};