<script type="text/javascript">

	$(document).ready(function () {

		console.log(<?php echo json_encode($board); ?>);

		$editor.Editor('setText', <?php echo json_encode($board['content']); ?>);

		if($thumblist != null) {

			$('.Editor-editor').find('img').each(function () {

				$thumblist.add($(this).attr('src'));
			} );
			$thumblist.select(<?php echo json_encode($board['thumbnail']); ?>);
		}

		$(<?php echo isset($board['files']['attach-files']) ? json_encode($board['files']['attach-files']) : null; ?>).each(function () {

			$files['attach'].add(this);
		} );

		$(<?php echo isset($board['files']['image-files']) ? json_encode($board['files']['image-files']) : null; ?>).each(function () {

			$files['image'].add(this);
		} );

		$(<?php echo isset($board['files']['video-files']) ? json_encode($board['files']['video-files']) : null; ?>).each(function () {

			$files['video'].add(this);
		} );
	} );
</script>