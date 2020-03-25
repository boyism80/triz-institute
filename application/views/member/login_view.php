<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.content.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/member/jquery.login.js'); ?>"></script>
<script type="text/javascript">

	$(document).ready(function () {

		$('input[name="path"]').val(parameters('path'));
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.content.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/member/style.login.css'); ?>">
</head>
<body>
	<div id="contents">
		<div class="login-main">
			<div class="login-left">
				<img src="<?php echo cdn('assets/image/member/login/member login.png'); ?>" />
			</div>
			<div class="login-right">
				<div class="welcome-box">
					<div style="font-size: 20px; font-weight: bold;">안녕하세요! 방문을 환영합니다.</div>
					<div>고객님의 아이디와 비밀번호를 입력해 주시기 바랍니다.</div>
				</div>
				<div class="login-box">
					<form action="<?php echo base_url('member/requestLogin'); ?>" method='post'>
						<table>
							<colgroup>
								<col width="30%">
								<col>
							</colgroup>
							<tbody>
								<tr>
									<td class="highlight-color">아이디</td>
									<td>
										<input id="id" name="id" type="text" style="width: 140px;">
									</td>
								</tr>
								<tr>
									<td class="highlight-color">비밀번호</td>
									<td><input id="pw" name="pw" type="password" style="width: 140px;"></td>
								</tr>
							</tbody>
						</table>
						<input type='hidden' name='path'>
						<input type='submit' class='login-button highlight-background' value='로그인'>
					</form>
				</div>
			</div>
		</div>
		<div class="login-support">
			<ul>
				<li>
					<ul>
						<li><font class="highlight-color">아직 트리즈 혁신 연구소의 회원이 아니세요?</font></li>
						<li>회원이 되시면 다양한 혜택과 정보를 편리하게 이용하실 수 있습니다.</li>
					</ul>
				</li>
				<li>
					<ul>
						<li><font class="highlight-color">아이디/비밀번호를 잊으셨나요?</font></li>
						<li>본인확인을 위한 간단한 질문을 통해 고객님의 아이디/비밀번호를 찾아드립니다.</li>
					</ul>
				</li>
				<li>
					<ul class="check-list">
						<li><font class="highlight-color">트리즈 혁신 연구소</font> 사이트의 회원가입은 무료입니다.</li>
						<li>회원가입을 하시면 모든 서비스 이용 및 다양한 정보를 이메일 및 SMS를 통하여 서비스해드립니다.</li>
						<li>그 외 <font class="highlight-color">트리즈 혁신 연구소</font>에서 준비한 혜택을 제한없이 받을 수 있습니다.</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</body>
</html>