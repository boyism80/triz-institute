<head>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/searchbox/jquery.searchbox.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/pagetab/jquery.pagetab.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/enumlist/jquery.enumlist.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/online-shop/jquery.publication.js'); ?>"></script>
<script type="text/javascript">
	
	$(document).ready(function () {

		var $contentBox				= $('.block');

		// -- search box --------------------------------------------------------------------------------------------------------

		var $searchBox 				= $('#search-box').searchbox(<?php echo json_encode($searchopt); ?>, function (type, keyword) {

			var href				= '?page=1';
			if(keyword.length != 0)
				href				+= '&keyword=' + keyword;

			if(type.length != 0)
				href				+= '&searchType=' + type;

			location.href			= href;
		});

		// -- pagetab ------------------------------------------------------------------------------------------------------------
		
		var pimages					= {	first: 		'<?php echo base_url('assets/images/icon_first.gif'); ?>',
							   			prev:  		'<?php echo base_url('assets/images/icon_prev.gif'); ?>',
							   			last:  		'<?php echo base_url('assets/images/icon_last.gif'); ?>',
							   			next:  		'<?php echo base_url('assets/images/icon_next.gif'); ?>',};
		var callback				= function (page) {

											var href            = '?page=' + page;
											var keyword			= <?php echo json_encode($keyword); ?>;
											var searchType		= <?php echo json_encode($searchType); ?>;

											if(keyword != undefined && keyword.length != 0)
									    		href            += '&keyword=' + keyword;

									    	if(searchType != undefined && searchType.length != 0)
												href            += '&searchType=' + searchType;
											
									    	location.href		= href;
									  }
		var $pagetab				= $('#pagetab').pagetab({maxTabs: 5, maxViews: <?php echo $pagetab['maxView']; ?>, image: pimages, callback: callback});
	    $pagetab.update(<?php echo $page; ?>, <?php echo $publications['count']; ?>);


	    // -- software data -----------------------------------------------------------------------------------------------------

		var data					= <?php echo json_encode($publications['data']); ?>;
		var option					= {baseurl: <?php echo json_encode(base_url()); ?>, 
									   link: 'onlineshop/publication',
									   size: {thumb: {width: '35vw', height: '45vw'}}};
		$contentBox.find('.list').enumerateProducts(data, option, function (data, $item) {

			// console.log(data, $item);
		});

		// ----------------------------------------------------------------------------------------------------------------------


		$('select').selectmenu();
		$('input[type=text]').textinput();
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/searchbox/style.searchbox.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/pagetab/style.pagetab.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/enumlist/style.enumlist.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/online-shop/style.publication.css'); ?>">
<style>
	.enumerate-list .item:not(:nth-child(4n))
	{
		margin-right: 2vw;
	}

	.enumerate-list .item
	{
		margin-bottom: 2vw;
		margin-right: 2vw;
		margin-left: 2vw;
	}

	.enumerate-list .custom
	{
		width: initial;
	}
</style>
</head>

<div class="block">
	<div class="top">
		<span>상품 <font class="highlight-color"><?php echo $publications['count']; ?></font>개</span>
		<span id="search-box" style="float: right"></span>
	</div>
	<div class="botttom"><ul class="list"></ul></div>
</div>
<div id="pagetab"></div>