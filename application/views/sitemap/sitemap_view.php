<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/sitemap/jquery.sitemap.js'); ?>"></script>
<script type="text/javascript">
	
	$(document).ready(function () {

		var menu			= <?php echo json_encode($menu); ?>;
		$('#sitemap').sitemap(menu.navitab);
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.content.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sitemap/style.sitemap.css'); ?>">
</head>
<div id="sitemap"></div>