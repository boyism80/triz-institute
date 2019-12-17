<head>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/editor/jquery.editor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/jquery.mailing.js'); ?>"></script>
<script type="text/javascript">
	
	$(document).ready(function () {

		var $editbox 			= $('div[name=editbox-content]');
		$editbox.Editor();
		$editbox.Editor('setText', $('input[name=content]').val());

		$('#addr').change(function () {

			var state 			= $(this).is(':checked');
			$('#addr-row').css('display', state ? '' : 'none');
		} ).trigger('change');

		$('#member').change(function () {

			var state 			= $(this).is(':checked');
			$('#filter-row').css('display', state ? '' : 'none');
		} ).trigger('change');

		$('#sendform').submit(function (event) {

			$('#state').css('display', 'inline-block');
			$('input[name=content]').val($editbox.Editor('getText'));
		} );
	} );
</script>

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/editor/style.editor.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin/style.mailing.css'); ?>">
</head>
<?php echo form_open_multipart('admin/mailing_result', 'id="sendform"');?>
<input type="hidden" name="content">
<table id="board-write-table" class="board-write-table" cellspacing="0" cellpadding="0" align="center">
	<tbody>
		<tr>
			<th>작성자</th>
			<td id="mail-from"><?php echo $user['name']; ?></td>
		</tr>
		<tr>
			<th>제목</th>
			<td>
				<input type="text" name="subject" maxlength="200" style="width: 100%;margin-bottom: 0px;">
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding: 10px 0px;">
				<div name="editbox-content"></div>
			</td>
		</tr>
		<tr>
			<th>형식</th>
			<td>
				<input id="member" name="member" type="checkbox" data-role="none" />
				<label for="member">홈페이지 회원</label>
				<input id="addr" name="addr" type="checkbox" data-role="none" />
				<label for="addr">주소록</label>
			</td>
		</tr>
		<tr id="filter-row">
			<th>필터링</th>
			<td>
				<table class="filter-table">
					<thead>
						<colgroup>
							<col width="<?php echo $this->baseform_model->isMobile() ? '35%' : '15%'; ?>">
						</colgroup>
					</thead>
					<tbody>
						<tr>
							<th>트리즈 레벨</th>
							<td>
								<ul class="filter-list">
									<li><input id="level_none" type="checkbox" name="level_none" value="level_none" checked><label for="level_none">없음</label></li>
									<li><input id="level1" type="checkbox" name="level1" value="level1" checked><label for="level1">트리즈 Level 1</label></li>
									<li><input id="level2" type="checkbox" name="level2" value="level2" checked><label for="level2">트리즈 Level 2</label></li>
									<li><input id="level3" type="checkbox" name="level3" value="level3" checked><label for="level3">트리즈 Level 3</label></li>
									<li><input id="level4" type="checkbox" name="level4" value="level4" checked><label for="level4">트리즈 Level 4</label></li>
									<li><input id="level5" type="checkbox" name="level5" value="level5" checked><label for="level5">트리즈 Level 5</label></li>
								</ul>
							</td>
						</tr>
						<tr>
							<th>직업</th>
							<td>
								<ul class="filter-list">
									<li><input id="job_teaching" type="checkbox" name="job_teaching" value="job_teaching" checked><label for="job_teaching">교직</label></li>
									<li><input id="job_student" type="checkbox" name="job_student" value="job_student" checked><label for="job_student">학생</label></li>
									<li><input id="job_engineer" type="checkbox" name="job_engineer" value="job_engineer" checked><label for="job_engineer">엔지니어/연구원</label></li>
									<li><input id="job_office" type="checkbox" name="job_office" value="job_office" checked><label for="job_office">사무직</label></li>
									<li><input id="job_executive" type="checkbox" name="job_executive" value="job_executive" checked><label for="job_executive">임원</label></li>
									<li><input id="job_other" type="checkbox" name="job_other" value="job_other" checked><label for="job_other">기타</label></li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr id="addr-row">
			<th>주소록</th>
			<td>
				<input id="excel_file" name="excel_file" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-role="none" />
				<div>
					<label for="name_row">회원 이름 열</label>
					<select id="name_row" name="name_row" data-inline="true">
						<option>A</option>
						<option>B</option>
						<option selected>C</option>
						<option>D</option>
						<option>E</option>
						<option>F</option>
						<option>G</option>
						<option>H</option>
						<option>I</option>
						<option>J</option>
						<option>K</option>
						<option>L</option>
						<option>M</option>
						<option>N</option>
						<option>O</option>
						<option>P</option>
						<option>Q</option>
						<option>R</option>
						<option>S</option>
						<option>T</option>
						<option>U</option>
						<option>V</option>
						<option>W</option>
						<option>X</option>
						<option>Y</option>
						<option>Z</option>
					</select>
				</div>
				<div>
					<label for="mail_row">회원 메일 열</label>
					<select id="mail_row" name="mail_row" data-inline="true">
						<option>A</option>
						<option>B</option>
						<option>C</option>
						<option>D</option>
						<option>E</option>
						<option>F</option>
						<option selected>G</option>
						<option>H</option>
						<option>I</option>
						<option>J</option>
						<option>K</option>
						<option>L</option>
						<option>M</option>
						<option>N</option>
						<option>O</option>
						<option>P</option>
						<option>Q</option>
						<option>R</option>
						<option>S</option>
						<option>T</option>
						<option>U</option>
						<option>V</option>
						<option>W</option>
						<option>X</option>
						<option>Y</option>
						<option>Z</option>
					</select>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<div class="button-fields" style="text-align: right;">
	<span id="state" style="display: none;">메일을 보내는 중입니다. 잠시만 기다려주세요.</span>
	<input type="submit" class="default-button" value="보내기"></div>
</div>
</form>