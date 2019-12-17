<li>
	<a href="?mode=read&index=<?php echo $idx; ?>" data-ajax="false">
		<div class="top">
			
			<div class="title" <?php if($fix === true) echo 'fix'; ?>><?php echo $title; ?></div>
			<?php
			if($comments > 0)
				echo "<span class='comments'>[$comments]</span>";
			?>	
		</div>
		<div class="bot">
			<span class="date">등록일 : <?php echo $date; ?></span>
			<span class="user">작성자 : <?php echo $uname; ?></span>
			<span class="hit">조회수 <?php echo $hit; ?></span>
		</div>
	</a>
</li>