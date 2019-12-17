<li>
	<img class="thumbnail" src="<?php echo $board['thumbnail']; ?>">
	<div class="item-info">
		<a class="subject" href="?level=<?php echo (isset($level) ? $level : 'undefined'); ?>&mode=read&index=<?php echo $board['idx']; ?>"><?php echo $board['title']; ?></a>
		<div>
			<span class="member">작성자 : <?php echo $board['uname']; ?></span>
		</div>
		<div>
			<span class="read">조회수 : <?php echo $board['hit']; ?></span>
			<span class="date">게시일 : <?php echo $board['date']; ?></span>
		</div>
	</div>
</li>