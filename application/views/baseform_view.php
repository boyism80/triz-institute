<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.content.css'); ?>">
<script type="text/javascript">

	$.fn.menutab = function (data) {

		var $self			= $(this);

		var $ul = $('<ul></ul>').appendTo($self);
		var $defaultSelection = null;
		$(data.item.subitem).each(function () {

			var $li = $('<li></li>').attr({name: this['@attributes']['name']}).appendTo($ul);
			var $anchor = $('<a></a>').text(this['@attributes']['name']).attr('href', "<?php echo base_url(); ?>" + this['@attributes']['link']).appendTo($li);


			if(this['@attributes']['link'] == data.active['@attributes']['link'])
				$defaultSelection = $li;
		} );

		$ul.children('li').each(function () {

			$(this).hover(function () {

				if($defaultSelection != null)
					$defaultSelection.removeClass('highlight-background').removeAttr('hover');

				$(this).addClass('highlight-background').attr('hover', '');
			}, function () {

				$(this).removeClass('highlight-background').removeAttr('hover');

				if($defaultSelection != null && $ul.children('li[hover]').length == 0)
					$defaultSelection.addClass('highlight-background').attr('hover', '');
			});
		} );

		if($defaultSelection != null)
			$defaultSelection.addClass('highlight-background').attr('hover', '');

		return $self;
	}

	$(document).ready(function () {

		var menu = <?php echo json_encode($currentTab); ?>;
		var $left = $('.left-content .menutab').menutab(menu);
	});
</script>
</head>
<body>
	<div class="content">
		<div class="section">
			<div class="left-content">
				<div id="side-menu" class="menutab"></div>
				<div class="contatct">
					<img src="<?php echo base_url('assets/images/home/tap3.jpg'); ?>">
				</div>
			</div>
			<div class="right-content">
				<h1 id="content-title" style="font-family: 'Malgun Gothic';"><?php echo $currentTab['active']->attributes()->name; ?></h1>
				<div class="division-line"></div>
				<div class="real-content">
					<?php
						foreach($customViews as $customView)
							$this->load->view($customView);
					?>
				</div>
			</div>
		</div>
	</div>
</body>