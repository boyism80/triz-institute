<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/member/signin/style.complete.css'); ?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/member/signin/jquery.complete.js'); ?>"></script>
</head>

<div class="icon-box">
	<img id="icon-complete" src="<?php echo base_url('assets/images/mobile/member/signin/icon_complete.png'); ?>">
	<img class="signin-step" src="<?php echo base_url('assets/images/mobile/member/signin/step_03.png'); ?>">
</div>
<div class="notice-box">
	<div class="title">회원가입 완료</div>
	<div class="sub-title"><font class="highlight-color">회원</font>이 되신 것을 환영합니다.</div>
	<div class="desc">사이트의 모든 서비스이용 및 다양한 정보를 이메일 및 SMS를 통하여 서비스해드립니다.</div>
</div>

<div class="notice-alarm">
	<font class="highlight-color" style="font-size: 15px;"><?php echo $name; ?></font> 회원님! <br>
	가입이 성공적으로 완료되었습니다. <br>
	많은 이용 바랍니다. <br>
	감사합니다.
</div>
<div align="center">
	<a href="<?php echo base_url('member/login'); ?>" data-ajax="false">
		<div class="default-button">로그인 바로가기</div>
	</a>
</div>