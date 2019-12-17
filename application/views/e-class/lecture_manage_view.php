<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/numeric/jquery.numeric.min.js"></script>
<style type="text/css">
	.manage-form
	{
		margin: 10px 0px;
	}

	.manage-form .item
	{
		border: 1px #c0c0c0 solid;
		border-radius: 8px;
		padding: 10px;
		font-size: 12px;
		margin-bottom: 20px;
	}

	.manage-form .item .evaluated-mark[evaluated="true"]
	{
		color: lime;
	}

	.manage-form .item .evaluated-mark[evaluated="false"]
	{
		color: red;
	}

	.manage-form .item[evaluate="false"]
	{
		background-color: #f0f0f0;
	}

	.manage-form .item table
	{
		width: 100%;
	}

	.manage-form .item table tr
	{
		border-bottom: 1px #c0c0c0 solid;
	}

	.manage-form .item table tr:last-child
	{
		border-bottom: none;
	}

	.manage-form .item table th
	{
		width: 100px;
	}

	.manage-form .item table td
	{
		padding: 10px 0px;
	}

	.manage-form .item table td[colspan="2"]
	{
		padding: 20px 0px;
	}
</style>
<script type="text/javascript">

	$(document).ready(function () {

		$('#lecture-form').children('ul').children('li').each(function () {

			let $self				= $(this);
			let $content 			= $(this).children('.content');

			let $score 				= $self.find('.input-score').numeric();
			let $comment 			= $self.find('.evaluation-comment');

			let $evaluateButton = $(this).find('.evaluation-button');
			$evaluateButton.bind('click', function () {

				let index			= parseInt($self.attr('index'));

				$.ajax({type: 'POST',
					url: '<?php echo base_url('eclass/evaluateLecture/'); ?>' + index,
					data: {score: $score.val(), comment: $comment.val()},
					dataType: 'json',
					success: function (result) {

						if(result.success == false) {

							alert(result.error);
							return;
						}

						$score.val(result.data.score);
						$comment.val(result.data.comment);

						$self.find('.evaluated-mark').attr('evaluated', true).text('평가 완료');
						alert('평가가 완료되었습니다.');
					},
					error: function (request, status, error) {
						console.log(request, status, error);
					},
				});
			} );

			let $expandButton = $(this).find('.expand-button');
			$expandButton.bind('click', function () {

				let isExpanded = $content.css('display') != 'none';
				$(this).text(isExpanded ? '펼치기' : '감추기');
				$content.slideToggle('slow');
			} ).trigger('click');
		} );
	} );
</script>
<div id="lecture-form" class="manage-form">
	<ul>
		<?php
			foreach($ldata as $data)
				$this->load->view('e-class/lecture_manage_element_view', array('data' => $data));
		?>
	</ul>
</div>