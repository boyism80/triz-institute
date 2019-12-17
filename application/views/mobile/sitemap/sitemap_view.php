<script type="text/javascript">
	
	console.log(<?php echo json_encode($menu); ?>);
</script>

<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/sitemap/style.sitemap.css'); ?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/sitemap/jquery.sitemap.js'); ?>"></script>
</head>


<div class="top">SITE MAP</div>
<div class="bot">
	<ul class="item-list">
		<?php
			foreach($menu['navitab'] as $item)
				$this->load->view('mobile/sitemap/sitemap_item_view', array('item' => $item));
		?>
	</ul>
</div>