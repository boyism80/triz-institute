<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/online-shop/jquery.software_detail.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/searchbox/jquery.searchbox.js'); ?>"></script>
<script type="text/javascript">
	
	$(document).ready(function () {

		// Register thumbnail event handler
		$('.product-small-image > img').bind('click', function () {

			$('.image-view > img').attr('src', $(this).attr('src'));
		} );

		$('.product-small-image > img').first().bind('load', function () {

			$(this).trigger('click');
		} );

		// Product tab plugin
		$('#product-tab').productTab();
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/online-shop/style.software_detail.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/searchbox/style.searchbox.css'); ?>">
</head>
<div class="product-view">
		<div class="image-view">
			<img alt="" class="product-image">
			<ul id="product-small-image-list">
				<?php
					foreach($software['thumb'] as $thumb) {
						echo '<li class="product-small-image">';
						echo '<img alt="" src="' . $thumb . '">';
						echo '</li>';
					}
				?>
			</ul>
		</div>
		<div class="product-info">
			<ul class="product-info-list">
				<li>
					<span id="product-name"><?php echo $software['name']; ?></span>
				</li>
				<li class="product-list-border-item">
					<span>수량별 공급단가</span>
					<span id="product-price" style="float: right;"><?php echo $software['lease7d']; ?>원(7일) / <?php echo $software['lease30d']; ?>원(30일) </span>
				</li>
				<li>
					<table class="product-info-table">
						<colgroup>
							<col width="110">
							<col width="250">
						</colgroup>
						<tbody>
							<tr>
								<td class="highlight-color">제품명</td>
								<td id="product-small-name"><?php echo $software['name']; ?></td>
							</tr>
							<tr>
								<td class="highlight-color">제조사</td>
								<td id="product-company"><?php echo $software['manufacturer']; ?></td>
							</tr>
						</tbody>
					</table>
				</li>
				<li>트리즈혁신연구소는 <?php echo $software['manufacturer']; ?>의 한국공식파트너이며, 정식 계약 하에 소프트웨어를 국내에 판매합니다.</li>
				<li>
					<ul class="button-list">
						<li>
							<a href="<?php echo $software['url']; ?>">
								<span class="button highlight-background">바로 구매</span>
							</a>
							<!-- <span class="button" style="background: gray;">장바구니</span> -->
						</li>
					</ul>
				</li>
			</ul>
		</div>
</div>
<div id="product-tab">
	<ul class="product-tab-list">
		<li target=".product-desc">
			<span>상품상세정보</span>
		</li>
		<li target=".product-qna">
			<span>상품문의</span>
		</li>
		<li target=".product-purchase">
			<span>주문/결제/배송안내</span>
		</li>
	</ul>
	<div class="product-tab-content">
		<div id="product-desc" class="product-desc">
			<?php echo $software['content']; ?>
		</div>
		<div id="product-qna" class="product-qna">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<colgroup>
					<col width="9%">
					<col width="13%">
					<col width="2%">
					<col width="17%">
					<col width="14%">
				</colgroup>
				<thead>
					<tr>
						<td>NO</td>
						<td>CATEGORY</td>
						<td>SUBJECT</td>
						<td>NAME</td>
						<td>DATE</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="no-data" colspan="6" align="center" valign="middle">자료가 없습니다.</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="product-purchase" class="product-purchase">
			<div class="box product-order">
				<span class="product-box-title highlight-color">주문안내</span>
				<div class="product-purchase-text">
					<ul>주문순서
						<li>제품선정-상담-주문-입금-결제확인-제품 다운로드-인증번호 입력 > 완료</li>
					</ul>
					<ul>
						<li>입금이 완료되고 결제 확인까지는 최대 7~10일이 소요됩니다.</li>
						<li>다운로드 설치 후 라이센스 코드가 찍힌 메시지 창이 열리고, 인증번호(unlock code)를 받을 수 있도록 메일(send email)을 클릭하라는 메시지가 함께 표시됩니다. (바로 클릭)</li>
						<li>send email 명령어를 클릭하고 나면 바로 답메일을 통해 인증번호를 받으실 수 있습니다.</li>
						<li>받으신 번호를 아래 unlock code에 입력하시면 됩니다.</li>
					</ul>
				</div>
			</div>
			<div class="box product-pay">
				<span class="product-box-title highlight-color">결제안내</span>
				<div class="product-purchase-text">
					<ul>결제방법
						<li>계좌이체</li>
						<li>온라인무통장입금</li>
						<li>신용카드결제는 준비 중에 있습니다.</li>
					</ul>
					<ul>세금계산서 발행
						<li>사업자등록증은 팩스나 이메일로 보내주시면 됩니다.</li>
					</ul>
				</div>
			</div>
			<div class="box product-delivery">
				<span class="product-box-title highlight-color">배송안내</span>
				<div class="product-purchase-text">
					<ul>배송방법
						<li>주문하신 제품은 결제 확인 후 다운로드를 통해 받으실 수 있습니다.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>