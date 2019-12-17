<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/board/listform/style.listform.css'); ?>">

<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/board/listform/jquery.listform.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/searchbox/jquery.searchbox.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/pagetab/jquery.pagetab.js'); ?>"></script>
<script type="text/javascript">

	$(document).on("pageshow",function(event,data){

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

		let pagetab_opt		= {first: '<?php echo base_url('assets/images/icon_first.gif'); ?>',
							   prev: '<?php echo base_url('assets/images/icon_prev.gif'); ?>',
							   last: '<?php echo base_url('assets/images/icon_last.gif'); ?>',
							   next: '<?php echo base_url('assets/images/icon_next.gif'); ?>',};
		let $pagetab 			= $('#page-tab').pagetab({maxTabs: <?php echo $maxTabs; ?>, maxViews: <?php echo $maxViews; ?>, image: pagetab_opt, callback: function (page) {

			var href			= '?page=' + page;
			if(searchState.keyword != undefined)
				href			+= '&keyword=' + searchState.keyword;

			if(searchState.searchType != undefined)
				href			+= '&searchType' + searchState.searchType;

			location.href       = href;
		}});
		$pagetab.update(<?php echo $page; ?>, <?php echo $count; ?>);
	});
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/pagetab/style.pagetab.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/searchbox/style.searchbox.css'); ?>">
</head>

<div class="count">총 <font class="highlight-color"><?php echo $count; ?></font>건</div>
<ul class="board-list">
	<?php
	foreach($boards as $board)
		$this->load->view('mobile/board/listform/listform_element_view', $board);
	?>
</ul>
<div id="page-tab"></div>
<div id="write" class="default-button" onclick="javascript:location.href = '?mode=write';">글쓰기</div>