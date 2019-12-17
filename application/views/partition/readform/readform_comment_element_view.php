<li class="comment-item" idx="<?php echo $comment['idx']; ?>">
	<div class="comment-item-box" style="padding-left: <?php echo ($comment['level'] + 1) * 30 . 'px'; ?>">
		<div class="comment-item-info">
			<span class="chead-name"><?php echo $comment['user']; ?></span>
			<span class="chead-date"><?php echo $comment['date']; ?></span>
		</div>
		<div class="comment-item-content"><?php echo $comment['content']; ?></div>
		<div class="button-box">
			<?php
				if($comment['deleted'] !== true)
					$this->load->view('partition/readform/readform_reply_comment_view', array('comment' => $comment));
			?>
			<?php
				if($comment['own'] && $comment['deleted'] !== true)
					$this->load->view('partition/readform/readform_auth_edit_comment_view', array('comment' => $comment));
			?>
		</div>
	</div>
</li>