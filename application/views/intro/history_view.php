<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/intro/jquery.history.js'); ?>"></script>
<script type="text/javascript">
	
	$(document).ready(function () {

		$('#history').historyList(<?php echo json_encode($history); ?>.item);
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/intro/style.history.css'); ?>">
</head>
<div id="history"></div>