<li class="comment-item" idx="<?php echo $comment['idx']; ?>">
	<div class="comment-item-box" style="padding-left: <?php echo $comment['level'] * 30 . 'px'; ?>">
		<div class="comment-top">
			<div class="chead-name"><?php echo $comment['user']; ?></div>
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
		<div class="comment-mid">
			<?php echo $comment['date']; ?>
		</div>
		<div class="comment-bot">
			<?php echo $comment['content']; ?>
		</div>
	</div>
</li>