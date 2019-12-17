<script type="text/javascript">

	let $editBox;
	let $attaches;
	
	$(document).ready(function () {

		$editBox = $('#editbox');
		$editBox.Editor();

		$attaches = $('#lecture-files').fileform({onupload: uploadFiles});
	} );

	function uploadFiles(name, files) {

		var ret 				= null;
		var fdata				= new FormData();
		for(var i = 0; i < files.length; i++)
			fdata.append('userfile[]', files[i]);
		fdata.append('name', name);

		$.ajax({async: false,
			type: 'POST',
			url: '<?php echo base_url('file/upload/'); ?>' + name,
			processData: false,
			contentType: false,
			data: fdata,
			success: function (result) {
				ret			= JSON.parse(result);
			},
			error: function (request, status, error) {
				console.log(request, status, error);
			},
		});

		if(ret.success == false) {

			alert(ret.error);
			return null;
		}

		return ret.data;
	}

	function submitLecture() {

		var content 		= $editBox.Editor('getText');
		var files 			= $attaches.files();

		$.ajax({type: 'POST',
			url: '<?php echo base_url("eclass/submitLecture/") . $linfo['idx']; ?>',
			data: {content: content, files: files},
			dataType: 'json',
			success: function (result) {

				if(result.success == false) {

					alert(result.error);
					return;
				}

				location.href			= '?mode=read&index=' + <?php echo $linfo['bindex']; ?>;

			},
			error: function (request, status, error) {
				console.log(request, status, error);
			},
		});
	}
</script>


<div id="submit-form" class="submit-form">
	<table class="lecture-table">
		<thead></thead>
		<tbody>
			<tr>
				<td colspan="2">
					<div class="title highlight-color" style="font-size: 18px;">과제물 제출내용</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div id="editbox" style="display: none;"></div>
				</td>
			</tr>
			<tr>
				<th>첨부 파일</th>
				<td>
					<div id="lecture-files" name="lecture-files"></div>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="button-box">
		<div class="default-button" onclick="submitLecture()">제출</div>
	</div>
</div>