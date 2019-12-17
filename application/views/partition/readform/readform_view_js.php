<script type="text/javascript">
	function updateComments(data) {

		$('.comment-list > li').remove();
		$('.comment-list').append(data);
	}

	function replaceJPlayer() {

		var $jplayer 	= $('.jp-video');

		$jplayer.each(function () {
			
			var keycode 	= $(this).attr('key');
			var name 		= $(this).attr('name');
			var path 		= $(this).attr('path');
			
			var videolist = [];
			videolist.push({title: name, artist: 'triz-institute', free: true, m4v: path});

			new jPlayerPlaylist({
				jPlayer: "#jquery_jplayer_" + keycode,
				cssSelectorAncestor: "#jp_container_" + keycode}, 
				videolist, { swfPath: "js/jplayer/dist/jplayer", supplied: "webmv, ogv, m4v", useStateClassSkin: true, autoBlur: false, smoothPlayBar: true, keyEnabled: false });
		} );
	}

	function reply(index) {

		$.ajax({type: 'POST',
			async: false,
			url: "<?php echo base_url('comment/ibox'); ?>",
			data: {index: index},
			dataType: 'json',
			success: function (result) {

				if(result.success == false) {

					alert(result.error);
					return;
				}

				$('.comment-item .input-box').remove();

				let $ibox = $(result.data);
				$('.comment-item[idx=' + index + ']').append($ibox);
			}, 
			error: function (request, status, error) {
				console.log(request, status, error);
			}});
	}

	function submitComment(index) {

		let cbox = index == undefined ? '.cbox_main' : '.comment-item[idx=' + index + ']';
		let $content = $(cbox + ' textarea[name=ibox-content]');

		$.ajax({type: 'POST',
			async: false,
			url: '<?php echo base_url('comment/add'); ?>',
			data: {bindex: <?php echo $binfo['board']['idx']; ?>, content: $content.val(), parent: index},
			dataType: 'json',
			success: function (result) {

				if(result.success == false) {
					alert(result.error);
					return;
				}

				updateComments(result.data);
				$content.val('');
			}, 
			error: function (request, status, error) {
				console.log(request, status, error);
			}});
	}

	function modify(index) {

		$.ajax({type: 'POST',
			async: false,
			url: "<?php echo base_url('comment/mbox'); ?>",
			data: {index: index},
			dataType: 'json',
			success: function (result) {

				if(result.success == false) {

					alert(result.error);
					return;
				}

				$('.comment-item .input-box').remove();

				let $ibox = $(result.data);
				$('.comment-item[idx=' + index + ']').append($ibox);
			}, 
			error: function (request, status, error) {
				console.log(request, status, error);
			}});
	}

	function modifyComment(index) {

		$.ajax({type: 'POST',
			async: false,
			url: "<?php echo base_url('comment/modify'); ?>",
			data: {index: index, bindex: <?php echo $binfo['board']['idx']; ?>, content: $('.comment-item[idx=' + index + '] textarea[name=ibox-content]').val()},
			dataType: 'json',
			success: function (result) {

				if(result.success == false) {

					alert(result.error);
					return;
				}

				updateComments(result.data);
			},
			error: function (request, status, error) {
				console.log(request, status, error);
			}});
	}

	function remove(index) {

		if(confirm('정말 삭제하시겠습니까? 삭제한 게시글은 복구할 수 없습니다.') == false)
			return;

		$.ajax({type: 'POST',
			async: false,
			url: "<?php echo base_url('comment/delete'); ?>",
			data: {index: index, bindex: <?php echo $binfo['board']['idx']; ?>},
			dataType: 'json',
			success: function (result) {

				if(result.success == false) {

					alert(result.error);
					return;
				}

				updateComments(result.data);
			}, 
			error: function (request, status, error) {
				console.log(request, status, error);
			}});
	}

	function deleteBoard() {

		if(confirm('정말 삭제하시겠습니까? 삭제한 게시글은 복구할 수 없습니다.') == false)
			return;

		$.ajax({type: 'POST',
			async: false,
			url: "<?php echo base_url('board/delete'); ?>",
			data: {index: <?php echo $binfo['board']['idx']; ?>},
			dataType: 'json',
			success: function (result) {

				if(result.success == false) {

					alert(result.error);
					return;
				}

				location.href = '?mode=list';
			}, 
			error: function (request, status, error) {
				console.log(request, status, error);
			}});
	}
</script>