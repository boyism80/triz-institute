<head>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/pagetab/jquery.pagetab.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/searchbox/jquery.searchbox.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.listform.js'); ?>"></script>
<script type="text/javascript">

	$(document).ready(function () {

		let searchState			= {keyword: null, searchType: null};
		let $searchBox 			= $('#search-box').searchbox(<?php echo json_encode($searchopt); ?>, function (type, keyword) {

			if(keyword.length == 0) {
				searchState.keyword		= undefined;
				searchState.searchType	= undefined;
			} else {
				searchState.keyword		= keyword;
				searchState.searchType	= type;
			}

			$pagetab.current = 1;

			var href            = '?page=1';
			if(searchState.keyword != undefined)
				href            += '&keyword=' + searchState.keyword;

			if(searchState.searchType != undefined)
				href            += '&searchType=' + searchState.searchType;

			location.href       = href;
		});

		if(<?php echo json_encode($keyword); ?> != null)
			$searchBox.keyword(<?php echo json_encode($keyword); ?>);

		if(<?php echo json_encode($searchType); ?> != null)
			$searchBox.type(<?php echo json_encode($searchType); ?>);

		let pagetab_opt		= {first: '<?php echo cdn('assets/image/icon_first.gif'); ?>',
							   prev: '<?php echo cdn('assets/image/icon_prev.gif'); ?>',
							   last: '<?php echo cdn('assets/image/icon_last.gif'); ?>',
							   next: '<?php echo cdn('assets/image/icon_next.gif'); ?>',};
		let $pagetab 			= $('#page-tab').pagetab({maxTabs: <?php echo $maxTabs; ?>, maxViews: <?php echo $maxViews; ?>, image: pagetab_opt, callback: function (page) {

			var href			= '?page=' + page;
			if(searchState.keyword != undefined)
				href			+= '&keyword=' + searchState.keyword;

			if(searchState.searchType != undefined)
				href			+= '&searchType' + searchState.searchType;

			location.href       = href;
		}});
		$pagetab.update(<?php echo $page; ?>, <?php echo $count; ?>);
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/pagetab/style.pagetab.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/searchbox/style.searchbox.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.listform.css'); ?>">
</head>