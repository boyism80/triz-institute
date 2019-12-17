<div class="input-box <?php if(isset($class)) echo "$class"; ?>">
	<div class="input-head">
		<span class="ihead-name"><?php echo $user['name']; ?></span>
	</div>
	<div class="input-contents">
		<textarea name="ibox-content"><?php if(isset($prevComment['content'])) echo $prevComment['content']; ?></textarea>
	</div>
	<div class="button-box">
		<div class="default-button" onclick="submitComment(<?php echo (isset($target) ? $target : null); ?>)">확인</div>
	</div>
</div>