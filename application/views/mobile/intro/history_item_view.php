<li>
<div class="year highlight-color"><?php echo $item->attributes()->year; ?></div>
	<ul class="archivement-list">
		<?php
			foreach($item->p as $desc)
				$this->load->view('mobile/intro/history_item_desc_view', array('desc' => $desc));
		?>
	</ul>
</li>