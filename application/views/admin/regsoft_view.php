<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/editor/jquery.editor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/fileform/jquery.fileform.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/numeric/jquery.numeric.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/jquery.regsoft.js'); ?>"></script>
<script type="text/javascript">

	$(document).ready(function () {

		$('input[name=lease_7d], input[name=lease_30d]').numeric();

		var $editbox 			= $('div[name=software_content]');
		$editbox.Editor();
		$editbox.Editor('setText', '제품의 상세 내용을 적으세요.');

		$('#sendform').submit(function (event) {

			$('#state').css('display', 'inline-block');
			$('input[name=content]').val($editbox.Editor('getText'));

			$('input[name=thumbnail]').val($thumb.files());
			event.preventDefault();
			return false;
		} );
	} );

</script>

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/editor/style.editor.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/fileform/style.fileform.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin/style.regsoft.css'); ?>">
</head>

<?php echo form_open_multipart('admin/regsoft_result', 'id="sendform"');?>
<input type="hidden" name="content">
<input type="hidden" name="thumbnail">
<table id="board-write-table" class="board-write-table" cellspacing="0" cellpadding="0" align="center">
	<tbody>
		<tr>
			<th>제품명</th>
			<td>
				<input type="text" name="name" maxlength="200" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<th>제조사</th>
			<td>
				<select name="manufacturer" style="margin-bottom: 0px;">
					<?php 
					foreach($manufacturers as $manufacturer)
						echo '<option value="' . $manufacturer['idx'] . '">' . $manufacturer['name'] . '</option>';
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th>가격</th>
			<td>
				<div style="margin-bottom: 5px;">
					<label class="lease_label">7일 대여</label>
					<input type="text" name="lease_7d" maxlength="200" style="margin-bottom: 0px;">
				</div>
				<div style="margin-bottom: 5px;">
					<label class="lease_label">한달 대여</label>
					<input type="text" name="lease_30d" maxlength="200" style="margin-bottom: 0px;">
				</div>
			</td>
		</tr>
		<tr>
			<th>URL</th>
			<td>
				<input type="text" name="url" maxlength="512" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding: 10px 0px;">
				<div name="software_content"></div>
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