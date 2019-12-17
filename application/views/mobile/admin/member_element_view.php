<li>
	<div class="visible-area">
		<div class="top">
			<span class="name"><?php echo $member['name']; ?></span>
			<span class="id">(<?php echo $member['id']; ?>)</span>
		</div>
		<div class="mid">
			<span>가입일 : <?php echo $member['register']; ?></span>
		</div>
		<div class="bot">
			<span>연락처 : <?php echo $member['tel']; ?></span>
		</div>
	</div>
	<div class="hidden-area">
		<div>
			<span class="key">직업</span>
			<span class="value"><?php echo $member['job']; ?></span>
		</div>
		<div>
			<span class="key">트리즈 레벨</span>
			<span class="value"><?php echo $member['level'] == 'none' ? '없음' : $member['level']; ?></span>
		</div>
		<div>
			<span class="key">이메일</span>
			<span class="value"><?php echo $member['email']; ?></span>
		</div>
		<div>
			<span class="key">메일 수신</span>
			<span class="value"><?php echo intval($member['recvmail']) != 0 ? '예' : '아니오'; ?></span>
		</div>
		<div>
			<?php
				if(intval($member['admin']) == 0)
					$this->load->view('admin/assign_button_view', array('idx' => $member['idx']));
				else
					$this->load->view('admin/relieve_button_view', array('idx' => $member['idx']));
			?>
		</div>
	</div>
</li>