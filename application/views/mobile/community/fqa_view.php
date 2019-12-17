<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/community/jquery.fqa.js'); ?>"></script>
<script type="text/javascript">

	$(document).on("pageshow", function(event,data) {

		// var $fqalist = $('#fqa-list').fqalist({data: <?php echo json_encode($fqalist); ?>, 
		// 									   qicon: '<?php echo base_url('assets/images/community/fqa/icon_Q.png'); ?>', 
		// 									   aicon: '<?php echo base_url('assets/images/community/fqa/icon_A.png'); ?>'});

		console.log(<?php echo json_encode($fqalist); ?>);
	});
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/community/style.fqa.css'); ?>">
</head>

<ul id="fqa-list">
	<?php
		foreach($fqalist as $item)
			$this->load->view('mobile/community/fqa_element_view', array('item' => $item));
	?>
</ul>