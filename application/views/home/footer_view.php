<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/home/jquery.footer.js"></script>
<script type="text/javascript">
	$(document).ready(function () {

		var $iconBanner					= $('.item-wrap[icon-banner]').banner({size: {width: 170, height: 50},
																			   visibleCount: 3, 
																			   interval: 5000, 
																			});

		var $iconBannerController 		= $('.item-wrap[icon-banner] .play-controller').playController({play: '<?php echo cdn('assets/image/home/icon_play.png'); ?>', 
											   					 	  									pause: '<?php echo cdn('assets/image/home/icon_pause.png'); ?>', 
		  										   					 	  								active: '<?php echo cdn('assets/image/home/icon_active.png'); ?>'}, function (activated) {
		  
																																						   					 	  	if(activated)
																																						   					 	  		$iconBanner.run();
																																						   					 	  	else
																																						   					 	  		$iconBanner.stop();
																																						   					 	  }).play();

		// Previous, next button mouse down/up event
		$('.item-wrap[icon-banner] .prev-button').bind('click', function () {

			$iconBanner.prev();
		} ).bind('mousedown', function () {

			$(this).children('img').attr('src', '<?php echo cdn('assets/image/home/switch left active.png'); ?>');
		} ).bind('mouseup', function () {

			$(this).children('img').attr('src', '<?php echo cdn('assets/image/home/switch left.png'); ?>');
		}).trigger('mouseup');


		$('.item-wrap[icon-banner] .next-button').bind('click', function () {

			$iconBanner.next();
		} ).bind('mousedown', function () {

			$(this).children('img').attr('src', '<?php echo cdn('assets/image/home/switch right active.png'); ?>');
		} ).bind('mouseup', function () {

			$(this).children('img').attr('src', '<?php echo cdn('assets/image/home/switch right.png'); ?>');
		}).trigger('mouseup');
	} );
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/home/style.footer.css'); ?>">
</head>
<body>
	<div class="footer">
		<div class="section">
			<div class="com-info">
				<ul class="menu">
					<li>
						<a href="javascript:alert('준비중입니다.');">회사소개</a>
					</li>
					<li>
						<a href="javascript:alert('준비중입니다.');">이용약관</a>
					</li>
					<li>
						<a href="javascript:alert('준비중입니다.');">개인정보취급방침</a>
					</li>
					<li>
						<a href="javascript:alert('준비중입니다.');">고객문의</a>
					</li>
					<li>
						<a href="javascript:alert('준비중입니다.');">제휴문의</a>
					</li>
				</ul>
				<div class="contact">(429-793)경기도 시흥시 정왕동 한국산업기술대학교 P동 505호 TEL:031-8041-0943</div>
				<div class="copyright">COPYRIGHT 2012 TRIZ-INSTITUTE ALL RIGHTS RESERVED</div>
			</div>
			<div class="item-wrap" icon-banner>
				<span class="play-controller" style="position: relative; top: -15px;"></span>
				<span class="prev-button">
					<img>
				</span>
				<div class="image-container">
					<ul class="images" style="margin: 0px auto;">
						<li class="item">
							<a>
								<img src="<?php echo cdn('assets/image/home/partners/icon_p_01.jpg'); ?>">
							</a>
						</li>
						<li class="item">
							<a>
								<img src="<?php echo cdn('assets/image/home/partners/icon_p_02.jpg'); ?>">
							</a>
						</li>
						<li class="item">
							<a>
								<img src="<?php echo cdn('assets/image/home/partners/icon_p_03.jpg'); ?>">
							</a>
						</li>
						<li class="item">
							<a>
								<img src="<?php echo cdn('assets/image/home/partners/icon_p_04.jpg'); ?>">
							</a>
						</li>
						<li class="item">
							<a>
								<img src="<?php echo cdn('assets/image/home/partners/icon_p_05.jpg'); ?>">
							</a>
						</li>
						<li class="item">
							<a>
								<img src="<?php echo cdn('assets/image/home/partners/icon_p_06.jpg'); ?>">
							</a>
						</li>
						<li class="item">
							<a>
								<img src="<?php echo cdn('assets/image/home/partners/icon_p_07.jpg'); ?>">
							</a>
						</li>
					</ul>
				</div>
				<span class="next-button">
					<img>
				</span>
			</div>
		</div>
	</div>
</body>
</html>