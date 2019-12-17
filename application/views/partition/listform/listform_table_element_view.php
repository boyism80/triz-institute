<tr class="table-item">
	<td><?php echo $board['idx']; ?></td>
	<td class="no-align">
		<a href="?mode=read&index=<?php echo $board['idx']; ?>" style="<?php if($board['fix'] === true) echo 'font-weight: bold;'; ?>">
			<?php 
				echo $board['title']; 
				if($board['comments'] > 0)
					echo ' [' . $board['comments'] . ']';
			?>
		</a>
		<?php
			if($board['new'] === true)
				$this->load->view('partition/listform/listform_new_icon_view');
		?>
	</td>
	<td><?php if($board['files'] === true) $this->load->view('partition/listform/listform_disk_icon'); ?></td>
	<td><?php echo $board['uname']; ?></td>
	<td><?php echo $board['date']; ?></td>
	<td><?php echo $board['hit']; ?></td>
</tr>