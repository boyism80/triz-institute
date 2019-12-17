<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.content.js'); ?>"></script>
</head>
<div align="center">
	<div style="font-weight: bold; font-size: 16px; margin: 20px 0px;">비밀번호를 입력하세요.</div>
</div>
<form action="<?php echo base_url(); ?>eclass/certificate/<?php echo $name; ?>" method="post">
	<label for="pw">비밀번호</label>
	<input type="password" id="pw" name="pw" style="border: 1px #c0c0c0 solid;">
	<input class="default-button" type="submit" value="확인">
</form>