<script type="text/javascript">
	$(document).ready(function () {

		$editBox.Editor('setText', <?php echo json_encode($ldata['content']); ?>);

		$(<?php echo json_encode($ldata['files']); ?>).each(function () {

			$attaches.add(this);
		} );
	} );
</script>