<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mobile/member/signin/style.agreement.css'); ?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/mobile/member/signin/jquery.agreement.js'); ?>"></script>
</head>


<form action="<?php echo base_url('member/request'); ?>" method='post' data-ajax="false">
	<div data-role="main" class="ui-content">
		<div class="icon-box">
			<img src="<?php echo base_url('assets/images/mobile/member/signin/step_01.png'); ?>" style="width: 100%;">
		</div>
		<input id="agree-clause" name="agree-clause" type="hidden" value="clause">
		<div class="readonly-textbox">
			<span class="highlight-color agreement-title">이용약관</span>
			<textarea rows="0" cols="0" class="default-textarea" readonly="readonly"><?php echo $text['clause']; ?></textarea>
		</div>

		<input id="agree-privacy" name="agree-privacy" type="hidden" value="privacy">
		<div class="readonly-textbox">
			<span class="highlight-color agreement-title">개인정보취급방침</span>
			<textarea rows="0" cols="0" class="default-textarea" readonly="readonly"><?php echo $text['privacy']; ?></textarea>
		</div>
	</div>
	<div data-role="footer" id="footer">
		<div style="padding: 10px 0px;">위 사항에 동의하십니까?</div>
		<div>
			<a href="<?php echo base_url(); ?>" data-ajax="false">
				<div class="default-button">동의하지 않음</div>
			</a>
			<input type="submit" class="default-button" data-role="none" value="동의함">
		</div>
	</div>
</form>