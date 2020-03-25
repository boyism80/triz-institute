<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.content.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/member/jquery.inquiry_id.js'); ?>"></script>
<script type="text/javascript">

	$(document).ready(function () {

		$('#contents').baseform('<?php echo base_url(); ?>', <?php echo $menu; ?>);
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.content.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/member/style.inquiry_id.css'); ?>">
</head>
<body>
	<div id="contents">
		<h2>아이디 조회 결과입니다.</h2>
		<hr>
		<h4><?php echo $id; ?></h4>
		<div class="button-box">
			<a href="<?php echo base_url('member/login'); ?>">
				<div class="default-button">로그인 바로가기</div>
			</a>
		</div>
	</div>
</body>
</html>