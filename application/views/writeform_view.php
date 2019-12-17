<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/fileform/jquery.fileform.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/thumblist/jquery.thumblist.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/editor/jquery.editor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.writeform.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jplayer/dist/jplayer/jquery.jplayer.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jplayer/dist/add-on/jplayer.playlist.min.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/fileform/style.fileform.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/thumblist/style.thumblist.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/editor/style.editor.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.writeform.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css'); ?>">
</head>
<body>
	<div id="contents">
		<div id="board">
			<table class="wform-table" cellspacing="0" cellpadding="0" align="center">
				<thead></thead>
				<tbody>
					<tr><th>작성자</th><td><?php echo $user['name']; ?></td></tr>
					<tr><th>제목</th><td><input type="text" name="title" maxlength="200" style="width: 100%;" value="<?php if(isset($board)) echo $board['title']; ?>"></td></tr>
					<?php
						if($user['admin'])
					?>
						<tr><th>게시물 형식</th><td><div><input type="checkbox" id="ckbox-notice" name="fix" <?php if(isset($board) && $board['fix'] == true) echo "checked"; ?>><label for="ckbox-notice">공지글</label></div></td></tr>
					<?php
					?>
					<tr>
						<td colspan="2" style="padding: 10px 0px; width: 100%;">
							<div name="editbox-content" style="display: none;"></div>
						</td>
					</tr>
					<tr>
						<th>첨부파일</th>
						<td><div id="attach-files" name="attach-files"></td>
					</tr>
					<tr>
						<th>이미지 파일</th>
						<td><div id="image-files" name="image-files"></td>
					</tr>
					<tr>
						<th>비디오 파일</th>
						<td><div id="video-files" name="video-files"></td>
					</tr>
					<?php
						if($thumbnail)
							$this->load->view('partition/writeform/writeform_thumbnail_view');
					?>
				</tbody>
			</table>
			<div style="text-align: center;">
				<div id="button-submit" class="default-button" onclick="upload()">확인</div>
				<div class="default-button" onclick="history.back()">취소</div>
			</div>
		</div>
	</div>
</body>
</html>