<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/member/style.inquiry.css'); ?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/member/jquery.inquiry.js'); ?>"></script>
</head>


<div class="icon-box">
	<img id="icon-complete" src="<?php echo base_url('assets/images/mobile/member/signin/icon_complete.png'); ?>">
</div>
<div class="inquiry-box">
	<div class="inquiry-header">
		<img src="<?php echo base_url('assets/images/mobile/member/inquiry/icon_01.png'); ?>">
		<div class="desc-brief"><font class="highlight-color">아이디</font>가 기억나지 않으세요?</div>
		<div class="desc-detail">회원가입시 등록된 인증확보 정보를 통해 아이디를 찾아드립니다.</div>
	</div>
	<form action="<?php echo base_url('member/inquiryId'); ?>" method="post" name="inquiry-id" data-ajax="false">
		<table class="inquiry-table">
			<tr>
				<th>이름</th>
				<td><input name="find-id-name" type="text" /></td>
			</tr>
			<tr>
				<th>이메일</th>
				<td><input name="find-id-email" type="text" /></td>
			</tr>
		</table>
		<input type="submit" id="find-id" class="default-button" value="확인" data-inline="true" data-role="none">
	</form>
</div>
<div class="inquiry-box">
	<div class="inquiry-header">
		<img src="<?php echo base_url('assets/images/mobile/member/inquiry/icon_01.png'); ?>">
		<div class="desc-brief"><font class="highlight-color">비밀번호</font>가 기억나지 않으세요?</div>
		<div class="desc-detail">회원가입시 입력한 정보의 확인을 통해서 비밀번호를 찾아드립니다.</div>
	</div>
	<form action="<?php echo base_url('member/inquiryId'); ?>" method="post" name="inquiry-pw" data-ajax="false">
		<table class="inquiry-table">
			<tr>
				<th>이름</th>
				<td><input name="find-pw-name" type="text" /></td>
			</tr>
			<tr>
				<th>아이디</th>
				<td><input name="find-pw-id" type="text" /></td>
			</tr>
			<tr>
				<th>이메일</th>
				<td><input name="find-pw-email" type="text" /></td>
			</tr>
		</table>
		<input type="submit" id="find-pw" class="default-button" value="확인" data-inline="true" data-role="none">
	</form>
</div>
<div class="inquiry-desc">
	<p>고객님의 개인정보는 항상 암호화 되어 처리되며, 본인 확인용으로만 사용합니다.</p>
	<p>아이디/비밀번호 찾기가 위의 방법으로 불가능하신 경우 고객센터로 문의해 주시기 바랍니다.</p>
</div>