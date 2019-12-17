<script type="text/javascript">

	$(document).ready(function () {

		$editor.Editor('setText', <?php echo json_encode($board['content']); ?>);

		$('#submit-date').datetimepicker({ dayOfWeekStart : 1,
			lang:'en',
			startDate: <?php echo json_encode($linfo['submit_date']); ?>,
			step: 10,
			value: <?php echo json_encode($linfo['submit_date']); ?>,
			format: 'Y-m-d H:i:s',
		});

		<?php
			if($linfo['limit_date'] != null)
				$this->load->view('e-class/partition/modify/emodify_limit_date_js', array('linfo' => $linfo));
		?>
	} );

	function upload() {

		let binfo = boardData();
		let linfo = {'submit_date': $('#submit-date').val(), 'limit_date': null, 'score' : $('#score').val()};
		if($('#use-limit').is(':checked'))
			linfo['limit_date'] = $('#limit-date').val();

		$.ajax({type: 'POST',
			url: '<?php echo base_url("eclass/modify/" . $linfo['idx']); ?>',
			data: {binfo: binfo, linfo: linfo},
			dataType: 'json',
			success: function (result) {

				if(result.success == false) {
					alert(result.error);
					return;
				}

				location.href = '?mode=read&index=<?php echo $board['idx']; ?>';
			},
			error: function (request, status, error) {
				console.log(request, status, error);
			},
		});
	}
</script>