<li>
	<a href="?mode=read&index=<?php echo $idx; ?>" data-ajax="false">
		<div class="left">
			<img src="<?php echo $thumbnail; ?>" class="thumb">
		</div>
		<div class="right">
			<div class="top">
				<div class="title"><?php echo $title; ?></div>
				<div class="comments">
					<img src="<?php echo base_url('assets/images/mobile/board/speech_bubble.png'); ?>">
					<div class="highlight-color"><?php echo $comments; ?></div>
				</div>
			</div>
			<div class="content-preview"><?php echo $preview; ?></div>
			<div class="uname">작성자 : <?php echo $uname; ?></div>
			<div class="date">등록일 : <?php echo $date; ?></div>
		</div>
	</a>
</li>