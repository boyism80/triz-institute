<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jplayer/dist/jplayer/jquery.jplayer.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jplayer/dist/add-on/jplayer.playlist.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/fileform/jquery.fileform.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/editor/jquery.editor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.readform.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/e-class/jquery.ereadform.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/fileform/style.fileform.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/editor/style.editor.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.readform.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/e-class/style.ereadform.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css'); ?>">
</head>

</head>
<div id="board" class="readview">
 	<div name="title"><?php echo $binfo['board']['title']; ?></div>
	<div class="readform-column" name="info">
		<span name="member">작성자 : <?php echo $binfo['board']['uname']; ?></span>
		<span name="date">작성일시 : <?php echo $binfo['board']['date']; ?></span>
		<span name="read">조회 : <?php echo $binfo['board']['hit']; ?></span>
	</div>
	<div class="readform-column">
		<span class="column_head">마감일</span>
		<span><?php echo $linfo['submit_date']; ?></span>
	</div>
	<div class="readform-column">
		<span class="column_head">최종마감일</span>
		<span><?php echo $linfo['limit_date']; ?></span>
	</div>
	<div class="readform-column">
		<span class="column_head">점수</span>
		<span><?php echo $linfo['score']; ?></span>
	</div>
	<div class="attach-files readform-column">
		<span class="title">첨부 파일</span>
		<?php
			if(isset($binfo['board']['files']['attach-files'])) {

				foreach($binfo['board']['files']['attach-files'] as $file)
					$this->load->view('partition/readform/readform_attach_file_view.php', array('file' => $file));
			}
		?>
	</div>
	<div name="board-content"><?php echo $binfo['board']['content']; ?></div>
	<div class="button-box">
		<div class="default-button" onclick="javascript:location.href = '?mode=list';">목록</div>
		<?php 
			if($binfo['board']['own'] === true || $user['admin'] === true)
				$this->load->view('partition/readform/readform_auth_edit_view');
		?>
	</div>
	<div class="comment-box">
		<div class="comment-head">댓글 <?php echo count($binfo['comments']); ?>개</div>
		<div class="comment-contents">
			<ul class="comment-list">
				<?php
					foreach($binfo['comments'] as $comment)
						$this->load->view('partition/readform/readform_comment_element_view', array('comment' => $comment));
				?>
			</ul>
		</div>
	</div>
	<?php
		if($this->session->userdata('user') != null)
			$this->load->view('partition/readform/readform_input_comment_view', array('user' => $this->session->userdata('user'), 'class' => 'cbox_main'));
	?>
</div>