<li class="item" index=<?php echo $data['idx']; ?>>
	<div class="head">
		<div><?php echo $data['uname'] . '(' . $data['uid'] . ')이 제출한 과제'; ?></div>
		<div class="evaluated-mark" evaluated="<?php echo json_encode($data['score'] != null); ?>"><?php echo ($data['score'] != null ? '평가완료' : '평가 미완료'); ?></div>
	</div>
	<div class="content">
		<table>
			<tbody>
				<tr>
					<th>제출자</th>
					<td><?php echo $data['uname'] . '(' . $data['uid'] . ')'; ?></td>
				</tr>
				<tr>
					<th>제출일자</th>
					<td><?php echo $data['date']; ?></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $data['content']; ?></td>
				</tr>
				<tr>
					<th>첨부파일</th>
					<td>
						<ul>
							<?php
								foreach($data['files'] as $file)
									$this->load->view('e-class/lecture_attach_file_view', array('file' => $file));
							?>
						</ul>
					</td>
				</tr>
				<tr>
					<th>평가점수</th>
					<td>
						<input class="input-score" type="text" value="<?php if($data['score'] != null) echo $data['score']; ?>"></td>
					</td>
				</tr>
				<tr>
					<th>평가의견</th>
					<td>
						<textarea class="evaluation-comment"><?php if(isset($data['comment'])) echo $data['comment']; ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="button-box">
		<div class="default-button evaluation-button">평가하기</div>
		<div class="default-button expand-button">펼치기</div>
	</div>
</li>