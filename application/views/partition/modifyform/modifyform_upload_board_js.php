<script type="text/javascript">
	function upload() {

		try {

			$.ajax({type: 'POST',
				url: '<?php echo base_url("board/modify/$dbname/$index"); ?>',
				data: boardData(),
				dataType: 'json',
				success: function (result) {
					if(result.success == false) {

						alert(result.error);
						return;
					}

					location.href 		= '?mode=read&index=' + result.data;
				},
				error: function (request, status, error) {
					console.log(request, status, error);
				},
			});
		} catch(e) {

			alert(e);
		}
	}
</script>