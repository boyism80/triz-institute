<li>
	<div>
		<a href="<?php echo $item->attributes()->link; ?>">
			<span class="item-title highlight-color"><?php echo $item->attributes()->name; ?></span>
		</a>
	</div>
	<ul class="subitem-list">
		<?php
			foreach($item->subitem as $subitem)
				$this->load->view('mobile/sitemap/sitemap_subitem_view', array('subitem' => $subitem));
		?>
	</ul>
</li>