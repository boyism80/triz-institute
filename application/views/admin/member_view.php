<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/jquery.member.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin/style.member.css'); ?>">
</head>

<table class="default-table">
	<thead>
		<tr>
			<td>회원번호</td>
			<td>아이디</td>
			<td>이름</td>
			<td>직업</td>
			<td>트리즈레벨</td>
			<td>메일수신</td>
			<td>가입일</td>
			<td>연락처</td>
			<td>권한</td>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($data['admins'] as $member)
				$this->load->view('admin/member_element_view', array('member' => $member));
		?>
	</tbody>
</table>

<table class="default-table">
	<thead>
		<tr>
			<td>회원번호</td>
			<td>아이디</td>
			<td>이름</td>
			<td>직업</td>
			<td>트리즈레벨</td>
			<td>메일수신</td>
			<td>가입일</td>
			<td>연락처</td>
			<td>권한</td>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($data['members'] as $member)
				$this->load->view('admin/member_element_view', array('member' => $member));
		?>
	</tbody>
</table>