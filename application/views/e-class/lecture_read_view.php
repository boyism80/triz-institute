<style type="text/css">
	.read-lecture-form
	{
		margin-bottom: 20px;
	}

	.read-lecture-form .title
	{
		font-size: 18px;
		padding: 10px 0px;
	}

	.read-lecture-table
	{
		width: 100%;
	}

	.read-lecture-table tr:first-child
	{
		border-top: 2px #c0c0c0 solid;
	}

	.read-lecture-table tr
	{
		border-bottom: 2px #c0c0c0 solid;
	}

	.read-lecture-table th
	{
		text-align: center;
		width: 100px;
	}

	.read-lecture-table td
	{
		padding: 8px 10px;
	}

	.read-lecture-table td[colspan="2"]
	{
		padding: 20px 10px;
	}
</style>

<div id="lecture-form">
	<div class="read-lecture-form">
		<div class="title highlight-color">제출내용</div>
		<table class="read-lecture-table">
			<tbody>
				<tr>
					<th>제출일시</th>
					<td><?php echo $ldata['date']; ?></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $ldata['content']; ?></td>
				</tr>
				<tr>
					<th>첨부파일</th>
					<td>
						<ul>
							<?php
								foreach($ldata['files'] as $file)
									$this->load->view('e-class/lecture_attach_file_view', array('file' => $file));
							?>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
		if($ldata['score'] != null)
			$this->load->view('e-class/lecture_evaluated_view', array('ldata' => $ldata));

		$now = new DateTime();
		$limit = $linfo['limit_date'] != null ? new DateTime($linfo['limit_date']) : new DateTime($linfo['submit_date']);

		if($ldata['score'] == null && ($now->format('U') < $limit->format('U')))
			$this->load->view('e-class/lecture_modify_button_view', array('bindex' => $bindex));
	?>
</div>