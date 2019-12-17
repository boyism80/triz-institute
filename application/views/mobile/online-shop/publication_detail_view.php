<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/online-shop/jquery.publication_detail.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/online-shop/style.publication_detail.css'); ?>">
</head>
<div class="pub-top">
	<div class="pub-left">
		<div class="pub-image">
			<img src="<?php if(isset($publication['thumb']) && count($publication['thumb']) != 0) echo $publication['thumb'][0]; ?>">
		</div>
	</div>
	<div class="pub-right">
		<div class="pub-box pub-base-info">
			<div class="pub-name"><?php echo $publication['name']; ?></div>
			<div class="pub-subtitle"><?php echo $publication['subtitle']; ?></div>
			<ul class="pub-text-list">
				<li>
					<span class="pub-label">가격</span>
					<span class="pub-value"><?php echo $publication['price'] . '원'; ?></span>
				</li>
			</ul>
		</div>
		<div class="pub-box pub-ext-info">
			<ul class="pub-text-list">
				<li>
					<span class="pub-label">저자</span>
					<span class="pub-value"><?php echo $publication['writer']; ?></span>
				</li>
				<li>
					<span class="pub-label">출판사</span>
					<span class="pub-value"><?php echo $publication['publisher']; ?></span>
				</li>
				<li>
					<span class="pub-label">출간</span>
					<span class="pub-value"><?php echo $publication['pubdate']; ?></span>
				</li>
				<li>
					<span class="pub-label">페이지</span>
					<span class="pub-value"><?php echo $publication['page'] . '쪽'; ?></span>
				</li>
				<li>
					<span class="pub-label">ISBN</span>
					<span class="pub-value"><?php echo $publication['ISBN']; ?></span>
				</li>
			</ul>
		</div>
		<div class="pub-box pub-buy-area">
			<a href="<?php echo $publication['url']; ?>">
				<div class="default-button" size="big">구매하기</div>
			</a>
		</div>
	</div>
</div>
<div class="pub-bot">
	<ul class="pub-content-list">
		<li>
			<div class="pub-title highlight-color">책 소개</div>
			<div class="pub-content"><?php echo $publication['intro']; ?></div>
		</li>
		<li>
			<div class="pub-title highlight-color">목차</div>
			<div class="pub-content"><?php echo $publication['toc']; ?></div>
		</li>
		<li>
			<div class="pub-title highlight-color">출판사 리뷰</div>
			<div class="pub-content"><?php echo $publication['pubreview']; ?></div>
		</li>
	</ul>
</div>