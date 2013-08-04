<?php App::uses('Debugger', 'Utility'); ?>
<h1>Contests</h1>
<?php if($admin): ?>
<div class="append">
	<i class="icon-plus-sign"></i>
	<?php echo $this->Html->link('Add new contest', 'create'); ?>
</div>
<?php endif; ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Contest ID</th>
			<th>Contest Name</th>
			<th>Start</th>
			<th>End</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($contests as $contest): ?>
		<tr>
			<td><?php echo h($contest['Contest']['id']); ?></td>
			<td><?php echo h($contest['Contest']['name']); ?></td>
			<td><?php echo h($contest['Contest']['start']); ?></td>
			<td><?php echo h($contest['Contest']['end']); ?></td>
			<?php if($contest['Contest']['user_id'] == $userid || $admin): ?>
			<td><?php echo $this->Html->link('Setting =>', 'setting/'.$contest['Contest']['id']); ?></td>
			<?php if(strtotime($contest['Contest']['start']) > time()): ?>
			<td><?php echo $this->Html->link('Set Problems =>', 'problem/'.$contest['Contest']['id']); ?></td>
			<?php else: ?>
			<td><?php echo $this->Html->link('Enter =>', 'problem/'.$contest['Contest']['id']); ?></td>
			<?php endif; ?>
			<?php elseif(strtotime($contest['Contest']['start']) > time()): ?>
			<td><?php echo $this->Html->link('Register =>', 'register/'.$contest['Contest']['id']); ?></td>
			<td></td>
			<?php else: ?>
			<td><?php echo $this->Html->link('Enter =>', 'problem/'.$contest['Contest']['id']); ?></td>
			<td></td>
			<?php endif; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
