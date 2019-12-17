<div class="menu-title" name="<?php echo $tab->attributes()->name; ?>"><?php echo $tab->attributes()->name; ?></div>
<ul class="menu-items">
	<?php
		foreach($tab->subitem as $subitem)
			$this->load->view('mobile/menu/menu_subitem_view', array('subitem' => $subitem));
	?>
</ul>