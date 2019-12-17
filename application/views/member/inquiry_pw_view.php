<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.content.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/member/jquery.inquiry_pw.js"></script>
<script type="text/javascript">

	$(document).ready(function () {

		$('#contents').baseform('<?php echo base_url(); ?>', <?php echo $menu; ?>);
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.content.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/member/style.inquiry_pw.css">
</head>
<body>
	<div id="contents">
		<div align="center">
			<div style="font-weight: bold; font-size: 16px;">비밀번호가 정상적으로 변경되었습니다.</div>
			<div>회원가입 시 입력된 이메일로 변경된 비밀번호를 발송하였으니 확인 후 반드시 비밀번호를 변경해주세요.</div>
		</div>
		<div class="highlight-color" style="font-weight: bold;">(로그인 후 MY PAGE - 회원정보 수정 페이지에서 변경이 가능합니다.)</div>
		<br>
		<div class="button-box">
			<a href="<?php echo base_url(); ?>member/login">
				<div class="default-button">로그인 바로가기</div>
			</a>
		</div>
	</div>
</body>
</html>