<?php App::uses('Debugger', 'Utility'); ?>
<?php echo $this->Element('contest', array('mode' => 'problem', 'contest_id' => $contest['Contest']['id'])); ?>
<?php if($contest['Contest']['user_id'] == $userid && $contest['Contest']['public'] == 0): ?>
<div class="append">
	<i class="icon-plus-sign"></i>
	<?php echo $this->Html->link('Add new problem', '/problems/create/'.$contest['Contest']['id']); ?>
</div>
<?php endif; ?>
<h1>Problems of <?php echo h($contest['Contest']['name']); ?></h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Problem ID</th>
			<th>Problem Name</th>
			<th>CPU Limit</th>
			<th>Memory Limit</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($contest['Problem'] as $problem): ?>
		<tr>
			<td><?php echo h($problem['id']); ?></td>
			<td><?php echo $this->Html->link($problem['name'], '/problems/view/'.$problem['id'].'/'.$contest['Contest']['id']); ?></td>
			<td><?php echo h($problem['cpu']); ?> sec</td>
			<td><?php echo h($problem['memory']); ?> MB</td>
			<?php if($problem['user_id'] == $userid): ?>
			<td><?php echo $this->Html->link('Setting =>', '/problems/setting/'.$problem['id'].'/'.$contest['Contest']['id']); ?></td>
			<td><?php echo $this->Html->link('Delete =>', '/problems/delete/'.$problem['id'].'/'.$contest['Contest']['id']); ?></td>
			<?php else: ?>
			<td></td>
			<td></td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
