<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/jquery.member.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/admin/jquery.member.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/admin/style.member.css'); ?>">
</head>

<div class="highlight-color group-title">관리자</div>
<ul class="member-list">
	<?php
		foreach($data['admins'] as $member)
			$this->load->view('mobile/admin/member_element_view', array('member' => $member));
	?>
</ul>

<div class="highlight-color group-title">일반회원</div>
<ul class="member-list">
	<?php
		foreach($data['members'] as $member)
			$this->load->view('mobile/admin/member_element_view', array('member' => $member));
	?>
</ul>