<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.content.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/member/signin/jquery.complete.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.content.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/member/signin/style.signin.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/member/signin/style.complete.css'); ?>">
</head>
<body>
	<div id="contents">
		<div class="signin-header">
			<div class="top">
				<span class="title">회원가입 완료</span>
				<img class="state-image" src="<?php echo cdn('assets/image/member/signin/step_03.png'); ?>" />
			</div>
			<div class="top">
				<div class="desc">
					<p style="font-size: 18px;"><font class="highlight-color">회원</font>이 되신 것을 환영합니다.</p>
					<p style="font-size: 12px; color: gray">사이트의 모든 서비스 이용 및 다양한 정보를 이메일 및 SMS를 통하여 서비스해드립니다.</p>
				</div>
			</div>
		</div>
		<div class="complete-msgbox">
			<p><font id="member-name" class="highlight-color"><?php echo $name; ?></font> 회원님!</p>
			<p>회원가입이 성공적으로 완료되었습니다. 많은 이용 바랍니다.</p>
			<p>감사합니다.</p>
		</div>
		<div align="center">
			<a href="<?php echo base_url(); ?>member/login">
				<div class="default-button" style="margin-top: 30px;">로그인 바로가기</div>
			</a>
		</div>
	</div>
</body>
</html>