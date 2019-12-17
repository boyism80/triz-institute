<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/board/readform/style.readform.css'); ?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/board/readform/jquery.readform.js'); ?>"></script>
</head>


<div class="top">
	<div class="subject"><?php echo $binfo['board']['title']; ?></div>
	<div class="date"><?php echo $binfo['board']['date']; ?></div>
</div>
<div class="mid">
	<div class="content"><?php echo $binfo['board']['content']; ?></div>
	<div class="files">
		<?php
		if(isset($binfo['board']['files']['attach-files'])) {

			echo '<img id="icon-file" src="' . base_url('assets/images/mobile/board/icon_folder.png') . '">';

			foreach($binfo['board']['files']['attach-files'] as $file)
				$this->load->view('partition/readform/readform_attach_file_view.php', array('file' => $file));
		}
		?>
	</div>
	<div class="bot">
		<span class="element name">작성자 : <?php echo $binfo['board']['uname']; ?></span>
		<span class="element hit">조회수 <?php echo $binfo['board']['hit']; ?></span>
	</div>
	<div class="button-box">
		<div class="default-button" onclick="javascript:location.href = '?mode=list';">목록</div>
		<?php 
			if($binfo['board']['own'] === true || $user['admin'] === true)
				$this->load->view('partition/readform/readform_auth_edit_view');
		?>
	</div>
	<div class="comment-box">
		<div class="comment-head">댓글 <font class="highlight-color"><?php echo count($binfo['comments']); ?></font></div>
		<div class="comment-contents">
			<ul class="comment-list">
				<?php
				foreach($binfo['comments'] as $comment)
					$this->load->view('mobile/board/readform/readform_comment_element_view', array('comment' => $comment));
				?>
			</ul>
		</div>
	</div>
	<?php
	if($this->session->userdata('user') != null)
		$this->load->view('partition/readform/readform_input_comment_view', array('user' => $this->session->userdata('user'), 'class' => 'cbox_main'));
	?>
</div>