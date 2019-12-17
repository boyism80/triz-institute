<div data-role="header">
	<a data-role="button" href="javascript:history.back();" data-ajax="false">
		<img src="<?php echo base_url('assets/images/mobile/home/icon_back.png'); ?>">
	</a>
	<h1>
		<?php 
			if(isset($currentTab))
				echo $currentTab['active']->attributes()->name;
			else
				echo '정보없음';
		?>
	</h1>
	<a data-role="button" href="<?php echo base_url(); ?>" data-ajax="false">
		<img src="<?php echo base_url('assets/images/mobile/home/icon_home.png'); ?>">
	</a>
</div>