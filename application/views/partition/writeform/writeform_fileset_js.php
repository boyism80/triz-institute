<script type="text/javascript">
	
	let $editor = null;
	let $files = {};
	let $thumblist = null;

	function boardData() {

		let data = {title: $('input[name=title]').val(), content: $editor.Editor('getText'), files: files(), fix: $('input[name=fix]').prop('checked')};
		let useThumbnail = <?php echo json_encode($thumbnail); ?>;
		if(useThumbnail === true) {

			data['thumbnail'] = $thumblist.selected();
			if(data['thumbnail'] == undefined)
				throw '썸네일을 선택하세요.';
		}

		return data;
	}

	function uploadFiles(name, files) {

		let ret 				= null;
		let fdata				= new FormData();
		for(let i = 0; i < files.length; i++)
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

				alert('파일을 첨부할 수 없습니다.');
				console.log(request, status, error);
			},
		});

		if(ret == null || ret.success == false) {

			return null;
		}

		return ret.data;
	}

	function uploadedPictures(file) {

		let $image 		= $('<img>').addClass('attach-image').attr({src: file.url, path: file.path, name: file.orig_name}).css('max-width', '100%');
		let newHTML		= $editor.Editor('getText') + $image.prop('outerHTML');
		$editor.Editor('setText', newHTML);

		if($thumblist != null)
			$thumblist.add(file['url']);
	}

	function uploadedVideos(file) {

		let htmlcode 	= $editor.Editor('getText');
		let $preview 	= $('<img />').addClass('preview-videoimg').attr({src: file.preview, path: file.path, name: file.orig_name});
		htmlcode 		+= $preview.prop('outerHTML');
		htmlcode 		+= '<br />';
		$editor.Editor('setText', htmlcode);
	}

	function deletePicture(file) {

		$editor.next().find('.attach-image[path="' + file.path + '"]').remove();

		if($thumblist != null)
			$thumblist.remove(file['url']);
	}

	function deleteVideo(file) {

		$editor.next().find('.preview-videoimg[path="' + file.path + '"]').remove();

		if($thumblist != null)
			$thumblist.remove(file['thumb']);	
	}

	function files() {

		let ret 			= [];
		ret 				= ret.concat($files['attach'].files());
		ret 				= ret.concat($files['image'].files());
		ret 				= ret.concat($files['video'].files());

		return ret;
	}

	$(document).ready(function () {

		$editor = $('div[name=editbox-content]');
		$editor.Editor();

		$files['attach'] = $('#attach-files').fileform({onupload: uploadFiles, maxsize: <?php echo $maxUploadSize['attach']; ?>});
		$files['image'] = $('#image-files').fileform({onupload: uploadFiles, 
			onuploaded: uploadedPictures, 
			ondelete: deletePicture, 
			maxsize: <?php echo $maxUploadSize['image']; ?>, 
			accept: 'image/*'});
		$files['video'] = $('#video-files').fileform({onupload: uploadFiles, 
			onuploaded: uploadedVideos, 
			ondelete: deleteVideo, 
			maxsize: <?php echo $maxUploadSize['video']; ?>, 
			accept: 'video/*'});

		let useThumbnail = <?php echo json_encode($thumbnail); ?>;
		if(useThumbnail)
			$thumblist = $('#thumbnail-list').thumbnailList();
	} );
</script>