<head>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/editor/jquery.editor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/jquery.mailing_result.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/editor/style.editor.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin/style.mailing_result.css'); ?>">
</head>
<div class="title">다음 회원들에게 성공적으로 메일을 보냈습니다.</div>
<ul class="default-list addr-list">
	<?php 
	foreach ($addrlist as $addr) {
		if($addr['success'] == false)
			continue;

		echo '<li>' . $addr['name'] . '(' . $addr['email'] . ')</li>';
	}
	?>
</ul>
<div class="button-box">
	<a href="<?php echo base_url(); ?>admin/mailing">
		<div class="default-button">메일 보내기</div>
	</a>
</div>