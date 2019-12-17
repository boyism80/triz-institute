<script type="text/javascript" src="<?php echo base_url('assets/js/e-learning/jquery.videoform.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/e-learning/style.videoform.css'); ?>">

<div id="board">
	<div class="board-top">
		<span>총 0건</span>
		<span id="search-box" style="float: right;"></span>
	</div>
	<div class="video-table">
		<ul name="video-list">
			<?php
				foreach($boards as $board)
					$this->load->view('partition/listform/listform_video_element_view', array('board' => $board, 'level' => isset($level) ? $level : null));
			?>
		</ul>
	</div>
	<div id="page-tab"></div>
	<div class="button-box">
		<div class="default-button" onclick="javascript:location.href = '?mode=write';">글쓰기</div>
	</div>
</div>