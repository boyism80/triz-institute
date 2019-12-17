<script type="text/javascript" src="<?php echo base_url('assets/js/community/jquery.gallery.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/community/style.gallery.css'); ?>">
<div id="board">
	<div class="board-top">
		<span>총 <?php echo count($boards); ?>건</span>
		<span id="search-box" style="float: right;"></span>
	</div>
	<div class="gallery">
		<ul name="photo-list">
			<?php
				foreach($boards as $board)
					$this->load->view('partition/listform/listform_gallery_element_view', array('board' => $board));
			?>
		</ul>
	</div>
	<div id="page-tab"></div>
	<div class="button-box">
		<div class="default-button" onclick="javascript:location.href = '?mode=write'">글쓰기</div>
	</div>
</div>