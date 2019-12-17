<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>트리즈혁신연구소에 오신 것을 환영합니다.</title>
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/style.default.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/home/style.home.css'); ?>">
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/home/jquery.home.js'); ?>"></script>
</head>
<body>
	<div data-role="page" id="home">
		<div data-role="panel" id="menu-panel">
			<div class="menu-left">
				<a href="<?php echo base_url('/mobile'); ?>" class="menu-left-home">
					<img src="<?php echo base_url('assets/images/mobile/home/icon_home.png'); ?>">
				</a>
				<ul class="menu-state-items">
					<?php
					foreach($menu['navitab'] as $tab)
						$this->load->view('mobile/menu/menu_state_view', array('tab' => $tab));
					?>
				</ul>
			</div>
			<div class="menu-right">
				<div class="menu-header">
					<div class="menu-right-title">전체 메뉴</div>
					<a href="#home" class="btn-close">
						<img src="<?php echo base_url('assets/images/mobile/menu/btn_close.png'); ?>" style="width: 100%;">
					</a>
				</div>
				<?php
				foreach($menu['navitab'] as $tab)
					$this->load->view('mobile/menu/menu_item_view', array('tab' => $tab));
				?>
			</div>
		</div>
		<div data-role="header">
			<a href="#menu-panel">
				<img src="<?php echo base_url('assets/images/mobile/home/icon_menu.png'); ?>">
			</a>
			<div class="title">
				<div class="text left">TRIZ</div>
				<div class="right">
					<div class="text">INNOVATION</div>
					<div class="text">INSTITUTE</div>
				</div>
			</div>
			<?php
				$user = $this->session->userdata('user');
				if($user == null)
					$this->load->view('mobile/home/button_login_view');
				else
					$this->load->view('mobile/home/button_logout_view');
			?>
		</div>

		<div data-role="main" class="ui-content">
			<div class="banner">
				<img src="<?php echo base_url('assets/images/mobile/home/banner.jpg'); ?>" style="width: 100%;">
			</div>
			<div class="sub-banner">
				<a href="<?php echo base_url('trizworld'); ?>" data-ajax="false">
					<img src="<?php echo base_url('assets/images/mobile/home/sub_banner.jpg'); ?>" style="width: 100%;">
					<span class="text">TRIZ 소개 > </span>
				</a>
			</div>
			<div class="shortcuts">
				<ul>
					<li>
						<div class="home-button button-blue">
							<a href="<?php echo base_url('community/notice'); ?>" data-ajax="false">공지사항</a>
						</div>
					</li>
					<li>
						<div class="home-button button-gray">
							<a href="<?php echo base_url('intro/greeting'); ?>" data-ajax="false">연구소 소개</a>
						</div>
					</li>
					<li>
						<div class="home-button button-blue">
							<a href="<?php echo base_url('community/qna'); ?>" data-ajax="false">문의 안내</a>
						</div>
					</li>
				</ul>
			</div>
			<div class="shortcuts-images">
				<ul>
					<li>
						<a href="<?php echo base_url('community/communityRoom');?>" data-ajax="false">
							<img src="<?php echo base_url('assets/images/mobile/home/icon_community.png'); ?>" style="width: 40%;">
							<div>커뮤니티</div>
						</a>
					</li>
					<li>
						<a href="<?php echo base_url('community/gallery'); ?>" data-ajax="false">
							<img src="<?php echo base_url('assets/images/mobile/home/icon_gallery.png'); ?>" style="width: 40%;">
							<div>갤러리</div>
						</a>
					</li>
					<li>
						<a href="<?php echo base_url('e_learning'); ?>" data-ajax="false">
							<img src="<?php echo base_url('assets/images/mobile/home/icon_e_learning.png'); ?>" style="width: 40%;">
							<div>TRIZ e-learning</div>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div data-role="footer" style="text-align: center" class="custom_footer">
			<img src="<?php echo base_url('assets/images/new_logo_2.png'); ?>" class="footer_logo_icon">
		</div>
	</div> 
</body>
</html>