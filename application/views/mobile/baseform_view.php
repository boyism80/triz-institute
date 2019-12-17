<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script type="text/javascript">
		$(document).bind("mobileinit", function () {
			$.mobile.ajaxEnabled = false;
		});
	</script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.default.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/style.default.css'); ?>">



</head>
<body>
	<div data-role="page">
		<?php
			$this->load->view('mobile/def_header_view', array('currentTab' => $currentTab));
		?>

		<div data-role="main" class="ui-content">
			<?php
				if($customViews != null) {
					foreach($customViews as $customView)
						$this->load->view($customView);
				}
			?>
		</div>
	</div> 
</body>
</html>