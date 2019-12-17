<script type="text/javascript">
	function upload() {

		let binfo = boardData();
		let linfo = {'submit-date': $('#submit-date').val(), 'score' : $('#score').val()};
		if($('#use-limit').is(':checked'))
			linfo['limit-date'] = $('#limit-date').val();

		$.ajax({type: 'POST',
			url: '<?php echo base_url("eclass/addLecture/$name"); ?>',
			data: {binfo: binfo, linfo: linfo},
			dataType: 'json',
			success: function (result) {

				if(result.success == false) {
					alert(result.error);
					return;
				}

				location.href			= '?mode=read&index=' + result.data;
			},
			error: function (request, status, error) {
				console.log(request, status, error);
			},
		});
	}
</script>