<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/mypage/jquery.leave.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mypage/style.leave.css'); ?>">
</head>

<h2>회원탈퇴를 하시겠습니까?</h2>
<p>회원탈퇴의 사유는 보다 나은 서비스를 위해 소중한 밑거름으로 사용되오니 번거로우시더라도 회원탈퇴사유를 작성해주십시오.</p>
<form action="requestLeave" method="post">
	<table class="default-table">
		<tbody>
			<tr>
				<th>아이디</th>
				<td id="member-id" name="id"><?php echo $user['id']; ?></td>
			</tr>
			<tr>
				<th>비밀번호</th>
				<td><input id="member-pw" name="pw" type="password" /></td>
			</tr>
			<tr>
				<th>탈퇴사유</th>
				<td>
					<select id="leave-reason" name="reason">
						<option>타사이트 유사서비스 이용</option>
						<option>자주 이용하지 않음</option>
						<option>전반적인 서비스에 대한 불만족</option>
						<option>일시적으로 사용을 원하지 않음(재가입 의사 있음)</option>
						<option>기타</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>회원탈퇴사유</th>
				<td><textarea id="leave-reason-detail" name="detail"></textarea></td>
			</tr>
		</tbody>
	</table>
	<div class="buttons">
		<input type="submit" value="회원탈퇴" class="cancel-button" data-inline="true" data-role="none">
		<a href="javascript:history.back()">
			<span class="default-button">취소</span>
		</a>
	</div>
</form>