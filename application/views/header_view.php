<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<html lang="en">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.header.js'); ?>"></script>
<script type="text/javascript">

	function parameters(name) {
	    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	    if (results == null) 
	        return null;
	    else 
	        return results[1] || 0;
	}

	function login() {

		var href			= location.href;
		var current			= href.replace('<?php echo base_url(); ?>', '').split('?')[0];
		if(current.search('member/') != -1)
			current			= '';

		if(current.length != 0)
			location.href	= '<?php echo base_url('member/login?path='); ?>' + current;
		else
			location.href	= '<?php echo base_url('member/login'); ?>';
	}

	function logout() {

	    $.ajax({type: 'POST',
		    	url: '<?php echo base_url('member/requestLogout'); ?>',
		    	data: {},
		    	dataType: 'json',
		    	success: function (result) {

		    		location.reload();
		    	},
		    	error: function (request, status, error) {
		    		console.log(request, status, error);
		    	},
		    });
	}

	$(document).ready(function () {

		var menu			= <?php echo json_encode($menu); ?>;
		$('#basetab').basetab(menu.base);
		$('#menutab').defmenu(menu.navitab);
	} );
</script>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.default.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.header.css'); ?>">
<title>트리즈혁신연구소</title>
</head>
<body>
	<div id="header">
		<div class="section">
			<a class="logo" href="<?php echo base_url(); ?>">
				<img src="<?php echo base_url('assets/images/new_logo_2.png'); ?>">
			</a>
			<div id="basetab"></div>
			<div id="menutab"></div>
		</div>
	</div>
</body>
</html>