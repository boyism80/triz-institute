$('#limit-date').datetimepicker({ dayOfWeekStart : 1,
	lang:'en',
	startDate: <?php echo json_encode($linfo['limit_date']); ?>,
	step: 10,
	value: <?php echo json_encode($linfo['limit_date']); ?>,
	format: 'Y-m-d H:i:s',
});