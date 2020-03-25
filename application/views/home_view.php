<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<html lang="en">
<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.home.js'); ?>"></script>
<script type="text/javascript">


	$(document).ready(function () {

		var menu			= <?php echo $menu; ?>;
		$('#basetab-ex').basetab(menu.base);
		$('#menutab-ex').extmenu(menu.category);

		var board			= <?php echo $board; ?>;
		$.each(board, function (key, value) {

			value.link		= '<?php echo base_url() ?>' + key;
		} );
		$('#preview-box').previewBox(board);
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.home.css'); ?>">
</head>
<body>
	<div id="wrap">
		<div id="header-ex">
			<div class="section">
				<a class="logo" href="<?php echo base_url() ?>">
					<img src="<?php echo cdn('assets/image/logo.png'); ?>">
				</a>
				<div id="basetab-ex"></div>
				<div id="menutab-ex"></div>
				<div id="banner">
					<img class="slogan" src="http://placehold.it/500x100">
				</div>
			</div>
		</div>
		<div id="contents">
			<div class="section">
				<div id="preview-box"></div>
				<div id="sitemap"></div>
			</div>
		</div>
	</div>
</body>
</html>