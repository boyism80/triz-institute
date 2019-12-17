<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.header.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/home/jquery.home.js"></script>
<script type="text/javascript">

	function parameters(name) {
	    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	    if (results == null) 
	        return null;
	    else 
	        return results[1] || 0;
	}

	function login() {

		var href			= location.href;
		var current			= href.replace('<?php echo base_url(); ?>', '').split('?')[0];
		if(current.search('member/') != -1)
			current			= '';

		if(current.length != 0)
			location.href	= '<?php echo base_url('member/login?path='); ?>' + current;
		else
			location.href	= '<?php echo base_url('member/login'); ?>';
	}

	function logout() {

	    $.ajax({type: 'POST',
		    	url: '<?php echo base_url('member/requestLogout'); ?>',
		    	data: {},
		    	dataType: 'json',
		    	success: function (result) {

		    		location.reload();
		    	},
		    	error: function (request, status, error) {
		    		console.log(request, status, error);
		    	},
		    });
	}

	$(document).ready(function () {

		var menu			= <?php echo $menu; ?>;
		$('#basetab').basetab(menu.base);
		$('#menutab').defmenu(menu.navitab);
	} );
</script>
<script type="text/javascript">

    $(document).ready(function () {

    	// Preview boards
    	var board			= <?php echo $board; ?>;
    	var $previewTab 	= $('.content .item-wrap[preview-tab]').previewTab();
    	$previewTab.addCategory('공지사항', 'notice', 'community/notice', board.notice);
    	$previewTab.addCategory('커뮤니티', 'community', 'community/communityRoom', board.community);
    	$previewTab.addCategory('갤러리', 'gallery', 'community/gallery', board.gallery);
    	$previewTab.select('notice');

    	// Content image banner
    	var $csection					= $('.content .section');
    	var $banner						= $('.item-wrap[banner]').banner({size: {width: $csection.width() * 0.35, height: 140},
											   						  	  controller: true,
											   						  	  interval: 2000, });

		var $bannerController			= $('.item-wrap[banner] .play-controller').playController({ play: '<?php echo base_url(); ?>assets/images/home/icon_play.png', 
													   					 							pause: '<?php echo base_url(); ?>assets/images/home/icon_pause.png', 
													   					 							active: '<?php echo base_url(); ?>assets/images/home/icon_active.png'}, function (activated) {
										
																																						   					 	if(activated)
																																						   					 		$banner.run();
																																						   					 	else
																																						   					 		$banner.stop();
																															   					 							}).play();

		// Main background image banner
		var $mainBackground				= $('.background-list').fadeBanner({interval: 7000, duration: 1000}).run();
		
		$('.background-list .button-arrow[left]').click(function () {

			$mainBackground.prev();
		} );
		$('.background-list .button-arrow[right]').click(function () {

			$mainBackground.next();
		} );


		// Top menu tab
    	var menu			= <?php echo $menu; ?>;
		$('#basetab-ex').basetab(menu.base);
		$('#menutab-ex').extmenu(menu.navitab);
		

		// On resize
		$(window).resize(function () {

			$mainBackground.resize({width: $(document).width(), height: $('.header').height()});
		} ).trigger('resize');
    });
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.header.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/home/style.home.css">
<title>트리즈혁신연구소</title>
<style type="text/css">
.basetab .basetab-item
{
	text-shadow: 2px 2px 4px #000000;
}

.background-list
{
	position: absolute;
}

.background-list .item
{
	display: inline-block;
	width: 100%;
}

.background-list .item img
{
	width: 100%;
}

.background-list .button-arrow
{
	position: absolute;
	top: 45%;
	z-index: 10;
	cursor: pointer;
}

.background-list .button-arrow[left]
{
	left: 12%;
}

.background-list .button-arrow[right]
{
	right: 16%;
}
</style>
</head>
<body>
	<div id="wrap">
		<div class="header">
			<div class="background-list">
				<span class="button-arrow" left>
					<img src="<?php echo base_url(); ?>assets/images/home/navigation button left.png">
				</span>
				<div class="image-container">
					<ul class="images">
						<li class="item">
							<img src="<?php echo base_url('assets/images/home/backgrounds/background_01.jpg'); ?>">
						</li>
						<li class="item">
							<img src="<?php echo base_url('assets/images/home/backgrounds/background_02.jpg'); ?>">
						</li>
						<li class="item">
							<img src="<?php echo base_url('assets/images/home/backgrounds/background_03.jpg'); ?>">
						</li>
					</ul>
				</div>
				<span class="button-arrow" right>
					<img src="<?php echo base_url('assets/images/home/navigation button right.png'); ?>">
				</span>
			</div>
			<div class="section">
				<a id="logo" href="<?php echo base_url(); ?>">
					<img src="<?php echo base_url('assets/images/new_logo.png'); ?>">
				</a>
				<div class="menutab">
					<div id="basetab-ex"></div>
					<div id="menutab-ex"></div>
				</div>
			</div>
		</div>
		<div class="content">
			<div class="section">
				<div class="item-wrap" preview-tab></div>
				<div class="item-wrap" banner>
					<div class="play-controller" style="top: 5px; z-index: 1;"></div>
					<div class="image-container">
						<ul class="images" style="margin: 0px auto;">
							<li class="item">
								<a href="<?php echo base_url('trizworld/intro'); ?>">
									<img src="<?php echo base_url('assets/images/home/banner/banner_01.jpg'); ?>">
								</a>
							</li>
							<li class="item">
								<a href="<?php echo base_url('software/trizsoft'); ?>">
									<img src="<?php echo base_url('assets/images/home/banner/banner_02.jpg'); ?>">
								</a>
							</li>
							<li class="item">
								<a href="<?php echo base_url('consulting/howto'); ?>">
									<img src="<?php echo base_url('assets/images/home/banner/banner_03.jpg'); ?>">
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="item-wrap" contact>
					<img src="<?php echo base_url('assets/images/home/tap3.jpg'); ?>">
					<a href="intro/location">
						<span class="location">찾아오시는 길</span>
						<img src="<?php echo base_url('assets/images/home/icon_contact.png'); ?>" style="position: relative; top: 6px; left: 55px; border: none;">
					</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>