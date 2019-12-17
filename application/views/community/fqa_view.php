<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/community/jquery.fqa.js'); ?>"></script>
<script type="text/javascript">
	
	$(document).ready(function () {

		var $fqalist = $('#fqa-list').fqalist({data: <?php echo json_encode($fqalist); ?>, 
											   qicon: '<?php echo base_url('assets/images/community/fqa/icon_Q.png'); ?>', 
											   aicon: '<?php echo base_url('assets/images/community/fqa/icon_A.png'); ?>'});
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/community/style.fqa.css'); ?>">
</head>

<div id="fqa-list"></div>