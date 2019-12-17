<head>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/intro/jquery.expert.js"></script>
<script type="text/javascript">
	
	$(document).ready(function () {

		$('#experts').experts(<?php echo $experts; ?>);
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/intro/style.expert.css">
</head>

<div id="contents">
	<div id="experts"></div>
</div>