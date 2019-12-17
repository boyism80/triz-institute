<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/e-class/jquery.home.js'); ?>"></script>
<script type="text/javascript">
	
	$(document).ready(function () {

		$('#eclass-table').eclassTable(<?php echo json_encode($data); ?>);
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/e-class/style.home.css'); ?>">
</head>

<div id="eclass-table"></div>
<?php
	$user = $this->session->userdata('user');

	if($user['admin'] == true)
		$this->load->view('e-class/home_admin_view');
?>