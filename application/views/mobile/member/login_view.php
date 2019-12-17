<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/member/style.login.css'); ?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/member/jquery.login.js'); ?>"></script>
</head>


<h2 class="login-title">LOGIN</h2>
<form action="<?php echo base_url('member/requestLogin'); ?>" method='post' name="form-login" data-ajax="false">
	<input id="id" name="id" type="text" placeholder="아이디">
	<input id="pw" name="pw" type="password" placeholder="비밀번호">
	<input type='hidden' name='path'>
	<div>
		<input type="submit" class="default-button" data-role="none" value="로그인">
		<a href="<?php echo base_url('member/signin'); ?>" data-ajax="false">
			<div class="default-button" id="sign-in">회원가입</div>
		</a>
	</div>
</form>
<div class="section-inquiry">
	<a href="<?php echo base_url('member/inquiry'); ?>" data-ajax="false">아이디 / 비밀번호 찾기</a>
</div>