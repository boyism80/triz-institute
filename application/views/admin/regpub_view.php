<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/editor/jquery.editor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/jquery.regpub.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/fileform/jquery.fileform.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/numeric/jquery.numeric.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/datetimepicker/jquery.datetimepicker.full.js'); ?>"></script>
<script type="text/javascript">

	$(document).ready(function () {

		// Set numeric input tag
		$('input[name=price], input[name=ISBN], input[name=page]').numeric();

		var currentTime			= new Date();
		currentTime.setSeconds(0);
		$('input[name=pubdate]').datetimepicker({ dayOfWeekStart : 1,
													lang:'en',
													startDate: currentTime,
													step: 10,
													value: currentTime,
													format: 'Y-m-d H:i:s',
												});

		// Set edit box
		var $intro	 			= $('div[name=intro]');
		$intro.Editor();
		$intro.Editor('setText', '책 소개를 입력하세요.');
		
		var prevIntro			= $('input[name=intro]').val();
		if(prevIntro.length != 0)
			$intro.Editor('setText', prevIntro);

		var $toc				= $('div[name=toc]');
		$toc.Editor();
		$toc.Editor('setText', '목차를 입력하세요.');

		var prevToc				= $('input[name=toc]').val();
		if(prevToc.length != 0)
			$toc.Editor('setText', prevToc);

		var $pubReview			= $('div[name=pubreview]');
		$pubReview.Editor();
		$pubReview.Editor('setText', '출판사 리뷰를 입력하세요.');

		var prevPubReview		= $('input[name=pubreview]').val();
		if(prevPubReview.length != 0)
			$pubReview.Editor('setText', prevPubReview);

		// Set submit data
		$('#sendform').submit(function (event) {

			$('#state').css('display', 'inline-block');
			$('input[name=intro]').val($intro.Editor('getText'));
			$('input[name=toc]').val($toc.Editor('getText'));
			$('input[name=pubreview]').val($pubReview.Editor('getText'));
			$('input[name=thumbnail]').val($thumb.files());

			event.preventDefault();
			return false;
		} );
	} );

</script>

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/editor/style.editor.cs'); ?>s">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/fileform/style.fileform.cs'); ?>s">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/datetimepicker/style.datetimepicker.css'); ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin/style.regpub.cs'); ?>s">
</head>
<?php echo form_open_multipart('admin/regpub_result', 'id="sendform"');?>
<input type="hidden" name="intro">
<input type="hidden" name="toc">
<input type="hidden" name="pubreview">
<input type="hidden" name="thumbnail">
<table id="board-write-table" class="board-write-table" cellspacing="0" cellpadding="0" align="center">
	<tbody>
		<tr>
			<th>도서명</th>
			<td>
				<input type="text" name="name" maxlength="128" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<th>부제목</th>
			<td>
				<input type="text" name="subtitle" maxlength="128" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<th>저자</th>
			<td>
				<input type="text" name="writer" maxlength="128" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<th>출판사</th>
			<td>
				<input type="text" name="publisher" maxlength="64" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<th>가격</th>
			<td>
				<input type="text" name="price" maxlength="128" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<th>출간일</th>
			<td>
				<input type="text" name="pubdate" maxlength="128" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<th>페이지</th>
			<td>
				<input type="text" name="page" maxlength="128" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<th>ISBN</th>
			<td>
				<input type="text" name="ISBN" maxlength="128" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<th>URL</th>
			<td>
				<input type="text" name="url" maxlength="512" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<th>목차</th>
			<td>
				<div name="toc"></div>
			</td>
		</tr>
		<tr>
			<th>책소개</th>
			<td>
				<div name="intro"></div>
			</td>
		</tr>
		<tr>
			<th>출판사 리뷰</th>
			<td>
				<div name="pubreview"></div>
			</td>
		</tr>
		<tr>
			<th>썸네일</th>
			<td>
				<input type="file" id="thumb" name="thumb[]" accept="image/*" multiple>
			</td>
		</tr>
	</tbody>
</table>
<div class="button-fields" style="text-align: right;">
	<input type="submit" class="default-button" value="등록"></div>
</div>
</form>