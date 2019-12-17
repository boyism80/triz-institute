<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/datetimepicker/jquery.datetimepicker.full.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/numeric/jquery.numeric.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/editor/jquery.editor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/fileform/jquery.fileform.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.writeform.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jplayer/dist/jplayer/jquery.jplayer.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jplayer/dist/add-on/jplayer.playlist.min.js'); ?>"></script>
<script type="text/javascript">

	$(document).ready(function () {

		// $('#board').ewriteform({user: <?php echo json_encode($user); ?>, 
		// 	thumbnail: <?php echo json_encode($thumbnail); ?>,
		// 	maxUploadSize: <?php echo json_encode($maxUploadSize); ?>,
		// 	uploadFiles: function (name, files) {

		// 		let ret 				= null;
		// 		let fdata				= new FormData();
		// 		for(let i = 0; i < files.length; i++)
		// 			fdata.append('userfile[]', files[i]);
		// 		fdata.append('name', name);

  //               $.ajax({async: false,
  //               		type: 'POST',
	 //                	url: '<?php echo base_url(); ?>file/upload/' + name,
	 //                	processData: false,
	 //                	contentType: false,
	 //                	data: fdata,
	 //                	success: function (result) {
	 //                		ret			= JSON.parse(result);
		//                 },
		//                 error: function (request, status, error) {
		//                 	console.log(request, status, error);
		//                 },
		//             });

  //               if(ret.success == false) {
                	
  //               	alert(ret.error);
  //               	return null;
  //               }
  //               console.log(ret.data);
  //               return ret.data;
  //           },
		// 	deleteFiles: function (files) {
	
				
		// 	},
		// 	uploadBoard: function (binfo, linfo) {

		// 		$.ajax({type: 'POST',
	 //                	url: '<?php echo base_url(); ?>eclass/addLecture/' + <?php echo json_encode($name); ?>,
	 //                	data: {binfo: binfo, linfo: linfo},
	 //                	dataType: 'json',
	 //                	success: function (result) {
	                		
	 //                		if(result.success == false) {
	 //                			alert(result.error);
	 //                			return;
	 //                		}

	 //                		location.href			= '?mode=read&index=' + result.data;
		//                 },
		//                 error: function (request, status, error) {
		//                 	console.log(request, status, error);
		//                 },
		//             });
		// 	}});


		let currentTime			= new Date();
		currentTime.setSeconds(0);

		$('#submit-date, #limit-date').datetimepicker({ dayOfWeekStart : 1,
														lang:'en',
														startDate: currentTime,
														step: 10,
														value: currentTime,
														format: 'Y-m-d H:i:s',
													});

		$('#use-limit').change( function () {
			let checked     = $(this).is(':checked');
			$('#limit-date').prop('disabled', !checked);
		} ).trigger('change');

		$('#score').numeric();
	} );
</script>

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/datetimepicker/style.datetimepicker.css'); ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/fileform/style.fileform.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/editor/style.editor.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.default.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.content.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.writeform.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/js/jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css'); ?>" />
</head>

<div id="board" class="writeview">
    <table class="wform-table" cellspacing="0" cellpadding="0" align="center">
        <thead></thead>
        <tbody>
            <tr>
                <th>작성자</th>
                <td>admin</td>
            </tr>
            <tr>
                <th>제목</th>
                <td>
                    <input type="text" name="title" maxlength="200" style="width: 100%;" value="<?php if(isset($board['title'])) echo $board['title']; ?>">
                </td>
            </tr>
            <tr>
                <th>게시물 형식</th>
                <td>
                    <div>
                        <input type="checkbox" id="ckbox-notice" name="fix" <?php if(isset($board['fix']) && $board['fix'] === true) echo 'checked'; ?>>
                        <label for="ckbox-notice">공지글</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 10px 0px; width: 100%;">
                    <div name="editbox-content"></div>
                </td>
            </tr>
            <tr>
                <th>마감일</th>
                <td>
                    <input id="submit-date" type="text">
                </td>
            </tr>
            <tr>
                <th>최종 마감일</th>
                <td>
                    <input id="limit-date" type="text" disabled="">
                    <input id="use-limit" type="checkbox" style="margin-left: 10px;" <?php if(isset($linfo['limit_date']) && $linfo['limit_date'] != null) echo 'checked'; ?>>
                    <label for="use-limit">지각 허용</label>
                </td>
            </tr>
            <tr>
                <th>점수</th>
                <td>
                    <input id="score" type="text" value="<?php if(isset($linfo['score'])) echo $linfo['score']; ?>">
                </td>
            </tr>
            <tr>
                <th>첨부 파일</th>
                <td>
                    <div id="attach-files" name="attach-files" class="fileform"></div>
                </td>
            </tr>
            <tr>
                <th>이미지 파일</th>
                <td>
                    <div id="image-files" name="image-files" class="fileform"></div>
                </td>
            </tr>
            <tr>
                <th>동영상 파일</th>
                <td>
                    <div id="video-files" name="video-files" class="fileform"></div>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="text-align: center;">
        <div id="button-submit" class="default-button" onclick="upload()">확인</div>
        <div class="default-button">취소</div>
    </div>
</div>