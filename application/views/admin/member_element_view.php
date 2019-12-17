<tr>
	<td><?php echo $member['idx']; ?></td>
	<td><?php echo $member['id']; ?></td>
	<td><?php echo $member['name']; ?></td>
	<td><?php echo $member['job']; ?></td>
	<td><?php echo $member['level'] == 'none' ? '' : $member['level']; ?></td>
	<td><?php echo $member['recvmail'] == '1' ? '예' : '아니오'; ?></td>
	<td><?php echo $member['register']; ?></td>
	<td><?php echo $member['tel']; ?></td>
	<td>
		<?php
			if(intval($member['admin']) == 0)
				$this->load->view('admin/assign_button_view', array('idx' => $member['idx']));
			else
				$this->load->view('admin/relieve_button_view', array('idx' => $member['idx']));
		?>
	</td>
</tr>