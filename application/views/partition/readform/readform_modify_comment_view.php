<div class="input-box">
	<div class="input-head">
		<span class="ihead-name"><?php echo $user['name']; ?></span>
	</div>
	<div class="input-contents">
		<textarea name="ibox-content"><?php echo $content; ?></textarea>
	</div>
	<div class="button-box">
		<div class="default-button" onclick="modifyComment(<?php echo $target; ?>)">수정</div>
	</div>
</div>