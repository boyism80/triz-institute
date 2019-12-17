<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/e-class/jquery.home.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/e-class/style.home.css'); ?>">
</head>

<ul class="ec-list">
	<?php
	foreach($data as $element)
		$this->load->view('mobile/e-class/home_element_view', array('element' => $element));
	?>
</ul>
<?php
$user = $this->session->userdata('user');

if($user['admin'] == true)
	$this->load->view('mobile/e-class/home_admin_view');
?>