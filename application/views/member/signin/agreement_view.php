<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.content.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/member/signin/jquery.agreement.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.content.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/member/signin/style.signin.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/member/signin/style.agreement.css'); ?>">
</head>
<body>
	<div id="contents">
		<form action="<?php echo base_url('member/request'); ?>" method='post'>
			<div class="signin-header">
				<div class="top">
					<span class="title">회원약관 동의</span>
					<img class="state-image" src="<?php echo cdn('assets/image/member/signin/step_01.png'); ?>" style="float: right;"/>
				</div>
				<div class="bottom">
					<div class="desc">
						<p style="font-size: 18px;">회원가입을 위해서는 <font class="highlight-color">약관동의는 필수</font>입니다.</p>
						<p style="font-size: 12px; color: gray">회원가입시 등록된 인증확보 정보를 통해 아이디를 찾아드립니다.</p>
					</div>
				</div>
			</div>
			<div id="use-clause" class="readonly-textbox">
				<span class="highlight-color">이용약관</span>
				<textarea rows="0" cols="0" class="default-textarea" readonly="readonly"><?php echo $text['clause']; ?></textarea>
				<div class="agree-box">
					<input id="agree-clause" name="agree-clause" type="checkbox" value="clause" />
					<label for="agree-clause">서비스 이용약관에 동의합니다.</label>
				</div>

			</div>
			<div id="treat-privacy" class="readonly-textbox">
				<span class="highlight-color">개인정보취급방침</span>
				<textarea rows="0" cols="0" readonly="readonly" class="default-textarea"><?php echo $text['privacy']; ?></textarea>
				<div class="agree-box">
					<input id="agree-privacy" name="agree-privacy" type="checkbox" value="privacy" />
					<label for="agree-privacy">개인정보취급방침에 동의합니다.</label>
				</div>
			</div>
			<div class="button-box content-group" style="text-align: center;">
				<input type="submit" class="default-button" value="확인"></input>
				<a href="<?php echo base_url(); ?>">
					<div class="cancel-button" name="btncancel">취소</div>
				</a>
			</div>
		</form>
    </div>
</body>
</html>