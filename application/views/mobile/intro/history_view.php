<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/intro/jquery.history.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/intro/style.history.css'); ?>">
</head>

<div class="flag">
	<img src="<?php echo base_url('assets/images/mobile/intro/history/flag_2.png'); ?>" style="width: 100%;">
</div>
<div class="history-header highlight-background">HISTORY</div>
<ul class="history-list">
	<?php
	foreach($history as $item)
		$this->load->view('mobile/intro/history_item_view', array('item' => $item));
	?>
</ul>