<div id="board">
	<div class="board-top">
		<span id="board-count">총 <?php echo $count; ?>건</span>
		<span id="search-box" style="float: right"></span>
	</div>
	<table id="board-table" class="btable" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
		<thead>
			<tr>
				<th scope="col" width="50">번호</th>
				<th scope="col" width="400">제목</th>
				<th scope="col" width="50">첨부</th>
				<th scope="col" width="70">작성자</th>
				<th scope="col" width="60">작성일</th>
				<th scope="col" width="50" style="background: none;">조회수</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($boards as $board)
					$this->load->view('partition/listform/listform_table_element_view', array('board' => $board));
			?>
		</tbody>
	</table>
	<div id="page-tab"></div>
	<div class="button-box">
		<div class="default-button" onclick="javascript:location.href = '?mode=write';">글쓰기</div>
	</div>
</div>