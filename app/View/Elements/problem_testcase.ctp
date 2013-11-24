<div class="testcases">
	<label>Testcases</label>
	<div class="append">
		<i class="icon-plus-sign"></i>
		<?php echo $this->Html->link('Add Testcase', '/testcases/add/'.$problem['Problem']['id']); ?>
	</div>
	<table>
		<thead>
			<th>Number</th>
			<th>Length</th>
			<th></th>
			<th></th>
		</thead>
		<tbody>
			<?php for($i = 0; $i < count($testcases); $i++): ?>
			<tr>
				<td><?php echo h($i + 1); ?></td>
				<td><?php echo h($testcases[$i]['Testcase']['length']); ?> B</td>
				<td><?php echo $this->Html->link('Edit =>', '/testcases/edit/'.$i.'/'.$testcases[$i]['Testcase']['id']); ?></td>
				<td><?php echo $this->Html->link('Delete =>', '/testcases/delete/'.$i.'/'.$testcases[$i]['Testcase']['id']); ?></td>
			</tr>
			<?php endfor; ?>
		</tbody>
	</table>
</div>
<?php echo $this->Form->create('Problem'); ?>
<div class="submit submit-button">
<?php
	echo $this->Form->input('id', array('type' => 'hidden', 'value' => $problem['Problem']['id']));
	echo $this->Form->submit('Submit', array('div' => false));
	echo $this->Html->link('Back', '/problems/setting/'.$problem['Problem']['id'].'/sample/'.$contest_id, array('class' => 'btn btn-large'));
?>
</div>
